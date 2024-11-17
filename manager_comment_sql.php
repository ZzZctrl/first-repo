<?php
require "dbConfig.php";
require "login_session_check.php";

// 连接数据库
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

$comment_id = $_POST["comment_id"];

// 更新评论的is_deleted状态为1
$update_comment_sql = "UPDATE comment SET is_deleted = 1 WHERE id = $comment_id";
if (mysqli_query($link, $update_comment_sql)) {
    echo "<script type='text/javascript'>";
    echo "alert('评论删除成功');";
    echo "window.location.href = './manager_comment.php';";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('评论删除失败');";
    echo "window.location.href = './manager_comment.php';";
    echo "</script>";
}

mysqli_close($link);
?>