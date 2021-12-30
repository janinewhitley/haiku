<?php 

session_start();

include('config.php');

if(isset($_SESSION["userid"])) {

    $userid = $_SESSION["userid"];

    $errors = ["title" => "", "first_line" => "", "second_line" => "", "third_line" => ""];

    $title = $firstLine = $secondLine = $thirdLine = "";

    if (isset($_POST["submit"])) {

        if(empty($_POST["title"])) {
            $errors["title"] = "A title is required";
        } else {
            $title = htmlspecialchars($_POST["title"]);
        }

        if(empty($_POST["first_line"])) {
            $errors["first_line"] = "A first line is required";
        } else {
            $firstLine = htmlspecialchars($_POST["first_line"]);
        }

        if(empty($_POST["second_line"])) {
            $errors["second_line"] = "A second line is required";
        } else {
            $secondLine = htmlspecialchars($_POST["second_line"]);
        }

        if(empty($_POST["third_line"])) {
            $errors["third_line"] = "A third line is required";
        } else {
            $thirdLine = htmlspecialchars($_POST["third_line"]);
        }

        if(array_filter($errors)) {

        } else {

            $sql = "INSERT INTO haikus(user_id, title, first_line, second_line, third_line) VALUES(:user_id, :title, :first_line, :second_line, :third_line)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $userid, 'title' => $title, 'first_line' => $firstLine, 'second_line' => $secondLine, 'third_line' => $thirdLine]);
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
    <title><?php echo "Create A Haiku" ?></title>
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
                <h1><?php echo "Create A Haiku" ?></h1>
                <br>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <label for="title">Title: </label>
                        <input type="text" name="title" placeholder="Best Haiku" value="<?php echo htmlspecialchars($title) ?>" maxlength="255">
                        <div class="error"><?php echo $errors["title"] ?></div>
                        <br>
                        <label for="first_line">First Line: </label>
                        <input type="text" name="first_line" placeholder="this is the first post" value="<?php echo htmlspecialchars($firstLine) ?>" maxlength="55">
                        <div class="error"><?php echo $errors["first_line"] ?></div>
                        <br>
                        <label for="second_line">Second Line: </label>
                        <input type="text" name="second_line" placeholder="all shall be anonymous" value="<?php echo htmlspecialchars($secondLine) ?>" maxlength="77">
                        <div class="error"><?php echo $errors["second_line"] ?></div>
                        <br>
                        <label for="third_line">Third Line: </label>
                        <input type="text" name="third_line" placeholder="with that said, create" value="<?php echo htmlspecialchars($thirdLine) ?>" maxlength="55">
                        <div class="error"><?php echo $errors["third_line"] ?></div>
                        <br>
                        <button class="submit" type="submit" name="submit" value="submit">Submit</button>
                    </form>
        </section>
    </main>
    <?php require 'footer.php' ?>
</html>