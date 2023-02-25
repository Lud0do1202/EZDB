<?php

require_once "MY_DB.php";
require_once "EZDB.php";

$ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

$ezdb->insertInto("test");
$ezdb->delete(MY_DB::USERS);

/* ********************************** */
/* Users */
// User 1
$ezdb->insertInto(MY_DB::USERS, [
    new Param(MY_DB::USERS_ID, 1),
    new Param(MY_DB::USERS_USERNAME, "AAA"),
    new Param(MY_DB::USERS_PASSWORD, "111")
]);

// User 2
$ezdb->insertInto(MY_DB::USERS, [
    new Param(MY_DB::USERS_ID, 2),
    new Param(MY_DB::USERS_USERNAME, "BBB"),
    new Param(MY_DB::USERS_PASSWORD, "222")
]);

// User 3
$ezdb->insertInto(MY_DB::USERS, [
    new Param(MY_DB::USERS_ID, 3),
    new Param(MY_DB::USERS_USERNAME, "CCC"),
    new Param(MY_DB::USERS_PASSWORD, "333")
]);

/* ********************************** */
/* Select */
echo "<pre>";
print_r($ezdb->select(MY_DB::USERS));
echo "</pre>";

echo "<pre>";
print_r($ezdb->select(MY_DB::USERS, [MY_DB::USERS_USERNAME, MY_DB::USERS_PASSWORD]));
echo "</pre>";

echo "<pre>";
print_r($ezdb->select(MY_DB::USERS, [MY_DB::USERS_USERNAME, MY_DB::USERS_PASSWORD], [
    new Where(new Param(MY_DB::USERS_ID, 2), "<=")
]));
echo "</pre>";

/* ********************************** */
/* Delete */
// Fake User 3
$ezdb->delete(MY_DB::USERS, [
    new Where(new Param(MY_DB::USERS_ID, 10), ">"),
    new Where(new Param(MY_DB::USERS_USERNAME, "CCC"), "=")
]);

// User 2
$ezdb->delete(MY_DB::USERS, [
    new Where(new Param(MY_DB::USERS_ID, 10), "<"),
    new Where(new Param(MY_DB::USERS_USERNAME, "BBB"), "=")
]);
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