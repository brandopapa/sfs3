<?php
//$Id: export.php 8524 2015-09-09 14:36:41Z chiming $
include "config.php";

//�{��
sfs_check();
$blank_name=$_POST['blank_name'];

if ($_POST[do_key]) {
	if ($_POST[data_id]==0) {
		$sss="\"�Ǧ~��\",\"�ǮեN��\",\"�ǥͩm�W\",\"�ǥͩʧO\",\"�X�ͦ~���\",\"�ǥ͵��ŧO\",\"�ǥͨ����O\",\"�~�ŧO\",\"�k���r�����O\",\"�����r�����O\",\"�~�y�t���l�k\",\"�a�x�{�p\"\r\n";
		$sss.="\"YEAR\",\"SCODE\",\"NAME\",\"SEX\",\"BIRTH\",\"LEVEL\",\"SORTS\",\"YEARS\",\"RIGHT\",\"LEFT\",\"FOREIGN\",\"FAMILY\"\r\n";

		$sel_year=curr_year();
		$sel_seme=curr_seme();
		$lv=($IS_JHORES==0)?"C":"J";
		$sorts_arr=array("�@���"=>10,"��L"=>20,"������"=>21,"������"=>22,"���W��"=>23,"���A��"=>24,"���n��"=>25,"�Q��"=>26,"���"=>26,"�|�ͱ�"=>27,"�ɮL��"=>28,"�F����"=>29,"������"=>29,"���"=>"2A","��������"=>"2B","�Ӿ|�ձ�"=>"2C","���_�ܶ���"=>"2D","�ɼw�J��"=>"2E","����"=>"30");
		//���X�ǮեN�X
		$query="select sch_id from school_base";
		$res=$CONN->Execute($query);
		$sch_id=$res->fields[sch_id];

		//���X�ǥͨ����O���
		$query="select student_sn,clan,type_id from stud_subkind where type_id in ('6','9')";
		$res=$CONN->Execute($query) or die('�ʤ־ǥͨ������O�P�ݩʸ�ƪ�stud_subkind');
		while(!$res->EOF) {
			$student_sn=$res->fields[student_sn];
			$clan[$student_sn]=trim($res->fields[clan]);
			$type_id[$student_sn]=$res->fields[type_id];
			if (substr($clan[$student_sn],-2,2)!="��") {
				$clan[$student_sn].="��";
			}
			$res->MoveNext();
		}

		$foreign_arr=array("����"=>1,"���ؤH���@�M��"=>1,"�j���a��"=>1,"����j��"=>1,"�V�n"=>2,"�L�ץ����"=>3,"�L��"=>3,"����"=>4,"��߻�"=>5,"�Z�H��"=>6,"�饻"=>7,"���Ӧ��"=>"8","����"=>"9","�_��"=>"10","�n��"=>"10","����"=>"10","�q�l"=>"11","�s�[�Y"=>"12","�[���j"=>"13");
				
		//���X�ǥͥ~�y�t���l�k�����O���
		$query="select student_sn,area from stud_subkind where type_id='".($m_arr['foreign_id']?$m_arr['foreign_id']:'100')."'";
		
		
		$res=$CONN->Execute($query) or die('�ʤ־ǥͨ������O�P�ݩʸ�ƪ�stud_subkind');
		while(!$res->EOF) {
			$student_sn=$res->fields[student_sn];
			$foreign_area[$student_sn]=trim($res->fields[area]);
			$foreign_id[$student_sn]=$foreign_arr[$res->fields[area]];
			//���Ϧ��w�q��O   �o������w�N����C  �h��H"��L"(14)
			if($foreign_area[$student_sn] and ! $foreign_id[$student_sn]) { $foreign_id[$student_sn]='14'; }
			$res->MoveNext();
		}
		
		//���X���O���
		$query="select * from health_sight where year='$sel_year' and semester='$sel_seme'";
		$res=$CONN->Execute($query) or die('�ʤ־ǥͰ��d��T�Ҳո�ƪ� health_sight');
		while(!$res->EOF) {
			$sight_v[$res->fields[student_sn]][$res->fields[side]]=$res->fields[sight_o];
			$res->MoveNext();
		}

		//���X�ǥ͸��
		$student_error="";
		$query="select * from stud_base where stud_study_cond in ('0','15') order by curr_class_num";
		$res=$CONN->Execute($query);
		while(!$res->EOF) {
			$student_birthday=$res->fields[stud_birthday];
			$stud_id=$res->fields[stud_id];
			//�ˬd�X�ͦ~���O�_����
			if($student_birthday<>'0000-00-00') {
				$student_sn=$res->fields[student_sn];
				$s=($res->fields[stud_sex]==2)?"F":"M";
				$ss=$clan[$student_sn];
				$fs=$foreign_id[$student_sn];
				if ($type_id[$res->fields[student_sn]]==6)
					$st="30";
				elseif ($ss=="")
					$st="10";
				else {
					$st=$sorts_arr[$ss];
					if ($st=="") $st="20";
				}
				$r=number_format($sight_v[$res->fields[student_sn]][r],1);
				$l=number_format($sight_v[$res->fields[student_sn]][l],1);
				$bday=explode("-",$res->fields[stud_birthday]);
				if($blank_name) $student_name=''; else $student_name=$res->fields[stud_name];
				
				//�ꤤ�~��-6
				$grade=substr($res->fields[curr_class_num],0,1);
				$years=($lv=='J')?$grade-6:$grade;
				
				//����a�x���p(�H�Ǵ��ϦV�ƧǡA����̫�Ǵ������O)    L�G�a�x�{�p( 1�X)�A1=���ˡA2=��ˡA3=�H��
				//$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
				$sql="SELECT sse_family_kind FROM stud_seme_eduh WHERE stud_id='$stud_id' ORDER BY seme_year_seme DESC";
				$res2=$CONN->Execute($sql) or die('�ʤ־ǥͻ��ɸ�ƪ� stud_seme_eduh');
				$family_kind=$res2->fields[0]?$res2->fields[0]:1;  //�Y�L�O���h�w�]��~~ 1.���� 
				
				
				if($quoted) $sss.="$sel_year,\"".sprintf("%06d",$sch_id)."\",\"$student_name\",\"$s\",".sprintf("%03d%02d",intval($bday[0])-1911,$bday[1],$bday[2]).",\"$lv\",\"$st\",$years,$r,$l,$fs,$family_kind\r\n";
				else  $sss.="$sel_year,".sprintf("%06d",$sch_id).",$student_name,$s,".sprintf("%03d%02d%02d",intval($bday[0])-1911,$bday[1],$bday[2]).",$lv,$st,$years,$r,$l,$fs,$family_kind\r\n";
			} else {
				$student_error.='���Ǹ��G'.$res->fields[stud_id].'  �Z�Ůy���G'.$res->fields[curr_class_num].'  �m�W�G'.$res->fields[stud_name].'<br>';
			}
			$res->MoveNext();
		}
		
		//�P�_�O�_���ǥͥͤ��ƿ��~
		if(! $student_error) {
			header("Content-disposition: attachment; filename=student.csv");
			header("Content-type: application/octetstream; Charset=Big5");
			//header("Pragma: no-cache");
							//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

			header("Expires: 0");
			echo $sss;
			exit;	
		}
	}
}

//��ƿ��
$sel1 = new drop_select();
$sel1->s_name="data_id";
$sel1->id= $data_id;
$sel1->arr = array("0"=>"�ǥ�CSV��");
$sel1->has_empty = false;
$sel1->is_submit = true;
$smarty->assign("data_sel",$sel1->get_select());

//�P�_���O��O�_�s�b
$query="select * from health_sight where 1=0";
$res=$CONN->Execute($query);
if ($res) {
	$smarty->assign("OK1",1);
	$query="select count(*) as nums from health_sight where year='".curr_year()."' and semester='".curr_seme()."'";
	$res=$CONN->Execute($query);
	if ($res->fields['nums']>0) $smarty->assign("OK2",1);
}

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("SFS_PATH_HTML",$SFS_PATH_HTML);
$smarty->assign("module_name","��ƶץX");
$smarty->assign("SFS_MENU",$school_menu_p);
$smarty->assign("STUDENT_ERROR",$student_error);
if($student_error) $smarty->display("edu_chart_error.tpl"); else $smarty->display("edu_chart_export.tpl");

