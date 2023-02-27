<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test EZDB</title>
</head>

<body>

    <?php
    // Require
    require_once "../EZTable/Mydb.php";
    require_once "./EZQuery.php";

    // DB Connection
    $ezq = new EZQuery("localhost", "Lud0do1202_ezdb", "root", "");

    // Delete All users
    echo "<br>************************<br>";
    echo $ezq->executeEdit(new DeleteQuery(Mydb::USERS), true);

    // Insert Users
    echo "<br>************************<br>";
    echo $ezq->executeEdit((new InsertQuery(Mydb::USERS))->columns(Mydb::USERS_ID, Mydb::USERS_USERNAME, Mydb::USERS_PASSWORD)->values(1, "aaa", "111"), true);
    echo $ezq->executeEdit((new InsertQuery(Mydb::USERS))->columns(Mydb::USERS_ID, Mydb::USERS_USERNAME, Mydb::USERS_PASSWORD)->values(2, "bbb", "222"), true);
    echo $ezq->executeEdit((new InsertQuery(Mydb::USERS))->columns(Mydb::USERS_ID, Mydb::USERS_USERNAME, Mydb::USERS_PASSWORD)->values(3, "ccc", "333"), true);

    // Update user
    echo "<br>************************<br>";
    echo $ezq->executeEdit((new UpdateQuery(Mydb::USERS, [Mydb::USERS_USERNAME, "zzz"]))->where("% = ?", Mydb::USERS_ID, 1), true);

    // SELECT
    echo "<br>************************<br>";
    echo "<pre>";
    print_r($ezq->executeSelect(new SelectQuery(Mydb::USERS), true));
    echo "</pre>";
    ?>

</body>

</html>