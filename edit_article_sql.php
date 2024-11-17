<?php
    // 处理用户编辑博文页面
    require("./login_session_check.php");
    require "dbConfig.php";
    // 连接mysql
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    // 编码设置
    mysqli_set_charset('utf8',$link);

    @session_start();
    $blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $type_id = mysqli_real_escape_string($link, strval($_POST['type_id']));
    $content = mysqli_real_escape_string($link, $_POST['content']);
    $author = $_SESSION['user_name'];

    // 处理上传图片
    $picture_name = $_FILES['picture']['name'];
    if (!empty($picture_name)) {
        $picture_tmp = $_FILES['picture']['tmp_name'];
        $picture_path = "./uploads/" . $picture_name;
        if (move_uploaded_file($picture_tmp, $picture_path)) {
            $sql = "UPDATE article SET type_id = '$type_id', title = '$title', content = '$content', picture = '$picture_name' WHERE id = $blog_id AND author = '$author'";
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('上传图片失败!');";
            echo "location.href='./edit_article.php?id=$blog_id';";
            echo "</script>";
            exit();
        }
    } else {
        $sql = "UPDATE article SET type_id = '$type_id', title = '$title', content = '$content' WHERE id = $blog_id AND author = '$author'";
    }

    $res = mysqli_query($link, $sql);
    if ($res) {
        echo "<script type='text/javascript'>";
        echo "alert('编辑成功!');";
        echo "location.href='./user_center.php';";
        echo "</script>";
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('编辑失败!');";
        echo "location.href='./edit_article.php?id=$blog_id';";
        echo "</script>";
        exit();
    }
?>