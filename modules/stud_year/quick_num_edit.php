<?
//$Id: quick_num_edit.php 5310 2009-01-10 07:57:56Z hami $
include "stud_year_config.php";
//include "../../include/sfs_case_subjectscore.php";

//�{��
##################����ƨ禡###########################
function get_order2($SQL) {
	//����,�覡,(�ĴX��,�C�դH��,�ƧǨ�)
	global $CONN ;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
###############################################
sfs_check();
//echo $_POST[act];
if($_POST[act]=='wri' && $_POST[Syear]!='' && $_POST[Sclass]!='' &&$_POST[stu_sn]!=''){
	$now_Syear=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�
	foreach($_POST[stu_sn] as $stu_sn=>$stu_num){
		$Sql_1="update stud_seme set  seme_num='$stu_num' where seme_year_seme='$_POST[Syear]' and  seme_class= '$_POST[Sclass]' and  student_sn ='$stu_sn' ";
		$curr_class_num=$_POST[Sclass].sprintf("%02d",$stu_num);//�զXcurr_class_num��
		$Sql_2="update stud_base set curr_class_num='$curr_class_num' where  student_sn ='$stu_sn' ";
		$rs=$CONN->Execute($Sql_1) or die($Sql_1);
		if ($now_Syear==$_POST[Syear]){
			$rs=$CONN->Execute($Sql_2) or die($Sql_2);
			}//�ثe�Ǧ~�~����curr_class_num��
//		echo $Sql_1."<BR>".$Sql_2."<BR>";
		}//end foreach
	header("Location:$_SERVER[PHP_SELF]?Syear=$_POST[Syear]&Sclass=$_POST[Sclass]");
}



$Sex=array(1=>"<FONT  COLOR='blue'>�k</FONT>",2=>"<FONT SIZE='' COLOR='red'>�k</FONT>");
$Sex_img=array(1=>"<img src=$SFS_PATH_HTML"."modules/stud_reg/images/boy.gif>",2=>"<img src=$SFS_PATH_HTML"."modules/stud_reg/images/girl.gif>");
$Ord=array("a.stud_sex"=>"�ʧO","b.stud_id"=>"�Ǹ�","b.seme_num"=>"��y��","a.stud_name"=>"�m�W","a.stud_birthday"=>"�ͤ�");
$Ord1=array("ASC"=>"�ѧC�찪","DESC"=>"�Ѱ���C");

###############   �{���}�l    ###################################

($_GET[Syear]!='') ? $Syear=$_GET[Syear]:$Syear=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�//�ثe�Ǧ~
if($_GET[Sclass]!='') $Sclass=$_GET[Sclass];
($Sclass) ? $LINK=link_a($Syear,$Sclass): $LINK=link_a($Syear);
head("�s�Z�@�~");
myheader();
$linkstr = "Syear=$Syear&Sclass=$Sclass";
print_menu($menu_p,$linkstr);
echo "
<TABLE border=0 width=100% style='font-size:10pt;'  cellspacing=1 cellpadding=0 bgcolor=#9EBCDD>
<TR bgcolor=#9EBCDD><FORM name=p2><TD  nowrap> $LINK
�Ǧ~��<INPUT TYPE='text' NAME='Syear' value='$Syear' size=6 class=ipmei>
<INPUT TYPE='submit' value='�̾Ǧ~�׻P�Z�ŦC�X'>
</TD></TR></FORM></TABLE>";


if($_POST[aa] && $_POST[bb]){
	$Ord_word=array();
	foreach($_POST[aa] as $pkey=>$pval) {
	if ($pval!='') $Ord_word[]=$pval." ".$_POST[bb][$pkey];
	}
	$Ord_word2 = implode (",", $Ord_word);
	}
if ($Ord_word2=='' )$Ord_word2="b.seme_num";

$SQL1="select b.stud_id, b.seme_num, a.stud_name, a.stud_sex, a.student_sn  ,a.stud_study_year, a.stud_birthday  from  stud_base a , stud_seme b where  a.student_sn= b.student_sn  and b.seme_year_seme='$Syear' and b.seme_class='$Sclass'  and a.stud_study_cond=0  order by  $Ord_word2 ";
$arr=get_order2($SQL1);

echo "
<table border=0  width=100% style='font-size:10pt;'  cellspacing=0 cellpadding=0 bgcolor=silver>
<TR bgcolor=white>
<TD width=40% valign=top><fieldset><legend><B>�ާ@����</B></legend>
<FONT SIZE=2 COLOR='blue'>���ާ@�����G</FONT><BR>
1.����ܯZ�ŦC�ܾǥ͡C<BR>
2.����u������(�i���Φh��),<BR>�A���i�̧ڿ�ܦC�ܡj�C<BR>
3.���N��,�A����̤U���<BR>�i�̥ثe�w�]�s�y����s��ơj�C<BR>
<FONT COLOR='red'>4.���{���A�X��Ǵ���ɰt�X�s�Z�ϥ�,�����ɤ���ĳ�ϥ�,�H�K�v�T��L��ƪ����T�ʡC</FONT>
<BR>
<FORM METHOD=POST ACTION='$_SERVER[PHP_SELF]?Syear=$Syear&Sclass=$Sclass' name='C1'>";


//for($i=0;$i<count($Ord);$i++) {
$i=0;
foreach($Ord as $View_key=>$View_val){
echo "<FONT COLOR='#0000FF'>����<B style='color:red;'>".($i+1)."</B>�u��</FONT><BR>\n";
echo set_select("aa[$i]",$Ord,$_POST[aa][$i]);
echo set_select("bb[$i]",$Ord1,$_POST[bb][$i])."<BR><BR>\n";
$i++;
}

echo "
<INPUT TYPE='button' NAME='b1' value='���s�]�w' onclick=\"location.href='$_SERVER[PHP_SELF]?Syear=$Syear&Sclass=$Sclass';\">
<INPUT TYPE='submit' NAME='b2'  value='�̧ڿ�ܦC��'></FORM>
<BR>
<FONT COLOR='#0000FF'>���ƿ��ǰȨt�α��s�p��</FONT>
</fieldset></TD>";


echo"<TD width=60% valign=top><fieldset><legend><B>�C�ܭ�Z�W�U</B></legend>
<table border=0  width=100% style='font-size:10pt;'  cellspacing=1 cellpadding=1 bgcolor=silver>
<TR align=center bgcolor=#9EBCDD><TD><FONT  COLOR='#FF0000'>�w�]<BR>�s�y��</FONT></TD>
<TD>�m�O</TD>
<TD>��y��</TD>
<TD>�Ǹ�</TD>
<TD>�m�W</TD>
<TD>�ͤ�</TD></TR><FORM METHOD=POST ACTION='$_SERVER[PHP_SELF]' name='C2'>
<INPUT TYPE='hidden' NAME='act'  value=''>
<INPUT TYPE='hidden' NAME='Syear'  value='$Syear'>
<INPUT TYPE='hidden' NAME='Sclass'  value='$Sclass'>";
//�C�ܭ�Z�H��
for ($i=0;$i<count($arr);$i++) {
$SO_S="<INPUT TYPE='text' NAME='stu_sn[".$arr[$i][student_sn]."]' value='".($i+1)."' size=5 class=ip3>";
//echo<INPUT TYPE='text' NAME='' value=''> "<TR><TD>".$SO_S.$Sex[$arr[$i][stud_sex]].$arr[$i][seme_num].$arr[$i][stud_name]."&nbsp;</td></tr>";
echo "<TR bgcolor=white>
<TD width=15%>$SO_S</TD>
<TD width=15%>".$Sex[$arr[$i][stud_sex]]."</TD>
<TD width=15%>".$arr[$i][seme_num]."</TD>
<TD width=15%>".$arr[$i][stud_id]."</TD>
<TD width=20%>".$arr[$i][stud_name]."</TD>
<TD width=20%>".$arr[$i][stud_birthday]."</TD></TR>";
//if($i%7==6 && $i!=0 ) echo "<BR>";
}
echo "<TR bgcolor=white><TD colspan=6>
<INPUT TYPE='button' NAME='b1' value='�̥ثe�w�]�s�y����s���' onclick=\"this.form.act.value='wri';this.form.submit();\">
</TD></TABLE>";

echo "</fieldset></TD></TR></FORM></TABLE>";
//&date_select($a, $b, $c, $d, $e)

#####################   �Z�ſ��  ###########################
function link_a($Syear,$Sclass=''){
//		global $PHP_SELF;//$CONN,
	$class_name_arr = class_base($Syear) ;
	$ss="��ܯZ�šG<select name='Sclass' size='1' class='small' onChange=\"location.href='$_SERVER[PHP_SELF]?Syear='+p2.Syear.value+'&Sclass='+this.options[this.selectedIndex].value;\">
	<option value=''>�����</option>\n ";
	foreach($class_name_arr as $key=>$val) {
//	$key1=substr($Syear,0,3)."_".substr($Syear,3,1)."_".sprintf("%02d",substr($key,0,1))."_".substr($key,1,2);
		($Sclass==$key) ? $cc=" selected":$cc="";
		$ss.="<option value='$key' $cc>$val </option>\n";
	}
	$ss.="</select>";
Return $ss;
}
##################�}�C�C�ܨ禡##########################
function set_select($name,$array_name,$select_t="") {
	//�W��,�_�l��,������,��ܭ�
$word="<select name='".$name."' class=ip2>\n";
$word .="<option value=''>--�����--</option>\n";

foreach( $array_name as $key=>$val) {
//	echo $key."--".$val."<BR>";
	if ($key==$select_t)
		{$word .= "<option value='".$key."' selected>".$val."</option>\n";}
		else {
		$word .="<option value='".$key."'>".$val."</option>\n";	}
	}
$word .="</select>";
Return $word;
}
#####################   CSS  ###########################
function myheader(){
?>
<style type="text/css">
body{background-color:#f9f9f9;font-size:12pt}
.ipmei{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;}
.ipme2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;color:red;font-family:�з��� �s�ө���;}
.ip2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:10pt;color:red;font-family:�s�ө��� �з���;}
.ip3{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:12pt;color:blue;font-family:�s�ө��� �з���;}
.bu1{border-style: groove;border-width:1px: groove;background-color:#CCCCFF;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
.bub{border-style: groove;border-width:1px: groove;background-color:#FFCCCC;font-size:14pt;}
.bur2{border-style: groove;border-width:1px: groove;background-color:#FFCCCC;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
A:link  {text-decoration:none;color:blue; }
A:visited {text-decoration:none;color:blue; }
A:hover {background-color:rgb(230, 236, 240);color: #000000;text-decoration: underline; }
</style><?
}


?>
