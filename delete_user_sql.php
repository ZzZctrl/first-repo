<?php
// 处理删除用户的 SQL 操作
require "dbConfig.php";
// 连接 MySQL
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
// 编码设置
mysqli_set_charset('utf8', $link);

// 获取用户信息
$user_id = $_POST['user_id'];
$userSql = "SELECT * FROM adminuser WHERE regid = $user_id";
$userResult = mysqli_query($link, $userSql);
$userInfo = mysqli_fetch_assoc($userResult);
$user_name = $userInfo['regname'];

// 更新用户账号的 islock 状态为 1
$update_user_sql = "UPDATE adminuser SET islock = 1 WHERE regname = '$user_name'";
if (mysqli_query($link, $update_user_sql)) {
    // 更新用户发表的博客的 is_deleted 状态为 1
    $update_article_sql = "UPDATE article SET is_deleted = 1 WHERE author = '$user_name'";
    mysqli_query($link, $update_article_sql);

    // 更新用户发表的评论的 is_deleted 状态为 1
    $update_comment_sql = "UPDATE comment SET is_deleted = 1 WHERE username = '$user_name'";
    mysqli_query($link, $update_comment_sql);

    // 更新用户发表的博客下的评论的 is_deleted 状态为 1
    $update_blog_comment_sql = "UPDATE comment SET is_deleted = 1 WHERE fileid IN (SELECT id FROM article WHERE author = '$user_name')";
    mysqli_query($link, $update_blog_comment_sql);

    echo "<script type='text/javascript'>";
    echo "alert('用户已删除,相关博客和评论也已删除');";
    echo "location.href='manager_user.php';";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('删除用户失败');";
    echo "location.href='manager_user.php';";
    echo "</script>";
}

mysqli_close($link);
?>