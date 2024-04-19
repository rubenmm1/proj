<?php
//echo getcwd() . "\n";

$db =getcwd().'/php.accdb';
if(!file_exists($db))
{
  die ("No se ha encontrado el fichero");
}
$db = new PDO ("odbc:DRIVER={Microsoft Access Driver {*.accdb}}; DBQ=$db; Uid=; Pwd=;");

$sql = "select * from usuarios";
$result= $db->query($sql);
echo "<pre>";
print_r($result->fetchAll());

?>
