<?php
include_once 'dbConfig.php';
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_post"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    // ตรวจสอบให้แน่ใจว่าค่า id ไม่ว่างเปล่า
    if (empty($id)) {
        echo "ID is empty";
    } else {
        // ตัวอย่าง: คำสั่ง SQL สำหรับอัปเดตโพสต์ในฐานข้อมูล
        $editSql = "UPDATE posts SET title = '$title', content = '$content' WHERE id = $id";
        // คุณต้องแทนคำสั่ง SQL ด้านบนด้วยคำสั่ง SQL ที่ใช้ในโปรเจคของคุณ
        
        if ($con->query($editSql) === TRUE) {
            // หากอัปเดตโพสต์สำเร็จ
            echo "Post edited successfully!";
        } else {
            // หากมีข้อผิดพลาดในการอัปเดตโพสต์
            echo "Error: " . $editSql . "<br>" . $con->error;
        }
    }
}
?>
