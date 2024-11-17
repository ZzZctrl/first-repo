<?php
    require "dbConfig.php";
    require "./header.php";
    // 连接mysql
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    // 编码设置
    mysqli_set_charset('utf8',$link);

    $sql = "SELECT * FROM article WHERE is_deleted = 0 ORDER BY pubtime DESC LIMIT 0,5"; // 只展示 is_deleted = 0 的博文
    $result = mysqli_query($link,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
</head>
<body>
    <div class="main_content">
        <div class="new_blog">
            <?php
            while ($new_blog=mysqli_fetch_array($result)) {
            ?>
            <div class="main-main">
                <div class="new-blog">
                    <div class="cover">
                        <?php echo "<a href='./blog_article.php?blog_id=".$new_blog["id"]." ' >" ?>
                        <img src="./uploads/<?php echo $new_blog["picture"]; ?>"
                             alt='<?php echo $new_blog["title"] ?>'  height="100%;"/>
                        </a>
                    </div>
                    <div class="inner-new">
                        <header class="header-new">
                            <h2 class="title-new">
                                <?php echo "<a href='./blog_article.php?blog_id=".$new_blog["id"]." ' >"; ?>
                                <?php echo $new_blog['title'] ?>
                                </a>
                            </h2>
                        </header>
                    <div class="content-new">
                        <?php echo "<a href='./blog_article.php?blog_id=".$new_blog["id"]." ' >"; ?>
                        <p> <!-- 限制输出内容 -->
                            <?php
                            if (strlen($new_blog['content'])>60) {
                                echo mb_substr($new_blog['content'],0,60,'UTF-8')."...";
                            }
                            else { echo $new_blog['content']; }
                            ?>
                        </p>
                        </a>
                    </div>
                    </div>
                <div class="meta-new">
                    <span class="pull-left">
                        <a class="release-date">
                            <?php echo '发布时间：'.mb_substr($new_blog['pubtime'],0,10,'UTF-8').''; ?>
                        </a>
                    <a href="./#comments" class="comments">
                        <?php echo "<a href='./blog_article.php?blog_id=".$new_blog["id"]."#comments ' >"; ?>
                        <?php
                        // 按提交时间找到对应博文的id
                        $comsql='select * from comment where fileid = '.$new_blog["id"].' and is_deleted = 0 order by comtime desc;';
                        $com_res=mysqli_query($link,$comsql);
                        $com_num=mysqli_num_rows($com_res);
                        echo "$com_num"." 条评论";
                        ?>
                    </a>
                    <a href=" " class="user">
                        <?php echo '作者：'.$new_blog["author"].''; ?>
                    </a>
                </span>
                <span class="pull-right">
                    <?php echo "<a  href='./blog_article.php?blog_id=".$new_blog["id"]." ' title='阅读全文'' >"; ?>
                        阅读全文
                    </a>
                </span>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="bottom"></div>
</div>
</body>
<?php require("./footer.php"); ?>
</html>