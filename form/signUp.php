<?php
    include('db.php');
    include('register_db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Franklin
            :ital@1&family=Noto+Sans+Thai&display=swap" rel="stylesheet">

    <title>Register</title>
</head>

<body>

    <header>
        <h1>LEGO</h1>
    </header>

    <div class="mid">
        <h1>Thailand</h1>
        <p>How could my day be bad. When I'm with you?</p>
    </div>
        <div class="form1">
            <h2>Sign Up</h2>

            <form action="register_db.php" method="POST">

                <?php include('error.php'); ?>

                <?php if(isset($_SESSION['error'])) : ?>
                        <div class="error">
                            <h3>
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </3>
                        </div>
                    <?php endif ?>

                <div class="input">
                    <label for="user"></lebel>
                    <input type="text" name="user" placeholder="Username" required>
                </div>
                <div class="input">
                    <label for="password_1"></lebel>
                    <input type="password" name="password_1" placeholder="Password" required>
                </div>
                <div class="input">
                    <label for="password_2"></lebel>
                    <input type="password" name="password_2" placeholder="Confirm Password" required>
                </div>
                <div class="input">
                    <label for="email"></lebel>
                    <input type="email" name="email" placeholder="Mail" required>
                </div>

                <div class="input">
                    <button type="submit" name="btn_register" class="btnn">Submit</button>
                </div>

            </form>
            <p>Already have Account ?
                <a href="login.php">Sign In</a>
            </p>
        </div>
                     
</body>
</html>