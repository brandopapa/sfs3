<?php
// $Id: test_temp.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();
if($_SESSION[session_log_id]==""){	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}

$con=3;	//�w�]�C���D��
$canon=30;	//�e���X�D�w�]������D
$pass=100;	//�L���D�ơA�i�o���_�_��
$font_q="<font <font size=6 face=�з���>";   // �D�ئr��
$font_c="<font <font size=5 face=�з���>";   // �ﶵ�r��

// $unit �ߤ@�ǤJ���椸�N��
if($unit=='')
	$unit='a3121';

$m = substr ($unit, 0, 1); 
$t = substr ($unit, 1, 2); 
$u = trim (substr ($unit, 3, 4)); 

//�n�X
if ($_GET[logout]== "yes"){
	session_start();
	$CONN -> Execute ("update pro_user_state set pu_state=0,pu_time_over=now() where teacher_sn='{$_SESSION['session_tea_sn']}'") or user_error("��s���ѡI",256);
	session_destroy();
	$_SESSION[session_log_id]="";
	$_SESSION[session_tea_name]="";
	Header("Location: index.php?m=$m&t=$t");
}

//���o�U���U�O
$sqlstr = "select * from unit_tome where  unit_m='$m' and unit_t='$t' " ;
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
$c_tome = $row["unit_tome"];
$tome_ver = $row["tome_ver"];
//���o�椸�W��
$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and u_s='$u' and tome_ver='$tome_ver' and exam='1'";
$result = mysql_query($sqlstr);
$row= mysql_fetch_array($result);
$c_unit = $row["unit_name"];
$u_id = $row["u_id"];
$msg_err="";
if($u_id==""){   //�L���椸
	$s_unit="<font size=7 color=red>�L���椸���D�w�I</font>";
}
$s_title= $modules[$m] . $c_tome .$c_unit  ; 
$c_title= "<font size=5 face=�з��� color=#800000><b>$s_title</b> </font>";	

//if ($_SESSION[session_log_id] != ""){
//	 $logout= "<a href=\"$_SERVER[PHP_SELF]?logout=yes&unit=$unit\">�n�X</a>";
//}	

//���o���_�_�����
$sqlstr = "select * from poke_base   " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$i=1;
while ($row = $result->FetchRow() ) { 
	//$p_sn = $row["p_sn"] ;	
	$p_name = $row["p_name"] ; 
	$poke_a[$i]['p_name']=$p_name ;
	$poke_a[$i]['1']=$row["p_s1"] ;
	$poke_a[$i]['2']=$row["p_s2"] ; 
	$poke_a[$i]['3']=$row["p_s3"] ; 

	$i++;
}
//���o�¸��
$sqlstr = "select * from test_score where  u_id='$u_id' and teacher_sn='$_SESSION[session_tea_sn]' " ;
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
if($row['s_id']=="" and $s_unit==""){  //�s���
	$sql_insert = "insert into test_score (u_id,stud_id,who,stud_name,teacher_sn) values ('$u_id','$_SESSION[session_log_id]','$_SESSION[session_who]','$_SESSION[session_tea_name]','$_SESSION[session_tea_sn]')";
	mysql_query($sql_insert) or die ($sql_insert); 
	$sqlstr = "select * from test_score where  u_id='$u_id' and stud_id='$_SESSION[session_log_id]' " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
}
$total = $row["total"];
$s_id = $row["s_id"];
//$type = $row["type"];
$poke = $row["poke"];
$exper = $row["exper"];
$top = $row["top"];
$up_date = mysql_date();
$poke_type=ceil($poke/50);
//�w�F�׷��i��
if($top==1)
	$poke_type=6;

$poke_n="�g��ȡG<font size=5 color=red> " . $exper . " </font><font size=2> (5���H�W�i�H�i��)</font>"  ;


if( $top==1){
	$poke_n="�g��ȡG<font size=5 color=red> " . $exper . " </font><font size=2> (���w�F�׷��i��)</font>"  ;
}
	
if($total>=100){
	$power_msg="<font size=2>(100���H�W�i�H�԰�)</font>";
}

if($key=="�T�w�ӶD" or $key=="���X�ӶD1" or $key=="���X�ӶD2" or $key=="���X�ӶD3" ){
	include "test_1.php"; 
}
if($key=="�i��" ){
	include "test_2_o.php"; 
}
if($key=="�԰�" or $key=="�ŤM��" or $key=="���Y��" or $key==" �� ��"){
	include "test_3.php"; 
} 
if($key=="�ڪ����_�_��" or $key=='�̽s��'or $key=='�̾԰��O' or $key=='�̽ҵ{'){
	include "test_4.php"; 
} 
if($key=="" or $key=="�T�wok" or $key=="�~��next"){ 
	include "test_5.php"; 
} 
if($key=="�ڪ�����" or $key=='�̧Ǹ�'or $key=='�̤��'){
	include "test_6.php"; 
} 

// onSelectStart="event.returnValue=false"  �T�����

// �����}�l
?>
<html>
<head>
<title><?=$s_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=big5" >
</head>
<body style="border: 10pt #808080 outset" bgcolor="CCFFCC" background="images-a/b<?=$exper?>.gif"  bgproperties="fixed"  
      ONDRAGSTART="window.event.returnValue=false" ONCONTEXTMENU="window.event.returnValue=false"  >
<script language="JavaScript">
<!--
  //if (history.length==0 ) window.location="";  //�T�����J���}    OnLoad="namosw_init_animation()
  //if(name!="poke") window.location="";       //�T�����J���}
 
-->
</script>

<font face="Times New Roman">
<OBJECT name="Player" ID="Player" height="0" width="0"
  CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">
</object>
</font>

<?php

$login= "<font size=5 color='9933ff' face=�з���>�V�m�a�G$_SESSION[session_tea_name]</font>";
$power="�԰��O�G<font size=5 color=red> " . $total . " </font>".$power_msg ;   //�Y�ɧ�s���Z�@
if($poke>0 ){
	$poke_alt=$poke . "_" . $poke_a[$poke]['p_name'];
	$poke_gif="<img src=pokemon/$poke" . ".gif  alt=$poke_alt >" .$poke_n;
}else{
	$poke_gif="$pass ���H�W�N�i���A���_�_����I";
}
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>			
    <td width="25%" ><a href=javascript:close()><font size=5 face=�з���>���}(EXIT)</font></a></td>
    <td width="65%" align="center"><?= $c_title ?></td>
         <td width="10%" align="center"><?= $logout ?></td>
</tr></table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
<tr> 
<td width="30%" align="right" valign="bottom"><?=$login ?>�@<a href=online_con.php><font size=3 face=�з���>�צ椧��</font></a></td>
<td width="30%" align="right" valign="bottom"><?=$power ?></td>
<td width="40%" align="right" valign="bottom"><?=$poke_gif ?></td>
</tr></table>
<?=$s_unit ?>
</body>
</html>



<script language="JavaScript">
function Play(mp){ 
mp="<?=$SFS_PATH_HTML?>data/test/" + mp ;
Player.URL = mp;
}	
</script>

