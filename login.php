<?php 
    include('config.php');

    session_start();

    $error = $username = $password = $email = "";

    if (isset($_POST['login'])) {

        if(empty($_POST["password"])) {
            $error = 'Please enter your password.';
        } else {
            $password =  htmlspecialchars($_POST["password"]);
        }

        if(empty($_POST["username"])) {
            $error = 'Please enter your username or email.';
        } else {
            $username =  htmlspecialchars($_POST["username"]);
            $sql = "SELECT * FROM users WHERE user_username = :username OR user_email = :email";
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute(["username" => $username, "email" => $email]);
            $user = $stmt->fetch();
    
            $rowCount = $stmt->rowCount();

            if($rowCount < 1) {
                $error = 'Username or password incorrect';
            }
        }

        if (isset($username) && isset($password) || isset($email) && isset($password)) {
            $passhash = $user->user_password;
            if (password_verify($password, $passhash)) {
                $_SESSION['userid'] = $user->user_id;
                $_SESSION['username'] = $user->user_username;
                $_SESSION['name'] = $user->user_name;
                $_SESSION['bio'] = $user->user_bio;
                $_SESSION['birthday'] = $user->user_birthday;
                header("location: home.php");
            } else {
                $error = 'Username or password incorrect';
            }
        }

    } else {
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Login</title>
</head>
<body>
    <main class="loginscreen">
        <section class="login-logo"><h1>Haiku</h1></section>
        <section class="log-in">
                <h1>Login</h1>
                <p class="error" style="padding: .5rem 0 1rem 0;"><?php echo $error ?></p>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <label for="username">Username: </label>
                        <input type="text" name="username" placeholder="Enter your username here" value="<?php echo htmlspecialchars($username) ?>" required>
                        <br>
                        <label for="password">Password: </label>
                        <input type="password" name="password" placeholder="**********" maxlength="24" value="<?php echo htmlspecialchars($password) ?>" required>
                        <br>
                        <button class="login" type="submit" name="login" value="login">Login</button>
                    </form>
                    <p style="padding: 1rem 0;">Don't have an account? Sign up <a href="register.php" style="opacity: 0.5;">here</a></p>
                    <a style="opacity: .6;" href="forgot-password.php">Forgot your password?</a>
        </section>
    </main>
</body>
</html>