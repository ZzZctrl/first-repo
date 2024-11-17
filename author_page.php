<?php
// 启动会话
session_start();

// 连接数据库
include("./dbConfig.php");
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

// 获取作者信息
$author = $_GET['author'];
$authorSql = "SELECT * FROM adminuser WHERE regname = '$author'";
$authorResult = mysqli_query($link, $authorSql);
$authorInfo = mysqli_fetch_assoc($authorResult);

// 获取作者发布的博客数量
$blogSql = "SELECT COUNT(*) AS blog_count FROM article WHERE author = '$author' and is_deleted=0";
$blogResult = mysqli_query($link, $blogSql);
$blogCount = mysqli_fetch_assoc($blogResult)['blog_count'];

// 获取作者的评论数量
$commentSql = "SELECT COUNT(*) AS comment_count FROM comment WHERE username = '$author' and is_deleted=0";
$commentResult = mysqli_query($link, $commentSql);
$commentCount = mysqli_fetch_assoc($commentResult)['comment_count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $authorInfo['regname']; ?>的主页</title>
    <link rel="stylesheet" type="text/css" href="./css/author_page.css">
</head>
<body>
    <div class="author-container">
        <div class="return-btn-container">
            <a href="javascript:history.go(-1);" class="return-btn">返回</a>
        </div>
        <div class="author-board">
            <div class="author-profile-box">
                <div class="author-avatar-box">
                    <img src="<?php echo './touxiang/' . $authorInfo['avatar']; ?>" alt="<?php echo $authorInfo['regname']; ?>" class="author-avatar">
                </div>
                <div class="author-info-box">
                    <h2 class="author-name"><?php echo $authorInfo['regname']; ?></h2>
                    <p class="author-signature"><?php echo $authorInfo['signature']; ?></p>
                    <p class="author-details">性别: <?php echo $authorInfo['regsex']; ?></p>
                    <p class="author-details">生日: <?php echo $authorInfo['birthday']; ?></p>
                    <p class="author-details">邮箱: <?php echo $authorInfo['regemail']; ?></p>
                    <p class="author-details">博客数量: <?php echo $blogCount; ?></p>
                    <p class="author-details">评论数量: <?php echo $commentCount; ?></p>
                </div>
            </div>
            <div class="author-blog-box">
                <h2 class="author-title"><?php echo $authorInfo['regname']; ?>的最新博文</h2>
                <?php
                $blogSql = "SELECT * FROM article WHERE author = '$author' AND is_deleted = 0 ORDER BY pubtime DESC LIMIT 5";
                $blogResult = mysqli_query($link, $blogSql);

                if (mysqli_num_rows($blogResult) > 0) {
                    echo "<div class='author-blog-list'>";
                    while ($row = mysqli_fetch_assoc($blogResult)) {
                        echo "<div class='author-blog-item'>";
                        echo "<div class='cover'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' class='blog-cover-link'>";
                        echo "<img src='./uploads/" . $row['picture'] . "' alt='" . $row['title'] . "' class='author-image'>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class='inner-new'>";
                        echo "<header class='header-new'>";
                        echo "<h2 class='title-new'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' class='blog-title-link'>" . $row['title'] . "</a>";
                        echo "</h2>";
                        echo "</header>";
                        echo "<div class='content-new'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' class='blog-content-link'>";
                        echo "<p>";
                        if (strlen($row['content']) > 60) {
                            echo mb_substr($row['content'], 0, 60, 'UTF-8') . "...";
                        } else {
                            echo $row['content'];
                        }
                        echo "</p>";
                        echo "</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='meta-new'>";
                        echo "<span class='pull-left'>";
                        echo "<a class='release-date'>" . '发布时间：' . mb_substr($row['pubtime'], 0, 10, 'UTF-8') . "</a>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "#comments' class='comments'>";
                        $comsql = 'select * from comment where fileid = ' . $row["id"] . ' and is_deleted = 0 order by comtime desc;';
                        $com_res = mysqli_query($link, $comsql);
                        $com_num = mysqli_num_rows($com_res);
                        echo "$com_num" . " 条评论";
                        echo "</a>";
                        
                        echo "</span>";
                        echo "<span class='pull-right'>";
                        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' title='阅读全文' class='read-more-link'>阅读全文</a>";
                        echo "</span>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='no-blogs'>{$authorInfo['regname']}还没有发布任何博客文章。</div>";
                }

                // 关闭数据库连接
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</body>
</html>