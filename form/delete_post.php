<?php
session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
include_once 'dbConfig.php';

if(!isset($_SESSION['user'])){
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['user']);
    header('location: login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $postId = $_GET["id"];
    
    // ตรวจสอบว่าเจ้าของโพสต์คือผู้ที่ล็อกอินเท่านั้นที่สามารถลบโพสต์ได้
    $sql = "SELECT * FROM posts WHERE id = $postId";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['user'] == $_SESSION['user']) {
            // ผู้ใช้เป็นเจ้าของโพสต์
            // ดำเนินการลบโพสต์ที่นี่
            
            // สร้างคำสั่ง SQL สำหรับลบโพสต์จากฐานข้อมูล
            $deleteSql = "DELETE FROM posts WHERE id = $postId";
            
            if ($con->query($deleteSql) === TRUE) {
                echo "โพสต์ถูกลบออกแล้ว";
                // หลังจากลบเสร็จสามารถทำการ redirect ไปยังหน้าที่คุณต้องการ
                header("Location: forum.php");
            } else {
                echo "มีข้อผิดพลาดในการลบโพสต์: " . $con->error;
            }
            
        } else {
            echo "คุณไม่มีสิทธิ์ลบโพสต์นี้";
        }
    } else {
        echo "ไม่พบโพสต์ที่คุณต้องการลบ";
    }
} else {
    echo "ไม่มีข้อมูลโพสต์ที่ระบุ";
}



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // ตรวจสอบว่าเจ้าของโพสต์คือผู้ที่ล็อกอินเท่านั้นที่สามารถลบโพสต์ได้
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['user'] == $_SESSION['user']) {
            // ผู้ใช้เป็นเจ้าของโพสต์
            // ดำเนินการลบโพสต์ที่นี่
            
            // สร้างคำสั่ง SQL สำหรับลบโพสต์จากฐานข้อมูล
            $deleteSql = "DELETE FROM posts WHERE id = $id";
            
            if ($con->query($deleteSql) === TRUE) {
                echo "";
                // หลังจากลบเสร็จสามารถทำการ redirect ไปยังหน้าที่คุณต้องการ
                // header("Location: forum.php");
            } else {
                echo "มีข้อผิดพลาดในการลบโพสต์: " . $con->error;
            }
            
        } else {
            echo "คุณไม่มีสิทธิ์ลบโพสต์นี้";
        }
    } else {
        echo "ไม่พบโพสต์ที่คุณต้องการลบ";
    }
} else {
    echo "ไม่มีข้อมูลโพสต์ที่ระบุ";
}

?>

