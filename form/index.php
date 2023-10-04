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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_web.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Franklin
            :ital@1&family=Noto+Sans+Thai&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <header>
        <h1>LEGO</h1>
        <nav class="top">
            
            <a href="index.php">HOME</a>
            <a href="forum.php">FORUM</a>
            <a href="#">ABOUT</a>
            <a href="#">CONTACT</a>

        </nav>

        <?php if(isset($_SESSION['user'])) :?>
            <p><button class="btnn"><a href="home.html?logout='1'">LogOut</a></button></p>
        <?php endif ?>
        
        
    </header>

    <div class="content">
        <?php if(isset($_SESSION['success'])) : ?>
            <div class="success">
                <h3>
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </3>
            </div>
        <?php endif ?>

        <div class="content">
        <?php if(isset($_SESSION['success'])) : ?>
            <div class="success">
                <h3>
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </3>
            </div>
        <?php endif ?>

        <h1>ประเพณีภาคเหนือ</h1>

            <div class="doc"><p> ประเพณีของภาคเหนือ เกิดจากการผสมผสานการดำเนินชีวิต และศาสนาพุทธความเชื่อเรื่องการนับถือผี 
                ส่งผลทำให้มีประเพณีที่เป็นเอกลักษณ์ของประเพณีที่จะแตกต่างกันไปตามฤดูกาล ทั้งนี้ ภาคเหนือจะมีงานประเพณีในรอบปีแทบทุกเดือน 
                จึงขอยกตัวอย่างประเพณีภาคเหนือบางส่วนมานำเสนอ ดังนี้</p>
            </div>
    
        <div class="box1">
            
            <div class="pic1"></div>

            <div class="infor"><p><b>ประเพณีลอยโคม</b> 
                <br>ชาวล้านนาจังหวัดเชียงใหม่ ที่มีความเชื่อในการปล่อย โคมลอยซึ่งทำด้วยกระดาษสาติดบนโครงไม้ไผ่
                แล้วจุดตะเกียงไฟตรงกลางเพื่อให้ไอความร้อนพาโคมลอยขึ้นไปในอากาศเป็นการปล่อยเคราะห์ปล่อยโศกและเรื่องร้าย ๆ ต่าง ๆ ให้ไปพ้นจากตัว</p>
            </div>
        </div> 

        <div class="box2">

            <div class="pic2"></div>

            <div class="infor"><p><b>ประเพณีสงกรานต์</b> 
                <br>ถือเป็นช่วงแรกของการเริ่มต้นปี๋ใหม่เมือง หรือสงกรานต์งานประเพณี โดยแบ่งออกเป็น<br>

                วันที่ 13 เมษายน หรือวันสังขารล่อง ถือเป็นวันสิ้นสุดของปี  ดยจะมีการยิงปืน  ยิงสโพก และจุดประทัดตั้งแต่ก่อนสว่างเพื่อขับไล่สิ่งไม่ดี  
                วันนี้ต้องเก็บกวาดบ้านเรือน และ ทำความสะอาดวัด<br>
          
                วันที่ 14 เมษายน หรือวันเนา ตอนเช้าจะมีการจัดเตรียมอาหารและเครื่องไทยทาน สำหรับงานบุญในวันรุ่งขึ้น  ตอนบ่ายจะไปขนทรายจากแม่น้ำ
                เพื่อนำไปก่อเจดีย์ทรายในวัด เป็นการทดแทนทรายที่เหยียบติดเท้าออกจากวัดตลอดทั้งปี<br>
          
                วันที่ 15 เมษายน หรือวันพญาวัน เป็นวันเริ่มศักราชใหม่ มีการทำบุญถวายขันข้าว ถวายตุง  ไม้ค้ำโพธิ์ที่วัดสรงน้ำพระพุทธรูป 
                พระธาตุและรดน้ำดำหัวขอพรจากผู้ใหญ่ที่เคารพนับถือ<br>
          
                วันที่ 16-17 เมษายน หรือวันปากปีและวันปากเดือน เป็นวันทำพิธีทางไสยศาสตร์  สะเดาะเคราะห์  และบูชาสิ่งศักดิ์สิทธิ์ต่าง ๆ 
                ทั้งนี้ ชาวล้านนามีความเชื่อว่า การทำพิธีสืบชะตาจะช่วยต่ออายุให้ตน เอง ญาติพี่น้อง และบ้านเมืองให้ยืนยาว ทำให้เกิดความเจริญรุ่งเรืองและความเป็นสิริมงคล 
                โดยแบ่งการสืบชะตาแบ่งออกเป็น 3 ประเภท คือ การสืบชะตาคน, การสืบชะตาบ้าน และการสืบชะตาเมือง</p>
            </div>         
        </div> 

        <div class="box3">
            
            <div class="pic3"></div>

            <div class="infor"><p><b>ปรเพณีแห่นางแมว</b> 
                <br>ระหว่างเดือนพฤษภาคมถึงสิงหาคม เป็นช่วงของการเพาะปลูก หากปีใดฝนแล้งไม่มีน้ำ จะทำให้นาข้าวเสียหาย ชาวบ้านจึงพึ่งพาสิ่งเหนือธรรมชาติ 
                เช่น ทำพิธีขอฝนโดยการแห่นางแมว โดยมีความเชื่อกันว่าหากกระทำเช่นนั้นแล้วจะช่วยให้ฝนตก</p>
            </div>
        </div>

        <div class="box4">
            
            <div class="pic4"></div>

            <div class="infor"><p><b>ประเพณีตานตุง</b> 
                <br>ในภาษาถิ่นล้านนา ตุง หมายถึง "ธง" จุดประสงค์ของการทำตุงในล้านนาก็คือ การทำถวายเป็นพุทธบูชา 
                ชาวล้านนาถือว่าเป็นการทำบุญอุทิศให้แก่ผู้ที่ล่วงลับไปแล้ว หรือถวายเพื่อเป็นปัจจัยส่งกุศลให้แก่ตนไปในชาติหน้า ด้วยความเชื่อที่ว่า 
                เมื่อตายไปแล้วก็จะได้เกาะยึดชายตุงขึ้นสวรรค์พ้นจากขุมนรก วันที่ถวายตุงนั้นนิยมกระทำในวันพญาวันซึ่งเป็นวันสุดท้ายของเทศกาลสงกรานต์</p>
            </div>
        </div>

        <div class="box5">
            
            <div class="pic5"></div>

            <div class="infor"><p><b>ประเพณีกรวยสลาก หรือตานก๋วยสลาก</b> 
                <br>เป็นประเพณีของชาวพุทธที่มีการทำบุญให้ทานรับพรจากพระ จะทำให้เกิดสิริมงคลแก่ตนและอุทิศส่วนกุศลให้แก่ผู้ล่วงลับไปแล้ว 
                เป็นการระลึกถึงบุญคุณของผู้มีพระคุณ และเป็นการแสดงออกถึงความสามัคคีของคนในชุมชน</p>
            </div>
        </div> 
    </div>


        


</body>
</html>