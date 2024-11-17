<?php
    // 处理用户登录页面
    require "dbConfig.php";
    // 连接mysql
    $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
    // 编码设置
    mysqli_set_charset('utf8',$link);

    // 取提交的数据
    $name = $_POST["user_name"];                        // 用户姓名
    $pwd = $_POST["user_pwd"];                          // 用户密码

    $sql = "select * from adminuser where regname = '$name'";
    $result = mysqli_query($link,$sql);

    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        if ($row['islock'] == 1) { // 用户被锁定
            echo "<script type='text/javascript'>";
            echo "alert('用户有问题,请联系管理员');";
            echo "location.href='login.php';";
            echo "</script>";
        } elseif ($pwd == $row['regpwd']) { // 判断密码是否正确
            // 登陆后修改登录状态
            $sql = "update adminuser 
            set islock = 1
            where regname = '$name';";
            mysqli_query($link, $sql);

            @session_start();
            $_SESSION["user_name"] = $name;

            echo "<script type='text/javascript'>";
            echo "alert('登录成功');";
            // 用户中心界面
            echo "location.href='user_center.php';";
            echo "</script>";
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('密码不正确');";
            echo "location.href='login.php';";
            echo "</script>";
        }
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('用户名不正确');";
        echo "location.href='login.php';";
        echo "</script>";
    }

mysqli_free_result($result);
mysqli_close($link);
?>