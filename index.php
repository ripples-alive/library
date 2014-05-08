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
    
    <div class="search <?php if (isset($_POST['submitSearch'])) echo 'upper'; ?>">
        <h1 class="title">图书管理系统</h1>
        <form name="search" action="index.php" method="post">
            <select class="input searchsel" name="type">
                <option id="bname" value="bname">按书名</option>
                <option id="bid" value="bid">按ISBN</option>
                <option id="author" value="author">按作者</option>
                <option id="type" value="type">按分类</option>
                <option id="publisher" value="publisher">按出版社</option>
                <option id="pubtime" value="pubtime">按出版时间</option>
                <?php
                    if ($_POST['type'])
                    {
                ?>
                    <script type="text/javascript">
                        document.getElementById("<?php echo $_POST['type']; ?>").selected = true;
                    </script>
                <?php
                    }
                ?>
            </select>
            <input class="input" type="text" name="content" value="<?php if (isset($_POST['content'])) echo $_POST['content']; ?>" />
            <input class="button submit" type="submit" name="submitSearch" value="搜  索" />
        </form>
    </div>
    
    <?php
        if (isset($_POST['submitSearch']))
        {
            echo "<div class='search_hint'>搜索 <strong>{$_POST['content']}</strong> 的结果：</div>";

            include 'useMysql.php';
    
            $sql = "SELECT bid, bname, author, publisher, pubtime, sumnum, bronum FROM book WHERE ";
            if ($_POST['type'] == 'bname')
            {
                $sql .= "bname LIKE '%{$_POST['content']}%'";
            }
            else if ($_POST['type'] == 'bid')
            {
                $sql .= "bid LIKE '%{$_POST['content']}%'";
            }
            else if ($_POST['type'] == 'author')
            {
                $sql .= "author LIKE '%{$_POST['content']}%'";
            }
            else if ($_POST['type'] == 'type')
            {
                $sql .= "type LIKE '%{$_POST['content']}%'";
            }
            else if ($_POST['type'] == 'publisher')
            {
                $sql .= "publisher LIKE '%{$_POST['content']}%'";
            }
            else if ($_POST['type'] == 'pubtime')
            {
                $sql .= "pubtime LIKE '%{$_POST['content']}%'";
            }
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc())
            {
    ?>
        <div class="onebook">
            <div class="bookname">
                <span>书名：</span>
                <span><a href="book.php?bid=<?php echo $row['bid']; ?>" target="_blank"><?php echo $row['bname']; ?></a></span>
            </div>
            <div class="bookauthor">
                <span>作者：</span>
                <span><?php echo $row['author']; ?></span>
            </div>
            <div>
                <span>出版社：</span>
                <span><?php echo $row['publisher']; ?></span>
            </div>
            <div>
                <span>出版时间：</span>
                <span><?php echo $row['pubtime']; ?></span>
            </div>
            <div>
                <span>馆藏副本：</span>
                <span><?php echo $row['sumnum']; ?></span>
                <span>，已借出副本：</span>
                <span><?php echo $row['bronum']; ?></span>
            </div>
            <div>
                <span>历史借阅人次：</span>
                <span>
                    <?php
                        if (isset($_SESSION['level']) && ($_SESSION['level'] >= 2))
                        {
                            echo '<a href="history.php?bid=' . $row['bid'] . '" target="_blank">';
                        }
                        $sql = "SELECT COUNT(*) FROM history WHERE bid = '{$row['bid']}'";
                        echo $db->query($sql)->fetch_row()[0];
                        if (isset($_SESSION['level']) && ($_SESSION['level'] >= 2))
                        {
                            echo '</a>';
                        }
                    ?>
                </span>
            </div>
        </div>
<!--
        <table class="search_result" border="1">
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
-->
    <?php
            }
            echo "</table>";
                
            include 'closeMysql.php';
        }
    ?>
</body>
</html>