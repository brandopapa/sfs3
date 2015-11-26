<?php

//���o�U���n�p�������� , �Ǧ^�T���}�C  
// $data[scope][subject_id][subject]=����W��
// $data[scope][subject_id][link_ss]=���
// $data[scope][subject_id][rate]=�[�v
// $data[scope][subject_id][ss_id]=�ҵ{�N�X
// $data[scope][subject_id][items]=�w�R�D��

function get_year_seme_scope($year,$semester,$class_year) {
	 	
	 	global $CONN;
	 	
	 	//�w�q�C�j���
	 	if($class_year>2){
			$ss_link=array("�y��-����y��"=>"language","�y��-�m�g�y��"=>"language","�y��-�^�y"=>"language","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			//$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
		} else {
			$ss_link=array("�y��-����y��"=>"language","�y��-�m�g�y��"=>"language","�y��-�^�y"=>"language","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			//$link_ss=array("chinese"=>"�y��-����y��","local"=>"�y��-�m�g�y��","english"=>"�y��-�^�y","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
		} 	

		//Ū���U���쪺�W��
		$sql="select * from score_subject ";
		$res=$CONN->Execute($sql);
		while ($row=$res->fetchRow()) {
 			$subject[$row['subject_id']]=$row['subject_name'];
		}
	
		//Ū���Ǵ��ҵ{�]�w
 		$query="select * from score_ss where year='$year' and semester='$semester' and class_year='$class_year' and enable='1' and need_exam='1' order by link_ss,sort,sub_sort";
		$res=$CONN->Execute($query) or die("Ū���ҵ{�]�w�o�Ϳ��~, SQL=".$query);
        //2015.11.18 �]���Z�Žҵ{���ϥέק�  ��U���쪺�]�w�w�q�� ALL �� class_id ���l�}�C
		while ($row=$res->fetchRow()) {
            $class_id=($row['class_id']=='')?"ALL":$row['class_id'];
			$link_ss=$row['link_ss'];   //��줤��W
			$SCOPE=$ss_link[$link_ss];	//�ഫ���^��
			
			//$scope_id=$row['scope_id']; //���id
					
			$subject_id=($row['subject_id']>0)?$row['subject_id']:$row['scope_id']; //����W�٪�id�A�Y��0�A�H���id���
			
			//�}�l�O��
			$scope_main[$class_id][$SCOPE][$subject_id]['subject']=$subject[$subject_id];
			$scope_main[$class_id][$SCOPE][$subject_id]['link_ss']=$SCOPE;
			$scope_main[$class_id][$SCOPE][$subject_id]['rate']=$row['rate'];
			$scope_main[$class_id][$SCOPE][$subject_id]['ss_id']=$row['ss_id'];
            //$scope_main[$SCOPE][$i][$subject_id]['class_id']=;
			
		} // end while
		
			//Ū�������D��
			$seme_year_seme=$year.$semester;
			foreach ($ss_link as $scope) {
				$paper_setup=get_paper_sn($seme_year_seme,$class_year,$scope);
				if ($paper_setup['sn']>0) {
				foreach ($scope_main[$scope] as $k=>$v) {
			  	$sql="select count(*) as num from resit_exam_items where paper_sn='".$paper_setup['sn']."' and subject='".$v['subject']."'";
			    $res=$CONN->Execute($sql) or user_error("Ū�����~! $sql",256);
			    $num=$res->fields['num'];
			    $scope_main[$scope][$k]['items']=$num;
				} // end foreach
			  } // end if
			} // end foreach
		
		return $scope_main;
		
} // end function

//Ū���Y�Ǵ�,�~��,���U�����D�Ƴ]�w
function get_scope_subject_items($seme_year_seme,$Cyear,$scope) {
	global $CONN;
	$subject=array();
	$sql="select * from resit_scope_subject where seme_year_seme='$seme_year_seme' and cyear='$Cyear' and scope='$scope'";
	$res=$CONN->Execute($sql) or die ('Ū�������D�Ƴ]�w���~ SQL='.$sql);
	while ($row=$res->fetchrow()) {
		$id=$row['subject_id'];
		$items=$row['items'];
	  $subject[$id]=$items;
	}
	
	return $subject;
	
}


//�p��Ǵ��U��줣�ή�H��, �üg�J�ɦҸ�Ʈw��
function count_scope_fail($Cyear,$seme_year_seme,$ss_link,$link_ss) {
	global $CONN,$now_cy,$curr_year_seme;
 //�̤Ŀ諸�~�� , ��Ū���W��
 //����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($curr_year_seme);
	$stud_sn=array();
  //$query="select a.*,b.stud_name,b.stud_person_id from stud_seme a left join stud_base b on a.student_sn=b.student_sn where a.seme_year_seme='$seme_year_seme' and a.seme_class like '$Cyear%' and b.stud_study_cond in ('0','15') order by a.seme_class,a.seme_num";
	//$res=$CONN->Execute($query);
  //�H���~�׾ǥ͸�ƥh�� student_sn , �H�K�줣���Ӥ~��J���ǥ� student_sn	
	$Now_Cyear=$Cyear+$now_cy;
	$query="select a.student_sn,a.stud_id,a.stud_name,a.stud_person_id,a.curr_class_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$curr_year_seme' and a.curr_class_num like '".$Now_Cyear."%' and stud_study_cond in ('0','15') order by curr_class_num";
  $res=$CONN->Execute($query) or die ("Ū���ǥͰ򥻸�Ƶo�Ϳ��~! SQL=".$query);	
	
	//�ǥ��`�H��
	$student_all=$res->recordcount(); 
	
	while(!$res->EOF) {
		$student_sn=$res->fields['student_sn'];
		$stud_sn[]=$student_sn;
		$curr_class_num=$res->fields['curr_class_num'];
		$seme_class=substr($curr_class_num,0,3);
		
		$student_data[$student_sn]['seme_class']=substr($curr_class_num,0,3);
		$student_data[$student_sn]['seme_num']=substr($curr_class_num,-2);
		
		
		$student_data[$student_sn]['stud_person_id']=$res->fields['stud_person_id'];
		$student_data[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data[$student_sn]['stud_id']=$res->fields['stud_id'];
		
		$student_data[$student_sn]['class_name']=$class_base[$seme_class];
		
		//echo $student_sn.",".$res->fields['stud_name']."<br>";
		
		$res->MoveNext();
	} // end while

 	$semes[]=$seme_year_seme;  //�ثe�Ǵ�
	//�����즨�Z
	$sel_year=substr($seme_year_seme,0,3);
	$sel_seme=substr($seme_year_seme,-1);
	//$fin_score=cal_fin_score($stud_sn,$semes,"",array($sel_year,$sel_seme,$Cyear),$percision);
	$fin_score=cal_fin_score($stud_sn,$semes,"",$strs,1);
  //Ū���ҵ{�]�w
  $scope_subject=get_year_seme_scope($sel_year,$sel_seme,$Cyear);

  //�έp�U��줣�Ů�H�� , �̻��]�j��  
  foreach ($link_ss as $scope=>$v) {
  	//Ū�������ը��]�w�A�S�����ܦ۰ʫإߡA�H�K�W�������ը�
  	$paper_setup=get_paper_sn($seme_year_seme,$Cyear,$scope,1); 	
  //�̾ǥ� student_sn �]�j��A�̦��ˬd��즨�Z
   foreach ($stud_sn as $student_sn) {
    //���ή�, �H�ƥ[1
   	if ($fin_score[$student_sn][$scope][$seme_year_seme]['score']<60) {
    	//���ѥ[�ɦ�, �ݸɦҤH�ƥ[1
			$sql="select a.* from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope'";
			$res=$CONN->Execute($sql) or die($sql);
			 //�ɦҸ�Ʈw���S���H
			if ($res->recordcount()==0) {
				//���o���ͤ��ή檺����
				$subjects="";
				foreach ($scope_subject[$scope] as $subject_id=>$v) {
				  //Ū�X���Z
				  $ss_id=$v['ss_id'];
				  $ss_score_sql="select ss_score from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='$ss_id'";
					$ss_score_res=$CONN->Execute($ss_score_sql) or die('Ū���Ǵ����Z�o�Ϳ��~!');
          $ss_score=$ss_score_res->fields['ss_score'];
          if ($ss_score<60) $subjects.=$v['subject'].",";
				} // end foreach
				if ($subjects!="") $subjects=substr($subjects,0,strlen($subjects)-1);
				$sql="insert into resit_exam_score (student_sn,paper_sn,org_score,subjects) values ('$student_sn','".$paper_setup['sn']."','".$fin_score[$student_sn][$scope][$seme_year_seme]['score']."','$subjects')";
				$res=$CONN->Execute($sql) or die($sql);
			} else {
			 //�����H�A�󥿭�l����
				$sql="update resit_exam_score set org_score='".$fin_score[$student_sn][$scope][$seme_year_seme]['score']."' where student_sn='$student_sn' and paper_sn='".$paper_setup['sn']."'";
				$res=$CONN->Execute($sql) or die($sql);
			}
		} // end if score<60
   } // end foreach
  }

  return $student_all;
  
}

//���o�ը����]�w��
function get_paper_sn($seme_year_seme,$class_year,$scope,$auto_insert=0) {
	global $CONN;
 	$sql="select * from resit_paper_setup where seme_year_seme='$seme_year_seme' and class_year='$class_year' and scope='$scope'";	
	$res=$CONN->Execute($sql) or die($sql);
	
	if ($res->RecordCount()==0 and $auto_insert==1) {
	 //�w�]��
	 $start_time=date('Y-m-d H:i:00');
   $end_time=date('Y-m-d H:i:00');
   $timer_mode=0;
   $timer=45;
   $relay_answer=0;
   $items=0;
   $double_papers=0;
		$sql="insert into resit_paper_setup (seme_year_seme,class_year,scope,start_time,end_time,timer_mode,timer,relay_answer,items,double_papers) values ('$seme_year_seme','$class_year','$scope','$start_time','$end_time','$timer_mode','$timer','$relay_answer','$items','$double_papers')";
	  $res=$CONN->Execute($sql) or die ('Error! Query='.$sql);
 		$sql="select * from resit_paper_setup where seme_year_seme='$seme_year_seme' and class_year='$class_year' and scope='$scope'";	
		$res=$CONN->Execute($sql) or die($sql);
	}
	
	$row=$res->fetchRow();
  return $row;
}


//���D��� $item=array()
function form_item($item) {
 global $scope_subject,$item_scope;
 //echo "<pre>";
 //echo $item_scope;
 //print_r($scope_subject);
 //echo "</pre>";
 //exit();
 
 ?>
 <table border="1" cellpadding="2" cellspacing="0" bordercolor="#800000" bgcolor="#FFFFFF" style="border-collapse: collapse">
   <tr>
     <td width="70" bgcolor="#FFCC66" valign="top"><font color="#0000FF">�D�F</font></td>
     <td width="730"bgcolor="#FFE7B3">
      <textarea name="question" cols="78" rows="5"><?php echo $item['question'];?></textarea>
			<br>���� <input type="file" size="26" name="thefig_q">
			<?php
			 if ($item['fig_q']) {
			?>
			<font color="#FF0000">(��)</font>
			<input type="checkbox" name="del_fig[q]" value="1">�R��
			<?php
			 } // end if fig_q
			?>
    </td>
  </tr>
  <tr id="cha">
      <td width="70" bgcolor="#A2FFA2"><font color="#0000FF">���(A)</font></td>
      <td bgcolor=#CCFFCC>
					<input size="49" name="cha" value="<?php echo $item['cha'];?>">
					����<input type="file" size="10" id="thefig_a" name="thefig_a">
			<?php
			 if ($item['fig_a']) {
			?>
			<font color="#FF0000">(��)</font>
			<input type="checkbox" id="del_fig_a" name="del_fig[a]" value="1">�R��
			<?php
			 } // end if fig_a
			?>
      </td>
  </tr>
  <tr id="chb">
      <td width="70" bgcolor="#A2FFA2"><font color="#0000FF">���(B)</font></td>
      <td bgcolor="#CCFFCC">
					<input size="49" name="chb" value="<?php echo $item['chb'];?>">
					����<input type="file" size="10" id="thefig_b" name="thefig_b">
			<?php
			 if ($item['fig_b']) {
			?>
			<font color="#FF0000">(��)</font>
			<input type="checkbox" id="del_fig_b" name="del_fig[b]" value="1">�R��
			<?php
			 } // end if fig_a
			?>					
      </td>
  </tr>
  <tr id="chc">
     	<td width="70" bgcolor="#A2FFA2"><font color="#0000FF">���(C)</font></td>
      <td width="564" bgcolor="#CCFFCC">
					<input size="49" name="chc" value="<?php echo $item['chc'];?>">
					����<input type="file" size="10" id="thefig_c" name="thefig_c">
			<?php
			 if ($item['fig_c']) {
			?>
			<font color="#FF0000">(��)</font>
			<input type="checkbox" id="del_fig_c" name="del_fig[c]" value="1">�R��
			<?php
			 } // end if fig_a
			?>					
      </td>
    </tr>
    <tr id="chd">
      <td width="70" bgcolor="#A2FFA2"><font color="#0000FF">���(D)</font></td>
      <td bgcolor="#CCFFCC">
					<input size="49" name="chd" value="<?php echo $item['chd'];?>">
					����<input type="file" size="10" id="thefig_d" name="thefig_d">
			<?php
			 if ($item['fig_d']) {
			?>
			<font color="#FF0000">(��)</font>
			<input type="checkbox" id="del_fig_d" name="del_fig[d]" value="1">�R��
			<?php
			 } // end if fig_a
			?>					
      </td>
    </tr>
    <tr id="answer">
      <td width="70" bgcolor="#A2FFA2"><font color="#0000FF">�зǵ���</font></td>
      <td bgcolor="#CCFFCC">
				<input type="radio" name="answer" value="A"<?php if ($item['answer']=="A") echo " checked";?>>(A)&nbsp;
				<input type="radio" name="answer" value="B"<?php if ($item['answer']=="B") echo " checked";?>>(B)&nbsp;
				<input type="radio" name="answer" value="C"<?php if ($item['answer']=="C") echo " checked";?>>(C)&nbsp;
				<input type="radio" name="answer" value="D"<?php if ($item['answer']=="D") echo " checked";?>>(D)
      </td>
    </tr>
    <tr id="subject">
      <td width="70" bgcolor="#A2FFA2"><font color="#0000FF">����O</font></td>
      <td bgcolor="#CCFFCC">
				<select size="1" name="subject">
				  <option value="">�L�]�w</option>
				  <?php
				   foreach ($scope_subject[$item_scope] as $scope=>$v) {
				   ?>
				   	<option value="<?php echo $v['subject'];?>"<?php if ($item['subject']==$v['subject']) echo " selected";?>><?php echo $v['subject'];?></option>
				   <?php
				   }
				  ?>
				</select>
      </td>
    </tr>
  </table>
 <?php
} // end function

//Ū�����D
function get_item($sn) {
 global $CONN;
 $sql="select * from resit_exam_items where sn='$sn'";
 $res=$CONN->Execute($sql) or die($sql);
 $row=$res->fetchRow();
 return $row;
}

//��ܸ��D
//$update_answer 0 �e�{����
//							 1 �վ���D�A�H�U�Ԧ����e�{
//							 2 �e�{ $stud_ans�����סA�ä��A�X�{���΢�
//							 3 �վ����
function show_item($sn,$update_answer=0,$stud_ans="",$site_num="") {
	
//	echo "��ܸ��D".$sn;
//	exit();
	
 global $CONN,$item_scope,$scope_subject;
 $sql="select * from resit_exam_items where sn='$sn'";
 $res=$CONN->Execute($sql) or die($sql);
 $row=$res->fetchRow();
 
 //�ˬd�����ը����S���@���O��
 $sql="select count(*) as num from resit_exam_score where paper_sn='".$row['paper_sn']."' and entrance='1'";
 $res=$CONN->Execute($sql) or die($sql);
 $NO_DEL=$res->fields['num'];
 
 if ($NO_DEL==0) {
  $del_url="<img src='./images/del.png' class='edit_paper_delete' id='item-".$row['sn']."'>";  
 } else {
  $del_url="";
 }

 $bg_A=$bg_B=$bg_C=$bg_D="#FFFFFF";
 $target_bg="bg_".$row['answer'];
 $$target_bg="#FFCCCC";  
 
 //�M�w��ܫ���(�D�F�Ϥj��400, ����, ��ؤp��200,�P�@��, 200~400,�����,�j��400�U�@�� )
 $fig_array=array("q","a","b","c","d");
  foreach ($fig_array as $v) {
		$target_fig_name="fig_".$v;
		$X="xx_".$v;
		$ssn=$row[$target_fig_name];
		if ($ssn) {
			$sql="select xx from resit_images where sn='$ssn'";
			$res=$CONN->Execute($sql) or die('�L�kŪ���Ϥ�width��! SQL='.$sql);
			${$X}=$res->fields['xx'];
    } else {
    	${$X}=0;
    }
  } // end foreach
  
  //��ܥ��D����, �νվ���� 
  if ($update_answer==3) { 
   $subject="
    <select size='1' name='ch_subject[".$row['sn']."]'>
      <option value=''>�L�]�w</option>";
    foreach ($scope_subject[$item_scope] as $v) {
      $subject.="<option value='".$v['subject']."'".(($v['subject']==$row['subject'])?" selected":"").">".$v['subject']."</option>";
    }   
    $subject.="</select>";
    
    $update_answer=0;
  } else {
   $subject=$row['subject'];
  } // end if else update_answer==3
  
  
  //�D�F����
  if ($xx_q > 400) {
    $HTML_q="
     <tr>
       <td>".$row['question']."�m<font size='2'>".$row['sn'].", ".$subject.", </font><img src='./images/edit.png' class='edit_paper_update' id='item-".$row['sn']."'> $del_url �n</td>
     </tr>
     <tr>
       <td><img src=\"img_show.php?sn=".$row['fig_q']."\"></td>
     </tr>";
  } elseif ($xx_q==0) {
    $HTML_q="
     <tr>
       <td>".$row['question']."�m<font size='2'>".$row['sn'].", ".$subject.", </font><img src='./images/edit.png' class='edit_paper_update' id='item-".$row['sn']."'> $del_url �n</td>
     </tr>";
  } else {
     $HTML_q="
     <tr>
       <td valign='top'>".$row['question']."�m<font size='2'>".$row['sn'].", ".$subject.", </font><img src='./images/edit.png' class='edit_paper_update' id='item-".$row['sn']."'> $del_url �n</td>
       <td valign='top' align='right'><img src=\"img_show.php?sn=".$row['fig_q']."\"></td>
     </tr>";   
  } // end if �D�F
  
  //��تO��
  if ($xx_a==0 and $xx_b==0 and $xx_c==0 and $xx_d==0) {
    //1�C
    $HTML_choice="
    <tr>
      <td valign='top' bgcolor='$bg_A'>(A)".$row['cha']."</td><td valign='top' bgcolor='$bg_B'>(B)".$row['chb']."</td><td valign='top' bgcolor='$bg_C'>(C)".$row['chc']."</td><td valign='top' bgcolor='$bg_D'>(D)".$row['chd']."</td>
    </tr>
    ";
  } elseif($xx_a+$xx_b+$xx_c+$xx_d<800) {
    //1�C
    $HTML_choice="
    <tr>
      <td width='25%' valign='top' bgcolor='$bg_A'>(A)".$row['cha'].(($row['fig_a']>0)?"<br><img src='img_show.php?sn=".$row['fig_a']."'>":"")."</td>
      <td width='25%' valign='top' bgcolor='$bg_B'>(B)".$row['chb'].(($row['fig_b']>0)?"<br><img src='img_show.php?sn=".$row['fig_b']."'>":"")."</td>
      <td width='25%' valign='top' bgcolor='$bg_C'>(C)".$row['chc'].(($row['fig_c']>0)?"<br><img src='img_show.php?sn=".$row['fig_c']."'>":"")."</td>
      <td width='25%' valign='top' bgcolor='$bg_D'>(D)".$row['chd'].(($row['fig_d']>0)?"<br><img src='img_show.php?sn=".$row['fig_d']."'>":"")."</td>
    </tr>
    ";
  } elseif($xx_a>200 and $xx_a<400) {
    //2�C
    $HTML_choice="
    <tr>
      <td width='50%' valign='top' bgcolor='$bg_A'>(A)".$row['cha'].(($row['fig_a']>0)?"<br><img src='img_show.php?sn=".$row['fig_a']."'>":"")."</td>
      <td width='50%' valign='top' bgcolor='$bg_B'>(B)".$row['chb'].(($row['fig_b']>0)?"<br><img src='img_show.php?sn=".$row['fig_b']."'>":"")."</td>
		</tr>
		<tr>
      <td width='50%' valign='top' bgcolor='$bg_C'>(C)".$row['chc'].(($row['fig_c']>0)?"<br><img src='img_show.php?sn=".$row['fig_c']."'>":"")."</td>
      <td width='50%' valign='top' bgcolor='$bg_D'>(D)".$row['chd'].(($row['fig_d']>0)?"<br><img src='img_show.php?sn=".$row['fig_d']."'>":"")."</td>
    </tr>
    ";
  } else {
    //4�C
    $HTML_choice="
    <tr>
      <td valign='top' bgcolor='$bg_A'>(A)".$row['cha'].(($row['fig_a']>0)?"<br><img src='img_show.php?sn=".$row['fig_a']."'>":"")."</td>
     </tr>
     <tr>
      <td valign='top' bgcolor='$bg_B'>(B)".$row['chb'].(($row['fig_b']>0)?"<br><img src='img_show.php?sn=".$row['fig_b']."'>":"")."</td>
     </tr>
     <tr>
      <td valign='top' bgcolor='$bg_C'>(C)".$row['chc'].(($row['fig_c']>0)?"<br><img src='img_show.php?sn=".$row['fig_c']."'>":"")."</td>
     </tr>
     <tr>
      <td valign='top' bgcolor='$bg_D'>(D)".$row['chd'].(($row['fig_d']>0)?"<br><img src='img_show.php?sn=".$row['fig_d']."'>":"")."</td>
    </tr>
    ";
  } // end if ��ت���
  
  //��X�D�F�M���
  
  switch($update_answer){
  	//���`�˵�
  	case 0:
  $main="
  <table border='0' width='800' cellspacing='0' cellpadding='0'>
   <tr>
   <td rowspan='2' valign='top' width='60' align='center'>( <font color=red>".$row['answer']."</font> )".$site_num.".</td>
   <td>
    <table border='0' width='100%'>    
    $HTML_q
    </table>
   </td>
   </tr>
   <tr>
    <td>
     <table border='0' width='100%'>
     $HTML_choice
     </table>
    </td>
    </tr>
  </table> 
  ";
  	break;
  	//�վ�ѵ�
  	case 1:
  	$ans_select="
  	 <select size='1' name='answer[".$row['sn']."]'>
  	   <option value='' style='color:#FF0000'>-</option>
  	   <option value='A'".(($row['answer']=='A')?" selected":"").">A</option>
  	   <option value='B'".(($row['answer']=='B')?" selected":"").">B</option>
  	   <option value='C'".(($row['answer']=='C')?" selected":"").">C</option>
  	   <option value='D'".(($row['answer']=='D')?" selected":"").">D</option>  	   
  	 </select>
  	";
  $main="
  <table border='0' width='800' cellspacing='0' cellpadding='0'>
   <tr>
   <td rowspan='2' valign='top' width='60' align='center'>$ans_select".$site_num.".</td>
   <td>
    <table border='0' width='100%'>    
    $HTML_q
    </table>
   </td>
   </tr>
   <tr>
    <td>
     <table border='0' width='100%'>
     $HTML_choice
     </table>
    </td>
    </tr>
  </table> 
  ";  
  	break;
  	
	//���ǥͧ@��  	
  	case 2:
			if ($row['answer']==$stud_ans) { 
			 $check_ans="<img src='./images/right.jpg'>";
			} else {
			 $check_ans="<img src='./images/wrong.png'>";
			}
  $main="
  <table border='0' width='800' cellspacing='0' cellpadding='0'>
   <tr>
   <td valign='top' width='60' align='center'>( <font color=green>".$stud_ans."</font> )".$site_num.".</td>
   <td>
    <table border='0' width='100%'>    
    $HTML_q
    </table>
   </td>
   </tr>
   <tr>
    <td valign='top' width='60' align='center'>$check_ans</td>
    <td>
     <table border='0' width='100%'>
     $HTML_choice
     </table>
    </td>
    </tr>
  </table> 
  ";  

  	break;

  
  
  } 
  
 
  return $main; 
   
}


//�s�@���D
function make_item_style($num,$row=array()) {
	
//	echo "��ܸ��D".$sn;
//	exit();
	
 global $CONN;

 //�M�w��ܫ���(�D�F�Ϥj��400, ����, ��ؤp��200,�P�@��, 200~400,�����,�j��400�U�@�� )
 $fig_array=array("q","a","b","c","d");
  foreach ($fig_array as $v) {
		$target_fig_name="fig_".$v;
		$X="xx_".$v;
		$ssn=$row[$target_fig_name];
		if ($ssn) {
			$sql="select xx from resit_images where sn='$ssn'";
			$res=$CONN->Execute($sql) or die('�L�kŪ���Ϥ�width��! SQL='.$sql);
			${$X}=$res->fields['xx'];
    } else {
    	${$X}=0;
    }
  } // end foreach
  
  $row['question'] = preg_replace("/���~/",'<font color=red><u>���~</u></font>',$row['question']);
  
  //�D�F����
  if ($xx_q > 400) {
    $HTML_q="
     <tr>
       <td>".$row['question']." <font size=2>�i".$row['subject']."�j</font></td>
     </tr>
     <tr>
       <td><img src=\"img_show.php?sn=".$row['fig_q']."\"></td>
     </tr>";
  } elseif ($xx_q==0) {
    $HTML_q="
     <tr>
       <td>".$row['question']." <font size=2>�i".$row['subject']."�j</font></td>
     </tr>";
  } else {
     $HTML_q="
     <tr>
       <td valign='top'>".$row['question']." <font size=2>�i".$row['subject']."�j</font></td>
       <td valign='top' align='right'><img src=\"img_show.php?sn=".$row['fig_q']."\"></td>
     </tr>";   
  } // end if �D�F
  
  //�i���ضüƽմ�, ���^$rand_choice[1]='' , $rand_choice[2]='' ....
  $n1=strpos(" ".$row['chd'],"�H�W��"); //��ݬݲĥ|�ӿ�جO�_���H�W��
  if ($n1==1) {
   $rand_choice=make_rand(array(1=>'A',2=>'B',3=>'C'));
   $rand_choice[4]='D';  
  } else {
   $rand_choice=make_rand(array(1=>'A',2=>'B',3=>'C',4=>'D'));
  }
  
  //��p�g
  for ($i;$i<=4;$i++) {
    $choice_key=strtolower($rand_choice[$i]);
    $a='ch'.$choice_key;
    $b='fig_'.$choice_key;
    $choice[$i]=$row[$a];       //�ﶵ��r
    $choice_fig[$i]=$row[$b];   //�ﶵ�Ϥ�
  }
  
  //�ﶵ 1-4 ,��ڿﶵ $rand_choice[$i] , �e�{��r $choice[$i] �e�{�Ϥ� $choice_fig[$i]
  
  
  //��تO��
  if ($xx_a==0 and $xx_b==0 and $xx_c==0 and $xx_d==0) {
    //1�C
    $HTML_choice="
    <tr>
      <td valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[1]."'>(A)".$choice[1]."</td>
      <td valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[2]."'>(B)".$choice[2]."</td>
      <td valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[3]."'>(C)".$choice[3]."</td>
      <td valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[4]."'>(D)".$choice[4]."</td>
    </tr>
    ";
  } elseif($xx_a+$xx_b+$xx_c+$xx_d<800) {
    //1�C
    $HTML_choice="
    <tr>
      <td width='25%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[1]."'>(A)".$choice[1].(($choice_fig[1]>0)?"<br><img src='img_show.php?sn=".$choice_fig[1]."'>":"")."</td>
      <td width='25%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[2]."'>(B)".$choice[2].(($choice_fig[2]>0)?"<br><img src='img_show.php?sn=".$choice_fig[2]."'>":"")."</td>
      <td width='25%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[3]."'>(C)".$choice[3].(($choice_fig[3]>0)?"<br><img src='img_show.php?sn=".$choice_fig[3]."'>":"")."</td>
      <td width='25%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[4]."'>(D)".$choice[4].(($choice_fig[4]>0)?"<br><img src='img_show.php?sn=".$choice_fig[4]."'>":"")."</td>
    </tr>
    ";
  } elseif($xx_a>200 and $xx_a<400) {
    //2�C
    $HTML_choice="
    <tr>
      <td width='50%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[1]."'>(A)".$choice[1].(($choice_fig[1]>0)?"<br><img src='img_show.php?sn=".$choice_fig[1]."'>":"")."</td>
      <td width='50%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[2]."'>(B)".$choice[2].(($choice_fig[2]>0)?"<br><img src='img_show.php?sn=".$choice_fig[2]."'>":"")."</td>
		</tr>
		<tr>
      <td width='50%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[3]."'>(C)".$choice[3].(($choice_fig[3]>0)?"<br><img src='img_show.php?sn=".$choice_fig[3]."'>":"")."</td>
      <td width='50%' valign='top'><input type='radio' name='answers[$num]' value='".$rand_choice[4]."'>(D)".$choice[4].(($choice_fig[4]>0)?"<br><img src='img_show.php?sn=".$choice_fig[4]."'>":"")."</td>
    </tr>
    ";
  } else {
    //4�C
    $HTML_choice="
    <tr>
      <td><input type='radio' name='answers[$num]' value='".$rand_choice[1]."'>(A)".$choice[1].(($choice_fig[1]>0)?"<br><img src='img_show.php?sn=".$choice_fig[1]."'>":"")."</td>
     </tr>
     <tr>
      <td><input type='radio' name='answers[$num]' value='".$rand_choice[2]."'>(B)".$choice[2].(($choice_fig[2]>0)?"<br><img src='img_show.php?sn=".$choice_fig[2]."'>":"")."</td>
     </tr>
     <tr>
      <td><input type='radio' name='answers[$num]' value='".$rand_choice[3]."'>(C)".$choice[3].(($choice_fig[3]>0)?"<br><img src='img_show.php?sn=".$choice_fig[3]."'>":"")."</td>
     </tr>
     <tr>
      <td><input type='radio' name='answers[$num]' value='".$rand_choice[4]."'>(D)".$choice[4].(($choice_fig[4]>0)?"<br><img src='img_show.php?sn=".$choice_fig[4]."'>":"")."</td>
    </tr>
    ";
  } // end if ��ت���
  
  //��X�D�F�M���
  $main="
  <table border='0'  width='100%' cellspacing='0' cellpadding='0'>
   <tr id=\"tr".$num."\" class=\"bg_0\" onMouseOver=\"OverLine('tr".$num."',$num)\" onMouseOut=\"OutLine('tr".$num."',$num)\" onClick=\"ClickLine('tr".$num."',$num)\">
   <td rowspan='2' valign='top' width='30' align='center'>$num.</td>
   <td>
    <table border='0' width='100%' class='test_item' style='font-size:12pt'>    
    $HTML_q
    </table>
   </td>
   </tr>
   <tr>
    <td>
     <table border='0' width='100%' class='test_item' style='font-size:12pt'>
     $HTML_choice
     </table>
    </td>
    </tr>
  </table> 
  ";
  
  return $main; 
   
}

//��ضü� (�ǤJ a,b,c �� a,b,c,d
function make_rand($rand_choice=array()) {
	
  $return_choice=array();
  $M=count($rand_choice);
  $i=0;
  do {
   $a=mt_rand(1,$M);
   if ($rand_choice[$a]!="") {
    $i++;
    $return_choice[$i]=$rand_choice[$a];
		$rand_choice[$a]="";
   }
  } while ($i<$M);  
  return $return_choice;
}

//���ɳB�z
function ImageResize($from_filename, $save_filename, $in_width=400, $in_height=300, $quality=100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    
    // ���o�Y�b���d�򤺪����
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);

    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    /*
    // $sub_name = jpeg, png, gif
    $function_name = 'imagecreatefrom' . $sub_name;

    if ($sub_name=='png')
        return $function_name($image_new, $save_filename, intval($quality / 10 - 1));

    $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
    */
    
    
    //$image = imagecreatefromjpeg($from_filename);
    
    $function_name = 'imagecreatefrom'.$sub_name;
    $image = $function_name($from_filename);

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagejpeg($image_new, $save_filename, $quality);
     
}

/**
 * ����n�Y�Ϫ����
 * $source_w : �ӷ��Ϥ��e��
 * $source_h : �ӷ��Ϥ�����
 * $inside_w : �Y�Ϲw�w�e��
 * $inside_h : �Y�Ϲw�w����
 *
 * Test:
 *   $v = (getResizePercent(1024, 768, 400, 300));
 *   echo 1024 * $v . "\n";
 *   echo  768 * $v . "\n";
 */
function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, �p�G����w�p�Y�Ϫ��p�N�����Y
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}
 

?>