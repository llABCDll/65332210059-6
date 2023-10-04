<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$con = new mysqli($servername, $username, $password, $dbname);


// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user= $_POST["user"]; // สมมติว่าคุณมี session ที่เก็บ user_id ของผู้ใช้ที่ล็อกอินอยู่

    // สร้างคำสั่ง SQL เพื่อเพิ่มโพสต์และระบุผู้ใช้
    $sql = "INSERT INTO posts (title, content, user) VALUES ('$title', '$content', '$user')";
    $con->query($sql);

    if ($con->query($sql) === TRUE) {
        // บันทึกสำเร็จ
        $_SESSION['statusMsg'] = "โพสต์ถูกบันทึกสำเร็จ";
    } else {
        // ข้อผิดพลาดในการบันทึก
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    
  
    // เมื่อเพิ่มโพสต์เรียบร้อย คุณอาจต้องเรียกโหลดหน้า forum.php หรือทำอื่นตามต้องการ
}





// ดึงโพสต์ทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $con->query($sql);
?>

<?php
    session_start();
    include('error.php');

    if(!isset($_SESSION['user'])){
        $_SESSION['msg'] = "you must Login";
        header('location: login.php');
    }

    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['user']);
        header('location: login.php');
    }
 
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_pos.css">
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
                <a class="user_name">User_id</a>
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

    <!-- Content sections -->
    <div class="content-section" id="post-section">
        <!-- Form for creating a post -->
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <!-- Title -->
            <div class="title">Title</div>
            <!-- Input field for title -->
            <input type="text" name="title" placeholder="Title">
            <!-- Text box with toolbar -->
            <div class="text-box">
                <!-- Toolbar for "Text (optional)" -->
                <textarea name="content" placeholder="Text (optional)"></textarea><br>
            </div>
            <div class="text-center justify-content-center align-items-center p-4 border-2 border-dashed rounded-3">
                <input type="file" name="file" class="form-control streched-link" accept="image/gif, image/jpeg, image/png">
                <input type="submit" name="submit" value="Post">
            </div>
        </form>
    </div> <!-- ปิด .content-section ที่นี่ -->
</div> <!-- ปิด .content-container ที่นี่ -->



<div class="row">
    <?php  if (!empty($_SESSION['statusMsg'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php 
                echo $_SESSION['statusMsg']; 
                unset($_SESSION['statusMsg']);
            ?>
        </div>
    <?php } ?>
</div>



</body>
</html>