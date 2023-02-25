<?php
require "EZDB.php";
$ezdb = new EZDB();

$client = [
    "idClient",
    "nomClient",
    "prenomClient",
    "telClient",
    "idAdresse"
];

$adresse = [
    "idAdresse",
    "codePostalAdresse",
    "localiteAdresse",
    "rueAdresse",
    "numeroAdresse"
];

$asbl = [
    "numeroTvaAsbl",
    "nomAsbl",
    "logoAsbl",
    "emailAsbl",
    "telAsbl",
    "idAdresse"
];

$ezdb->addTable("Client", $client);
$ezdb->addTable("Adresse", $adresse);
$ezdb->addTable("Asbl", $asbl);
$ezdb->addTable("Empty");

$ezdb->createFile();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $ezdb->display() ?>
</body>
</html>