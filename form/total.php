<?php
include_once 'dbConfig.php';
session_start();

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $con->connect_error);
}

// ดึงจำนวนโพสต์ทั้งหมด
$sqlPosts = "SELECT COUNT(*) AS totalPosts FROM posts";
$resultPosts = $con->query($sqlPosts);
$rowPosts = $resultPosts->fetch_assoc();
$totalPosts = $rowPosts['totalPosts'];

// ดึงจำนวนความคิดเห็นทั้งหมด
$sqlComments = "SELECT COUNT(*) AS totalComments FROM comments";
$resultComments = $con->query($sqlComments);
$rowComments = $resultComments->fetch_assoc();
$totalComments = $rowComments['totalComments'];
?>

<!-- เพิ่มสรุปโพสต์และความคิดเห็นไปยังหน้าเว็บ -->
<div class="summary">
    <p>Total Posts: <?php echo $totalPosts; ?></p>
    <p>Total Comments: <?php echo $totalComments; ?></p>
</div>
