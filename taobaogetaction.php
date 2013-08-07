<?php
$url = $_POST['sendUrl'];
$html = file_get_contents($url);
echo $html;
?>