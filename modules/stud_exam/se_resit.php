<?php	
header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
//���ҬO�_�n�J
sfs_check(); 
//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ɦҾǴ��O�]�w
$sql="select * from resit_seme_setup limit 1";
$res=$CONN->Execute($sql);
$SETUP=$res->fetchrow();
$seme_year_seme=$SETUP['now_year_seme'];

//���o�ǥͥثe���y���
//�H���~�׾ǥ͸�ƥh�� student_sn , �H�K�줣���Ӥ~��J���ǥ� student_sn	
//�ǥ͸�Ʀs��� $STUD array ��, �]�A�G
// stud_id �Ǹ�
// stud_anme ����m�W
// seme_class �Z�� �p 701,702
// seme_class_name �Z�ŦW��
// seme_num �y��
$sql="select a.*,b.stud_name from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.student_sn='".$_SESSION['session_tea_sn']."' and a.seme_year_seme='".$curr_year_seme."'";
$res=$CONN->Execute($sql);
$STUD=$res->fetchRow();

//�ӥͷ�e�~��
$Now_Cyear=substr($STUD['seme_class'],0,1); //�E�~�@�e���~�� , �ꤤ�� 7-9
$sel_year=substr($SETUP['now_year_seme'],0,3);
$sel_seme=substr($SETUP['now_year_seme'],-1);

//�ɦҾǴ����~��
$Cyear=$Now_Cyear-($curr_year-$sel_year);


//���o�Ǵ��ҵ{�]�w
//������Ǵ��Ҧ��ҵ{�]�w(���Ф���) 3���}�C $scope_subject[scope][][]
// $data[scope][subject_id][subject]=����W��
// $data[scope][subject_id][link_ss]=���
// $data[scope][subject_id][rate]=�[�v
// $data[scope][subject_id][ss_id]=�ҵ{�N�X
// $data[scope][subject_id][items]=�w�R�D��
$scope_subject=get_year_seme_scope($sel_year,$sel_seme,$Cyear);



//�Z�Ť���W��
$CLASS_name=$school_kind_name[$Now_Cyear].$STUD['seme_class_name']."�Z"; //����A�p�@�~�A�G�~...

//�Ǧ~�פ���W��
$C_year_seme=substr($SETUP['now_year_seme'],0,3)."�Ǧ~�ײ�".substr($SETUP['now_year_seme'],-1)."�Ǵ�";

//�E�~�@�e�����
 		if($Cyear>2){
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
		} else {
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
		}

//���o�ӥ͸ӾǴ����Ǵ����Z
	$semes[]=$seme_year_seme;  //�ثe�Ǵ�
	$stud_sn[]=$STUD['student_sn'];
	//�����즨�Z
	$sel_year=substr($seme_year_seme,0,3);
	$sel_seme=substr($seme_year_seme,-1);
	$fin_score=cal_fin_score($stud_sn,$semes,"",array($sel_year,$sel_seme,$Cyear),1);

  foreach ($ss_link as $v) {
    ${$v}=$fin_score[$STUD['student_sn']][$v][$seme_year_seme]['score'];
  }
  
//�ثe�ɶ�
$nowsec=date("U",mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y")));
  
//�}�l����
if ($_POST['act']=='start_test') {
 //���O
 $scope=$_POST['scope'];
 $main="<tr><td>�ɦһ��G".$school_kind_name[$Cyear]."�� ".$link_ss[$scope]."</td></tr>";
 //�w�����ˬd ==============================
	if (${$scope}>=60) {
 			echo "<br>�A���ݭn�ɦҳo�ӻ��! ";
 			exit();
 	}

 //Ū�����ը��]�w
  $paper_setup=get_paper_sn($seme_year_seme,$Cyear,$scope);

 //�ˬd�Ҹծɶ� 
 	 //�Ҹծɬq�̾Ǵ��]�w�θը��ӧO�]�w
 			  if ($SETUP['paper_mode']) {
					$start_time=$SETUP['start_time'];
					$end_time=$SETUP['end_time']; 
					$paper_setup['timer_mode']=0; //�@�߱ĭӧO�p��			  
 			  } else {
					$start_time=$paper_setup['start_time'];
					$end_time=$paper_setup['end_time']; 		  
 			  }
 //�ˬd�O�_�Ҹծɬq��
 		$StartSec=date("U",mktime(substr($start_time,11,2),substr($start_time,14,2),substr($start_time,17,2),substr($start_time,5,2),substr($start_time,8,2),substr($start_time,0,4)));
		$EndSec=date("U",mktime(substr($end_time,11,2),substr($end_time,14,2),substr($start_time,17,2),substr($end_time,5,2),substr($end_time,8,2),substr($end_time,0,4)));
  if ($nowsec<$StartSec or $nowsec>$EndSec) {
  	echo "<br>����ɶ��G$start_time - $end_time <br> �{�b���O����ɶ��I�����}!!!";
    exit();
  }
  
 //timer�ɶ�
 if ($paper_setup['timer_mode']==1) {
	//�P�ɵ���  
  $timer=(($paper_setup['timer']*60)+$StartSec)-$nowsec;          
 } else {
 //�ӧO�p�� 
  $timer=$paper_setup['timer']*60;  //��
 } 
  
  
 //�ˬd�O�_�w����A�O�_���\���л��
 			 $sql="select * from resit_exam_score where student_sn='".$STUD['student_sn']."' and paper_sn='".$paper_setup['sn']."'";
 			 $res=$CONN->Execute($sql);
 			 if ($res->RecordCount()==0) {
 				  echo "<br>�A�S���b�ɦҦW���, �гq���ʦҦѮv���s�]�w�I";
 				  exit(); 	
 			 }
 			 $resit_data=$res->fetchRow();  //array
  			if ($resit_data['complete']) {
 				  echo "<br>�A�w�g�ҹL�F�I";
 				  exit(); 				  
 				}
 				if ($resit_data['entrance'] and $paper_setup['double_papers']==0) {
  				echo "<br>�A�w�g��L���F�I";
 				  exit(); 
 			  } else {
 			  	//���\���л�ΨS��L, ���R�� ,�ΥH���� score �� sn ,�ϦP�@�H���ը�, ���̵L�k���e��̧@��
 			  	$org_score=$resit_data['org_score'];		//��l����
 			  	$subjects=$resit_data['subjects'];			//���ή檺����
 			  	$sql="delete from resit_exam_score where student_sn='".$STUD['student_sn']."' and paper_sn='".$paper_setup['sn']."'";
 			    $res=$CONN->Execute($sql);
 			  	$sql="insert into resit_exam_score (student_sn,paper_sn,org_score,subjects) values ('".$STUD['student_sn']."','".$paper_setup['sn']."','$org_score','$subjects')";
 			    $res=$CONN->Execute($sql) or die ('���ئ��Z��Ƶo�Ϳ��~! SQL='.$sql);
 			 		$sql="select * from resit_exam_score where student_sn='".$STUD['student_sn']."' and paper_sn='".$paper_setup['sn']."'";
 			 		$res=$CONN->Execute($sql);
 			 		$resit_data=$res->fetchRow();  //array
 			  }
 //=�w�����ˬd����====================================================================================
 //�}�l�X�D, �X�D����إ߰򥻸��, ��Ū�� sn ,�x�s�ɤ�� sn,paper_sn,student_sn ,
  
 //���o score_sn
 $score_sn=$resit_data['sn']; 
 //Ū�����D�̤j��
 $sql="select count(*) as num from `resit_exam_items` where paper_sn='".$paper_setup['sn']."'";
 $res=$CONN->Execute($sql);
 $Max_items=$res->fields['num'];
 if ($Max_items==0) {
   echo "<br>�@��I�Ѯv�n���ѤF�X�D�I";
   exit();
 }
 
 //�}�l�X�D, �D�ب��O���b $item_form
 //�H���X�D
	$i=0;  								//�R�D�p�ƾ�
	$item_form='';  			//���D���
	$test_items=array();	//���D�y�����O��
 if ($paper_setup['item_mode']==0) {
  //�ˬd�D�w�ƶq
 		$test_count=$paper_setup['items'];
 		if ($test_count>$Max_items) {
 		  echo "�@��! �Ѯv�R�D���ƶq����! �гq���Ѯv�[��R�D!!!";
 		  exit();
 		}
 		if ($test_count==0) $test_count=$Max_items;
 		
 	//�H�����D�}�l
 	//�X�D�y���� (�Q�� test_items array �O��) ,�ǥͪ��@���h�Q�� test_answers array �O��
 			$sql="SELECT * FROM `resit_exam_items` where paper_sn='".$paper_setup['sn']."' ORDER BY RAND() LIMIT 0,$test_count"; 
 			$res=$CONN->Execute($sql);
 	//�}�l�O��
 			while ($row=$res->fetchRow()) {	
				$i++;
				$test_items[$i]=$row['sn'];  //�O�����D�y����
				$item_style=make_item_style($i,$row);
				$item_form.="
					<tr>
						<td>
							<hr>
						</td>
					</tr>
					<tr>
						<td>$item_style</td>
					</tr>
				";
 			} // end while
 				$item_form.="<tr><td><hr></td></tr>";
 				$item_form="<table border='0'>".$item_form."</table>";
   
 //�̤���X�D
 } else {
 	
 	//Ū�������U�������X�D��
 	  $subject_items=get_scope_subject_items($seme_year_seme,$Cyear,$scope);
 	//�ˬd���ͨ��X�Ӥ��줣�ή�
 	  //Ū���ǥͩҦ����즨�Z
 	  $ss_score=array();
  	  $sql_ss_score="select ss_id,ss_score from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn='".$STUD['student_sn']."'";
			$res_ss_score=$CONN->Execute($sql_ss_score) or die($sql_ss_score);
			
			while ($row_ss_score=$res_ss_score->fetchRow()) {
			  $ss_id=$row_ss_score['ss_id'];
			  $ss_score[$ss_id]=$row_ss_score['ss_score'];
			}
 	
 	//�ˬd�U������D������
 				$stop=0;		
 				$stop_info="";		
 				//���ͭY���Z�Žҵ{ , ���� ALL �ҵ{ ������,�]�����D�u��@��, �Y��줣�ή�,�Ҧ����쳣�n�� 2016.01.06	      
	      foreach ($scope_subject['ALL'][$scope] as $subject_id=>$V) {    
	     	  $now_subject_ss_id=$V['ss_id'];
					//������Y���ή�
					if ($ss_score[$now_subject_ss_id]<60) {
					  if ($subject_items[$subject_id]>$V['items']) {
					    $stop_info.=$V['subject']."���X".$subject_items[$subject_id]."�D, �ը��w����".$V['items']."�D�I<br>";
					    $stop=1;
					  } else {
					   //�������D�ư�, �}�l�H�����X��������D
					   $test_count=$subject_items[$subject_id]; //���R�D��
					   //�X�D�Ƴ]�w >0 �~���D
					   if ($test_count>0) {
 							//�X�D�y���� (�Q�� test_items array �O��) ,�ǥͪ��@���h�Q�� test_answers array �O��
 							$sql="SELECT * FROM `resit_exam_items` where paper_sn='".$paper_setup['sn']."' and subject='".$V['subject']."' ORDER BY RAND() LIMIT 0,$test_count"; 
 							$res=$CONN->Execute($sql);
 							//�}�l�O�� 							
 							while ($row=$res->fetchRow()) {	
								$i++;
								$test_items[$i]=$row['sn'];  //�O�����D�y����
								$item_style=make_item_style($i,$row);
								$item_form.="
										<tr>
											<td>
											<hr>
											</td>
										</tr>
										<tr>
											<td>$item_style</td>
										</tr>
										";
 							} // end while				  
 						 } // end if ($test_count>0)
					  } // end if else $subject_items[$subject_id]>$V['items']
					} // end if ($ss_score[$now_subject_ss_id]<60)
	      }  // end foreach
 	      
 	      if ($stop==1) {
 	        echo $stop_info;
 	        echo "<br>�гq���ʦҦѮv!";
 	        exit();
 	      } else {
 	        //�X���ը�
 	       	$item_form.="<tr><td><hr></td></tr>";
 					$item_form="<table border='0'>".$item_form."</table>";
 	      }
   
 }  // end if else $paper_setup['item_mode']
 
  
 //�O������ɶ�
 $entrance=1;
 $entrance_time=date("Y-m-d H:i:s");
 $paper_sn=$paper_setup['sn'];
 $student_sn=$STUD['student_sn'];
 //$test_items �R�D���D�� , array
 $items=serialize($test_items);

 $sql="update resit_exam_score set items='$items',entrance='1',entrance_time='$entrance_time' where sn='$score_sn'";

 $res=$CONN->Execute($sql) or die('�O���ը���ƥ���! SQL='.$sql);

 $main= "<input type='hidden' name='score_sn' value='$score_sn'>
 <input type='hidden' name='paper_sn' value='$paper_sn'>
 <input type='hidden' name='exam_items' value='$test_count'>".$main.$item_form;
 
 $main.="\n
  <Script>
   var intsec=".$timer.";\n
   checktime();
  </Script>
 "; 
   
 echo $main;
 
 exit(); 

} // end if start_test

//���
if ($_POST['act']=='start_test_submit') {
 $score_sn=$_POST['score_sn'];
 $paper_sn=$_POST['paper_sn'];
 
 $sql="select * from resit_paper_setup where sn='$paper_sn'";
 $res=$CONN->Execute($sql) or die('Ū���ը��]�w���~! SQL='.$sql);
 $top_marks=$res->fields['top_marks'];
 
 $answers=$_POST['answers'];  // array
 $complete=1;
 $complete_time=date("Y-m-d H:i:s");
 
 $correct=0;
 //���X���Z�O��(���w�����D�}�C)
 $sql="select * from resit_exam_score where sn='$score_sn' and student_sn='".$STUD['student_sn']."' and paper_sn='$paper_sn'";
 $res=$CONN->Execute($sql) or die('Ū���@�����D�O������! SQL='.$sql);
 if ($res->recordcount()) {
 	  $row=$res->fetchRow();
    $items=unserialize($row['items']);
    $test_count=count($items);  				//�D��
    for($i=1;$i<=$test_count;$i++) {
      $sql_ans="select answer from `resit_exam_items` where sn='".$items[$i]."'";
      $res_ans=$CONN->Execute($sql_ans);
      $answer=$res_ans->fields['answer'];
      if ($answer==$answers[$i]) $correct++;
    } // end for
    
    //����
    $score=($correct/$test_count)*$top_marks;
    $score=round($score,2);
    
    $write_answers=serialize($answers);
    
    $sql="update `resit_exam_score` set score='$score',answers='$write_answers',complete='$complete',complete_time='$complete_time' where sn='$score_sn' and student_sn='".$STUD['student_sn']."' and paper_sn='$paper_sn'";
    $res=$CONN->Execute($sql) or die('�g�J�@���Φ��Z�O������! SQL='.$sql);
    //echo "�o".round($score,2)."��";
    //exit();
    
 } else {
    echo "�o�ͤF���~! �L�k�q�@�����D�O�����ѵ�!<br>";
    echo "SQL=".$sql;
    exit();
 }
 

} // end if ($_POST['act']=='start_test_submit')



/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();
//�C�X���
echo $tool_bar;
?>
<style type="text/css">
 .bg_0 { background-color:#FFFFFF  }
 .bg_Click { background-color:#FFCC99  }
 .bg_Over { background-color:#CCFFFF  }

 #st {
 position: absolute;  /*�����m*/
 z-index:99;  /*�קK�Q��L�B��div�\��*/
 width:80px;  /*DIV���e�A�г]�w����*/
 }
</style>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="scope" value="">

<?php
 echo "�ɦҾǴ��O�G".$C_year_seme."�A";
 echo "��e�Z�Ůy���G".$CLASS_name." ".$STUD['seme_num']."�� ".$STUD['stud_name']."<br>";
if ($_POST['act']=='report_test') {
 //���O
 $scope=$_POST['scope'];
 //���o�����ɦҳ]�w
 $paper_setup=get_paper_sn($seme_year_seme,$Cyear,$scope);
 $sql="select * from resit_exam_score where student_sn='".$STUD['student_sn']."' and paper_sn='".$paper_setup['sn']."'";
 $res=$CONN->Execute($sql);
 $resit_data=$res->fetchRow();  //array
 ?>
  <table border="1"style=" border-collapse:collapse;font-size:10pt" bordercolor="#111111" cellpadding="3" width="100%">
    <tr bgcolor="FFCCCC">
    	<td>�ɦһ��O�G<?php echo $link_ss[$scope]; ?></td>
    	<td width="150" align="center">�o���G<?php echo $resit_data['score'];?></td>
    </tr>
  </table>
 <?php
 if ($paper_setup['relay_answer']=='0') {
   echo "�����ը����}��\���I";
   exit();
 }
 
$sql="select a.*,b.stud_id,b.stud_name,b.curr_class_num from resit_exam_score a,stud_base b where a.paper_sn='".$paper_setup['sn']."' and a.student_sn='".$STUD['student_sn']."' and a.student_sn=b.student_sn";
$res=$CONN->Execute($sql) or die ("Ū���ը���Ƶo�Ϳ��~! SQL=".$sql);
$row=$res->fetchRow();

$curr_class_num=$row['curr_class_num'];
$seme_class=substr($curr_class_num,0,3);
$seme_num=substr($curr_class_num,-2);
$items=unserialize($row['items']);
$answers=unserialize($row['answers']);
?>
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  	<input type="button" id="list_paper_end" value="�����˵�" onclick="window.location.href='se_resit.php'">
 	  	<table border='0'>
 	  	
		<?php
		$i=0;
    foreach ($items as $k=>$v) {
    	$i++;
				?>
				<tr><td><hr></td></tr>
				<tr>
					<td><?php echo show_item($v,2,$answers[$k],$i);?></td>
				</tr>
				<?php 			  
    
    } // end foreach
		?>
		</table>
 	  </span>
 	  </td>
 	</tr>
 </table> 
<?php
 exit();
} // end if


//���i������ܮɪ��e��
?>
 <div id="show_timer" style="display:none">
  <table border="1"style=" border-collapse:collapse;font-size:10pt" bordercolor="#111111" cellpadding="3" width="100%">
    <tr bgcolor="FFCCCC">
    	<td width="100%">
    		<table border="0" width="100%">
    		  <tr>
    		    <td width="200"></td>
    				<td align="center">�Ѿl�ɶ��G<input type="text" name="quiztimer" value="" size="10"><font color=red> (�`�N�I�ɶ���۰ʥ��)</font></td>
      		  <td width="200" align="right">�r��j�p�G<a href="javascript:FontZoom('small')">�Y�p</a> <a href="javascript:FontZoom('big')">��j</a></td>
    		  </tr>
    		</table>
      	</td>
    </tr>
  </table>
</div>
<div id="st" style="display:none;left: 0px; top: 300px;">
  <table bgcolor="#FFCCCC" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" bordercolor="#111111" width="80" name="formtable" id="formtable">
  <tr>
    <td width="100%" align="center" style="font-size:9pt;color:#0000FF">�Ѿl�ɶ�</td>
  </tr>
  <tr>
    <td width="100%" align="center">
    	<input type="text" name="timer1" id="timer1" size="5" style="text-align: center; color: #FF6060; background-color: #D7FFEB" value=""><br>
    	<input type="button" value="�ߧY���" name="submit1" class="start_test_submit" style="font-size:10 px;"><br>
			<a href="javascript:FontZoom('small')">�m</a>�@<a href="javascript:FontZoom('big')">�n</a>
�@	</td>
  </tr>
	</table>
 </div>
 <table border="0">
  <tr>
  	<!--���e�� -->
    <td valign="top">
    	<div id="show_top">
 	<table border="1" style="border-collapse:collapse;font-size:10pt" bordercolor="#111111" cellpadding="3">
 		<tr bgcolor="#FFCCFF">
 			<td align='center'>���O</td>
 			<td align='center'>���Z</td>
 			<td align='center'>�O�_�ݸɦ�</td>
 			<td align='center'>����}�l�ɶ�</td>
 			<td align='center'>��������ɶ�</td>
 			<td align='center'>�ɦҦ��Z</td>
 			<td align='center'>�ɦҧ����ɶ�</td>
 			<td align='center'>�ާ@</td>
 		</tr>
 		<?php
 		foreach ($ss_link as $k=>$v) {
 			//$v �����O
 			//���o�����ɦҳ]�w
 			 $paper_setup=get_paper_sn($seme_year_seme,$Cyear,$v);
 			 //�Ҹծɬq�̾Ǵ��]�w�θը��ӧO�]�w
 			  if ($SETUP['paper_mode']) {
					$start_time=$SETUP['start_time'];
					$end_time=$SETUP['end_time']; 			  
 			  } else {
					$start_time=$paper_setup['start_time'];
					$end_time=$paper_setup['end_time']; 		  
 			  }

 			// �O�_�ή�, �p�G���ή�, ���ˬd�O�_�ѥ[�L�ɦ�, �Y�ѥ[�L, ����A��
 			if (${$v}<60) {
 			 $show1='<font color=red>�ݭn</font>';
     
 			 //���o resit_exam_score �̥����ǥͦ��Z
 			 $sql="select * from resit_exam_score where student_sn='".$STUD['student_sn']."' and paper_sn='".$paper_setup['sn']."'";
 			 $res=$CONN->Execute($sql);
 			 $resit_data=$res->fetchRow();  //array

 			 //�ˬd�O�_�ҧ��λ�������Ҹդ�
 			 if ($resit_data['complete']) {
 			 //���ɦҧ���
 			   $show2=$resit_data['score'];  			//�ɦҦ��Z
 			   $show3=$resit_data['update_time'];  //�ɦҧ����ɶ�
 			   //���ҧ��A�ˬd�O�_�i�d�ݸը�
 			   if ($paper_setup['relay_answer']==1) {
 			    $show4="<input type='button' style='color:#0000FF' value='�˵��@��' class='report_test' id='".$v."'>";
 			   } else {
 			   	$show2="���}��";
 			    $show4="<font size='2'>���}��\��</font>";
 			   }
 			 } elseif ($resit_data['entrance'] and $paper_setup['double_papers']==0) {
 			 //�٨S�ɦҧ�, �O�_���
  			 $show2="-";  //�ɦҦ��Z
 			   $show3="-";  //�ɦҧ����ɶ�
 			 	 $show4="<font size=''2 color='red'>�w����A�Y�]����ݭ��s����A�гq���ʦҦѮv</font>";
 			 } else {
 			 //�����, �ˬd�ɶ��O�_��F
				//�i�Ҹծɬq �ɤ�����~ 2015-01-11 12:12:12
				 $StartSec=date("U",mktime(substr($start_time,11,2),substr($start_time,14,2),0,substr($start_time,5,2),substr($start_time,8,2),substr($start_time,0,4)));
				 $EndSec=date("U",mktime(substr($end_time,11,2),substr($end_time,14,2),0,substr($end_time,5,2),substr($end_time,8,2),substr($end_time,0,4)));
  			 $show2="-";  //�ɦҦ��Z
 			   $show3="-";  //�ɦҧ����ɶ�
				 //�ˬd�ɬq
				 	if ($nowsec>=$StartSec and $nowsec<=$EndSec) {
				 	  //�ɬq�� 
				 	  $show4="<input type='button' value='����Ҹ�' class='start_test' id='".$v."'>";
				 	} elseif ($nowsec<$StartSec) {
				 		//�ɶ�����
				 	  $show4="<font color=blue>�Ҹծɶ�����</font>";
				 	} else {
				 		//�ɶ��w�L
				 	  $show4="<font color=blue>�Ҹծɶ��w�L</font>";
				 	}	//end if �ɬq�ˬd		 		 
 			 } //end if �ˬd�O�_�ҧ��λ�������Ҹդ� 			 
 			} else {
 			 $show1='���ݭn';
 			 $show2='-';
 			 $show3='-';
 			 $show4='-';
 			} // end if �ˬd�O�_�ή�
 		  ?>
 		  <tr>
 		    <td><?php echo $k;?></td>
 		    <td align="center"><?php echo ${$v};?></td>
 		    <td align="center"><?php echo $show1;?></td>
 		    <td align="center"><?php echo $start_time;?></td>
 		    <td align="center"><?php echo $end_time;?></td>
 		    <td align="center"><?php echo $show2;?></td>
 		    <td align="center"><?php echo $show3;?></td>
 		    <td align="center"><?php echo $show4;?></td>
 		  </tr>
 		  <?php
 		  } // end foreach
 		  ?>
  	</table>
  	<br>
  	
  	���ɦҫ�Ǵ����Z�O�_�X��A�Цb�Ǯնi�榨�Z����ä��i�i�d�߫�A<br>�@�A�g��<font color=blue>�u<a href="../stud_eduh_self/"><u>�ǥ͸�Ʀ۫�</u></a>���ǲߦ��G�ίS���{���ڪ��ǲߪ�{�v</font>�d�ߦU�Ǵ��`���Z�C
  	
 	</div>
    </td>
  </tr>
 </table>
 <div id="show_buttom">
 </div>
 <table border="0">
   	<tr id='start_test_submit_button' style="display:none">
			<td>
			  <input type="button" class="start_test_submit" value="���">
			</td>
   	</tr>
 </table> 	

</form>
<?php
//  --�{���ɧ�
foot();
?>

<script>

//�w�q��ƦC�Ƥηƹ����ШϥΪ� class id
 var intALL=500;
 var strMouseOver='bg_Over';
 var strMouseClick='bg_Click';
 
 //�w�q�}�C�Ϋإ߹w�]��
 var intTR=new Array(intALL); //�ΥH�O���O�_�w���U
 var strTR=new Array(intALL); //�ΥH�O����l�� tr �� class �� 
 
 var font_size=12;
 
 for (i=1;i<=intALL;i++) {
   intTR[i]=0;
 }


//�}�l����
$(".start_test").click(function(){
	var scope=$(this).attr("id");
	var act='start_test';
	
  $.ajax({
   	type: "post",
    url: 'se_resit.php',
    data: { act:act,scope:scope },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~!');
    },
    success: function(response) {
    	show_top.style.display='none';    	
    	$('#show_buttom').html(response);
      $('#show_buttom').fadeIn(); 
      if (response.substr(0,4)!='<br>') {
		   //�}�l
        start_test_submit_button.style.display='block';
				show_timer.style.display='block';	
				st.style.display='block';		   
		  }
    } // end success
	});   // end $.ajax	
})

//�\��
$(".report_test").click(function(){
	var scope=$(this).attr("id");
	var act='report_test';
  
  document.myform.scope.value=scope;
  document.myform.act.value=act;
  
  document.myform.submit();
	
})


//���
$(".start_test_submit").click(function(){
	
	//�ˬd�O�_�����@��
	 var i=0;
   var a=0;
   var ok=0;
   var exam_items=document.myform.exam_items.value;
  
  		while (i < document.myform.elements.length)  {
    		if (document.myform.elements[i].name.substr(0,7)=='answers') {
      		if (document.myform.elements[i].checked) a++;
    		}
    		i++;
  		}
   
  if (a<exam_items) {
   is_confirmed = confirm('�z���D�إ��@����!! \n���@�� '+exam_items+' �D, �A�u�@�� '+a+' �D,\n�z�T�w�n����F�ܡH');
    if (is_confirmed) {
     ok=1;
    }else{
     ok=0;
    }
  } else {
   ok=1;
  }

  if (ok==1) {
  	document.myform.act.value='start_test_submit';
  	document.myform.submit();
  } else {
    return false;
  }

})


//���U�ƹ������
 function ClickLine(w,c) {
 	if (intTR[c]==0) {
  document.getElementById(w).className = strMouseClick;
	 intTR[c]=1;
 	} else {
   document.getElementById(w).className = strTR[c];
   intTR[c]=0;
  }
 }
 
//�ƹ����b�W����
 function OverLine(w,c) {
   if (intTR[c]==0) {
 	  strTR[c]=document.getElementById(w).className;
   }
   document.getElementById(w).className = strMouseOver;  
 }
 
 //�ƹ����}��
 function OutLine(w,c) {
 	if (intTR[c]==0) {
   document.getElementById(w).className = strTR[c];
 	} else {
   document.getElementById(w).className = strMouseClick;
  }
 } 

function checktime() {
intsec=intsec-1;
if (intsec>0) {
	m=Math.floor(intsec/60);
	sec=intsec%60;
	if (sec<10) sec='0'+sec;
	show=m+':'+sec;
	document.myform.quiztimer.value=show;
	document.myform.timer1.value=show;
}
//if (intsec==180) window.alert('�ɶ��ѤU3�����o! �Ъ`�N�I �ɶ���|�۰ʥ��!'); 
 if (intsec<=0) {
  document.myform.act.value='start_test_submit';
  document.myform.submit();
 }
 TimerID=setTimeout("checktime()",1000);
}

$(function(){ 
	var div_id='st';  //�ۭqDiv�϶�id�W�� 
	var seat ='up'; //down=���H�k�U��   up=���H�k�W�� 
	var nowTop2 =0; 
		w = $(window); 
	div_left=48;
	$("#"+div_id).css('left', div_left); 
  $("#"+div_id).css('top', 280); 

   w.scroll(function(){ 
    nowHight =parseInt(document.body.scrollTop, 10) ||parseInt(document.documentElement.scrollTop, 10); 
    nowTop =parseInt(document.body.scrollTop, 10) ||parseInt(document.documentElement.scrollTop, 10); 
    $("#"+div_id).css('top', nowTop+280); 
    nowTop2 =nowTop; 
   }); 
}); 

function FontZoom(size)
 {
 	 
   var the_element = document.getElementsByTagName("table");
   var components = new Array();
   //alert(the_element.length);
   var j=0;
   for(i = 0; i < the_element.length; i++) {
     attr = the_element[i].getAttribute("class");
     if(attr == "test_item") {
       components[j] = the_element[i];
       j++;
     }
   }
   
   if (size=='small' && font_size>12) font_size=font_size-2;
   if (size=='big' && font_size<24) font_size=font_size+2;
   
   for (i = 0; i < components.length; i++)
     components[i].style.fontSize = font_size+'pt';
     
   
 }
   
   
 
 </script>

</script>