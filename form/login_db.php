<?php

    session_start();
    include('db.php');

    $error = array();
    

    if(isset($_POST['btn_user'])){
        $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        if(empty($user_id)){
            array_push($error, "User is required");
        }
        if(empty($password)){
            array_push($error, "Password is required");
        }

        if(count($error)==0){
            $password = md5($password);
            $query = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$password' ";
            $result = mysqli_query($con, $query);
            
            if(mysqli_num_rows($result)==1){
                $_SESSION['user_id'] = $user_id;
                header('location: index.php');
                
            }else{
                array_push($error, "Wrong user or password try again");
                $_SESSION['error'] = "Wrong user or password try again";
                header('location: login.php');
            }
        }
        
    }
    
?>