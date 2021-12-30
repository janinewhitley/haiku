<?php

if(isset($_POST["logout"])) {
    session_destroy();
    header("location: login.php");
}

?>

<body>
<header class="header">
    <nav class="nav">
        <div class="logo"><h1><a href="home.php">Haiku</a></h1></div>
        <ul class="menu">
            <li class = "menu-item profile">
                <a href="profile.php"><span class="material-icons">person_outline</span></a>
                <ul class="logout">
                    <li>
                        <a href="settings.php"><input class="logout-button" value="Settings"></a>
                    </li>
                    <li>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <a><input type="submit" name="logout" value="Logout" class="logout-button"></a>
                        </form>
                    </li>
                </ul>
            </li>
            <li class = "menu-item"><a href="feed.php"><span class="material-icons material-icons-outlined">feed</span></a></li>
            <li class = "menu-item">
                <a href="search.php"><span class="material-icons">search</span></a>
            </li>
        </ul>
    </nav>
</header>
