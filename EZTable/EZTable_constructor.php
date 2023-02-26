<?php
require "EZTable.php";
$ezTable = new EZTable("Mydb");

$users = [
    "id",
    "username",
    "password",
    "created_at"
];

$posts = [
    "id",
    "title",
    "content",
    "user_id",
    "created_at"
];

$comments = [
    "id",
    "content",
    "post_id",
    "user_id",
    "created_at"
];

$ezTable->addTable("users", $users);
$ezTable->addTable("posts", $posts);
$ezTable->addTable("comments", $comments);
$ezTable->addTable("NoColumn");

$ezTable->createFile();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZTable</title>
</head>
<body>
    <?= $ezTable->display() ?>
</body>
</html>