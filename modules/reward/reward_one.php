<?php

// $Id: reward_one.php 8052 2014-06-03 23:54:43Z hsiao $

//���o�]�w��
include_once "config.php";

sfs_check();

//���o�Ǧ~�Ǵ�
$year_seme=$_REQUEST[year_seme];
if ($year_seme) {
	$sel_year=intval(substr($year_seme,0,3));
	$sel_seme=substr($year_seme,3,1);
} else {
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year];
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme];
}
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
//�B�z���
if ($_POST[temp_reward_date]) {
	$dd=explode("-",$_POST[temp_reward_date]);
	if ($dd[0]<1911) $dd[0]+=1911;
	$_POST[temp_reward_date]=implode("-",$dd);
}

//���o�s��ﶵ
$on_reward=$_REQUEST[on_reward];

//���o�B�z�Ҧ�
$act=$_REQUEST[act];
$chk_id=$_POST[chk_id];
if ($on_reward && !$_POST[past_on_reward] && $act!="�M�����e") $act="�T�w�s�W";

//�ϥΧֶK
if ($_POST['act_paste']) $act="�T�w�s�W";


//���o�ǥ;Ǹ�
if ($_POST[past_stud_id]!=$_REQUEST[One]) {
	$One=$_REQUEST[One];
	$focus_str="<body OnLoad='document.base_form.One.focus()'>";
	$focus=1;
} elseif ($_POST[past_stud_id]!=$_POST[stud_id])
	$One=$_POST[stud_id];
elseif (!empty($_REQUEST[reward_id])) {
	$query="select stud_id from reward where reward_id='$_REQUEST[reward_id]'";
	$res=$CONN->Execute($query);
	$One=$res->fields[stud_id];
} else {
	//�p�G�Z�ſ�����
	if ($_REQUEST[class_id]!=$_REQUEST[past_class_id]) {
		$class_id=$_REQUEST[class_id];
		$c=explode("_",$class_id);
		$seme_class=intval($c[2]).$c[3];
		$year_name=intval($c[2]);
		$class_name=intval($c[3]);
		//$class_num="";
		//$One="";
                //�ץ����ܯZ�ſ��ɤ��|�Y����ܾǸ����D
                //$class_num="01";
                //�ץ��p�G1����ǫ���ܿ��|�o�ͯZ�Ÿ��������D
                $class_num=$CONN->Execute("select a.seme_num from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' and b.student_sn=a.student_sn and b.stud_study_cond='0'")->fields[seme_num];
                $sql="select a.stud_id,b.stud_study_cond from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' and a.seme_num='$class_num' and b.student_sn=a.student_sn and b.stud_study_cond='0'";
                $rs=$CONN->Execute($sql);
                $stud_id=$rs->fields[stud_id];
                if (!empty($stud_id)) $One=$stud_id;
                $focus_str="<body OnLoad='document.base_form.One.focus()'>";
                $focus=1;
	} else {
		//���o�~�ůZ�Ůy��
		$year_name=intval($_POST[year_name]);
		$class_name=$_POST[class_name];
		$class_num=$_POST[class_num];

		//�B�z�ꤤ���T�~��
		if ($year_name) $year_name+=$IS_JHORES;

		//�p�G�Z�ſ��S���ܡA����J�~�šB�Z�šB�y��
		if ($year_name && $class_name && $class_num) {
			$seme_class=$year_name.sprintf("%02d",$class_name);
			$seme_num=sprintf("%02d",$class_num);
			$sql="select a.stud_id,b.stud_study_cond from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' and a.seme_num='$seme_num' and b.student_sn=a.student_sn and b.stud_study_cond='0'";
			$rs=$CONN->Execute($sql);
			$stud_id=$rs->fields[stud_id];
			if (!empty($stud_id)) $One=$stud_id;
			$focus_str="<body OnLoad='document.base_form.year_name.focus()'>";
			$focus=2;
		}
	}
}

//���o�g��
$weeks_array=get_week_arr($sel_year,$sel_seme,$_POST[temp_reward_date]);
$sel_week=$_REQUEST[sel_week];
if ($sel_week) $weeks_array[0]=$sel_week;
if ($weeks_array[0]=="") $weeks_array[0]=1;
$sel_week=$weeks_array[0];

//�p�G�S���Ǹ��]�S���Z��
if (empty($One) && empty($class_id)) {
	$sql="select stud_id from stud_seme where seme_year_seme='$seme_year_seme' order by seme_class,seme_num";
	$rs=$CONN->Execute($sql);
	$One=$rs->fields[stud_id];
}

//�p�G���Ǹ�
if ($One) {
	$sql="select student_sn,seme_class,seme_num from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$One'";
	$rs=$CONN->Execute($sql);
	$student_sn=$rs->fields[student_sn];
	if (!$student_sn) 
		$One="";
	else {
		$seme_class=$rs->fields[seme_class];
		$year_name=intval(substr($seme_class,0,-2));
		$class_name=intval(substr($seme_class,-2,2));
		$class_num=intval($rs->fields[seme_num]);
	}
}

//�Y�����M���Ҧ��h���o���e 
if ($act!="�M�����e" && ($act=="�T�w�s�W" || $act=="�T�w�ק�" || $on_reward)) {
	//���o���g���e
	$reward_kind=$_POST[reward_kind];
	$reward_reason=$_POST[reward_reason];
	$reward_base=$_POST[reward_base];
	$reward_date=$_POST[temp_reward_date];
	$reward_bonus=$_POST[reward_bonus];
}

//����ʧ@�P�_
if($act=="edit"){
	$main=&mainForm($sel_year,$sel_seme,$_REQUEST[class_id],$One,$_REQUEST[reward_id]);
}elseif($act=="�T�w�s�W"){
	if ($_POST['act_paste']) {
	
	 //�ֶK�覡
	 /* �ɤJ���ܼ�
    $reward_kind => 4  ���Һ���
    $year_seme => 1021  �Ǧ~�Ǵ�
    $One => 20001			stud_id
    $reward_reason =>  �ƥ�
    $reward_base =>    �̾�
    $reward_date] =>   ��� �ন�褸
 
	 */
	$data_array=explode("\n",$_POST['data_array']);
	//�O���w�s�J�X�����
	$Insert_rec=0; 
	foreach ($data_array as $OneData) {
	 if (trim($OneData)=="") continue;
	 $O=explode("\t",$OneData);
	 foreach ($O as $k=>$v) {
	  $ONE[$k]=trim($v);
	 }
	 $seme_year_seme=$reward_year_seme=$ONE[0];
	 $sel_year=substr($seme_year_seme,0,3);
	 $sel_seme=substr($seme_year_seme,-1);
	 //�~�ŧO,�Y���ꤤ�A��J 1,2,3 �۰ʥ[ 6
		if($IS_JHORES>=6) {
	 	 $ONE[1]=($ONE[1]>6)?$ONE[1]:$ONE[1]+6;
		}
  //�Z��
		$seme_class=sprintf("%1d%02d",$ONE[1],$ONE[2]);
	//�y��
		$seme_num=$ONE[3];
	 //���o�ǥ;Ǹ���student_sn
	 $query="select student_sn,stud_id from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$seme_class' and seme_num='$seme_num'";
	 $res=$CONN->Execute($query) or die($query);
	 $student_sn=$res->fields['student_sn'];
	 $One=$res->fields['stud_id'];
	 
	 //���g���e
	 $reward_reason=$ONE[5];
	 //���g����
	 $reward_kind=0;
	 foreach ($reward_arr as $k=>$v) {
	   if ($v==stripslashes($ONE[6])) { $reward_kind=$k; break; }
	 }
	 
	 //���g�̾�
	 $reward_base=$ONE[7];
	 //���
		$dd=explode("-",$ONE[8]);
		if ($dd[0]<1911) $dd[0]+=1911;  //�ഫ���褸
		$reward_date=implode("-",$dd);
   //�}�l	
   if (!empty($One) && !empty($reward_kind) && !empty($reward_reason) && !empty($reward_base)){
		$reward_div=($reward_kind>0)?"1":"2";
		$reward_sub=1;
		$reward_c_date=date("Y-m-j");
		$reward_ip=getip();
		$query="insert into reward (reward_div,stud_id,reward_kind,reward_year_seme,reward_date,reward_reason,reward_c_date,reward_base,reward_cancel_date,update_id,update_ip,reward_sub,dep_id,student_sn,reward_bonus) values ('$reward_div','$One','$reward_kind','$reward_year_seme','$reward_date','$reward_reason','$reward_c_date','$reward_base','0000-00-00','$_SESSION[session_log_id]','$reward_ip','$reward_sub','0','$student_sn','$_POST[reward_bonus]')";
		//echo $query."<br>";
		
		$res=$CONN->Execute($query);
		$dep_id=$CONN->Insert_ID();
		$query="update reward set dep_id='$dep_id' where reward_id='$dep_id'";
		$CONN->Execute($query);
		cal_rew($sel_year,$sel_seme,$One);
    $Insert_rec++;
   }
	 
	} // end foreach
   $INFO="�w�Q�ξ��ֶK�覡, �إ�".$Insert_rec."�����, �аȥ��չ��ƥ��T��!";
	} else {
	 //�ӤH���g�Ҧ�
	 if (!empty($One) && !empty($reward_kind) && !empty($reward_reason) && !empty($reward_base)){
		$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
		$reward_year_seme=$sel_year.$sel_seme;
		$query="select student_sn from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$One'";
		$res=$CONN->Execute($sql);
		$student_sn=$res->fields[student_sn];
		$reward_div=($reward_kind>0)?"1":"2";
		$reward_sub=1;
		$reward_c_date=date("Y-m-j");
		$reward_ip=getip();
		$query="insert into reward (reward_div,stud_id,reward_kind,reward_year_seme,reward_date,reward_reason,reward_c_date,reward_base,reward_cancel_date,update_id,update_ip,reward_sub,dep_id,student_sn,reward_bonus) values ('$reward_div','$One','$reward_kind','$reward_year_seme','$reward_date','$reward_reason','$reward_c_date','$reward_base','0000-00-00','$_SESSION[session_log_id]','$reward_ip','$reward_sub','0','$student_sn','$_POST[reward_bonus]')";
		$res=$CONN->Execute($query);
		$dep_id=$CONN->Insert_ID();
		$query="update reward set dep_id='$dep_id' where reward_id='$dep_id'";
		$CONN->Execute($query);
		cal_rew($sel_year,$sel_seme,$One);
	 }
  }
	
	$main=&mainForm($sel_year,$sel_seme,$_REQUEST[class_id],$One,$dep_id);
}elseif($act=="�T�w�ק�"){
	$reward_id=$_POST[reward_id];
  //�ˬd�O�_��Ʀ����, �Y�����, ���A�k�ݩ������g, �� dep_id �אּ�ۤv�� reward_id
	 $dep_id="";
	 $query="select reward_kind from reward where reward_id='$reward_id'";
	 $res=$CONN->Execute($query);
	 list($reward_kind1)=$res->fetchRow();
   if ($reward_kind!=$reward_kind1) {
     $dep_id=",dep_id='".$reward_id."'";
   }
	$reward_div=($reward_kind>0)?"1":"2";
	$query="update reward set reward_div='$reward_div',reward_kind='$reward_kind',reward_reason='$reward_reason',reward_base='$reward_base',reward_date='$reward_date',reward_bonus='$reward_bonus'".$dep_id." where reward_id='$reward_id'";
	$CONN->Execute($query);
	cal_rew($sel_year,$sel_seme,$One);
	$main=&mainForm($sel_year,$sel_seme,$_REQUEST[class_id],$One,$reward_id);
}elseif($act=="del"){
	del_one($sel_year,$sel_seme,$_REQUEST[reward_id]);
	$main=&mainForm($sel_year,$sel_seme,$_REQUEST[class_id],$One,"");
}else{
	$main=&mainForm($sel_year,$sel_seme,$_REQUEST[class_id],$One,"");
}


//�q�X����
head("�ӤH���g�n�O");
if ($on_reward) echo $focus_str;
echo $main;
foot();
?>

<Script>
	$("#go_paste_form").click(function(){
	 paste_form.style.display='block';	
	 reward_form.style.display='none';		
	})
	
	$("#go_reward_form").click(function(){
	 paste_form.style.display='none';	
	 reward_form.style.display='block';		
	})

</Script>


<?php
//�D�n��J�e��
function &mainForm($sel_year,$sel_seme,$class_id="",$One="",$reward_id=""){
	global $student_menu_p,$CONN,$year_name,$class_name,$class_num,$reward_arr,$sel_week,$on_reward,$reward_kind,$reward_reason,$reward_base,$reward_date,$focus,$IS_JHORES;
	global $INFO;
	//�����\���
	$tool_bar=&make_menu($student_menu_p);

	//�O�_���ק�Ҧ�
	if ($reward_id) {
		$query="select * from reward where reward_id='$reward_id'";
		$res=$CONN->Execute($query);
		$One=$res->fields[stud_id];
		$reward_kind=$res->fields[reward_kind];
		$reward_reason=$res->fields[reward_reason];
		$reward_base=$res->fields[reward_base];
		$reward_date=$res->fields[reward_date];
		$reward_bonus=$res->fields[reward_bonus];
		$submit_msg="�T�w�ק�";		
	} else {
		$submit_msg="�T�w�s�W";
	}

	//�Ǧ~�Ǵ����
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$year_seme_p=get_class_seme();
	$year_seme_select = "<select name='year_seme' onchange='this.form.submit()';>\n";
	while (list($k,$v)=each($year_seme_p)){
		if ($seme_year_seme==$k)
	      		$year_seme_select.="<option value='$k' selected>$v</option>\n";
	      	else
	      		$year_seme_select.="<option value='$k'>$v</option>\n";
	}
	$year_seme_select.= "</select>"; 

	//���X���T�Z�ťN�X
	if (!empty($One)) {
		$sql="select seme_class from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='$One'";
		$rs=$CONN->Execute($sql);
		$seme_class=$rs->fields[seme_class];
		$year_name=intval(substr($seme_class,0,-2));
		$class_name=intval(substr($seme_class,-2,2));
		$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$year_name,$class_name);
	}
	$year_name-=$IS_JHORES;

	//���o�ӯZ�ξǥͦW��A�H�ζ�g���
	$signForm=&signForm($sel_year,$sel_seme,$class_id,$One,$reward_id);

	//�~�ŻP�Z�ſ��
	$class_select=&classSelect($sel_year,$sel_seme,"","class_id",$class_id,true);
	$stud_select=get_stud_select($class_id,$One,"stud_id","this.form.submit",1);

	//���g���
	$sel1 = new drop_select(); //������O
	$sel1->s_name = "reward_kind"; //���W��	
	$sel1->id = $reward_kind; //�w�]�ﶵ	
	$sel1->arr = $reward_arr; //���e�}�C		
	$sel1->top_option = "-- ��ܼ��g --";
	$reward_select=$sel1->get_select();

	// ����禡
	if ($reward_date=="") $reward_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$seldate=new date_class("myform");
	$seldate->demo="";

	//���g���
	$date_input=$seldate->date_add("reward_date",$reward_date);
	
	//�K�դJ�ǿn���ĭp
	$reward_bonus=$reward_bonus==='0'?0:1;
	$bonus_input="<input type='radio' name='reward_bonus' value='1' ".($reward_bonus?'checked':'').">�O <input type='radio' name='reward_bonus' value='0' ".($reward_bonus?'':'checked').">�_ ";

	//�s��ﶵ���p
	$chk_r=($on_reward)?"checked":"";
	if ($on_reward)
		if ($focus==1)
			$One="";
		elseif ($focus==2) {
			$year_name="";
			$class_name="";
			$class_num="";
		}

	$main="
	$tool_bar";
	if ($INFO!="") {
	$main.="<font color=red>$INFO</font>";
	}
	$main.="
	<table border='0'>
	<!-- �ӤH���g��� -->
	<form action='$_SERVER[SCRIPT_NAME]' name='base_form' method='post'>
	<tr id='reward_form'>
	<td>
	<table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>
	<tr class='title_sbody2'>
	<td>�п�Ǧ~��<td align='left' bgcolor='white' colspan='2'>$year_seme_select<input type='hidden' name='reward_kind' value='$reward_kind'><input type='hidden' name='reward_reason' value='$reward_reason'><input type='hidden' name='reward_base' value='$reward_base'><input type='hidden' name='temp_reward_date' value='$reward_date'>
	</tr>
	<tr class='title_sbody2'>
	<td>�п�Z�ũM�m�W<td align='left' bgcolor='white' colspan='2'>$class_select $stud_select<input type='hidden' name='past_class_id' value='$class_id'>
	</tr>
	<tr class='title_sbody2'>
	<td>�Ϊ�����J�Ǹ�<td align='left' bgcolor='white' colspan='2'><input type='text' size='10' maxsize='10' name='One' value='$One'><input type='hidden' name='past_stud_id' value='$One'>
	</tr>
	<tr class='title_sbody2'>
	<td>�Ϊ�����J�Z�Ůy��<td align='left' bgcolor='white' colspan='2'><input type='text' size='2' maxsize='2' name='year_name' value='$year_name'> �~�� <input type='text' size='2' maxsize='2' name='class_name' value='$class_name'> �Z <input type='text' size='2' maxsize='2' name='class_num' value='$class_num'> �� <input type='submit' value='�T�w'>
	</tr>";
	if (!empty($reward_kind) || !empty($reward_reason) || !empty($reward_base))
		$main.="<tr class='title_sbody2'><td>�s��ﶵ<td align='left' bgcolor='white' colspan='2'><input type='checkbox' name='on_reward' $chk_r onClick='this.form.submit()'>�s���J���g���<input type='hidden' name='past_on_reward' value='".(!$on_reward)."'></tr>";
	$main.="
	</form>
	<form action='$_SERVER[SCRIPT_NAME]' method='post' name='reward_one_form'>
	<tr class='title_sbody2'>
	<td>���g���O<td align='left' bgcolor='white'>$reward_select<td align='left' bgcolor='white' rowspan='5' valign='bottom'>
	<input type='submit' name='act' value='$submit_msg'><br>
	<input type='submit' name='act' value='�M�����e'><br>
	<input type='button' name='past_form' id='go_paste_form' value='���ֶK'>
	<input type='hidden' name='reward_id' value='$reward_id'>
	<input type='hidden' name='year_seme' value='$seme_year_seme'>
	<input type='hidden' name='One' value='$One'>
	<input type='hidden' name='on_reward' value='$on_reward'>
	</tr>
	<tr class='title_sbody2'>
	<td>���g�ƥ�<td align='left' bgcolor='white'><input type='text' name='reward_reason' value='$reward_reason' size='50' >
	</tr>
	<tr class='title_sbody2'>
	<td>���g�̾�<td align='left' bgcolor='white'><input type='text' name='reward_base' value='$reward_base' size='50' >
	</tr>
	<tr class='title_sbody2'>
	<td>���g���<td align='left' bgcolor='white'>$date_input
	</tr>
	<tr class='title_sbody2'>
	<td>�K�դJ�ǿn���ĭp<td align='left' bgcolor='white'>$bonus_input
	</tr>
	</table>
	</td>
	</tr>
	<tr id='paste_form' style='display:none'>
	<td>
  <!-- �ֶK��� -->	
	<table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2'>
	<input type='hidden' name='act_paste' value=''>
		<tr class='title_sbody2'>	
			<td align='left'>���ֶK�G�Ш�<a href='images/paste_demo.xls'>�d����</a>�K�W���.</td>
			<td align='right'>
				<input type='button' value='�e�X���' onclick='document.reward_one_form.act_paste.value=1;document.reward_one_form.submit()'>
				<input type='button' value='�^�ӤH�n�O' id='go_reward_form'>
			</td>
		</tr>
		<tr class='title_sbody2'>	
			<td colspan='2'><textarea name='data_array' rows='8' cols='80'></textarea></td>
		</tr>
		<tr class='title_sbody2'>
		<td colspan='2' align='left'><font color=red>1.�Q�ΧֶK, �i�ֳt�Ӥj�q���إ߾ǥͼ��g����.<br>2.�`�N! �j�q�K�W��, �B�z�ɶ�����, �Э@�ߵ��ԡC</font></td>
		</tr>
	</table>
	</tr>
	</form>
  </table>	
	$signForm
	";
	return $main;
}

//���o�ӯZ�ξǥͦW��A�H�ζ�g���
function &signForm($sel_year,$sel_seme,$class_id,$One="",$id=""){
	global $CONN,$weekN,$weeks_array,$reward_arr,$sel_week,$class_year;
	
	//���o�ǥͰ}�C
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$all_sn="";
	$query="select * from stud_seme where seme_year_seme='$seme_year_seme' order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$student_sn=$res->fields[student_sn];
		$seme_class[$stud_id]=$res->fields[seme_class];
		$seme_num[$stud_id]=$res->fields[seme_num];
		$all_sn.="'".$student_sn."',";
		$res->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	$query="select stud_id,stud_name from stud_base where student_sn in ($all_sn)";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$stud_name[$stud_id]=addslashes($res->fields[stud_name]);
		$res->MoveNext();
	}

	//���o�Z�Ű}�C
	$query="select class_id,c_name from school_class where year='$sel_year' and semester='$sel_seme' order by class_id";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$class_id=$res->fields[class_id];
		$c=explode("_",$class_id);
		$c_year=intval($c[2]);
		$class_name[$c_year.$c[3]]=$class_year[$c_year].$res->fields[c_name]."�Z";
		$res->MoveNext();
	}

	//�g�O���
	$year_seme=sprintf("%03d",$sel_year).$sel_seme;
	while (list($k,$v)=each($weeks_array)) {
		if ($k!=0) {
			if ($k==$weeks_array[0]) {
				$weeks_url.="<font color='#ff0000'>".$k."</font>, ";
			} else 
				$weeks_url.="<a href={$_SERVER['SCRIPT_NAME']}?sel_week=$k&year_seme=$year_seme&stud_id=$One>".$k."</a>, ";
		}
	}
	$weeks_url=substr($weeks_url,0,-2);
	$sw1=$weeks_array[0];
	$sw2=$sw1+1;
        $last_str=($sw2<count($weeks_array))?"and a.reward_date<'$weeks_array[$sw2]'":"";

	//��ܸ��
	$reward_year_seme=$sel_year.$sel_seme;
	$reward_data="";
	$query="select a.* from reward a inner join stud_seme b on a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' where a.reward_year_seme='$reward_year_seme' and a.reward_date>='$weeks_array[$sw1]' $last_str and dep_id=reward_id order by b.seme_class,b.seme_num";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$reward_id=$res->fields[reward_id];
		$reward_kind=$res->fields[reward_kind];
		$bgcolor=($reward_kind>0)?"#FFE6D9":"#E6F2FF";
		$bgcolor=$res->fields[reward_bonus]?$bgcolor:'#dddddd';
		$reward_bonus=$res->fields[reward_bonus]?"<img src='images/ok.png'>":"";		
		if ($reward_id==$id) $bgcolor="#FFFF00";
		$stud_id=$res->fields[stud_id];
		$cancel_date=$res->fields[reward_cancel_date];
		if ($reward_kind>0) {
			$cancel_date="-----";
			$oo_path="good";
		} else {
			if ($cancel_date=="0000-00-00")
				$cancel_date="���P�L";
			else
				$cancel_date=DtoCh($cancel_date);
			$oo_path="bad";
		}
		$url_str="$_SERVER[SCRIPT_NAME]?sel_year=$sel_year&sel_seme=$sel_seme&sel_week=$sel_week&reward_id=$reward_id";
		$chked=($chk_id[$reward_id])?"checked":"";
		$reward_data.="
		<tr bgcolor=$bgcolor>
		<td><input type='checkbox' name='chk_id[".$reward_id."] $chked'>
		<td>$stud_id
		<td>".$stud_name[$stud_id]."
		<td>".$class_name[$seme_class[$stud_id]]."
		<td>".$seme_num[$stud_id]."
		<td>".addslashes($reward_arr[$reward_kind])."
		<td width='150'>".addslashes($res->fields[reward_reason])."
		<td width='150'>".addslashes($res->fields[reward_base])."
		<td>".DtoCh($res->fields[reward_date])."
		<td>$cancel_date
		<td align='center'>$reward_bonus
		<td><a href=$url_str&act=edit><img src='images/edit.png' border='0' alt='�ק�'></a> <a href=$url_str&act=del onClick=\"return confirm('�T�w�R��".$stud_name[$stud_id]."���o�@���O��?')\"><img src='images/del.png' border='0' alt='�R��' ></a> <a href=reward_rep.php?stud_id=$stud_id&reward_id=$reward_id&oo_path=$oo_path><img src='images/print.png' border='0' alt='�C�L�q����'></a></tr>";
		$res->MoveNext();
	}
	$main="
	<table cellspacing='0' cellpadding='0'0class='small'>
	<tr><td valign='top'>
		<table cellspacing='1' cellpadding='3' bgcolor='#9ebcdd' class='small'>
		<form action='$_SERVER[SCRIPT_NAME]' method='post' name='myform'>
		<tr class='title_sbody1'>
		<td colspan='12' align='left'>�g��&gt;$weeks_url
		</tr>
		<tr class='title_sbody2'>
		<td align='left'>���</td>
		<td align='left'>�Ǹ�</td>
		<td align='left'>�m�W</td>
		<td align='left'>�Z��</td>
		<td align='left'>�y��</td>
		<td align='left'>���g���O</td>
		<td align='left'>���g�ƥ�</td>
		<td align='left'>���g�̾�</td>
		<td align='left'>���g���</td>
		<td align='left'>�P�L���</td>
		<td align='left'>�n���ĭp</td>
		<td align='left'>�\��ﶵ</td>
		</tr>
		".stripslashes($reward_data)."
		</table>
	</td><td valign='top'>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<input type='hidden' name='class_id' value='$class_id'>";
	$main.="
	</form>
	</td></tr>
	</table>
	";
	return $main;
}

function del_one($sel_year,$sel_seme,$reward_id) {
	global $CONN;

	$query="select stud_id from reward where reward_id='$reward_id'";
	$res=$CONN->Execute($query);
	$One=$res->fields[stud_id];
	$query="delete from reward where reward_id='$reward_id'";
	$CONN->Execute($query);
	cal_rew($sel_year,$sel_seme,$One);
}
?>

<script language="JavaScript">
function checkok()
{
	var OK=true;
	if(document.myform.id.value=='')
	{
		if(document.myform.stud_class.value==0)
		{	alert('����ܯZ��');
			OK=false;
		}	
		if(document.myform.stud_id.value=='')
		{	alert('����ܾǥ�');
			OK=false;
		}	
	}
	if(document.myform.reward_kind.value=='')
	{	alert('��������O');
		OK=false;
	}	
	if(document.myform.reward_reason.value=='')
	{	alert('����ƥ�');
		OK=false;
	}	
	if(document.myform.reward_base.value=='')
	{	alert('����̾�');
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
