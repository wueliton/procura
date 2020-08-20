<?php 

require("classes/crud.Class.php");

$sql = new crud();
$empresas = $sql->query("SELECT * FROM empresa");

foreach($empresas as $empresa) {
	$id = $empresa['id'];
	$month = date('m');
	$last_month = date('m')-1;

	$ultima_busca = $sql->query("SELECT id,data_atual FROM busca WHERE empresa_id=$id AND MONTH(data_atual)=$month ORDER BY data_atual ASC LIMIT 0,1");

	$penultima_busca = $sql->query("SELECT id,data_atual FROM busca WHERE empresa_id=$id AND MONTH(data_atual)=$last_month ORDER BY data_atual ASC LIMIT 0,1");

	if(count($ultima_busca)>0) {
		$busca_id = $ultima_busca[0]["id"];
		$data_busca = $ultima_busca[0]["data_atual"];

		$palavras = $sql->query("SELECT * FROM posicionamento WHERE busca_id=$busca_id");
		$grupo = _group_by($palavras,"pagina");

		$primeira_pagina = array_key_exists(1,$grupo) ? count($grupo[1]) : 0;
		$segunda_pagina = array_key_exists(2,$grupo) ? count($grupo[2]) : 0;
		$terceira_pagina = array_key_exists(3,$grupo) ? count($grupo[3]) : 0;
		$quarta_pagina = array_key_exists(4,$grupo) ? count($grupo[4]) : 0;
		$nao_localizada = array_key_exists("Não encontrada",$grupo) ? count($grupo["Não encontrada"]) : 0;
	}
}

function _group_by($array, $key) {
	$return = array();
	foreach($array as $val) {
		$return[$val[$key]][] = $val;
	}
	return $return;
}

echo "<pre>";
echo $primeira_pagina."<br/>";
echo $segunda_pagina."<br/>";
echo $terceira_pagina."<br/>";
echo $quarta_pagina."<br/>";
echo $nao_localizada."<br/>";
echo "</pre>";

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	google.charts.load('current', {'packages':['bar']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Posicionamento das Palavras', 'OUT', 'NOV'],
			['Primeira Página', <?=$primeira_pagina?>, 0],
			['Segunda Página', <?=$segunda_pagina?>, 0],
			['Terceira Página', <?=$terceira_pagina?>, 0],
			['Quarta Página', <?=$quarta_pagina?>, 0],
			['Não encontrada', <?=$nao_localizada?>, 0]
			]);

		var options = {
			chart: {
				title: 'Smartfire',
				subtitle: 'Posicionamento das Palavras chave',
			}
		};

		var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

		chart.draw(data, google.charts.Bar.convertOptions(options));
	}
</script>
<div id="columnchart_material" style="width: 800px; height: 500px;"></div>