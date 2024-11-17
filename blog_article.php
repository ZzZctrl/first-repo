<?php
// 展现用户发布博文页面
require "dbConfig.php";
require("./header.php");

// 连接mysql
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
// 编码设置
mysqli_set_charset('utf8', $link);

$get_all_sql = "select * from article";         // 选择所有的博文
$res_articles = mysqli_query($link, $get_all_sql);
$num_article = mysqli_num_rows($res_articles);

$blog_id = intval($_GET["blog_id"]);          // 查看博文id
if (empty($blog_id) || $blog_id > $num_article) {
    header("location:./blog_article.php?blog_id=1");
    exit();
}

$get_one_sql = "select a.*, t.type_name from article a 
                LEFT JOIN article_type t ON a.type_id = t.type_id
                where a.id = $blog_id"; // 获取文章
$res_one_article = mysqli_query($link, $get_one_sql);
$article_info = mysqli_fetch_array($res_one_article);
$blog_author = $article_info["author"]; // 文章作者
$picture_path = "./uploads/" . $article_info["picture"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>文章内容</title>
    <link rel="stylesheet" type="text/css" href="./css/blog_article.css">
</head>
<body>
    <div class="bg">
        <div class="bloginfo">
            <div class="article_title">
                <div class="title-container">
                    <h2><?php echo $article_info['title']; ?></h2>
                </div>
                <div class="return-btn-container">
                        <a href="javascript:history.go(-1);" class="return-btn">返回</a>
                    </div>
                <div class="author_time">
                    <?php
                    echo '<a>发布时间：' . $article_info['pubtime'] . '</a>';
                    echo '<a>作者：<a href="./author_page.php?username=' . $article_info["author"] . '">' . $article_info["author"] . '</a></a>';
                    echo '<a>类别：' . $article_info["type_name"] . '</a>';
                    ?>
                </div>
                <img src="<?php echo $picture_path; ?>" alt="<?php echo $article_info['title']; ?>" class="article-image">
                <p><?php echo $article_info['content']; ?></p>
            </div>
        </div>
    </div>
    <?php include("./comment.php") ?>
    <?php require("./footer.php"); ?>
</body>
</html>