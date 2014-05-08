<?php
    session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>图书管理系统</title>
    <link href="css/library.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />
</head>
    
<body>
    <?php
        include "top.php";
    ?>

    <?php
        include "useMySQL.php";

        $sql = "SELECT bname FROM book WHERE bid = '{$_GET['bid']}'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    ?>
    
    <h3 class="tablehead">《<?php echo $row['bname']; ?>》历史借阅记录</h3>
    <table class="hovertable">
        <tr>
            <th>借书者ID</th>
            <th>借阅时间</th>
            <th>归还时间</th>
        </tr>
        <?php
            $sql = "SELECT sid, lenttime, returntime FROM history WHERE bid = '{$_GET['bid']}'";
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc())
            {
        ?>
            <tr onmouseover="this.style.backgroundColor='#ffff66';" onmouseout="this.style.backgroundColor='#d4e3e5';">
                <td><?php echo $row['sid']; ?></td>
                <td><?php echo $row['lenttime']; ?></td>
                <td>
                    <?php
                        if ($row['returntime'] != null)
                        {
                            echo $row['returntime'];
                        }
                        else
                        {
                            echo '尚未归还';
                        }
                    ?>
                </td>
            </tr>
        <?php
            }
    
            include "closeMySQL.php";
        ?>
    </table>
</body>
</html>