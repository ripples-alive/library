<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
    <?php
        include "top.php";
    ?>
    
    <?php
        if (!isset($_SESSION['level']) || ($_SESSION['level'] == 0))
        {
            die('没有权限！');
        }
    ?>
    
    <div class="all">
        <form name="titleForm" action="administrator.php" method="post">
            <div class="union">
                <div class="describe">被封号者编号：</div>
                <input class="input short" type="text" name="sid" />
            </div>
            <div class="union">
                <div class="describe">封号时间：</div>
                <input class="input short titletime" type="text" name="titletime" />
                天
            </div>
            <input class="button double" type="submit" name="title" value="封  号" />
            <input class="button double" type="submit" name="untitle" value="解  封" />
        </form>
    </div>
    
    <script type="text/javascript">
        <?php
            if (isset($_POST['title']))
            {
                include "useMySQL.php";
                
                $sql = "SELECT level FROM user WHERE sid = '{$_POST['sid']}'";
                $result = $db->query($sql);
                if ($row = $result->fetch_assoc())
                {
                    if ($_SESSION['level'] > $row['level'])
                    {
                        $sql = "UPDATE user SET titledate = DATE_ADD(NOW(), INTERVAL {$_POST['titletime']} DAY) WHERE sid = '{$_POST['sid']}'";
                        $db->query($sql);
                        echo "alert('封号成功！');";
                    }
                    else
                    {
                        echo "alert('权限不足！');";
                    }
                }
                else
                {
                    echo "alert('不存在此用户！');";
                }
                
                include "closeMySQL.php";
            }
            else if (isset($_POST['untitle']))
            {
                include "useMySQL.php";
                
                $sql = "SELECT level FROM user WHERE sid = '{$_POST['sid']}'";
                $result = $db->query($sql);
                if ($row = $result->fetch_assoc())
                {
                    if ($_SESSION['level'] > $row['level'])
                    {
                        $sql = "UPDATE user SET titledate = NULL WHERE sid = '{$_POST['sid']}'";
                        $db->query($sql);
                        echo "alert('解封成功！');";
                    }
                    else
                    {
                        echo "alert('权限不足！');";
                    }
                }
                else
                {
                    echo "alert('不存在此用户！');";
                }
                
                include "closeMySQL.php";
            }
        ?>
    </script>
</body>
</html>