<?php
    // 处理用户中心页面
    require("./login_session_check.php");
    require("./dbConfig.php");
    require("./header.php");
    // 连接mysql
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    // 编码设置
    mysqli_set_charset('utf8',$link);
    @session_start();
    $name = $_SESSION['user_name'];

    $sql = "select * from adminuser where regname = '$name' and fig = 1";
    $result = mysqli_query($link,$sql);
    $admin = mysqli_num_rows($result);

    mysqli_free_result($result);
    mysqli_close($link);
 ?>
<link rel="stylesheet" href="./css/header.css">

 <!DOCTYPE html>
 <html>
 <head>
     <title>个人中心</title>
     <link rel="stylesheet" type="text/css" href="./css/user_center.css">
 </head>
    <div class="user_center">
        <div class="big_menu">
            <?php if ($admin > 0 ) { // 超级管理员 ?>
            <a href="./manager_user.php">
                <div class="center_menu">
                <h3>管理用户<br><br><img src="./images/15.jpg" alt="管理用户" width='100'></h3></div>
            </a>
            <a href="./manager_blog.php">
                <div class="center_menu">
                <h3>管理博客<br><br><img src="./images/16.jpg" alt="管理博客" width='100'></h3></div>
            </a>
            <a href="./manager_comment.php">
                <div class="center_menu">
                <h3>管理评论<br><br><img src="./images/17.jpg" alt="管理评论" width='100'></h3></div>
            </a>
            <a href="./manager_type.php">
                <div class="center_menu">
                <h3>管理分类<br><br><img src="./images/18.jpg" alt="管理分类" width='100'></h3></div>
            </a>
            
            <?php } else { // 普通用户 ?>
            <a href="./post_article.php">
                <div class="center_menu">
                <h3>发布博文<br><br><img src="./images/55.jpg" alt="发布博文" width='100'></h3></div>
            </a>
            <a href="./main.php">
                <div class="center_menu">
                <h3>博客浏览<br><br><img src="./images/99.jpg" alt="博客浏览" width='100'></h3></div>
            </a>
            <a href="./home_page.php">
                <div class="center_menu">
                <h3>我的主页<br><br><img src="./images/13.png" alt="我的主页" width='100'></h3></div>
            </a>
            <a href="./my_blog.php">
                    <div class="center_menu">
                    <h3>我的博文<br><br><img src="./images/14.png" alt="我的博文" width='100'></h3></div>
            </a>
            <a href="./search_comment.php">
                    <div class="center_menu">
                    <h3>我的评论<br><br><img src="./images/77.jpg" alt="我的评论" width='100'></h3></div>
            </a>
            <?php } ?>
            <a href="./user_exit_sql.php">
                <div class="center_menu">
                <h3>退出登录<br><br><img src="./images/10.jpg" alt="退出登录" width='100'></h3></div>
            </a>
        </div>
    </div>
    <?php require("./footer.php"); ?>
 </html>