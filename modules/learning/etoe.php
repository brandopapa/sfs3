<?php
// $Id: etoe.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();
if($_SESSION[session_log_id]==""){
	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}

if ($unit ==""){
		$unit = 'a3101';
}
// ���W��
$m = substr ($unit, 0, 1); 
$t = substr ($unit, 1, 2); 
$u = trim (substr ($unit, 3, 4)); 

if ($entry =="")
	$entry = 'a'; 


//�n�X
if ($_GET[logout]== "yes"){
	session_start();
	$CONN -> Execute ("update pro_user_state set pu_state=0,pu_time_over=now() where teacher_sn='{$_SESSION['session_tea_sn']}'") or user_error("��s���ѡI",256);
	session_destroy();
	$_SESSION[session_log_id]="";
	$_SESSION[session_tea_name]="";
	Header("Location: $_SERVER[PHP_SELF]?unit=$unit");
}
if ($_GET[logout]== "no" and $_SESSION[session_log_id] ==""){
//	$_SESSION[unit]=$unit;
	include $SFS_PATH."/rlogin.php";  
	exit();
}




$l_entry="�U";
foreach($entry_s as $key=>$value){
	$l_entry.="<a href=$PHP_SELF?entry=$key&unit=$unit>$value</a>�U";
}

//���o�U���U�O
$sqlstr = "select * from unit_tome where  unit_m='$m' and unit_t='$t' " ;
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
$c_tome = $row["unit_tome"];
//���o�椸�W��
$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and u_s='$u'" ;
$result = mysql_query($sqlstr);
$row= mysql_fetch_array($result);
$c_unit = $row["unit_name"];
$u_id = $row["u_id"];
$exam_c="";
$exam = $row["exam"];
		if($exam==1){   // �p�G���إ��D�w���� 
			$exam_c="<a href=javascript:fullwin('test.php?unit=$unit')> �u�W���� </a>";
		}

if($_SESSION[session_who]=="�Юv" ){   // �Юv�i�H�˵��D�w���e
		$l_entry.="<a href=test_edit.php?unit=$unit>�˵��D�w</a>�U";
}



$s_title= $modules[$m] . $c_tome .$c_unit; 

if ($_SESSION[session_log_id] != ""){
	$login= "�w�� $_SESSION[session_tea_name] �n�J! �@<a href=\"$_SERVER[PHP_SELF]?logout=yes&unit=$unit\">�n�X</a></td>";
}else{
	$login= "<a href=\"$_SERVER[PHP_SELF]?logout=no&unit=$unit\">�n�J</a>";
}	
$c_title= "<font size=5 face=�з��� color=#800000><b>$s_title</b> </font>";	

//���ؼ��D
	$sqlstr = "select * from unit_c where  ( bk_id='$u_id' or  bk_id='$m') and b_kind='$entry' and b_days > 0 order by b_open_date desc" ;	
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_unit="<form  method='post' action=board_c.php>" ;
	$s_unit.="<table align='center'  border='0' cellpadding='3' cellspacing='3' width='100%'  >";
	$s_unit.="<tr ><td bgcolor='#cccccc'><font size=5 face=�з��� color=#800000> $entry_s[$entry] </font>";
	if($_SESSION[session_who]=="�Юv"){
		$s_unit.="<input type='submit'  value='�s�W'>";
	}

	
$s_unit.="</td></tr>";
	while ($row = $result->FetchRow() ) {    		
    		$b_sub = $row["b_sub"] ;   
    		$b_id = $row["b_id"] ;  
		$bgcolor="#ffCCFF";		
		$s_unit.="<tr ><td bgcolor='$bgcolor'><a href=$PHP_SELF?entry=$entry&unit=$unit&m_id=$b_id > $b_sub </a></td></tr>";
	}
	$s_unit.="</table>"; 

	$s_unit.="<input type='hidden' name='u_id' value= $u_id >
			<input type='hidden' name='entry' value=$entry>
			<input type='hidden' name='unit' value=$unit>
	
		<input type='hidden' name='s_title' value=$s_title-$entry_s[$entry]>

	</form>"; 


// �p���Ƽ�
$sqlstr = "SELECT count(*)  as cou FROM `unit_c` WHERE bk_id='$u_id' and b_days > 0 and b_kind <>'' " ;
$result = mysql_query($sqlstr);
$row= mysql_fetch_array($result);
$total = $row["cou"];
$sql_update = "update unit_u set total='$total' where u_id='$u_id' ";
mysql_query($sql_update) or die ($sql_update);




//���o���e

	include "entry_show.php"; 



// �����}�l
include "header_u.php";

?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>
    <td width="25%" ><a href="index.php?m=<?=$m ?>&t=<?=$t ?>");">�^�ؿ�</a>�@<a href="search.php?unit=<?=$unit ?>");">�j�M</a>�@<?=$exam_c ?></td>
    <td width="65%" align="center"><?= $c_title ?></td>
    <td width="10%" align="right"><a href="javascript:fullwin('oyez.php');">�ù����R</a></td>
  </tr></table>
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" ><tr>
    <td width="70%" ><?= $l_entry ?></td>
    <td width="30%" align="right"><?=$login ?></td>
  </tr>
</table><p>
<table align="center"  border="0" cellpadding="0" cellspacing="0" width="95%"  >
  <tr>
    <td width="20%" valign="top"><?=$s_unit ?></td>
    <td width="80%" valign="top"><?=$main ?></td>
  </tr>
</table>

<script language="JavaScript">
<!--
function fullwin(curl){
window.open(curl,'alone','fullscreen=yes,scrollbars=yes');
}
	
// -->
</script>
<script language="JavaScript">
function Play(mp){ 
mp="<?=$SFS_PATH_HTML?>data/unit/" + mp ;
Player.URL = mp;
}	

</script>

</body>
</html>
<script language="JavaScript">
<!--
function fullwin(curl)
{window.open(curl,"poke","fullscreen,scrollbars")}
// -->
</script>