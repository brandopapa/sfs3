<?php	
header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
require_once "../../include/sfs_case_excel.php";

//���ҬO�_�n�J
sfs_check(); 

$s=get_school_base();
$school_name=$s['sch_cname']; //�ǮզW��

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ɦҾǴ��O�]�w
$sql="select * from resit_seme_setup limit 1";
$res=$CONN->Execute($sql);
$SETUP=$res->fetchrow();
$C_year_seme=substr($SETUP['now_year_seme'],0,3)."�Ǧ~�� �� ".substr($SETUP['now_year_seme'],-1)." �Ǵ�";


//�ثe�B�z���Ǧ~�Ǵ�
$sel_year = substr($SETUP['now_year_seme'],0,3);
$sel_seme = substr($SETUP['now_year_seme'],-1);

//�w��w���~��
$Cyear=$_POST['Cyear'];
 		if($Cyear>2){
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
		} else {
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
		}

//�T�{�i�ɦҪ��~��
//�Ҧp: �H�ꤤ�Ө�, �{���Ǧ~ 103 , �Y�ҥ� 102�Ǧ~, �u��ҸӦ~���@�~�ũM�G�~��, �]���T�~�Ťw���~
// �ꤤ�ΰ�p�P�w $IS_JHORES=6 (�ꤤ) , $IS_JHORES=0 (��p)
if ($IS_JHORES==6) {
	$SY=$curr_year-3;   //�H103����, ����I�� 100
} else {
	$SY=$curr_year-6;   //�H103����, ����I�� 97
}

//�s�@�~�ſ��
$sy_circle=$sel_year-$SY;	
$now_cy=3-$sy_circle;

// ajax �˵��w�ɦҦW��
if ($_POST['act']=='html_resit_list') {
	$S['go']='�ɦҤ�';
	$S['ready']='���ɦ�';
	$S['tested']='�ɦҧ�';
 	//���O
 	// $Cyesr : �~��
	$scope=$_POST['scope'];
	$opt1=$_POST['opt1'];
	$seme_year_seme=$SETUP['now_year_seme'];
  //����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($curr_year_seme);
	
	//Ū���w�ɦҦW��
	switch ($opt1) {
	  case 'ready':
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num,c.email_pass from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and entrance='0' and complete='0' order by curr_class_num";
	  break;
	  case 'go':
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num,c.email_pass from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and entrance='1' and complete='0' order by curr_class_num";	  
	  break;
	  case 'tested':
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num,c.email_pass from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and complete='1' order by curr_class_num";
	  break;

	}
	$res=$CONN->Execute($sql) or die($sql);
	while ($row=$res->FetchRow()) {
		$student_sn=$row['student_sn'];
		$curr_class_num=$row['curr_class_num'];
		$seme_class=substr($curr_class_num,0,3);
		$seme_num=substr($curr_class_num,-2);
		
		$main.="
			<tr>
	     <td style='font-size:10pt' align='center'>".$class_base[$seme_class]."</td>
	     <td style='font-size:10pt' align='center'>".$seme_num."</td>
	     <td style='font-size:10pt' align='center'>".$row['stud_name']."</td>
	     <td style='font-size:10pt' align='center'>".$row['org_score']."</td>
	     ";
	     
	   if ($opt1=="ready") {
			$main.="
			<td style='font-size:9pt'>".$row['subjects']."</td>	   
			<td style='font-size:9pt'>".$row['stud_id']."</td>	
			<td style='font-size:9pt'>".$row['email_pass'];	  
	   } elseif ($opt1=="go") {
	  	$main.="   
			 <td style='font-size:9pt'>".$row['subjects']."</td>	   
	     <td style='font-size:9pt'>".$row['entrance_time'];		
	   } else {
	  	$main.="   
	     <td style='font-size:9pt'>".$row['entrance_time']."</td>		
	  	 <td style='font-size:9pt'>".$row['complete_time']."</td>
	     <td style='font-size:10pt".(($row['score']<60)?";color:red":"")."' align='center'>".$row['score'];
		 }

		if ($row['complete']==1) {
		 $main.=" <a href='resit_list_paper.php?seme_year_seme=$seme_year_seme&Cyear=$Cyear&scope=$scope&sn=".$row['sn']."' target='_blank' title='�s���m".$row['stud_name']."�n���@��'><img src='images/filefind.png'></a></td>
			</tr>";
		} else {
		 $main.="</td>
			</tr>";
		}
		

	}
	  $title="	  
	 <table border=\"0\" width=\"100%\" cellspacing=\"3\" cellpadding=\"2\">
  	<tr>
   	  <td colspan='5' style='color:#800000'><b>".$link_ss[$scope]."���</b> - [<font color=blue>".$S[$opt1]."</font>]�W��</td>
   	</tr>
	   <tr bgcolor=\"#FFCCCC\">
	     <td style='font-size:10pt'>�Z��</td>
	     <td style='font-size:10pt'>�y��</td>
	     <td style='font-size:10pt'>�m�W</td>
	     <td style='font-size:10pt'>�즨�Z</td>";
	  if ($opt1=="ready") {
	  	$title.="
	  	<td style='font-size:10pt'>���ή����</td>
	  	<td style='font-size:10pt'>�Ǹ�</td>
	  	<td style='font-size:10pt'>�n�J�K�X</td>
	  	";
	  } elseif ($opt1=="go") {
	  	$title.="	 
	  	 <td style='font-size:10pt'>���ή����</td>    
	     <td style='font-size:10pt'>����ɶ�</td>
	     ";
	  }else {
	  	$title.="	     
	  	 <td style='font-size:10pt'>����ɶ�</td>
	     <td style='font-size:10pt'>�����ɶ�</td>
	     <td style='font-size:10pt'>�ɦҦ��Z</td>
			";  
	  }	
	     
     $title.="</tr>";
	   
	 $main=$title.$main."</table>"; 
	  
 
  echo $main;
  exit();

}

//�ץX���ή�W��
if ($_POST['act']=='output_resit_name') {
  
	//���O
	$scope=$_POST['opt1'];
	
  $seme_year_seme=$SETUP['now_year_seme'];
  $year=substr($seme_year_seme,0,3);
  $semester=substr($seme_year_seme,3,1);
 //����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($curr_year_seme);
	$stud_sn=array();
	
	//������Ǵ��Ҧ��ҵ{�]�w(���Ф���)
	$scope_subject=get_year_seme_scope($year,$semester,$Cyear);

  //�H���~�׾ǥ͸�ƥh�� student_sn , �H�K�줣���Ӥ~��J���ǥ� student_sn	
	$Now_Cyear=$Cyear+$now_cy;
	$query="select a.student_sn,a.stud_id,a.stud_name,a.curr_class_num,a.stud_addr_2,a.stud_tel_2,a.stud_tel_3,a.addr_zip,c.guardian_name from stud_base a,stud_seme b,stud_domicile c where a.student_sn=b.student_sn and b.student_sn=c.student_sn and b.seme_year_seme='$curr_year_seme' and a.curr_class_num like '".$Now_Cyear."%' and stud_study_cond in ('0','15') order by curr_class_num";
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
		
		$student_data[$student_sn]['stud_name']=$res->fields['stud_name'];
		$student_data[$student_sn]['stud_id']=$res->fields['stud_id'];
		$student_data[$student_sn]['stud_addr_2']=$res->fields['stud_addr_2'];
		$student_data[$student_sn]['stud_tel_2']=$res->fields['stud_tel_2'];
		$student_data[$student_sn]['stud_tel_3']=$res->fields['stud_tel_3'];
		$student_data[$student_sn]['addr_zip']=$res->fields['addr_zip'];
		$student_data[$student_sn]['guardian_name']=$res->fields['guardian_name'];
		
		$student_data[$student_sn]['class_name']=$class_base[$seme_class];

		$res->MoveNext();
	} // end while
	
	$semes[]=$seme_year_seme;  //�ثe�Ǵ�
	//�����즨�Z
	$sel_year=substr($seme_year_seme,0,3);
	$sel_seme=substr($seme_year_seme,-1);

	$fin_score=cal_fin_score($stud_sn,$semes,"",$strs,1);

 //�������
 if ($scope=="ALL") {
  
  //�ץX
  if ($_POST['opt2']=='') {
   $x=new sfs_xls();
	 $x->setUTF8();
	 $x->filename=substr($seme_year_seme,0,3)."�Ǧ~�ײ�".substr($seme_year_seme,-1).'�Ǵ����ɦҾǥͦW��.xls';
	 $x->setBorderStyle(1);
	 $x->addSheet("���ɦҦW��");
	 $x->items[0]=array('�Ǹ�','�ثe�Z��','�ثe�y��','�m�W','�y��','�ƾ�','�۵M','���|','����','����','��X','���ɦһ��','���ɦһ���','�w�ɦһ��','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�q�T�a�}');
  }
  
	foreach ($stud_sn as $student_sn) {
    
    
    //���o�ǥͷ�Ǵ����Z�Ůy�� , ���X $class_id (2016.01.06 �]���Z�Žҵ{)
    $sql_class_num="select seme_class from stud_seme where student_sn='".$student_sn."' and seme_year_seme='".$seme_year_seme."'";
 	  $res_class_num=$CONN->Execute($sql_class_num);
 	  if ($res_class_num->RecordCount()==1) {
 	    $seme_class=$res_class_num->fields['seme_class'];
     	$class_year=substr($seme_class,0,1);
     	$class_num=substr($seme_class,1,2);			  
	    $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$class_year,$class_num);
 	  } else {
 	    $seme_class="";
 	    $class_id="ALL";
 	  }
 	  
 	  
 	  //Ū���ǥͩҦ����즨�Z
 	  $ss_score=array();
  	  $sql_ss_score="select ss_id,ss_score from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn='$student_sn'";
			$res_ss_score=$CONN->Execute($sql_ss_score) or die($sql_ss_score);
			
			while ($row_ss_score=$res_ss_score->fetchRow()) {
			  $ss_id=$row_ss_score['ss_id'];
			  $ss_score[$ss_id]=$row_ss_score['ss_score'];
			}
	   
    //�ˬd�O�_�����@�줣�ή�
    $language=$math=$nature=$social=$health=$art=$complex="";
    $resit_scope=$resit_tested="";
	  $put_it=0;
	  $resit_number=0;
	  $memo=array();
	  foreach ($ss_link as $v=>$S) {
	  	${$S}=$fin_score[$student_sn][$S][$seme_year_seme]['score'];
	  	//�Y��줣�ή�, �ˬd����ӥ�
	   if ($fin_score[$student_sn][$S][$seme_year_seme]['score']<60) {
	     $put_it=1;
	     $resit_number++;
	     $resit_scope.="�i".$v;
	     
	     //Ū������
	     //���ͬO�_���Z�Žҵ{ , �Y�L�h�� ALL �ҵ{
	     $target_id=(count($scope_subject[$class_id][$S])>0)?$class_id:"ALL"; 
	     $resit_subject="";
	     if (count($scope_subject[$target_id][$S])>1) {
	      foreach ($scope_subject[$target_id][$S] as $V) {
    
	     	  $now_subject_ss_id=$V['ss_id'];
					if ($ss_score[$now_subject_ss_id]<60) {
					  $resit_subject.=$V['subject'].",";  //���줤��W
						/* 2015.03.22 �]�����s�ư��D�A�������ҦѮv�����@���W���J
					  //Ū���Ѯv���ҦѮv
		        if ($seme_class) {
		        	$class_year=substr($seme_class,0,1);
		        	$class_num=substr($seme_class,1,2);			  
					    $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$class_year,$class_num);
					    $sql_subject_teacher="select teacher_sn from score_course where class_id='$class_id' and ss_id='$now_subject_ss_id'";
							$res_subject_teacher=$CONN->Execute($sql_subject_teacher);
							$teacher_sn=$res_subject_teacher->fields['teacher_sn'];
							$subject_teacher=get_teacher_name($teacher_sn);
					  } else {
					    $subject_teacher="��J";   //��ǥ͡A�L����Ѯv
					  }
					  */
					}
	      }  // end foreach
	      $memo[$S]="<font size=1>".substr($resit_subject,0,strlen($resit_subject)-1)."</font>";
				$resit_subject="(".substr($resit_subject,0,strlen($resit_subject)-1).")";
	     } else {
	       $memo[$S]="<font size=1>".$v."</font>";
	     }
	     $resit_scope.=$resit_subject."�j";
	   } else {
	    $memo[$S]="�ή�";
	   }
	   //�w�ɦ�
	   	$sql="select a.score from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$S' and a.complete='1'";
			$res=$CONN->Execute($sql) or die($sql);
			if ($res->recordcount()) {
	      $resit_tested.="�i".$v."�j";
		  }
	  }
	  
	  if ($put_it==1) {
			if ($_POST['opt2']=='') {
			 $x->items[]=array($student_data[$student_sn]['stud_id'],$student_data[$student_sn]['class_name'],$student_data[$student_sn]['seme_num'],$student_data[$student_sn]['stud_name'],$language,$math,$nature,$social,$health,$art,$complex,$resit_scope,$resit_number,$resit_tested,$student_data[$student_sn]['guardian_name'],$student_data[$student_sn]['stud_tel_2'],$student_data[$student_sn]['stud_tel_3'],$student_data[$student_sn]['addr_zip'],$student_data[$student_sn]['stud_addr_2']);
  		} elseif ($_POST['opt2']=='print') {
  			
  			$main='  			
  			<TABLE style="border-collapse: collapse; margin: auto; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt �з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="9" style="font: 20pt �з���; font-weight: bold;">'.$school_name.'</TD>
		</TR>
        <TR style="height: 20pt;">
          <TD colSpan="9" style="font: 20pt �з���; font-weight: bold;"><span style="font-family: Times New Roman; font-weight: bold;">'.curr_year().'�Ǧ~�ײ�<span style="font-family: Times New Roman; font-weight: bold;">'.curr_seme().'�Ǵ��u�ɦ���q�v�q����</TD>
		</TR>
        <TR style="height: 20pt; font-size: 12pt;">
          <TD colSpan="9" style="font: 14pt �з���; text-align: left;"><BR>
		  ���B�̾ڱШ|���u����p�Ǥΰ�����Ǿǥͦ��Z���q�ǫh�v�ά����W�w��z�C<BR><BR>
		  �L�B�`�N�ƶ��G<BR>
			'.$_POST['note_list'].'
		  �ѡB�˵� �Q�l�̤J�ǥH�ӦU�Ǵ��C�j�ǲ߻�즨�Z�����A <B>�Q�l�̦�������<BR>
		  �@�@�쥼�F�ή�з�</B>�A�S�����q���ѳq���a���� �Q�l�̡A�q�Юa���@�P��U<BR>
		  �@�@���ɾǥͽҷ~�ǲߡA�H�� �Q�l�̸ɦ���q���Q�A�F�즨�Z�ή�зǡC<BR><BR>
		  �v�B�����ɦ���q���Ǵ��d�򬰡G'.substr($seme_year_seme,0,3).'�Ǧ~�� ��'.substr($seme_year_seme,-1).'�Ǵ��C<BR><BR>
		  ��B�Q�l�̸ӾǴ��ǲ߻�즨�Z����<BR><BR>
		  <span style="font-size: 18pt;">
		  '.$student_data[$student_sn]['class_name'].'</B></span><span style="font-size: 18pt;"><B> '.$student_data[$student_sn]['seme_num'].'</B></span> �� <span style="font-size: 18pt;"><B>'.$student_data[$student_sn]['stud_name'].'</B></span>
		   <BR>
		  </TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt; background-color: #EEEEEE;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" colspan="2">�ǲ߻��</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">�y��</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">�ƾ�</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">�۵M�P<br>�ͬ����</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">���|</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">���d�P<br>��|</TD>
          <TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;">���N�P<br>�H��</TD>
          <TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" >��X</TD>
		</TR>
    <TR style="height: 28pt;font-size: 16pt;">
			<TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 12pt;" colSpan="2">���Z</TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['language'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['math'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['nature'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['social'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['health'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['art'][$seme_year_seme]['score'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$fin_score[$student_sn]['complex'][$seme_year_seme]['score'].'</span></TD>
		</TR>
    <TR style="height: 28pt;font-size: 16pt;">
			<TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 12pt;" colSpan="2">�Ƶ�</TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['language'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['math'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['nature'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['social'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['health'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['art'].'</span></TD>
			<TD style="width:11%; border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">'.$memo['complex'].'</span></TD>
		</TR>
        <TR style="height: 0pt;">
          <TD style="border-top: windowtext 1.5pt solid;" colSpan="9"></TD>
		</TR>
        <TR style="height: 20pt; font-size: 12pt;">
          <TD colSpan="9" style="font: 14pt �з���; text-align: right;">�аȳB�@�@�q�W<BR>���إ��� '.(date('Y')-1911).' �~ '.date('m').' �� '.date('d').' ��</TD>
		</TR>		
		<TR>
		  <TD colSpan="9" style="height: 20pt; text-align: left;"></TD>
		</TR>
    <TR style="height: 20pt;">
       <TD colSpan="9" style="font: 18pt �з���; font-weight: bold; border-top: windowtext 0.75pt dashed;">
		  <BR><span style="font-family: Times New Roman; font-weight: bold;">'.curr_year().'</span>�Ǧ~�ײ�<span style="font-family: Times New Roman; font-weight: bold;">'.curr_seme().'</span>�Ǵ��u�ɦ���q�v�q���Ѯa���^���p
		  </TD>
		</TR>
        <TR style="height: 15pt; font-size: 12pt;">
          <TD colSpan="9" style="font: 14pt �з���; text-align: left;"><BR>
		  ���H�� <span style="font-size: 18pt;"><B>'.$student_data[$student_sn]['class_name'].'</B></span><span style="font-size: 18pt;"><B> '.$student_data[$student_sn]['seme_num'].'</B></span> �� <span style="font-size: 18pt;"><B>'.$student_data[$student_sn]['stud_name'].'</B></span> �ǥͮa���A����аȳB���u�ɦ���q�q���ѡv�A�w�ԲӾ\Ū�äF�Ѿǥ;ǲߪ��p�C<BR>
		  </TD>
		</TR>
        <TR style="height: 20pt; font-size: 12pt;">
          <TD colSpan="9" style="font: 14pt �з���; text-align: right;"><BR>
		  �a��ñ���G<U>�@�@�@�@�@�@�@�@�@</U>�]ñ�W�ɽ�ñ���W�^<BR>
		  </TD>
		</TR>
        <TR>
          <TD>&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
          <TD width="11%">&nbsp;</TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>';
  		 echo $main;
  		
  		}
  	} // end if
   } // end foreach 
   
  
 
 //��@���
 } else {
	$x=new sfs_xls();
	$x->setUTF8();
	$x->filename=$seme_year_seme.$link_ss[$scope].'���ή�ǥͦW��.xls';
	$x->setBorderStyle(1);
	$x->addSheet($link_ss[$scope]."���ή�");
	$x->items[0]=array('�Ǹ�','�ثe�Z��','�ثe�y��','�m�W');
	//Ū������
	$data_length=3;
	foreach ($scope_subject['ALL'][$scope] as $V) {
	 $data_length++;
	 $x->items[0][$data_length]=$V['subject'];
 	 $data_length++;
	 $x->items[0][$data_length]="���ұЮv";
	}
	$add_array=array('�Ǵ�����','�ɦҤ���','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�q�T�a�}');
	foreach ($add_array as $v) {
 	 $data_length++;
	 $x->items[0][$data_length]=$v;
	}

  $add_data_id=0;
	foreach ($stud_sn as $student_sn) {
		if ($fin_score[$student_sn][$scope][$seme_year_seme]['score']<60) {
			
		//���o�ǥͷ�Ǵ����Z�Ůy��
    $sql_class_num="select seme_class from stud_seme where student_sn='".$student_sn."' and seme_year_seme='".$seme_year_seme."'";
 	  $res_class_num=$CONN->Execute($sql_class_num);
 	  if ($res_class_num->RecordCount()==1) {
 	    $seme_class=$res_class_num->fields['seme_class'];
          $class_year=substr($seme_class,0,1);
          $class_num=substr($seme_class,1,2);
          $class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$class_year,$class_num);
 	  } else {
 	    $seme_class="";
 	  }
			
			//Ū���ǥͩҦ����즨�Z
 	    $ss_score=array();
  	  $sql_ss_score="select ss_id,ss_score from stud_seme_score where seme_year_seme='$seme_year_seme' and student_sn='$student_sn'";
			$res_ss_score=$CONN->Execute($sql_ss_score) or die($sql_ss_score);
			
			while ($row_ss_score=$res_ss_score->fetchRow()) {
			  $ss_id=$row_ss_score['ss_id'];
			  $ss_score[$ss_id]=$row_ss_score['ss_score'];
			}
			
			$add_data_id++;  //excel ���׭p�ơ@
			//���s�J�e4��
			$x->items[$add_data_id]=array($student_data[$student_sn]['stud_id'],$student_data[$student_sn]['class_name'],$student_data[$student_sn]['seme_num'],$student_data[$student_sn]['stud_name']);
			$data_length=3;
			//��J���즨�Z
            //2015.11.18 �ˬd�O�_�ӯZ�Ŧ��Z�Žҵ{
            $target_id=($scope_subject[$class_id][$scope]=='')?"ALL":$class_id;
			foreach ($scope_subject[$target_id][$scope] as $V) {
	     	  $now_subject_ss_id=$V['ss_id'];
					$score=$ss_score[$now_subject_ss_id];  //�������
					//Ū���Ѯv���ҦѮv
		            if ($seme_class) {
					    $sql_subject_teacher="select teacher_sn from score_course where class_id='$class_id' and ss_id='$now_subject_ss_id'";
						$res_subject_teacher=$CONN->Execute($sql_subject_teacher);
						$teacher_sn=$res_subject_teacher->fields['teacher_sn'];
						$subject_teacher=get_teacher_name($teacher_sn);
				    } else {
					    $subject_teacher="��J��";   //��ǥ͡A�L����Ѯv
				    } // end if ($seme_class)
	 			$data_length++;
	 			$x->items[$add_data_id][$data_length]=$score;
 	 			$data_length++;
	 			$x->items[$add_data_id][$data_length]=$subject_teacher;
					
	    }  // end foreach
	
			
    	//�O�_���ɦҦ��Z
			$sql="select a.* from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.complete='1'";
			$res=$CONN->Execute($sql) or die($sql);
			if ($res->recordcount()==0) {
			  $resit_score="";
			} else {
		    $resit_score=$res->fields['score'];		  
		  }
			//�ɤW�̫᪺���		  
			$add_array=array($fin_score[$student_sn][$scope][$seme_year_seme]['score'],$resit_score,$student_data[$student_sn]['guardian_name'],$student_data[$student_sn]['stud_tel_2'],$student_data[$student_sn]['stud_tel_3'],$student_data[$student_sn]['addr_zip'],$student_data[$student_sn]['stud_addr_2']);
			foreach ($add_array as $v) {
 	 			$data_length++;
	 			$x->items[$add_data_id][$data_length]=$v;
			} // end foreach

  	} // end if
  } // end foreach //�U�@��ǥ�
 } // end if $scope=='ALL'
 
  if ($_POST['opt2']=='') {
		$x->writeSheet();
		$x->process();
  }
  
  exit();

}  // end if �ץX���ή�W��


$class_year_list="
  <select size=\"1\" name=\"Cyear\" onchange=\"this.form.opt1.value='';this.form.opt2.value='';this.form.act.value='';this.form.submit()\">
   <option value=''>�п�ܦ~��</option>";
   for ($i=1;$i<=$sy_circle;$i++) {
    $CY=$i+$IS_JHORES;
    $NCY=$CY+$now_cy;
    $class_year_list.="<option value='$CY'".(($CY==$Cyear)?" selected":"").">".$school_kind_name[$CY]."�� (�ثe�NŪ".$school_kind_name[$NCY]."��)</option>";
   }    
$class_year_list.="
  </select>
";

// POST����檺�{��


//�p��U��줣�ή�H��
if ($Cyear!="") {
		if ($_POST['act']=='get_all_resit_name') {
		 $all_students=count_scope_fail($Cyear,$SETUP['now_year_seme'],$ss_link,$link_ss);
		 $INFO="�ӾǦ~�ǥ��`�� $all_students �H�A�w�۾Ǵ����Z��Ʈw����s�ɦҦW��!";		 
	  } 
	  	$seme_year_seme=$SETUP['now_year_seme'];
	   foreach ($ss_link as $scope) {
	   	//���ή�H��
	     $sql="select count(*) as num from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope'";
			 $res=$CONN->Execute($sql) or die ("Ū���H�Ƶo�Ϳ��~�ISQL=".$sql);
			 $fail['still'][$scope]=$res->fields['num'];
			//�w�ɦҤH�� 
	     $sql="select count(*) as num from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.complete='1'";
			 $res=$CONN->Execute($sql) or die ("Ū���H�Ƶo�Ϳ��~�ISQL=".$sql);
			 $fail['tested'][$scope]=$res->fields['num'];
			//�ݸɦҤH��
	     $sql="select count(*) as num from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.complete='0'";
			 $res=$CONN->Execute($sql) or die ("Ū���H�Ƶo�Ϳ��~�ISQL=".$sql);
			 $fail['ready'][$scope]=$res->fields['num'];			 
	   } // end foreach	   
		
} // end if $Cyear!="";


/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();
//�C�X���
echo $tool_bar;
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="opt1" value="">
	<input type="hidden" name="opt2" value="">
<?php
 echo "<font color=red>�ɦҾǴ��O�G".$C_year_seme."</font><br>";
 echo "�п�ܭn�˵����~�šG".$class_year_list;
 
 if ($Cyear!="") { 
 	?>
 <table border="0">
  <tr>
  	<!--���e�� -->
    <td valign="top">
 	  <table border="1" style="border-collapse:collapse;font-size:10pt" bordercolor="#111111" cellpadding="3">
 		<tr bgcolor="#FFCCFF">
 			<td>���O</td>
 			<td>���ή�</td>
 			<td>�w�ɦ�</td>
 			<td>�ݸɦ�</td>
 			<td>�˵��ާ@</td>
 		</tr>
 		<?php
 		foreach ($ss_link as $k=>$v) {
 		  ?>
 		  <tr>
 		    <td><?php echo $k;?></td>
 		    <td><?php echo $fail['still'][$v];?></td>
 		    <td><?php echo $fail['tested'][$v];?></td>
 				<td><?php echo $fail['ready'][$v];?></td>
 				<td>
 					<input type="button" value="���ɦ�" class="html_resit_list" id="btn_<?php echo $v;?>_ready">
					<input type="button" value="�ɦҤ�" class="html_resit_list" id="btn_<?php echo $v;?>_go">
 					<input type="button" value="�ɦҧ�" class="html_resit_list" id="btn_<?php echo $v;?>_tested">
 					<input type="button" value="�ץX�W��" class="output_resit_name" id="<?php echo $v;?>">
 				</td>
 		  </tr>
 		  <?php
 		} 		
 		?>
 		<tr>
 				<td colspan="5" align="center">
 					<input type="button" value="��s�ɦҦW��" class="get_all_resit_name">
 					<input type="button" value="�ץX�Ҧ����W��" id="output_resit_name_all">
 					<input type="button" value="�C�L�q����" id="print_resit_name_all">
 				</td>
 		</tr>
 	  </table>
     <?php 
     if ($INFO) {
     echo "<br><font color=red>$INFO</font>";
     }
     ?>
   	 <div id="waiting" style="display:none">
   	 	<br><font color='red'>��ƳB�z���A�еy��.....</font><br>
     </div> 
     <table border="0" width="520">
 	    <tr>
 	     <td style='font-size:10pt;color:#800000'>���C�L�q���椧�`�N�ƶ��]�Ш̻ݭn�ۦ�׭q�^</td>
 	    </tr>
 	    <tr>
 	     <td>
 	     <?php
 	      $input_data="
�@�B���q�d��H�ӾǴ��оǤ��e����h�C<BR>
�G�B�������i�ܤO�]���~�A<B>�O�����ѥ[�̡A���P���ɦ���q�����|</B>�C<BR>
�T�B�����ɦ���q��H��<U><B>�ǲ߻��Ǵ����Z���F�����]���Q���^</B></U>���ǥ͡C<BR>
�|�B�̳W�w<B>�ɦ���q�ή�̡A�Ӿǲ߻�즨�Z�H���Q���p</B>�C<BR>
���B�ɦ���q�ɵ{�P�a�I�A�t�椽�i���C<BR><BR>";
 	     ?>
 	     <textarea style="width:100%;font-size:10pt" rows="6" name="note_list"><?php echo $input_data;?></textarea>
 	     </td>
 	    </tr>
 	  </table>
 	  	
 		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>����:<br>
   1.�ץX��Ƭұĥ� Excel �榡�A�H�ѮM�L�U���q����C<br>
   2.���έp��Y�����~�βĤ@���ҥΥ��Ǵ��ɦҡA�Ы�<input type="button" value="��s�ɦҦW��" class="get_all_resit_name">�����W��C<br>
	 3.�p�G�ݭn�U���쪺���Z�Υ��ұЮv�W��A�ХѦU���u�ץX�W��v�C<br>
	 <font color=red>4.�`�N�I�������b�ɦҶi��e�ץX�A�p�G�w�Q�� makeup_exam �Ҳնi��ɦҦ��Z���u�A<br>�h�ץX����즨�Z�Τ��즨�Z�����u�᪺���Z�C</font>
   </font>

    </td>
  	<!--�k�e�� -->
    <td valign="top">
		<span id="show_right"></span>
    </td>
 </table> 	
 	<?php
 } //end if $Cyear 
?>
</form>
<?php
//  --�{���ɧ�
foot();
?>

<Script>

//�ץX���ή�W�� , �̻��
$(".output_resit_name").click(function(){
	var scope=$(this).attr("id");
	document.myform.act.value="output_resit_name";
	document.myform.opt1.value=scope;
	document.myform.target="";
	document.myform.submit();
	document.myform.act.value="";
})

//�ץX���ή�W��
$("#output_resit_name_all").click(function(){
	var scope=$(this).attr("id");
	document.myform.act.value="output_resit_name";
	document.myform.opt1.value="ALL";
	document.myform.target="";
	document.myform.submit();
	document.myform.act.value="";
})

//�C�L�q����
$("#print_resit_name_all").click(function(){
	var scope=$(this).attr("id");
	document.myform.act.value="output_resit_name";
	document.myform.opt1.value="ALL";
	document.myform.opt2.value="print";
	document.myform.target="_blank";
	document.myform.submit();
	document.myform.act.value="";
	document.myform.opt2.value="";
	document.myform.target="";
})

//���s�p����o�ɦҦW��
$(".get_all_resit_name").click(function(){
	document.myform.act.value="get_all_resit_name";
	waiting.style.display="block";
	document.myform.submit();
	document.myform.act.value="";
})

//�˵��w�ɦҦW��
$(".html_resit_list").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array(3);
�@var NewArray = btnID.split("_");
  var scope=NewArray[1];
  var opt1=NewArray[2];
	var act='html_resit_list';
	var Cyear='<?php echo $_POST['Cyear'];?>';
  
    $.ajax({
   	type: "post",
    url: 'resit_score.php',
    data: { act:act,scope:scope,opt1:opt1,Cyear:Cyear },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~!');
    },
    success: function(response) {
    	$('#show_right').html(response);
      $('#show_right').fadeIn(); 
			
    } // end success
	});   // end $.ajax


})


</Script>