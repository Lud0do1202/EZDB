<?php

require_once "MY_DB.php";
require_once "EZDB.php";

$ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

echo $ezdb->insertInto("test");

/* Users */
/* Insert into */
$params = [
    new Param(MY_DB::USERS_ID, 1),
    new Param(MY_DB::USERS_USERNAME, "AAA"),
    new Param(MY_DB::USERS_PASSWORD, "111")
];
echo $ezdb->insertInto(MY_DB::USERS, $params);

$params = [
    new Param(MY_DB::USERS_ID, 2),
    new Param(MY_DB::USERS_USERNAME, "BBB"),
    new Param(MY_DB::USERS_PASSWORD, "222")
];
echo $ezdb->insertInto(MY_DB::USERS, $params);

$params = [
    new Param(MY_DB::USERS_ID, 3),
    new Param(MY_DB::USERS_USERNAME, "CCC"),
    new Param(MY_DB::USERS_PASSWORD, "333")
];
echo $ezdb->insertInto(MY_DB::USERS, $params);

/* Delete */
$wheres = [
    new Where(new Param(MY_DB::USERS_ID, 10), ">"),
    new Where(new Param(MY_DB::USERS_USERNAME, "CCC"), "=")
];
echo $ezdb->delete(MY_DB::USERS, $wheres);

$wheres = [
    new Where(new Param(MY_DB::USERS_ID, 10), "<"),
    new Where(new Param(MY_DB::USERS_USERNAME, "BBB"), "=")
];
echo $ezdb->delete(MY_DB::USERS, $wheres);

echo $ezdb->delete(MY_DB::USERS);
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