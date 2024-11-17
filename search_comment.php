<?php
// 启动会话
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>我的评论</title>
    <link rel="stylesheet" type="text/css" href="./css/my_comments.css">
    <style>
        .comment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .comment-actions {
            display: flex;
            gap: 10px;
        }
        .delete-comment {
            display: inline-block;
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-comment:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="comment-container">
        <div class="comment-board">
            <div class="return-btn-container">
            <a href="./user_center.php" class="return-btn">返回</a>
            </div>
            <h2 class="comment-title">我的评论</h2>
            <?php
            // 检查用户是否登录
            if (isset($_SESSION['user_name'])) {
                // 连接数据库
                include("./dbConfig.php");
                include("./login_session_check.php");
                $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
                mysqli_set_charset('utf8', $link);

                // 查询该用户的评论内容
                $sql = "SELECT c.id, c.content, c.comtime, a.title, c.fileid 
                        FROM comment c
                        JOIN article a ON c.fileid = a.id
                        WHERE c.username = '{$_SESSION['user_name']}' AND c.is_deleted = 0
                        ORDER BY c.comtime DESC";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // 输出评论内容
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='comment-item'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['fileid'] . "' class='comment-title'>" . $row['title'] . "</a>";
                        echo "<p class='comment-content'>" . $row['content'] . "</p>";
                        echo "<p class='comment-time'>" . $row['comtime'] . "</p>";
                        echo "<div class='comment-actions'>";
                        echo "<a href='./search_comment.php?id=" . $row['id'] . "' class='delete-comment'>删除</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='no-comments'>您还没有发表任何评论。</div>";
                }

                // 关闭数据库连接
                mysqli_close($link);
            } else {
                echo "<div class='no-comments'>您尚未登录,无法查看评论内容。</div>";
            }
            ?>
            
        </div>
    </div>

    <?php
    // 处理删除评论的操作
    if (isset($_GET['id'])) {
        $commentId = $_GET['id'];
        // 重新连接数据库
        $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
        mysqli_set_charset('utf8', $link);

        $sql = "UPDATE comment SET is_deleted = 1 WHERE id = $commentId AND username = '{$_SESSION['user_name']}'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            // 删除成功,提示窗口
            echo "<script type='text/javascript'>";
            echo "alert('删除评论成功');";
            echo "window.location.href = './search_comment.php';";
            echo "</script>";
        } else {
            echo "<script>alert('删除评论失败');</script>";
        }

        // 关闭数据库连接
        mysqli_close($link);
    }
    ?>
</body>
</html>