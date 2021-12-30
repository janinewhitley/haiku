<?php 
    include('config.php');

    $error = "";

    $name = $username = $birthday = $email = $confirm_email = $password = $confirm_password = "";

    if (isset($_POST["register"])) {

        if(empty($_POST["name"])) {
            $error = "A name is required (no one will see this information and we do not share data)";
        } else {
            $name = htmlspecialchars($_POST["name"]);

            if(empty($_POST["birthday"])) {
                $error = "A date is required (no one will see this information and we do not share your data)";
            } else {
            $birthday = htmlspecialchars($_POST["birthday"]);
                if(empty($_POST["username"])) {
                    $error = "A username is required (no one will see this information and we do not share your data)";
                } else {
                    $username = htmlspecialchars($_POST["username"]);

                    $sql = "SELECT EXISTS(SELECT 1 FROM users WHERE user_username = :username)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':username' => $username]);
                    $count = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($count["EXISTS(SELECT 1 FROM users WHERE user_username = '$username')"] == 1) {
                        $error = "Username already exists";
                    } else {

                    if(empty($_POST["email"])) {
                        $error = "An email is required (no one will see this information and we do not share your data)";
                    } else {
                        
                        $email = htmlspecialchars($_POST["email"]);

                        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error = "Email must be a valid email address";
                        }

                            if(empty($_POST["confirm_email"])) {
                                $error = "Please confirm your email";
                            } else {
                                $confirm_email = htmlspecialchars($_POST["confirm_email"]);

                                if(empty($_POST["password"])) {
                                    $error = "A password is required";
                                } else {
                                    $password = htmlspecialchars($_POST["password"]);

                                    if(empty($_POST["confirm_password"])) {
                                        $error = "Please confirm your password";
                                    } else {
                                        $confirm_password = htmlspecialchars($_POST["confirm_password"]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
                                
        if ($error === "") {

            if ($email === $confirm_email) {

                if ($password === $confirm_password) {
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users(user_name, user_username, user_birthday, user_email, user_password) VALUES(:user_name, :user_username, :user_birthday, :user_email, :user_password)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['user_name' => $name, 'user_username' => $username, 'user_birthday' => $birthday, 'user_email' => $email, 'user_password' => $pass]);
                    header('location: login.php');
                 } else {
                    $error = "Passwords do not match";
                }

            } else {
                $error =  "Emails do not match";
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
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Sign Up</title>
</head>
<body>
    <main class="loginscreen">
        <section class="login-logo"><h1>Haiku</h1></section>
        <section class="log-in">
                <h1>Sign Up</h1>
                <p class="error" style="padding: .5rem 0 1rem 0;"><?php echo $error ?></p>
                    <form class="form register" action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="POST">
                        <label for="name">Name: </label>
                        <input type="text" name="name" placeholder="Jane Doe" value="<?php echo htmlspecialchars($name); ?>" required>
                        <label for="birthday">Birthday: </label>
                        <input type="date" name="birthday" value="<?php echo htmlspecialchars($birthday) ?>" required>
                        <label for="username">Username: </label>
                        <input type="text" name="username" placeholder="Enter your username here" value="<?php echo htmlspecialchars($username); ?>" maxlength="16" required>
                        <label for="email">Email: </label>
                        <input type="email" name="email" placeholder="somebody@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
                        <label for="confirm_email">Confirm Email: </label>
                        <input type="email" name="confirm_email" placeholder="somebody@example.com" value="<?php echo htmlspecialchars($confirm_email); ?>" required>
                        <label for="password">Password: </label>
                        <input type="password" name="password" placeholder="**********" minlength="8" maxlength="24" value="<?php echo htmlspecialchars($password); ?>" required>
                        <label for="confirm_password">Confirm Password: </label>
                        <input type="password" name="confirm_password" placeholder="**********" minlength="8" maxlength="24" value="<?php echo htmlspecialchars($confirm_password); ?>" required>
                        <br>
                        <button class="login" type="submit" name="register" value="register">Register</button>
                    </form>
                    <p>Already have an account? Sign in <a href="login.php" style="opacity: 0.5;">here</a></p>
        </section>
    </main>
</body>
</html>