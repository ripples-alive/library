<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
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
        if (isset($_POST['submit']))
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
                
                $sql = "SELECT sid FROM user WHERE account = '{$username}'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION['sid'] = $row['sid'];
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
        <div class="register">
            <div>
                欢迎加入图书馆!
            </div>
            <form name="register" action="register.php" onsubmit="return formValid(this)" method="post">
                <div class="register_div">
                    用户名：
                    <input type="text" name="user" value="<?php if (isset($_POST['user'])) {echo $_POST['user'];} ?>" />
                </div>
                
                <div class="register_div">
                    密码:
                    <input type="password" id="pswd" name="pswd" />
                </div>
                
                <div class="register_div">
                    确认密码:
                    <input type="password" id="pswdConfirm" name="pswdConfirm" />
                </div>
                
                <div class="register_div">
                    真实姓名:
                    <input type="text" id="realname" name="realname" />
                </div>
                
                <div class="register_div">
                    邮箱:
                    <input type="text" id="email" name="email" />
                </div>
                
                <?php
                    if (isset($login_error))
                    {
                ?>
                    <div class="register_error">
                        注册失败
                    </div>
                    
                    <script type="text/javascript">
                        this.pswd.focus();
                    </script>
                <?php
                    }
                ?>
                
                <input type="submit" class="submit" name="submit" value="注  册" />
                
                <div class="hint">
                    已有帐号?
                    <a href="login.php">
                        登陆
                    </a>
                </div>
            </form>
        </div>
    <?php
        }
    ?>
</body>
</html>