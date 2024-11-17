<?php
    // 处理用户注册页面
    require "dbConfig.php";
    // 连接 MySQL 数据库
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    // 设置编码为 UTF-8
    mysqli_set_charset('utf8', $link);

    // 1. 获取表单提交的数据
    $regname = $_POST["user_name"];      // 用户名
    $regemail = $_POST['user_email'];    // 用户邮箱
    $regpwd = $_POST['user_pwd'];        // 用户密码
    $rereqpwd = $_POST['reuser_pwd'];    // 确认密码
    $regsex = $_POST['user_sex'];        // 用户性别
    $regqq = $_POST['user_qq'];          // 用户QQ

    // 2. 检查用户名是否已经存在
    $check_sql = "SELECT * FROM adminuser WHERE regname = '$regname'";
    $check_res = mysqli_query($link, $check_sql);
    $row_user = mysqli_num_rows($check_res);

    if ($row_user > 0) {                  // 用户名已存在
        echo "<script type='text/javascript'>";
        echo "alert('用户名已存在');";
        echo "location.href='sign.php';";
        echo "</script>";
        exit;
    }

    // 3. 检查两次输入的密码是否一致
    if ($regpwd !== $rereqpwd) {         // 密码不一致
        echo "<script type='text/javascript'>";
        echo "alert('两次输入密码不一致！');";
        echo "location.href='sign.php';";
        echo "</script>";
        exit;
    }


    // 5. 插入用户数据到数据库
    $sign_sql = "INSERT INTO adminuser (regname, regpwd, regemail, regsex, regqq, islock, fig)
         VALUES ('$regname', '$regpwd', '$regemail', '$regsex', '$regqq', 0, 0)";

    $sign = mysqli_query($link, $sign_sql);
    if ($sign) {
        echo "<script type='text/javascript'>";
        echo "alert('注册成功');";
        echo "location.href='login.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('注册失败');";
        echo "location.href='sign.php';";
        echo "</script>";
    }

    // 6. 关闭数据库连接
    mysqli_close($link);
?>