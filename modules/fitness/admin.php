<?php
// $Id: admin.php 6558 2011-09-26 07:19:31Z infodaes $
include "config.php";
sfs_check();
$session_tea_sn =  $_SESSION['session_tea_sn'] ;

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if($c_curr_seme ==''){
	$c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�
}

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'] ;
if ( checkid($SCRIPT_FILENAME,1) or ($admin==$session_tea_sn) ){
		$class_seme_p = get_class_seme(); //�Ǧ~��	
		$seme_temp = "<select name=\"c_curr_seme\" onchange=\"this.form.submit()\">\n";
		while (list($tid,$tname)=each($class_seme_p)){
			if ($c_curr_seme== $tid)
		      		$seme_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
		      	else
		      		$seme_temp .= "<option value=\"$tid\">$tname</option>\n";
		}
		$seme_temp .= "</select>"; 
	$class_avg_a=array("���Z����","�k�ͥ���","�k�ͥ���");
	$avg_temp=  "<select name='class_avg' onchange='this.form.submit()'>";
	while (list($tid,$tname)=each($class_avg_a)){
		if ($class_avg== $tid)
	      		$avg_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$avg_temp .= "<option value=\"$tid\">$tname</option>\n";
		}
	$avg_temp .= "</select>"; 	
	$cita_a=array("�������","�Ƚ����","�ɽ����");
	$cita_temp=  "<select name='cita_avg' onchange='this.form.submit()'>";
	while (list($tid,$tname)=each($cita_a)){
		if ($cita_avg== $tid)
	      		$cita_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$cita_temp .= "<option value=\"$tid\">$tname</option>\n";
		}
	$cita_temp .= "</select>"; 	
	$bmi_a=array("����(�H�W)","����(�H�U)","�魫(�H�W)","�魫(�H�U)","����(�H�W)","����(�H�U)");
	$bmi_temp=  "<select name='bmi_avg' onchange='this.form.submit()'>";
	while (list($tid,$tname)=each($bmi_a)){
		if ($bmi_avg== $tid)
	      		$bmi_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$bmi_temp .= "<option value=\"$tid\">$tname</option>\n";
		}
	$bmi_temp .= "</select>"; 	
	$sco_a=array("�����e�s","���װ_��","�ߩw����","800/1600����");
	$sco_temp=  "<select name='sco_avg' onchange='this.form.submit()'>";
	while (list($tid,$tname)=each($sco_a)){
		if ($sco_avg== $tid)
	      		$sco_temp .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$sco_temp .= "<option value=\"$tid\">$tname</option>\n";
		}
	$sco_temp .= "</select>"; 	

}
else {
		echo "����޲z�����";
	   //Header("Location: index.php");
	   exit ;
}

// ��ܺa�A�]
if (count ($sel_stud) >0){	
	$now=date("Y-m-d");
	$session_tea_sn =  $_SESSION['session_tea_sn'] ;
	$order_pos=$cita_avg; 
	$data_get=$cita_a[$cita_avg];  
	$sel_year=substr($c_curr_seme,0,-1);
	$sel_seme=substr($c_curr_seme,-1);
	$title=Num2CNum($sel_year)."�Ǧ~�ײ�".Num2CNum($sel_seme)."�Ǵ���A�����";
	$body1="���ߧA�b".$title."�A�a��";	
	$body2="�A�ڭ̳����A�P�찪���A�S�O�{�o�������y�A�Ʊ�A�~��V�O�A��W�h�ӡC";
	$helper="�ж���ѻP�����W��A���Ŀ�ǥ͡A�A�I��<font color=red>�ѻP����</font>�A�̫��[�T�w�s�W]�Y�i�A�p�����~�A�i���R����A�s�W �C<br>�Z�C�Ǵ��W�߰ѻP�B�ʹF�Q�G�g�H�W�A�C�g�ܤ֤T���B�C���B�ʤT�Q�����H�W�A�g��|�½ҦѮv�f�ֳq�L�̡I";
	$kind_set="�������,�Ƚ����,�ɽ����,�ѻP����,";	
	$sqlstr ="SELECT * FROM cita_kind WHERE doc='$title'";
		  $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    	$row = $result->FetchRow() ;          
        	$id = $row["id"];   
	$end_date = $row["end_date"]; 	
	$beg_date = $row["beg_date"]; 	
	 if($id==''){
		//�s�W�a�A�]
		$sqlstr ="INSERT INTO cita_kind (title,doc,beg_date,end_date,input_classY,foot,is_hide,grada,kind_set,helper ) 
			VALUES ('$body1', '$title', '$now', '$now', '1,2,3,4,5,6',  '$body2', '1', '0' ,'$kind_set','$helper')";
		 $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;  
		$sqlstr ="SELECT id FROM cita_kind WHERE doc='$title'";
		 $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
    		$row = $result->FetchRow() ;          
        		$id = $row["id"];   
		$end_date = $row["end_date"]; 	
		$beg_date = $row["beg_date"]; 	
	}	
	if (date("Y-m-d")>=$beg_date and date("Y-m-d")<=$end_date){
	    for($i=0;$i<count ($sel_stud);$i++){
		$stud_id=sel_data($sel_stud[$i],1);
		$class_id=sel_data($sel_stud[$i],2);
		$num=$i;
		$stud_name=sel_data($sel_stud[$i],3);		
		$sqlstr ="insert into cita_data (kind,stud_id,stud_name,teach_id,class_id,num,data_get,order_pos,up_date) 
					         values ('$id','$stud_id','$stud_name','$session_tea_sn','$class_id','$num','$data_get','$order_pos','$now')";
	             $result = $CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ; 
		echo $stud_name ."�w�פJ<br>";
        	   }
	}else{
	  	echo "��������w�L";
	}
}






if($Submit<>"�C�L"){
	head("��A�����") ;
	print_menu($menu_p);

	if($chk=='avg') $avg_check="checked";
	if($chk=='cita') $cita_check="checked";
	if($chk=='bmi') $bmi_check="checked";
	if($chk=='sco') $sco_check="checked";

	echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"chform\">";
	echo  $seme_temp;
	echo  "�@<input type='radio' value='avg' $avg_check name='chk'>$avg_temp";
	echo  "�@<input type='radio' value='cita' $cita_check  name='chk'>$cita_temp";
	echo  "�@<input type='radio' value='bmi' $bmi_check  name='chk'>$bmi_temp <input type='text' name='ass' size='2' value='$ass'>�H";
	echo  "�@<input type='radio' value='sco' $sco_check  name='chk'>$sco_temp <input type='text' name='asco' size='2' value='$asco'>�H";
	echo "�@<input type='submit' value='�d��' name='Submit'> <input type='submit' value='�C�L' name='Submit'>";
	if($chk=='cita' ){
		echo '<br><input type="button" value="����" onClick="javascript:tagall(1);">';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">�@';			
		echo "<input type='submit' name='do_key' value='�ץX�ܺa�A�]'>";

	}
}

$main="<br>���I��n�d�ߪ����ءI";
if($chk=='avg' )
	$main=avg($class_avg);
if($chk=='cita' )
	$main=cita($cita_avg);
if($chk=='bmi' )
	$main=bmi($bmi_avg,$ass);
if($chk=='sco' )
	$main=sco($sco_avg,$asco);




echo $main;

if($Submit<>"�C�L"){
	echo "</form>";
	foot() ;
}
//�U�Z�έp
function  avg($class_avg){ 
global $CONN,$SCHOOL_BASE,$c_curr_seme,$test,$class_avg_a;

$sex="";
$avg_name=$class_avg_a[$class_avg];
if($class_avg=="1"){
	$sex="and a.stud_sex=1";
}elseif($class_avg=="2"){
	$sex="and a.stud_sex=2";
}

$sel_year=substr($c_curr_seme,0,-1);
$sel_seme=substr($c_curr_seme,-1);
$main=  "<br><font size=4>".$SCHOOL_BASE[sch_cname]." ".$sel_year." �Ǧ~�ײ� ".$sel_seme." �Ǵ� ��A�����U�Z $avg_name �έp��</font>";
$main.= "<table border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000' width='100%'>";

$sql = "select  b.seme_class,count(*) as cou,avg(c.tall) as a_tall ,avg(c.weigh) as a_weigh ,avg(c.bmt) as a_bmt ,avg(c.test1) as a_test1 ,avg(c.test2) as a_test2 ,avg(c.test3) as a_test3 ,avg(c.test4) as a_test4 from stud_base a,stud_seme b ,fitness_data c where a.student_sn=b.student_sn and c.student_sn=a.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and c.c_curr_seme='$c_curr_seme' ".$sex." group by b.seme_class"; 
$result =  $CONN->Execute($sql) or user_error("Ū�����ѡI<br>$query",256) ; 
$main.= "<tr align='center'><td width='12%'>$avg_name</td>";
$main.= "<td width='11%'>�H��</td>";
$main.= "<td width='11%'>$test[0]</td>";
$main.= "<td width='11%'>$test[1]</td>";
$main.= "<td width='11%'>BMI����<br>kg/m2</td>";
$main.= "<td width='11%'>$test[2]</td>";
$main.= "<td width='11%'>$test[3]</td>";
$main.= "<td width='11%'>$test[4]</td>";
$main.= "<td width='11%'>$test[5]</td>";
while ($row = $result->FetchRow() ) {
	$class_num=$row["seme_class"];
	$class_name=class_id2big5($class_num,$sel_year,$sel_seme);
	$cou = $row["cou"];
	$a_tall = round($row["a_tall"],1);
	$a_weigh = round($row["a_weigh"],1);
	$a_bmt = round($row["a_bmt"],1) ;
	$a_test1 = round($row["a_test1"],1) ;
	$a_test2 = round($row["a_test2"],1) ;
	$a_test3 = round($row["a_test3"],1) ;
	$a_test4 = round($row["a_test4"],1) ;
	$main.=  "<tr align='center'><td>$class_name</td><td>$cou</td><td>$a_tall</td><td>$a_weigh</td><td>$a_bmt</td><td>$a_test1</td><td>$a_test2</td><td>$a_test3</td><td>$a_test4</td></tr>" ;   
}
$main.= "</table>";
return $main;
}

//���N����
function  cita($cita_avg){ 
global $CONN,$SCHOOL_BASE,$c_curr_seme,$test,$cita_a,$Submit;

$cita_name=$cita_a[$cita_avg];

//���o�ǥ͸�ư}�C
$sql = "select b.seme_class,a.stud_id,a.stud_birthday,a.stud_name,a.stud_sex,b.seme_num,c.*  from stud_base a,stud_seme b ,fitness_data c where a.student_sn=b.student_sn and c.student_sn=a.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$c_curr_seme' and  c.c_curr_seme='$c_curr_seme' order by b.seme_class,b.seme_num "; 
$result=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
$sel_year=substr($c_curr_seme,0,-1);
$sel_seme=substr($c_curr_seme,-1);

$main=  "<br><font size=4>".$SCHOOL_BASE[sch_cname]." ".$sel_year." �Ǧ~�ײ� ".$sel_seme." �Ǵ� ��A�������պa�� $cita_name �W��</font>";
$main.= "<table border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000' width='100%'>";

$main.= "<tr align=center><td width='12%'>�~�Z</td><td width='5%'>�y��</td><td width='12%'>�m�W</td><td width='6%'>�ʧO</td><td width='5%'>�~��</td>";
$main.= "<td width='15%'>$test[2] [�H]</td>";
$main.= "<td width='15%'>$test[3] [�H]</td>";
$main.= "<td width='15%'>$test[4] [�H]</td>";
$main.= "<td width='15%'>$test[5] [�H]</td>";
if($Submit<>"�C�L"){
		$main.="<td >���</td>";
}

$main.= "<tr>";
$s=0;
while ($row = $result->FetchRow()) {
$class_num=$row["seme_class"];
$class_name=class_id2big5($class_num,$sel_year,$sel_seme);

$num=$row["seme_num"];
$stud_id=$row["stud_id"]; 
$name=$row["stud_name"]; 
$stud_name=$name;
if($Submit<>"�C�L"){
	$url_str_1 = "fitpass.php?stud_id=$stud_id";
	$name="<a onclick=\"openwindow('$url_str_1')\" title='$name ���ӤH�@��'>$name"; 
}

$test1=$row["test1"]; 
$test2=$row["test2"]; 
$test3=$row["test3"]; 
$test4=$row["test4"]; 
$prec1=$row["prec1"]; 
$prec2=$row["prec2"]; 
$prec3=$row["prec3"]; 
$prec4=$row["prec4"]; 
$sex=$row["stud_sex"];
if($sex==1) $sex="�k";
elseif($sex==2) $sex="�k";
$age=$row["age"];
$text1=text(1,$prec1,$test1);
$text2=text(1,$prec2,$test2);
$text3=text(1,$prec3,$test3);
$text4=text(1,$prec4,$test4);
$cita=cita_c($prec1,$prec2,$prec3,$prec4);
if($cita==$cita_name){
	$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
	$value=$stud_id."#".$class_id."#".$stud_name;
	$main.= "<tr bgcolor='#ffffff' align=center>
	<td  >$class_name </td>
	<td>$num</td>
	<td  > $name</td>
	<td  >$sex </td>
	<td  >$age </td>
	<td  >$text1  $test1 [$prec1]</td>
	<td  >$text2 $test2 [$prec2]</td>
	<td  >$text3 $test3 [$prec3]</td>
	<td >$text4 $test4 [$prec4]</td>";
	if($Submit<>"�C�L"){
		$main.="<td ><input id=c_$stud_id type=checkbox name=sel_stud[] value=$value></td>";	
	}
$main.="</tr>";
$s++;
}
}
$main.= "</table>";
$main.="�@ $s �H";
return $main;

}

//BMI
function  bmi($bmi_avg,$ass=0){ 
global $CONN,$SCHOOL_BASE,$c_curr_seme,$test,$bmi_a,$Submit;

switch ($bmi_avg){
	case 0:
		if($ass==0) $ass=85;
		$bmi_name="�����b". $ass . "�H�H�W";
		$ass_c=" and  c.prec_t>=$ass and c.tall>0 order by c.tall desc";
	break;
	case 1:
		if($ass==0) $ass=15;
		$bmi_name="�����b". $ass . "�H�H�U";
		$ass_c=" and c.prec_t<=$ass  and c.tall>0 order by c.tall ";
	break;
	case 2:
		if($ass==0) $ass=85;
		$bmi_name="�魫�b". $ass . "�H�H�W";
		$ass_c=" and  c.prec_w>=$ass and c.weigh>0 order by c.weigh desc";
	break;
	case 3:
		if($ass==0) $ass=15;
		$bmi_name="�魫�b". $ass . "�H�H�U";
		$ass_c=" and c.prec_w<=$ass  and c.weigh>0 order by c.weigh ";
	break;
	case 4:
		if($ass==0) $ass=80;
		$bmi_name="�����q���Ʀb". $ass . "�H�H�W";
		$ass_c=" and  c.prec_b>=$ass and c.bmt>0 order by c.bmt desc";
	break;
	case 5:
		if($ass==0) $ass=20;
		$bmi_name="�����q���Ʀb". $ass . "�H�H�U";
		$ass_c=" and c.prec_b<=$ass  and c.bmt>0 order by c.bmt ";
	break;


}
//���o�ǥ͸�ư}�C
$sql = "select b.seme_class,a.stud_id,a.stud_birthday,a.stud_name,a.stud_sex,b.seme_num,c.* from stud_base a,stud_seme b ,fitness_data c where a.student_sn=b.student_sn and c.student_sn=a.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and b.seme_year_seme='$c_curr_seme' and c.c_curr_seme='$c_curr_seme' ".$ass_c.",b.seme_class,b.seme_num"; 
$result=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
$sel_year=substr($c_curr_seme,0,-1);
$sel_seme=substr($c_curr_seme,-1);

$main=  "<br><font size=4>".$SCHOOL_BASE[sch_cname]." ".$sel_year." �Ǧ~�ײ� ".$sel_seme." �Ǵ� ��A�������� $bmi_name �W��</font>";
$main.= "<table border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000' width='100%'>";

$main.= "<tr align=center><td width='12%'>�~�Z</td><td width='5%'>�y��</td><td width='12%'>�m�W</td><td width='6%'>�ʧO</td><td width='5%'>�~��</td>";
$main.= "<td width='15%'>$test[0] [�H]</td>";
$main.= "<td width='15%'>$test[1] [�H]</td>";
$main.= "<td width='15%'>�����q����<br>BMI(kg/m2)[�H]</td>";
$main.= "<tr>";
$s=0;
while ($row = $result->FetchRow()) {
$class_num=$row["seme_class"];
$class_name=class_id2big5($class_num,$sel_year,$sel_seme);
$stud_id=$row["stud_id"]; 
$num=$row["seme_num"];
$name=$row["stud_name"]; 
if($Submit<>"�C�L"){
	$url_str_1 ="fitpass.php?stud_id=$stud_id";
	$name="<a onclick=\"openwindow('$url_str_1')\" title='$name ���ӤH�@��'>$name"; 
}

$tall=$row["tall"]; 
$weigh=$row["weigh"]; 
$bmt=$row["bmt"]; 
$prec_t=$row["prec_t"]; 
$prec_w=$row["prec_w"]; 
$prec_b=$row["prec_b"]; 

$sex=$row["stud_sex"];
if($sex==1) $sex="�k";
elseif($sex==2) $sex="�k";
$age=$row["age"];
$text=text(6,$prec_b,$bmt);
$main.= "<tr bgcolor='#ffffff' align=center>
<td  >$class_name </td>
<td>$num</td>
<td  > $name</td>

<td  >$sex </td>
<td  >$age </td>
<td  > $tall [$prec_t]</td>
<td  > $weigh [$prec_w]</td>
<td  >$text $bmt [$prec_b]</td>
</tr>";
$s++;
}

$main.= "</table>";
$main.="�@ $s �H";
return $main;

}


//���Z
function  sco($sco_avg,$ass=0){ 
global $CONN,$SCHOOL_BASE,$c_curr_seme,$test,$sco_a,$Submit;

		if($ass==0) $ass=75;
		$t=$sco_avg+1;
		$sco_name=$sco_a[$sco_avg]."�b". $ass . "�H�H�W";
		$ass_c=" and  c.prec". $t ." >=$ass  and c.test". $t ." >0 order by c.test". $t;
		if( $sco_avg<3) $ass_c.=" desc ";

//���o�ǥ͸�ư}�C
$sql = "select b.seme_class,a.stud_id,a.stud_birthday,a.stud_name,a.stud_sex,b.seme_num,c.* from stud_base a,stud_seme b,fitness_data c where a.student_sn=b.student_sn and c.student_sn=a.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and c.c_curr_seme='$c_curr_seme' ".$ass_c.", b.seme_class,b.seme_num";
$result=$CONN->Execute($sql) or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
$sel_year=substr($c_curr_seme,0,-1);
$sel_seme=substr($c_curr_seme,-1);

$main=  "<br><font size=4>".$SCHOOL_BASE[sch_cname]." ".$sel_year." �Ǧ~�ײ� ".$sel_seme." �Ǵ� ��A�������� $sco_name �W��</font>";
$main.= "<table border='1' cellpadding='1' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000' width='100%'>";
$main.= "<tr align=center><td width='12%'>�~�Z</td><td width='5%'>�y��</td><td width='10%'>�m�W</td><td width='10%'>���N</td><td width='6%'>�ʧO</td><td width='5%'>�~��</td>";
$main.= "<td width='13%'>$test[2] [�H]</td>";
$main.= "<td width='13%'>$test[3] [�H]</td>";
$main.= "<td width='13%'>$test[4] [�H]</td>";
$main.= "<td width='13%'>$test[5] [�H]</td>";
$main.= "<tr>";

$s=0;
while ($row = $result->FetchRow()) {
$class_num=$row["seme_class"];
$class_name=class_id2big5($class_num,$sel_year,$sel_seme);
$num=$row["seme_num"];
$stud_id=$row["stud_id"]; 
$name=$row["stud_name"]; 
if($Submit<>"�C�L"){
	$url_str_1 ="fitpass.php?stud_id=$stud_id";
	$name="<a onclick=\"openwindow('$url_str_1')\" title='$name ���ӤH�@��'>$name"; 
}

$test1=$row["test1"]; 
$test2=$row["test2"]; 
$test3=$row["test3"]; 
$test4=$row["test4"]; 
$prec1=$row["prec1"]; 
$prec2=$row["prec2"]; 
$prec3=$row["prec3"]; 
$prec4=$row["prec4"]; 
$sex=$row["stud_sex"];
if($sex==1) $sex="�k";
elseif($sex==2) $sex="�k";
$age=$row["age"];
$text1=text(1,$prec1,$test1);
$text2=text(1,$prec2,$test2);
$text3=text(1,$prec3,$test3);
$text4=text(1,$prec4,$test4);
$cita=cita_c($prec1,$prec2,$prec3,$prec4);

$main.= "<tr bgcolor='#ffffff' align=center>
<td  >$class_name </td>
<td>$num</td>
<td  > $name</td>
<td  > $cita</td>
<td  >$sex </td>
<td  >$age </td>
<td  >$text1  $test1 [$prec1]</td>
<td  >$text2 $test2 [$prec2]</td>
<td  >$text3 $test3 [$prec3]</td>
<td >$text4 $test4 [$prec4]</td>
</tr>";
$s++;
}

$main.= "</table>";
$main.="�@ $s �H";
return $main;

}


//�u�}����
function cita_c($t1,$t2,$t3,$t4){
$text="";
if($t1>=85 && $t2>=85 && $t3>=85 && $t4>=85 ){
	$text="�������";
}elseif($t1>=75 && $t2>=75 && $t3>=75 && $t4>=75 ){
	$text="�Ƚ����";
}elseif($t1>=50 && $t2>=50 && $t3>=50 && $t4>=50 ){
	$text="�ɽ����";
}
return $text;
}

// ����
function text($grade,$prec,$s){
$text="";
if($s>0){
	if($grade==1){
		if($prec>=75) $text="<font color=purple>�u�}</font>";
		if($prec<25) $text="<font color=red>�[�j</font>";
	}
	if($grade==6){
		if($prec>=80) $text="<font color=red>�L��</font>";
		if($prec<20) $text="<font color=red>�L��</font>";
	}	
}
return $text;
}

//���θ�Ƴ��C

function sel_data($string,$s) {
$i=1;
$tok = strtok ($string,"#"); 
while ($tok) { 
$data_arr[$i]=$tok; 
$tok = strtok ("#"); 
$i++;
} 
return $data_arr[$s];
}

?>
<script language="JavaScript">
<!--
function openwindow(url_str){
	window.open (url_str,"�ӤH��A���@��","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=800,height=480");
}
function tagall(status) {		
	var i =0;
	while (i < document.chform.elements.length)  {
		if (document.chform.elements[i].name=='sel_stud[]') {
		document.chform.elements[i].checked=status;
		}
		i++;
	}
}
//  End -->
</script>
