<?php	
header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
require_once "../../include/sfs_case_excel.php";

//���ҬO�_�n�J
sfs_check(); 
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
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and entrance='0' and complete='0' order by curr_class_num";
	  break;
	  case 'go':
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and entrance='1' and complete='0' order by curr_class_num";	  
	  break;
	  case 'tested':
			$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and complete='1' order by curr_class_num";
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
	     <td style='font-size:10pt' align='center'>".$row['score']."</td>
	     <td style='font-size:9pt'>".$row['entrance_time']."</td>		
	     <td style='font-size:9pt'>".$row['complete_time']."</td>		
			</tr>
		";
		

	}
	  $main="	  
	 <table border=\"0\" width=\"100%\" cellspacing=\"3\" cellpadding=\"2\">
  	<tr>
   	  <td colspan='5' style='color:#800000'><b>".$link_ss[$scope]."���</b> - [<font color=blue>".$S[$opt1]."</font>]�W��</td>
   	</tr>
	   <tr bgcolor=\"#FFCCCC\">
	     <td style='font-size:10pt'>�Z��</td>
	     <td style='font-size:10pt'>�y��</td>
	     <td style='font-size:10pt'>�m�W</td>
	     <td style='font-size:10pt'>�즨�Z</td>
	     <td style='font-size:10pt'>�ɦҦ��Z</td>
	     <td style='font-size:10pt'>����ɶ�</td>
	     <td style='font-size:10pt'>�����ɶ�</td>
	   </tr>
	 ".$main."
	 </table>"; 
	  
 
  echo $main;
  exit();

}

//�ץX���ή�W��
if ($_POST['act']=='output_resit_name') {
  
	//���O
	$scope=$_POST['opt1'];
	
  $seme_year_seme=$SETUP['now_year_seme'];
  
 //����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($curr_year_seme);
	$stud_sn=array();

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
	$x=new sfs_xls();
	$x->setUTF8();
	$x->filename=substr($seme_year_seme,0,3)."�Ǧ~�ײ�".substr($seme_year_seme,-1).'�Ǵ����ɦҾǥͦW��.xls';
	$x->setBorderStyle(1);
	$x->addSheet("���ɦҦW��");
	$x->items[0]=array('�Ǹ�','�ثe�Z��','�ثe�y��','�m�W','�y��','�ƾ�','�۵M','���|','����','����','��X','���ɦһ��','�w�ɦһ��','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�q�T�a�}');

	foreach ($stud_sn as $student_sn) {
    //�ˬd�O�_�����@�줣�ή�
    $language=$math=$nature=$social=$health=$art=$complex="";
    $resit_scope=$resit_tested="";
	  $put_it=0;
	  foreach ($ss_link as $v=>$S) {
	  	${$S}=$fin_score[$student_sn][$S][$seme_year_seme]['score'];
	   if ($fin_score[$student_sn][$S][$seme_year_seme]['score']<60) {
	     $put_it=1;
	     $resit_scope.="�i".$v."�j";
	   }
	   	$sql="select a.score from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$S'";
			$res=$CONN->Execute($sql) or die($sql);
			if ($res->recordcount()) {
	      $resit_tested.="�i".$v."�j";
		  }
	  }
	  
	  if ($put_it==1) {
    	//�O�_���ɦҦ��Z
			//$sql="select a.* from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope'";
			//$res=$CONN->Execute($sql) or die($sql);
			//if ($res->recordcount()==0) {
			//  $resit_score="";
			//} else {
		  //  $resit_score=$res->fields['score'];
		  //}
			$x->items[]=array($student_data[$student_sn]['stud_id'],$student_data[$student_sn]['class_name'],$student_data[$student_sn]['seme_num'],$student_data[$student_sn]['stud_name'],$language,$math,$nature,$social,$health,$art,$complex,$resit_scope,$resit_tested,$student_data[$student_sn]['guardian_name'],$student_data[$student_sn]['stud_tel_2'],$student_data[$student_sn]['stud_tel_3'],$student_data[$student_sn]['addr_zip'],$student_data[$student_sn]['stud_addr_2']);
  	} // end if
  } // end foreach 
 
 
 //��@���
 } else {
	$x=new sfs_xls();
	$x->setUTF8();
	$x->filename=$seme_year_seme.$link_ss[$scope].'���ή�ǥͦW��.xls';
	$x->setBorderStyle(1);
	$x->addSheet($link_ss[$scope]."���ή�");
	$x->items[0]=array('�Ǹ�','�ثe�Z��','�ثe�y��','�m�W','�Ǵ�����','�ɦҤ���','�a���m�W','�����q��','��ʹq��','�l���ϸ�','�q�T�a�}');

	foreach ($stud_sn as $student_sn) {
		if ($fin_score[$student_sn][$scope][$seme_year_seme]['score']<60) {
			
    	//�O�_���ɦҦ��Z
			$sql="select a.* from resit_exam_score a,resit_paper_setup b where a.paper_sn=b.sn and a.student_sn='$student_sn' and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope'";
			$res=$CONN->Execute($sql) or die($sql);
			if ($res->recordcount()==0) {
			  $resit_score="";
			} else {
		    $resit_score=$res->fields['score'];
		  }
			$x->items[]=array($student_data[$student_sn]['stud_id'],$student_data[$student_sn]['class_name'],$student_data[$student_sn]['seme_num'],$student_data[$student_sn]['stud_name'],$fin_score[$student_sn][$scope][$seme_year_seme]['score'],$resit_score,$student_data[$student_sn]['guardian_name'],$student_data[$student_sn]['stud_tel_2'],$student_data[$student_sn]['stud_tel_3'],$student_data[$student_sn]['addr_zip'],$student_data[$student_sn]['stud_addr_2']);
  	} // end if
  } // end foreach
 } // end if $scope=='ALL'
 
		$x->writeSheet();
		$x->process();

  exit();

}  // end if �ץX���ή�W��


$class_year_list="
  <select size='1' name='Cyear' onchange='this.form.submit()'>
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
 					<input type="button" value="�ץX�Ҧ����W��" id="output_resit_name_all">
 				</td>
 		</tr>
 	  </table>
 		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>����:<br>
   1.�ץX��Ƭұĥ� Excel �榡�A�H�ѮM�L�U���q����C<br>
   2.���έp��Y�����~�A�Ы�<input type="button" value="��s�ɦҦW��" id="get_all_resit_name">���s�p��è��o�ɦҦW��C
   </font>
   <?php echo "<br><br><font color=red>$INFO</font>";?>
   	 <div id="waiting" style="display:none">
   	 	<br>��ƳB�z���A�еy��......
     </div>
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

//�ץX���ή�W��
$(".output_resit_name").click(function(){
	var scope=$(this).attr("id");
	document.myform.act.value="output_resit_name";
	document.myform.opt1.value=scope;
	document.myform.submit();
	document.myform.act.value="";
})

//�ץX���ή�W��
$("#output_resit_name_all").click(function(){
	var scope=$(this).attr("id");
	document.myform.act.value="output_resit_name";
	document.myform.opt1.value="ALL";
	document.myform.submit();
	document.myform.act.value="";
})

//���s�p����o�ɦҦW��
$("#get_all_resit_name").click(function(){
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