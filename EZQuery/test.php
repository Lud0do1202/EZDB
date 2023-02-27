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
    require_once "EZQuery.php";

    $ezdb = new EZQuery("localhost", "Lud0do1202_ezdb", "root", "");

    /* Delete All User and Posts */
    $deleteAllPosts = new DeleteQuery(Mydb::POSTS);
    echo $ezdb->executeEdit($deleteAllPosts);

    $deleteAllUsers = new DeleteQuery(Mydb::USERS);
    echo $ezdb->executeEdit($deleteAllUsers);

    /* Insert Users */
    $insertUser1 = (new InsertQuery(Mydb::USERS))
        ->columns([
            new DBTuple(Mydb::USERS_ID, 1),
            new DBTuple(Mydb::USERS_USERNAME, "Ludo"),
            new DBTuple(Mydb::USERS_PASSWORD, "123")
        ]);
    echo $ezdb->executeEdit($insertUser1);

    $insertUser2 = (new InsertQuery(Mydb::USERS))
        ->columns([
            new DBTuple(Mydb::USERS_ID, 2),
            new DBTuple(Mydb::USERS_USERNAME, "AAA"),
            new DBTuple(Mydb::USERS_PASSWORD, "Azerty")
        ]);
    echo $ezdb->executeEdit($insertUser2);

    /* Insert Posts */
    $insertPost1 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 1),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 1"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 1"),
            new DBTuple(Mydb::POSTS_USER_ID, 1),
        ]);
    echo $ezdb->executeEdit($insertPost1);

    $insertPost2 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 2),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 2"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 2"),
            new DBTuple(Mydb::POSTS_USER_ID, 2),
        ]);
    echo $ezdb->executeEdit($insertPost2);

    $insertPost3 = (new InsertQuery(Mydb::POSTS))
        ->columns([
            new DBTuple(Mydb::POSTS_ID, 3),
            new DBTuple(Mydb::POSTS_TITLE, "Post Title 3"),
            new DBTuple(Mydb::POSTS_CONTENT, "Post Content 3"),
            new DBTuple(Mydb::POSTS_USER_ID, 1),
        ]);
    echo $ezdb->executeEdit($insertPost3);

    /* Select */
    $select1 = new SelectQuery(Mydb::USERS);
    echo "<pre>";
    print_r($ezdb->executeSelect($select1));
    echo "</pre>";

    $select2 = new SelectQuery(Mydb::POSTS);
    echo "<pre>";
    print_r($ezdb->executeSelect($select2));
    echo "</pre>";

    $select3 = (new SelectQuery([Mydb::USERS, Mydb::POSTS]))
        ->distinct()
        ->columns(Mydb::USERS_USERNAME)
        ->where(new Where(Mydb::USERS_ID, "=", Mydb::POSTS_USER_ID, false))
        ->orderBy(new OrderBy(Mydb::USERS_USERNAME, false));
    echo "<pre>";
    print_r($ezdb->executeSelect($select3));
    echo "</pre>";

    /* Delete One Post */
    $deletePost1 = (new DeleteQuery(Mydb::POSTS))
        ->where(new Where(Mydb::POSTS_ID, "=", 1));
    echo $ezdb->executeEdit($deletePost1);

    echo "<pre>";
    print_r($ezdb->executeSelect($select2));
    echo "</pre>";

    /* Update One User */
    $UpdateUser1 = (new UpdateQuery(Mydb::USERS, [
        new DBTuple(Mydb::USERS_USERNAME, "$$$"),
        new DBTuple(Mydb::USERS_PASSWORD, "???")
    ]))->where(new Where(Mydb::USERS_ID, "=", 1));
    echo $ezdb->executeEdit($UpdateUser1);

    echo "<pre>";
    print_r($ezdb->executeSelect($select1));
    echo "</pre>";
    ?>

</body>

</html>