<?php

//$Id: myfun2.php 7337 2013-07-10 14:17:26Z hami $

//�s��
function save_semester_score($sel_year,$sel_seme) {
	global $CONN,$now;

	//�Ǵ���ƪ�W��
	$score_semester="score_semester_".$sel_year."_".$sel_seme;

	$temp_sn = substr($_POST[student_sn_hidden],0,-1);
	$temp_arr = explode(",",$temp_sn);
	if($_POST[test_sort] == 255)
		$test_kind='���Ǵ�';
	elseif($_POST[test_kind] == 's1')
		$test_kind='�w�����q';
	else
		$test_kind='���ɦ��Z';
	if ($_POST[test_sort] == 254){
		//�ˬd���L���Z
		$query = "select student_sn from $score_semester where ss_id='$_POST[ss_id]' and test_sort='$_POST[test_sort]' and test_kind='$test_kind' and student_sn in($temp_sn)";
		$temp_sn_arr = array();
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$temp_sn_arr[$res->fields[1]][]=$res->fields[0];
			$res->MoveNext();
		}
		for ($i=1;$i<=$_POST[performance_test_times];$i++) {
			reset($temp_arr);
			while(list($id,$val) = each($temp_arr)) {
				$class_id=student_sn_2_class_id($sel_year,$sel_seme,$val);
				$score = trim($_POST["s_$val"]);
				if($score=='') $score= -100;
//				if (in_array($val,$temp_sn_arr[$i]))
//					$query = "UPDATE $score_semester set score='$score',update_time='$now',teacher_sn='$_SESSION[session_tea_sn]' where class_id='$class_id' and ss_id='$_POST[ss_id]' and test_sort='$i' and test_kind='$test_kind' and student_sn='$val'";
//				else
					$query = "REPLACE INTO $score_semester(class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values('$class_id','$val','$_POST[ss_id]','$score','$test_kind','$test_kind','$i','$now','$_SESSION[session_tea_sn]')";
				$CONN->Execute($query) or die($query);
			}
		}
	}else{
		//�ˬd���L���Z
		$query = "select student_sn from $score_semester where ss_id='$_POST[ss_id]' and test_sort='$_POST[test_sort]' and test_kind='$test_kind' and student_sn in($temp_sn)";
		$temp_sn_arr = array();
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		while(!$res->EOF){
			$temp_sn_arr[]=$res->fields[0];
			$res->MoveNext();
		}
		while(list($id,$val) = each($temp_arr)) {
			$class_id=student_sn_2_class_id($sel_year,$sel_seme,$val);
			$score = trim($_POST["s_$val"]);
			if($score=='') $score= -100;
		//	if (in_array($val,$temp_sn_arr))
//				$query = "UPDATE $score_semester set score='$score',update_time='$now',teacher_sn='$_SESSION[session_tea_sn]' where class_id='$class_id' and ss_id='$_POST[ss_id]' and test_sort='$_POST[test_sort]' and test_kind='$test_kind' and student_sn='$val'";
		//	else
				$query = "REPLACE INTO $score_semester(class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values('$class_id','$val','$_POST[ss_id]','$score','$test_kind','$test_kind','$_POST[test_sort]','$now','$_SESSION[session_tea_sn]')";
			$CONN->Execute($query) or die($query);
		}
	}
}



//�ר�аȳB
function seme_score_input($sel_year,$sel_seme) {
	global $CONN,$now,$yorn;
	//�Ǵ���ƪ�W��
	$score_semester="score_semester_".$sel_year."_".$sel_seme;

	$temp_sn = substr($_POST[student_sn_hidden],0,-1);
	$temp_arr = explode(",",$temp_sn);
	// �N score_semester �� sendmit �]�� 0
	$test_str=($_POST[test_sort] != 254)?"and test_sort='$_POST[test_sort]'":"and test_kind='���ɦ��Z'";
	$query= "UPDATE $score_semester set sendmit='0' where student_sn in ($temp_sn) and ss_id='$_POST[ss_id]' $test_str";
	$CONN->Execute($query) or die($query);
	$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$query = "select student_sn from stud_seme_score where ss_id='$_POST[ss_id]' and seme_year_seme='$seme_year_seme' and student_sn in($temp_sn)";
	$temp_sn_seme_arr = "";
	$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	while(!$res->EOF){
		$temp_sn_seme_arr.="'".$res->fields[0]."',";
		$res->MoveNext();
	}

	if ($temp_sn_seme_arr<>""){
		$temp_sn_seme_arr=substr($temp_sn_seme_arr,0,-1);
		//���N��r�y�z���X
		$rs=$CONN->Execute("select student_sn,ss_score_memo from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn in ($temp_sn_seme_arr) and ss_id='$_POST[ss_id]'");
		while (!$rs->EOF) {
			$val_arr[$rs->fields['student_sn']]=addslashes($rs->fields['ss_score_memo']);
			$rs->MoveNext();
		}
	}

	//���q���Z ���ɦ��Z
	if ($_POST[test_sort]<255) {
		//�N�Z�Ŧr���ର�}�C
		if($_POST[class_id]) {
			$class_arr=class_id_2_old($_POST[class_id]);
			$class_year=$class_arr[3];
		}
		else {//���o�~��
			$class_year=ss_id_2_class_year($_POST[ss_id]);
		}

		$query = "select performance_test_times,score_mode,test_ratio from score_setup where  class_year=$class_year and year=$sel_year and semester='$sel_seme' and enable='1'";
		$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
		//���禸��
		$performance_test_times = $res->fields[performance_test_times];
		//���Z�t����Ҭ����]�w
		$score_mode = $res->fields[score_mode];
		//��v
		$test_ratios = $res->fields[test_ratio];
		 //��v����
	        if($score_mode=="all"){
        	        $test_ratio=explode("-",$test_ratios);
       		 }
		//�C���q���q���O���P��v
       		elseif($score_mode=="severally"){
			$temp_arr=explode(",",$test_ratios);
			while(list($id,$val) = each($temp_arr)){
				$test_ratio_temp=explode("-",$val);
				$test_ratio[$id][0]=$test_ratio_temp[0];
				$test_ratio[$id][1]=$test_ratio_temp[1];
			}
		}
	        else{
        	        $test_ratio[0]=60;
			$test_ratio[1]=40;
		}
	
		//�p�G�C�Ǵ��u�]�w�@���Ǵ����ɦ��Z�B�C���q���q��v�Ҥ��P��,��v�� 100 - �U���q���q��v
	        if ($yorn =='n' and $score_mode=="severally"){
        	        $temp_ratio=0;
			for($i=0;$i<$performance_test_times;$i++)
	        	                $temp_ratio += $test_ratio[$i][0];
                	$temp_ratio = (100-$temp_ratio);
			
	        }
                                                                                                                             

		//�p��Ǵ����Z
		//���Ǵ����O�@�س]�w
		if($score_mode=="all"){
			if($yorn =='y')
				$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id=$_POST[ss_id] and student_sn in ($temp_sn) and test_sort <= $performance_test_times and score <> '-100' group by student_sn,test_kind ";
			else
				$query = "select student_sn,test_kind,sum(score) as cc from $score_semester where ss_id=$_POST[ss_id] and student_sn in ($temp_sn) and test_sort <= $performance_test_times and score <> '-100' and (test_kind='�w�����q' or test_kind='���ɦ��Z') group by student_sn,test_kind";
//			echo $query."<BR>";
			$res = $CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
			$score_arr = array();
			$test_ratio_1  = $test_ratio[0]/100;
			$test_ratio_2  = $test_ratio[1]/100;
			
			while(!$res->EOF){
				$student_sn = $res->fields[student_sn];
				$test_kind = $res->fields[test_kind];
				$score = $res->fields[cc];
				if ($score=='') $score=0;
				if ($test_kind == "�w�����q")
					$cc = ($score/$performance_test_times)*$test_ratio_1;
				else {
					$cc = $score * $test_ratio_2 / $performance_test_times;
					
				}
//				echo "$student_sn --  $test_kind -- $test_ratio_1 --  $test_ratio_2 -- $cc <BR>";
				$score_arr[$student_sn] += $cc;
				$res->MoveNext();
			}
		}
		//�C�����q�����P�]�w
		else {
			if ($yorn=='y')
				$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$_POST[ss_id]' and student_sn in ($temp_sn) and test_sort<255 ";
			else
				$query = "select student_sn,test_kind,test_sort,score from $score_semester where ss_id='$_POST[ss_id]' and student_sn in ($temp_sn) and (test_kind='�w�����q' or test_kind='���ɦ��Z')";
			$res = $CONN->Execute($query) or die($query);
			$temp_score= array();
			while(!$res->EOF){
				$test_sort = $res->fields[test_sort];
				$student_sn = $res->fields[student_sn];
				$test_kind = $res->fields[test_kind];
				$score = $res->fields[score];
				if ($score=="-100") $score=0;
				$id = $test_sort-1;
				if ($test_kind=='�w�����q')
					$cc =  $score*$test_ratio[$id][0]/100;
                                else{
					$cc =  $score*$test_ratio[$id][1]/100;
                                }
						
				$score_arr[$student_sn] += $cc;
				$res->MoveNext();
			}
		}
//�N���Z��J�Ǵ����Z��
                while(list($id,$val) = each($score_arr)){
			$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$id','$_POST[ss_id]','$val','".addslashes($val_arr[$id])."','$_SESSION[session_tea_sn]')";
                        $CONN->Execute($query) or die($query);
                }
	}
	//���Ǵ��@�����Z
	else if ($_POST[test_sort] == 255) {
		//�N���Z��J�Ǵ����Z��
		reset($temp_arr); 
		while(list($id,$val) = each($temp_arr)){
			$score = trim($_POST["avg_hidden_$val"]);
			$query = "replace into stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score,ss_score_memo,teacher_sn)values('$seme_year_seme','$val','$_POST[ss_id]','$score','".addslashes($val_arr[$val])."','$_SESSION[session_tea_sn]')";
			$CONN->Execute($query) or die($query);
		}
		
	}

	
}

//���Z�ɶץX
function download_score($sel_year,$sel_seme) {
	global $CONN;
	//require_once "../../include2/sfs_case_studclass.php";

	//�Ǵ���ƪ�W��
	$score_semester="score_semester_".$sel_year."_".$sel_seme;
	$class_id = $_POST[class_id];
	$ss_id = $_POST[ss_id];
	$test_sort = $_POST[test_sort];
	if($test_sort==255){
		$test_kind_num="all";
		$test_kind = "���Ǵ�";
	}
	else if ($_POST[test_kind] == 's1'){
		$test_kind = "�w�����q";
		$test_kind_num ="1";
	}
	else{
		$test_kind = "���ɦ��Z";
		$test_kind_num ="2";
	}
	$filename="semescore_".$class_id."_".$ss_id."_".$_POST[test_sort]."_".$test_kind_num.".csv";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$class_id_name=explode("_",$class_id);
	
	//  ���X�Z�W
	$class_sql="select * from school_class where class_id='$class_id' and enable=1";
	$rs_class=$CONN->Execute($class_sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
	$c_year= $rs_class->fields['c_year'];
	$c_name= $rs_class->fields['c_name'];
	$school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
	$full_year_class_name=$school_kind_name[$c_year];
	$full_year_class_name.=$c_name."�Z";
	$class_year_name =  $full_year_class_name;
	
	//$class_year_name=class_id_to_full_class_name($class_id);
	$subject_name=ss_id_to_subject_name($ss_id);
	$dl_time=date("Y m d H:i:s");
	if($test_kind_num=="all")
		$file_info="#".intval($class_id_name[0])."�Ǧ~��".intval($class_id_name[1])."�Ǵ�".$class_year_name.$subject_name.$test_kind."���Z(".$dl_time.")\n";
	else
		$file_info="#".intval($class_id_name[0])."�Ǧ~��".intval($class_id_name[1])."�Ǵ�".$class_year_name.$subject_name."��".$test_sort."���q��".$test_kind."(".$dl_time.")\n";
	
	echo $file_info;
	echo "�ǥͬy����,�y��,�m�W,���Z\n";
	if ($test_sort == 254) $test_sort=1;
	$query = "select student_sn,score from $score_semester where class_id='$class_id' and test_sort='$test_sort' and test_kind='$test_kind' and ss_id='$ss_id' ";
	$res = $CONN->Execute($query) or trigger_error("SQL ���~ $query",E_USER_ERROR);
	while(!$res->EOF){
		$stud_temp_arr[$res->fields[student_sn]] = $res->fields[score];
		$res->MoveNext();
	}

	//���o�ǥͩm�W�y��
	$temp_sn = substr($_POST[student_sn_hidden],0,-1);
	$query = "select student_sn,stud_name,curr_class_num from stud_base where student_sn in ($temp_sn) order by curr_class_num";
	$res = $CONN->Execute($query)or trigger_error($query);
	while(!$res->EOF){
		$sit_num = intval(substr($res->fields[curr_class_num],-2));
		echo $res->fields[student_sn].",".$sit_num.",\"".$res->fields[stud_name]."\",".$stud_temp_arr[$res->fields[student_sn]]."\n";
		$res->MoveNext();
	}


	exit;
}

//�פJ�ɮ�
function import_score($sel_year,$sel_seme) {
	global $CONN,$menu_p;

	$main="
            <table bgcolor=#FDE442 border=0 cellpadding=2 cellspacing=1 align='center'>
            <tr><td colspan=2  height=50 align='center'><font size='+2'>���Z�ɮ׶פJ</font></td></tr>
            <form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
            <tr><td  nowrap valign='top' bgcolor='#E1ECFF' width=40%>
            <p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
            <input type=file name='scoredata'>
            <input type=hidden name='score_semester' value='$score_semester'>
            <input type=hidden name='class_id' value='$_POST[class_id]'>
            <input type=hidden name='test_sort' value='$_POST[test_sort]'>
            <input type=hidden name='test_kind' value='$_POST[test_kind]'>
            <input type=hidden name='ss_id' value='$_POST[ss_id]'>
            <input type=hidden name='teacher_course' value='$_POST[teacher_course]'>
	    <input type=hidden name='student_sn_hidden' value='$_POST[student_sn_hidden]'>
	    <input type=hidden name='performance_test_times' value='$_POST[performance_test_times]'>
            <input type=hidden name='err_msg' value='�ɮ׮榡���~<a href=./manage.php?teacher_course=$_POST[teacher_course]&curr_sort=$_POST[test_sort]> <<�W�@��>></a>'>
            <p><input type=submit name='file_date' value='���Z�ɮ׶פJ'></p>
            <b>".$_POST['err_msg']."</b>
            </td>
            <td valign='top' bgcolor='#FFFFFF'>
            �����G<br>
            <ol>
                <li>���Zcsv�ɡA�Фżg�W���Z�A�{���|�ѲĤT��}�lŪ��</li>
                <li>���Zcsv�ɪ��Ĥ@��key�W���D�A��K�N�Ӧۤv���d��</li>
                <li>�ɮפ��e�榡�p�U�G(�ѲĤT��}�l���Ĥ@�欰�ǥͬy�����A�ĤG�欰�y��, �ĤT�欰�m�W,�ĥ|�欰����)</li>
            </ol>
    <pre>
    #91�Ǧ~��1�Ǵ��@�~�@�Z�ƾǲ�2���q���w�����q
    2001,1,��XX,56
    2002,2,��XX,76
    2003,3,�iXX,56
    2004,4,�dXX,22
    1005,5,�LXX,99
    1006,6,��XX,65
    1007,7,��XX,87
    1008,8,��XX,88
    </pre>
            </td>
            </tr>
            </table>
            </form>";
	
       	head("���Z�ɮ׶פJ");
	print_menu($menu_p,"teacher_course=$_POST[teacher_course]");
        echo $main;
	foot();
	exit;
}

function save_import_score($targetFile = 'manage2.php') {
	global $CONN;	
	
	$ss_id = $_POST[ss_id];
	$test_sort = $_POST[test_sort];
	$teacher_course = $_POST[teacher_course];
	$class_id = $_POST[class_id];
	$class_id_array=explode("_",$_POST[class_id]);
	$seme_year_seme=$class_id_array[0].$class_id_array[1];
	$seme_class=intval($class_id_array[2]).$class_id_array[3];
	$score_semester = "score_semester_".intval($class_id_array[0])."_".intval($class_id_array[1]);
	$update_time = date("Y-m-j H:m:s");
	if ($test_sort == 255){
		$test_kind="���Ǵ�";
		$update_str=" test_sort=255 ";
		$test_kind_num = "all";
	}
	elseif($_POST[test_kind] =='s1'){
		$test_kind="�w�����q";
		$update_str = " test_kind='�w�����q'";
		$test_kind_num = "1";
	}
	elseif($_POST[test_kind] =='s2'){
		$test_kind="���ɦ��Z";
		$update_str = " test_kind='���ɦ��Z'";
		$test_kind_num = "2";
	}
	
	//�ˬd�ɦW�D�_�۲�
	$filename="semescore_".$class_id."_".$ss_id."_".$test_sort."_".$test_kind_num.".csv";
	if (strcmp($filename,$_FILES['scoredata']['name'])!= 0){
		echo "�פJ�ɦW���~ !! ,�Ч�M $filename �ɦW�פJ!!";
		exit;
	}
		
	//�ˬd���L���Z�O��
	$student_sn_hidden = substr($_POST[student_sn_hidden],0,-1);
	if ($_POST[test_sort] == 254){
		$query ="select student_sn,test_sort from $score_semester where student_sn in ($student_sn_hidden) and class_id='$class_id' and ss_id='$ss_id' and test_kind='$test_kind'";
		$res = $CONN->Execute($query);
		$student_sn_arr = array();
		while(!$res->EOF){
			$student_sn_arr[$res->fields[1]][]=$res->fields[0];
			$res->MoveNext();
		}
		if ($_FILES['scoredata']['size'] >0 && $_FILES['scoredata']['name'] != ""){
			$fd = fopen ($_FILES['scoredata']['tmp_name'] ,"r");
			$i =0;
			while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
				if ($i++ < 2){//�Ĥ@�������Y
					$msg="�Ĥ@�������Y�A���nkeyin���Z<br>";
					continue ;
				}
				$student_sn= trim($tt[0]);
				$stud_score = trim($tt[3]);
			//	if(strlen($stud_score)>3){
			//		echo $main;
			//		exit;
			//	}
				if($student_sn){
					if($stud_score=="")
						$stud_score="-100";
					echo $_POST[performance_test_times];
					for ($j=1;$j<=$_POST[performance_test_times];$j++) {
						if (in_array($student_sn,$student_sn_arr[$j]))
							$bobo= "update $score_semester SET score='$stud_score',update_time='$update_time',teacher_sn='$_SESSION[session_tea_sn]' where student_sn='$student_sn' and class_id='$class_id' and ss_id='$ss_id' and $update_str and test_sort='$j'";
						else
							$bobo="INSERT INTO $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values('$class_id','$student_sn','$ss_id','$stud_score','$test_kind','$test_kind','$j','$update_time','$_SESSION[session_tea_sn]')";
//	     	     				echo $bobo."<BR>";              
						if($CONN->Execute($bobo))
							$msg.="--num ".$stud_site_num." --���\<br>";
						else
							$msg.="--num ".$stud_site_num." --����<br>";
					}
				}else{
					$msg.="--num ".$stud_site_num." --���s�b<br>";
				}
			}
			header("Location: $targetFile?teacher_course=$teacher_course&curr_sort=$test_sort&msg=$msg");
		}
		else{
			echo $main;
			exit;
		}
	}else{
		$query ="select student_sn from $score_semester where student_sn in ($student_sn_hidden) and class_id='$class_id' and ss_id='$ss_id' and test_kind='$test_kind' and test_sort='$test_sort'";
		$res = $CONN->Execute($query);
		$student_sn_arr = array();
		while(!$res->EOF) {
			$student_sn_arr[]=$res->fields[0];
			$res->MoveNext();
		}

		if ($_FILES['scoredata']['size'] >0 && $_FILES['scoredata']['name'] != ""){
			$fd = fopen ($_FILES['scoredata']['tmp_name'] ,"r");
			$i =0;
			while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
				if ($i++ < 2){//�Ĥ@�������Y
					$msg="�Ĥ@�������Y�A���nkeyin���Z<br>";
					continue ;
				}
				$student_sn= trim($tt[0]);
				$stud_score = trim($tt[3]);
				//if(strlen($stud_score)>3){
				//	echo $main;
				//	exit;
				//}
				if($student_sn){
					if($stud_score=="")
						$stud_score="-100";
					if (in_array($student_sn,$student_sn_arr))
						$bobo= "update $score_semester SET score='$stud_score',update_time='$update_time',teacher_sn='$_SESSION[session_tea_sn]' where student_sn='$student_sn' and class_id='$class_id' and ss_id='$ss_id' and $update_str and test_sort='$test_sort'";
					else
						$bobo="INSERT INTO $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,teacher_sn) values('$class_id','$student_sn','$ss_id','$stud_score','$test_kind','$test_kind','$test_sort','$update_time','$_SESSION[session_tea_sn]')";
	//     	     			echo $bobo."<BR>";              
					if($CONN->Execute($bobo))
						$msg.="--num ".$stud_site_num." --���\<br>";
					 else
						$msg.="--num ".$stud_site_num." --����<br>";
				}
				else{
					$msg.="--num ".$stud_site_num." --���s�b<br>";
				}
			}
			header("Location: $targetFile?teacher_course=$teacher_course&curr_sort=$test_sort&msg=$msg");
		}
		else{
			echo $main;
			exit;
		}
	}

}




//���եثe�Ӧ~�ŸӯZ�ťثe�w�����q���Z�����
function select_stage2($year_seme,$year_name){
	global $CONN,$score_semester,$yorn;
	$sel_year = substr($year_seme,0,3);
	$sel_seme = substr($year_seme,-1);
	$c_year = substr($year_name,0,-2);
	$c_name = substr($year_name,-2);
	$score_semester="score_semester_".intval($sel_year)."_".$sel_seme;
	$class_id = sprintf("%03s_%s_%02s_%02s",$sel_year,$sel_seme,$c_year,$c_name);
	if ($yorn=='n')
		$sql="select DISTINCT test_sort from $score_semester where class_id='$class_id'  order by test_sort";
	else
		$sql="select DISTINCT test_sort from $score_semester where class_id='$class_id' and test_sort<>254  order by test_sort";

	$rs=&$CONN->Execute($sql) or die($sql);
        while (!$rs->EOF) {
		if($rs->fields[0]==255)
			$temp_name="���Ǵ�";
		elseif($rs->fields[0]==254)
			$temp_name="���ɦ��Z";
		else
			$temp_name="��".$rs->fields[0]."���q";
		$test_sort[$rs->fields[0]]= $temp_name;
		$rs->MoveNext();
        }
	return $test_sort;
}

//���o�Ҧ���ذ}�C
function get_all_subject_arr(){
	global $CONN;
	$query = "select subject_id,subject_name from score_subject";
	$res = $CONN->Execute($query);
	while(!$res->EOF){
		$res_arr[$res->fields[0]] = $res->fields[1];
		$res->MoveNext();
	}
	return $res_arr;
}
//��X�o�ӭȬO�}�C���ĴX�j���Aa�O�@�ӼơAb�O�@�Ӱ}�C
function  how_big2($a,$b){
	$sort=1;
	while(list($id,$val)=each($b)){
        	if($a<$val) $sort++;
    }
    return  $sort;
}

//�O�_�C�@����ҭn�t�X�@�����ɦ��Z
function  findyorn(){
	global $CONN;
	$rs_yorn=$CONN->Execute("SELECT pm_value FROM pro_module WHERE pm_name='score_input' AND pm_item='yorn'");
	$yorn=$rs_yorn->fields['pm_value'];
	return $yorn;
}

function ss_id_2_class_year($ss_id){
	global $CONN;
	$sql="select class_year from score_ss where ss_id='$ss_id' and enable=1";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$class_year=$rs->fields['class_year'];
	return $class_year;
}

function student_sn_2_class_id($sel_year,$sel_seme,$student_sn){
	global $CONN;
	$sql="select seme_class from stud_seme where student_sn='$student_sn' and seme_year_seme='".sprintf("%03d",$sel_year).$sel_seme."'";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	$seme_class=$rs->fields['seme_class'];
	$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($seme_class,0,-2),substr($seme_class,-2,2));
	return $class_id;
}
?>
