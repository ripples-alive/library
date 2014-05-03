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
        include "useMySQL.php";

        $sql = "SELECT bname, author, publisher, pubtime FROM book WHERE bid = '{$_GET['bid']}'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        include "closeMySQL.php";
    ?>
    
    <table>
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
    </table>
</body>
</html>