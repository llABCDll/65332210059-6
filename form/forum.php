<?php
include_once 'dbConfig.php';

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $con->connect_error);
}

session_start(); // เริ่มเซสชันหรือกู้ค่าเซสชันของผู้ใช้ (หากมี)
include('error.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "you must Login";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('location: login.php');
}

// การโพสต์ (เพิ่มโพสต์ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_SESSION["user_id"];

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
        // สร้างคำสั่ง SQL เพื่อเพิ่มโพสต์และระบุผู้ใช้
        $sql = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";

        if ($con->query($sql) === TRUE) {
            // เมื่อเพิ่มโพสต์เรียบร้อย คุณสามารถทำอย่างอื่นตามต้องการได้
            echo "";
        } else {
            // หากมีข้อผิดพลาดในการเพิ่มโพสต์
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        // ถ้า $_SESSION["user_id"] ไม่ถูกตั้งค่า ให้ทำอะไรก็ตามที่คุณต้องการ เช่น แสดงข้อความว่า "User not logged in." หรือเปลี่ยนทิศทางการทำงานตามต้องการ
        echo "User not logged in.";
    }
}

// การแสดงความคิดเห็น (comment) ด้วย user อื่น
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    $post_id = $_POST["id"]; // ใช้ "id" แทน "post_id"
    $user_id = $_SESSION["user_id"];
    $content = $_POST["comment_content"]; // ใช้ "comment_content" แทน "content"
    
    // สร้างคำสั่ง SQL เพื่อเพิ่มความคิดเห็นลงในฐานข้อมูล
    $sql = "INSERT INTO comments (post_id, content, user_id) VALUES ('$post_id', '$content', '$user_id')";
    
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
    $comment_id = $_POST["comment_id"];
    $reply_content = $_POST["reply_content"];
    $user_id = $_SESSION["user_id"];
    
    // ตรวจสอบว่าคีย์ "parent_reply_id" มีอยู่ใน $_POST หรือไม่
    $parent_reply_id = isset($_POST["parent_reply_id"]) ? $_POST["parent_reply_id"] : null;

    // สร้างคำสั่ง SQL เพื่อเพิ่มความตอบกลับลงในฐานข้อมูล
    $sql = "INSERT INTO replies (comment_id, content, user_id, parent_reply_id) VALUES ('$comment_id', '$reply_content', '$user_id', '$parent_reply_id')";

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


        <nav class="createpost">
    <div style="text-align: center; margin-top: 5%">
        <button class="icon-btn add-btn" onclick="redirectToForum()">
            <div class="add-icon"></div>
            <div class="btn-txt">Create</div>
        </button>
    </div>
</nav>

<script>
    function redirectToForum() {
        // ใช้ window.location.href เพื่อเปลี่ยนหน้าไปยัง forum_db.php
        window.location.href = 'forum_db.php';
    }
</script>


<!-- เริ่ม ปุ่มล็อกอินขล็อกเอาต์ -->
        <?php if(isset($_SESSION['user_id'])) :?>
            <p><button class="btnn"><a href="home.html?logout='1'">LogOut</a></button></p>
        <?php endif ?>
<!-- จบ ปุ่มล็อกอินขล็อกเอาต์ -->

<nav class="profile">
    <div class="profile_box">
        <?php
        if (isset($_SESSION['user_id'])) {
            $username = $_SESSION['user_id'];
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

    <div class="post-section">
    <?php
    while ($row = $result->fetch_assoc()) {
        // แสดงโพสต์และความคิดเห็นตามลำดับ
        echo '<div class="post">';
        echo '<h3>' . $row['title'] . '</h3>';
        echo '<p>' . $row['content'] . '</p>';
        echo '<p>Posted by: ' . $row['user_id'] . '</p>';
        // ตรวจสอบว่าเป็นเจ้าของโพสต์หรือไม่
    if ($row['user_id'] == $_SESSION['user_id']) {
        echo '<button class="edit-btn" onclick="editPost(' . $row['post_id'] . ');">Edit</button>';
        echo '<button class="delete-btn" onclick="deletePost(' . $row['post_id'] . ');">Delete</button>';

    }

        // เพิ่มแบบฟอร์ม Comment ในส่วนของความคิดเห็น
    echo '<div class="comments">';
    echo '<form action="forum.php" method="POST" id="comment-form-' . $row['post_id'] . '">';
    echo '<input type="text" name="comment_content" placeholder="Write a comment" required>';
    echo '<input type="hidden" name="id" value="' . $row['post_id'] . '">';
    echo '<input type="submit" name="submit_comment" value="Comment" onclick="clearCommentHistory();">';
    echo '</form>';


// เรียกข้อมูลความคิดเห็นจากฐานข้อมูล (เรียกในส่วนนี้)
$post_id = $row['post_id'];
$commentsSql = "SELECT * FROM comments WHERE post_id = $post_id";
$commentsResult = $con->query($commentsSql);

// แสดงความคิดเห็น
while ($commentRow = $commentsResult->fetch_assoc()) {
    // แสดงความคิดเห็นและปุ่ม Reply
    echo '<div class="comment">';
    echo '<p>Comment by: ' . $commentRow['user_id'] . '</p>';
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
    echo '<input type="hidden" name="comment_id" value="' . $comment_id . '">'; // ใช้ comment_id แทนเป็น parent_comment_id
    echo '<input type="submit" name="submit_reply" value="Reply">';
    echo '</form>';
    echo '</div>';


    while ($replyRow = $repliesResult->fetch_assoc()) {
        echo '<div class="reply">';
        echo '<p>Reply by: ' . $replyRow['user_id'] . '</p>';
        echo '<p>' . $replyRow['content'] . '</p>';
        echo '</div>';
    }
}
echo '</div>';
    }
?>
</div>

<!-- แสดงค่าในหน้าเว็บ
<div class="summary">
    <p>Total Posts: <?php echo $totalPosts; ?></p>
    <p>Total Comments: <?php echo $totalComments; ?></p>
</div> -->


<script>
    function toggleCommentForm(post_id) {
        var commentForm = document.getElementById('comment-form-' + post_id);
        if (commentForm.style.display === 'block') {
            commentForm.style.display = 'none';
        } else {
            commentForm.style.display = 'block';
        }
    }

    function toggleReplyForm(comment_id) {
        var replyForm = document.getElementById('reply-form-' + comment_id);
        if (replyForm.style.display === 'block') {
            replyForm.style.display = 'none';
        } else {
            replyForm.style.display = 'block';
        }
    }
</script>


<script>
function editPost(post_id) {
    // ใช้ confirm เพื่อแสดงข้อความยืนยัน
    if (confirm("คุณต้องการแก้ไขโพสต์นี้หรือไม่?")) {
        // ถ้าผู้ใช้กด "ตกลง" จะเปลี่ยนไปยังหน้าแก้ไขโพสต์ (edit_post.php)
        window.location.href = 'edit_post.php?edit_id=' + post_id;
    }
}

function deletePost(post_id) {
    // ใช้ confirm เพื่อแสดงข้อความยืนยัน
    if (confirm("คุณต้องการลบโพสต์นี้หรือไม่?")) {
        // ถ้าผู้ใช้กด "ตกลง" จะเปลี่ยนไปยังหน้าลบโพสต์ (delete_post.php)
        window.location.href = 'delete_post.php?delete_id=' + post_id;
    }
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