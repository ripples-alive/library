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
        if ($_SESSION['level'] == 0)
        {
            die('没有权限！');
        }
    ?>
    
    <div>
        <form name="bookForm" action="lent.php" method="post">
            <div>
                书籍编号：
                <input type="text" name="bid" />
            </div>
            <div>
                借书人编号：
                <input type="text" name="sid" />
            </div>
            <input type="submit" name="submitLent" value="借  出" />
            <input type="submit" name="submitReturn" value="还  回" />
        </form>
    </div>
    
    <script type="text/javascript">
        <?php
            if (isset($_POST['submitLent']))
            {
                include "useMySQL.php";
                
                $sql = "SELECT sumnum, bronum, cbtime FROM book WHERE bid = '{$_POST['bid']}'";
                $result = $db->query($sql);
                if ($book = $result->fetch_assoc())
                {
                    if ($book['sumnum'] == $book['bronum'])
                    {
                        echo "alert('此书已借完！');";
                    }
                    else
                    {
                        $sql = "SELECT bbn, cbn, tlw FROM user NATURAL JOIN power WHERE sid = '{$_POST['sid']}'";
                        $result = $db->query($sql);
                        if ($staff = $result->fetch_assoc())
                        {
                            if ($staff['bbn'] == $staff['cbn'])
                            {
                                echo "alert('此人已达借书上限！');";
                            }
                            else
                            {
                                $sql = "INSERT INTO ubb VALUES ('{$_POST['sid']}', '{$_POST['bid']}', 0, '" . date('Y-m-d', strtotime('+'. $book['cbtime'] * $staff['tlw'] . ' day')) . "')";
                                if ($db->query($sql))
                                {
                                    $sql = "INSERT INTO history VALUES ('{$_POST['sid']}', '{$_POST['bid']}', '" . date('Y-m-d') . "', NULL)";
                                    $db->query($sql);
                                    $sql = "UPDATE book SET bronum = bronum + 1 WHERE bid = '{$_POST['bid']}'";
                                    $db->query($sql);
                                    $sql = "UPDATE user SET bbn = bbn + 1 WHERE sid = '{$_POST['sid']}'";
                                    $db->query($sql);
                                    echo "alert('借书成功');";
                                }
                                else
                                {
                                    echo "alert('借书失败');";
                                }
//                                echo "alert(\"$sql\");";
                            }
                        }
                        else
                        {
                            echo "alert('没有这个人！');";
                        }
                    }
                }
                else
                {
                    echo "alert('没有这本书！');";
                }
                
                include "closeMySQL.php";
            }
            else if (isset($_POST['submitReturn']))
            {
                include "useMySQL.php";
                
                $sql = "DELETE FROM ubb WHERE sid = '{$_POST['sid']}' AND bid = '{$_POST['bid']}'";
                $db->query($sql);
                if ($db->affected_rows == 0)
                {
                    echo "alert('还书失败！');";
                }
                else
                {
                    $sql = "UPDATE history SET returntime = NOW() WHERE sid = '{$_POST['sid']}' AND bid = '{$_POST['bid']}' AND returntime IS NULL";
                    $db->query($sql);
                    $sql = "UPDATE book SET bronum = bronum - 1 WHERE bid = '{$_POST['bid']}'";
                    $db->query($sql);
                    $sql = "UPDATE user SET bbn = bbn - 1 WHERE sid = '{$_POST['sid']}'";
                    $db->query($sql);
                    echo "alert('还书成功');";
                }
                
                include "closeMySQL.php";
            }
        ?>
    </script>
</body>
</html>