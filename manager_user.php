<!--针对超级管理员管理所有用户-->
<head>
    <link rel="stylesheet" type="text/css" href="./css/manager_user.css">
</head>
<?php
require "dbConfig.php";
require "login_session_check.php";
require "./header.php";
// 连接mysql
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("ERROR: CANNOT CONNECT TO DATABASE!");
// 编码设置
mysqli_set_charset('utf8',$link);
$user_name = $_SESSION["user_name"]; // 超级管理员姓名

$get_users_sql = "select * from adminuser where fig <> 1 AND islock <> 1";
$res_users = mysqli_query($link,$get_users_sql);
$num_users = mysqli_num_rows($res_users); // 用户数量
?>

<div class="users_table_wrapper">
    <div class="users_table">
        <div class="user_title">
            <h2 style="text-align: center;"><?php echo "本系统共有".$num_users."名用户注册账户"."<br/>"; ?></h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>用户姓名</th>
                    <th>用户 QQ</th>
                    <th style="width: 20%;">用户邮箱</th>
                    <th>用户性别</th>
                    <th style="width: 15%;">用户生日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($user=mysqli_fetch_array($res_users)) { // 找出所有注册用户
                ?>
                <tr>
                    <td><a href="./author_page.php?author=<?php echo $user["regname"]; ?>" class="user-name"><?php echo $user["regname"]; ?></a></td>
                    <td><?php echo $user["regqq"]; ?></td>
                    <td style="width: 20%;"><?php echo $user["regemail"]; ?></td>
                    <td><?php echo $user["regsex"]; ?></td>
                    <td style="width: 15%;"><?php echo $user["birthday"]; ?></td>
                    <td>
                        <div class="user_actions">
                            <form name="user" action="./user_edit_page.php" method="POST"> <!--编辑用户-->
                                <input type="submit" name="submit" class="button" value="编辑" />
                                <input type="hidden" name="user_id" value="<?php echo $user["regid"]; ?>" />
                            </form>
                            <form name="user" action="./delete_user_sql.php" method="POST"> <!--删除用户-->
                                <input type="submit" name="submit" class="button" value="删除" />
                                <input type="hidden" name="user_id" value="<?php echo $user["regid"]; ?>" />
                            </form>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php require("./footer.php"); ?>