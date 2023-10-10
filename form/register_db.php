<?php
    session_start();
    include('db.php');


    $error = array();

    if(isset($_POST['btn_register'])) {
        $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($con, $_POST['password_2']);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        if(empty($user_id)){
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
    
        $user_check_query = "SELECT * FROM users WHERE user_id = '$user_id' OR email = '$email' ";
        $query = mysqli_query($con, $user_check_query);
        $result = mysqli_fetch_assoc($query);


        /*เช็คว่ามี user แล้วหรือยัง*/
        if($result){
            if($result['user_id'] === $user_id ){
                array_push($error, "have Username already");
            }

            if($result['email'] === $email ){
                array_push($error, "have Mail already");
            }
        }


        if(count($error) == 0){
            $password = md5($password_1);

            $sql = "INSERT INTO users (user_id, password, email) VALUES ('$user_id', '$password', '$email')";
            mysqli_query($con, $sql);

            $_SESSION['user_id'] = $user_id;
            setcookie("registration_success", "1", time() + 3600, "/");
            header('location: home.html');
        }else{
            array_push($error, "Username or Mail Use already");
                $_SESSION['error'] = "Username or Mail Use already";
                header('location: signUp.php');
        }
    }

?>