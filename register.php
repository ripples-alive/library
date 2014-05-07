<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
    <link href="css/register.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/library.js"></script>
    <script type="text/javascript">
        function formValid(form)
        {
            with (form)
            {
                if (!strValid(user.value))
                {
                    alert("用户名不合法！");
                    user.focus();
                    return false;
                }
                if (!strValid(pswd.value))
                {
                    alert("密码不合法！");
                    pswd.focus();
                    return false;
                }
                if (pswd.value != pswdConfirm.value)
                {
                    alert("两次密码不一致！");
                    pswd.focus();
                    return false;
                }
            }
            return true;
        }
    </script>
    
    <?php
        if (isset($_POST['submitRegister']))
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

<body onload="document.getElementById('user_input').focus()">
    <?php
        if (isset($_POST['submitRegister']))
        {
    ?>
        <?php
            $username = $_POST['user'];
            $password = $_POST['pswd'];
        
            include 'useMySQL.php';
        
            $sql = "SELECT sid FROM user WHERE account = '{$username}'";
            $result = $db->query($sql);
            if ($result->num_rows == 0)
            {
                $salt = date('Y-m-d H:i:s');
                $md5pswd = md5($username . $password . $salt);
                
                $sql = "UPDATE power SET cnt = cnt + 1 WhERE level = 0";
                $db->query($sql);
                
                $sql = "SELECT cnt FROM power WHERE level = 0";
                $sql = "CONCAT('s', LPAD(({$sql}), 4, 0))";
                $sql = "INSERT INTO user VALUES ({$sql}, '{$username}', '{$md5pswd}', '{$salt}', null, '{$_POST['realname']}', '{$_POST['email']}', 0, 0)";
                $db->query($sql);
                
                $sql = "SELECT sid, level FROM user WHERE account = '{$username}'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION['sid'] = $row['sid'];
                $_SESSION['user'] = $username;
                $_SESSION['level'] = $row['level'];
        ?>
            <div class="register_hint">
                <div>
                    登陆成功!
                </div>
                
                <div>
                    <span id="time">
                    </span>
                    <span>
                        秒后自动跳转到首页!
                    </span>
                </div>
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
        if (!isset($_POST['submitRegister']) || isset($login_error))
        {
    ?>
        <div class="middle">
            <div class="middle_left">
                <img src="images/bg_01.gif" />
            </div>
            <div class="middle_mid">
                <div class="middle_mid_up">
                    <img src="images/wiscom_05.jpg" />
                </div>
                <div class="middle_mid_down">
                    <form name="register" action="register.php" onsubmit="return formValid(this)" method="post">
                        <input id="user_input" class="user_input" type="text" name="user" value="<?php if (isset($_POST['user'])) {echo $_POST['user'];} ?>" />
                        <input class="pswd_input" type="password" id="pswd" name="pswd" />
                        <input class="pswd_input" type="password" id="pswdConfirm" name="pswdConfirm" />
                        <input class="name_input" type="text" id="realname" name="realname" />
                        <input class="mail_input" type="text" id="email" name="email" />
                        
                        <div class="register_error">
                            <?php
                                if (isset($login_error))
                                {
                            ?>
                                注册失败
                                
                                <script type="text/javascript">
                                    this.pswd.focus();
                                </script>
                            <?php
                                }
                            ?>
                        </div>
                        
                        <input type="submit" class="submit" name="submitRegister" value="" />
                        
                        <div class="hint">
                            已有帐号?
                            <a href="login.php">
                                登陆
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="middle_right">
                <img src="images/wiscom_10.jpg" />
            </div>
        </div>
    <?php
        }
    ?>
</body>
</html>