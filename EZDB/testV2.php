<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test EZDB V2</title>
</head>

<body>

    <?php
    require_once "../EZTable/Mydb.php";
    require_once "EZDB.php";

    $ezdb = new EZDB("localhost", "Lud0do1202_ezdb", "root", "");

    /* Delete All User and Posts */
    $deleteAllPosts = new DeleteQuery(Mydb::POSTS);
    echo $ezdb->executeEditV2($deleteAllPosts);

    $deleteAllUsers = new DeleteQuery(Mydb::USERS);
    echo $ezdb->executeEditV2($deleteAllUsers);

    /* Insert Users */
    $insertUser1 = (new InsertQuery(Mydb::USERS))
        ->columns([
            new DBTuple(Mydb::USERS_ID, 1),
            new DBTuple(Mydb::USERS_USERNAME, "Ludo"),
            new DBTuple(Mydb::USERS_PASSWORD, "123")
        ]);
    echo $ezdb->executeEditV2($insertUser1);

    $insertUser2 = (new InsertQuery(Mydb::USERS))
        ->columns([
            new DBTuple(Mydb::USERS_ID, 2),
            new DBTuple(Mydb::USERS_USERNAME, "AAA"),
            new DBTuple(Mydb::USERS_PASSWORD, "Azerty")
        ]);
    echo $ezdb->executeEditV2($insertUser2);

    /* Insert Posts */
    $insertPost1 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 1),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 1"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 1"),
            new DBTuple(Mydb::POSTS_USER_ID, 1),
        ]);
    echo $ezdb->executeEditV2($insertPost1);

    $insertPost2 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 2),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 2"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 2"),
            new DBTuple(Mydb::POSTS_USER_ID, 2),
        ]);
    echo $ezdb->executeEditV2($insertPost2);

    $insertPost3 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 3),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 3"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 3"),
            new DBTuple(Mydb::POSTS_USER_ID, 1),
        ]);
    echo $ezdb->executeEditV2($insertPost3);

    /* Select */
    $select1 = new SelectQuery(Mydb::USERS);
    echo "<pre>";
    print_r($ezdb->executeSelectV2($select1));
    echo "</pre>";

    $select2 = new SelectQuery(Mydb::POSTS);
    echo "<pre>";
    print_r($ezdb->executeSelectV2($select2));
    echo "</pre>";

    $select3 = (new SelectQuery([Mydb::USERS, Mydb::POSTS]))
        ->distinct()
        ->columns(Mydb::USERS_USERNAME)
        ->where(new W(Mydb::USERS_ID, "=", Mydb::POSTS_USER_ID, false))
        ->orderBy(new OrderBy(Mydb::USERS_USERNAME, false));
    echo "<pre>";
    print_r($ezdb->executeSelectV2($select3));
    echo "</pre>";

    /* Delete One User */
    $deleteUser1 = (new DeleteQuery(Mydb::POSTS))
        ->where(new W(Mydb::POSTS_ID, "=", 1));
    echo $ezdb->executeEditV2($deleteUser1);

    echo "<pre>";
    print_r($ezdb->executeSelectV2($select2));
    echo "</pre>";
    ?>

</body>

</html>