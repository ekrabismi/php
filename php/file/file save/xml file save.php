<?php
$html = "<html><head>test</head></html>";   

$fileName="export.xml";
header('Content-type: application/ms-excel');
header("Content-Disposition: attachment; filename=$fileName");

$fp = fopen("php://output", "w");
 echo $html;
fclose($fp);
?>