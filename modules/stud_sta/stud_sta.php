<?php

// $Id: stud_sta.php 6120 2010-09-11 02:38:04Z brucelyc $

// ���J�]�w��
include "config.php";
include  "sfs_oo_date2.php";
// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


if(!$stud_class)
	$stud_class =$default_begin_class; //�w�]�Z��

$curr_seme = curr_year().curr_seme(); //�{�b�Ǧ~�Ǵ�
$sel_year = curr_year(); //��ܾǦ~
$sel_seme = curr_seme(); //��ܾǴ�
$sel_class_year = substr($stud_class,0,1); //��ܦ~��
$sel_class_name = substr($stud_class,-2); //��ܯZ��
$stud_study_year = $sel_year-$sel_class_year+1; //�NŪ�~
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
if ($stud_id) {
	$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$stud_id'";
	$res=$CONN->Execute($query);
	$student_sn=$res->fields['student_sn'];
}

//����B�z
switch($key) {
	case $postProve :
		$set_ip = getip();
		$prove_date = $pro_date;
		$move_c_date = $reward_ndate;
		if ($purpose==''){
		   $purpose='�@';
		   }
		//$reward_div="1";
		//�[�J���ʰO�� ChtoD()
		$sql_insert = "insert into stud_sta (prove_id,stud_id,prove_year_seme,purpose,prove_date,set_id,set_ip,prove_cancel,student_sn) values ('$prove_id','$stud_id','$curr_seme','$purpose','$prove_date','$set_id','$set_ip','$prove_cancel','$student_sn')";
		$CONN->Execute($sql_insert) or die ($sql_insert);
		
		//if($reward_kind == "99") { //�R��
		//	$sql_update = "delete from reward where stud_id='$stud_id'";
		//}
		//else
			//$sql_update = "update reward set stud_study_cond ='$reward_kind' where stud_id='$stud_id'";
		//$CONN->Execute($sql_update) or die ($sql_update);
	break;

	case "cancel" :
		$prove_cancel=$_GET[prove_cancel];
		
		//�r������
		$prove_id=(integer)($prove_id);
		


		$sql_update = "update stud_sta  set prove_cancel=$prove_cancel where prove_id=$prove_id";
		$CONN->Execute($sql_update) or die ($sql_update);	
	
    break;
    	
    	case "print" :
			
    break;
}

//����T
$field_data = get_field_info("stud_sta");

// ����禡
$seldate = new date_class("myform");
$seldate->demo ="";

//����ˬdjavascript �禡
$seldate->date_javascript();

//�ͤ�
$prove_date = $seldate->date_add("pro_date",$pro_date);

$seldate->do_check();

//�L�X���Y
head();
echo make_menu($school_menu_p);
//print_menu($student_menu_p);
?>

<script language="JavaScript">
function checkok()
{
	
	var OK=true;	
	if(document.myform.stud_class.value==0)
	{	alert('����ܯZ��');
		OK=false;
	}	
	if(document.myform.stud_id.value=='')
	{	alert('����ܾǥ�');
		OK=false;
	}	

	
	if (OK == true){
		OK=date_check();
	   }
	
	return OK;
	
	
	
}


function setfocus(element) {
	element.focus();
 return;
}
//-->
</script>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign=top bgcolor="#CCCCCC">
    <form name ="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" >
  <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr>
<td class=title_mbody colspan=2 align=center > �ǥͦb���ҩ��� </td>
</tr>
<tr>
<td align="right" class=title_sbody2  >�@�@�@�@�@��ܯZ��</td>
<td>
	<?php 
		//�C�X�Z��		
		echo  get_class_select($sel_year,$sel_seme,"","stud_class","this.form.submit",$stud_class);

	  ?>	    
    </td>
</tr>
<tr>
	<td class=title_sbody2>��ܾǥ�</td>
	<td>
	<?php 
	// source in include/PLlib.php    
	$temp_arr = explode("_",$stud_class);
	$temp_class = intval($temp_arr[2]).$temp_arr[3];
	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = 1 ;	     //��ܵ���
	$grid1->width = 1 ;	     //��ܼe	
	$grid1->dispaly_nav = false; // ��ܤU����s
	$grid1->bgcolor ="FFFFFF";
	$grid1->nodata_name ="�S���ǥ�";
	$grid1->top_option = "-- ��ܾǥ� --";
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select stud_id,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num from stud_base where  curr_class_num like '$temp_class%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O 
	$grid1->do_query(); //����R�O
//	echo $grid1->sql_str;
	$downstr = "<input type=hidden name=ckey value=\"$ckey\">";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��    
	
  ?>	
	</td>
</tr>

<tr>
	<td align="right" CLASS="title_sbody2">�ҩ��ت�</td>
	<td><input type="text" size="30" maxlength="30" name="purpose" value="<?php echo $tea1->Record[purpose] ?>"></td>
</tr>

<tr>
	<td class=title_sbody2>�ҩ����</td>
	
	<td><? echo "$prove_date";?>
</tr>

<tr>
    <td width="100%" align="center"  colspan="5" >
    <input type="hidden" name="set_id" value="<?php echo $_SESSION['session_log_id'] ?>">

    <?php	
    	echo "<input type=submit name=key value =\"$postProve\" onClick=\"return checkok();\">";   	
    ?>
    </td>
  </tr>
</table>
   �@</td>
  </tr>
<TR>
	<TD>
	<?php
		//reset($reward_good_arr);
		//while(list($tid,$tname)=each($reward_good_arr))
		//	$temp_reward_kind .="a.reward_kind = $tid or ";
		//$temp_reward_kind = substr($temp_reward_kind,0,-3);
		$query = "select a.*,b.stud_name,b.curr_class_num from stud_sta a ,stud_base b where a.student_sn=b.student_sn and a.prove_year_seme='$curr_seme' order by a.prove_date";

		$result = $CONN->Execute($query) or die ($query);
		if (!$result->EOF) {
			echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" bordercolorlight=\"#333354\" bordercolordark=\"#FFFFFF\"  width=\"100%\" class=main_body >";
			echo "<tr><td colspan=9 class=title_top1 align=center >���Ǵ��}�ߤ��b���ҩ�</td></tr>";
			echo "
			<TR class=title_mbody >
				<TD>�帹</TD>
				<TD>�Ǹ�</TD>
				<TD>�m�W</TD>
				<TD>�Z��</TD>
				<TD>�ҩ��ت�</TD>
				<TD>�ҩ����</TD>
				<TD>�ĤO</TD>
				<TD>�C�L</TD>
			</TR>";
		}
		$class_list_p = class_base();
		while(!$result->EOF) {
			$prove_id = $result->fields["prove_id"];
			$prove_id2 = sprintf("%03d",$prove_id);
			$stud_id = $result->fields["stud_id"];		
			$stud_name = $result->fields["stud_name"];
			$class_num = substr($result->fields["curr_class_num"],0,3);
			$stud_clss = $class_list_p[$class_num];
			$prove_year_seme = $result->fields["prove_year_seme"];
			$prove_date = DtoCh($result->fields["prove_date"]);
			$purpose = $result->fields["purpose"];
			$prove_cancel = $result->fields["prove_cancel"];
			$curr_seme_temp = sprintf("%03d",$curr_seme);
			echo ($i++ %2)?"<TR class=nom_1>":"<TR class=nom_2>";
			echo "			
					<TD>$prove_id2</TD>
					<TD>$stud_id</TD>
					<TD>$stud_name</TD>
					<TD>$stud_clss</TD>
					<TD>$purpose</TD>
					<TD>$prove_date</TD>";
			if ($prove_cancel ==0) {
				$prove_sta= "<a href=\"stud_sta.php?key=cancel&stud_id=$stud_id&prove_id=$prove_id&prove_cancel=1\" onClick=\"return confirm('�T�w�N $stud_name �b���ҩ��ѧ@�o �H');\">����</a>"; 
				}
			else  {
				$prove_sta= "<a href=\"stud_sta.php?key=cancel&stud_id=$stud_id&prove_id=$prove_id&prove_cancel=0\" onClick=\"return confirm('�T�w�� $stud_name �b���ҩ��ѥͮ� �H');\"><font color=red>�@�o</a>";
				}
			echo "<td>$prove_sta</td>";
			echo "<td><a href=\"stud_sta_rep.php?stud_id=$stud_id&prove_id=$prove_id\"  onClick=\"return confirm('�T�w�C�L $stud_name �b���ҩ��� �H');\">�ҩ���</a></TD>
				</TR>";
		
			$result->MoveNext();
		}
	?>
	</table>
	</TD>
</TR>
<TR>
	<TD></TD>
</TR>

</table>
</form>

<?php foot(); ?>
