<?php
include_once 'dbConfig.php'; // เรียกใช้ไฟล์ dbConfig.php หรือไฟล์ที่เกี่ยวข้อง

session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
include('error.php'); // รวมไฟล์ error.php หรือไฟล์ที่เกี่ยวข้อง

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "You must login first";
    header('location: login.php'); // ให้เปลี่ยนเส้นทางไปยังหน้า login.php หรือหน้าที่คุณต้องการ
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_post"])) {
    $post_id = $_POST["post_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    // สร้างคำสั่ง SQL เพื่ออัปเดตโพสต์
    $sql = "UPDATE posts SET title = '$title', content = '$content' WHERE post_id = '$post_id'";

    if ($con->query($sql) === TRUE) {
        // หากอัปเดตโพสต์เรียบร้อย
        header('location: forum.php'); // ให้เปลี่ยนเส้นทางไปยังหน้า forum.php หรือหน้าที่คุณต้องการ
    } else {
        // หากมีข้อผิดพลาดในการอัปเดตโพสต์
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// ดึงข้อมูลโพสต์ที่ต้องการแก้ไข
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM posts WHERE post_id = '$edit_id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_forum.css">
    <title>Edit Post</title>
</head>
<body>
    <header>
        <!-- ส่วนหัวเว็บ -->
    </header>
    <div class="post-section">
        <h2>Edit Post</h2>
        <form method="post" action="edit_post.php">
            <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br>
            <label for="content">Content:</label>
            <textarea name="content" required><?php echo $row['content']; ?></textarea><br>
            <input type="submit" name="update_post" value="Update Post">
        </form>
    </div>
    <footer>
        <!-- ส่วนท้ายเว็บ -->
    </footer>
</body>
</html>
