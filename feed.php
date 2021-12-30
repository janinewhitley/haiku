<?php

    session_start();

    include('config.php');

    $error = "";

    if(isset($_SESSION["userid"])) {
        # select all users who have liked the haikus this user has liked

        $userID = $_SESSION['userid'];

        if(isset($_POST['like'])) {
            include('like.php');   
        }

        $sql = "SELECT * FROM likes WHERE user_id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userid' => $userID]);
        $likes = $stmt->fetchAll();

        
        if($stmt->rowCount() > 0) {

            foreach($likes as $like) {
                $dbh = "SELECT * FROM likes WHERE haiku_id = :haikuid";
                $stmh = $pdo->prepare($dbh);
                $stmh->execute(['haikuid' => $like->haiku_id]);
                $userids = $stmh->fetchAll();
            }

            foreach($userids as $userid) {
                $stl = "SELECT * FROM likes WHERE user_id = :userid";
                $stdh = $pdo->prepare($stl);
                $stdh->execute(['userid' => $userid->user_id]);
                $haikuids = $stdh->fetchAll();
            }

            # select liked haikus of all other users who have liked the same haiku
            foreach($haikuids as $haikuid) {
                $stq = "SELECT * FROM haikus WHERE haiku_id = :haikuid";
                $stmb = $pdo->prepare($stq);
                $stmb->execute(["haikuid" => $haikuid->haiku_id]);
                $likedhaikus = $stmb->fetchAll();
            }

            $haikus = [];

            foreach($likedhaikus as $likedhaiku) {
                array_push($haikus, $likedhaiku);
            }
        }

    } else {
        header("location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Feed</title>
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
        <p class="error"><?php echo $error ?></p>
        <h1>Your Feed</h1>
        <br>
        <section class="haikus">
            <ul>
                <?php if($stmt->rowCount() > 0) {
                    foreach($haikus as $haiku) { ?>
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
                <?php } 
                } else {
                    echo "Like some haikus to boost your algorithm!";
                }
                ?>
        </ul>
    </section>
    <form action="add-haiku.php" method="POST">
        <button class="create-haiku">+</button>
    </form>
</main>
<?php require 'footer.php' ?>
</html>