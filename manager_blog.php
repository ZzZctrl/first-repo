<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>博客管理</title>
    <link rel="stylesheet" href="./css/manager_blog.css">
</head>
<body>
    <?php
    require "dbConfig.php";
    require "login_session_check.php";
    require "./header.php";

    // 连接数据库
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    mysqli_set_charset('utf8', $link);

    $get_blogs_sql = "SELECT id, title, content, pubtime 
                      FROM article 
                      WHERE is_deleted = 0
                      ORDER BY pubtime DESC";
    $res_blogs = mysqli_query($link, $get_blogs_sql);
    $num_blogs = mysqli_num_rows($res_blogs);
    ?>

    <div class="blog_table_wrapper">
        <div class="blog_table">
            <div class="blog_title">
                <h2 style="text-align: center;"><?php echo "本系统共有" . $num_blogs . "篇博客" . "<br/>"; ?></h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>博客标题</th>
                        <th>博客内容</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($blog = mysqli_fetch_array($res_blogs)) {
                        // 限制博客内容的词数显示, 最多100个词
                        $content_words = str_word_count($blog["content"], 0);
                        $content_display = $content_words > 100 ? substr($blog["content"], 0, 100) . "..." : $blog["content"];
                    ?>
                    <tr>
                        <td><a href="blog_article.php?blog_id=<?php echo $blog["id"]; ?>"><?php echo $blog["title"]; ?></a></td>
                        <td><?php echo $content_display; ?></td>
                        <td><?php echo $blog["pubtime"]; ?></td>
                        <td>
                            <div class="blog_actions">
                                <form name="blog" action="./delete_blog_sql.php" method="POST">
                                    <input type="submit" name="submit" class="button" value="删除" />
                                    <input type="hidden" name="blog_id" value="<?php echo $blog["id"]; ?>" />
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