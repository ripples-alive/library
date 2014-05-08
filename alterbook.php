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
        if (!isset($_SESSION['level']) || ($_SESSION['level'] <= 1))
        {
            die('没有权限！');
        }
    ?>
    
    <?php
        if ($_GET['func'] == 1)
        {
            if (isset($_POST['alter']))
            {
                include "useMySQL.php";
                
                $sql = "INSERT INTO book VALUES('{$_POST['bid']}', '{$_POST['bname']}', '{$_POST['author']}', '{$_POST['publisher']}', '{$_POST['pubtime']}', '{$_POST['type']}', '{$_POST['location']}', {$_POST['sumnum']}, 0, {$_POST['cbtime']}, '{$_POST['cover']}')";
                $db->query($sql);
                echo '<script type="text/javascript">alert("上架成功");</script>';
                
                include "closeMySQL.php";
            }
    ?>
        <form class="all" action="alterbook.php?func=1" method="POST">
            <h3>上架新书</h3>
            <div class="union alterunion">
                <div class="describe alterdes">ISBN：</div>
                <input class="input alterinput" type="text" name="bid" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">书名：</div>
                <input class="input alterinput" type="text" name="bname" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">作者：</div>
                <input class="input alterinput" type="text" name="author" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">图书类别：</div>
                <input class="input alterinput" type="text" name="type" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">封面：</div>
                <input class="input alterinput" type="text" name="cover" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">出版社：</div>
                <input class="input alterinput" type="text" name="publisher" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">出版时间：</div>
                <input class="input alterinput" type="text" name="pubtime" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">图书数量：</div>
                <input class="input alterinput" type="text" name="sumnum" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">借期：</div>
                <input class="input alterinput alterdate" type="text" name="cbtime" />
                天
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">索书号：</div>
                <input class="input alterinput" type="text" name="location" />
            </div>
            <input class="button" type="submit" name="alter" value="上  架" />
        </form>
    <?php
        }
        else if ($_GET['func'] == 2)
        {
            if (isset($_POST['alter']))
            {
                include "useMySQL.php";
                
                $sql = "UPDATE book SET sumnum = {$_POST['num']} WHERE bid = '{$_POST['bid']}'";
                $db->query($sql);
                echo '<script type="text/javascript">alert("修改成功");</script>';
                
                include "closeMySQL.php";
            }
    ?>
        <form class="all" action="alterbook.php?func=2" method="POST">
            <h3>修改图书数量</h3>
            <div class="union alterunion">
                <div class="describe alterdes">ISBN：</div>
                <input class="input alterinput" type="text" name="bid" />
            </div>
            <div class="union alterunion">
                <div class="describe alterdes">新数量：</div>
                <input class="input alterinput" type="text" name="num" />
            </div>
            <input class="button" type="submit" name="alter" value="修  改" />
        </form>
    <?php
        }
        else if ($_GET['func'] == 3)
        {
            if (isset($_POST['alter']))
            {
                include "useMySQL.php";
                
                $sql = "DELETE FROM book WHERE bid = '{$_POST['bid']}'";
                $db->query($sql);
                echo '<script type="text/javascript">alert("下架成功");</script>';
                
                include "closeMySQL.php";
            }
    ?>
        <form class="all" action="alterbook.php?func=3" method="POST">
            <h3>下架图书</h3>
            <div class="union alterunion">
                <div class="describe alterdes">ISBN：</div>
                <input class="input alterinput" type="text" name="bid" />
            </div>
            <input class="button" type="submit" name="alter" value="下  架" />
        </form>
    <?php
        }
    ?>
</body>
</html>