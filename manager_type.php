<?php
require "dbConfig.php";
require "login_session_check.php";
require "./header.php";

// 连接数据库
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

// 添加分类
if (isset($_POST['add_type'])) {
    $type_name = $_POST['type_name'];
    $add_type_sql = "INSERT INTO article_type (type_name) VALUES ('$type_name')";
    $res_add_type = mysqli_query($link, $add_type_sql);
    if ($res_add_type) {
        echo "<script>alert('添加分类成功!');</script>";
    } else {
        echo "<script>alert('添加分类失败!');</script>";
    }
}

// 删除分类
if (isset($_POST['delete_type'])) {
    $type_id = $_POST['type_id'];
    $delete_type_sql = "DELETE FROM article_type WHERE type_id = $type_id";
    $res_delete_type = mysqli_query($link, $delete_type_sql);
    if ($res_delete_type) {
        echo "<script>alert('删除分类成功!');</script>";
    } else {
        echo "<script>alert('删除分类失败!');</script>";
    }
}

// 获取所有分类
$get_types_sql = "SELECT * FROM article_type";
$res_types = mysqli_query($link, $get_types_sql);
$num_types = mysqli_num_rows($res_types);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>分类管理</title>
    <link rel="stylesheet" href="./css/manager_type.css">
</head>
<body>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>分类编号</th>
                    <th>分类名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($type = mysqli_fetch_array($res_types)) {
                ?>
                <tr>
                    <td><?php echo $type["type_id"]; ?></td>
                    <td><?php echo $type["type_name"]; ?></td>
                    <td>
                        <div class="actions">
                            <form name="delete_type" action="./manager_type.php" method="POST">
                                <input type="hidden" name="type_id" value="<?php echo $type["type_id"]; ?>">
                                <button type="submit" name="delete_type">删除</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="add-form">
        <form name="add_type" action="./manager_type.php" method="POST">
            <input type="text" name="type_name" placeholder="请输入新的分类名称" required>
            <button type="submit" name="add_type">添加</button>
        </form>
    </div>

    <?php require("./footer.php"); ?>
</body>
</html>