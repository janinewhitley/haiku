<?php 

    $error = $email = $password = $confirm_password = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Reset Your Password</title>
</head>
<body>
    <main class="loginscreen">
        <section class="login-logo"><h1>Haiku</h1></section>
        <section class="log-in">
                <h1>Reset Your Password</h1>
                <p class="error" style="padding: .5rem 0 1rem 0;"><?php echo $error ?></p>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <label for="email">Email: </label>
                        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>" readonly required>
                        <br>
                        <label for="password">Password: </label>
                        <input type="password" name="password" placeholder="**********" minlength="8" maxlength="24" value="<?php echo htmlspecialchars($password); ?>" required>
                        <label for="confirm_password">Confirm Password: </label>
                        <input type="password" name="confirm_password" placeholder="**********" minlength="8" maxlength="24" value="<?php echo htmlspecialchars($confirm_password); ?>" required>
                        <br>
                        <button class="login" type="submit" name="reset_password" value="reset_password">Reset Password</button>
                    </form>
                    <a style="opacity: .6;" href="forgot-password.php">Forgot your password?</a>
        </section>
    </main>
</body>
</html>