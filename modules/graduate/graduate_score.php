<?php

// $Id: graduate_score.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

if($_GET['class_year_b']) $class_year_b=$_GET['class_year_b'];
else $class_year_b=$_POST['class_year_b'];
if($_GET['select_seme_year']) $select_seme_year=$_GET['select_seme_year'];
else $select_seme_year=$_POST['select_seme_year'];
if($_GET['Cyear'] || $_GET['Cyear']=="0") $Cyear=$_GET['Cyear'];
else $Cyear=$_POST['Cyear'];
if($Cyear!="") $Cyear=intval($Cyear);
if($_GET['class_id']) $class_id=$_GET['class_id'];
else $class_id=$_POST['class_id'];
if($_GET['Sweight']) $Sweight=$_GET['Sweight'];
else $Sweight=$_POST['Sweight'];
if($_GET['Wyear']) $SWyear=$_GET['Wyear'];
else $Wyear=$_POST['Wyear'];
if($_GET['Wclass']) $Wclass=$_GET['Wclass'];
else $Wclass=$_POST['Wclass'];
if($_GET['view']) $view=$_GET['view'];
else $view=$_POST['view'];
while(list($key , $val) = each($_POST['ss_id'])) {
	$w_ss_id[$key]=$val;
}

//�ϥΪ̻{��
sfs_check();
//�{�����Y
head("���~�ͧ@�~");

print_menu($menu_p);
//�]�w�D������ܰϪ��I���C��
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";

//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$new_sel_year=date("Y")-1911;//�ثe����~

if($Sweight=="�T�w"){
	if($Wyear){
		$seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);		
		//���ӧ�stud_id��stud_seme
		$sql_stid="select stud_id from stud_seme where seme_year_seme='$seme_year_seme' and seme_class like '$Wyear%'";
		//echo $sql_stid."<br>";
		$rs_stid=$CONN->Execute($sql_stid);
		$a=0;
		while(!$rs_stid->EOF){
			$stud_id[$a]=$rs_stid->fields['stud_id'];//�{�b����ss_id�N�ӥi��|���link_ss�A�H��[�q��
			//�ഫstud_id��student_sn
			 $student_sn[$a]=stud_id2student_sn($stud_id[$a]);
			//echo $student_sn[$a]."<br>";
			$stud_name[$a]=stud_name($stud_id[$a]);			
			echo "<br>�}�l�� ".$stud_name[$a].$stud_id[$a]." �����Z�ơI<br>";
			reset($w_ss_id);
			$b=0;
			while(list($key[$a] , $val[$a]) = each($w_ss_id)) {
				if($val[$a]=="0") continue;
				//echo $key."=>".$val."<br>" ;
				//��stud_seme_score��ӥͨC�@�Ǵ����`���Z
				$sql_seme_score="select ss_score from stud_seme_score where student_sn='$student_sn[$a]' and ss_id='$key[$a]'";
				//echo $sql_seme_score."<br>";
				$rs_seme_score=$CONN->Execute($sql_seme_score);
				$ss_score[$a][$b]=$rs_seme_score->fields['ss_score'];
				$grad_score[$stud_id[$a]]=$grad_score[$stud_id[$a]]+$ss_score[$a][$b]*$val[$a];
				$Weight[$a]=$Weight[$a]+$val[$a];
				if($ss_score[$a][$b]=="") $ss_score[$a][$b]="0";
				echo ss_id_to_year_seme($key[$a]).ss_id_to_subject_name($key[$a])."�G".$ss_score[$a][$b]."*".$val[$a]."=".$ss_score[$a][$b]*$val[$a]."<br>";
			}
			$average_score[$a]=$grad_score[$stud_id[$a]]/$Weight[$a];
			echo "�`���G".$grad_score[$stud_id[$a]]."<br>";
			echo "�����G".$average_score[$a]."<br>";
			echo "�N�����g�J���~�͸�ƪ�grad_stud(�p�G�Ӳ��~�ͦs�b����).............<br>";
			$CONN->Execute("UPDATE grad_stud SET grad_score ='$average_score[$a]' WHERE stud_id= '$stud_id[$a]' ");
			$rs_stid->MoveNext();
			$a++;
		}		

	}
	elseif($Wclass){
		while(list($key , $val) = each($w_ss_id)) {
			echo $key."=>".$val."<br>" ;		
		}			
	}
}
else{
	//��ܦ~��
	$class_year_menu=&get_class_year_select($sel_year,$sel_seme,$Cyear,$jump_fn="jumpMenu1",$col_name="Cyear");
	echo "
		<table cellspacing=0 cellpadding=2><tr><td align='left' width='10%' nowrap>
		<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
		�п�ܭn�p�Ⲧ�~���Z��$class_year_menu</form></td>";

	//��ܯZ��

	$class_select_menu=&get_class_select($sel_year,$sel_seme,$Cyear,$col_name="class_id",$jump_fn="jumpMenu2",$class_id,$mode="��");
	echo "
		<td  align='left' width='10%' nowrap>
		<form name='form2' method='post' action='{$_SERVER['PHP_SELF']}'>
		��$class_select_menu
		<input type='hidden' name='Cyear' value='$Cyear'>
		</form></td>
	";
	echo "<td><a href='view_grad_score.php'><button>�[�ݲ��~���Z</button></a></td></tr>";
	//�C�X�Ӧ~�ũҦ��ǥ�

	if($Cyear=="" && $class_id=="") echo "</table>";
	else{
		echo "<tr><td colspan='2'><form name='weight_f' method='post' action='{$_SERVER['PHP_SELF']}'></td></tr>";
		if($class_id) {
			$class_id_A=explode("_",$class_id);
			$Cyear=intval($class_id_A[2]);
			$ben=$class_id_A[3];
		}	
		for($i=$Cyear;$i>0;$i--,$sel_year--){//�Ǧ~
			for($j=2;$j>0;$j--){//�Ǵ�
				//echo $sel_year."---".$j."---".$i."<br>";
				if($class_id) $sql_ss="select ss_id,rate from score_ss where year='$sel_year' and semester='$j' and class_year='$i'  and class_id like '%$ben' and enable='1' and  need_exam='1'";
				else $sql_ss="select ss_id,rate from score_ss where year='$sel_year' and semester='$j' and class_year='$i' and enable='1' and  need_exam='1'";				
				//�ثe��ܯZ�ťi���ٵL�@�Φ��O���F�]���N�ӽҵ{�i��O�H�Z�Ŭ����Ӱ��]�w�G�d�U���@�ﶵ
				$rs_ss=$CONN->Execute($sql_ss);
				$m=$rs_ss->fields['ss_id'];				
				$bgcolor=($j==1)?"bgcolor='#FFF589'":"bgcolor='#FCA4FF'";
				if($m!="") echo "<tr $bgcolor><td colspan='3'>".$i."�~�Ų�".$j."�Ǵ��G&nbsp;&nbsp;&nbsp;&nbsp;";
				$k=0;
				while(!$rs_ss->EOF){
					$ss_id[$k]=$rs_ss->fields['ss_id'];//�{�b����ss_id�N�ӥi��|���link_ss�A�H��[�q��
					$R[$k]=$rs_ss->fields['rate'];//�ӽҵ{���Ǥ���
					echo "&nbsp;&nbsp;".ss_id_to_subject_name($ss_id[$k])."*";
					echo "<input type='text' name='ss_id[$ss_id[$k]]' value='$R[$k]' size='2' maxlength='2'>\n";
					$rs_ss->MoveNext();
					$k++;
				}
				if($m!="") {echo "</td></tr>"; $mm++;}

			}
			//echo $i."�~��<br>";
		}
		if($mm>0) {
			echo "<tr><td colspan='2'><input type='hidden' name='Wclass' value='$class_id'><input type='hidden' name='Wyear' value='$Cyear'><input type='submit' name='Sweight' value='�T�w'></form></td></tr>";
			echo "<tr><td colspan='2'><br>�ާ@�����G<br>
									<li>�b�z�Q�n�[�J�p�Ⲧ�~���Z���ҵ{�k������J�[�v�ơA�Y�[�v�Ƭ�0��ܦ��@�ҵ{���C�J���~���Z���p��C</li>
									<li>�{���w�]�Ҧ��ҵ{�x�C�J���~���Z���p��B�[�v�Ƭ�1</li></td></tr>";
		}	
		else    { echo "</table></table>";  trigger_error("�z�ҿ諸�~�ũίZ�ŨS������ҵ{�]�w�A�Э��s�ާ@�I<br>".$sql_ss,E_USER_ERROR); }
		echo "</table>";
	}
}
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();
?>

<script language="JavaScript1.2">
<!-- Begin

function jumpMenu1(){
	var str, classstr ;
 if (document.form1.Cyear.options[document.form1.Cyear.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?Cyear=" + document.form1.Cyear.options[document.form1.Cyear.selectedIndex].value;
	}
}

function jumpMenu2(){
	var str, classstr ;
    if (document.form2.class_id.options[document.form2.class_id.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?class_id=" + document.form2.class_id.options[document.form2.class_id.selectedIndex].value;
	}
}
//  End -->
</script>
