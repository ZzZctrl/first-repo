<?php
// 查询该用户发布的最新博文
$sql = "SELECT * FROM article WHERE author = '{$_SESSION['user_name']}' AND is_deleted = 0 ORDER BY pubtime DESC LIMIT 5";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // 输出博文列表
    echo "<div class='home-blog-list'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='home-blog-item'>";
        echo "<div class='cover'>";
        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' class='blog-cover-link'>";
        echo "<img src='./uploads/" . $row['picture'] . "' alt='" . $row['title'] . "' class='home-image'>";
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
        echo "<a href=' ' class='user'>" . '作者：' . $row["author"] . "</a>";
        echo "</span>";
        echo "<span class='pull-right'>";
        echo "<a href='./blog_article.php?blog_id=" . $row['id'] . "' title='阅读全文' class='read-more-link'>阅读全文</a>";
        echo "</span>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='no-blogs'>您还没有发布任何博客文章。</div>";
}

// 关闭数据库连接
mysqli_close($link);