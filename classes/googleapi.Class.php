<?php 

class GoogleAPI {
	function __construct() {
		session_start();
	}

	function getContent($url,$ip,$agent) {
		set_time_limit(0);
		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Language: pt-br,pt;q=0.5";
		$header[] = "Pragma: ";
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
			CURLOPT_CUSTOMREQUEST  	=> "GET",
			CURLOPT_POST           	=> false,
			CURLOPT_COOKIEFILE     	=>"cookie.txt",
			CURLOPT_COOKIEJAR      	=>"cookie.txt",
			CURLOPT_USERAGENT 		=> $agent,
			CURLOPT_URL 			=> $url,
			CURLOPT_HEADER 			=> false,
			CURLOPT_FOLLOWLOCATION 	=> true,
			CURLOPT_ENCODING 		=> 'UTF-8',
			CURLOPT_VERBOSE 		=> true,
			CURLOPT_AUTOREFERER    	=> true,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_CONNECTTIMEOUT 	=> 120,
			CURLOPT_HTTPHEADER 		=> array("X-Forwarded-For: $ip"),
			CURLOPT_TIMEOUT 		=> '10'
		));
		$content = curl_exec($ch);
		$content = html_entity_decode($content, ENT_QUOTES, "utf-8");
		curl_close($ch);

		return $content;
	}

	function search($search,$urlSite,$clientSite,$id,$position=0) {
		set_time_limit(0);
		$clientSite = $this->sanitizeString($clientSite);
		$clientSite = strtolower($clientSite);
		$clientSite = trim($clientSite);

		$array = "";
		$actual_page = $position+1;
		if($position<4) {
			$searchTerm = preg_replace("@ @", "+", $search);
			$searchTerm = preg_replace("@,@", "%2C", $searchTerm);
			$searchTerm = preg_replace("@'@", "%27", $searchTerm);

			$ip[] = "201.27.103.39";

			$page = $position*10;

			$url[] = "https://www.google.com/search?sxsrf=ACYBGNThUVDMN6GGrAHTGeNIvo5YAogRFw%3A1570555101579&ei=3cScXa6EI5e15OUP7uCy2AU&q=$searchTerm&oq=$searchTerm&gs_l=psy-ab.3..35i39i19j0i67l2j0j0i67l3j0l3.9736.10919..11072...1.2..3.114.729.2j5....1..0....1..gws-wiz.....10..0i71j35i39j0i131i67j0i131j35i362i39.uDquHcOGPHg&ved=0ahUKEwju5rfXlY3lAhWXGrkGHW6wDFsQ4dUDCAs&uact=5&start=$page";
			$url[] = "http://www.google.com/search?hl=pt&tbo=d&site=&source=hp&q=$searchTerm&start=$page";
			$url[] = "https://www.google.com/search?q=$searchTerm&oq=$searchTerm&aqs=chrome.0.69i59.1775j0j1&sourceid=chrome&ie=UTF-8&start=$page";
			$url[] = "https://www.google.com/search?q=$searchTerm&aqs=chrome.0.69i59.1775j0j1&sourceid=chrome&ie=UTF-8&start=$page";
			$url[] = "https://www.google.com/search?q=$searchTerm&oq=$searchTerm&aqs=chrome..69i57.551j0j1&sourceid=chrome&ie=UTF-8&start=$page";
			$url[] = "https://www.google.com/search?q=$searchTerm&aqs=chrome..69i57.551j0j1&sourceid=chrome&ie=UTF-8&start=$page";

			$agents = array(
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3694.0 Safari/537.36 Chrome-Lighthouse'
			);

			$agent = $agents[array_rand($agents)];

			$thisURL = array_rand($url, 1);
			$url1 = $url[$thisURL];
			$thisURL = array_rand($url, 1);
			$url2 = $url[$thisURL];

			$thisip = array_rand($ip, 1);
			$ip = $ip[$thisip];

			$content = $this->getContent($url1,$ip,$agent);

			$content2 = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
			$content2 = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $content2);
			preg_match_all('/<div class="rc" data-hveid="\b[^>]*>(.*?)<\/div>/is', $content2, $conteudo);
			$urlSite = $urlSite;
			$array = preg_grep("/\b$urlSite\b/i",$conteudo[0]);
			$search = str_replace("'","&lsquo;",$search);

			if(!empty($array)) {
				$first = $position=0 ? key($array) : "Página: ".($position+1).", Posição Orgânica: ".(key($array)+1);
				$page_google = $actual_page;
				$position_page = key($array)+1;
				echo "<li>$id - ".$search." => ".$first."</li>";
				echo "<script>$('#excel').val($('#excel').val() + '<tr><td><a href=$url1 >$search</a></td><td>$page_google</td><td>$position_page</td></tr>');</script>";

				if(!is_dir("../searchs/$clientSite")) {
					mkdir("../searchs/$clientSite", 0777, true);
				}

				ob_start();
				$searchName = $this->sanitizeString($search);
				$contentFile = str_replace('src="','src="https://www.google.com',$content);
				$contentFile = str_replace('style="background:url(/images','style="background:url(https://www.google.com/images',$contentFile);
				file_put_contents("../searchs/$clientSite/".$id."_".$searchName.".html", $contentFile);
			}
			else {
				preg_match('/g-recaptcha/i',$content2,$array1);
				if(!empty($array1)) {
					echo "captcha";
				}
				else {
					sleep(40);
					$position++;
					$this->search($search,$urlSite,$clientSite,$id,$position);
				}
			}
		}
		else {
			echo "<li class='unsearch'>$id - $search => Não encontrada</li>";
			echo "<script>$('#excel').val($('#excel').val() + '<tr><td>$search</td><td>Não encontrada</td><td></td></tr>');</script>";
		}
	}

	function sanitizeString($str) {
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		$str = preg_replace('/[^a-z0-9]/i', '_', $str);
		$str = preg_replace('/_+/', '_', $str);
		$str = strtolower($str);
		return $str;
	}
}
?>