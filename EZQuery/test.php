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
    require "./Query/IQuery.php";
    require "./Query/SelectQuery.php";
    require "./Query/InsertQuery.php";
    require "./Query/DeleteQuery.php";

    // SELECT
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

    // INSERT
    echo "<br>************************<br>";
    echo $insert1 = (new InsertQuery(Mydb::USERS));
    echo "<br>";
    print_r($insert1->getParams());
    
    echo "<br>";
    echo $insert2 = (new InsertQuery(Mydb::USERS))->values(0, "111", "222");
    echo "<br>";
    print_r($insert2->getParams());
    
    echo "<br>";
    echo $insert3 = (new InsertQuery(Mydb::USERS))->values(1, "aaa", "bbb")->columns(Mydb::USERS_ID, Mydb::USERS_USERNAME, Mydb::USERS_PASSWORD);
    echo "<br>";
    print_r($insert3->getParams());
    
    echo "<br>************************<br>";
    echo $delete1 = (new DeleteQuery(Mydb::USERS));
    echo "<br>";
    print_r($delete1->getParams());
    
    echo "<br>";
    echo $delete2 = (new DeleteQuery(Mydb::USERS))->where("% BETWEEN ? AND ?", Mydb::USERS_ID, 1, 10);
    echo "<br>";
    print_r($delete2->getParams());
    ?>

</body>

</html>