<?php
    $db = new mysqli("localhost", "library", "library", "library");
    if (mysqli_connect_errno())
    {
        die("Connect failed: " . mysqli_connect_error());
    }
?>