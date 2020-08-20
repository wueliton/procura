<?php 
$site = $_POST['website'];
$site = preg_replace('/[^a-z0-9]/i', '_', $site);
$data = date("d/m/Y");
$data = str_replace("/",".",$data);
$content = $_POST['content'];
$top = "<table border='1'>";
$top.= "<tr>";
$top.= "<td colspan='3'>";
$top.= "<h1>$site</h1>";
$top.= "</td>";
$top.= "</tr>";
$top.= "<tr>";
$top.= "<td>Palavra</td>";
$top.= "<td>Página</td>";
$top.= "<td>Posição Orgânica</td>";
$top.= "</tr>";
$content.="</table>";

$arquivo = "$site - $data - Pesquisa de Palavras.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Type: application/vnd.openxmlformats- officedocument.spreadsheetml.sheet");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
header ("Cache-Control: max-age=0");

echo utf8_decode($top).utf8_decode($content);
exit;

 ?>