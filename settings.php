<?php 

session_start();

include('config.php');

if(isset($_SESSION['userid'])) {
    $name = $_SESSION["name"];
    $birthday = $_SESSION["birthday"];
    $age = floor((time() - strtotime($birthday)) / 31556926);
    $username = $_SESSION["username"];
    $userid = $_SESSION["userid"];
    $bio = $_SESSION["bio"];
    // $profilepic = $_SESSION["profilepic"];
    $changeBio = $changeEmail = $confirmChangeEmail = $message = $error = "";

    if(isset($_POST['changeSettings'])) {

        if(empty($_POST['changeBio'])) {

        } else {
            $changeBio = htmlspecialchars($_POST['changeBio']);
            $sql = "UPDATE users SET user_bio = :changeBio WHERE user_id = :userid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['changeBio' => $changeBio, 'userid' => $userid]);
            $message = "Your profile has been updated";
        }

        if(empty($_POST['changeEmail'])) {

        } else {
            $changeEmail = htmlspecialchars($_POST['changeEmail']);

            if(empty($_POST['confirmChangeEmail'])) {
                $error = "Please confirm your email";
            }   else {
                $confirmChangeEmail = htmlspecialchars($_POST['confirmChangeEmail']);

                if($changeEmail === $confirmChangeEmail) {
                    $sql = "UPDATE users SET user_email = :changeEmail WHERE user_id = :userid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['changeEmail' => $changeEmail, 'userid' => $userid]);
                    $message = "Your profile has been updated";
                }
                    
                else {
                    $error = "Emails do not match";
                }
            }
        }
    }

}  else {
    header("location: login.php");
}

?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($username) . "'s Settings" ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <script src="script.js" defer></script>
</head>
<body>
<body>
    <?php require 'header.php' ?>
    <main>
        <h1 style="max-width: 16rem;">Your Settings</h1>
        <section class="settings">
            <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <p style="color: green;"><?php echo $message ?></p>
                <label for="changeBio">Update Your Bio:</label>
                <input id="changeBio" name="changeBio" placeholder="Write updated bio here" value="<?php echo htmlspecialchars($changeBio) ?>" maxlength="140"><br>
                <label for="changeEmail">Change Email:</label>
                <input type="email" id="changeEmail" name="changeEmail" placeholder="Change your email here" value="<?php echo htmlspecialchars($changeEmail) ?>"><br>
                <label for="confirmChangeEmail">Confirm Email:</label>
                <input type="email" id="confirmChangeEmail" name="confirmChangeEmail" placeholder="Confirm your email here" value="<?php echo htmlspecialchars($confirmChangeEmail) ?>"><br>
                <p class="error"><?php echo $error ?></p>
                <button class="submit" type="submit" name="changeSettings" id="changeSettings">Update Profile</button>
            </form>
        </section>
    </main>
    <?php require 'footer.php' ?>
</body>
</html>