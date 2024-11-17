<?php
// 启动会话
session_start();

// 连接数据库
include("./dbConfig.php");
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
mysqli_set_charset('utf8', $link);

// 获取用户信息
$userSql = "SELECT * FROM adminuser WHERE regname = '{$_SESSION['user_name']}'";
$userResult = mysqli_query($link, $userSql);
$userInfo = mysqli_fetch_assoc($userResult);

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regname = $_POST['regname'];
    $regemail = $_POST['regemail'];
    $regsex = $_POST['regsex'];
    $birthday = $_POST['birthday'];
    $signature = $_POST['signature'];

    // 处理头像上传
    $avatar = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $avatar_dir = './touxiang/';
    if (!empty($avatar)) {
        move_uploaded_file($avatar_tmp, $avatar_dir . $avatar);
    } else {
        $avatar = $userInfo['avatar'];
    }

    $updateSql = "UPDATE adminuser SET regemail = '$regemail', regsex = '$regsex', birthday = '$birthday', signature = '$signature', avatar = '$avatar' WHERE regname = '{$_SESSION['user_name']}'";
    mysqli_query($link, $updateSql);

    header("Location: ./home_page.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>个人信息编辑</title>
    <link rel="stylesheet" type="text/css" href="./css/edit_info.css">
</head>
<body>
    <div class="edit-info-container">
        <div class="edit-info-board">
            <h2 class="edit-info-title">个人信息编辑</h2>
            <form method="post" class="edit-info-form" enctype="multipart/form-data">
                <label for="regname" class="edit-info-label">用户名:</label>
                <input type="text" id="regname" name="regname" value="<?php echo $userInfo['regname']; ?>" disabled>

                <label for="regemail" class="edit-info-label">邮箱:</label>
                <input type="email" id="regemail" name="regemail" value="<?php echo $userInfo['regemail']; ?>">

                <label for="regsex" class="edit-info-label">性别:</label>
                <select id="regsex" name="regsex">
                    <option value="男" <?php if ($userInfo['regsex'] == '男') echo 'selected'; ?>>男</option>
                    <option value="女" <?php if ($userInfo['regsex'] == '女') echo 'selected'; ?>>女</option>
                </select>

                <label for="birthday" class="edit-info-label">生日:</label>
                <input type="date" id="birthday" name="birthday" value="<?php echo $userInfo['birthday']; ?>">

                <label for="signature" class="edit-info-label">个性签名:</label>
                <textarea id="signature" name="signature"><?php echo $userInfo['signature']; ?></textarea>

                <label for="avatar" class="edit-info-label">头像:</label>
                <input type="file" id="avatar" name="avatar">

                <div class="edit-info-buttons">
                    <button type="submit" class="edit-info-submit">保存</button>
                    <a href="./home_page.php" class="edit-info-cancel">取消</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>