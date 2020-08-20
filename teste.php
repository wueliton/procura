<?php 
	include("classes/crud.Class.php");

	$sql = new crud();
	$sql->insert("empresa",array("nome","website"),array("SmartFire","smartfire.com.br"));


	$dados="<tr><td><a href=https://www.google.com/search?sxsrf=ACYBGNThUVDMN6GGrAHTGeNIvo5YAogRFw%3A1570555101579&ei=3cScXa6EI5e15OUP7uCy2AU&q=Instalação+de+Notifier&oq=Instalação+de+Notifier&gs_l=psy-ab.3..35i39i19j0i67l2j0j0i67l3j0l3.9736.10919..11072...1.2..3.114.729.2j5....1..0....1..gws-wiz.....10..0i71j35i39j0i131i67j0i131j35i362i39.uDquHcOGPHg&ved=0ahUKEwju5rfXlY3lAhWXGrkGHW6wDFsQ4dUDCAs&uact=5&start=0 >Instalação de Notifier</a></td><td>1</td><td>6</td></tr><tr><td><a href=http://www.google.com/search?hl=pt&tbo=d&site=&source=hp&q=Instalação+PROTECTOWIRE&start=0 >Instalação PROTECTOWIRE</a></td><td>1</td><td>1</td></tr><tr><td><a href=https://www.google.com/search?q=Instalação+Simplex&oq=Instalação+Simplex&aqs=chrome.0.69i59.1775j0j1&sourceid=chrome&ie=UTF-8&start=0 >Instalação Simplex</a></td><td>1</td><td>1</td></tr><tr><td>Instalação Sistema alarme incêndio</td><td>Não encontrada</td><td></td></tr><tr><td>Instalação sistema de combate a incêndio</td><td>Não encontrada</td><td></td></tr><tr><td><a href=https://www.google.com/search?sxsrf=ACYBGNThUVDMN6GGrAHTGeNIvo5YAogRFw%3A1570555101579&ei=3cScXa6EI5e15OUP7uCy2AU&q=Instalação+sistema+de+supressão+CO2&oq=Instalação+sistema+de+supressão+CO2&gs_l=psy-ab.3..35i39i19j0i67l2j0j0i67l3j0l3.9736.10919..11072...1.2..3.114.729.2j5....1..0....1..gws-wiz.....10..0i71j35i39j0i131i67j0i131j35i362i39.uDquHcOGPHg&ved=0ahUKEwju5rfXlY3lAhWXGrkGHW6wDFsQ4dUDCAs&uact=5&start=0 >Instalação sistema de supressão CO2</a></td><td>1</td><td>1</td></tr><tr><td><a href=https://www.google.com/search?q=Janus+Manutenção&aqs=chrome..69i57.551j0j1&sourceid=chrome&ie=UTF-8&start=0 >Janus Manutenção</a></td><td>1</td><td>2</td></tr><tr><td>Manutenção Eaton</td><td>Não encontrada</td><td></td></tr><tr><td><a href=https://www.google.com/search?q=Manutenção+Esser&oq=Manutenção+Esser&aqs=chrome..69i57.551j0j1&sourceid=chrome&ie=UTF-8&start=0 >Manutenção Esser</a></td><td>1</td><td>1</td></tr><tr><td><a href=https://www.google.com/search?q=Manutenção+Morley&oq=Manutenção+Morley&aqs=chrome..69i57.551j0j1&sourceid=chrome&ie=UTF-8&start=0 >Manutenção Morley</a></td><td>1</td><td>1</td></tr>";

	$dados = explode("tr>",$dados);

	$step = 0;

	foreach($dados as $key=>$item) {
		preg_match_all('/<a href=\b[^>]*>(.*?)>/is', $item, $result);

		foreach(explode('td>',$item) as $value) {
			$value = strip_tags($value);
			if(trim($value)!="") {
				$out[$key][$step++] = strip_tags($value);
			}
		}

		if(count($result[0])>0) {
			$out[$key][$step++] = $result[0][0];
		}

		$step = 0;
	}

	$out = array_values($out);
	echo "<pre>";
	print_r($out);
	echo "</pre>";

	$id = 1;

	$sql->insert("busca",array("empresa_id"),array($id));
		$idBusca = $sql->query("SELECT id FROM busca WHERE $id ORDER BY data_atual ASC LIMIT 1");
	$idBusca = $idBusca[0]["id"];

	foreach($out as $item) {
		$palavra = $item[0];
		$pagina = $item[1];
		$posicao = $pagina!="Não encontrada" ? $item[2] : 0;
		$link = $pagina!="Não encontrada" ? $item[3] : "";

		$sql->insert("posicionamento",array("link","busca_id","palavra","pagina","posicao","empresa"),array($link,$idBusca,$palavra,$pagina,$posicao,$id));

		echo $link."<br/>".$idBusca."<br/>".$palavra."<br/>".$pagina."<br/>".$posicao."<br/>".$id;
	}
	
?>