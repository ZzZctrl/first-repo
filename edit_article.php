<?php 
    require("./login_session_check.php");
    require("./header.php");

    // 获取要编辑的博客ID
    $blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // 从数据库查询博客内容
    require "dbConfig.php";
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    mysqli_set_charset('utf8',$link);

    $sql = "SELECT * FROM article WHERE id = $blog_id AND author = '{$_SESSION['user_name']}'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script type='text/javascript'>";
        echo "alert('无法编辑该博客!');";
        echo "location.href='./user_center.php';";
        echo "</script>";
        exit();
    }

    $title = $row['title'];
    $type_id = $row['type_id'];
    $content = $row['content'];
    $picture = $row['picture'];

    // 从数据库查询所有分类
    $get_types_sql = "SELECT * FROM article_type";
    $res_types = mysqli_query($link, $get_types_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>编辑博文</title>
    <link rel="stylesheet" type="text/css" href="./css/post_article.css">
</head>
<body>
    <div class="post_bg">
        <div class="post_fix"></div>
        <div class="post_art_main">
            <h2>编辑博文</h2>
            <div class="post_form">
                <form action="./edit_article_sql.php?id=<?php echo $blog_id; ?>" method="post" enctype="multipart/form-data">
                    <div class="province">
                        <select name="type_id" >
                            <?php while ($type = mysqli_fetch_array($res_types)) { ?>
                                <option value="<?php echo $type['type_id']; ?>" <?php echo $type_id == $type['type_id'] ? 'selected="selected"' : ''; ?>><?php echo $type['type_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input placeholder="文章标题" required="required" type="text" name="title" value="<?php echo $title; ?>"><br/>
                    <textarea placeholder="来吧展示" required="required" name="content"><?php echo $content; ?></textarea>
                    <input type="file" name="picture" accept="image/*">
                    <p>当前封面图片: <img src="./uploads/<?php echo $picture; ?>" alt="封面图片" width="100"></p>
                    <div class="btnn">
                        <input type="submit" name="submit" value="保存">
                        <a href="./my_blog.php" class="btn-cancel">取消</a>
                    </div>
                </form> 
            </div>
        </div>
        <div class="post_fix"></div>
    </div>
    <?php require("./footer.php"); ?>
</body>
</html>