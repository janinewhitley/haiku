<?php

    session_start();

    include('config.php');
    
    $haikus = [];

    if(isset($_POST['search'])) {

        $result = htmlspecialchars($_POST['searchfield']);
        
        $search = "%$result%";
        
        $sql = "SELECT * FROM haikus WHERE 
                title LIKE :search 
                OR first_line LIKE :search 
                OR second_line LIKE :search 
                OR third_line LIKE :search";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => $search]);
        $haikus = $stmt->fetchAll();
        
        if(isset($_POST['like'])) {
            if(isset($_SESSION['userid'])) {
                $userID = $_SESSION['userid'];
                include('like.php');
            } else {
                header('location: login.php');
            }
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <script src="script.js" defer></script>
</head>
    <?php require 'header.php' ?>
    <main>
        <br>
        <h1>Search Haikus:</h1>
        <br>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="search" class="searchfield" id="searchfield" name="searchfield" placeholder="sad, happy, goofy, satire, etc...">
            <button type="submit" name="search" class="search-button">🔎︎</button>
        </form>
        <br>
        <section class="haikus">
        <ul>
            <?php foreach($haikus as $haiku) { ?> 
                <li>
                    <article>
                        <br>
                        <h3><?php echo htmlspecialchars($haiku->title); ?></h3>
                        <br>
                        <p><?php  echo htmlspecialchars($haiku->first_line); ?></p>
                        <p><?php  echo htmlspecialchars($haiku->second_line); ?></p>
                        <p><?php  echo htmlspecialchars($haiku->third_line); ?></p>
                        <br>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <input type="hidden" name="haikuid" value="<?php echo $haiku->haiku_id ?>">
                            <input type="hidden" name="userid" value="<?php echo $userID ?>">
                            <input type="hidden" name="authorid" value="<?php echo $haiku->user_id ?>">
                            <input class="heart" value=&#9825; name="like" type="submit">
                        </form>
                    </article>
                </li> 
            <?php } ?>
            </ul>
        </section>
        <form action="add-haiku.php" method="POST">
            <button class="create-haiku">+</button>
        </form>
    </main>
    <?php require 'footer.php' ?>
</html>