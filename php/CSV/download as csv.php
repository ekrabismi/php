<?php
$yourfile = 'test.txt';
header ("Content-Type: application/download");
header ("Content-Disposition: attachment; filename=$yourfile");
header("Content-Length: 1024");
echo 'a, b, c, d' . "\r\n";
echo '1, 2, 3, 4';
?>