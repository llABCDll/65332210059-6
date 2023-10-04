<?php
    session_start();
    include('db.php');


    $error = array();

    if(isset($_POST['btn_register'])) {
        $user = mysqli_real_escape_string($con, $_POST['user']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($con, $_POST['password_2']);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        if(empty($user)){
            array_push($error, "User is required");
        }
        if(empty($password_1)){
            array_push($error, "Password is required");
        }
        if(empty($email)){
            array_push($error, "Mail is required");
        }

        if($password_1 != $password_2){
            array_push($error, 'wrong');
        }
    
        $user_check_query = "SELECT * FROM users WHERE user = '$user' OR email = '$email' ";
        $query = mysqli_query($con, $user_check_query);
        $result = mysqli_fetch_assoc($query);


        /*เช็คว่ามี user แล้วหรือยัง*/
        if($result){
            if($result['user'] === $user ){
                array_push($error, "have Username already");
            }

            if($result['email'] === $email ){
                array_push($error, "have Mail already");
            }
        }


        if(count($error) == 0){
            $password = md5($password_1);

            $sql = "INSERT INTO users (user, password, email) VALUES ('$user', '$password', '$email')";
            mysqli_query($con, $sql);

            $_SESSION['user'] = $user;
            header('location: index.php');
        }else{
            array_push($error, "Username or Mail Use already");
                $_SESSION['error'] = "Username or Mail Use already";
                header('location: signUp.php');
        }
    }

    

?>