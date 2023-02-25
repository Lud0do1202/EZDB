<?php

require_once "MY_DB.php";
require_once "EZDB.php";

$ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

$ezdb->delete(MY_DB::POSTS);
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



/* Post */
$ezdb->insertInto(MY_DB::POSTS, [
    new ColumnValue(MY_DB::POSTS_ID, 1),
    new ColumnValue(MY_DB::POSTS_TITLE, "First Posts"),
    new ColumnValue(MY_DB::POSTS_CONTENT, "Content First Posts"),
    new ColumnValue(MY_DB::POSTS_USER_ID, 1)
]);

$ezdb->insertInto(MY_DB::POSTS, [
    new ColumnValue(MY_DB::POSTS_ID, 2),
    new ColumnValue(MY_DB::POSTS_TITLE, "Second Posts"),
    new ColumnValue(MY_DB::POSTS_CONTENT, "Content Second Posts"),
    new ColumnValue(MY_DB::POSTS_USER_ID, 3)
]);

$ezdb->insertInto(MY_DB::POSTS, [
    new ColumnValue(MY_DB::POSTS_ID, 3),
    new ColumnValue(MY_DB::POSTS_TITLE, "Second Posts"),
    new ColumnValue(MY_DB::POSTS_CONTENT, "Content Third Posts"),
    new ColumnValue(MY_DB::POSTS_USER_ID, 1)
]);


echo "<br>**************************************";
echo "<br>**************************************";
echo "<br>**************************************";
echo "<br><br><br>";

$select = new SelectQuery([MY_DB::USERS, MY_DB::POSTS]);
$select->distinct()
    ->columns(MY_DB::USERS_USERNAME)
    ->where(new W(MY_DB::USERS_ID, "=", MY_DB::POSTS_USER_ID, false))
    ->orderBy(new OrderBy(MY_DB::USERS_USERNAME, false));

echo "<pre>";
print_r($ezdb->selectV2($select));
echo "</pre>";
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