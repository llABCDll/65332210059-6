<?php

// การเชื่อมต่อกับฐานข้อมูลผู้ใช้
$user_db = mysqli_connect("localhost", "root", "", "blog");

// ตรวจสอบการเชื่อมต่อกับฐานข้อมูลผู้ใช้
if (!$user_db) {
    die("การเชื่อมต่อกับฐานข้อมูลผู้ใช้ล้มเหลว: " . mysqli_connect_error());
}

// การเชื่อมต่อกับฐานข้อมูลความคิดเห็น
$comment_db = mysqli_connect("localhost", "root", "", "blog");

// ตรวจสอบการเชื่อมต่อกับฐานข้อมูลความคิดเห็น
if (!$comment_db) {
    die("การเชื่อมต่อกับฐานข้อมูลความคิดเห็นล้มเหลว: " . mysqli_connect_error());
}



// ดึงข้อมูลผู้ใช้จากฐานข้อมูลผู้ใช้
$user_id = null; // กำหนดค่าเริ่มต้นให้เป็น null
$username = $_POST['username']; // รับค่า username จากแบบฟอร์ม

// ตรวจสอบว่ามีการเชื่อมต่อกับฐานข้อมูลผู้ใช้และ username ไม่ใช่ค่าว่าง
if ($user_db && !empty($username)) {
    $user_query = "SELECT user FROM users WHERE user = ?";
    $stmt = mysqli_prepare($user_db, $user_query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
}



// รับค่าเนื้อหาความคิดเห็นจากแบบฟอร์ม
$comment_content = $_POST['comment_content'];

if ($comment_db && $user_id && !empty($comment_content)) {
    // เตรียมคำสั่ง SQL สำหรับบันทึกความคิดเห็น
    $comment_query = "INSERT INTO comments (id, content) VALUES (?, ?)";
    $stmt = mysqli_prepare($comment_db, $comment_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $comment_content);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        // หลังจากบันทึกความคิดเห็นสำเร็จ ให้เปลี่ยนเส้นทางไปยังหน้า post.php
        header("Location: forum.php");
        exit; // จบการทำงานทันทีหลังจาก redirect
    } else {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL";
    }
    
}
?>