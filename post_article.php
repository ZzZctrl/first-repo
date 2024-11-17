<?php 
    require("./login_session_check.php");
    require("./header.php");
    require("./dbConfig.php");

    // 连接数据库
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    mysqli_set_charset('utf8', $link);

    // 获取所有分类
    $get_types_sql = "SELECT * FROM article_type";
    $res_types = mysqli_query($link, $get_types_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>博文发布</title>
     <link rel="stylesheet" type="text/css" href="./css/post_article.css">
</head>
    <div class="post_bg">
        <div class="post_fix"></div>
        <div class="post_art_main">
            <div class="return-btn-container">
            <a href="./user_center.php" class="return-btn">返回</a>
            </div>
            <h2>博文发布</h2>
            <div class="post_form">
                <form action="./post_article_sql.php" method="post" enctype="multipart/form-data">
                    <div class="province">
                        <select name="type_id" >
                            <?php while ($type = mysqli_fetch_array($res_types)) { ?>
                                <option value="<?php echo $type['type_id']; ?>"><?php echo $type['type_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input placeholder="文章标题" required="required" type="text" name="title"><br/>
                    <textarea placeholder="来吧展示" required="required" name="content"></textarea>
                    <input type="file" name="picture" accept="image/*" required>
                    <div class="btnn">
                        <input type="submit" name="submit" value="发布">
                    </div>
                </form> 
            </div>
        </div>
        <div class="post_fix"></div>
    </div>
    <?php require("./footer.php"); ?>
</html>