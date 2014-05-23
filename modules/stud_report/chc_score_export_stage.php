<?php
//$Id: chc_score_export.php,v 1.1.2.2 2005/09/08 09:01:21 chi Exp $
require_once( "./chc_config.php");
include_once "../../include/sfs_case_dataarray.php";
//echo "<pre>";
//�U�즨�Z�ץX
//�{��
sfs_check();
// 1.smarty����
//$template_dir = $_SERVER[DOCUMENT_ROOT].dirname($_SERVER[PHP_SELF])."/templates/";
$template_dir = $SFS_PATH."/".get_store_path()."/templates/";

// $smarty->config_dir = $template_dir;

$save_csv=$_POST['save_csv'];

//---�אּ���o��@�Z�Ū��ǥͧǸ�
//----�ǤJ class_id 
//----�Ǧ^ �t�ǥͧǸ����}�C student_sn
function get_stsn($class_id){
	global $CONN;
	$st_sn=array();
	//--foreach($class_id as $key=>$data){
	$key = $class_id;
	$class_ids=split("_",$key);
	$seme=$class_ids[0].$class_ids[1];
	$the_class=($class_ids[2]+0).$class_ids[3];
	$SQL="select student_sn from stud_seme where  seme_year_seme ='$seme' and seme_class='$the_class' order by seme_num ";
	$rs = $CONN->Execute($SQL);
	$the_sn=$rs->GetArray();
	for ($i=0;$i<$rs->RecordCount();$i++){
		array_push($st_sn,$the_sn[$i][student_sn]);
	}
	//---}

	return $st_sn;
}

//--- ��l�ƻݭn���ܼ�
$break_page="<P STYLE='page-break-before: always;'>";
$prn_page = 0;

///�H�Z�Ű}�C���X�ǥ�
if ($_POST[act]=='OK' && is_array($_POST[class_id]) ){
	//print_r($_POST[class_id]);
	//--- ���o�Ҧ��Z�Ū��ǥͥN��

	$class_data=array();
	foreach($_POST[class_id] as $class_id=>$data) {
		$sn_ary=get_stsn($class_id);
		foreach($sn_ary as $student_sn) {
			$class_data[$class_id][$student_sn][seme_ary]=seme_num_detail($student_sn);
		}
	}

	$sub_str='';
	$sub_ary=array();
	foreach ($class_data as $class_id=>$stud_ary) {
		foreach($stud_ary as $student_sn=>$stud) {
			foreach($stud[seme_ary] as $seme_key=>$seme_data) {
				if (!empty($seme_data)) {
					if (strpos($sub_str,$seme_data[class_id])===false) {
						$sub_str .= '/'.$seme_data[class_id];
						$class_sub=get_subj($seme_data[class_id],'stage'); //���o�ݬq�Ҫ����
						foreach ($class_sub as $ss_id=>$sub) {
							$sub_name=$sub[sb];
							if (empty($sub_ary[$seme_key][$sub_name])) {
								$sub_ary[$seme_key][$sub_name]='**';
							}
						}
					}
				}
			}
		}
	}
	//print_r($class_data);
	//print_r($sub_ary['6_2']);
	//die();

	//����ܤE�~�ŲĤG�Ǵ�
	unset($sub_ary['9_2']);

	//unset($sub_ary['3_2']);
	//print_r($sub_ary);
	foreach ($class_data as $class_id=>$stud_ary) {
		foreach($stud_ary as $student_sn=>$stud) {
			$base_ary = get_base_data($student_sn);
			$class_data[$class_id][$student_sn][base][stud_id]=$base_ary[stud_id];
			$class_data[$class_id][$student_sn][base][stud_name]=$base_ary[stud_name];
			$class_data[$class_id][$student_sn][base][class_id]=$base_ary[class_id];
			$class_data[$class_id][$student_sn][base][cla_no]=$base_ary[cla_no];
			$class_data[$class_id][$student_sn][base][seme_num]=$base_ary[seme_num];
			$class_data[$class_id][$student_sn][base][stud_sex]=$base_ary[stud_sex];

			$stud_id=$base_ary[stud_id];
			foreach($stud[seme_ary] as $seme_key=>$seme_data) {
				if (empty($seme_data)) {
					unset($class_data[$class_id][$student_sn][seme_ary][$seme_key]);
				}
				else {
					$stage_score=stage_score_chc($seme_data[class_id], $student_sn);
					$class_data[$class_id][$student_sn][seme_ary][$seme_key][stage_score]=$sub_ary[$seme_key];
					foreach($stage_score as $ss_id=>$score_ary) {
						$sub_name=$score_ary[sb];
						$score=$score_ary[score];
						if ($sub_ary[$seme_key][$sub_name]=='**') {
							$class_data[$class_id][$student_sn][seme_ary][$seme_key][stage_score][$sub_name]=$score;
						}
					}
				}
			}
		}
	}

	foreach ($sub_ary as $seme_key=>$subs) {
		$sub_arys[$seme_key][items]=count($subs);
		$sub_arys[$seme_key][name]=$subs;
	}

   	//print_r($sub_arys);
	//print_r($class_data);
   	//die();

	//print_r($main);
	//die();
	if($save_csv){
		$title_ary0='"'.$school_long_name.'",'."\n".'"�`�N�G",'."\n".'"1.���ˬd�q�Ҥά�ئW�٦��Z���`��",'."\n".'"2.�u**�v��ܸӬ�صL����",'."\n".'"3.�u7_1�v��ܤC�~�ŲĤ@�Ǵ�",';
		$title_ary1=array('','','','','');
		$title_ary2=array('�Z��','�y��','�m�W','�Ǹ�','�ʧO');
		foreach($sub_arys as $sem_sub => $sub){
			foreach($sub[name] as $sub_name => $value){
				for($j=1;$j<=3;$j++){ //�T���q��
					$title_ary1[]='"'.$sem_sub.'"';
					$title_ary2[]='"'.$sub_name.$j.'"';
				}
			}
		}
		//print_r($title_ary1);
		//print_r($title_ary2);
		$csv_title1=implode(",",$title_ary1);
		$csv_title2=implode(",",$title_ary2);
		$i=0;
		foreach($class_data as $my_class_id => $my_class_ary){
			foreach($my_class_ary as $my_student_sn => $my_stud){
				$main[$i]='"'.$my_stud[base][cla_no].'",';
				$main[$i].='"'.$my_stud[base][seme_num].'",';
				$main[$i].='"'.$my_stud[base][stud_name].'",';
				$main[$i].='"'.$my_stud[base][stud_id].'",';
				$main[$i].='"'.$my_stud[base][stud_sex].'",';
	
				foreach($my_stud[seme_ary] as $my_seme_key => $my_seme_data){
					foreach($my_seme_data[stage_score] as $my_sub_name => $my_score){
						$main[$i].='"'.$my_score[1].'","'.$my_score[2].'","'.$my_score[3].'",';
					}
				}
				$main[$i].="\n";
				$i++;
			}
		}
		$filename = $class_id."_".time()."_stagescore.csv";

		header("Content-type: text/x-csv ; Charset=Big5");
		header("Content-disposition:attachment ; filename=$filename");
		//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
		header("Expires: 0");
		echo $title_ary0."\n".$csv_title1."\n".$csv_title2."\n";
		foreach($main as $num => $my_str){
			echo $my_str;
		}
	}else{
		$smarty->left_delimiter="{{";
		$smarty->right_delimiter="}}";
		//---���J���������CSS�]�w��
		$smarty->display($template_dir."prn_head.tpl");
		foreach ($class_data as $class_id=>$class_ary) {
			$smarty->assign('school_name',$school_long_name);
			$smarty->assign('sub_arys', $sub_arys);
			$smarty->assign('class_id', $class_id);
			$smarty->assign('class_ary', $class_ary);
			$smarty->assign('break_page', $break_page);
			$smarty->display($template_dir."chc_score_export_stage.htm");
		}
	}

}


?>
