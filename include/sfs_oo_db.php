<?php

// $Id: sfs_oo_db.php 5310 2009-01-10 07:57:56Z hami $
// ���N DBClass.php

// ���J��90.09.30�q����
class DBClass {
	var $db ;
	var $server;
	var $stduser;
	var $stdpass;

function Recordset($SQL) {
	if (($this->stdpass != "") && ($this->stduser != "") && ($this->server != "")) {
	$link = @mysql_connect($this->server, $this->stduser, $this->stdpass) or  $this->DBDie("�L�k�s����Ʈw,���ˬd�s�u��T!<BR>"); 
	}
//	mysql_select_db($this->db);
	$rs = mysql_db_query($this->db, $SQL) or $this->DBDie($SQL."<BR>�L�k�s����Ʈw,���ˬd��Ʈw�W�٬O�_�]�w���T!<BR>");
//	$rs = mysql_query($SQL ,$link) or $this->DBDie();
	return $rs;// 
	if (($this->stdpass != "") && ($this->stduser != "") && ($this->server != "")) { 
	$this->DBClose($link); 
	}
}

function Execute($SQL) {
	if (($this->stdpass != "") && ($this->stduser != "") && ($this->server != "")) { 
	$link = @mysql_connect($this->server, $this->stduser, $this->stdpass)  or  $this->DBDie("�L�k�s����Ʈw,���ˬd�s�u��T!<BR>");
	}
	$rs = mysql_db_query($this->db, $SQL) or $this->DBDie("��Ʈw�W�٩Ϋ��O�ԭz���~!<BR> $SQL ");
	return mysql_insert_id();
	if (($this->stdpass != "") && ($this->stduser != "") && ($this->server != "")) {
		$this->DBClose($link); 
	}
}

function RecordCount($rs) {
	if (!$rs) {return $this->DBDie($SQL."�S���s������!�L�k�p��!<BR> ");exit;}
	return mysql_num_rows($rs) ;
	}

function GetRows($rs) {
	if (!$rs) {return $this->DBDie("�S���s������!�L�k�Ǧ^���!<BR>");exit;}
	$arr = array();
	$counter = 0;
	while ($row = mysql_fetch_array($rs)) {
	$arr[$counter] = $row;
	$counter++;
	}
	return $arr;
}

function GetString($rs, $col, $row) {
	$return_str = "";
	while($thisRow = mysql_fetch_row($rs)) {
	$return_str .= join($col, $thisRow).$row;
	}
	return $return_str;
}

function GetFieldCount($rs) {
if (!$rs) {return $this->DBDie("�S���s������!�L�k�p��!<BR>");exit;}
	return mysql_num_fields($rs);
}

function DBClose($link) {
	mysql_close($link);
}

function DBDie($error) {
	echo $error;exit;
	}
}
?>
