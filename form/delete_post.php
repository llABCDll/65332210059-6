<?php
include_once 'dbConfig.php'; // เรียกใช้ไฟล์ dbConfig.php หรือไฟล์ที่เกี่ยวข้อง

session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
include('error.php'); // รวมไฟล์ error.php หรือไฟล์ที่เกี่ยวข้อง

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "You must login first";
    header('location: login.php'); // ให้เปลี่ยนเส้นทางไปยังหน้า login.php หรือหน้าที่คุณต้องการ
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // สร้างคำสั่ง SQL เพื่อลบโพสต์
    $sql = "DELETE FROM posts WHERE post_id = '$delete_id'";

    if ($con->query($sql) === TRUE) {
        // หากลบโพสต์เรียบร้อย
        header('location: forum.php'); // ให้เปลี่ยนเส้นทางไปยังหน้า forum.php หรือหน้าที่คุณต้องการ
    } else {
        // หากมีข้อผิดพลาดในการลบโพสต์
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_forum.css">
    <title>Delete Post</title>
</head>
<body>
    <header>
        <!-- ส่วนหัวเว็บ -->
    </header>
    <div class="post-section">
        <h2>Delete Post</h2>
        <p>Are you sure you want to delete this post?</p>
        <a href="delete_post.php?delete_id=<?php echo $delete_id; ?>" class="btn">Yes, Delete</a>
        <a href="forum.php" class="btn">No, Cancel</a>
    </div>
    <footer>
        <!-- ส่วนท้ายเว็บ -->
    </footer>
</body>
</html>
