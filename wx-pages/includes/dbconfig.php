<?php 
    $db_config["hostname"]    = "localhost";    //��������ַ 
    $db_config["username"]    = "root";        //���ݿ��û��� 
    $db_config["password"]    = "Wxb37214728";        //���ݿ����� 
    $db_config["database"]    = "weigj";        //���ݿ����� 
    $db_config["charset"]        = "utf8mb4"; 
	
    include('dbclass.php'); 
    $db    = new db(); 
    $db->connect($db_config); 
?> 