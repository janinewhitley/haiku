<?php

    session_start();

    include('config.php');
    if(isset($_POST['like'])) {
        include('like.php');
    }

    if(isset($_SESSION['userid'])) {
        $name = $_SESSION["name"];
        $birthday = $_SESSION["birthday"];
        $age = floor((time() - strtotime($birthday)) / 31556926);
        $username = $_SESSION["username"];
        $userID = $_SESSION["userid"];
        $bio = $_SESSION["bio"];
        // $profilepic = $_SESSION["profilepic"];
        $error = "";

        // write query for all haikus
        $stmt = $this->pdo->query('SELECT * FROM haikus ORDER BY haiku_id DESC');

        $haikus = $stmt->fetchAll();

        //write query for deleting haikus
        if(isset($_POST['delete'])) {

            $haikuid = htmlspecialchars($_POST['haikuid']);
            $sql = 'DELETE FROM haikus WHERE haiku_id = :haikuid';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid'=>$haikuid]);

        }

        //write query for unliking haikus

        if(isset($_POST['unlike'])) {

            $haikuid = htmlspecialchars($_POST['haikuid']);
            $authorid = htmlspecialchars($_POST['authorid']);
            $userId = htmlspecialchars($_POST['userid']);
            $sql = 'DELETE FROM likes WHERE haiku_id = :haikuid AND author_id = :authorid AND user_id = :userid';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid'=>$haikuid, 'authorid'=>$authorid, 'userid'=>$userId]);

        }

        $dbh = 'SELECT * FROM likes WHERE user_id = :userid';
        $stmh = $pdo->prepare($dbh);
        $stmh->execute(['userid'=>$userID]);
        $likes = $stmh->fetchAll();
    }
    
    else {
        header("location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($name) . "'s Profile" ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <script src="script.js" defer></script>
</head>
<body>
    <?php require 'header.php' ?>
    <main>
        <h1 style="max-width: 16rem;"><?php echo htmlspecialchars($name) . "'s Profile" ?></h1>
        <section class = "user-profile">
            <div class = "user">
                <figure class="profile-picture">
                    <img src="media/users/profile_pictures/pfp.png" alt="profile picture"></img>
                    <figcaption></figcaption>
                </figure>
                <h2><?php echo htmlspecialchars($name) ?></h2>
                <h3 style="opacity: 0.3; z-index: -1;"><?php echo "@".htmlspecialchars($username) ?></h3>
                <p><?php echo htmlspecialchars($age) . " years old"?></p>
                <p style="padding: 1.5rem 0;"><?php echo htmlspecialchars($bio) ?></p>
                <p style="font-size: larger; font-weight: lighter; padding-bottom: 1.5rem;"><a id="showHaikus">Haikus</a> | <a id="showLikes">Likes</a></p>
            </div>
        </section>
        <section class="haikus">
            <ul id="userHaikus">
            <?php foreach($haikus as $haiku) { 
                if ($userID === $haiku->user_id) {
                    ?>
                <li>
                    <article>
                        <br>
                        <h3><?php echo htmlspecialchars($haiku->title); ?></h3>
                        <br>
                        <p><?php  echo htmlspecialchars($haiku->first_line); ?></p>
                        <p><?php  echo htmlspecialchars($haiku->second_line); ?></p>
                        <p><?php  echo htmlspecialchars($haiku->third_line); ?></p>
                        <br>
                        <div class="profile-buttons">
                            <form action="edit-haiku.php" method="POST">
                                <input type="hidden" value="<?php echo $haiku->haiku_id ?>" name="haikuid">
                                <input type="hidden" value="<?php echo $haiku->title ?>" name="title">
                                <input type="hidden" value="<?php echo $haiku->first_line ?>" name="firstline">
                                <input type="hidden" value="<?php echo $haiku->second_line ?>" name="secondline">
                                <input type="hidden" value="<?php echo $haiku->third_line ?>" name="thirdline">
                                <input type="submit" name="edit" class="edit" value=&#x1F589;>
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">
                                <input type="hidden" value="<?php echo $haiku->haiku_id ?>" name="haikuid">
                                <input type="submit" name="delete" value="x" class="delete">
                            </form>
                        </div>
                    </article>
                </li>
            <?php }
            }
        ?>
            </ul>
            <ul id="likedHaikus">
            <?php foreach($haikus as $haiku) { 
                    foreach($likes as $like) { 
                        if ($haiku->haiku_id === $like->haiku_id) {
            ?>
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
                                <input class="heart" value=💔&#xFE0E; name="unlike" type="submit">
                            </form>
                        <p><?php echo $error ?></p>
                    </article>
                </li>
            <?php } 
            }
        }
        ?>
            </ul>
        </section>
        <form action="add-haiku.php" method="POST">
            <button class="create-haiku">+</button>
        </form>
    </main>
    <?php require 'footer.php' ?>
    </body>
</html>