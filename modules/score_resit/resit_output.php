<?php	
header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
include_once "../makeup_exam/my_fun.php";
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

// ajax �˵��w�ɦҦ��Z
if ($_POST['act']=='output_resit_score') {
 	//���O
 	// $Cyesr : �~��
 	$i=0;
	$scope=$_POST['scope'];
	$seme_year_seme=$SETUP['now_year_seme'];
  //����Z�ų]�w�̪��Z�ŦW��
	$class_base= class_base($curr_year_seme);
	$sql="select a.*,c.stud_id,c.stud_name,c.curr_class_num from resit_exam_score a,resit_paper_setup b,stud_base c where a.paper_sn=b.sn and b.seme_year_seme='$seme_year_seme' and b.class_year='$Cyear' and b.scope='$scope' and a.student_sn=c.student_sn and complete='1' order by curr_class_num";
	$res=$CONN->Execute($sql) or die($sql);
	while ($row=$res->FetchRow()) {
		$i++;
		$student_sn=$row['student_sn'];
		$curr_class_num=$row['curr_class_num'];
		$seme_class=substr($curr_class_num,0,3);
		$seme_num=substr($curr_class_num,-2);
		
		$main.="
			<tr>
	     <td style='font-size:10pt' align='center'><input type='checkbox' name='score_sn[]' value='".$row['sn']."' checked></td>
	     <td style='font-size:10pt' align='center'>".$class_base[$seme_class]."</td>
	     <td style='font-size:10pt' align='center'>".$seme_num."</td>
	     <td style='font-size:10pt' align='center'>".$row['stud_name']."</td>
	     <td style='font-size:10pt' align='center'>".$row['org_score']."</td>
	     <td style='font-size:10pt".(($row['score']<60)?";color:red":"")."' align='center'>".$row['score']."</td>
	     <td style='font-size:9pt'>".$row['entrance_time']."</td>		
	     <td style='font-size:9pt'>".$row['complete_time']."</td>		
			</tr>
		";

	}
	  $main="	  
	 <input type='hidden' name='scope' value='$scope'>
	 <table border=\"0\" width=\"100%\" cellspacing=\"3\" cellpadding=\"2\">
  	<tr>
   	  <td colspan='5' style='color:#800000'><b>".$link_ss[$scope]."���</b> - [<font color=blue>�w�ɦ�</font>]�W�� , �@�p $i ��</td>
   	</tr>
	   <tr bgcolor=\"#FFCCCC\">
	   	 <td style='font-size:10pt'>�Ŀ�</td>
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

//�ץX����
if ($_POST['act']=='output_resit_score_submit') {
	$scope=$_POST['scope'];
	$seme_year_seme=$SETUP['now_year_seme'];
	$paper_setup=get_paper_sn($seme_year_seme,$Cyear,$scope);
	$data_arr=array();
	//�}�C���e data_arr[$student_sn][$seme_year_seme][$scope_ename]=$score
	foreach ($_POST['score_sn'] as $score_sn) {
	 $sql="select * from resit_exam_score where sn='$score_sn'";
   $res=$CONN->Execute($sql) or die ("Ū�����Ƹ�Ƶo�Ϳ��~! SQL=".$sql);
   while ($row=$res->fetchRow()) {	 
	  $student_sn=$row['student_sn'];
	  $org_score=$row['org_score'];
	 //�ˬd makeup_exam �̪� makeup_exam_scope ���S���T�{�W��
		$sql_check="select * from makeup_exam_scope where student_sn='$student_sn' and seme_year_seme='$seme_year_seme' and scope_ename='$scope'";
		$res_check=$CONN->Execute($sql_check);
		if ($res_check->recordCount()==0 and $_POST['auto_insert_makeup_exam_list']==1) {
			$query="insert into makeup_exam_scope (seme_year_seme,student_sn,scope_ename,class_year,oscore) values ('".$seme_year_seme."','".$student_sn."','".$scope."','".$Cyear."','$org_score')";
			$res_insert=$CONN->Execute($query) or die("�۰ʩ� makeup_exam �Ҳիإߵ��q�W�U���ѡISQL=".$query);
		}
    $data_arr[$student_sn][$seme_year_seme][$scope]=($row['score']>100)?100:$row['score'];
	 } // end while
	} // end foreach
	
	$SUCC=import_makeup_exam($data_arr);
  $INFO="�w���\�פJ ".$SUCC." ��".$link_ss[$scope]."��쪺�ɦҦ��Z��ơI";
}

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
 echo "�п�ܭn�ץX���Z���~�šG".$class_year_list;
 
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
 			<td>�ץX�ާ@</td>
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
 					<input type="button" value="�ץX���Z" class="output_resit_score" id="<?php echo $v;?>">
 				</td>
 		  </tr>
 		  <?php
 		} 		
 		?>
 	  </table>
 		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>����:<br>
   1.���B�ץX���Z�ëD�N���Z�����פJ�Ǵ����Z��Ʈw�C<br>
   2.�z�����w���u�ɦ���q���Z�@�~(makeup_exam)�v�ҲաA<br>
   ���t�η|�N���Z�ץX�ܸӼҲաA�бz�A�Q�θӼҲճB�z���Z�C<br>
	 3.�Щ�ߡA���_�פJ�ȱN���Z�мg�A�ä��|����L���~�C
   </font>
   <br>
   <br>
   <font color=red><?php echo $INFO;?></font>
   <br>
   	 <div id="output_submit" style="display:none">
   	 	<input type="button" style="color:#FF0000" value="�T�{�L�~�A�ץX�Ŀ諸���Z" id="output_resit_score_submit">
		 <br><input type="checkbox" name="auto_insert_makeup_exam_list" value="1" checked>��ɦ���q�W�U���L���W��ɦ۰ʷs�W
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

//�ץX�w�ɦҦ��Z
$(".output_resit_score").click(function(){
	var scope=$(this).attr("id");
	var act='output_resit_score';
	var Cyear='<?php echo $_POST['Cyear'];?>';
  
    $.ajax({
   	type: "post",
    url: 'resit_output.php',
    data: { act:act,scope:scope,Cyear:Cyear },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~!');
    },
    success: function(response) {
    	$('#show_right').html(response);
      $('#show_right').fadeIn(); 
			output_submit.style.display='block';
    } // end success
	});   // end $.ajax

})

//�ץX�w�ɦҦ��Z
$("#output_resit_score_submit").click(function(){

	document.myform.act.value='output_resit_score_submit';
	document.myform.submit();
	
})


</Script>