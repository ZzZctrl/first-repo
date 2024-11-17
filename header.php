<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>博客系统</title>
    <link rel="stylesheet" type="text/css" href="./css/header.css">
</head>
<?php 
    @session_start();
?>
<body>
    <div class="main-header">
        <div class="container">
            <div class="navigation">
                <div class="info">
                    <nav class="menu">
                        <ul class="menu-one">
                            <li><a href="./main.php">首页</a></li>
                            <?php
                                if (!empty($_SESSION["user_name"])) { # 如果用户已登录,则显示个人中心与退出按钮
                                    echo "<li><a href='./user_center.php'>个人中心</a></li>";
                                    echo "<li><a href='./user_exit_sql.php'>退出</a></li>";
                                }
                                else { # 如果用户未登录,则显示登录与注册按钮
                                    echo "<li><a href='./login.php'>登录</a></li>";
                                    echo "<li><a href='./sign.php'>注册</a></li>";
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
                
                <div class="search-container">
                    <form action="search.php" method="GET" class="search-form">
                        <input type="text" name="keyword" placeholder="搜索博客..." required class="search-input">
                        <button type="submit" class="search-button">搜索</button>
                    </form>
                </div>

                <div class="content">
                    <h2>行云流水账</h2>
                    <h3>云水之间,心随景动</h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>