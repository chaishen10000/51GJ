<?php 
/* 
 *    Mysql���ݿ� DB�� 
 *    @package    db 
 *    @author     360ing 
 *    @version    2014-12-23 
 *    @copyrigth    http://www.360ing.cn/  
 */ 
class db { 
    var $connection_id = ""; 
    var $pconnect = 0; 
    var $shutdown_queries = array(); 
    var $queries = array(); 
    var $query_id = ""; 
    var $query_count = 0; 
    var $record_row = array(); 
    var $failed = 0; 
    var $halt = ""; 
    var $query_log = array(); 
    function connect($db_config){ 
        if ($this->pconnect){
            $this->connection_id = mysql_pconnect($db_config["hostname"], $db_config["username"], $db_config["password"]); 
			mysql_set_charset($db_config["charset"],$this->connection_id);
        }else{
            $this->connection_id = mysql_connect($db_config["hostname"], $db_config["username"], $db_config["password"]); 
			mysql_set_charset($db_config["charset"],$this->connection_id);
        } 
        if ( ! $this->connection_id ){ 
            $this->halt("Can not connect MySQL Server"); 
        } 
        if ( ! @mysql_select_db($db_config["database"], $this->connection_id) ){ 
            $this->halt("Can not connect MySQL Database"); 
        } 
        if ($db_config["charset"]) { 
            //@mysql_unbuffered_query("SET NAMES '".$db_config["charset"]."'"); 
			
        } 
		
        return true; 
    } 
    //����SQL ��ѯ�������ؽ���� 
    function query($query_id, $query_type='mysql_query'){ 
        $this->query_id = $query_type($query_id, $this->connection_id); 
        $this->queries[] = $query_id; 
        if (! $this->query_id ) { 
            $this->halt("��ѯʧ��:\n$query_id"); 
        } 
        $this->query_count++; 
        $this->query_log[] = $str; 
        return $this->query_id; 
    } 
    //����SQL ��ѯ��������ȡ�ͻ��������� 
    function query_unbuffered($sql=""){ 
	    $req = $this->query($sql, 'mysql_unbuffered_query'); 
		//$this->log_result("�����ݿ�ִ�С�:\n".$req."\n");
        return $req; 
    } 
    //�ӽ������ȡ��һ����Ϊ�������� 
    function fetch_array($sql = ""){ 
        if ($sql == "") $sql = $this->query_id; 
        $this->record_row = @mysql_fetch_array($sql, MYSQL_ASSOC); 
        return $this->record_row; 
    } 
    function shutdown_query($query_id = ""){ 
        $this->shutdown_queries[] = $query_id; 
    } 
    //ȡ�ý�������е���Ŀ������ INSERT��UPDATE ���� DELETE 
    function affected_rows() { 
        return @mysql_affected_rows($this->connection_id); 
    } 
    //ȡ�ý�������е���Ŀ������ SELECT �����Ч 
    function num_rows($query_id="") { 
        if ($query_id == "") $query_id = $this->query_id; 
        return @mysql_num_rows($query_id); 
    } 
    //������һ�� MySQL �����еĴ�����Ϣ�����ֱ��� 
    function get_errno(){ 
        $this->errno = @mysql_errno($this->connection_id); 
        return $this->errno; 
    } 
    //ȡ����һ�� INSERT ���������� ID 
    function insert_id(){ 
        return @mysql_insert_id($this->connection_id); 
    } 
    //�õ���ѯ���� 
    function query_count() { 
        return $this->query_count; 
    } 
    //�ͷŽ���ڴ� 
    function free_result($query_id=""){ 
           if ($query_id == "") $query_id = $this->query_id; 
        @mysql_free_result($query_id); 
    } 
    //�ر� MySQL ���� 
    function close_db(){ 
        if ( $this->connection_id ) return @mysql_close( $this->connection_id ); 
    } 
    //�г� MySQL ���ݿ��еı� 
    function get_table_names(){ 
        global $db_config; 
        $result = mysql_list_tables($db_config["database"]); 
        $num_tables = @mysql_numrows($result); 
        for ($i = 0; $i < $num_tables; $i++) { 
            $tables[] = mysql_tablename($result, $i); 
        } 
        mysql_free_result($result); 
        return $tables; 
       } 
    //�ӽ������ȡ������Ϣ����Ϊ���󷵻أ�ȡ�������ֶ� 
    function get_result_fields($query_id=""){ 
           if ($query_id == "") $query_id = $this->query_id; 
        while ($field = mysql_fetch_field($query_id)) { 
            $fields[] = $field; 
        } 
        return $fields; 
       } 
    //������ʾ 
    function halt($the_error=""){ 
        $message = $the_error."<br/>\r\n"; 
        $message.= $this->get_errno() . "<br/>\r\n"; 
        $sql = "INSERT INTO `db_error`(pagename, errstr, timer) VALUES('".$_SERVER["PHP_SELF"]."', '".addslashes($message)."', ".time().")"; 
        @mysql_unbuffered_query($sql); 
        if (DEBUG==true){ 
            echo "$message)";
			echo "���ݿ���ʴ���";
            exit; 
        } 
    } 
	
	function  log_result($word) 
	{
		$date = date("Y-m");
	    $log_name = "./notify_url_$date.log";//log�ļ�·��
	    $log_error =  "notify_error_$date.log";//log�ļ�·��
	    $fp = fopen($log_name,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"ִ�����ڣ�".strftime("%Y-%m-%d-%H��%M��%S",time())."\n".$word."\n\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
	
	
    function __destruct(){ 
        $this->shutdown_queries = array(); 
        $this->close_db(); 
    } 
    function sql_select($tbname, $where="", $limit=0, $fields="*", $orderby="id", $sort="DESC"){ 
        $sql = "SELECT ".$fields." FROM `".$tbname."` ".($where?" WHERE ".$where:"")." ORDER BY ".$orderby." ".$sort.($limit ? " limit ".$limit:""); 
        //$this->log_result("�����ݿ��ѯ��:\n".$sql."\n");
		return $sql; 
    } 
    function sql_insert($tbname, $row){ 
        foreach ($row as $key=>$value) { 
            $sqlfield .= $key.","; 
            $sqlvalue .= "'".$value."',"; 
        }
		$sql= "INSERT INTO `".$tbname."` (".substr($sqlfield, 0, -1).") VALUES (".substr($sqlvalue, 0, -1).")";
		//$this->log_result("�����ݿ���롿:\n".$sql."\n");
        return  $sql;
    } 
    function sql_update($tbname, $row, $where){ 
        foreach ($row as $key=>$value) { 
            $sqlud .= $key."= '".$value."',"; 
        } 
		$sql = "UPDATE `".$tbname."` SET ".substr($sqlud, 0, -1)." WHERE ".$where; 
		//$this->log_result("�����ݿ���¡�:\n".$sql."\n");
        return $sql; 
    } 
	function sql_update_int($tbname, $row, $where){ 
        foreach ($row as $key=>$value) { 
            $sqlud .= $key."= ".$value.","; 
        } 
        return "UPDATE `".$tbname."` SET ".substr($sqlud, 0, -1)." WHERE ".$where; 
    } 
    function sql_delete($tbname, $where){ 
        return "DELETE FROM `".$tbname."` WHERE ".$where; 
    } 
    //������һ����¼ 
    function row_insert($tbname, $row){  
        $sql = $this->sql_insert($tbname, $row);  
        $this->query_unbuffered($sql);
		return $this->insert_id(); 
    } 
    //����ָ����¼ 
    function row_update($tbname, $row, $where){ 
        $sql = $this->sql_update($tbname, $row, $where); 
        return $this->query_unbuffered($sql); 
    }
	//����ָ����¼ INT
    function row_update_int($tbname, $row, $where){ 
        $sql = $this->sql_update_int($tbname, $row, $where); 
        return $this->query_unbuffered($sql); 
    } 
    //ɾ�����������ļ�¼ 
    function row_delete($tbname, $where){ 
        $sql = $this->sql_delete($tbname, $where); 
        return $this->query_unbuffered($sql); 
    } 
    /*    ����������ѯ���������м�¼ 
     *    $tbname ����, $where ��ѯ����, $limit ���ؼ�¼, $fields �����ֶ� 
     */ 
    function row_select($tbname, $where="", $limit=0, $fields="*", $orderby="id", $sort="DESC"){ 
        $sql = $this->sql_select($tbname, $where, $limit, $fields, $orderby, $sort); 
        return $this->row_query($sql); 
    } 
    //��ϸ��ʾһ����¼ 
    function row_select_one($tbname, $where, $fields="*", $orderby="id"){ 
        $sql = $this->sql_select($tbname, $where, 1, $fields, $orderby); 
        return $this->row_query_one($sql); 
    } 
    function row_query($sql){ 
        $rs     = $this->query($sql); 
        $rs_num = $this->num_rows($rs); 
        $rows = array(); 
        for($i=0; $i<$rs_num; $i++){ 
            $rows[] = $this->fetch_array($rs); 
        } 
        $this->free_result($rs); 
        return $rows; 
    } 
    function row_query_one($sql){ 
        $rs     = $this->query($sql); 
        $row = $this->fetch_array($rs); 
        $this->free_result($rs); 
        return $row; 
    } 
    //����ͳ�� 
    function row_count($tbname, $where=""){ 
        $sql = "SELECT count(id) as row_sum FROM `".$tbname."` ".($where?" WHERE ".$where:""); 
        $row = $this->row_query_one($sql); 
        return $row["row_sum"]; 
    } 
} 
?>