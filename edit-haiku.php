<?php 

session_start();

include('config.php');

if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    if(isset($_POST['edit'])) {
        $_SESSION['haikuid'] = htmlspecialchars($_POST['haikuid']);
        $_SESSION['title'] = htmlspecialchars($_POST['title']);
        $_SESSION['firstline'] = htmlspecialchars($_POST['firstline']);
        $_SESSION['secondline'] = htmlspecialchars($_POST['secondline']);
        $_SESSION['thirdline'] = htmlspecialchars($_POST['thirdline']);
    }

        $haikuid = $_SESSION['haikuid'];
        $title = $_SESSION['title'];
        $firstLine = $_SESSION['firstline'];
        $secondLine = $_SESSION['secondline'];
        $thirdLine = $_SESSION['thirdline'];

    if (isset($_POST["update"])) {

        if(empty($_POST["_title"])) {

        } else {
            $title = htmlspecialchars($_POST["_title"]);
            $sql = "UPDATE haikus SET title = :title WHERE haiku_id = :haikuid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid' => $haikuid, 'title' => $title]);
            unset($_SESSION['title']);
            unset($_SESSION['haikuid']);
            header('location: home.php');

        }

        if(empty($_POST["first_line"])) {

        } else {
            $firstLine = htmlspecialchars($_POST["first_line"]);
            $sql = "UPDATE haikus SET first_line = :firstLine WHERE haiku_id = :haikuid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid' => $haikuid, 'firstLine' => $firstLine]);
            unset($_SESSION['firstline']);
            unset($_SESSION['haikuid']);
            header('location: home.php');

        }

        if(empty($_POST["second_line"])) {

        } else {
            $secondLine = htmlspecialchars($_POST["second_line"]);
            $sql = "UPDATE haikus SET second_line = :secondLine WHERE haiku_id = :haikuid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid' => $haikuid, 'secondLine' => $secondLine]);
            unset($_SESSION['secondline']);
            unset($_SESSION['haikuid']);
            header('location: home.php');

        }

        if(empty($_POST["third_line"])) {

        } else {
            $thirdLine = htmlspecialchars($_POST["third_line"]);
            $sql = "UPDATE haikus SET third_line = :thirdLine WHERE haiku_id = :haikuid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['haikuid' => $haikuid, 'thirdLine' => $thirdLine]);
            unset($_SESSION['thirdline']);
            unset($_SESSION['haikuid']);
            header('location: home.php');

        }

    }
} else {
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Haiku</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <script src="script.js" defer></script>
</head>
    <?php require 'header.php' ?>
    <main>
        <section class="add-haiku">
                <h1>Edit Haiku</h1>
                <br>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" value="<?php echo htmlspecialchars($haikuid) ?>">
                        <label for="title">Title: </label>
                        <input type="text" name="_title" value="<?php echo $title ?>">
                        <br>
                        <label for="first_line">First Line: </label>
                        <input type="text" name="first_line" value="<?php echo $firstLine ?>">
                        <br>
                        <label for="second_line">Second Line: </label>
                        <input type="text" name="second_line" value="<?php echo $secondLine ?>">
                        <br>
                        <label for="third_line">Third Line: </label>
                        <input type="text" name="third_line" value="<?php echo $thirdLine ?>">
                        <br>
                        <button class="submit" type="submit" name="update">Update</button>
                    </form>
        </section>
    </main>
    <?php require 'footer.php' ?>
</html>