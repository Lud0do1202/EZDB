<?php

require "MY_DB.php";
require "EZDB.php";

$ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

echo $ezdb->executeEdit('DELETE FROM ' . MY_DB::USERS);

$insertUser =
    'INSERT INTO ' . MY_DB::USERS . ' (' . MY_DB::USERS_USERNAME . ', ' . MY_DB::USERS_PASSWORD . ') 
    VALUES (:' . MY_DB::USERS_USERNAME . ', :' . MY_DB::USERS_PASSWORD . ')';

$john = [
    MY_DB::USERS_USERNAME => "john",
    MY_DB::USERS_PASSWORD => "123"
];
$jane = [
    MY_DB::USERS_USERNAME => "jane",
    MY_DB::USERS_PASSWORD => "456"
];

$ezdb->executeEdit($insertUser, $john);
$ezdb->executeEdit($insertUser, $jane);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZDB</title>
</head>

<body>

</body>

</html>