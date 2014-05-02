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
    <?php
        include "top.php";
    ?>
    
    <div class="search">
        <form name="search" action="index.php" method="post">
            <input type="text" name="content" />
            <input class="submit" type="submit" name="submitSearch" value="搜  索" />
        </form>
    </div>
    
    <?php
        if (isset($_POST['submitSearch']))
        {
            echo "搜索 {$_POST['content']} 的结果：</br>";

            include 'useMysql.php';
    
            $sql = "SELECT bname, author, publisher, pubtime FROM book WHERE bname LIKE '%{$_POST['content']}%'";
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc())
            {
                echo "<div class='book'>";
                echo "书名：" . $row['bname'] . "</br>";
                echo "作者：" . $row['author'] . "</br>";
                echo "出版社：" . $row['publisher'] . "</br>";
                echo "出版时间：" . $row['pubtime'] . "</br>";
                echo "</div>";
            }
                
            include 'closeMysql.php';
        }
    ?>
</body>
</html>