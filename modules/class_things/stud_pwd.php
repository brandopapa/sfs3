<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("���ǥ͵n�J�K�X");

//�Ҳտ��
print_menu($menu_p,$linkstr);


if($is_pwd){
	$student_sn=$_POST['student_sn'];
	//�x�s�����B�z
	if($student_sn and $_POST['go']=='���K�X'){
		$login_pass=$_POST[login_pass];
		if(strlen($login_pass)>=6){
			$login_pass2=$_POST[login_pass2];
			if($login_pass and $login_pass==$login_pass2){
				$ldap_password = createLdapPassword($login_pass);
				$query="update stud_base set email_pass ='$login_pass', ldap_password='$ldap_password' where student_sn=$student_sn";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$msg='�K�X��令�\�I';
				
				//��s�ǥ� sha key 2014.10.07 *********************/
				$query = "SELECT stud_person_id FROM stud_base where student_sn='$student_sn' ";
				$res = $CONN->Execute($query) or die($query);
				$row=$res->FetchRow();
      	if ($row['stud_person_id']!="") {
				 	$stud_person_id = hash('sha256', strtoupper($row['stud_person_id']));
				 	$sql = "UPDATE stud_base SET edu_key='$stud_person_id' WHERE student_sn='$student_sn'";
					$CONN->Execute($sql) ;
			 	}			
				
			} else $msg='�s�K�X�B�T�{�s�K�X���P�A��異�ѡI';
		} else $msg='�s�K�X���פӵu�A��異�ѡI  �Цܤֿ�J6�Ӧr��';
	}
		
		
	$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
	//��X���ЯZ��
	$class_name=teacher_sn_to_class_name($teacher_sn);
	$class_id=$class_name[0];
	$curr_year_seme=sprintf('%03d%d',curr_year(),curr_seme());

	if($class_id){
		//���;ǥͦW��
		$query="select a.student_sn,a.seme_num,b.stud_name,b.stud_sex from `stud_seme` a inner join stud_base b on a.student_sn=b.student_sn where seme_year_seme='$curr_year_seme' and seme_class='{$class_id}' order by a.seme_num";
		$res=$CONN->Execute($query) or die("SQL���~�G<br>$query");
		$student_select="<select name='student_sn' onchange='this.form.submit()'><option value=''>- �п�ܾǥ� -</option>";
		while(!$res->EOF){
			$selected=($student_sn==$res->fields['student_sn'])?'selected':'';
			$color=($res->fields['stud_sex']==1)?'#0000ff':'#ff0000';
			$color=($student_sn==$res->fields['student_sn'])?'#00ff00':$color;
			$student_select.="<option value='{$res->fields['student_sn']}' $selected bgcolor='$color'>({$res->fields['seme_num']}) {$res->fields['stud_name']}</option>";
			$res->MoveNext();
		}
		$student_select.="</select>";
	}

	if($student_sn){
	$mydata="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>
		<tr align='center'><td bgcolor='#ccccff'>��J�s�K�X</td><td><input type='password' size='32' maxlength='32' name='login_pass'></td></tr>
		<tr align='center'><td bgcolor='#ccccff'>�T�{�s�K�X</td><td><input type='password' size='32' maxlength='32' name='login_pass2'></td></tr>
		<tr bgcolor='#ccccff' align='center'>
			<td colspan=2>
				<input type='submit' value='���K�X' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#ff5555; font-size:16px; height=42'>
			</td>
		</tr></table>";
	}

	$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>�n���K�X���ǥ͡G $student_select <br> $mydata<br>$msg</font></form>";
} else $main="<BR><center><font color=red size=4>�Ҳ��ܼƩ|���}�񥻥\��A�Ь��߾Ǯըt�κ޲z�̡I</font></center>";

echo $main;

foot();

?>
