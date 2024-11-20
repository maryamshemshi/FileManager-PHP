<?php 
$filePath=$_REQUEST['name'];
$fileHandler = fopen($filePath,'r');
while(!feof($fileHandler)){
$line = fgets($fileHandler);
echo "$line" . "<br>";
}

?>