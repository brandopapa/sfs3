<?
// $Id: chc_teacher.v2.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
sfs_check();

if ($_POST[act]=='add' && $_POST[year_seme]!=''&& $_POST[grade]!='' ){
	foreach ($_POST[class_id] as $new_class=>$tea_sn) {
	if ($new_class=='' || $new_class=='0' ) continue;
	$ary[$tea_sn][sn]=$tea_sn;
	$new_class1= split("_",$new_class);//���}�r��
	$seme_class=($new_class1[2]+0).$new_class1[3];
	$ary[$tea_sn][seme_class]=$seme_class;
	$ary[$tea_sn][year]=$new_class1[0]+0;
	$ary[$tea_sn][semester]=$new_class1[1]+0;
	$ary[$tea_sn][c_year]=sprintf("%d",$new_class1[2]);
	$ary[$tea_sn][c_sort]=$new_class1[3]+0;
	$ary[$tea_sn][tea_name]=$_POST[tea][$new_class];
	unset($new_class1);
	}
	//�O�_���Ǵ�
	$now=curr_year()."_".curr_seme();
	($_POST[year_seme]==$now) ? $chk_now='Y':$chk_now='N';
	//�O���ܤ~��steacher_post��
	if ($chk_now=='Y'){
		foreach ($ary as $new_class) {
			$ary2[]=$new_class[seme_class];
			}
		$in_ary=join(",",$ary2);
		$SQL="update teacher_post set class_num='' where  class_num in ($in_ary) ";
		$rs=$CONN->Execute($SQL) or die($SQL);
	}

	foreach ($ary as $sn => $dat) {
		//�p�G,�O���Ǵ��~�ק� teacher_post
		if ($chk_now=='Y'){
			$SQL="update teacher_post set class_num='$dat[seme_class]' where teacher_sn='$sn'";
			$rs=$CONN->Execute($SQL) or die($SQL); 
			}
		$sql_update = "update school_class set teacher_1='$dat[tea_name]' where year='$dat[year]' and semester='$dat[semester]' and c_year='$dat[c_year]' and c_sort='$dat[c_sort]' and enable=1";
		$rs=$CONN->Execute($sql_update) or die($sql_update); 
		}
		$URL=$_SERVER[PHP_SELF]."?year_seme=".$_POST[year_seme]."&grade=".$_POST[grade];
	header("location:".$URL);
}


////�������w�˥��ɦ�m
$template_file = $SFS_PATH."/".get_store_path()."/templates/chc_teacher.v2.htm";
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";

head("�ɮv�]�w");
print_menu($school_menu_p);


// 2.�P�_�Ǧ~��

$now_year_seme=curr_year()."_".curr_seme();
($_GET[year_seme]=='') ? $year_seme=$now_year_seme:$year_seme=$_GET[year_seme];
$sel_year= split("_",$year_seme);//���}�r��

	//��ܪ��Ǧ~��
$smarty->assign("year_seme",$year_seme);
$smarty->assign("sel_year",sel_year("year_seme",$year_seme));
($IS_JHORES==6) ? $all_grade=array(7=>"�@�~��",8=>"�G�~��",9=>"�T�~��","all"=>"����"):$all_grade=array(1=>"�@�~��",2=>"�G�~��",3=>"�T�~��",4=>"�|�~��",5=>"���~��",6=>"���~��","all"=>"����");
//�ǤJ�~�Ű}�C
$smarty->assign("sel_grade",$all_grade);


if ($_GET[grade]!=''){
	$grade=$_GET[grade];
	$smarty->assign("now_grade",$grade);

	$SQL_NOW="select a.teach_id, a.teach_person_id, a.name, a.sex, a.birthday,a.teach_condition, a.teacher_sn, b.class_num  from teacher_base a left join   teacher_post b on  a.teacher_sn=b.teacher_sn and b.class_num!='' where teach_condition='0'  order by b.class_num desc,a.sex ,a.name ";
	$SQL_AGO="select a.teach_id, a.teach_person_id, a.name, a.sex, a.birthday,a.teach_condition, a.teacher_sn, b.class_num  from teacher_base a left join   teacher_post b on  a.teacher_sn=b.teacher_sn  and b.class_num!=''   order by b.class_num desc,a.sex ,a.name  ";

	($year_seme==$now_year_seme) ? $SQL=$SQL_NOW: $SQL=$SQL_AGO;

	$rs=$CONN->Execute($SQL) or die($SQL); 
	while ($ro=$rs->FetchNextObject(false)) {
		$tea[$ro->teach_id]=get_object_vars($ro);
		}
	$SQL_all="select  class_sn,class_id, year, semester, c_year, c_name, c_kind, c_sort, enable, teacher_1, teacher_2 from school_class where year='".$sel_year[0]."' and  semester='".$sel_year[1]."'  and enable='1' order by class_id ";
	$SQL_part="select  class_sn,class_id, year, semester, c_year, c_name, c_kind, c_sort, enable, teacher_1, teacher_2 from school_class where year='".$sel_year[0]."' and  semester='".$sel_year[1]."' and  c_year='$grade'  and enable='1' order by class_id ";
	//�������Z�ũΥ���
	($grade=='all') ? $SQL=$SQL_all:$SQL=$SQL_part;
	$rs=$CONN->Execute($SQL) or die($SQL);
	$class_ary=$rs->GetArray();
	foreach ($class_ary as $tmp_ary){
		($IS_JHORES==6) ? $tmp_ary[cc_year]=num_tw($tmp_ary[c_year]-6):$tmp_ary[cc_year]=num_tw($tmp_ary[c_year]);
		$class_ary_1[]=$tmp_ary;
		}
	$class_ary=$class_ary_1;
	$smarty->assign("SEX",array(1=>"�k",2=>"�k"));
	//�Юv
	$smarty->assign("tea",add_to_td2($tea,4));
	//�Z�Ű}�C
	$smarty->assign("class_ary",add_to_td2($class_ary,2));
}


////��ܵ��G
$smarty->display($template_file);
// echo "<PRE>";
//print_r($class_ary);
//..print_r($tea);

foot();

//////-------------�ɻ���ܥΨ禡2---------------///////
function add_to_td2($data,$num) {
	$all=count($data);
	$loop=ceil($all/$num);
	$flag=$num-1;//�X�檺key
	$all_td=($loop*$num)-1;//�̤j�Ȥp1
	$show=array();$i=0;
	foreach ($data as $key=>$ary ){
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $ary[next_line]='yes':$ary[next_line]='';
		$show[$key]=$ary;
		$i++;
		}
	if ($i<=$all_td ){
		for ($i;$i<=$all_td;$i++){
			$key='Add_Td_'.$i;
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $show[$key][next_line]='yes':$show[$key][next_line]='';
		}
	}
		return $show;
}

##################  �Ǵ��U�Ԧ����禡  ##########################
function sel_year($name,$select_t='') {
	global $CONN ;
	$SQL = "select * from school_day where  day<=now() and day_kind='start' order by day desc ";
	$rs=$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
	while(!$rs->EOF){
	$ro = $rs->FetchNextObject(false);
	// ��i$ro=$rs->FetchNextObj()�A���O�ȥΩ�s������adodb�A�ثe��SFS3���A��
	$year_seme=$ro->year."_".$ro->seme;
	$obj_stu[$year_seme]=$ro->year."�Ǧ~�ײ�".$ro->seme."�Ǵ�";
	}
	$str="<select name='$name' onChange=\"location.href='".$_SERVER[PHP_SELF]."?".$name."='+this.options[this.selectedIndex].value;\">\n";
		//$str.="<option value=''>-�����-</option>\n";
	foreach($obj_stu as $key=>$val) {
		($key==$select_t) ? $bb=' selected':$bb='';
		$str.= "<option value='$key' $bb>$val</option>\n";
		}
	$str.="</select>";
	return $str;
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

?>