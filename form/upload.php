<?php 

session_start();
include_once 'dbConfig.php';

// File upload path
$targetDir = "uploads/";

if (isset($_POST['submit'])) {
    if (!empty($_FILES["file"]["name"])) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $insert = $con->query("INSERT INTO images(file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                if ($insert) {
                    $_SESSION['statusMsg'] ;
                    header("location: forum.php");
                } else {
                    $_SESSION['statusMsg'] = "File upload failed, please try again.";
                    header("location: forum.php");
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                header("location: forum.php");
            }
        } else {
            $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
            header("location: forum.php");
        }
    } else {
        $_SESSION['statusMsg'] = "Please select a file to upload.";
        header("location: forum.php");
    }
}
?>

<?php
// การโพสต์ (เพิ่มโพสต์ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // ดึงข้อมูลจากฟอร์ม
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_POST["user_id"];
    
    // เตรียมคำสั่ง SQL โดยใช้การเตรียมคำสั่ง (prepared statement)
    $sql = "INSERT INTO posts (title, content,user_id) VALUES ('$title', '$content', '$user_id')";
    
    // เตรียมคำสั่ง
    $stmt = $con->prepare($sql);
    
    // ตรวจสอบว่าการเตรียมคำสั่งเสร็จสมบูรณ์หรือไม่
    if ($stmt) {
        // ผูกค่าแทนที่ในคำสั่ง SQL
        $stmt->bind_param("ss", $title, $content);
        
        // ประมวลผลคำสั่ง SQL
        $stmt->execute();
        
        // ปิดคำสั่ง SQL
        $stmt->close();
    } else {
        // หากมีข้อผิดพลาดในการเตรียมคำสั่ง
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL.";
    }
}
?>