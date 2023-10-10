<?php

include_once 'dbConfig.php';

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $con->connect_error);
}


    session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
    include('error.php');

    if(!isset($_SESSION['user_id'])){
        $_SESSION['msg'] = "you must Login";
        header('location: login.php');
    }

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['user_id']);
        header('location: login.php');
    }


// การโพสต์ (เพิ่มโพสต์ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีค่า post_id ที่ถูกส่งมา
    if (isset($_POST["post_id"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];
        // ตรวจสอบค่า $_SESSION["user_id"] ว่าถูกตั้งค่าและไม่ว่างเปล่า
        if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            // สร้างคำสั่ง SQL เพื่อเพิ่มโพสต์และระบุผู้ใช้
            $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";

            if ($con->query($sql) === TRUE) {
                // เมื่อเพิ่มโพสต์เรียบร้อย คุณสามารถทำอย่างอื่นตามต้องการได้
                echo "Post added successfully!";
            } else {
                // หากมีข้อผิดพลาดในการเพิ่มโพสต์
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } else {
            // ถ้า $_SESSION["user_id"] ไม่ถูกตั้งค่า ให้ทำอะไรก็ตามที่คุณต้องการ เช่น แสดงข้อความว่า "User not logged in." หรือเปลี่ยนทิศทางการทำงานตามต้องการ
            echo "User not logged in.";
        }
    } else {
        // ถ้าไม่มี post_id ที่ถูกส่งมา ให้ทำอะไรก็ตามตามต้องการ เช่น แสดงข้อความว่า "Invalid request." หรือเปลี่ยนทิศทางการทำงานตามต้องการ
        echo "Invalid request.";
    }
}



// การแสดงความคิดเห็น (comment) ด้วย user อื่น
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    $post_id = $_POST["post_id"]; // id ของโพสต์ที่กำลังแสดงความคิดเห็น
    $commentingUser = $_SESSION["user_id"]; // user ของผู้ใช้ที่ comment
    $content = $_POST["comment_content"]; // เนื้อหาของความคิดเห็น
    
    // สร้างคำสั่ง SQL เพื่อเพิ่มความคิดเห็นลงในฐานข้อมูลโดยระบุ user ที่ comment
    $sql = "INSERT INTO comments (post_id, content, user_id) VALUES ('$post_id', '$content', '$commentingUser')";
    
    if ($con->query($sql) === TRUE) {
        // หากเพิ่มความคิดเห็นเรียบร้อย
        // คุณสามารถทำอย่างอื่นตามต้องการได้
        echo "";
    } else {
        // หากมีข้อผิดพลาดในการเพิ่มความคิดเห็น
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}


// การเพิ่มความตอบกลับ (reply) ด้วย user อื่น
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_reply"])) {
    $commentId = $_POST["comment_id"]; // ID ของความคิดเห็นที่กำลังถูกตอบกลับ
    $replyingUser = $_SESSION["user_id"]; // User ของผู้ใช้ที่ตอบกลับ
    $replyContent = $_POST["reply_content"]; // เนื้อหาของความตอบกลับ

    // สร้างคำสั่ง SQL เพื่อเพิ่มความตอบกลับลงในฐานข้อมูลโดยระบุ user ที่ตอบกลับและ comment_id
    $sql = "INSERT INTO replies (comment_id, content, user_id) VALUES ('$commentId', '$replyContent', '$replyingUser')";

    if ($con->query($sql) === TRUE) {
        // หากเพิ่มความตอบกลับเรียบร้อย
        // คุณสามารถทำอย่างอื่นตามต้องการได้
        echo "";
    } else {
        // หากมีข้อผิดพลาดในการเพิ่มความตอบกลับ
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}



// รับค่าจาก Session
// $totalPosts = isset($_SESSION['totalPosts']) ? $_SESSION['totalPosts'] : 0;
// $totalComments = isset($_SESSION['totalComments']) ? $_SESSION['totalComments'] : 0;

// $totalPosts = $_SESSION['totalPosts'];
// $totalComments = $_SESSION['totalComments'];

// ดึงโพสต์ทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $con->query($sql);
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_post.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital@1&family=Noto+Sans+Thai&display=swap" rel="stylesheet">
    <title>Create a post</title>
    
</head>
<body>
    <header>
        <div>
             <!-- เพิ่มโลโก้เป็นลิงก์ -->
             <h2><a href="index.php"><img src="path_to_your_logo_image.png" alt="Logo"></a> Create Post</h2>
    <!-- เพิ่มเมนูอื่น ๆ ตามต้องการ -->
        </div>
        <div class="search-bar">
            <!-- Add your search bar here -->
            <input type="text" placeholder="Search...">
        </div>
        <nav class="profile">
            <div class="profile_box">
                <a class="user_name"><?php
                    if (isset($_SESSION['user_id'])) {
                        $username = $_SESSION['user_id'];
                        echo '<a class="user_name">' . $username . '</a>';
                    } else {
                        echo '<a class="user_name">Guest</a>';
                    }
                    ?></a>
                    <input type="checkbox" class="profile_checkbox" id="profile_checkbox">
                <label for="profile_checkbox" class="profile_button">
                    <span class="options_icon">&#9660;</span>
                    <div class="options_menu">
                        <ul>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Account</a></li>
                            <li><a href="home.html?logout='1'">Sigout</a></li>
                        </ul>
                    </div>
                </label>
            </div>
        </nav>
    </div>
    
    </header>

    <div class="content-container">
    <nav class="menu">
        <ul>
            <li>Post</li>
        </ul>
    </nav>

    <div class="create-post">
    <h2>Create a Post</h2>
    <form action="forum.php" method="POST">
        <!-- ช่องกรอกหัวข้อ -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <!-- ช่องกรอกเนื้อหา -->
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required></textarea>
        <!-- ปุ่มส่งข้อมูลโพสต์ -->
        <input type="submit" name="post" value="Post">
    </form>
</div>


</body>
</html>