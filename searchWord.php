<?php set_time_limit(0); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title><?=$_POST['siteName'];?> | Procura | Busca de Palavras no Google</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="images/favicon.png" />
</head>
<body>
	<div class="menu"><a href="index.php">Voltar</a></div>
	<img src="images/logo.png" alt="Procura" class="logo">
	<div class="container">
		<div class="loading"><span></span></div>
		<h1 class="loading_text" id="loading_text">Carregando...</h1>
		<span class="sitename"><?=$_POST['siteName'];?></span>
		<span class="status"></span>
	</div>
	<ul class="itens">
		
	</ul>
	<form action="includes/gerarplanilha.php" id="form_excel" method="post">
		<textarea id="excel" name="content" hidden>

		</textarea>
		<input type="text" name="website" value="<?=$_POST['siteName']?>" hidden>
	</form>
	<script>
		$(window).on('beforeunload',function(){
	      return '';
	    });

		var arr = new Array();
		<?php
		if(isset($_POST['palavras'])) {
			$palavras = nl2br($_POST['palavras']);
			$palavras = explode("<br />",$palavras);
			$palavras = array_map('trim', $palavras);

			$i = 0;
			foreach($palavras as $key => $value) {
				$value = str_replace("'","\'",$value);
				printf("\narr[$i] = '$value';", $key, $value);
				$i++;
			}

		} ?>
		<?php 
		$site = $_POST['website'];
		$site = preg_replace("/^http:/i", "", $site);
		$site = preg_replace("/^https:/i", "", $site);
		$site = str_replace("/", "", $site);
		$site = preg_replace('/^www\./', '', $site);
		?>
		clientSite = "<?=$_POST['siteName']?>";
		website = "<?=$site?>";
	</script>
	<script type="text/javascript" src="js/script.php"></script>
</body>
</html>