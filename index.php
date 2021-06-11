<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Procura - Busca de Palavras no Google</title>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" type="image/x-icon" href="images/favicon.png" />
</head>
<body>
	<img src="images/logo.png" alt="Procura" class="logo">
	<div class="container form">
		<form method="post" action="searchWord.php">
			<input type="text" name="website" placeholder="Endereço do Site" autocomplete="off" required>
			<input type="text" name="siteName" placeholder="Nome do Site" autocomplete="off" required>
			<textarea name="palavras" cols="30" placeholder="Palavras Chave" rows="10"></textarea>
			<button type="submit">Enviar</button>
		</form>
	</div>
</body>
</html>

<?php
	$fileVersionControl = 'version.txt';
	$versionControl = fopen($fileVersionControl, 'r+');
	$actualVersion = fread($versionControl, filesize($fileVersionControl));

	$githubProjectCommits = "https://api.github.com/repos/wueliton/procura/commits?page=1&per_page=1";
	$ch = curl_init($githubProjectCommits);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded; charset=utf-8','User-Agent: https://github.com/wueliton']);
	$content = curl_exec($ch);
	curl_close($ch);

	$commitData = json_decode($content, true);
	$time = $commitData[0]['commit']['author']['date'];
	$date = date_format(date_create($time),'Y-m-d h:i:s');

	if($date !== $actualVersion) {
		$urlFile = "https://raw.githubusercontent.com/wueliton/procura/master/classes/googleapi.Class.php";
		$ch = curl_init($urlFile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($ch);
		if(curl_errno($ch)) {
			echo('Erro ao tentar atualizar arquivo.');
		} else {
			$localFile = 'classes/googleapi.Class.php';
			$fileContent = fopen($localFile, 'w');
			$versionControl = fopen($fileVersionControl, 'w');
			fwrite($fileContent, $content);
			fwrite($versionControl, $date);
		}
		curl_close($ch);
		fclose($fileContent);
	}
	
	fclose($versionControl);
?>