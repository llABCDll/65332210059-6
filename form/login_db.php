<?php

    session_start();
    include('db.php');

    $error = array();
    

    if(isset($_POST['btn_user'])){
        $user = mysqli_real_escape_string($con, $_POST['user']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        if(empty($user)){
            array_push($error, "User is required");
        }
        if(empty($password)){
            array_push($error, "Password is required");
        }

        if(count($error)==0){
            $password = md5($password);
            $query = "SELECT * FROM users WHERE user = '$user' AND password = '$password' ";
            $result = mysqli_query($con, $query);
            
            if(mysqli_num_rows($result)==1){
                $_SESSION['user'] = $user;
                header('location: index.php');
                
            }else{
                array_push($error, "Wrong user or password try again");
                $_SESSION['error'] = "Wrong user or password try again";
                header('location: login.php');
            }
        }
        
    }
    
?>