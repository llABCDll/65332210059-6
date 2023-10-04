<?php
    include('db.php');
    
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
    <title>Login</title>
</head>
<body>
    
    <header>
        <h1>LEGO</h1>
    </header>

    <div class="mid">
        <h1>Thailand</h1>
        <p>How could my day be bad. When I'm with you?</p>
    </div>
        <div class="form">
            <h2>LOGIN</h2>
    
            <form action="login_db.php" method="POST">
                
                <?php include('error.php');
                      include('login_db.php'); ?>
                
                <?php if(isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <h3>
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </h3>
                    </div>

                <?php endif ?>
                <div class="input">
                    <label for="user"></lebel>
                    <input type="text" name="user" placeholder="Username" required>
                </div>
                <div class="input">
                    <label for="password"></lebel>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="input">
                    <button type="submit" name="btn_user" class="btnn">Log in</button>
                </div>

            </form>

            <p>Don't have Account ?
                <a href="signUp.php">Sign Up</a>
            </p>
        </div>
    
    
</body>
</html>