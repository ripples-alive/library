<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
    <link href="css/book.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
    <?php
        include "top.php";
    ?>
    
    <?php
        include "useMySQL.php";

        if (isset($_POST['content']))
        {
            $sql = "SELECT titledate FROM user WHERE sid = '{$_SESSION['sid']}' AND (titledate IS NULL OR titledate < NOW())";
            $result = $db->query($sql);
            if ($result->num_rows > 0)
            {
                $sql = "INSERT INTO ucb VALUES ('{$_SESSION['sid']}', '{$_GET['bid']}', NOW(), '{$_POST['content']}')";
                $db->query($sql);
                echo "<script type='text/javascript'>alert('评论成功！');</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('对不起，您已被封号，无法评论！');</script>";
            }
        }

        if (isset($_GET['delete']))
        {
            $sql = "SELECT level FROM user WHERE sid = '{$_GET['sid']}'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            if (isset($_SESSION['level']) && (($_SESSION['level'] > $row['level']) || ($_SESSION['sid'] == $_GET['sid'])))
            {
                $sql = "DELETE FROM ucb WHERE sid = '{$_GET['sid']}' AND bid = '{$_GET['bid']}' AND MD5(time) = '{$_GET['delete']}'";
                $db->query($sql);
                echo "<script type='text/javascript'>alert('删除成功！');</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('权限不足！');</script>";
            }
        }
    ?>

    <?php
        $sql = "SELECT bid, bname, author, publisher, pubtime, location, cover, sumnum, bronum FROM book WHERE bid = '{$_GET['bid']}'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    ?>
    
    <img class="cover" src="images/cover/<?php echo $row['cover']; ?>" />
    <table class="book">
        <tr>
            <td>书名：</td>
            <td><?php echo $row['bname']; ?></td>
        </tr>
        <tr>
            <td>作者：</td>
            <td><?php echo $row['author']; ?></td>
        </tr>
        <tr>
            <td>出版社：</td>
            <td><?php echo $row['publisher']; ?></td>
        </tr>
        <tr>
            <td>出版时间：</td>
            <td><?php echo $row['pubtime']; ?></td>
        </tr>
        <tr>
            <td>ISBN：</td>
            <td><?php echo $row['bid']; ?></td>
        </tr>
        <tr>
            <td>索书号：</td>
            <td><?php echo $row['location']; ?></td>
        </tr>
        <tr>
            <td>馆藏副本：</td>
            <td><?php echo $row['sumnum']; ?></td>
        </tr>
        <tr>
            <td>已借出副本：</td>
            <td><?php echo $row['bronum']; ?></td>
        </tr>
    </table>
    
    <?php
        $sql = "SELECT sid, account, level, time, content FROM ucb NATURAL JOIN user WHERE bid = '{$_GET['bid']}' ORDER BY time";
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc())
        {
    ?>
        <div class="comment">
            <div class="ccontent"><?php echo $row['content']; ?></div>
            <div class="cfooter">
                <?php
                    if (isset($_SESSION['level']) && (($_SESSION['level'] > $row['level']) || ($_SESSION['sid'] == $row['sid'])))
                    {
                        echo "<a href='book.php?bid={$_GET['bid']}&sid={$row['sid']}&delete=" . md5($row['time']) . "'>删除</a>";
                    }
                ?>
                <div><?php echo $row['time'] ?></div>
                <div class="account"><?php echo $row['account'] ?></div>
            </div>
        </div>
    <?php
        }

        include "closeMySQL.php";
    ?>
    
    <form class="add_cmt" action="book.php?bid=<?php echo $_GET['bid']; ?>" method="post">
        <div><strong>发表评论：</strong></div>
        <div><textarea class="cmt_input input" name="content" <?php if (!isset($_SESSION['sid'])) echo 'value="请登陆后再发表评论！" readonly="readonly"'; ?>></textarea></div>
        <input class="button" type="submit" name="submitComment" value="发  表" <?php if (!isset($_SESSION['sid'])) echo 'disabled="disabled"'; ?> />
    </form>
</body>
</html>