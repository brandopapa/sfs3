<?php
//$Id: ad_item.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
sfs_check();

//if ($_POST){
//	echo "<PRE>";print_r($_POST);print_r($_GET);echo "</PRE>";
//	die();
//	}

//phpinfo();
//$_SESSION
#####################   �v���ˬd  ###########################
$ad_array=who_is_root();
if (!is_array($ad_array[$_SESSION[session_tea_sn]])){
if ($_POST[mid] || $_GET[mid] || $_POST[main_id] ) {
	$bb='';
	($_POST[mid]!='' ) ? $bb=$_POST[mid]:$bb;
	($_GET[mid]!='' ) ? $bb=$_GET[mid]:$bb;
	($_POST[main_id]!='' ) ? $bb=$_POST[main_id]:$bb;
if (check_man($_SESSION[session_tea_sn],$bb ,2)!='YES'   ) backe("�z�L�v���ާ@");
}}
//echo "<PRE>";
//print_r($_POST);
#####################   ���سB�z���  ###########################

if ($_POST[act]=='item_add') {
	if (strlen($_POST[enterclass])==0 || $_POST[playera]=='' || $_POST[passera]=='') backe("���񧴡I�A�Ӥ@���I");
	if ($_POST[sportkind]=='�����'|| $_POST[place]=='') backe("���񧴡I�A�Ӥ@���I");
	if ( $_POST[sunit]=='' ||$_POST[sord]=='') backe("�L�p���榡�αƦC�覡�I�A�Ӥ@���I");
	if ( $_POST[mid]=='' ||$_POST[item]==''  ) backe("�L�N���I�A�Ӥ@���I");
	$sporttime=$_POST[year1]."-".$_POST[year2]."-".$_POST[year3]." ".$_POST[year4].":00:00";
	$mid=$_POST[mid];
//	echo$sporttime."--<BR>";
	if($_POST[sportkind]==5){$kgp=$_POST[kgp];$kgm=$_POST[kgm];}
	else {$kgp=0;$kgm=0;}
	for ($i=0;$i<(strlen($_POST[enterclass])/2);$i++) {
	$worda=substr($_POST[enterclass],$i*2,2);//�C�����X�@�Ӧ~�ũʧO
	if ($_POST[createnexttime]=='yes'){
	$sql_insert = "insert into sport_item(mid,item,enterclass,sportkind,playera,passera,place,kind,skind ,sporttime,overtime,sunit,sord,imemo) values ('$_POST[mid]','$_POST[item]','$worda','$_POST[sportkind]','$_POST[playera]','$_POST[passera]','$_POST[place]','1','0' ,'$sporttime','$sporttime','$_POST[sunit]','$_POST[sord]','$_POST[imemo]') ";
	$rs=$CONN->Execute($sql_insert) or die($sql_insert);
	$linkid=$CONN->Insert_ID();
	$sql_insert = "insert into sport_item(mid,item,enterclass,sportkind,playera,passera,kgp,kgm,place,kind,skind ,sporttime,overtime,sunit,sord,imemo) values ('$_POST[mid]','$_POST[item]','$worda','$_POST[sportkind]','$_POST[playera]','$_POST[passera]','$kgp','$kgm','$_POST[place]','2', '$linkid' ,'$sporttime','$sporttime','$_POST[sunit]','$_POST[sord]','$_POST[imemo]') ";
	$rs=$CONN->Execute($sql_insert)or die($sql_insert);;
		}
	else{
		$SQL="insert into sport_item(mid,item,enterclass,sportkind,playera,passera,kgp,kgm,place,kind,skind ,sporttime,overtime,sunit,sord,imemo) values ('$_POST[mid]','$_POST[item]','$worda','$_POST[sportkind]','$_POST[playera]','$_POST[passera]','$kgp','$kgm','$_POST[place]','2','0' ,'$sporttime','$sporttime','$_POST[sunit]','$_POST[sord]','$_POST[imemo]') ";
	$rs=$CONN->Execute($SQL) or die($SQL);//�����إߨM��
			}
		}//����for�j��
		$url=$PHP_SELF."?mid=".$mid;header("Location:$url");
	}

#####################   ���حק�  ###########################
if (substr($_POST[act],0,6)=='update'){
	if ( $_POST[mid]==''  ) backe("�L�N���I�A�Ӥ@���I");
	$key=split("_",$_POST[act]);
	if ($key[1]=='' ) backe("�ާ@���~");
	foreach( $_POST[$key[1]]as $kk=>$val) {
		$sql="update sport_item set ".$key[1]."='$val' where id ='$kk' ";
		$rs = $CONN->Execute($sql) or die($sql);
		}
		$url=$PHP_SELF."?mid=".$_POST[mid];header("Location:$url");
	}
#####################   ���اR��  ###########################
if ($_GET[act]=="del" && $_GET[item]!='' && $_GET[mid]!='') {
	$rs = $CONN->Execute("select id from sport_res where itemid='$_GET[item]' ");
	if ( $rs->RecordCount()==0 ) {
		$CONN->Execute("DELETE FROM sport_item WHERE id='$_GET[item]' ");
		$url=$PHP_SELF."?mid=".$_GET[mid];header("Location:$url");
		}
	else {backe("�w����ơA�L�k�R���I");
	}
	}
#####################   ���ا�s  ###########################
if ($_POST[act]=="item_update"){
	if ($_POST[mid]=='' ||$_POST[id]=='' ) backe("���񧴡I�A�Ӥ@���I");
	if ( $_POST[sporttime]==''&&  $_POST[overtime]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[enterclass]==''&&  $_POST[item]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[sportorder]==''&&  $_POST[sportkind]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[playera]==''&&  $_POST[passera]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[place]=='') backe("����ܡI�A�Ӥ@���I");
	$sql="update sport_item set item='$_POST[item]',enterclass='$_POST[enterclass]', sportorder= '$_POST[sportorder]' , sportkind='$_POST[sportkind]' ,playera='$_POST[playera]', passera='$_POST[passera]' , place='$_POST[place]', sporttime='$_POST[sporttime]' , overtime='$_POST[overtime]' ,kind='$_POST[kind]' where id='$_POST[id]' ";
	$rs=$CONN->Execute($sql) or die($sql);
	$url=$PHP_SELF."?mid=$mid&act=modify&item=".$_POST[id];header("Location:$url");

	}

#####################   ���خɶ���s1  ###########################
if ($_POST[act]=="time_change1"){
	if ($_POST[mid]=='' ||$_POST[time_valve1]=='' ) backe("���񧴡I�A�Ӥ@���I");
	if ( $_POST[Ta]==''&&  $_POST[Tb]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[ttime]=='') backe("�п�ܤ覡�I�A�Ӥ@���I");
	if ( $_POST[ttimea]=='') backe("�п�ܤ覡�I�A�Ӥ@���I");
	$mid=$_POST[mid];
($_POST[ttime]=='d') ? $tt=' - ': $tt='';
	foreach( $_POST[Ta] as $kk=>$val) {
	$sql="update sport_item set sporttime=DATE_ADD(sporttime, INTERVAL $tt $_POST[time_valve1] $_POST[ttimea]) where id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);}
	if ($_POST[Tb]=='' ) {header("Location:".$PHP_SELF."?mid=$mid&act=chtime");}

	foreach( $_POST[Tb] as $kk=>$val) {
	$sql="update sport_item set  overtime=DATE_ADD( overtime, INTERVAL $tt $_POST[time_valve1] $_POST[ttimea])  where id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);
	}
	$url=$PHP_SELF."?mid=$mid&act=chtime";header("Location:$url");
	}
#####################   ���خɶ���s2  ###########################
if ($_POST[act]=="time_change2"){
	if ($_POST[mid]=='' ||$_POST[time_valve2]=='' ) backe("���񧴡I�A�Ӥ@���I");
	if ( $_POST[Ta]==''&&  $_POST[Tb]=='' ) backe("����ܡI�A�Ӥ@���I");
	if ( $_POST[Ttimeb]=='') backe("�п�ܤ覡�I�A�Ӥ@���I");
	$mid=$_POST[mid];
	foreach( $_POST[Ta] as $kk=>$val) {
	$sql="select  sporttime  from  sport_item where  id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);
	$arr=$rs->GetArray();
	$new_t=CT_1($_POST[Ttimeb],$arr[0][sporttime],$_POST[time_valve2]);
	$sql="update sport_item set  sporttime='$new_t'  where id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);
//	echo $sql."<BR>";
	}
	foreach( $_POST[Tb] as $kk=>$val) {
	$sql="select   overtime from  sport_item where  id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);
	$arr=$rs->GetArray();
	$new_t=CT_1($_POST[Ttimeb],$arr[0][overtime],$_POST[time_valve2]);
	$sql="update sport_item set  overtime='$new_t'  where id ='$kk' ";
	$rs = $CONN->Execute($sql) or die($sql);
//	echo $sql."<BR>";
	}
	$url=$PHP_SELF."?mid=$mid&act=chtime";header("Location:$url");
	}

function CT_1($in,$t,$v) {
$ck=$in-1;
$ta=split("[- :]",$t);
	for ($i=0;$i<count($ta);$i++) {
	($ck===$i) ? $ta[$i]=$v : $ta[$i]=$ta[$i];
	}
	$time=$ta[0]."-".$ta[1]."-".$ta[2]." ".$ta[3].":".$ta[4].":".$ta[5];
	return $time;
}


#####################   ���P���Y  ###########################

head("�v�ɺ޲z");
include_once "menu.php";
include_once "chk.js";
if($_GET[mid]=='') { print_menu($school_menu_p3);}
else {$link2="mid=$_GET[mid]"; print_menu($school_menu_p3,$link2);}

#####################   �{���D��  ###########################
($_GET[mid]=='') ? mmid2():  mmid2($_GET[mid]);
if ($_GET[mid]!='' && $_GET[act]=='') {
	($_GET[tb]=='' ) ? list_item($_GET[mid]): list_item($_GET[mid],$_GET[tb]);
	}
if ($_GET[mid]!='' && $_GET[act]=='add_tb') {
	item_tb($_GET[mid]);	}
if ($_GET[mid]!='' && $_GET[act]=='modify' && $_GET[item]!='' ) {
	item_edit($_GET[mid],$_GET[item]);}
if ($_GET[mid]!='' && $_GET[act]=='chtime' ) {
	list_time($_GET[mid]);}

foot();

#####################   �浧�s�ת��  ###########################
function item_edit($mid,$item){
	global $CONN,$sportclass,$sportkind_name,$sportname,$itemkind;
	$SQL="select * from sport_item where id='$item' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();

include_once"chi_text.js";

?>

<?
btt();
?>



<table border=0 width='80%' cellspacing=1 cellpadding=0 bgcolor=silver style='color:#800000;font-size:11pt;'>
<form method="post" action="<?=$_SERVER[PHP_SELF]?>" name="f1">
<tr bgcolor=#f2f2f2>
<td width=100% colspan=4 ><img src='images/21.gif'>&nbsp;<B>�涵�ק�</B>
<?btr("images/ch_back2.gif","���s��g");bt('item_update','�g�n�e�X','images/ch_save.gif')?>
<INPUT TYPE='button' value='��^�W��' onclick="location='<?=$_SERVER[PHP_SELF]?>?mid=<?=$mid?>';">
<INPUT TYPE='hidden' name='act' value=''>
</td>
</tr>
<tr bgcolor=white>
<td width=20% nowrap>�s��</td>
<td width=30% nowrap><input type=hidden name=id value='<?=$arr[0][id]?>'><?=$arr[0][id]?> </td>
<td width=20% nowrap>�D�D</td>
<td width=30% nowrap><input type=hidden name=mid value='<?=$arr[0][mid]?>'><?=$arr[0][mid]?></td>
</tr>
<tr bgcolor=white>
<td width=20% nowrap>�էO</td>
<td width=30% nowrap>
<? set_sport_selectb("enterclass",$sportclass,$arr[0][enterclass]);?>
<? set_sport_selectb("item",$sportname,$arr[0][item]);?>
<td width=20% nowrap>�W��/���O</td>
<td width=30% nowrap><? set_sport_selectb("kind",$itemkind,$arr[0][kind]);?>
<? set_sport_selectb("sportkind",$sportkind_name,$arr[0][sportkind]);?>
</td>
</tr>
<tr bgcolor=white>
<td width=20% nowrap>���ɶ���</td>
<td width=30% nowrap><input type='text' name='sportorder' value='<?=$arr[0][sportorder]?>' class=ipmei size=4 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);"></td>

<td width=20% nowrap>�C��/����</td>
<td width=30% nowrap>�C��
<input type='text' name='playera' value='<?=$arr[0][playera]?>' class=ipmei size=4 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);">

����
<input type='text' name='passera' value='<?=$arr[0][passera]?>' class=ipmei size=4 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);">
</td>
</tr>

<tr bgcolor=white>
<td width=20% nowrap>���ɳ��a</td>
<td width=80% nowrap colspan=3>
<input type='text' name='place' value='<?=$arr[0][place]?>' class=ipmei size=30 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);">
</td></tr>


<tr bgcolor=white>
<td width=20% nowrap>���ɮɶ�</td>
<td width=30% nowrap><input type='text' name='sporttime' value='<?=$arr[0][sporttime]?>' class=ipmei size=16 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);"> </td>
<td width=20% nowrap>�����ɶ�</td>
<td width=30% nowrap><input type='text' name='overtime' value='<?=$arr[0][overtime]?>' class=ipmei size=16 onfocus="this.select();return false ;" onkeydown="moveit2(this,event);"></td>
</tr>
<tr bgcolor=white>
<td width=20% nowrap>�����ɵ{</td>
<td width=80% nowrap colspan=3>
<?
$net_item=get_next_item($arr[0][id]);
$TTTT="<B style='color:blue;'>".$sportclass[$net_item[enterclass]].$sportname[$net_item[item]].$itemkind[$net_item[kind]]."</B>";
$FFFF="<B style='color:blue;'>�L��������</B>";
echo ($net_item=='') ? $FFFF:$TTTT ;
?></td></tr>
</form>
</table>
<B style='color:red;'>���Y�������ɵ{�A�Фp�߭ק�C</B>

   	  
<?
}

#####################   �s�W���1  ###########################
function item_tb($mid) {
	global $CONN,$sportclass,$sportkind_name,$sportname;
	$SQL="select * from sport_main where id='$mid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	echo"<form method='POST' action='$PHP_SELF' name='f1'>";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function add(n) {
	var str1=document.f1.enterclass.value;
	var str2=new String(n);
	if (str1.indexOf(str2,0)==-1) {
	document.f1.enterclass.value=str1+n;}
	else {
	document.f1.enterclass.value=str1.replace(n,'');}
}

//-->
</SCRIPT><BR>
<table align='center' bgColor='#eef8ff' border='0' borderColor='#9EBCDD' cellPadding='0' cellSpacing='1'>
<tr>
<td><img src='images/21.gif'>&nbsp;�s�W���ɶ���</td>
<td>
<INPUT TYPE='hidden' name='act' value=''>
<INPUT TYPE='text' NAME='ifo' value='' size='20' disabled style=' border-width: 0px; background-color:#eef8ff; font-size:12pt;color:#800000;'>
<input TYPE='image' align='top' border=0 SRC='images/ch_back2.gif' onclick="this.form.reset();return false;" alt='���s���' onmouseover="f1.ifo.value='���s���';" onmouseout="f1.ifo.value='';">
<input TYPE='image' align='top' border=0 SRC='images/ch_save.gif' 
onclick=" if (window.confirm('��J�����H')){this.form.act.value='item_add';this.form.sumit();}return false;" alt='��J����' 
onmouseover="f1.ifo.value='��J����';" onmouseout="f1.ifo.value='';">
</td>
</tr>
<tr style='color:red'>
<td align='right' bgColor='#9EBCDD'>��g����</td>
<td style='color:red;font-size:9pt'>����|�@���إߨC�@���ժ����ظ�ơC<BR>
���C�@���ժ��v�ɶ��ǻP�ɶ������@�@�]�w�C<BR>
�_�h�˿���P�ɵ{��W���|�X�{������ơC
</td>
</tr><tr>
<td align='right' bgColor='#9EBCDD'>��ƽs��</td>
<td>
�D�D�s�� 
<?php
echo "<INPUT TYPE='hidden' name='id' value=''>";
echo"<INPUT TYPE='hidden' name='mid' value='$mid'>$mid";
?>


</td></tr>
<tr>
<td align='right' bgColor='#9EBCDD'><FONT  COLOR='red'>*</FONT>���ئW��</td>
<td>
<?php
set_sport_selectb("item",$sportname);
?>
<input type='checkbox' name='createnexttime' value='yes'><B style='color:#800000;'>�@�֫إߪ���</B>
<B style='font-size:10pt;'>(����ɪ����إߨM��)</B>
</td>
</tr>
<tr>
<td align='right' bgColor='#9EBCDD'><FONT  COLOR='red'>*</FONT>���ɤ��</td>
<td>
<?php
set_time_select("year1",date("Y")-5,date("Y")+5,date("Y"));//�~��
echo"�~";
set_time_select("year2",1,13,date("m"));//��
echo"��";
set_time_select("year3",1,32,date("d"));//��
echo"��";
set_time_select("year4",1,24,date("G"));//��
echo"��&nbsp;&nbsp;<FONT  COLOR='red'>*</FONT>���O";
set_sport_selectb("sportkind",$sportkind_name);
?>
</td></tr>
<tr>
<td align='right' bgColor='#9EBCDD'><FONT  COLOR='red'>*</FONT>�i���ɲէO</td><td>
<input name='enterclass' size='20' value='' readonly class=ipmei>
<FONT  COLOR='#999999'>�������k�k�h�k�k������</FONT><br>
<?php
$i=0;
foreach($sportclass as $key => $value) {

echo "
<input type='checkbox' name='enterclassa[".($i+1)."]' value='$key' 
onclick=\"add(this.value);\">$value";
	if ($i%6==5){echo"<BR>";}
	$i++;
}
?>
</td>
</tr>
<tr>
<td align='right' bgColor='#9EBCDD'>�ɵ{</td>
<td>���ɨC��
<input name='playera' size='3' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;'>
<FONT  COLOR='red'>*</FONT>�H�A�����e
<input name='passera' size='3' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;'>
<FONT  COLOR='red'>*</FONT>�W�i�J�M�ɡC<BR>
<FONT  COLOR='red'>*</FONT>�B�~����
<input name='imemo' size='18' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;'>
<BR>
<FONT SIZE='-1' COLOR='blue'>�ҿרC��,�O���C���P�ɶ��h�֤H���ɡC�Ҧp�P���ɶ]���H<BR>
�B�~�����G�Ҧp�y���u2�H�z�C�S���B�~������N���n��C</FONT>
</td></tr>
<tr>
<td align='right' bgColor='#9EBCDD'>���Z�P�p��</td>
<td><FONT  COLOR='red'>*</FONT>�p���榡
<input name='sunit' size='10' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;'><BR>
<FONT SIZE='-1' COLOR='blue'>�v������0.00.00.0��ܮ�.��.��.x<BR>
��������00.00.0 ��ܤ���.����.x<BR>
�y������000��ܱo��</FONT>
<BR><FONT  COLOR='red'>*</FONT>
�ƦC�覡<SELECT NAME='sord'>
<option value=''>�����</option>
<option value='1'>���ƧC�A���Z�n</option>
<option value='2'>���ư��A���Z�n</option>
</SELECT><BR>
<FONT SIZE='-1' COLOR='blue'>���ƧC�A���Z�n�G�p�ɶ]�C<BR>���ư��A���Z�n�G�p���������C</FONT>
</td></tr>
<tr>
<td align='right' bgColor='#9EBCDD'>����</td>
<td>�ҿרC��,�O���C���P�ɶ��h�֤H���ɡC�Ҧp�P���ɶ]���H</td>
</tr>
<tr>
<td align='right' bgColor='#9EBCDD'><FONT  COLOR='red'>*</FONT>���ɦa�I</td>
<td><input name='place' size='20' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;'>
</td></tr>
<tr>
<td align='right' bgColor='#9EBCDD'><FONT  COLOR='red'>*</FONT>���O���ﶵ</td>
<td>�C���i���W�ռ�
<input name='kgp' size='3' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;' value='0'>
�C�դH��
<input name='kgm' size='3' style='font-size:14pt;color:blue;background-color: #FFCCCC;border-width:0px;' value='0'>
<FONT SIZE='-1' COLOR='blue'>(�D���O����0)</FONT></td></tr>

</FORM>
<tr><td align='right' bgColor='#9EBCDD' colspan='2'> 
<p align='center'>�{���]�p:�G�L��p������</td> 
</tr>
</table>
</table> <?
}


#####################   �C�ܥD�n����  ###########################
function mmid2($gmid='') {
			global $CONN;
	($gmid=='') ? $SQL="select * from sport_main order by year desc": $SQL="select * from sport_main where id='$gmid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
echo "<TABLE border=0 width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=#9EBCDD><TR align=center bgcolor='#9EBCDD'><TD width=6%>����</TD>
	<TD width=30% >�W��  </TD>
	<TD width=10%>���</TD>
	<TD width=27%>�Z�ų��W�P�I��</TD>
	<TD width=27%>�j�|�ާ@�P�I��</TD>
</TR>";
for($i=0; $i<$rs->RecordCount(); $i++) {

echo "<TR align=center bgcolor='#FFFFFF'><TD>".$arr[$i][id]."</TD>
	<TD align=left><A HREF='$PHP_SELF?mid=".$arr[$i][id]."'>".$arr[$i][title]."</A></TD>
	<TD>".$arr[$i][year]."</TD>
	<TD style='font-size:9pt;' >".substr($arr[$i][signtime],0,13)." -- ".substr($arr[$i][stoptime],0,13)."</TD>
	<TD style='font-size:9pt;'>".substr($arr[$i][work_start],0,13)." -- ".substr($arr[$i][work_end],0,13)."</TD>
</TR>";
}
echo "</TABLE>";
}

#####################   �C�ܤl����  ###########################
function list_item($mid,$tb='') {
			global $CONN,$sportclass,$sportname,$itemkind,$sportkind_name;
	$SQL="select * from sport_item where mid='$mid' order by  enterclass,sportkind,kind ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
include_once"chi_text.js";

echo "<TABLE border=0 width=100% style='font-size:10pt;'  cellspacing=1 cellpadding=0 bgcolor=Silver>
<tr bgcolor=#F2F2F2 >
<TD width=100% colspan=13>
<img src='images/21.gif'><A HREF='$_SERVER[PHP_SELF]'>��^�D�D�C��</A>
���s�׿ﶵ<img src='images/arrow.gif'>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&act=add_tb'>�s�W����</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=playera'>�C�դH��</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=passera'>�����H��</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=kgp'>�ռ�(���O)</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=kgm'>�H��(���O)</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=sportorder'>�ɵ{����</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=sunit'>�榡</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=sord'>�̾�</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=imemo'>�B�~</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&act=chtime'>�ɶ��վ�</A>
</TD></tr>";
if ($tb!='' ){
$echo_str="<tr bgcolor=#F2F2F2 align=center><TD colspan=13><INPUT TYPE='hidden' name=mid value='".$mid."'>
<INPUT TYPE='hidden' name=act value='update_$tb'>
<INPUT TYPE='reset'>&nbsp;<INPUT TYPE='submit' value='��n�e�X'></TD></tr>";
}

echo"
<FORM METHOD=POST ACTION='$PHP_SELF' name='f1'>$echo_str<tr bgcolor=#F2F2F2 align=center>
<TD width=4% nowrap>����</TD>
	<TD width=18%  nowrap>�W�� </TD>
	<TD width=12%  nowrap>�ʧ@</TD>
	<TD width=8% nowrap>���O</TD> 
	<TD width=6% nowrap>�C��</TD>
	<TD width=6% nowrap>����</TD>
	<TD width=6% nowrap>�ռ�</TD>
	<TD width=6% nowrap>�H��</TD>
<TD width=6% nowrap>�ɵ{��</TD>
	<TD width=6% nowrap>�v���W</TD>

	<TD width=8% nowrap>���Z�榡</TD>
	<TD width=6% nowrap>���Z�̾�</TD>
	<TD width=10% nowrap>�B�~</TD>
</TR><tr bgcolor=#F2F2F2><TD colspan=12 style='color:blue;'>���Z�̾ڡG1��ܤ��ƧC���Z�n,2��ܤ��ư����Z�n<BR>
�ռơG�����O���C�Z�i���X�աA�H�ƫ��C�եi���h�֤H�A�D���O���ж�0�C
<TD></TR>";

for($i=0; $i<$rs->RecordCount(); $i++) {
($i%10==9 && $i!=0 )? $bgc="#F2F2F2": $bgc="#FFFFFF";
($tb=='playera')? $arr[$i][playera]="<INPUT TYPE='text' NAME='playera[".$arr[$i][id]."]' value='".$arr[$i][playera]."' size=2 class=ip2  onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][playera]=$arr[$i][playera];
($tb=='passera')? $arr[$i][passera]="<INPUT TYPE='text' NAME='passera[".$arr[$i][id]."]' value='".$arr[$i][passera]."' size=2 class=ip2 onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][passera];
($tb=='sportorder')? $arr[$i][sportorder]="<INPUT TYPE='text' NAME='sportorder[".$arr[$i][id]."]' value='".$arr[$i][sportorder]."' size='3' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][sportorder];
($tb=='sunit')? $arr[$i][sunit]="<INPUT TYPE='text' NAME='sunit[".$arr[$i][id]."]' value='".$arr[$i][sunit]."' size='10' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][sunit];
($tb=='sord')? $arr[$i][sord]="<INPUT TYPE='text' NAME='sord[".$arr[$i][id]."]' value='".$arr[$i][sord]."' size='3' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][sord];
($tb=='imemo')? $arr[$i][imemo]="<INPUT TYPE='text' NAME='imemo[".$arr[$i][id]."]' value='".$arr[$i][imemo]."' size='12' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][imemo];
($tb=='kgp')? $arr[$i][kgp]="<INPUT TYPE='text' NAME='kgp[".$arr[$i][id]."]' value='".$arr[$i][kgp]."' size='2' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][kgp];
($tb=='kgm')? $arr[$i][kgm]="<INPUT TYPE='text' NAME='kgm[".$arr[$i][id]."]' value='".$arr[$i][kgm]."' size='2' class='ip2' onfocus=\"this.select();\" onkeydown=\"moveit2(this,event);\" >":$arr[$i][kgm];


($arr[$i][skind]==0) ? $bb="":$bb="&nbsp;&nbsp;";
echo "<TR align=center bgcolor=$bgc><TD>".$arr[$i][id]."</TD>
<TD align=left  nowrap>$bb".$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]]."</TD>
<TD nowrap><A HREF='$PHP_SELF?mid=$mid&act=modify&item=".$arr[$i][id]."'>�ק�</A>
<A HREF='$PHP_SELF?mid=$mid&act=del&item=".$arr[$i][id]."'>�R��</A></TD>
<TD nowrap>".$sportkind_name[$arr[$i][sportkind]]."-". $itemkind[$arr[$i][kind]]."</TD>
<TD>".$arr[$i][playera]."�H</TD>
<TD>".$arr[$i][passera]."�W</TD>
<TD>".$arr[$i][kgp]."��</TD>
<TD>".$arr[$i][kgm]."�H</TD>
<TD>".$arr[$i][sportorder]."</TD>
<TD>".$arr[$i][res]."</TD>
<TD>".$arr[$i][sunit]."</TD>
<TD>".$arr[$i][sord]."</TD>
<TD>".$arr[$i][imemo]."</TD>


</TR>";
}
echo "</FORM></TABLE>";
}
#####################   �ק�ɶ�  ###########################
function list_time($mid) {
			global $CONN,$sportclass,$sportname,$itemkind,$sportkind_name;
	$SQL="select * from sport_item where mid='$mid' and skind=0 order by  enterclass,sportkind,kind ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
echo "<TABLE border=0 width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=Silver>
<tr bgcolor=#F2F2F2><TD width=100%>
<img src='images/21.gif'><A HREF='$_SERVER[PHP_SELF]'>��^�D�D�C��</A>
���s�׿ﶵ<img src='images/arrow.gif'>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&act=add_tb'>�s�W����</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=playera'>�C�դH��</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=passera'>�����H��</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&tb=sportorder'>�ɵ{����</A>
<img src='images/dia_bluve.gif'><A HREF='$PHP_SELF?mid=$mid&act=chtime'>�ɶ��վ�</A>
</TD></tr>";

?>

<tr bgcolor=#ffffff ><TD width=100%>
<FONT COLOR='#990000'>�վ�@�~�G</FONT><?btt();?>
<FORM METHOD=POST ACTION='<?=$PHP_SELF?>' name='f1'>
<INPUT TYPE='hidden' name=act value=''>
<INPUT TYPE='hidden' name=mid value='<?=$mid?>'>
<div style="margin-left: 40pt;background-color:#F2F2F2">
<?bt('time_change1','�ĥΤ覡���N�_�ﶵ���ܧ�ɶ�','images/00_check.gif')?>
�覡1�G�N�_���
<INPUT TYPE='radio' NAME='ttime' value='a'>�W�[
<INPUT TYPE='radio' NAME='ttime' value='d'>���
<INPUT TYPE='text' NAME='time_valve1' class=ipmei size=6>
<?
$gg=array('1'=>'�~','2'=>'��','3'=>'��','4'=>'��','5' =>'��');
$gg1=array('MONTH'=>'��','DAY'=>'��','HOUR'=>'��','MINUTE' =>'��');
//$gg1=array(m=>"MONTH",d=>"DAY",h=>"HOUR"=>"��",MINUTE =>"��");

set_sport_selectb("ttimea",$gg1);
?>
<BR>
<?bt('time_change2','�ĥΤ覡���N�_�ﶵ���ܧ�ɶ�','images/00_check.gif')?>

�覡2�G���ܹ_��̪�<?set_sport_selectb("Ttimeb",$gg);?>���ܬ� 
<INPUT TYPE='text' NAME='time_valve2' class=ipmei size=6><BR>
<?btr("images/ch_back2.gif");?>

</div>
</TD></TR><tr bgcolor=#ffffff ><TD width=100% nowrap style='font-size:10pt;'>
<FONT COLOR='#990000'>��Ʈ榡�G</FONT>����-�}�l�ɶ�..�����ɶ�<BR>
<?
	//2004-12-05 05:06:00
for($i=0; $i<$rs->RecordCount(); $i++) {
	$Ta=split("[- :]",$arr[$i][sporttime]);
	$Tb=split("[- :]",$arr[$i][overtime]);
echo $bb."<img src='images/closedb.gif'>".
	$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]].
	"<INPUT TYPE='checkbox' NAME='Ta[".$arr[$i][id]."]'>\n".
	"<B style='color:#cccccc;'>".$Ta[0]."</B>&nbsp;".
	"&nbsp;<B style='color:#FF0000;'>".$Ta[1]."-".$Ta[2]."</B>&nbsp;".
	"<FONT COLOR='#0000ff'>".$Ta[3].":".$Ta[4]."</FONT> �� ".
	"<INPUT TYPE='checkbox' NAME='Tb[".$arr[$i][id]."]'>".
	"<B style='color:#cccccc;'>".$Tb[0]."</B>&nbsp;".
	"&nbsp;<B style='color:#FF0000;'>".$Tb[1]."-".$Tb[2]."</B>&nbsp;".
	"<FONT COLOR='#0000ff'>".$Tb[3].":".$Tb[4]."</FONT>\n&nbsp;&nbsp;".sub_item($arr[$i][id])."<BR>";
}
echo "</TD></TR></TABLE></FORM>";
}

function sub_item($aa){
			global $CONN,$sportclass,$sportname,$itemkind,$sportkind_name;
	$SQL="select * from sport_item where skind='$aa'  ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$BB='';
	if ($rs->RecordCount()==1) {
	$arr=$rs->GetArray();
	$Ta=split("[- :]",$arr[0][sporttime]);
	$Tb=split("[- :]",$arr[0][overtime]);

	$BB="<img src='images/closedb.gif'>".
	$sportclass[$arr[0][enterclass]].$sportname[$arr[0][item]].$itemkind[$arr[0][kind]].
	"<INPUT TYPE='checkbox' NAME='Ta[".$arr[0][id]."]'>\n".
	"<B style='color:#cccccc;'>".$Ta[0]."</B>&nbsp;".
	"&nbsp;<B style='color:#FF0000;'>".$Ta[1]."-".$Ta[2]."</B>&nbsp;".
	"<FONT COLOR='#0000ff'>".$Ta[3].":".$Ta[4]."</FONT> �� ".
	"<INPUT TYPE='checkbox' NAME='Tb[".$arr[0][id]."]'>".
	"<B style='color:#cccccc;'>".$Tb[0]."</B>&nbsp;".
	"&nbsp;<B style='color:#FF0000;'>".$Tb[1]."-".$Tb[2]."</B>&nbsp;".
	"<FONT COLOR='#0000ff'>".$Tb[3].":".$Tb[4]."</FONT>\n";}

return $BB;

}
?>
