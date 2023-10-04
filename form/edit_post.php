<?php
session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
include_once 'dbConfig.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header('location: login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

// ตรวจสอบค่า ID ที่รับมา
if (!empty($id)) {
    echo "รับค่า ID ที่ถูกส่งมา: " . $id;
} else {
    echo "ไม่ได้รับค่า ID หรือค่า ID ว่างเปล่า";
}

    
    // ตรวจสอบว่ามีค่า 'id' ที่ถูกส่งมาใน URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        
        // ตัวอย่าง: คำสั่ง SQL สำหรับดึงข้อมูลโพสต์จากฐานข้อมูล
        $sql = "SELECT * FROM posts WHERE id = $id";
        // ดำเนินการ query คำสั่ง SQL และดึงข้อมูลจากฐานข้อมูล
        // คุณต้องแทนคำสั่ง SQL ด้านบนด้วยคำสั่ง SQL ที่ใช้ในโปรเจคของคุณ
        
        // เรียกใช้ฟังก์ชัน query และดึงข้อมูลโพสต์
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {
            // ถ้าพบข้อมูลโพสต์
            $post = $result->fetch_assoc();
            
            // แสดงแบบฟอร์มโพสต์เพื่อแก้ไข
            echo '<form method="post" action="forum.php">';
            echo '<input type="hidden" name="id" value="' . $post['id'] . '">';
            echo 'Title: <input type="text" name="title" value="' . $post['title'] . '"><br>';
            echo 'Content: <textarea name="content">' . $post['content'] . '</textarea><br>';
            echo '<input type="submit" name="edit_post" value="Edit Post">';
            // echo '<input type="submit" name="delete_post" value="Delete Post">';
            echo '</form>';
        } else {
            // ถ้าไม่พบข้อมูลโพสต์
            echo 'Post not found.';
        }
    } else {
        // ถ้าไม่มีหรือไม่ถูกต้องในการส่ง 'id' มาใน URL
        echo 'Invalid or missing "id" parameter in the URL.';
    }
}
?>
