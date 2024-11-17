<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>评论管理</title>
    <link rel="stylesheet" href="./css/manager_comment.css">
</head>
<body>
    <?php
    require "dbConfig.php";
    require "login_session_check.php";
    require "./header.php";

    // 连接数据库
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    mysqli_set_charset('utf8', $link);

    $get_comments_sql = "SELECT c.id, c.content, c.comtime, a.title, a.id AS blog_id, c.username, c.is_deleted
                         FROM comment c
                         JOIN article a ON c.fileid = a.id
                         WHERE c.is_deleted = 0
                         ORDER BY c.comtime DESC";
    $res_comments = mysqli_query($link, $get_comments_sql);
    $num_comments = mysqli_num_rows($res_comments);
    ?>

    <div class="comments_table_wrapper">
        <div class="comments_table">
            <div class="comment_title">
                <h2 style="text-align: center;"><?php echo "本系统共有" . $num_comments . "条评论" . "<br/>"; ?></h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>评论内容</th>
                        <th>评论文章</th>
                        <th>评论用户</th>
                        <th>评论时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($comment = mysqli_fetch_array($res_comments)) {
                    ?>
                    <tr>
                        <td><?php echo $comment["content"]; ?></td>
                        <td><a href="blog_article.php?blog_id=<?php echo $comment["blog_id"]; ?>"><?php echo $comment["title"]; ?></a></td>
                        <td><?php echo $comment["username"]; ?></td>
                        <td><?php echo $comment["comtime"]; ?></td>
                        <td>
                            <div class="comment_actions">
                                <form name="comment" action="./manager_comment_sql.php" method="POST">
                                    <input type="submit" name="submit" class="button" value="删除" />
                                    <input type="hidden" name="comment_id" value="<?php echo $comment["id"]; ?>" />
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="height: 50px;"></div>
    <?php require("./footer.php"); ?>
</body>
</html>