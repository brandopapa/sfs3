<?
include "config.php";
 include "$SFS_PATH/pnadodb/tohtml.inc.php";
sfs_check();

//if ($_POST){
//	echo "<PRE>";print_r($_POST);print_r($_GET);echo "</PRE>";
//	die();
//	}
#####################   ���حק�  ###########################
if (substr($_POST[act],0,6)=='update'){
	$key=split("_",$_POST[act]);//update_XXX
	if ($key[1]=='' ) backe("�ާ@���~");
	$Col_name=$key[1];
	if($Col_name=='add' ) {
		if ($_POST[gp]=='' ) backe("���񧴡A���U�᭫��I");
		if ($_POST[kkey]=='' ) backe("���񧴡A���U�᭫��I");
		if ($_POST[na]=='' ) backe("���񧴡A���U�᭫��I");
		$sql="insert into  sport_var(gp,kkey,na)values('$_POST[gp]','$_POST[kkey]','$_POST[na]') ";
		$rs = $CONN->Execute($sql) or die($sql);
		header("Location:$_SERVER[PHP_SELF]");
		}
	foreach( $_POST[$Col_name] as $id=>$val) {
		$sql="update sport_var set ".$Col_name."='$val' where id ='$id' ";
//		echo$sql."<BR>";
		$rs = $CONN->Execute($sql) or die($sql);
		}
		header("Location:$_SERVER[PHP_SELF]");
//	gonow($_SERVER[PHP_SELF]."?mid=$mid");exit;
	}

//phpinfo();
//$_SESSION
#####################   �v���ˬd  ###########################
$ad_array=who_is_root();
if (!is_array($ad_array[$_SESSION[session_tea_sn]])) backe("�z�D�t�κ޲z�̡I�L�ާ@�v���I");
//if (check_man($_SESSION[session_tea_sn],$bb ,2)!='YES'   )
//echo "<PRE>";print_r($ad_array);
head("�v�ɺ޲z");
include_once "menu.php";
include_once "chk.js";
include_once "chi_text.js";

if($_GET[mid]=='') { print_menu($school_menu_p3);}
else {$link2="mid=$_GET[mid]"; print_menu($school_menu_p3,$link2);}

//rs2html($rs,'border=0 cellpadding=1',array('�s��','����','���ޭ�','��ƭ�'));
?>
<table border=0 width='100%' >
<tr bgcolor=white><td width='60%'  valign=top>

<table border=0 width='100%' style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>
<tr bgcolor=white>
<TD width=100% colspan=4>
���s�׿ﶵ<?
echo "<img src='images/dia_bluve.gif'><A HREF='$_SERVER[PHP_SELF]?tb=add'>�s�W�ﶵ</A>
<img src='images/dia_bluve.gif'><A HREF='?tb=gp'>�����s��</A>
<img src='images/dia_bluve.gif'><A HREF='?tb=kkey'>���ޭȽվ�</A>
<img src='images/dia_bluve.gif'><A HREF='?tb=na'>��ƭȽվ�</A>
</TD></tr><FORM METHOD=POST ACTION='$_SERVER[PHP_SELF]' NAME='f1'>";?>
<tr bgcolor=white align=center>
<td width=10%>�s��</td><td width=30%>����/�ܼƦW��</td>
<td width=20%>���ޭ�</td><td width=40%>��ƭ�</td>
</tr>
<?
if($_GET[tb]!='') {
	echo "<tr bgcolor=white align=center><td colspan=4 align=right>
<INPUT TYPE='reset' value='���s���' class=bur>&nbsp;
<INPUT TYPE=button  value='�g�n�e�X���' onclick=\" bb('�g�J��ơHOK�H','update_$_GET[tb]');\" class=bur>
<INPUT TYPE=button  value='������^' onclick=\"location.href='$_SERVER[PHP_SELF]';\" class=bur>
<INPUT TYPE='hidden' name='act' value=''>
</td></tr>";

}

if($_GET[tb]=='add') {
echo "<tr bgcolor=white align=center>
<td width=10%><img src='images/arrow.gif'></td><td width=30%>
<INPUT TYPE='text' NAME='gp' value='' size=20 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" ></td>
<td width=20%>
<INPUT TYPE='text' NAME='kkey' value='' size=6 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" ></td><td width=40%>
<INPUT TYPE='text' NAME='na' value='' size=20 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" ></td>
</tr>";

}
	$SQL="select * from sport_var order by gp ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
for($i=0; $i<count($arr); $i++) {
$id_1=$arr[$i][id];
($_GET[tb]=='gp') ? $gp_1="<INPUT TYPE='text' NAME='gp[".$arr[$i][id]."]' value='".$arr[$i][gp]."' size=20 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$gp_1=$arr[$i][gp];
($_GET[tb]=='kkey') ? $kkey_1="<INPUT TYPE='text' NAME='kkey[".$arr[$i][id]."]' value='".$arr[$i][kkey]."' size=6 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$kkey_1=$arr[$i][kkey];
($_GET[tb]=='na') ? $na_1="<INPUT TYPE='text' NAME='na[".$arr[$i][id]."]' value='".$arr[$i][na]."' size=20 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$na_1=$arr[$i][na];




echo "
<tr bgcolor=white align=center>
<td>$id_1</td><td>$gp_1</td>
<td>$kkey_1</td><td align=left>$na_1</td>
</tr>";
}


?>

</FORM>
</table></td>
<td width='40%' valign=top>
<PRE style='color:#800000;font-size:10pt;'>���G
1.�P�@�Ӥ����U���ޭȬO�ߤ@���A���୫�ơC

2.��ƭȪ����ܾA�y�w�˼Ҳիᰨ�W�ק�C
  ����z�v�ϥΥ��ҲեB��ڹB�@��A���ܸ�ƭ�
  �N�ϱz�H�e���ɪ��O�����s���W�١C
  �ҥH��z��ڹB�@��N���y�A��A���s�W�h�������C

3.�U�@�o�ر��εo�ͤF�A�z�٬O�i�H�A��^�H�e���]�w
  �h�H�e���ɪ��O���N�|�A���즳���W�٭ȡC
  </PRE>
</td>
</tr>
</table>
<BR><BR><BR>
<?
foot();
?>
