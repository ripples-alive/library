<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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
</head>
    
<body>
    <?php
        include "top.php";
    ?>
    
    <?php
        if (!isset($_SESSION['level']) || ($_SESSION['level'] <= 1))
        {
            die('没有权限！');
        }
    ?>
    
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
                
                $sql = "UPDATE power SET cnt = cnt + 1 WhERE level = {$_POST['type']}";
                $db->query($sql);
                
                $sql = "SELECT cnt FROM power WHERE level = {$_POST['type']}";
                if ($_POST['type'] == '1')
                {
                    $sql = "CONCAT('b', LPAD(({$sql}), 4, 0))";
                }
                else
                {
                    $sql = "CONCAT('a', LPAD(({$sql}), 4, 0))";
                }
                $sql = "INSERT INTO user VALUES ({$sql}, '{$username}', '{$md5pswd}', '{$salt}', null, '{$_POST['realname']}', '{$_POST['email']}', 0, {$_POST['type']})";
                $db->query($sql);
        ?>
            <script type="text/javascript">
                alert('分配成功！');
            </script>
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
    
    <div class="all">
        <form name="register" action="assign.php" onsubmit="return formValid(this)" method="post">
            <div class="union assignunion">
                <div class="describe assigndes">用户名：</div>
                <input class="input assign" type="text" name="user" value="<?php if (isset($_POST['user'])) {echo $_POST['user'];} ?>" />
            </div>
            <div class="union assignunion">
                <div class="describe assigndes">密码：</div>
                <input class="input assign" type="password" id="pswd" name="pswd" />
            </div>
            <div class="union assignunion">
                <div class="describe assigndes">确认密码：</div>
                <input class="input assign" type="password" id="pswdConfirm" name="pswdConfirm" />
            </div>
            <div class="union assignunion">
                <div class="describe assigndes">真实姓名：</div>
                <input class="input assign" type="text" id="realname" name="realname" />
            </div>
            <div class="union assignunion">
                <div class="describe assigndes">邮箱：</div>
                <input class="input assign" type="text" id="email" name="email" />
            </div>
            <div class="union assignunion">
                <div class="describe assigndes">用户类型：</div>
                <select class="input assign" name="type">
                    <option value="1">普通管理员</option>
                    <?php if ($_SESSION['level'] > 2) echo '<option value="2">系统管理员</option>'; ?>
                </select>
            </div>
            
            <div class="register_error">
                <?php
                    if (isset($login_error))
                    {
                ?>
                    分配失败
                    
                    <script type="text/javascript">
                        this.pswd.focus();
                    </script>
                <?php
                    }
                ?>
            </div>
            
            <input type="submit" class="button" name="submitRegister" value="分  配" />
        </form>
    </div>
</body>
</html>