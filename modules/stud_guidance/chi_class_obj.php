<?php
//$Id: chi_class_obj.php 8059 2014-06-10 13:55:04Z chiming $
$question_kind=array("����g",
	1=>"�ǮסB�Y���欰���t�欰",
	2=>"�C���N�B�����ǥ�",
	3=>"�ɾǡB�N�~���D",
	4=>"�a�x�B�H�ڡB�A���x�����]��",
	5=>"�K�u�ǥ�(�ݥ��Ī�)",
	6=>"�۶˾ǥ�(�ۧڶˮ`�ɦV)",
	7=>"�a��ݯS�O�������h���ǥ�",
	8=>"��L"
	);
$come_from=array("����g",1=>"�ť��Ѯv",2=>"�a��",3=>"���|��",4=>"��L");
$guid_over=array("�_","�O");
$talk_gui_stud=array("����g",1=>"���",2=>"�q��",3=>"�a�X",4=>"��L");
$size=15;

#####################   CSS  ###########################
function myheader(){
?>
<style type="text/css">
body{background-color:#f9f9f9;font-size:12pt}
.ip12{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:12pt;}
.ipmei{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;}
.ipme2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:14pt;color:red;font-family:�з��� �s�ө���;}
.ip2{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:11pt;color:red;font-family:�s�ө��� �з���;}
.ip3{border-style: solid; border-width: 0px; background-color:#E6ECF0; font-size:12pt;color:blue;font-family:�s�ө��� �з���;}
.bu1{border-style: groove;border-width:1px: groove;background-color:#CCCCFF;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
.bub{background-color:#FFCCCC;font-size:14pt;}
.bur2{border-style: groove;border-width:1px: groove;background-color:#FFCCCC;font-size:12px;Padding-left:0 px;Padding-right:0 px;}
.f8{font-size:9pt;color:blue;}
.f9{font-size:9 pt;}
.tth{ text-align: center; white-space: nowrap; background-color:#9EBCDD;}
.ttd{  white-space: nowrap; background-color:#FFFFFF;font-size:10pt }
A:link  {text-decoration:none;color:blue; }
A:visited {text-decoration:none;color:blue; }
A:hover {background-color:FF8000;color: #000000;  }
</style><?php
}

#####################   �Z�ſ��  ###########################
function link_a($Seme,$Sclass=''){
//		global $PHP_SELF;//$CONN,
	$class_name_arr = class_base($Seme) ;
	$ss="��ܯZ�šG<select name='Sclass' size='1' class='small' onChange=\"location.href='$_SERVER[PHP_SELF]?Seme='+p2.Seme.value+'&Sclass='+this.options[this.selectedIndex].value;\">
	<option value=''>�����</option>\n ";
	foreach($class_name_arr as $key=>$val) {
	//$key1=substr($Seme,0,3)."_".substr($Seme,3,1)."_".sprintf("%02d",substr($key,0,1))."_".substr($key,1,2);
	$key1=$Seme."_".$key;
	($Sclass==$key1) ? $cc=" selected":$cc="";
	$ss.="<option value='$key1' $cc>$val </option>\n";
	}
	$ss.="</select>";
Return $ss;
}


##################  �򥻤u�� initArray��Ƹ�Ƭ����޻P�a�Ȩ禡 #######################
## �����ƪ���A������,��B����,��A���O�ߤ@
## �ϥή� �ǤJ $F1���r��==>subject_id,subject_name
## �ϥή� �ǤJ $SQL����Ʈw�y�k
##################  �򥻤u�� initArray��Ƹ�Ƭ����޻P�a�Ȩ禡 #######################

function initArray($F1,$SQL){
	global $CONN ;
	$col=split(",",$F1);
	$key_field=$col[0];
	$value_field=$col[1];

	$rs = $CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
		Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
		$sch_all[$rs->fields[$key_field]]=$rs->fields[$value_field]; 
		$rs->MoveNext(); // ���ܤU�@���O��
		}
	}
	Return $sch_all;
}
###########################################################
##����Юv��ơA�]�A�qteach_person_id,name,birthday,address,home_phone,title_name,class_num�r//
function get_tea_sel(){
	global $CONN;
	//����Юv���
	if($_GET['view']=='old') $teach_cond=''; else $teach_cond='and a.teach_condition =0'; 
	$sql_select = "SELECT a.teacher_sn, a.name, a.birthday, a.address, a.home_phone, a.cell_phone,a.teach_condition , d.title_name ,b.class_num FROM  teacher_base a , teacher_post b, teacher_title d where  a.teacher_sn =b.teacher_sn  and b.teach_title_id = d.teach_title_id $teach_cond order by a.teach_condition,class_num, post_kind , post_office , a.teach_id ";
	$rs=$CONN->Execute($sql_select) or die($sql_select);
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		if($ro->teach_condition) $ro->title_name='*�D�b¾*'; 
		if($ro->class_num=='' || $ro->class_num=='0'){
			$word=$ro->title_name." - ".$ro->name;}
		else {
			$word=$ro->title_name.$ro->class_num." - ".$ro->name;
		}
		$key=$ro->teacher_sn;
		$arys[$key]=$word;
	}
	return $arys;
}

###########################################################
##����Юv��ơA�]�A�qteach_person_id,name,birthday,address,home_phone,title_name,class_num�r//
function get_tea_data(){
	global $CONN;
	//����Юv���
	if($_GET['view']=='old') $teach_cond=''; else $teach_cond='and a.teach_condition =0';
	$sql_select = "SELECT a.teacher_sn, a.name, a.birthday, a.address, a.home_phone, a.cell_phone , d.title_name ,b.class_num FROM  teacher_base a , teacher_post b, teacher_title d where  a.teacher_sn =b.teacher_sn  and b.teach_title_id = d.teach_title_id $teach_cond order by class_num, post_kind , post_office , a.teach_id ";
	$rs=$CONN->Execute($sql_select) or die($sql_select);
	$arys=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$key=$ro->teacher_sn;
		$arys[$key] = get_object_vars($ro);
		}
	return $arys;
}
###########################################################
##  �ǥX�ǥ͸��
function get_stu_data($st_sn,$seme){
	global $CONN ,$IS_JHORES;
		$sql = "select a.* ,b.seme_class,b.seme_num from stud_base a ,stud_seme b where a.student_sn = '$st_sn' and b.seme_year_seme='$seme' and b.student_sn=a.student_sn";
		$sql="select stud_base.*,stud_seme.seme_class,stud_seme.seme_num, stud_domicile.guardian_name,stud_domicile.guardian_unit,stud_domicile.guardian_hand_phone,stud_domicile.guardian_address,stud_domicile.guardian_phone  from stud_base left join stud_seme on(stud_base.student_sn=stud_seme.student_sn and stud_seme.seme_year_seme='$seme') left join stud_domicile on(stud_base.stud_id=stud_domicile.stud_id)  where stud_base.student_sn='{$st_sn}'  ";
		$rs = $CONN->Execute($sql) or die($sql);
		$arys=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$arys = get_object_vars($ro);
		($IS_JHORES==6) ? $grade=substr($ro->seme_class,0,1)-6:$grade=substr($ro->seme_class,0,1);
		$class1=substr($ro->seme_class,1,2)+0;
		$arys[cgrade]=num_tw($grade)."�~".num_tw($class1)."�Z";
		}
	return $arys;
}
###########################################################
##  �ǥX�ǥ͸��
function get_stu_list($seme,$t_sn=''){
	global $CONN ,$IS_JHORES;
	if ($t_sn!='') { $add=" and a.guid_tea_sn='$t_sn' " ;}else { $add=" ";}
	$sql = "select a.guid_c_id,a.st_sn,a.guid_c_from,a.begin_date,a.guid_tea_sn,a.guid_c_kind,a.end_date,a.guid_c_isover,b.stud_name,b.stud_sex,c.seme_class,c.seme_num from stud_guid a,stud_base b,stud_seme c where a.st_sn = b.student_sn and b.student_sn=c.student_sn and c.seme_year_seme='$seme'  $add  order by a.begin_date desc ,c.seme_class ,c.seme_num ";
		$rs = $CONN->Execute($sql) or die($sql);
		$arys=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$arys[$ro->st_sn] = get_object_vars($ro);
		($IS_JHORES==6) ? $grade=substr($ro->seme_class,0,1)-6:$grade=substr($ro->seme_class,0,1);
		$class1=substr($ro->seme_class,1,2)+0;
		$arys[$ro->st_sn][cgrade]=num_tw($grade)."�~".num_tw($class1)."�Z";
		}
	return $arys;
}
###########################################################
##  �ǥX�ǥ͸��
function get_stu_list2($type,$t_sn=''){
	global $CONN ,$IS_JHORES;
switch ($type){
	case 'now':$add1=" and a.guid_c_isover=0 ";
		break;
	case 'old':$add1=" and a.guid_c_isover=1 ";break;
 default:
}
	$seme=sprintf("%03d",curr_year()).curr_seme();
	if ($t_sn!='') { $add=" and a.guid_tea_sn='$t_sn' " ;}else { $add=" ";}
	$sql = "select a.guid_c_id,a.st_sn,a.guid_c_from,a.begin_date,a.guid_tea_sn,a.guid_c_kind,a.end_date,a.guid_c_isover,b.stud_name,b.stud_sex,c.seme_class,c.seme_num from stud_guid a,stud_base b,stud_seme c where a.st_sn = b.student_sn and b.student_sn=c.student_sn and c.seme_year_seme='$seme'  $add $add1 order by a.begin_date desc ,c.seme_class,c.seme_num  ";
		$rs = $CONN->Execute($sql) or die($sql);
		$arys=array();
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$arys[$ro->st_sn] = get_object_vars($ro);
		($IS_JHORES==6) ? $grade=substr($ro->seme_class,0,1)-6:$grade=substr($ro->seme_class,0,1);
		$class1=substr($ro->seme_class,1,2)+0;
		$arys[$ro->st_sn][cgrade]=num_tw($grade)."�~".num_tw($class1)."�Z";
		}
	return $arys;
}


#########################################################
####  �ǥX�ǥ͸��3

function get_stu_list3($type,$page=0,$t_sn=''){
	global $CONN ,$IS_JHORES,	$size;
switch ($type){
	case 'now':$add1="  a.guid_c_isover=0 ";
		break;
	case 'old':$add1="  a.guid_c_isover=1 ";break;
 default:
}

//	$seme=sprintf("%03d",curr_year()).curr_seme();//�ثe�Ǵ�

if ($t_sn!='') { $add=" and a.guid_tea_sn='$t_sn' " ;}else { $add=" ";}

	$sql = "select a.guid_c_id,a.st_sn,a.guid_c_from,a.begin_date,a.guid_tea_sn,a.guid_c_kind,a.end_date,a.guid_c_isover,a.guid_over_reason,b.stud_name,b.stud_sex,b.curr_class_num  from stud_guid a  left join stud_base b on( a.st_sn = b.student_sn)  where  $add1  $add  order by a.begin_date desc ,b.curr_class_num  limit   ".$page*$size." ,  $size";
	$rs = $CONN->Execute($sql) or die($sql);
	$obj=array();
	$obj=$rs->GetArray();
for($i=0;$i<$rs->RecordCount();$i++){
	($IS_JHORES==6) ? $obj[$i][grade]=substr($obj[$i][curr_class_num],0,1)-6:$obj[$i][grade]=substr($obj[$i][curr_class_num],0,1);
	$obj[$i][class1]=substr($obj[$i][curr_class_num],1,2)+0;
	$obj[$i][seme_num]=substr($obj[$i][curr_class_num],3,2)+0;
	$obj[$i][cgrade]=num_tw($obj[$i][grade])."�~".num_tw($obj[$i][class1])."�Z";
	$obj[$i][guid_all_kind]=explode(",",$obj[$i][guid_c_kind]);

	}
	return $obj;
}


###########################################################
##  �ǥX�ǥ͸��
function get_stu_gui($id,$t_sn){
	global $CONN ;

		$sql = "select * from stud_guid where guid_c_id ='$id' and guid_tea_sn='$t_sn' ";
		$rs = $CONN->Execute($sql) or die($sql);
	if ($rs->RecordCount()==0) return "�S��������ơI";
	$obj_stu=$rs->GetArray();
	$obj_stu[0][guid_all_kind]=explode(",",$obj_stu[0][guid_c_kind]);
	return $obj_stu[0];
}
###########################################################
##  �ǥX�ǥ͸�ƻ��ɬ���--����----�ǤJ�׸��P�Юv�X
function get_event_all($id,$t_sn){
	global $CONN ;
		$sql = "select * from stud_guid_event where guid_c_id ='$id' and tutor='$t_sn' order by guid_l_date desc ";
		$rs = $CONN->Execute($sql) or die($sql);
	if ($rs->RecordCount()==0) return "";
	$obj_stu=$rs->GetArray();
	return $obj_stu;
}
###########################################################
##  �ǥX�ǥ͸�ƻ��ɬ���--�ӤH�浧----�ǤJ��Ƹ��P�Юv�X
function get_event_one($id,$t_sn){
	global $CONN ;
		$sql = "select * from stud_guid_event where guid_l_id  ='$id' and tutor='$t_sn' ";
		$rs = $CONN->Execute($sql) or die($sql);
	if ($rs->RecordCount()==0) return "�S��������ơI";
	$obj_stu=$rs->GetArray();
	return $obj_stu[0];
}

###########################################################
##  �ˬd�O���O�_�ѥ��H�t�d
function check_gui($id,$t_sn){
	global $CONN ;
		$sql = "select * from stud_guid where guid_c_id ='$id' and guid_tea_sn='$t_sn' ";
		$rs = $CONN->Execute($sql) or die($sql);
	if ($rs->RecordCount()==0) {return "No";} else {return "Yes";}
}
###########################################################
##  �ˬd�O���O�_�ѥ��H��g
function check_event($id,$t_sn){
	global $CONN ;
		$sql = "select * from stud_guid_event where guid_l_id ='$id' and tutor ='$t_sn' ";
		$rs = $CONN->Execute($sql) or die($sql);
	if ($rs->RecordCount()==0) {return "No";} else {return "Yes";}
}



###########################################################
##  �ǥX����Ʀr���

function num_tw($num, $type=0) {
 $num_str[0] = "�Q�ʤd";
        $num_str[1] = "�B�եa";
        $num_type[0]='�s�@�G�T�|�����C�K�E';
        $num_type[1]='�s���L�Ѹv��m�èh';
        $num = sprintf("%d",$num);
        while ($num) {
                $num1 = substr($num,0,1);
                $num = substr($num,1);
                $target .= substr($num_type[$type], $num1*2, 2);
                if (strlen($num)>0) $target .= substr($num_str[$type],(strlen($num)-1)*2,2);
 }
 return $target;
}

function backinput($st="����!���U��^�W������!") {
echo"<BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	}
function backe($st="����!���U��^�W������!") {
echo "<BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}
function backend($st="����!���U��^�W������!") {
echo "<BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"window.close()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}


function get_date_seme() {
	global $CONN ;
	$sql = "select * from school_day where day_kind='start' order by year ,seme ";
	$arys=array();
	$rs = $CONN->Execute($sql) or die($sql);
	while ($rs and $ro=$rs->FetchNextObject(false)) {
		$key=$ro->year."_".$ro->seme;
		$arys[$key][start] = $ro->day;
		$arys[$key][year]=$ro->year;
		$arys[$key][seme]=$ro->seme;
		}
	$sql = "select * from school_day where day_kind='end' order by year ,seme ";
	$rs = $CONN->Execute($sql) or die($sql);
	$all_day=$rs->GetArray();
	for ($i=0;$i<$rs->RecordCount();$i++){
		$ckey=$all_day[$i][year]."_".$all_day[$i][seme];
		$arys[$ckey][end]=$all_day[$i][day];
		}
	return $arys;
}


function alter_table(){
		global  $CONN;
	$res = $CONN->Execute("show columns from stud_guid like 'guid_over_reason'");
if ($res->EOF) {
	$UPSQL = 'ALTER TABLE `stud_guid` CHANGE `guid_c_over_reason` `guid_over_reason` TEXT NOT NULL';
	$rs=$CONN->Execute($UPSQL) or die($UPSQL."��s����");
	}
}


?>
