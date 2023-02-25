<?php

require_once "MY_DB.php";
require_once "EZDB.php";

$ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

$ezdb->delete(MY_DB::USERS);

/* ********************************** */
/* Users */
$ezdb->insertInto(MY_DB::USERS, [
    new ColumnValue(MY_DB::USERS_ID, 1),
    new ColumnValue(MY_DB::USERS_USERNAME, "AAA"),
    new ColumnValue(MY_DB::USERS_PASSWORD, "111")
]);

$ezdb->insertInto(MY_DB::USERS, [
    new ColumnValue(MY_DB::USERS_ID, 2),
    new ColumnValue(MY_DB::USERS_USERNAME, "BBB"),
    new ColumnValue(MY_DB::USERS_PASSWORD, "222")
]);

$ezdb->insertInto(MY_DB::USERS, [
    new ColumnValue(MY_DB::USERS_ID, 3),
    new ColumnValue(MY_DB::USERS_USERNAME, "CCC"),
    new ColumnValue(MY_DB::USERS_PASSWORD, "333")
]);

/* ********************************** */
/* Update */
$ezdb->update(MY_DB::USERS, [new ColumnValue(MY_DB::USERS_PASSWORD, "222")], [new Where(new ColumnValue(MY_DB::USERS_ID, "3"), "=")]);

/* ********************************** */
/* Select */
echo "<pre>";
print_r($ezdb->select(MY_DB::USERS));
echo "</pre>";

echo "<pre>";
print_r($ezdb->select(MY_DB::USERS, "*", [], [new OrderBy(MY_DB::USERS_PASSWORD, false), new OrderBy(MY_DB::USERS_USERNAME, false)]));
echo "</pre>";

echo "<pre>";
print_r($ezdb->select(MY_DB::USERS, [MY_DB::USERS_USERNAME, MY_DB::USERS_PASSWORD]));
echo "</pre>";

echo "<pre>";
print_r($ezdb->select(MY_DB::USERS, [MY_DB::USERS_USERNAME, MY_DB::USERS_PASSWORD], [
    new Where(new ColumnValue(MY_DB::USERS_ID, 2), "<=")
]));
echo "</pre>";

/* ********************************** */
/* Delete */
$ezdb->delete(MY_DB::USERS, [
    new Where(new ColumnValue(MY_DB::USERS_ID, 10), "<"),
    new Where(new ColumnValue(MY_DB::USERS_USERNAME, "BBB"), "=")
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