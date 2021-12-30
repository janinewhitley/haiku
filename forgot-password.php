<?php

$error = $email = "";
include("config.php");

if(isset($_POST['sendemail'])) {
    if(empty($_POST['email'])) {
        $error = 'Please enter your email';
    } else {
        $email = htmlspecialchars($_POST['email']);

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $emails = $stmt->fetchAll();

        if($stmt->rowCount() > 0) {
            $email = $user->user_email;
            $id = $user->user_userid;
            $token = uniqid(md5(time()));
            $sql = "INSERT INTO password_reset(id, email, token) VALUES(:id, :email, :token)"
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id, 'email' => $email, 'token' => $token])
            $to = $email;
            $subject = "Password Reset Link"
            $message = "Please click <a href='https://$_SERVER['SERVER_NAME']/reset-password.php'> here </a> to reset your password"
            mail($to, $subject, $message);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <main class="loginscreen">
        <section class="login-logo">
            <h1>Haiku</h1>
        </section>
        <section class="add-haiku">
                <h1>Forgot Password</h1>
                <br>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <p><?php echo $error; ?></p>
                        <p class="forgot-pass-paragraph">Enter your email and if that email exists in our system, we will send you a link to reset your password.</p>
                        <br>
                        <label for="email">Email: </label>
                        <input type="email" name="email" value="<?php echo $email ?>" placeholder="somebody@example.com">
                        <br>
                        <button class="submit" type="submit" name="sendemail">Send</button>
                    </form>
        </section>
    </main>
</body>
</html>