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