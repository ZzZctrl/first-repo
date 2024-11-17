<?php
// 启动会话
session_start();

// 连接数据库
include("./dbConfig.php");
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

// 获取用户信息
$userSql = "SELECT * FROM adminuser WHERE regname = '{$_SESSION['user_name']}'";
$userResult = mysqli_query($link, $userSql);
$userInfo = mysqli_fetch_assoc($userResult);

// 获取博客和评论数量
$blogSql = "SELECT COUNT(*) AS blog_count FROM article WHERE author = '{$_SESSION['user_name']}' and is_deleted=0 ";
$blogResult = mysqli_query($link, $blogSql);
$blogCount = mysqli_fetch_assoc($blogResult)['blog_count'];

$commentSql = "SELECT COUNT(*) AS comment_count FROM comment WHERE username = '{$_SESSION['user_name']}' and is_deleted=0";
$commentResult = mysqli_query($link, $commentSql);
$commentCount = mysqli_fetch_assoc($commentResult)['comment_count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>个人主页</title>
    <link rel="stylesheet" type="text/css" href="./css/home_page.css">
</head>
<body>
    <div class="home-container">
        <div class="return-btn-container">
            <a href="./user_center.php" class="return-btn">返回</a>
        </div>
        <div class="home-board">
            <div class="home-profile-box">
                <div class="home-avatar-box">
                    <img src="<?php echo './touxiang/' . $userInfo['avatar']; ?>" alt="<?php echo $userInfo['regname']; ?>" class="home-avatar">
                </div>
                <div class="home-info-box">
                    <h2 class="home-name"><?php echo $userInfo['regname']; ?></h2>
                    <p class="home-signature"><?php echo $userInfo['signature']; ?></p>
                    <p class="home-details">性别: <?php echo $userInfo['regsex']; ?></p>
                    <p class="home-details">生日: <?php echo $userInfo['birthday']; ?></p>
                    <p class="home-details">邮箱: <?php echo $userInfo['regemail']; ?></p>
                    <p class="home-details">博客数量: <?php echo $blogCount; ?></p>
                    <p class="home-details">评论数量: <?php echo $commentCount; ?></p>
                    <div class="edit-btn-container">
                        <a href="./edit_info.php" class="edit-btn">修改信息</a>
                    </div>
                </div>
            </div>
            <div class="home-blog-box">
                <h2 class="home-title">最新博文</h2>
                <?php
                include("./home_page_sql.php");
                ?>
            </div>
        </div>
    </div>
</body>
</html>