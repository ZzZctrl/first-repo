<?php
require "dbConfig.php";
require "login_session_check.php";

// 连接数据库
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

$blog_id = $_POST["blog_id"];

// 更新博客的is_deleted状态为1
$update_blog_sql = "UPDATE article SET is_deleted = 1 WHERE id = $blog_id";
if (mysqli_query($link, $update_blog_sql)) {
    // 更新博客下评论的is_deleted状态为1
    $update_comment_sql = "UPDATE comment SET is_deleted = 1 WHERE fileid = $blog_id";
    mysqli_query($link, $update_comment_sql);

    echo "<script type='text/javascript'>";
    echo "alert('博客删除成功');";
    echo "window.location.href = './manager_blog.php';";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('博客删除失败');";
    echo "window.location.href = './manager_blog.php';";
    echo "</script>";
}

mysqli_close($link);
?>