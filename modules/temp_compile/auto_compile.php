<?php

// $Id: auto_compile.php 7712 2013-10-23 13:31:11Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
$class_year_b=$_REQUEST['class_year_b'];
$work=$_REQUEST['work'];
$rkind=$_POST[rkind];
if ($rkind=="") $rkind=3;
$start_class=$_REQUEST[start_class];
$spec_chg_str="�S��Z���";

//�ϥΪ̻{��
sfs_check();

//�{�����Y
$checks=(!$_POST[Submit6]&&!$_POST[Submit8]&&!$_POST[Submit9]&&!$_POST[Submit10]&&!$_POST[Submit11]&&!$_POST[Submit12]&&!$_POST[Submit13]&&!$_POST[Submit14]&&!$_POST[Submit15]);
if ($checks) {
	head("�s�ͽs�Z");
	print_menu($menu_p,"class_year_b=$class_year_b");
}

//�]�w�D������ܰϪ��I���C��
if ($checks) echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";

//�u�@���
$selected[$work]="selected";
$menu="
	<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
	<select name='class_year_b' onchange='this.form.submit();'>";
	$chk=($class_year_b)?$class_year_b:$IS_JHORES+1;
	while (list($k,$v)=each($class_year)) {
		$checked=($chk==$k)?"selected":"";
		$menu.="<option value='$k' $checked>$v</option>\n";
	}
$menu.="</select>
	<select name='work' onChange='jumpMenu1()'>
	<option value=''>�п�ܤu�@����</option>\n
	<option value='1' ".$selected[1].">�]�w�����Z�O</option>\n
	<option value='2' ".$selected[2].">�s�ͤH�u�����s�Z</option>\n
	<option value='3' ".$selected[3].">�s�ͦ۰ʥ����s�Z</option>\n
	<option value='8' ".$selected[8].">�s�ͥ����s�Z�S��վ�</option>\n
	<option value='4' ".$selected[4].">�s�ͥ����s�Z�d��</option>\n
	<option value='7' ".$selected[7].">�Z���y���۰ʽվ�</option>\n
	<option value='5' ".$selected[5].">�d�߷s�ͥ������s�Z�W��</option>\n
	<option value='6' ".$selected[6].">�C�L�s�ͥ����s�Z�W�U</option>\n
	</select>
	</form>";
if ($checks) echo "<table><tr><td>".$menu."<td>";

//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$new_sel_year=date("Y")-1911;

//���o�զW
$query="select * from school_base";
$res=$CONN->Execute($query);
$school_name=$res->fields[sch_cname];

if($_POST['Submit2']){
	$query="update new_stud set class_sort=null,class_site=null,meno=null where stud_study_year='$new_sel_year' and class_year='$class_year_b'";
	$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
}
if($_POST['Submit3']){
	$stud_id=$_POST[stud_id];
	$c=explode("_",$_POST[input_class]);
	$class_sort=intval($c[3]);
	$error_msg="";
	while(list($k,$v)=each($stud_id)) {
		$query="select * from new_stud where temp_id='A".$v."' and stud_study_year='$new_sel_year'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		if (empty($res->fields[stud_name])) continue;
		if (!$res->fields[sure_study]) {
			$error_msg.="<font color='#ff0000'>�{�ɽs��".$res->fields[temp_id]."(".$res->fields[stud_name].")���NŪ����</font><br>";
			$stud_id[$k]="";
			continue;
		}
		$query="update new_stud set class_sort='$class_sort',class_site='$k' where temp_id='A".$v."' and stud_study_year='$new_sel_year'";
		$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	}
}
if($_POST['Submit4']){
	//�P�_�ʧO
	if ($_POST[lkind]==1) {
		$sex_sel="and stud_sex='1'";
		$oth_sel="and stud_sex='2'";
	} elseif ($_POST[lkind]==2) {
		$sex_sel="and stud_sex='2'";
		$oth_sel="and stud_sex='1'";
	}
	switch($_POST[kind]){
		case 0:
			$query="select temp_id from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and (class_sort is null or class_site is null or round(class_sort)=0 or round(class_site)=0) $sex_sel order by temp_id";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			while(!$res->EOF) {
				$stud_arr[]=$res->fields[temp_id];
				$res->MoveNext();
			}
			break;
		case 1:
			$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' order by temp_class,temp_site";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			while(!$res->EOF){
				$temp_class=$res->fields[temp_class];
				$temp_site=$res->fields[temp_site];
				$class_sort=intval(substr($temp_class,-2,2));
				$newstud_sn=$res->fields[newstud_sn];
				$query_update="update new_stud set class_sort='$class_sort',class_site='$temp_site' where newstud_sn='$newstud_sn'";
				$res_update=$CONN->Execute($query_update) or trigger_error($query_update,E_USER_ERROR);
				$res->MoveNext();
			}
			break;
		case 2:
			//�����X�U������J���Z�ǥ͸��
			for ($i=1;$i<=3;$i++) {
				$query="select temp_id from new_stud where temp_score$i='-100' and stud_study_year='$new_sel_year' and class_year='$class_year_b'";
				$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
				$ids="";
				while (!$res->EOF) {
					$ids.="'".$res->fields[temp_id]."',";
					$res->MoveNext();
				}
				if ($ids) $ids=substr($ids,0,-1);
				$temp_score_id[$i]=$ids;
				$query="update new_stud set temp_score$i='0' where temp_score$i='-100' and stud_study_year='$new_sel_year' and class_year='$class_year_b'";
				$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			}
			$query="select temp_id,(temp_score1+temp_score2+temp_score3) as cc from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and (class_sort is null or class_site is null or round(class_sort)=0 or round(class_site)=0) $sex_sel order by cc desc";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			while(!$res->EOF) {
				$stud_arr[]=$res->fields[temp_id];
				$res->MoveNext();
			}
			for ($i=1;$i<=3;$i++) {
				if ($temp_score_id[$i]) {
					$query="update new_stud set temp_score$i='-100' where temp_id in (".$temp_score_id[$i].")";
					$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
				}
			}
			break;
	}
	$max_stud=count($stud_arr);
	$start_point=intval($_POST[start_point]);
	$class_arr=$_POST[class_arr];
	if (($_POST[kind]==0 || $_POST[kind]==2) && ($start_point<=$max_stud) && count($class_arr)>0) {
		//��ǥͰ}�C�̡u�s�Z�̾ڡv�ƦC�n
		$c=explode("_",$_POST[start_class]);
		$stud_arr1=array_slice($stud_arr,$start_point-1);
		$stud_arr2=($start_point>1)?array_slice($stud_arr,0,$start_point-1):array();
		$stud_arr=array_merge($stud_arr1,$stud_arr2);
		$max_class=count($class_arr);
		$i=1;
		$class_str="";
		while(list($k,$v)=each($class_arr)){
			$classes[$i]=$k;
			$real_class[$i]=$k;
			$class_str.="'".$k."',";
			$i++;
		}
		$j=($rkind==3)?intval($c[3]):intval($c[3])+1;
		//�N�u��Z�O�̽s�Z���ǱƦC�n
//		if ($j>$max_class) $j=1;
//		for ($i=1;$i<=$max_class;$i++) {
//			$real_class[$i]=$j;
//			$j++;
//			if ($j>$max_class) $j=1;
//		}
		if ($class_str) $class_str=substr($class_str,0,-1);
		//����X�U�Z�w���s�J�y���̤j��
		$query="select max(class_site),class_sort from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and class_sort in ($class_str) group by class_sort order by class_sort";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$site_now[$res->fields[class_sort]]=$res->fields[0];
			$res->MoveNext();
		}
		$query="select count(newstud_sn) from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and class_sort is null $oth_sel";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$oth_total=$res->fields[0];
		if ($oth_total==0) $sex_sel="";
		//��X�U�Z�w�s�H�ƤΤw�s�Z�`�H��
		$num_pre_total=0;
		$query="select count(newstud_sn),class_sort from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and class_sort in ($class_str) $sex_sel group by class_sort";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$num_pre[$res->fields[class_sort]]=$res->fields[0];
			$num_pre_total+=$num_pre[$res->fields[class_sort]];
			$res->MoveNext();
		}
		$c_now=array_keys($classes,intval($c[3]));
		//$class_now�ëD�u���s�J�Z�šA�ӬO����
		$class_now=($rkind==3)?1:$max_class;
		//��X�Z�ť����H��
		$avg_num=ceil(($max_stud+$num_pre_total)/$max_class);
		//�T�w��}�l�Z�ŮɬO���V�άO�f�V
		$next_class=intval($rkind)-2;
		//�}�l�s�Z
		for ($i=0;$i<$max_stud;$i++) {
			$class_now_temp=$class_now;
			//�ˬd�A�s�J�ǥͫ�Z�ŤH�ƬO�_�|�W�L�����H�ơA�p�G�|�W�L�A�N����U�@�ӯZ
			while(($num_now[$real_class[$class_now]]+$num_pre[$real_class[$class_now]]+1)>$avg_num){
				$class_now+=$next_class;
				//�p�G�s�Z�{�Ƕ]��F�_�l�Z�A�s�Z��V�令�V��
				if ($class_now==0) {
					$class_now=$class_now_temp;
					$next_class=1;
				}
				//�p�G�s�Z�{�Ƕ]��F�̲ׯZ�A�s�Z��V�令�V�e
				if ($class_now>$max_class) {
					$class_now=$class_now_temp;
					$next_class=-1;
				}
			}
			//�N�ǥͽs�J�Z��
			$site_now[$real_class[$class_now]]++;
			$num_now[$real_class[$class_now]]++;
			$query="update new_stud set class_sort='".$real_class[$class_now]."',class_site='".$site_now[$real_class[$class_now]]."',sort_sn='".($i+1)."' where temp_id='".$stud_arr[$i]."'";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			//�p��X�U�@�ӯZ��
			if ($class_now+$next_class>$max_class) 
				$next_class=-1;
			elseif ($class_now+$next_class<1)
				$next_class=1;
			else
				$class_now+=$next_class; 
		}
	}
	if ($_POST[lkind]!=0 && $_POST[lkind]!="") $_POST[lkind]=3-$_POST[lkind];
	$rkind=4-$rkind;
	$sclass=explode("_",$start_class);
	$query="select c_sort from school_class where year='$new_sel_year' and semester='1' and class_id like '".sprintf("%03d_%d_%02d",$new_sel_year,1,$class_year_b)."%' order by class_id desc";
	$res=$CONN->Execute($query);
	$sclass[3]--;
	$sclass[3]=($sclass[3]==0)?$res->fields[c_sort]:$sclass[3];
	$start_class=sprintf("%03d_%d_%02d_%02d",$sclass[0],$sclass[1],$sclass[2],$sclass[3]);
}
if ($_POST['Submit7']){
	$first=$_POST['first'];
	$law=($_POST['law']);
	asort($law);
	$order_str="order by class_sort";
	while(list($k,$v)=each($law)) {
		if ($v) $order_str.=",".$k;
		if ($v && $k=="stud_sex" && $first==2) $order_str.=" desc";
	}
	$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' $order_str";
	$res=$CONN->Execute($query) or die($query);
	while(!$res->EOF) {
		$class_sort=$res->fields[class_sort];
		if ($class_sort!=$old_class)
			$i=1;
		else
			$i++;
		$newstud_sn=$res->fields[newstud_sn];
		$query_update="update new_stud set class_site='$i' where newstud_sn='$newstud_sn'";
		$CONN->Execute($query_update);
		$old_class=$class_sort;
		$res->MoveNext();
	}
}

if ($_POST[Submit16] && $_POST[sel1] && $_POST[sel2]) {
	$sel1=$_POST[sel1];
	$sel2=$_POST[sel2];
	$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and temp_id='$sel1'";
	$res=$CONN->Execute($query);
	$csort=$res->fields[class_sort];
	$csite=$res->fields[class_site];
	$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and temp_id='$sel2'";
	$res=$CONN->Execute($query);
	$query="update new_stud set class_sort='".$res->fields[class_sort]."',class_site='".$res->fields[class_site]."',meno='$spec_chg_str' where stud_study_year='$new_sel_year' and class_year='$class_year_b' and temp_id='$sel1'";
	$CONN->Execute($query);
	$query="update new_stud set class_sort='$csort',class_site='$csite',meno='$spec_chg_str' where stud_study_year='$new_sel_year' and class_year='$class_year_b' and temp_id='$sel2'";
	$CONN->Execute($query);
}

if ($_POST[Submit8]||$_POST[Submit9]||$_POST[Submit10]||$_POST[Submit11]||$_POST[Submit12]||$_POST[Submit13]||$_POST[Submit14]||$_POST[Submit15]){
	if ($_POST[Submit8])
		$filename=$new_sel_year."chart2.CSV";
	elseif ($_POST[Submit9])
		$filename=$new_sel_year."chart1.CSV";
	elseif ($_POST[Submit12])
		$filename=$new_sel_year."chart_g.CSV";
	elseif ($_POST[Submit14])
		$filename=$new_sel_year."chart_b.CSV";
	else
		$filename="";
	if ($_POST[Submit10])
		$title_str="�s�ͽs�Z�`���ƧǦW��C��";
	elseif ($_POST[Submit11])
		$title_str="�s�ͽs�Z��l���Z�n����U";
	elseif ($_POST[Submit13])
		$title_str="�s�ͽs�Z���Z�ƧǪ�U(�k��)";
	elseif ($_POST[Submit15])
		$title_str="�s�ͽs�Z���Z�ƧǪ�U(�k��)";
	if ($filename) {
		header("Content-disposition: filename=$filename");
		header("Content-type: application/octetstream ; Charset=Big5");
		//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
		header("Expires: 0");
	} else 
		echo "	<html><head><meta http-equiv=\"Content-Language\" content=\"zh-tw\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">
			<title>$school_name $new_sel_year �Ǧ~�� $title_str </title></head>
			<body><center>";
	if ($_POST[Submit8])
		echo "�Ǹ�,�ƦC�W��,�m�W,�`��,�᫬�ƦC���Z�O,�����s��,�Ƶ�\n";
	elseif ($_POST[Submit9]) {
		echo "�y����,�{�ɯZ��,�{�ɽs��,�m�W,�ʧO,��ؤ@����,��ؤG����,��ؤT����,�`��,�Ƶ�\n";
		$col_str="�y����";
	} elseif ($_POST[Submit12]||$_POST[Submit14]) {
		echo "���Z�Ƨ�,�{�ɯZ��,�{�ɽs��,�m�W,�ʧO,��ؤ@����,��ؤG����,��ؤT����,�`��,�Ƶ�\n";
		$col_str="���Z�Ƨ�";
	}
	if ($_POST[Submit12]||$_POST[Submit13])
		$sex_kind="2";
	elseif ($_POST[Submit14]||$_POST[Submit15])
		$sex_kind="1";		
	//�����X�U������J���Z�ǥ͸��
	for ($i=1;$i<=3;$i++) {
		$query="select temp_id from new_stud where temp_score$i='-100' and stud_study_year='$new_sel_year' and class_year='$class_year_b'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$ids="";
		while (!$res->EOF) {
			$ids.="'".$res->fields[temp_id]."',";
			$res->MoveNext();
		}
		if ($ids) $ids=substr($ids,0,-1);
		$temp_score_id[$i]=$ids;
		$query="update new_stud set temp_score$i='0' where temp_score$i='-100' and stud_study_year='$new_sel_year' and class_year='$class_year_b'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	}
	if ($_POST[Submit8]||$_POST[Submit10])
		$query="select *,(temp_score1+temp_score2+temp_score3) as cc from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' order by sort_sn,stud_sex";
	elseif ($_POST[Submit9]||$_POST[Submit11])
		$query="select *,(temp_score1+temp_score2+temp_score3) as cc from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' order by temp_class,temp_site";
	elseif ($_POST[Submit12]||$_POST[Submit13]||$_POST[Submit14]||$_POST[Submit15])
		$query="select *,(temp_score1+temp_score2+temp_score3) as cc from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='1' and stud_sex='$sex_kind' order by cc desc";
	$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	$i=1;
	$pg=1;
	$all_i=$res->RecordCount();
	$all_pg=ceil($all_i/40);
	while(!$res->EOF) {
		$c_sex=($res->fields[stud_sex]==1)?"�k":"�k";
		if ($_POST[Submit8])
			echo $i.",".$res->fields[sort_sn].",".$res->fields[stud_name].",".$res->fields[cc].",".$res->fields[class_sort].",".$res->fields[temp_id].", \n";
		elseif ($_POST[Submit9]||$_POST[Submit12]||$_POST[Submit14])
			echo $i.",".$res->fields[temp_class].",".$res->fields[temp_id].",".$res->fields[stud_name].",".$c_sex.",".$res->fields[temp_score1].",".$res->fields[temp_score2].",".$res->fields[temp_score3].",".$res->fields[cc].", \n";
		elseif ($_POST[Submit10]) {
			if ($i%40==1)
				echo "<p align=\"center\"><font face=\"�з���\" size=\"4\">$school_name $new_sel_year �Ǧ~��</font><br><font face=\"�з���\" size=\"5\">$title_str</font></p>\n
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"610\">\n
				<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">�Ǹ�</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">�ƦC�W��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">�m�W</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">�`��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">�᫬�ƦC<br>���Z�O</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">�����s��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"110\">�Ƶ�</td>\n
				</tr>\n";
			if ($i%5!=0  && $i!=$all_i)
				echo "<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$i."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[sort_sn]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[stud_name]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[cc]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[class_sort]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[temp_id]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"110\"></td>\n
				</tr>\n";
			else
				echo "<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$i."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[sort_sn]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[stud_name]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[cc]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[class_sort]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[temp_id]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"110\"></td>\n
				</tr>\n";
			if ($i%40==0 || $i==$all_i) {
				echo "</table><br><small><b>��".$pg."��/�@".$all_pg."��</b></small><br style=\"page-break-before:always\">";
				$pg++;
			}
			if ($i==$all_i) echo "</center></body></html>";
		} else {
			if ($i%40==1)
				echo "<p align=\"center\"><font face=\"�з���\" size=\"4\">$school_name $new_sel_year �Ǧ~��</font><br><font face=\"�з���\" size=\"5\">$title_str</font></p>\n
				<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"610\">\n
				<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">$col_str</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">�{�ɯZ��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">�{�ɽs��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">�m�W</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">�ʧO</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">��ؤ@<br>����</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">��ؤG<br>����</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">��ؤT<br>����</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">�`��</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"30\">�Ƶ�</td>\n
				</tr>\n";
			if ($i%5!=0  && $i!=$all_i)
				echo "<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">".$i."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[temp_class]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[temp_id]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[stud_name]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">".$c_sex."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score1]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score2]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score3]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[cc]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"30\"></td>\n
				</tr>\n";
			else
				echo "<tr>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">".$i."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[temp_class]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"80\">".$res->fields[temp_id]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"100\">".$res->fields[stud_name]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">".$c_sex."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score1]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score2]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[temp_score3]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"60\">".$res->fields[cc]."</td>\n
				<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"30\"></td>\n
				</tr>\n";
			if ($i%40==0 || $i==$all_i) {
				echo "</table><br><small><b>��".$pg."��/�@".$all_pg."��</b></small><br style=\"page-break-before:always\">";
				$pg++;
			}
			if ($i==$all_i) echo "</center></body></html>";
		}
		$i++;
		$res->MoveNext();
	}
	for ($i=1;$i<=3;$i++) {
		if ($temp_score_id[$i]) {
			$query="update new_stud set temp_score$i='-100' where temp_id in (".$temp_score_id[$i].")";
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		}
	}
	exit;
}
if($_GET['del']){
	$query="update new_stud set class_sort=null,class_site=null,sort_sn='0' where temp_id='A".$_GET['del']."' and stud_study_year='$new_sel_year'";
	$CONN->Execute($query);
}

switch($work){
	case 1:
		echo "</tr></table><br>�Ш�u�Ǵ���]�w�v���u�Z�ų]�w�v�h<a href='".$SFS_PATH_HTML."modules/every_year_setup/class_year_setup.php'>�]�w�����Z��</a>�C";
		break;
	case 2:
		$input_class=$_REQUEST[input_class];
		if (empty($input_class)) $input_class=sprintf("%03d_%d_%02d_%02d",$new_sel_year,1,$class_year_b,1);
		$class_menu=full_class_name($input_class,"input_class",$new_sel_year,$class_year_b,1);
		$c=explode("_",$input_class);
		$query="select * from temp_class where year='$new_sel_year' and class_id like '$class_year_b%' order by class_id";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while (!$res->EOF) {
			$classn[$res->fields[class_id]]=$res->fields[c_name]."�Z";
			$res->MoveNext();
		}
		echo "<form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>$class_menu<input type='hidden' name='work' value='$work'><input type='hidden' name='class_year_b' value='$class_year_b'></form></table>";
		$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and class_sort='".intval($c[3])."' order by class_site";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$sum=$res->RecordCount();
		while (!$res->EOF) {
			$id=$res->fields[class_site];
			$stud_name[$id]=$res->fields[stud_name];
			$temp_class[$id]=$res->fields[temp_class];
			$temp_site[$id]=$res->fields[temp_site];
			$sex=$res->fields[stud_sex];
			if ($sex==1) {
				$stud_sex[$id]="�k";
				$fontcolor[$id]="'blue'";
			} else {
				$stud_sex[$id]="�k";
				$fontcolor[$id]="'#FF6633'";
			}
			$stud_id[$id]=substr($res->fields[temp_id],1);
			$url[$id]=(empty($stud_name[$id]))?"":"<a href={$_SERVER['PHP_SELF']}?work=2&input_class=$input_class&del=$stud_id[$id]&class_year_b=$class_year_b>�եX</a>";
			$max_num=intval($id);
			$res->MoveNext();
		}
		$sum=($sum>$max_num)?$sum:$max_num;
		if ($sum<60) $sum=60;
		echo "	$error_msg
			<form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>
			<input type='submit' name='Submit3' value='�x�s'>
			<table><tr><td>
			<table bgcolor='#000000' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#E1ECFF'>
			<td>�y��</td>
			<td>�{�ɽs��</td>
			<td>�ǥͩm�W</td>
			<td>�ʧO</td>
			<td>�{�ɯZ��</td>
			<td>�{�ɮy��</td>
			<td>�եX���Z</td>
			</tr>\n";
		for ($i=1;$i<=$sum;$i++) {
			echo "	<tr bgcolor='#FFF7CD'>
				<td>$i</td>
				<td>A<input type='text' size='5' name='stud_id[$i]' value='$stud_id[$i]'></td>
				<td><font color=$fontcolor[$i]>$stud_name[$i]</font></td>
				<td align='center'><font color=$fontcolor[$i]>$stud_sex[$i]</font></td>
				<td align='center'>".$classn[$temp_class[$i]]."</td>
				<td align='center'>$temp_site[$i]</td>
				<td align='center'>$url[$i]</td>
				</tr>\n";
		}
		echo "</table></td></tr></table><input type='hidden' name='class_year_b' value='$class_year_b'><input type='hidden' name='input_class' value='$input_class'><input type='hidden' name='work' value='$work'><input type='submit' name='Submit3' value='�x�s'></form>";
		break;

	case 3:
		$ksel[intval($_POST[kind])]="checked";
		$lsel[intval($_POST[lkind])]="checked";
		$rsel[$rkind]="checked";
		$cacheck=$_POST[cacheck];
		if (empty($start_class)) $start_class=sprintf("%03d_%d_%02d_%02d",$new_sel_year,1,$class_year_b,1);
		$class_list=full_class_name($start_class,"start_class",$new_sel_year,$class_year_b,0);
		$onchg="onchange='this.form.submit();'";
		$lkind_str=($ksel[1])?"":"	<td>
				<input type='radio' name='lkind' value='0' $lsel[0]>���ީʧO<br>
				<input type='radio' name='lkind' value='1' $lsel[1]>�s�k��<br>
				<input type='radio' name='lkind' value='2' $lsel[2]>�s�k��<br>
				</td>
				<td>
				�_�l�I<input type='text' size='3' maxsize='3' name='start_point' value='1'>
				</td>
				<td>
				�_�l�Z".$class_list."
				</td>
				<td>
				<input type='radio' name='rkind' value='3' $rsel[3]>���V<br>
				<input type='radio' name='rkind' value='1' $rsel[1]>�f�V<br>
				</td>
				<td width='300' bgcolor='#FFFFDD'>
				�p�G�s�Z�ɨk�k�ͤ��G���ӽs���ܡA<font color='#FF0000'>�ĤG�����_�l�Z�����O�Ĥ@���_�l�Z���e�@�ӯZ</font>�F�Ĥ@���пﶶ�V�A�ĤG���п�f�V�C
				</td>
				";
		echo "	</tr></table><form name='class_form' method='post' action='{$_SERVER['PHP_SELF']}'>
			<br>�۰ʽs�Z�覡���G<br>
			<table cellspacing=5 cellpadding=0><tr><td valign='top'>
			<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
			<tr bgcolor='#E1ECFF' vlign='top'><td>
			<input type='radio' name='kind' value='0' $ksel[0] $onchg>���{�ɽs��<br>
			<input type='radio' name='kind' value='1' $ksel[1] $onchg>���{�ɽs�Z<br>
			<input type='radio' name='kind' value='2' $ksel[2] $onchg>�̦��Z
			</td>
			$lkind_str
			</tr></table>
			<input type='submit' name='Submit4' value='�}�l�s�Z'>
			<input type='submit' name='Submit2' value='�M���w�s���'><br>
			<input type='submit' name='Submit9' value='�U����l���Z�n����U(.CSV)'>
			<input type='submit' name='Submit11' value='�U����l���Z�n����U(����)'><br>
			<input type='submit' name='Submit8' value='�U���`���ƧǦW��C��(.CSV)'>
			<input type='submit' name='Submit10' value='�U���`���ƧǦW��C��(����)'><br>
			<input type='submit' name='Submit12' value='�U���k���`���ƧǦC��(.CSV)'>
			<input type='submit' name='Submit13' value='�U���k���`���ƧǦC��(����)'><br>
			<input type='submit' name='Submit14' value='�U���k���`���ƧǦC��(.CSV)'>
			<input type='submit' name='Submit15' value='�U���k���`���ƧǦC��(����)'>
			<input type='hidden' name='work' value='$work'>
			<input type='hidden' name='class_year_b' value='$class_year_b'>
			</td></tr></table>";
		if (!$ksel[1]) 	$sel_cstr="<td align='center'><input type='checkbox' name='all_class' $cacheck onClick='CheckAll();'>��ܩҦ��Z��</td>";
		echo "	�ثe�����s�Z���p�G<br>
			<table cellspacing=5 cellpadding=0><tr><td valign='top'>
			<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
			<tr bgcolor='#E1ECFF'>$sel_cstr<td align='center'>�����Z�O</td><td>�k�ͤH��</td><td>�k�ͤH��</td><td>�`�H��</td></tr>";
		$class_id=sprintf("%03d_%d_%02d",$new_sel_year,1,$class_year_b);
		$query="select * from school_class where year='$new_sel_year' and semester='1' and class_id like '$class_id%' order by class_id";
		$res=$CONN->Execute($query);
		while (!$res->EOF){
			$cid=$res->fields[class_id];
			$c=explode("_",$cid);
			$chk=($class_arr[intval($c[3])])?"checked":"";
			if (!$ksel[1]) 	$chk_cstr="<td align='center'><input type='checkbox' name='class_arr[".intval($c[3])."]' id='class_arr' $chk></td>";
			$query="select stud_sex,count(stud_name) from new_stud where stud_study_year='$new_sel_year' and class_year='".intval($c[2])."' and class_sort='".intval($c[3])."' group by stud_sex";
			$res_sex=$CONN->Execute($query);
			while (!$res_sex->EOF) {
				$sex[$cid][$res_sex->fields[stud_sex]]=intval($res_sex->fields[1]);
				$res_sex->MoveNext();
			}
			echo "	<tr bgcolor='#FFF7CD'>
				$chk_cstr
				<td align='center'>".$class_year[intval($c[2])].$res->fields[c_name]."�Z</td>
				<td align='right'>".intval($sex[$cid][1])."</td>
				<td align='right'>".intval($sex[$cid][2])."</td>
				<td align='right'>".intval($sex[$cid][1]+$sex[$cid][2])."</td></tr>";
			$res->MoveNext();
		}
		echo "</form></table></td></tr></table></table>";
		break;

	case 4:
		echo "	</tr></table><br>";
		echo "	<form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>
			�ǥͩm�W�G�@<input type='text' name='stud_name' value='$stud_name'><br>\n
			�{�ɽs���G�@<input type='text' name='stud_id' value='$stud_id'><br>\n
			�{�ɯZ�šG�@<input type='text' name='temp_class' value='$temp_class'><br>\n
			�����Ҧr���G<input type='text' name='stud_person_id' value='$stud_person_id'><br>\n
			�ͤ�G�@�@�@<input type='text' name='stud_birthday' value='$stud_birthday'><br>\n
			�q�ܡG�@�@�@<input type='text' name='stud_tel' value='$stud_tel'><br>\n
			��}�G�@�@�@<input type='text' name='stud_addr' value='$stud_addr'><small>(��J������}�Y�i)</small><br>\n
			�a���m�W�G�@<input type='text' name='guardian_name' value='$guardian_name'><br>\n
			��NŪ�ǮաG<input type='text' name='old_school' value='$old_school'><br>\n
			<input type='hidden' name='work' value='$work'>
			<input type='hidden' name='class_year_b' value='$class_year_b'>
			<input type='submit' name='Submit5' value='�}�l�d��'><br><br>";
		if ($_POST[Submit5]) {
			if ($_POST[stud_name]) $where="and stud_name='$_POST[stud_name]'";
			if ($_POST[stud_id]) $where.="and temp_id='$_POST[stud_id]'";
			if ($_POST[temp_class]) $where.="and temp_class='$_POST[temp_class]'";
			if ($_POST[stud_person_id]) $where.="and stud_person_id='$_POST[stud_person_id]'";
			if ($_POST[stud_birthday]) $where.="and stud_birthday='$_POST[stud_birthday]'";
			if ($_POST[stud_tel]) $where.="and stud_tel_1='$_POST[stud_tel]'";
			if ($_POST[stud_addr]) $where.="and stud_address like '$_POST[stud_addr]%'";
			if ($_POST[guardian_name]) $where.="and guardian_name='$_POST[guardian_name]'";
			if ($_POST[old_school]) $where.="and old_school='$_POST[old_school]'";
			$query="select * from new_stud where stud_study_year='$new_sel_year' $where order by stud_id";
			$res=$CONN->Execute($query);
			if ($res) {
				echo "<center><hr size='2' width='95%'><table border='0' cellspacing='2'><tr bgcolor='#FFEC6E'><td>�{�ɽs��</td><td>�{�ɯZ��</td><td>�ǥͩm�W</td><td>�����Ҧr��</td><td>�ͤ�</td><td>�q��</td><td>�a���m�W</td><td>��}</td><td>��NŪ�Ǯ�</td><td>�����Z��</td><td>�����y��</td></tr>";
				while (!$res->EOF) {
					echo "<tr bgcolor='#E6F7E2'><td>".$res->fields[temp_id]."</td><td>".$res->fields[temp_class]."</td><td>".$res->fields[stud_name]."</td><td>".$res->fields[stud_person_id]."</td><td>".$res->fields[stud_birthday]."</td><td>".$res->fields[stud_tel_1]."</td><td>".$res->fields[guardian_name]."</td><td>".$res->fields[stud_address]."</td><td>".$res->fields[old_school]."</td><td>".$res->fields[class_sort]."</td><td>".$res->fields[class_site]."</td></tr>";
					$res->MoveNext();
				}
				if ($res->RecordCount()==0) echo "<tr bgcolor='#E6F7E2'><td colspan='9' align='center'>�d�L�ŦX���</td></tr>";
				echo "</table></center>";
			}
		}
		echo "	</form></table>";
		break;

	case 5:
		echo "	</tr></table><br>
			�ثe�|���s�Z�ǥͬ��G<br>
			<table cellspacing=5 cellpadding=0><tr><td valign='top'>
			<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
			<tr bgcolor='#E1ECFF'><td>�{�ɽs��</td><td>�m�W</td><td>�ʧO</td></tr>";
		$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and (class_sort is null or class_site is null) and sure_study<>'0'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while (!$res->EOF) {
			$sex=$res->fields[stud_sex];
			if ($sex==1) {
				$stud_sex="�k";
				$fontcolor="'blue'";
			} else {
				$stud_sex="�k";
				$fontcolor="'#FF6633'";
			}
			echo "<tr bgcolor='#FFF7CD'><td>".$res->fields[temp_id]."</td><td><font color=$fontcolor>".$res->fields[stud_name]."</font></td><td align='center'><font color=$fontcolor>$stud_sex</font></td></tr>";
			$res->MoveNext();
		}
		if ($res->RecordCount()==0) echo "<tr bgcolor='#FFF7CD'><td colspan='3' align='center'>�d�L���</td></tr>";
		echo "</table></td></tr></table></table>";
		break;
	case 6:
		$query="select * from temp_class where year='$new_sel_year' and class_id like '$class_year_b%' order by class_id";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		if ($res->RecordCount()==0)
			return "�|���]�w�{�ɯZ�šA�Х��]�w�I";
		else {
			while (!$res->EOF) {
				$temp_class_arr[$res->fields[class_id]]=$res->fields[c_name]."�Z";
				$res->MoveNext();
			}
		}
		$query="select min(class_id),max(class_id) from school_class where year='$new_sel_year' and semester='1' and c_year='$class_year_b'";
		$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		$min_class=intval(substr($res->fields[0],-2,2));
		$max_class=intval(substr($res->fields[1],-2,2));
		$start_class=$_POST[start_class];
		if (empty($start_class)) $start_class=$min_class;
		$end_class=$_POST[end_class];
		if (empty($end_class)) $end_class=$max_class;
		$checked[intval($_POST[kind])]="checked";
		if ($_POST[Submit6]) {
			$query="select * from school_class where year='$new_sel_year' and semester='1' and c_year='$class_year_b' order by class_id";
			$res=$CONN->Execute($query);
			while (!$res->EOF) {
				$classn[$res->fields[class_id]]=$res->fields[c_name]."�Z";
				$res->MoveNext();
			}
			$csex=array("1"=>"�k","2"=>"�k");
			$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and class_sort >= '$start_class' and class_sort <= '$end_class' order by class_sort,class_site";
			$res=$CONN->Execute($query);
			while (!$res->EOF) {
				$class_sort=$res->fields[class_sort];
				if ($class_sort!=$old_class_sort) $i=1;
				$class_site=$res->fields[class_site];
				$class_id=sprintf("%03d_%d_%02d_%02d",$new_sel_year,1,$class_year_b,$class_sort);
				$id_arr[$class_id][$class_site]=$res->fields[temp_id];
				$name_arr[$class_id][$class_site]=$res->fields[stud_name];
				$sex_arr[$class_id][$class_site]=$csex[$res->fields[stud_sex]];
				$temp_arr[$class_id][$class_site]="<small>".substr($temp_class_arr[$res->fields[temp_class]],0,-2)."�Z".sprintf("%02d",$res->fields[temp_site])."��</small>"."&nbsp;";
				$meno_arr[$class_id][$class_site]=$res->fields[meno];
				$score_total[$class_id][$class_site]=0;
				$score_arr1[$class_id][$class_site]=$res->fields[temp_score1];
				if ($score_arr1[$class_id][$class_site]=="-100") {
					$score_arr1[$class_id][$class_site]="---";
				} else {
					$score_total[$class_id][$class_site]+=$score_arr1[$class_id][$class_site];
				}
				$score_arr2[$class_id][$class_site]=$res->fields[temp_score2];
				if ($score_arr2[$class_id][$class_site]=="-100") {
					$score_arr2[$class_id][$class_site]="---";
				} else {
					$score_total[$class_id][$class_site]+=$score_arr2[$class_id][$class_site];
				}
				$score_arr3[$class_id][$class_site]=$res->fields[temp_score3];
				if ($score_arr3[$class_id][$class_site]=="-100") {
					$score_arr3[$class_id][$class_site]="---";
				} else {
					$score_total[$class_id][$class_site]+=$score_arr3[$class_id][$class_site];
				}
				$i++;
				$res->MoveNext();
			}
			$pages=count($id_arr);
			reset ($id_arr);
			$pg=1;
			while (list($k,$v)=each($id_arr)) {
				if ($k=="") {
					$pages--;
					continue;
				}
				switch ($_POST[kind]) {
					case 0:
						echo "	<html><head><meta http-equiv=\"Content-Language\" content=\"zh-tw\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">
							<title>$school_name $new_sel_year �Ǧ~�� �s�ͥ����s�Z�W�U</title></head>
							<body>
							<p align=\"center\"><font face=\"�з���\" size=\"4\">$school_name $new_sel_year �Ǧ~��</font><br><font face=\"�з���\" size=\"5\">�s�ͥ����s�Z<->�{�ɽs����ӦW�U</font></p><p align=\"left\">�����Z�O�G".$classn[$k]."</p>
							<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"610\">
							<tr>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"70\">�{�ɽs��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�ʧO</td>
							<td style=\"border-left:0.75pt solid windowtext; border-right:3px double windowtext; border-top:1.5pt solid windowtext; border-bottom:0.75pt solid windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm\" align=\"center\" width=\"70\">�ơ@��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"70\">�{�ɽs��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�ʧO</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"70\">�ơ@��</td>
							</tr>";
						for ($i=1;$i<=30;$i++)	{
							$j=$i+30;
							if ($i % 5 != 0)
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$i."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\">".$sex_arr[$k][$i]."</td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width:1\" align=\"center\"><font size=\"-2\">".$meno_arr[$k][$i]."</font></td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\">".$sex_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font size=\"-2\">".$meno_arr[$k][$j]."</font></td>
									</tr>";
							else
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">$i</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\">".$sex_arr[$k][$i]."</td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width: 1.5pt\" align=\"center\"><font size=\"-2\">".$meno_arr[$k][$i]."</font></td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1.5pt\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\">".$sex_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font size=\"-2\">".$meno_arr[$k][$j]."</font></td>
									</tr>";
						}
						break;
					case 1:
						echo "	<html><head><meta http-equiv=\"Content-Language\" content=\"zh-tw\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">
							<title>$school_name $new_sel_year �Ǧ~�� �s�ͥ����s�Z�W�U</title></head>
							<body>
							<p align=\"center\"><font face=\"�з���\" size=\"4\">$school_name $new_sel_year �Ǧ~��</font><br><font face=\"�з���\" size=\"5\">�s�ͥ����s�Z<->�{�ɮy����ӦW�U</font></p><p align=\"left\">�����Z�O�G".$classn[$k]."</p>
							<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"610\">
							<tr>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"70\">�{�ɽs��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-left:0.75pt solid windowtext; border-right:3px double windowtext; border-top:1.5pt solid windowtext; border-bottom:0.75pt solid windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm\" align=\"center\" width=\"105\">�{�ɮy��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"70\">�{�ɽs��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"105\">�{�ɮy��</td>
							</tr>";
						for ($i=1;$i<=30;$i++)	{
							$j=$i+30;
							if ($i % 5 != 0)
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$i."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width:1\" align=\"right\">".$temp_arr[$k][$i]."</td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"right\">".$temp_arr[$k][$j]."</td>
									</tr>";
							else
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">$i</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width: 1.5pt\" align=\"right\">".$temp_arr[$k][$i]."</td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1.5pt\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$id_arr[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"right\">".$temp_arr[$k][$j]."</td>
									</tr>";
						}
						break;
					case 2:
						echo "	<html><head><meta http-equiv=\"Content-Language\" content=\"zh-tw\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">
							<title>$school_name $new_sel_year �Ǧ~�� �s�ͥ����s�Z�W�U</title></head>
							<body>
							<p align=\"center\"><font face=\"�з���\" size=\"4\">$school_name $new_sel_year �Ǧ~��</font><br><font face=\"�з���\" size=\"5\">�s�ͥ����s�Z<->���禨�Z��ӦW�U</font></p><p align=\"left\">�����Z�O�G".$classn[$k]."</p>
							<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"610\">
							<tr>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤ@</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤG</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤT</td>
							<td style=\"border-left:0.75pt solid windowtext; border-right:3px double windowtext; border-top:1.5pt solid windowtext; border-bottom:0.75pt solid windowtext; padding-left:1.4pt; padding-right:1.4pt; padding-top:0cm; padding-bottom:0cm\" align=\"center\" width=\"50\">�`��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"35\">�y��</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"90\">�m�@�@�W</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤ@</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤG</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"40\">��ؤT</td>
							<td style=\"border-style: solid; border-color: windowtext; border-width: 1.5pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"center\" width=\"50\">�`��</td>
							</tr>";
						for ($i=1;$i<=30;$i++)	{
							$j=$i+30;
							if ($i % 5 != 0)
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$i."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr1[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr2[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr3[$k][$i]."</font></td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width:1\" align=\"right\">".$score_total[$k][$i]."&nbsp;&nbsp;&nbsp;</td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr1[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr2[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr3[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 0.75pt 0.75pt; padding: 0cm 1.4pt;\" align=\"right\">".$score_total[$k][$j]."&nbsp;&nbsp;&nbsp;</td>
									</tr>";
							else
								echo "	<tr>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">$i</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$i]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr1[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr2[$k][$i]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr3[$k][$i]."</font></td>
									<td style=\"border-right-style: double; border-right-width: 3; border-bottom-style:solid; border-bottom-width: 1.5pt\" align=\"right\">".$score_total[$k][$i]."&nbsp;&nbsp;&nbsp;</td>
									<td style=\"border-bottom-style: solid; border-bottom-width: 1.5pt\" align=\"center\"><font face=\"Dotum\">$j</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\">&nbsp;".$name_arr[$k][$j]."</td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr1[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr2[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 0.75pt 1.5pt; padding: 0cm 1.4pt;\" align=\"center\"><font face=\"Dotum\">".$score_arr3[$k][$j]."</font></td>
									<td style=\"border-style: solid; border-color: windowtext; border-width: 0.75pt 1.5pt 1.5pt 0.75pt; padding: 0cm 1.4pt;\" align=\"right\">".$score_total[$k][$j]."&nbsp;&nbsp;&nbsp;</td>
									</tr>";
						}
						break;
				}
				if ($pages!=$pg) echo "</table><br style=\"page-break-before:always\">";
				$pg++;
			}
			echo "</body></html>";
		} else 
		echo "	</tr></table><br><form name='form' method='post' action='{$_SERVER['PHP_SELF']}' target='new'>�Z�Žd��G��<input type='text' name='start_class' size='2' value='$start_class'>�Z��<input type='text' size='2' name='end_class' value='$end_class'>�Z<br>
			<input type='radio' name='kind' value='0' $checked[0]>�s�ͥ����s�Z<->�{�ɽs���W�U <br>
			<input type='radio' name='kind' value='1' $checked[1]>�s�ͥ����s�Z<->�{�ɮy���W�U<br>
			<input type='radio' name='kind' value='2' $checked[2]>�s�ͥ����s�Z<->���禨�Z�W�U<br>
			<input type='submit' name='Submit6' value='�}�l�C�L'>
			<input type='hidden' name='work' value='$work'>
			<input type='hidden' name='class_year_b' value='$class_year_b'>
			</form>";
		break;
	case 7:
		$chkf[$_POST[first]]="checked";
		if (empty($_POST[first])) $chkf[2]="checked";
		echo "	</tr></table>
			<form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>
			<table><tr><td>
			<table bgcolor='#000000' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#E1ECFF'>
			<td>�y���s�ƳW�h<font color='#ff0000'> (�п�J1�B2�B3...)</font></td>
			</tr>
			<tr bgcolor='#FFF7CD'><td>
			<input type='text' name='law[stud_sex]' size='1' maxlength='1' value='$law[stud_sex]'>�ʧO�]<input type='radio' name='first' value='2' $chkf[2]>�k�ͦb�e�@<input type='radio' name='first' value='1' $chkf[1]>�k�ͦb�e�^<br>
			<input type='text' name='law[stud_name]' size='1' maxlength='1' value='$law[stud_name]'>�m�W<br>
			<input type='text' name='law[temp_id]' size='1' maxlength='1' value='$law[temp_id]'>�{�ɽs��<br>
			</td></tr>
			</table></td></tr></table><input type='submit' name='Submit7' value='�}�l���s�s�Ʈy��'><input type='hidden' name='work' value='$work'><input type='hidden' name='class_year_b' value='$class_year_b'>
			";
		break;
	case 8:
		$input_class1=$_REQUEST[input_class1];
		$input_class2=$_REQUEST[input_class2];
		//���X�S��Z�W
		$query="select distinct meno from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='2' order by meno";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			if ($res->fields[meno]!=$spec_chg_str && $res->fields[meno]!="") 	$spec_arr[$res->fields[meno]]=$res->fields[meno];
			$res->MoveNext();
		}

		if (empty($input_class1)) $input_class1=sprintf("%03d_%d_%02d_%02d",$new_sel_year,1,$class_year_b,1);
		$c[1]=explode("_",$input_class1);
		if (empty($input_class2) || ($input_class2==$input_class1)) {
			$first_class=($c1[3]=="01")?2:1;
			$input_class2=sprintf("%03d_%d_%02d_%02d",$new_sel_year,1,$class_year_b,$first_class);
		}
		$c[2]=explode("_",$input_class2);
		$class_menu1=full_class_name($input_class1,"input_class1",$new_sel_year,$class_year_b,1,"",$spec_arr);
		$class_menu2=full_class_name($input_class2,"input_class2",$new_sel_year,$class_year_b,1,$input_class1);
		echo "<form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>$class_menu1 ��=�� $class_menu2<input type='hidden' name='work' value='$work'><input type='hidden' name='class_year_b' value='$class_year_b'></table>";
		for ($i=1;$i<=2;$i++) {
			if (in_array(${"input_class".$i},$spec_arr)) {
				$query="select *,(temp_score1+temp_score2+temp_score3) as c from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and meno='$input_class1' and sure_study='2' order by c desc";
			} else {
				$query="select *,(temp_score1+temp_score2+temp_score3) as c from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and class_sort='".intval($c[$i][3])."' order by c desc";
			}
			$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			$sum[$i]=$res->RecordCount();
			$id=0;
			while (!$res->EOF) {
				$id++;
				$class_site[$i][$id]=$res->fields[class_site];
				if ($class_site[$i][$id]==0) $class_site[$i][$id]=$id;
				$stud_name[$i][$id]=$res->fields[stud_name];
				$temp_score1[$i][$id]=$res->fields[temp_score1];
				$temp_score2[$i][$id]=$res->fields[temp_score2];
				$temp_score3[$i][$id]=$res->fields[temp_score3];
				$stud_id[$i][$id]=$res->fields[temp_id];
				$sex=$res->fields[stud_sex];
				//�ˬd����
				if ($i==1 && $_POST[sel1]==$stud_id[$i][$id]) $chk_score=$res->fields[c];
				if ($i==2 && $_POST[sel1]) {
					$chk_s=abs($chk_score-$res->fields[c]);
					if ($chk_s==0)
						$bgcr[$id]="#FF99FC";
					elseif ($chk_s<=5)
						$bgcr[$id]="#FFD9FC";
					elseif ($chk_s<=10)
						$bgcr[$id]="#FFF2FC";
				}
				if ($sex==1) {
					$stud_sex[$i][$id]="�k";
					$fontcolor[$i][$id]="blue";
				} else {
					$stud_sex[$i][$id]="�k";
					$fontcolor[$i][$id]="#FF6633";
				}
				$res->MoveNext();
			}
		}
		echo "	$error_msg
			<input type='submit' name='Submit16' value='���'>
			<table><tr>";
		for ($i=1;$i<=2;$i++) {
			echo "	<td valign='top'><table><tr><td>
				<table bgcolor='#000000' border='0' cellpadding='2' cellspacing='1'>
				<tr bgcolor='#E1ECFF'>
				<td>�y��</td>
				<td>�{�ɽs��</td>
				<td>�ǥͩm�W</td>
				<td>�ʧO</td>
				<td align='center'>���<br>�@</td>
				<td align='center'>���<br>�G</td>
				<td align='center'>���<br>�T</td>
				</tr>\n";
			for ($j=1;$j<=$sum[$i];$j++) {
				$chg_str=($i==1)?"OnChange='this.form.submit();'":"";
				$chked=(($i==1 && $_POST[sel1]==$stud_id[$i][$j])||($i==2 && $_POST[sel2]==$stud_id[$i][$j]))?"checked":"";
				$bg=($i==2 && !empty($bgcr[$j]))?$bgcr[$j]:"#FFF7CD";
				$bg=($i==1 && $_POST[sel1]==$stud_id[$i][$j])?"#C9FF99":$bg;
				echo "	<tr bgcolor='$bg'>
					<td><input type='radio' name='sel".$i."' $chg_str $chked value='".$stud_id[$i][$j]."'>".sprintf("% 2d",$class_site[$i][$j])."</td>
					<td>".$stud_id[$i][$j]."</td>
					<td><font color='".$fontcolor[$i][$j]."'>".$stud_name[$i][$j]."</font></td>
					<td align='center'><font color='".$fontcolor[$i][$j]."'>".$stud_sex[$i][$j]."</font></td>
					<td align='center'>".$temp_score1[$i][$j]."</td>
					<td align='center'>".$temp_score2[$i][$j]."</td>
					<td align='center'>".$temp_score3[$i][$j]."</td>
					</tr>\n";
			}
			echo "</table></td></tr></table>";
			if ($i==1)
				echo "<td><img src='images/exchange.png'><td>";
			else
				echo "<td>&nbsp;<td valign='top'><table bgcolor='#000088' border='0' cellpadding='2' cellspacing='1'><tr bgcolor='#FFFFFF'><td><table class='small'><tr><td colspan='2'>�����G</tr><tr><td width='10' bgcolor='#FF99FC'><td bgcolor='#FFF7CD'>����<br>�ۦP</tr><tr><td width='10' bgcolor='#FFD9FC'><td bgcolor='#FFF7CD'>���Ʈt<br>������</tr><td width='10' bgcolor='#FFF2FC'><td bgcolor='#FFF7CD'>���Ʈt<br>�Q����</tr><tr><td colspan='2'>��ĳ�G</tr><tr><td colspan='2' width='45' bgcolor='#FFFFCC'>�Y���귽�Z��աA��ĳ��ժ���H���P���θ��C���̡F�Y�����u�Z��աA��ĳ��ժ���H���P���θ������̡C</tr></table></tr></table>";
		}
		echo "</tr></table><input type='hidden' name='class_year_b' value='$class_year_b'><input type='hidden' name='work' value='$work'><input type='submit' name='Submit16' value='���'></form>";
		break;
	default:
		echo "</tr></table>";
}


//�����D������ܰ�
if(!$_POST['Submit6']) {
	echo "</td></tr></table>";

	//�{���ɧ�
	foot();
}

//�����s�Z���Z�ſ��
function  full_class_name($id,$col_name,$stud_study_year,$class_year_b,$onchange,$except,$spec_arr){
	global $CONN;

	$OnChg=($onchange==1)?"onchange='this.form.submit();'":"";
	$temp_str="<select name='$col_name' $OnChg>\n";
	if (count($spec_arr)>0) {
		while(list($k,$v)=each($spec_arr)) {
			$sel=($k==$id)?"selected":"";
			$temp_str.="<option value='$k' $sel>$v \n";
		}
	}
	$class_id=sprintf("%03d_%d_%02d",$stud_study_year,1,$class_year_b);
	$query="select * from school_class where year='$stud_study_year' and semester='1' and class_id like '$class_id%' order by class_id";
	$res=$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	if ($res->RecordCount()==0)
		return "�|���]�w�����Z�šA�Х��]�w�I";
	else {
		while (!$res->EOF) {
			$selected=($id==$res->fields[class_id])?"selected":"";
			$temp_str.=($except==$res->fields[class_id])?"":"<option value='".$res->fields[class_id]."' $selected>".$res->fields[c_name]."�Z</option>\n";
			$res->MoveNext();
		}
		$temp_str.="</select>\n";
		return $temp_str;
	}
	
}
?>

<script language="JavaScript1.2">
<!-- Begin
function jumpMenu1(){
	var str, classstr ;
 if (document.form1.work.options[document.form1.work.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?work=" + document.form1.work.options[document.form1.work.selectedIndex].value + "&class_year_b=" + document.form1.class_year_b.options[document.form1.class_year_b.selectedIndex].value;
	}
}

function CheckAll(){
	for (var i=0;i<document.class_form.elements.length;i++){
		var e = document.class_form.elements[i];
		if (e.id == 'class_arr') e.checked = !e.checked;
	}
}
//  End -->
</script>
