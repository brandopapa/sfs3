<?php
include"config.php";
sfs_check();
##############��ƳB�z############
if($_POST[wek]!='' && $_POST[unit]!='' && $_POST[event]!='' && $_POST[syear]!=''){
$day=date("Y-m-d H:i:s");
foreach( $_POST[wek] as $key=>$val) {
$SQL="INSERT INTO cal_elps(syear,week,unit,event,user,day) VALUES ('$_POST[syear]', '$key', '$_POST[unit]', '$_POST[event]', '$_SESSION[session_tea_sn]','$day')";
//echo $SQL."<br>";
	$rs=$CONN->Execute($SQL) or die($SQL);
	}
	header("Location:cal_edit.php?syear=$_POST[syear]");
}





##########################
head("�հȦ�ƾ�");
if($_GET[syear]=='') { print_menu($school_menu_p);}
else {$link2="syear=$_GET[syear]"; print_menu($school_menu_p,$link2);}

myheader();
$now_Syear=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�

if ($_GET[syear]){
$SQL="select * from cal_elps_set where syear='$_GET[syear]' ";
$arr=get_data($SQL);
$barr=$arr[0];
}

$cal_name=substr($barr[syear],0,3)."�Ǧ~�ײ�".substr($barr[syear],3,1)."�Ǵ� �հȦ�ƾ� �s�W���";

echo cal_sel("xxx",$_GET[syear])."<B style='color:red'> << </B>�Х����";
?>
<TABLE border=0 width=85% style='font-size:12pt;' cellspacing='1' cellpadding=3 bgcolor='lightGray'>
<TR bgcolor=white><td colspan=2 align=center>
<h3><?php echo $cal_name; ?></h3>
</td></tr><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name=f1>
<TR bgcolor=#9EBCDD>
<td width=25%>�W��</td>
<td width=75%>�]�w��</td></tr>
<tr bgcolor=white><td>�Ǧ~��</td>
<td><input type="text" name="syear" size=6 value="<?php echo $barr[syear]; ?>" class=ipmei>
</td></tr>
<tr bgcolor=white><td>��ܦ�ƶg�O<BR><B style='color:red'>(�i�ƿ�)</B></td>
<td>
<?php
for ($i=1;$i<=$barr[weeks];$i++){
echo "<input type=checkbox name='wek[$i]' >�� $i �g";
if ($i%5==0)echo "<br>\n";
}
?>
</td></tr>
<tr bgcolor=white><td>�������O</td>
<td>
<?php
	//$unit=split("@@@",$barr[unit]);//���}�C
	$unit=explode("@@@",$barr[unit]);//���}�C
	$unit_nu=count($unit);//������
echo set_select2("unit",$unit,'');
?>
</td></tr>

<tr bgcolor=white><td>��ưO��<BR><B style='color:red'>�ȶ�@�Ӥu�@����</B></td>
<td>
<textarea name="event" rows="5" cols="40" class=ipmei></textarea>
</td></tr>
<tr bgcolor=white><td colspan=2>
<input type="submit" name="sum" value="��n�e�X"><BR><FONT COLOR='#FF0000'>��g�ɥH�y�h�g��u�z����h�C</FONT><BR>
(�@����h�g,�C���ȶ�@�Ӥu�@����)<BR>
�Х���ܨ��X�g�n���o��u�@�A�A��g�u�@���e�C<BR><BR>

�Ҧp�G�V�ɤ譱��1�g�i�঳1.�ˬd�⩬ 2.�Z�ҽå��ˬd 3.�����V�m�T�Ӥu�@����<BR>
�h���T����g�C�Ĥ@����y�ˬd�⩬�z�B���n��s��(123..)�A�H�������C<BR>
��g��<I><U>�N�ۦP�u�@���ت��g��</U></I>�]�@�ֿ�n�C<BR><BR>
�H����k�椧�A�ܧִN�N�ӾǴ�����ƾ䧹���F�C

</td></tr>
</form>
</table>
<?php



foot();

?>
