<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/library.js"></script>
    <script type="text/javascript">
        function formValid(form)
        {
            with (form)
            {
                if (!strValid(user.value))
                {
                    alert("请输入用户名！");
                    user.focus();
                    return false;
                }
                if (!strValid(pswd.value))
                {
                    alert("请输入密码！");
                    pswd.focus();
                    return false;
                }
            }
            return true;
        }
    </script>
    
    <?php
        if (isset($_POST['submit']))
        {
    ?>
        <script type="text/javascript">
            var t = 4;
            
            function timeCount()
            {
                --t;
                if (t > 0)
                {
                    document.getElementById("time").innerHTML = t;
                    setTimeout("timeCount()", 1000);
                }
                else
                {
                    window.location.assign("index.php");
                }
            }
            
            setTimeout("timeCount()", 0);
        </script>
    <?php
        }
    ?>
</head>

<body>
    <?php
            echo $_POST['submit'];
            echo $_POST['user'];
            echo $_POST['pswd'];
        if (isset($_POST['submit']))
        {
    ?>
        <?php 
            $username = $_POST['user'];
            $password = $_POST['pswd'];
        
            include 'useMySQL.php';
        
            $sql = "SELECT sid, password, salt FROM user WHERE account = '{$username}'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $md5pswd = md5($username . $password . $row['salt']);
            if ($row['password'] == $md5pswd)
            {
                $_SESSION['sid'] = $row['sid'];
                $_SESSION['user'] = $username;
        ?>
            <div>
                登陆成功!
            </div>
            
            <div>
                <span id="time">
                </span>
                <span>
                    秒后自动跳转到登陆前页面!
                </span>
            </div>
        <?php
            }
            else
            {
                $login_error = 1;
            }
        
            include 'closeMySQL.php';
        ?>
    <?php
        }
    ?>
        
    <?php
        if (!isset($_POST['submit']) || isset($login_error))
        {
    ?>
        <div class="middle">
            <div class="middle_top">
                <div class="middle_top_left">
                    <img src="images/wiscom_15.jpg" />
                 </div>
                <div class="middle_top_right">
                    <img src="images/wiscom_05.jpg" />
                 </div>
            </div>
            <div class="middle_mid">
                <div class="middle_mid_1">
                    <img src="images/wiscom_07.jpg" />
                </div>
                <div class="middle_mid_2">
                    <img src="images/wiscom_08.jpg" />
                </div>
                <div class="middle_mid_3">
                    <form id="login_form" name="input" action="login.php" onsubmit="return formValid(this)" method="post">
                        <input class="user_input" type="text" name="user" value="<?php if (isset($_POST['user'])) {echo $_POST['user'];} ?>" />
                        <input class="pswd_input" type="password" id="pswd" name="pswd" />
                        
<!--
                        <?php
                            if (isset($login_error))
                            {
                        ?>
                            <div class="login_error">
                                帐号或密码错误
                            </div>
                            
                            <script type="text/javascript">
                                this.pswd.focus();
                            </script>
                        <?php
                            }
                        ?>
-->
                        
<!--                        <input class="submit" type="submit" name="submit" value="登  陆" />-->
<!--                        <input type="button" name="submit" value="submit" />-->
                        <script type="text/javascript">
                            function defaultSubmit()
                            {
                                with (document.getElementById("login_form"))
                                {
                                        alert(document.getElementById("login_form").submit());
                                    if (onsubmit())
                                    {
                                        action = "login.php";
                                        method = "post";
                                        submit();
                                    }
                                }
                            }
                        </script>
                        <img src="images/wiscom_login.jpg" onclick="defaultSubmit()" />
                        
                        <div class="hint">
                            没有帐号?
                            <a href="register.php">
                                注册
                            </a>
                        </div>
                    </form>
                </div>
                <div class="middle_mid_4">
                    <img src="images/wiscom_10.jpg" />
                </div>
            </div>
<!--
            <div class="login">
                <form name="input" action="login.php" onsubmit="return formValid(this)" method="post">
                    <div class="login_div">
                        Username:
                        <input type="text" name="user" value="<?php if (isset($_POST['user'])) {echo $_POST['user'];} ?>" />
                    </div>
                    
                    <div class="login_div">
                        Password:
                        <input type="password" id="pswd" name="pswd" />
                    </div>
                    
                    <?php
                        if (isset($login_error))
                        {
                    ?>
                        <div class="login_error">
                            帐号或密码错误
                        </div>
                        
                        <script type="text/javascript">
                            this.pswd.focus();
                        </script>
                    <?php
                        }
                    ?>
                    
                    <input class="submit" type="submit" name="submit" value="登  陆" />
                    
                    <div class="hint">
                        没有帐号?
                        <a href="register.php">
                            注册
                        </a>
                    </div>
                </form>
            </div>
-->
        </div>
    <?php
        }
    ?>
</body>
</html>