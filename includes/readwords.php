<?php 

set_time_limit(0);
include("../classes/googleapi.Class.php");

$keyword = $_POST['keyword'];
$clientSite = $_POST['clientSite'];
$website = $_POST['website'];
$id = $_POST['i'];

$test = new GoogleAPI;
$test->search($keyword,$website,$clientSite,$id);
?>