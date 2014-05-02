<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
    <div class="top">
        <?php
            if (isset($_SESSION['sid']))
            {
        ?>
            <a href="index.php">首页</a>
            <div>
                <a href="user.php">
                    <?php
                        echo $_SESSION['user'];
                    ?>
                </a>
                <div id="usermenu">
                    <a href="user.php?func=1">
                        个人中心
                    </a>
                    <a href="user.php?func=2">
                        修改密码
                    </a>
                    <a href="logout.php">登 出</a>
                </div>
            </div>
        <?php
            }
            else
            {
        ?>
            <a href="login.php">登 陆</a>
            <a href="register.php">注 册</a>
        <?php
            }
        ?>
    </div>
    
    <?php
        if (isset($_GET['func']) && ($_GET['func'] == 2))
        {
    ?>
        <?php
            include 'useMysql.php';
            
            $sql = "SELECT sid, account, password, salt FROM user WHERE sid = '{$_SESSION['sid']}'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
    
            include 'closeMysql.php';
        ?>
        
        <?php
            if (isset($_POST['submitChange']))
            {
                if (md5($row['account'] . $_POST['pswdOld'] . $row['salt']) == $row['password'])
                {
                    include 'useMysql.php';
                
                    $salt = date('Y-m-d H:i:s');
                    $md5pswd = md5($row['account'] . $_POST['pswd'] . $salt);
                    $sql = "UPDATE user SET password = '{$md5pswd}', salt = '{$salt}' WHERE sid = '{$_SESSION['sid']}'";
                    $db->query($sql);
                
                    include 'closeMysql.php';
                    
                    echo "<div>恭喜您，修改成功！</div>";
                }
                else
                {
                    $change_error = 1;
                }
            }
            
            if (!isset($_POST['submitChange']) || isset($change_error))
            {
                echo "修改" . $row['account'] . "的密码";
        ?>
    
            <form name="input" action="user.php?func=2" method="post">
                <div>
                    当前密码:
                    <input type="password" name="pswdOld" />
                </div>
                
                <div>
                    新密码:
                    <input type="password" name="pswd" />
                </div>
                
                <div>
                    确认新密码:
                    <input type="password" name="pswdConfirm" />
                </div>
                
                <input class="submit" type="submit" name="submitChange" value="确  认" />
            </form>
        <?php
            }
            if (isset($change_error))
            {
                echo '<div>当前密码错误！</div>';
            }
        ?>
    <?php
        }
        else
        {
    ?>
        <?php
            include 'useMysql.php';
            
            $sql = "SELECT sid, account, sname, emailadd, bbn, level FROM user WHERE sid = '{$_SESSION['sid']}'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
    
            include 'closeMysql.php';
    
            echo $row['account'] . "的帐号";
        ?>
        
<!--        <form name="change" action="" method="post">-->
            <div class="info">
                ID : <?php echo $row['sid'] ?>
            </div>
            
            <div class="info">
                真实姓名 : <?php echo $row['sname'] ?>
<!--                <input type="text" name="realname" />-->
            </div>
            
            <div class="info">
                E-mail : <?php echo $row['emailadd'] ?>
<!--                <input type="text" name="email" />-->
            </div>
            
            <div class="info">
                已借书数 : 
                <a href="">
                   <?php echo $row['bbn'] ?>
                </a>
            </div>
<!--            <input class="change" type="submit" name="change" value="确认修改" />-->
<!--        </form>-->
    <?php
        }
    ?>
</body>
</html>