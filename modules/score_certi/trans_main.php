<?php

// $Id: trans_main.php 8693 2015-12-25 03:53:51Z qfon $

        //�s�W�@�� zipfile ���
        $ttt = new EasyZIP;

        // �]�w�ɮץؿ�
        $ttt->setPath($oo_path);

        // �[�J��ӥؿ�
        $ttt->addDir("META-INF");

        // �[�J�ɮ�
        $ttt -> addFile("styles.xml");
        //$ttt -> addFile("content.xml");
        $ttt -> addFile("meta.xml");
        $ttt -> addFile("settings.xml");

        // �[�J���e
        $data = & $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
	
	$sql="select * from school_base";
	$rs=$CONN->Execute($sql);
	$temp_arr["school_name"] = $rs->fields['sch_cname'];
	$temp_arr["school_ename"] = ucwords($rs->fields['sch_ename']);
	$student_sn=intval($student_sn);
	$sql="select stud_id,stud_name,stud_name_eng,stud_birthday,stud_study_year,stud_study_cond from stud_base where student_sn='$student_sn'";
	$rs=$CONN->Execute($sql);
	$stud_id=$rs->fields['stud_id'];
	$s1=$rs->fields['stud_study_year'];
	$temp_arr["student_name"] = $rs->fields['stud_name'];
	$temp_arr["student_ename"] = $rs->fields['stud_name_eng'];
	$temp_arr["stud_id"] = $stud_id;
	$d=explode("-",$rs->fields['stud_birthday']);
	$temp_arr["by"]=intval($d[0])-1911;
	$temp_arr["bm"]=$d[1];
	$temp_arr["bd"]=$d[2];
	$temp_arr["ebdate"]=$d[0].".".$d[1].".".$d[2];
	$temp_arr["iy"]=$stud_study_year;
	$temp_arr["im"]="08";
	$temp_arr["id"]="01";
	$temp_arr["eedate"]=(intval($stud_study_year)+1911).".08.01";
	if ($rs->fields[stud_study_cond]=="5") {
		$query="select grad_date from grad_stud where stud_id='$stud_id' and (stud_grad_year-$stud_study_year between 1 and 9) ";
		$res=$CONN->Execute($query);
		$gd=explode("-",$res->fields[grad_date]);
		$temp_arr["gy"]=$gd[0]-1911;
		$temp_arr["gm"]=$gd[1];
		$temp_arr["gd"]=$gd[2];
		$temp_arr["egdate"]=$gd[0].".".$gd[1].".".$gd[2];
	} else {
		$temp_arr["gy"]="�@";
		$temp_arr["gm"]="�@";
		$temp_arr["gd"]="�@";
		$temp_arr["egdate"]="";
	}
	$temp_arr["ty"]=num2str(intval($today[0])-1911);
	$temp_arr["tm"]=num2str($today[1]);
	$temp_arr["td"]=num2str($today[2]);
	$temp_arr["etdate"]=$today[0].".".$today[1].".".$today[2];
	$temp_arr["c_num"] = $c_num;
	$temp_arr["s2"]=$s1+1;
	$temp_arr["s3"]=$s1+2;
	$sql="select subject_id,subject_name from score_subject where enable='1'";
	$rs=$CONN->Execute($sql);
	while (!$rs->EOF) {
		$subject_id=addslashes($rs->fields['subject_id']);
		$subject_arr[$subject_id]=($subject_arr[$subject_id]=="")?$rs->fields['subject_name']:$subject_arr[$subject_id];
		$rs->MoveNext();
	}
	$std_ss=array("1"=>"�y��-����y��","2"=>"�y��-�^�y","3"=>"�ƾ�","4"=>"�۵M�P�ͬ����","5"=>"���|","6"=>"���N�P�H��","7"=>"���d�P��|","8"=>"��X����");
	$nor_arr=array("���ݧ�i"=>'1',"�ݦA�[�o"=>'2',"��{�|�i"=>'3',"��{�}�n"=>'4',"��{�u��"=>'5');
	$arr_nor=array('1'=>"���ݧ�i",'2'=>"�ݦA�[�o",'3'=>"��{�|�i",'4'=>"��{�}�n",'5'=>"��{�u��");
	for ($i=1;$i<=3;$i++) {
		$year=$s1+$i-1;
		$year_name=$i+6;
		$temp_arr["s".$i]=$year;
		for ($j=1;$j<=2;$j++) {
			$year_seme=sprintf("%03d%1d",$year,$j);
			$sql="select seme_class from stud_seme where seme_year_seme='$year_seme' and stud_id='$stud_id'";
			$rs=$CONN->Execute($sql);
			$seme_class=$rs->fields['seme_class'];
			$class=($seme_class=="")?"":substr($seme_class,1,2);
			$class_id=sprintf("%03d_%1d_%02d_%02d",$year,$j,$year_name,$class);
			$ss_num_arr = get_ss_num_arr($class_id);
			$sql="select * from stud_seme_score where seme_year_seme='$year_seme' and student_sn='$student_sn'";
			$rs=$CONN->Execute($sql);
			$max_ss=8;
			$score="";
			$memo="";
			$ssval="";
			$std_ss[9]="";
			$std_ss[10]="";
			$std_ss[11]="";
			while (!$rs->EOF) {
				$ss_id=$rs->fields['ss_id'];
				$ssscore=$rs->fields['ss_score'];
				if ($ssscore) $score[$ss_id]=$ssscore;
				$ssmemo=addslashes($rs->fields['ss_score_memo']);
				if ($ssmemo!="") $memo[$ss_id]=$ssmemo;
				$rs->MoveNext();
			}
			$sql="select ss_id,ss_val from stud_seme_score_oth where seme_year_seme='$year_seme' and stud_id='$stud_id' and ss_kind='�V�O�{��'";
			$rs=$CONN->Execute($sql);
			$ss_id=$rs->fields['ss_id'];
			if ($ss_id!="") {
				while (!$rs->EOF) {
					$ss_id=$rs->fields['ss_id'];
					$ss_val=addslashes($rs->fields['ss_val']);
					if ($ss_val != "") $ssval[$ss_id]=$ss_val;
					$rs->MoveNext();
				}
			}
			$sql="select ss_id,scope_id,subject_id,rate,link_ss from score_ss where class_id='$class_id' and enable='1' and need_exam='1' order by sort,sub_sort";
                        $rs=$CONN->Execute($sql);
                        if ($rs->RecordCount()==0){
                                $sql="select ss_id,scope_id,subject_id,rate,link_ss from score_ss where class_id='' and year='$year' and semester='$j' and class_year='$year_name' and enable='1' and need_exam='1' order by sort,sub_sort";
                                $rs=$CONN->Execute($sql);
                        }

			$wtime="";
			$ss_arr="";
			$rate="";
			$ss_score="";
			$tss_score="";
			$mmemo="";
			$sval="";
			$v= array();
			while (!$rs->EOF) {
				$scope_id=$rs->fields['scope_id'];
				$subject_id=$rs->fields['subject_id'];
				$ss_id=$rs->fields['ss_id'];
				$rrate=intval($rs->fields['rate']);
				$link_ss=$rs->fields['link_ss'];
				//�u�ʽҵ{
				if ($link_ss=='�u�ʽҵ{') {
					$max_ss++;
					if ($subject_id==0) $subject_id=$scope_id;
					$std_ss[$max_ss]=$subject_arr[$subject_id];
					$scope_id=$subject_id;
					$wtime[$subject_arr[$scope_id]]=intval($ss_num_arr[$ss_id]);
					if ($score[$ss_id]!="") {
						$ss_score[$subject_arr[$scope_id]]=$score[$ss_id]*$rrate;
						$tss_score[$subject_arr[$scope_id]]=$score[$ss_id];
						$rate[$subject_arr[$scope_id]]=$rrate;
					}
					$mmemo[$subject_arr[$scope_id]]=$memo[$ss_id];
					$sval[$subject_arr[$scope_id]]=$ssval[$ss_id];
				} else {
					//�D�u�ʽҵ{
					$wtime[$link_ss]+=intval($ss_num_arr[$ss_id]);
					if ($score[$ss_id]!="") {
						$ss_score[$link_ss]+=$score[$ss_id]*$rrate;
						$rate[$link_ss]+=$rrate;
					}
					$dd=$mmemo[$link_ss];
					$d=(($dd != "") && (substr($dd,-2,2) != "�C"))?"�C":"";
					$mmemo[$link_ss].=$d.$memo[$ss_id];
					if ($ssval[$ss_id]) {
						$vv=$v[$link_ss];
						$sval[$link_ss]=$arr_nor[round(($nor_arr[$sval[$link_ss]]*$vv+$nor_arr[$ssval[$ss_id]])/($vv+1))];
						$v[$link_ss]+=1;
					}
				}
				$rs->MoveNext();
			}
			$sum_c=0;
			$sum_s=0;
			$sql="select rule from score_setup where year='$year' and semester='$j' and class_year='$year_name' and enable='1'";
			$rs=$CONN->Execute($sql);
			$rule=$rs->fields['rule'];
			for ($k=1;$k<=11;$k++) {
				$ss=$std_ss[$k];
				if ($wtime[$ss]) {
					$temp_arr["c".$k."_".$i.$j]=$wtime[$ss];
					if($rate[$ss]!=0)
						$sum_c+=$wtime[$ss];
				} else
					$temp_arr["c".$k."_".$i.$j]="---";
				if ($ss_score[$ss])	{
					$ssscore=number_format($ss_score[$ss]/$rate[$ss],2);
					$temp_arr["s".$k."_".$i.$j]=$ssscore;
					$temp_arr["f".$k."_".$i.$j]=sc2str($ssscore,$rule);
					$temp_arr["e".$k."_".$i.$j]=sc2grade($ssscore);
					$sum_s+=$ssscore*$wtime[$ss];
				} else {
					$temp_arr["s".$k."_".$i.$j]="---";
					$temp_arr["f".$k."_".$i.$j]="---";
					$temp_arr["e".$k."_".$i.$j]="---";
				}
				if ($mmemo[$ss])	
					$temp_arr["m".$k."_".$i.$j]=$mmemo[$ss];
				else
					$temp_arr["m".$k."_".$i.$j]="---";
				if ($sval[$ss])
					$temp_arr["v".$k."_".$i.$j]=$sval[$ss];
				else
					$temp_arr["v".$k."_".$i.$j]="---";
			}
			if ($sum_c)
				$temp_arr["cavg_".$i.$j]=$sum_c;
			else
				$temp_arr["cavg_".$i.$j]="---";
			if ($sum_s) {
				$ssscore=number_format($sum_s/$sum_c,2);
				$temp_arr["savg_".$i.$j]=$ssscore;
				$temp_arr["favg_".$i.$j]=sc2str($ssscore,$rule);
			} else {
				$temp_arr["savg_".$i.$j]="---";
				$temp_arr["favg_".$i.$j]="---";
			}
			for ($k=9;$k<=11;$k++) {
				//��ܼu�ʽҵ{���
				if ($std_ss[$k]){
					$ss=$std_ss[$k];
					$temp_arr["b".$k."_".$i.$j]=$std_ss[$k];
					$temp_arr["s".$k."_".$i.$j]=$tss_score[$ss];
					$temp_arr["m".$k."_".$i.$j]=$mmemo[$ss];
					$temp_arr["f".$k."_".$i.$j]=sc2str($tss_score[$ss],$rule);
					$temp_arr["e".$k."_".$i.$j]=sc2grade($tss_score[$ss]);
				}
				else
					$temp_arr["b".$k."_".$i.$j]="---";
			}
			//�B�z��`��{���Z�Τ�r�y�z
			$student_sn=intval($student_sn);
			$sql="select ss_score,ss_score_memo from stud_seme_score_nor where seme_year_seme='$year_seme' and student_sn='$student_sn'";
			$rs=$CONN->Execute($sql);
			$ss_score=$rs->fields['ss_score'];
			if ($ss_score && $nor_score) {
				$temp_arr["s12_".$i.$j]=$ss_score;
				$temp_arr["f12_".$i.$j]=sc2str($ss_score,$rule);
				$temp_arr["e12_".$i.$j]=sc2grade($ss_score);
			} else {
				$temp_arr["s12_".$i.$j]="---";
				$temp_arr["f12_".$i.$j]="---";
				$temp_arr["e12_".$i.$j]="---";
			}
			$memo=addslashes($rs->fields['ss_score_memo']);
			if ($memo=="")
				$temp_arr["m12_".$i.$j]="---";
			else
				$temp_arr["m12_".$i.$j]=$memo;
			$sql="select ss_id,ss_val from stud_seme_score_oth where seme_year_seme='$year_seme' and stud_id='$stud_id' and ss_kind='�ͬ���{���q' order by ss_id";
			$rs=$CONN->Execute($sql);
			$k=1;
			$norval="";
			while (!$rs->EOF) {
				$ss_id=$rs->fields['ss_id'];
				$ss_val=$rs->fields['ss_val'];
				if (($ss_id==$k) && ($ss_val)){
					$norval.=(6-$nor_arr[$ss_val]).",";
					$k++;
					$rs->MoveNext();
				} elseif ($ss_id<$k) {
					$rs->MoveNext();
				} else {
					$norval.="--,";
					$k++;
				}
			}
			if ($norval)
				$norval=substr($norval,0,strlen($norval)-1);
			else
				$norval="---";
			$temp_arr["v12_".$i.$j]=($nor_score)?$norval:"---";
		}
	}

	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	$fl="chart_".$stud_id."_".$oo_path;
	header("Content-disposition: attachment; filename=$fl.sxw");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
	//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק�A���� no-cache
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	
	exit;	

function num2str($num) {
    $ar = array("�s", "��", "�L", "��", "�v", "��", "��", "�m", "��", "�h") ;
    $cName = array("", "", "�B", "��", "�a", "�U", "�B", "��", "�a", "��", "�B", "��", "�a");
    $conver = "";
    $cLast = "" ;
    $cZero = 0;
    $i = 0;
    for ($j = strlen($num) ; $j >=1 ; $j--){  
      $cNum = intval(substr($num, $i, 1));
      $cunit = $cName[$j]; //���X���
      if ($cNum == 0) { //�P�_���X���Ʀr�O�_��0,�p�G�O0,�h�O���@���X0
         $cZero++;
         if (strpos($cunit,"�U��") >0 && ($cLast == "")){ // '�p�G���X���O�U,��,�h��ƥH�U���Ӹ�
          $cLast = $cunit ;
         }      
      }else {
        if ($cZero > 0) {// '�p�G���X���Ʀr0��n��,�h�H�s�N���Ҧ���0
          if (strpos("�U��", substr($conver, strlen($conver)-2)) >0) {
             $conver .= $cLast; //'�p�G�̫�@�줣�O��,�U,�h�̫�@��ɤW"���U"
          }
          $conver .=  "�s" ;
          $cZero = 0;
          $cLast = "" ;
        }
         $conver = $conver.$ar[$cNum].$cunit; // '�p�G���X���Ʀr�S��0,�h�O����Ʀr+���          
      }
      $i++;
    }  
  //'�P�_�Ʀr���̫�@��O�_��0,�p�G�̫�@�쬰0,�h��U���ɤW
     if (strpos("�U��", substr($conver, strlen($conver)-2)) >0) {
       $conver .=$cLast; // '�p�G�̫�@�줣�O��,�U,�h�̫�@��ɤW"���U"
    }
    return $conver;
}


function sc2str($score="",$rule=""){
	
	$r=explode("\n",$rule);
	while(list($k,$v)=each($r)){

		$str=explode("_",$v);
		$du_str = (double)$str[2];
		
		if($str[1]==">="){
			if($score >= $du_str)return $str[0];
		}elseif($str[1]==">"){
			if($score > $du_str)return $str[0];
		}elseif($str[1]=="="){
			if($score == $du_str)return $str[0];
		}elseif($str[1]=="<"){
			if($score < $du_str)return $str[0];
		}elseif($str[1]=="<="){
			if($score <= $du_str)return $str[0];
		}
	}
	$score_name="";
	return $score_name;
}

function sc2grade($score=""){
	
	$r=array("1"=>"A_>=_85","2"=>"B_>=_70","3"=>"C_>=_60","4"=>"F_<_60");
	while(list($k,$v)=each($r)){

		$str=explode("_",$v);
		$du_str = (double)$str[2];
		
		if($str[1]==">="){
			if($score >= $du_str)return $str[0];
		}elseif($str[1]==">"){
			if($score > $du_str)return $str[0];
		}elseif($str[1]=="="){
			if($score == $du_str)return $str[0];
		}elseif($str[1]=="<"){
			if($score < $du_str)return $str[0];
		}elseif($str[1]=="<="){
			if($score <= $du_str)return $str[0];
		}
	}
	$score_name="";
	return $score_name;
}
?>
