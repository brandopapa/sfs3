<?php
// $Id: real_input.php 7545 2013-09-19 03:31:46Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
$class_year_b=$_REQUEST['class_year_b'];

//�ϥΪ̻{��
sfs_check();

//�{�����Y
head("�s�ͽs�Z");

print_menu($menu_p);
//�]�w�D������ܰϪ��I���C��
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";
//�������e�иm�󦹳B

//�ˬd�O�_�w�g�s���Z�F
$new_sel_year=date("Y")-1911;
if ($_GET[act]=="import") {
	$sql_newstud="select * from new_stud where stud_study_year='$new_sel_year' and sure_study<>'0' and class_year='$class_year_b'";
	$rs_newstud=$CONN->Execute($sql_newstud) or die($sql_newstud);
	echo $sql_newstud;
	while(!$rs_newstud->EOF){
		$stud_id=$rs_newstud->fields['stud_id'];
		$addr_zip=$rs_newstud->fields['addr_zip'];
		$stud_mschool_name=addslashes($rs_newstud->fields['old_school']);
		$sql_base="update stud_base set addr_zip='$addr_zip',stud_mschool_name='$stud_mschool_name' where stud_study_year='$new_sel_year' and stud_id='$stud_id'";
		$CONN->Execute($sql_base) or trigger_error($sql_base, E_USER_ERROR);
		$rs_newstud->MoveNext();
	}
	echo "��ƸɤJ����";
}elseif($class_year_b==""){
$menu="
    <form name='form' method='post' action='{$_SERVER['PHP_SELF']}'>
		�п�ܭn�g�J���y��ƪ��~�šG<br>
        <select name='class_year_b'>
            <option value='0' $selecteda>���X��</option>\n
            <option value='1' $selectedb>�p�@</option>\n
            <option value='2' $selectedc>�p�G</option>\n
            <option value='3' $selectedd>�p�T</option>\n
            <option value='4' $selectede>�p�|</option>\n
            <option value='5' $selectedf>�p��</option>\n
            <option value='6' $selectedg>�p��</option>\n
            <option value='7' $selectedh>��@</option>\n
            <option value='8' $selectedi>��G</option>\n
            <option value='9' $selectedj>��T</option>\n
            <option value='10' $selectedk>���@</option>\n
            <option value='11' $selectedl>���G</option>\n
            <option value='12' $selectedm>���T</option>\n
        </select>
        <input type='submit' name='submit' value='�T�w'>
    </form>";
echo $menu;

}
else{
    $sql="select * from new_stud where stud_study_year='$new_sel_year' and sure_study<>'0' and class_year='$class_year_b'";
    $rs=$CONN->Execute($sql) or die($sql);
    $i=0;
    $j=0;
    while(!$rs->EOF){
        $newstud_sn=$rs->fields['newstud_sn'];
        $stud_id[$i]=$rs->fields['stud_id'];
        $stud_name[$i]=$rs->fields['stud_name'];
        $class_year[$i]=$rs->fields['class_year'];
        $class_sort[$i]=$rs->fields['class_sort'];
        $class_site[$i]=$rs->fields['class_site'];
        if($stud_id[$i] && $class_year[$i] && $class_sort[$i] && $class_site[$i]) $j++;
        else echo $class_year[$i]."�~��".$stud_name[$i]."���s�Z�I<br> $j";
        $i++;
        $rs->MoveNext();
    }
    if($j<$i) echo "�z�|���H�W�ǥͥ������s�Z�A�Х��i��s�Z�ʧ@�I";
    else{
    	
        //�ˬd�Ǯժ��¥ͬO�_�w�g�ɯŤF
        $sql_oldstud="select curr_class_num from stud_base where stud_study_cond='0'";
        $rs_oldstud=$CONN->Execute($sql_oldstud);
        $m=0;
        while(!$rs_oldstud->EOF){
            $student_sn[$m]=$rs_oldstud->fields['student_sn'];
            $curr_class_num[$m]=$rs_oldstud->fields['curr_class_num'];
            $curr_class_year[$m]=substr($curr_class_num[$m],0,-4);
            
            if($curr_class_year[$m]==$class_year_b){
                echo "�t�Τ��w��".$class_year_b."�~�Ū���ơA�z�i��w���פJ���Ǧ~�ת��s�͸�ƤF�A�Ϊ̱z�|�������ɯŪ��ʧ@�A�Y�O���@���ΡA�h�Х��i���¥ͪ��ɯ�!<br><a href='{$_SERVER['PHP_SELF']}?act=import&class_year_b=$class_year_b'>�ɤJ�u��J�ǰ�p�v�Ρu�l���ϸ��v</a>";
                exit;
            }
            
            $m++;
            $rs_oldstud->MoveNext();
        }
       
        if($_GET['write']=="1"){
            //echo $class_year_b;
            $sql_newstud="select * from new_stud where stud_study_year='$new_sel_year' and sure_study<>'0' and class_year='$class_year_b'";
            $rs_newstud=$CONN->Execute($sql_newstud) or die($sql_newstud);
            $i=0; 
            
            while(!$rs_newstud->EOF){
            	 
                $newstud_sn=$rs_newstud->fields['newstud_sn'];
                $stud_id[$i]=$rs_newstud->fields['stud_id'];
                $stud_name[$i]=addslashes($rs_newstud->fields['stud_name']);
                $stud_study_year[$i]=$rs_newstud->fields['stud_study_year'];
                $class_year[$i]=$rs_newstud->fields['class_year'];
                $class_sort[$i]=$rs_newstud->fields['class_sort'];
                $class_site[$i]=$rs_newstud->fields['class_site'];
                $curr_class_num[$i]=sprintf("%d%02d%02d",$class_year[$i],$class_sort[$i],$class_site[$i]);
                $seme_year_seme[$i]=sprintf("%03d%d",$stud_study_year[$i],1);
                $seme_class[$i]=sprintf("%d%02d",$class_year[$i],$class_sort[$i]);
                $seme_num[$i]=$class_site[$i];
                $rs_cname=$CONN->Execute("select c_name from school_class where year='$stud_study_year[$i]' and semester='1' and c_year='$class_year[$i]' and c_sort='$class_sort[$i]' and enable=1");
                //echo "select c_name from school_class where year='$stud_study_year[$i]' and semester='1' and c_year='class_year[$i]' and c_sort='class_sort[$i]' and enable=1";
                $seme_class_name[$i]=$rs_cname->fields['c_name'];
                if($seme_class_name[$i]==""){
                    trigger_error("$stud_study_year[$i]�Ǧ~��1�Ǵ����Z�ũ|���]�w",E_USER_ERROR);
                    exit;
                }                
                $stud_person_id[$i]=$rs_newstud->fields['stud_person_id'];
                $stud_sex[$i]=$rs_newstud->fields['stud_sex'];
                $stud_tel_1[$i]=$rs_newstud->fields['stud_tel_1'];
                $stud_birthday[$i]=$rs_newstud->fields['stud_birthday'];
                $guardian_name[$i]=addslashes($rs_newstud->fields['guardian_name']);
                $addr_1[$i]=addslashes($rs_newstud->fields['stud_address']);
                $addr_arr = change_addr($addr[$i]);
								$addr_zip[$i]=$rs_newstud->fields['addr_zip'];
								$stud_mschool_name[$i]=addslashes($rs_newstud->fields['old_school']);

                $addr_2[$i]=addslashes($rs_newstud->fields['stud_addr_2']); 					//�p���a�} 2012.05.03�W�[
                $stud_tel_3[$i]=$rs_newstud->fields['stud_tel_3']; 										//������X 2012.05.03�W�[
                $stud_name_eng[$i]=addslashes($rs_newstud->fields['stud_name_eng']); 	//�^��m�W 2012.05.03�W�[
                $addr_move_in[$i]=addslashes($rs_newstud->fields['addr_move_in']);    //���y�E�J��� 2012.05.03�W�[
                $edu_key[$i] = hash('sha256', strtoupper($rs_newstud->fields['stud_person_id']));
                //�s�W����y��ƪ�
                $sql_base="insert into stud_base(stud_id,stud_name,stud_name_eng,stud_person_id,stud_birthday,stud_sex,
                stud_study_cond,curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,
                stud_addr_e,stud_addr_f,stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,
                stud_addr_m,stud_addr_1,stud_addr_2,stud_tel_1,stud_tel_2,stud_tel_3,stud_kind,stud_mschool_name,
                addr_zip,addr_move_in, edu_key) values ('$stud_id[$i]','{$stud_name[$i]}','$stud_name_eng[$i] ','$stud_person_id[$i]',
                '$stud_birthday[$i]','$stud_sex[$i]','0','$curr_class_num[$i]','$stud_study_year[$i]','$addr_arr[0]','$addr_arr[1]',
                '$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]','$addr_arr[8]','$addr_arr[9]',
                '$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','$addr_1[$i]','$addr_2[$i]','$stud_tel_1[$i]','$stud_tel_2[$i]',
                '$stud_tel_3[$i]','$stud_kind[$i]','$stud_mschool_name[$i]','$addr_zip[$i]','$addr_move_in[$i]','$edu_key[$i]')";
                $CONN->Execute($sql_base) or trigger_error($sql_base, E_USER_ERROR);
                
								$tmp_auto_inc_id=mysql_insert_id();

								//�[�J�a�x���p���
								$sql_domicile="insert into stud_domicile (stud_id,fath_name,moth_name,guardian_name,student_sn) values('$stud_id[$i]','$fath_name','$moth_name','$guardian_name[$i]','$tmp_auto_inc_id')";
								$CONN->Execute($sql_domicile) or trigger_error($sql_domicile, E_USER_ERROR);
								//�[�J�Ǧ~�Ǵ����
								$sql_seme="insert into stud_seme (seme_year_seme,stud_id,seme_class,seme_num,seme_class_name,student_sn)  values ('$seme_year_seme[$i]','$stud_id[$i]','$seme_class[$i]','$seme_num[$i]','$seme_class_name[$i]','$tmp_auto_inc_id')";
								$CONN->Execute($sql_seme) or trigger_error($sql_seme, E_USER_ERROR);
                $i++;
                $rs_newstud->MoveNext();
            }
            echo "�g�J�F ".$i." ���s�͸�ơI";
        }
        else{
            echo "���U���y�g�J�������y��ƪ�z�A�|�N�s�ͪ���Ƽg�J���������y��ƪ�I<br>";
            echo "<a href='{$_SERVER['PHP_SELF']}?write=1&class_year_b=$class_year_b'><span class='button'>�g�J�������y��ƪ�</span></a>";
        }
    }

}


//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();


function change_addr($addr) {
	//����
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

      	//�m��
	$temp_str = split_str($addr,"�m",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);
	
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//����
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//�F
	$temp_str = split_str($addr,"�F");
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��",1);
	if ($temp_str[0] =="")
		$temp_str = split_str($addr,"��",1);

	$res[] = $temp_str[0];
	$addr=$temp_str[1];

      	//�q
	$temp_str = split_str($addr,"�q");
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

      	//��
	$temp_str = split_str($addr,"��");
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��");
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��");
	$temp_arr = explode("-",$temp_str);
	if (sizeof($temp_arr)>1){
		$res[]=$temp_arr[0];
		$res[]=$temp_arr[1];
	}else {
		$res[]=$temp_str[0];
		$res[]="";
	}
	$addr=$temp_str[1];

	//��
	$temp_str = split_str($addr,"��");
	$res[]=$temp_str[0] ;
	$addr=$temp_str[1];

	//�Ӥ�
	if ($addr != "")
		$temp_str = substr(chop($addr),2);
	else
		$temp_str ="";

	$res[]=$temp_str ;
      	return $res;
}

function split_str($addr,$str,$last=0) {
      	$temp = explode ($str, $addr);
	if (count($temp)<2 ){
		$t[0]="";
		$t[1]=$addr;
	}else{
		$t[0]=(!empty($last))?$temp[0].$str:$temp[0];
		$t[1]=$temp[1];
	}
	return $t;
}
?>