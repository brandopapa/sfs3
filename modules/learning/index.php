<?php
// $Id: index.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();

//�n�X
if ($_GET[logout]== "yes"){
//	session_start();
//	$CONN -> Execute ("update pro_user_state set pu_state=0,pu_time_over=now() where teacher_sn='{$_SESSION['session_tea_sn']}'") or user_error("��s���ѡI",256);
	session_destroy();
	$_SESSION[session_log_id]="";
	$_SESSION[session_tea_name]="";
	Header("Location: $_SERVER[PHP_SELF]");
}
if ($_GET[logout]== "no" and $_SESSION[session_log_id] ==""){
	include $SFS_PATH."/rlogin.php";  
	exit();
}

if ($m =="")
	$m = 'a'; 
if ($t=='')
	$t=31;
// ���W��
if ($se=='')
	$se=substr($t,1,1);


$l_modules="�U";
foreach($modules_s as $key=>$value){
	$l_modules.="<a href=$PHP_SELF?m=$key&t=$t>$value</a>�U";
}
$c_modules=$modules[$m];
//���o�U���U�O

if($_SESSION['session_who']=='�Юv'){
	$testadmin="<a href=test_score.php??key=stud>�V�m�a�W��</a>";
}

$admin="";    // �u���޲z�̤~�i�i��޲z

if (checkid($_SERVER[SCRIPT_FILENAME],1)){
$admin="<input type='submit'  value='�޲z'>";
$testadmin="<a href=test_admin.php>�u�W����޲z</a>";
}
	$sqlstr = "select * from unit_tome where  unit_m='$m' and tome_ver <>''  order by seme,unit_t" ;
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_tome="<table align='center'  border='0' cellpadding='3' cellspacing='3' width='95%'  >";
	$s_tome.="<form  method='post' action=tome_edit.php>
			<tr><td bgcolor='#cccccc'><font size=5 face=�з��� color=#800000> $c_modules </font>�@
			$admin </td>
			</tr><input type='hidden' name='m' value= $m ></form>";
	while ($row = $result->FetchRow() ) {    		
    		$unit_tome = $row["unit_tome"] ;    
    		$unit_t = $row["unit_t"] ;  
		$tome_ver = $row["tome_ver"] ;
		$seme = $row["seme"] ;
		$bgcolor="#ffCCFF";
		if($seme==2)
			$bgcolor="#11CCFF";
		
		$s_tome.="<tr ><td bgcolor='$bgcolor'><a href=$PHP_SELF?m=$m&t=$unit_t&se=$seme > $unit_tome : $tome_ver </a></td></tr>";
		if($unit_t==$t){
			$c_tome=$unit_tome;     //�U�O
			$c_tome_ver=$tome_ver; //���Ǵ�����
			$l_var="<a href=$PHP_SELF?m=$m&t=$t&se=$se&oth=oth>�䥦��</a>";
			if($oth=="oth"){
				$o_tome_ver=$tome_ver;
				$c_tome_ver="�䥦��";
				$l_var="<a href=$PHP_SELF?m=$m&t=$t&se=$se>$tome_ver </a>";
			}
		}

	}
	$s_tome.="</table>"; 
//���o�椸�W��
	$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and tome_ver ='$c_tome_ver'  order by u_s" ;
	if($oth=="oth"){
		$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and tome_ver !='$o_tome_ver'  and tome_ver !=''  order by u_s" ;
	}
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_unit="<table align='center'  border='0' cellpadding='2' cellspacing='2' width='95%'  bgcolor='#ccFFFF'>";
	$bgcolor="#ffCCFF";
		if($se==2)
			$bgcolor="#11CCFF";

	$s_unit.="<form  method='post' action=unit_edit.php>
			<tr bgcolor='$bgcolor'><td width='80%'><font size=5 face=�з��� color=#800000> $c_tome : $c_tome_ver </font> 
			$l_var �@<a href=search.php>�j�M</a>�@
		$admin $testadmin</td><td width='10%' align='center'>��Ƽ�</td><td width='10%' align='center'><a href=javascript:fullwin('online_con.php')>�צ�<br>����</a></td></tr><input type='hidden' name='m' value= $m ><input type='hidden' name='t' value= $t ></form>";
	while ($row = $result->FetchRow() ) {    		
    		$unit_name = $row["unit_name"] ;    
    		$u_s = $row["u_s"] ;  		
		$u=$m.$t.$u_s;
		$total = $row["total"] ;
	
		if($total==0){
			$total="";
		}

		$exam = $row["exam"] ; 
		$exam_c="";
		if($exam==1){
			$exam_c="<a href=javascript:fullwin('test.php?unit=$u')>����</a>";
		}
		
		$s_unit.="<tr bgcolor='#a1c1a1'><td ><a href=etoe.php?unit=$u >  $unit_name </a></td><td align='center'>$total</td><td align='center'>$exam_c</td></tr>";
	}
	$s_unit.="</table>"; 


if ($_SESSION[session_log_id] != ""){
	$login= "�w�� $_SESSION[session_tea_name] �n�J! �@<a href=\"$_SERVER[PHP_SELF]?logout=yes&bk_id=$bk_id\">�n�X</a></td>";
}else{
	$login= "<a href=\"$_SERVER[PHP_SELF]?logout=no&bk_id=$bk_id\">�n�J</a>";
}	
	$c_title= "<font size=5 face=�з��� color=#800000><b>$school_short_name �оǸ귽�� </b> </font>";	

// �����}�l
include "header.php";

?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>
   <td width="15%" ><a href=<?=$HOME_URL ?>>HOME</a>�@<a href='http://woa.mlc.edu.tw/index.jsp?unitid=000004' target='_blank'><img  border=0 src='pokemon/new.gif'  alt='���_�_���p��'  ></a>
</td>
    <td width="60%" align="center"> <?= $c_title ?> </td>
    <td width="30%" align="center"><?=$login ?></td>
  </tr>

      <tr>
    <td width="100%" colspan="3" > <?= $l_modules ?></td>
  </tr>

</table><p>
<table align="center"  border="0" cellpadding="0" cellspacing="0" width="95%"  >
  <tr>
    <td width="25%" valign="top"><?=$s_tome ?></td>
    <td width="75%" valign="top"><?=$s_unit ?></td>
  </tr>
</table>
</body>
</html>
<script language="JavaScript">
<!--
function fullwin(curl)
{window.open(curl,"poke","fullscreen,scrollbars")}
// -->
</script>