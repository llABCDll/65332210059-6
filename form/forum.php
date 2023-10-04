<?php

include_once 'dbConfig.php';

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $con->connect_error);
}


    session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
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


// การโพสต์ (เพิ่มโพสต์ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user = $_SESSION["user"]; 
    
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        // สร้างคำสั่ง SQL เพื่อเพิ่มโพสต์และระบุผู้ใช้
        $sql = "INSERT INTO posts (title, content, user) VALUES ('$title', '$content', '$user')";

        $con->query($sql);
        // เมื่อเพิ่มโพสต์เรียบร้อย คุณอาจต้องเรียกโหลดหน้า forum.php หรือทำอื่นตามต้องการ
    } else {
        // ถ้า $_SESSION["user"] ไม่ถูกตั้งค่า ให้ทำอะไรก็ตามที่คุณต้องการ เช่น แสดงข้อความว่า "User not logged in." หรือเปลี่ยนทิศทางการทำงานตามต้องการ
        echo "User not logged in.";
    }
    
    // สร้างคำสั่ง SQL เพื่อเพิ่มโพสต์และระบุผู้ใช้
    // $sql = "INSERT INTO posts (title, content, user) VALUES ('$title', '$content', '$user')";
    // $con->query($sql);

    // เมื่อเพิ่มโพสต์เรียบร้อย คุณอาจต้องเรียกโหลดหน้า forum.php หรือทำอื่นตามต้องการ
}

// การแสดงความคิดเห็น (comment) ด้วย user อื่น
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    $id = $_POST["id"]; // id ของโพสต์ที่กำลังแสดงความคิดเห็น
    $commentingUser = $_SESSION["user"]; // user ของผู้ใช้ที่ comment
    $content = $_POST["comment_content"]; // เนื้อหาของความคิดเห็น
    
    // สร้างคำสั่ง SQL เพื่อเพิ่มความคิดเห็นลงในฐานข้อมูลโดยระบุ user ที่ comment
    $sql = "INSERT INTO comments (id, content, user) VALUES ('$id', '$content', '$commentingUser')";
    
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
    $replyingUser = $_SESSION["user"]; // User ของผู้ใช้ที่ตอบกลับ
    $replyContent = $_POST["reply_content"]; // เนื้อหาของความตอบกลับ

    // สร้างคำสั่ง SQL เพื่อเพิ่มความตอบกลับลงในฐานข้อมูลโดยระบุ user ที่ตอบกลับและ comment_id
    $sql = "INSERT INTO replies (comment_id, content, user) VALUES ('$commentId', '$replyContent', '$replyingUser')";

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
$totalPosts = isset($_SESSION['totalPosts']) ? $_SESSION['totalPosts'] : 0;
$totalComments = isset($_SESSION['totalComments']) ? $_SESSION['totalComments'] : 0;

$totalPosts = $_SESSION['totalPosts'];
$totalComments = $_SESSION['totalComments'];

// ดึงโพสต์ทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $con->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style_forum.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Franklin
            :ital@1&family=Noto+Sans+Thai&display=swap" rel="stylesheet">

            <style>
    body {
        background-image: url('https://images2.alphacoders.com/127/1274819.jpg'); /* เปลี่ยน 'ชื่อไฟล์รูปภาพ.jpg' เป็นตำแหน่งและชื่อไฟล์ของรูปภาพที่คุณต้องการใช้ */
        background-size: cover; /* ใช้เต็มขนาดของหน้าจอ */
        background-repeat: no-repeat; /* ไม่ต้องทำซ้ำรูปภาพ */
        background-attachment: fixed; /* คงความนิ่ง (ไม่เลื่อนพื้นหลัง) */
    }
</style>


    <title>Document</title>
</head>
<body>

    <header>
        
        <h1>LEGO</h1>
        <nav class="top">
            <a href="index.php">HOME</a>
            <a href="forum.php">FORUM</a>
            <a href="์newpost.php">ABOUT</a>
            <a href="#">CONTACT</a>
        </nav>


<!-- เริ่ม ปุ่มล็อกอินขล็อกเอาต์ -->
        <?php if(isset($_SESSION['user'])) :?>
            <p><button class="btnn"><a href="home.html?logout='1'">LogOut</a></button></p>
        <?php endif ?>
<!-- จบ ปุ่มล็อกอินขล็อกเอาต์ -->

<nav class="profile">
    <div class="profile_box">
        <?php
        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user'];
            echo '<a class="user_name">' . $username . '</a>';
        } else {
            echo '<a class="user_name">Guest</a>';
        }
        ?>
        <input type="checkbox" class="profile_checkbox" id="profile_checkbox">
        <label for="profile_checkbox" class="profile_button">
            <span class="options_icon">&#9660;</span>
            <div class="options_menu">
                <ul>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Account</a></li>
                    <li><a href="#">Sign Out</a></li>
                </ul>
            </div>
        </label>
    </div>
</nav>

        </div>
    </header>
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



<div class="post-section">
    <?php
    while ($row = $result->fetch_assoc()) {
        // แสดงโพสต์และความคิดเห็นตามลำดับ
        echo '<div class="post">';
        echo '<h3>' . $row['title'] . '</h3>';
        echo '<p>' . $row['content'] . '</p>';
        echo '<p>Posted by: ' . $row['user'] . '</p>';
        // ตรวจสอบว่าเป็นเจ้าของโพสต์หรือไม่
    if ($row['user'] == $_SESSION['user']) {
        echo '<button class="edit-btn" onclick="editPost(' . $row['id'] . ');">Edit</button>';
        echo '<button class="delete-btn" onclick="deletePost(' . $row['id'] . ');">Delete</button>';
    }


        // เพิ่มแบบฟอร์ม Comment ในส่วนของความคิดเห็น
        // เพิ่มแบบฟอร์มการตอบกลับในส่วนของความคิดเห็น
echo '<div class="comments">';
echo '<form action="forum.php" method="POST" id="comment-form">';
echo '<input type="text" name="comment_content" placeholder="Write a comment" required>';
echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
echo '<input type="submit" name="submit_comment" value="Comment" onclick="clearCommentHistory();">';
echo '</form>';

// เรียกข้อมูลความคิดเห็นจากฐานข้อมูล (เรียกในส่วนนี้)
$id = $row['id'];
$commentsSql = "SELECT * FROM comments WHERE id = $id";
$commentsResult = $con->query($commentsSql);

// แสดงความคิดเห็น
while ($commentRow = $commentsResult->fetch_assoc()) {
    // แสดงความคิดเห็นและปุ่ม Reply
    echo '<div class="comment">';
    echo '<p>Comment by: ' . $commentRow['user'] . '</p>';
    echo '<p>' . $commentRow['content'] . '</p>';
    echo '<button class="reply-btn" onclick="toggleReplyForm(' . $commentRow['comment_id'] . ');">Reply</button>';
    echo '</div>';

    // เรียกข้อมูลการตอบกลับจากความคิดเห็น (เรียกในส่วนนี้)
    $comment_id = $commentRow['comment_id'];
    $repliesSql = "SELECT * FROM replies WHERE comment_id = $comment_id";
    $repliesResult = $con->query($repliesSql);

    // แสดงการตอบกลับ
    echo '<div id="reply-form-' . $comment_id . '" style="display: none;">';
    echo '<form action="forum.php" method="POST">';
    echo '<input type="text" name="reply_content" placeholder="Write a reply" required>';
    echo '<input type="hidden" name="comment_id" value="' . $comment_id . '">';
    echo '<input type="submit" name="submit_reply" value="Reply">';
    echo '</form>';
    echo '</div>';

    while ($replyRow = $repliesResult->fetch_assoc()) {
        echo '<div class="reply">';
        echo '<p>Reply by: ' . $replyRow['user'] . '</p>';
        echo '<p>' . $replyRow['content'] . '</p>';
        echo '</div>';
    }
}
echo '</div>';
    }
?>
</div>

<!-- แสดงค่าในหน้าเว็บ -->
<div class="summary">
    <p>Total Posts: <?php echo $totalPosts; ?></p>
    <p>Total Comments: <?php echo $totalComments; ?></p>
</div>


<script>
function toggleReplyForm(commentId) {
    var replyForm = document.getElementById('reply-form-' + commentId);
    if (replyForm.style.display === 'block') {
        replyForm.style.display = 'none';
    } else {
        replyForm.style.display = 'block';
    }
}
</script>

<script>
function toggleCommentForm(id) {
    var commentForm = document.getElementById('comment-form-' + id);
    if (commentForm.style.display === 'block') {
        commentForm.style.display = 'none';
    } else {
        commentForm.style.display = 'block';
    }
}
</script>


<script>
    function editPost(id) {
    // ส่งคำขอแก้ไขโพสต์ไปยังหน้าแก้ไขโพสต์โดยส่ง postId ด้วย
    window.location.href = 'edit_post.php?id=' + id;
}

    function deletePost(id) {
    // ส่งคำขอลบโพสต์ไปยังหน้าลบโพสต์โดยส่ง postId ด้วย
    window.location.href = 'delete_post.php?id=' + id;
}

</script>


<script>
    // ฟังก์ชันสำหรับบันทึกประวัติการพิมพ์ Comment
    function saveCommentHistory() {
        var commentField = document.getElementById('comment_content');
        var commentText = commentField.value;
        sessionStorage.setItem('commentHistory', commentText);
    }

    // ฟังก์ชันสำหรับล้างประวัติการพิมพ์ Comment
    function clearCommentHistory() {
        var commentField = document.getElementById('comment_content');
        commentField.value = ''; // ล้างค่าในฟิลด์ข้อความ Comment
        sessionStorage.removeItem('commentHistory'); // ลบประวัติการพิมพ์ Comment
    }

    // ฟังก์ชันสำหรับกู้ค่าประวัติการพิมพ์ Comment เมื่อโหลดหน้าเว็บ
    window.onload = function() {
        var commentField = document.getElementById('comment_content');
        var commentHistory = sessionStorage.getItem('commentHistory');
        if (commentHistory) {
            commentField.value = commentHistory;
        }
    };
</script>



</body>
</html>