<?php
// 启动会话
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>我的博客</title>
    <link rel="stylesheet" type="text/css" href="./css/my_blog.css">
</head>
<body>
    <div class="blog-container">
        <div class="blog-board">
            <div class="return-btn-container">
                <a href="./user_center.php" class="return-btn">返回</a>
            </div>
            <h2 class="blog-title">我的博客</h2>
            <?php
            // 检查用户是否登录
            if (isset($_SESSION['user_name'])) {
                // 连接数据库
                include("./dbConfig.php");
                include("./login_session_check.php");
                $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
                mysqli_set_charset('utf8', $link);

                // 查询该用户发布的博文
                $sql = "SELECT * FROM article WHERE author = '{$_SESSION['user_name']}' AND is_deleted = 0 ORDER BY pubtime DESC";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // 输出博文列表
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='blog-item'>";
                        echo "<div class='blog-cover'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "'>";
                        echo "<img src='./uploads/" . $row['picture'] . "' alt='" . $row['title'] . "' class='blog-image'>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class='blog-content'>";
                        echo "<h3 class='blog-title'><a href='./blog_article.php?blog_id=" . $row['id'] . "'>" . $row['title'] . "</a></h3>";
                        echo "<p class='blog-excerpt'>";
                        if (strlen($row['content']) > 100) {
                            echo mb_substr($row['content'], 0, 100, 'UTF-8') . "...";
                        } else {
                            echo $row['content'];
                        }
                        echo "</p>";
                        echo "<div class='blog-info'>";
                        echo "<span class='blog-author'>" . $row['author'] . "</span>";
                        echo "<span class='blog-time'>" . $row['pubtime'] . "</span>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='blog-actions'>";
                        echo "<a href='./edit_article.php?id=" . $row['id'] . "' class='edit-blog'>编辑</a>";
                        echo "<a href='./my_blog.php?delete_id=" . $row['id'] . "' class='delete-blog' onclick='return confirmDelete()'>删除</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='no-blogs'>您还没有发布任何博客文章。</div>";
                }

                // 关闭数据库连接
                mysqli_close($link);
            } else {
                echo "<div class='no-blogs'>您尚未登录,无法查看博客内容。</div>";
            }
            ?>
            
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("确定要删除这篇博客吗?");
        }
    </script>

    <?php
    // 处理删除博客的操作
if (isset($_GET['delete_id'])) {
    $blogId = $_GET['delete_id'];
    // 重新连接数据库
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    mysqli_set_charset('utf8', $link);

    // 先删除该博客的评论
    $delCommentSql = "UPDATE comment SET is_deleted = 1 WHERE fileid = $blogId";
    mysqli_query($link, $delCommentSql);

    // 再删除博客
    $delBlogSql = "UPDATE article SET is_deleted = 1 WHERE id = $blogId AND author = '{$_SESSION['user_name']}'";
    $result = mysqli_query($link, $delBlogSql);
    if ($result) {
        // 删除成功,刷新页面
        echo "<script>window.location.href = './my_blog.php';</script>";
    } else {
        echo "<script>alert('删除博客失败');</script>";
    }

    // 关闭数据库连接
    mysqli_close($link);
}
    ?>
</body>
</html>