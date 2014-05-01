<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
    session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
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
</head>

<body>
    <div>
        <?php
            if (isset($_SESSION['sid']))
            {
                unset($_SESSION['sid']);
                unset($_SESSION['user']);
                echo "已退出登陆！";
            }
            else
            {
                echo "尚未登录！";
            }
        ?>
    </div>
        
    <div>
        <span id="time">
        </span>
        <span>
            秒后自动跳转到退出前页面!
        </span>
    </div>
</body>
</html>