<?php
// $Id: my_fun.php 5310 2009-01-10 07:57:56Z hami $
function year_seme_menu($sel_year,$sel_seme) {
	global $CONN;

	$sql="select year,semester from school_class where enable='1' order by year,semester";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$year=$rs->fields["year"];
		$semester=$rs->fields["semester"];
		if ($year!=$oy || $semester!=$os)
			$show_year_seme[$year."_".$semester]=$year."�Ǧ~�ײ�".$semester."�Ǵ�";
		$oy=$year;
		$os=$semester;
		$rs->MoveNext();
	}
	$scys = new drop_select();
	$scys->s_name ="year_seme";
	$scys->top_option = "��ܾǴ�";
	$scys->id = $sel_year."_".$sel_seme;
	$scys->arr = $show_year_seme;
	$scys->is_submit = true;
	return $scys->get_select();
}

function class_year_menu($sel_year,$sel_seme,$id) {
	global $school_kind_name,$CONN;

	$sql="select distinct c_year from school_class where year='$sel_year' and semester='$sel_seme' and enable='1' order by c_year";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_year_name[$rs->fields["c_year"]]=$school_kind_name[$rs->fields["c_year"]]."��";
		$rs->MoveNext();
	}
	$scy = new drop_select();
	$scy->s_name ="year_name";
	$scy->top_option = "��ܦ~��";
	$scy->id = $id;
	$scy->arr = $show_year_name;
	$scy->is_submit = true;
	return $scy->get_select();
}

function class_name_menu($sel_year,$sel_seme,$sel_class,$id) {
	global $CONN;

	$sql="select distinct c_name,c_sort from school_class where year='$sel_year' and semester='$sel_seme' and c_year='$sel_class' and enable='1' order by c_sort";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$show_class_year[$rs->fields["c_sort"]]=$rs->fields["c_name"]."�Z";
		$rs->MoveNext();
	}
	$sc = new drop_select();
	$sc->s_name ="me";
	$sc->top_option = "��ܯZ��";
	$sc->id = $id;
	$sc->arr = $show_class_year;
	$sc->is_submit = true;
	return $sc->get_select();
}

//�Ѹ�ƪ����o�ɾǾǮ�
function get_grade_school_table($sel_year='') {
        global $CONN ;      
	if ($sel_year=='')
        	$sel_year = curr_year(); //�ثe�Ǧ~		
	$sqlstr = " SELECT new_school  FROM  grad_stud where stud_grad_year = '$sel_year' group by new_school " ;

	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
	while ($row = $result->FetchRow() )
	    if ( $row["new_school"]){
	        $sc_name = $row["new_school"];
		$temp[] = $sc_name ;
	    }	
	return $temp;	
} 

//���o�w�]�Ȥ����ɾǾǮզW��(�t��)
function get_grade_school() {
      global $G_SCHOOL_NAME ;  
      $sc_name_arr = get_grade_school_table() ;
      $tmp_arr = split("," , $G_SCHOOL_NAME) ;
      foreach ($tmp_arr as $key =>$value ) {
        if (!in_array($value, $sc_name_arr))
        $sc_name_arr[] = $value ;
      }  
      return $sc_name_arr ;   
}

//�Ʀr�ର��r90 -> �E��
function PNum2CNum($num) {	
	$ChineseNumeric =array ('��','�@','�G','�T','�|','��','��','�C','�K','�E');
        for ($i=0 ;$i<strlen($num); $i++){
            $d = substr($num , $i,1) ;
            $str .= $ChineseNumeric[$d] ;
        }
        return $str ;
}

//add by david 20150515 �����|�j�D�b�ӿ��
function my_score_area_menu($id,$other_script="") {	
	$show_score_area['all']="����";
	$show_score_area['���D�b']="���D�b";
	$show_score_area['��¦�D�b']="��¦�D�b";
	$show_score_area['�ͩR�D�b']="�ͩR�D�b";
	$show_score_area['�ͬ��D�b']="�ͬ��D�b";
	$scy = new drop_select();
	$scy->s_name ="score_area";
	$scy->top_option = "��ܥD�b";
	$scy->id = $id;
	$scy->arr = $show_score_area;
	$scy->is_submit = true;
	$scy->other_script = $other_script;
	return $scy->get_select();
}

//add by david 20150520 for �ǰȺ޲z�t�έ��� / �ִ����� / �ִ�_�а� / �ִ�_���U�� / ���~�ͧ@�~_�ִ����� / ���~���Z
function my_cal_fin_score($sslk = array(),$student_sn=array(),$seme=array(),$succ="",$strs="",$precision=1)   //$succ:�ݦX����� $strs:���ĵ��_�N���r��
{

	//���X�Ǵ���]�w��  ���~���Z�p��覡  0:��ƥ���   1:�[�v����(�Ǥ������[�v)

	global $CONN;
	if (count($seme)==0) return;
	$SQL="select * from pro_module where pm_name='every_year_setup' AND pm_item='FIN_SCORE_RATE_MODE'";
        $RES=$CONN->Execute($SQL);
        $FIN_SCORE_RATE_MODE=INTVAL($RES->fields['pm_value']);

	//$sslk=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","���d�P��|"=>"health","�ͬ�"=>"life","���|"=>"social","���N�P�H��"=>"art","�۵M�P�ͬ����"=>"nature","�ƾ�"=>"math","��X����"=>"complex");
	//$sslk=array("�y��-����y��"=>"chinese","�y��-�m�g�y��"=>"local","�y��-�^�y"=>"english","�ƾ�"=>"math","�ͬ�"=>"life","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex","��¦�D�b"=>"basic","�ͩR�D�b"=>"live","�ͬ��D�b"=>"mylife");
	if (count($student_sn)>0 && count($seme)>0) {
		$all_sn="'".implode("','",$student_sn)."'";
		$all_seme="'".implode("','",$seme)."'";
		//���o��ئ��Z
		$query="select a.*,b.link_ss,b.rate from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1'";
		// �Y���ƿ�..�h�ץ���Ʈw�y�k,�[�J�w��SS_ID���~�ŧ@�ˬd,�O�_�P�ǥͩҦb�~�Ŭ۲�
/*		$sch=get_school_base();
		if($sch[sch_sheng]=='���ƿ�'){
			$query="select a.*,b.link_ss,b.rate,b.class_year ,b.year as chc_year,b.semester as chc_semester,c.seme_class as chc_seme_class from stud_seme_score a left join score_ss b on a.ss_id=b.ss_id left join stud_seme as c on (a.seme_year_seme=c.seme_year_seme and a.student_sn =c.student_sn) where a.student_sn in ($all_sn) and a.seme_year_seme in ($all_seme) and b.enable='1' and b.need_exam='1' and (b.class_year=left(c.seme_class,1))";
		}
*/		
		$res=$CONN->Execute($query);
		//���o�U�Ǵ����Ǭ즨�Z.�[�v�ƨå[�`
		while(!$res->EOF) {
			//���o���[�v�`��
			$subj_score[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[ss_score]*$res->fields[rate];
			//����`�[�v��
			$rate[$res->fields[student_sn]][$res->fields[link_ss]][$res->fields[seme_year_seme]]+=$res->fields[rate];
			$res->MoveNext();
		}

		//�B�z�U�Ǵ���쥭��
		$IS5=false;
		$IS7=false;
		while(list($sn,$v)=each($subj_score)) {
			$sys=array();
			reset($v);
			while(list($link_ss,$vv)=each($v)) {
				reset($vv);
				$ls=$sslk[$link_ss];
				if($ls){  //�Ǵ����Z�p��ư��E�~�@�e������"�D�w�]�����"�P"�u�ʽҵ{"(�D���j�ΤC�j���) �����Z 
					if($ls=="life") $IS5=true;
					if($ls=="art") $IS7=true;
					//�p��U���Ǵ����Z
					while(list($seme_year_seme,$s)=each($vv)) {
						$fin_score[$sn][$ls][$seme_year_seme][score]=number_format($s/$rate[$sn][$link_ss][$seme_year_seme],$precision);
						$fin_score[$sn][$ls][$seme_year_seme][rate]=$rate[$sn][$link_ss][$seme_year_seme];

						//$FIN_SCORE_RATE_MODE=1���[�v����  0����ƥ���   ���]���~�`�����[�v�ƨӦۭ�l��إ[�v��   ���`�N�U�Ǵ��[�v�O�_�X�z  ��p  �e�@�Ǵ��H100 200  500 �]�w   �����@�Ǵ��H�`�� 2  3 6  �]�w  �p���|�y����@�Ǵ����ӻ�즨�Z�񭫥��Ű��D
						if($FIN_SCORE_RATE_MODE=='1') {
							//��첦�~�`���Z
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
							//��첦�~�`����
							$fin_score[$sn][$ls][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
						} else {
							$fin_score[$sn][$ls][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
							$fin_score[$sn][$ls][total][rate]+=1;
						}

						//��Ǵ��Ǵ��`�����B�z
						if ($ls=="chinese" || $ls=="local" || $ls=="english") {
							//�y����S�O�B�z����
							if ($sys[$seme_year_seme]!=1) $sys[$seme_year_seme]=1;
							$fin_score[$sn][language][$seme_year_seme][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$fin_score[$sn][$ls][$seme_year_seme][rate];
							$fin_score[$sn][language][$seme_year_seme][rate]+=$fin_score[$sn][$ls][$seme_year_seme][rate];
						} else {

							if($FIN_SCORE_RATE_MODE=='1') {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score]*$rate[$sn][$link_ss][$seme_year_seme];
								$fin_score[$sn][$seme_year_seme][total][rate]+=$rate[$sn][$link_ss][$seme_year_seme];
							} else {
								$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][$ls][$seme_year_seme][score];
								$fin_score[$sn][$seme_year_seme][total][rate]+=1;
							}
						}
					}
				}
				$fin_score[$sn][$ls][avg][score]=number_format($fin_score[$sn][$ls][total][score]/$fin_score[$sn][$ls][total][rate],$precision);

				//�� ����y��  �m�g�y��  �^�y  �M �u�ʽҵ{ �~   �N��L��쥭�����Z�[�J"���~"�`���Z
				if ($ls!="chinese" && $ls!="local" && $ls!="english" && $ls!="") {
					if($FIN_SCORE_RATE_MODE=='1') {
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][total][score];
						$fin_score[$sn][total][rate]+=$fin_score[$sn][$ls][total][rate];
					} else {
            //echo $sn."-".$ls."-".$fin_score[$sn][total][score]." - ".$fin_score[$sn][$ls][avg][score]."-".$fin_score[$sn][total][rate]."<BR>";
						$fin_score[$sn][total][score]+=$fin_score[$sn][$ls][avg][score];
						$fin_score[$sn][total][rate]+=1;
					}
					//�P�_�ή����
					if ($fin_score[$sn][$ls][avg][score] >= 60) $fin_score[$sn][succ]++;
				}
			}


			//�ͬ���즨�Z�S�O�B�z
			if($IS5 && $IS7) {
				$fin_score[$sn][art][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][score]+=$fin_score[$sn][life][avg][score]*$fin_score[$sn][life][total][rate]/3;

				$fin_score[$sn][art][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][nature][total][rate]+=$fin_score[$sn][life][total][rate]/3;
				$fin_score[$sn][social][total][rate]+=$fin_score[$sn][life][total][rate]/3;

				$fin_score[$sn][art][avg][score]=number_format($fin_score[$sn][art][total][score]/$fin_score[$sn][art][total][rate],$precision);
				$fin_score[$sn][nature][avg][score]=number_format($fin_score[$sn][nature][total][score]/$fin_score[$sn][nature][total][rate],$precision);
				$fin_score[$sn][social][avg][score]=number_format($fin_score[$sn][social][total][score]/$fin_score[$sn][social][total][rate],$precision);
			}


			//�y���즨�Z�S�O�W�߭p��
			if (count($sys)>0) {
				$r=0;
				while(list($seme_year_seme,$s)=each($sys)) {
					$fin_score[$sn][language][$seme_year_seme][score]=number_format($fin_score[$sn][language][$seme_year_seme][score]/$fin_score[$sn][language][$seme_year_seme][rate],$precision);


					if($FIN_SCORE_RATE_MODE=='1')	{
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$fin_score[$sn][language][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];


						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score]*$fin_score[$sn][language][$seme_year_seme][rate];
						$r+=$fin_score[$sn][language][$seme_year_seme][rate];
		//echo $sn."---".$r."---".$fin_score[$sn][language][$seme_year_seme][rate]."---".$fin_score[$sn][language][avg][score]."<BR>";
						$fin_score[$sn][$seme_year_seme][total][rate]+=$fin_score[$sn][language][$seme_year_seme][rate];
					} else {
						$fin_score[$sn][language][avg][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$fin_score[$sn][$seme_year_seme][total][score]+=$fin_score[$sn][language][$seme_year_seme][score];
						$r+=1;
						$fin_score[$sn][$seme_year_seme][total][rate]+=1;
					}
					$fin_score[$sn][$seme_year_seme][avg][score]=number_format($fin_score[$sn][$seme_year_seme][total][score]/$fin_score[$sn][$seme_year_seme][total][rate],$precision);
				}

				$fin_score[$sn][language][avg][score]=number_format($fin_score[$sn][language][avg][score]/$r,$precision);
				if($FIN_SCORE_RATE_MODE=='1')	{
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score]*$r;
					$fin_score[$sn][total][rate]+=$r;
				} else {
					$fin_score[$sn][total][score]+=$fin_score[$sn][language][avg][score];
					$fin_score[$sn][total][rate]+=1;
				}
/*
				$fin_score[$sn][avg][score]=number_format($fin_score[$sn][total][score]/$fin_score[$sn][total][rate],$precision);
				//�ƻs��ƦW�}�C
				$rank_score[$sn]=$fin_score[$sn]['total']['score'];
*/

				if ($fin_score[$sn][language][avg][score] >= 60) $fin_score[$sn][succ]++;
			}

			$fin_score[$sn][avg][score]=number_format($fin_score[$sn][total][score]/$fin_score[$sn][total][rate],$precision);
			//�ƻs��ƦW�}�C
			$rank_score[$sn]=$fin_score[$sn]['total']['score'];

			if ($succ) {
				if ($fin_score[$sn][succ] < $succ) $show_score[$sn]=$fin_score[$sn];
			}

/*      
      //�w��̫ᵲ�G���Ƨ�
			arsort($rank_score);
			//�p��W��
			$rank=0;
			foreach($rank_score as $key=>$value) {
				$rank+=1;
				$fin_score[$key]['total']['rank']=$rank;
			}
*/
		}
		
    //�w��̫ᵲ�G���Ƨ�
		arsort($rank_score);
		//�p��W��
		$rank=0;
		foreach($rank_score as $key=>$value) {
			$rank+=1;
			$fin_score[$key]['total']['rank']=$rank;
		}
		

		if ($succ)
			return $show_score;
		else
			return $fin_score;
	} elseif (count($student_sn)==0) {
		return "�S���ǤJ�ǥͬy����";
	} else {
		return "�S���ǤJ�Ǵ�";
	}
}
?>