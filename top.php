<div class="top">
    <?php
        if (isset($_SESSION['sid']))
        {
    ?>
        <a href="index.php">首页</a>
        
        <?php
            if ($_SESSION['level'] > 0)
            {
                echo '<a href="lent.php">借还书</a>';
                echo '<a href="administrator.php">封号</a>';
            }
        ?>
    
        <div>
            <a href="user.php">
                <?php
                    echo $_SESSION['user'];
                ?>
            </a>
            <div id="usermenu">
                <a href="user.php?func=1">
                    个人中心
                </a>
                <a href="user.php?func=2">
                    修改密码
                </a>
                <a href="logout.php">登 出</a>
            </div>
        </div>
    <?php
        }
        else
        {
    ?>
        <a href="login.php">登 陆</a>
        <a href="register.php">注 册</a>
    <?php
        }
    ?>
</div>