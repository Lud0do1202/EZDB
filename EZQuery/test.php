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
    require_once "../EZTable/Mydb.php";
    require "Query/IQuery.php";
    require "Query/SelectQuery.php";
    echo (new SelectQuery(Mydb::USERS));
    echo "<br>";
    echo (new SelectQuery(Mydb::USERS))->limit(2);
    echo "<br>";
    echo $select1 = (new SelectQuery(Mydb::USERS))->where("% <= ?", Mydb::USERS_ID, 2);
    echo "<br>";
    print_r($select1->getParams());
    echo "<br>";
    echo $select2 = (new SelectQuery(Mydb::USERS))->where("% <= ?", Mydb::USERS_ID, 2)->orderBy([mydb::USERS_USERNAME, false], Mydb::USERS_PASSWORD);
    echo "<br>";
    print_r($select2->getParams());
    ?>

</body>

</html>