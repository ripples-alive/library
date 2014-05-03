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
    
    <div class="search">
        <form name="search" action="index.php" method="post">
            <input type="text" name="content" value="<?php if (isset($_POST['content'])) echo $_POST['content']; ?>" />
            <input class="submit" type="submit" name="submitSearch" value="搜  索" />
        </form>
    </div>
    
    <?php
        if (isset($_POST['submitSearch']))
        {
            echo "搜索 {$_POST['content']} 的结果：</br>";

            include 'useMysql.php';
    
            $sql = "SELECT bid, bname, author, publisher, pubtime FROM book WHERE bname LIKE '%{$_POST['content']}%'";
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc())
            {
    ?>
        <table>
            <tr>
                <td>书名：</td>
                <td><a href="book.php?bid=<?php echo $row['bid']; ?>" target="_blank"><?php echo $row['bname']; ?></a></td>
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
        </table>
    <?php
            }
            echo "</table>";
                
            include 'closeMysql.php';
        }
    ?>
</body>
</html>