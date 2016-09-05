<?php 
    $db_config["hostname"]    = "localhost";    //服务器地址 
    $db_config["username"]    = "root";        //数据库用户名 
    $db_config["password"]    = "Wxb37214728";        //数据库密码 
    $db_config["database"]    = "weigj";        //数据库名称 
    $db_config["charset"]        = "utf8mb4"; 
	
    include('dbclass.php'); 
    $db    = new db(); 
    $db->connect($db_config); 
?> 