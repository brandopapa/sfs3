<?php

// $Id:  $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_score.php";

sfs_check();

//�����X
if($_POST['go']=='�����X'){
	$new_page="<p STYLE='page-break-after: always;'>";
	foreach($_POST['student_sn'] as $student_sn){
		//page 1
		//����ǥͰ򥻸��
		$query="SELECT stud_name, stud_addr_1 FROM stud_base WHERE student_sn=$student_sn";
		$rs=$CONN->Execute($query) or die("SQL���~�G<br>$query");
		$stud_name=$rs->fields['stud_name'];
		$stud_addr = $rs->fields['stud_addr_1'];
		//����ǥ;Ǵ��NŪ�Z��
		$stud_seme_arr=get_student_seme_list($student_sn);
		
		//���o�Юv�B���ɱЮv�J�����
		$query="select * from career_contact where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		$content_array=unserialize($res->fields['content']);

		
		$contact_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
			<tr bgcolor='#c4d9ff' align='center'><td>�Ǵ�</td><td>�Z��</td><td>�Z�Ůy��</td><td>�ɮv�m�W</td><td>���ɱЮv�m�W</td></tr>";
		//���e
		foreach($stud_seme_arr as $seme_key=>$value){
			$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
			$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
			$contact_list.="<tr align='center'><td>{$value['year_seme']}</td>
			<td>{$value['seme_class_name']}</td>
			<td>{$value['seme_num']}</td>
			<td>{$content_array[$seme_key][tutor]}</td>
			<td>{$content_array[$seme_key][guidance]}</td>			
			</tr>";
			if($curr_seme_key==$seme_key) $curr_class_name='--'.$value['seme_class_name'].'--';
		}
		$contact_list.="</table>";
		
		//page 2
		//����B���p���q��
		$room_tel=get_room_tel();
		$room_list="<p align='left'>�Y���ͲP���ɬ������D�A�i���ߡG<br><br><br>���Ǯլ����B���p���q�ܡG<br><br>�@�аȳB�G{$room_tel['�аȳB']}<br>�@�ǰȳB�G{$room_tel['�ǰȳB']}<br>�@���ɳB�G{$room_tel['���ɳB']}</p><br>";	
		
		//����ǥ;Ǵ��NŪ�Z��
		$stud_seme_arr=get_student_seme($student_sn);
		
		//���o�ɮv�λ��ɱЮv���
		$query="select * from career_contact where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		$content_array=unserialize($res->fields['content']);

		$contact_list2="<p align='left'>���ɮv�λ��ɱЮv�G</p><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
			<tr bgcolor='#c4d9ff' align='center'><td>�~��</td><td>�ɮv�m�W</td><td>�ɮv�p���q��</td><td>���ɱЮv�m�W</td><td>���ɱЮv�p���q��</td></tr>";
		//���e
		foreach($stud_seme_arr as $seme_key=>$year_seme){
			$bgcolor=($career_previous or $curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
			$readonly=($career_previous or $curr_seme_key==$seme_key)?'':'readonly';
			$contact_list2.="<tr align='center'><td>$seme_key</td>
				<td>{$content_array[$seme_key][tutor]}</td>
				<td>{$content_array[$seme_key][tutor_tel]}</td>
				<td>{$content_array[$seme_key][guidance]}</td>
				<td>{$content_array[$seme_key][guidance_tel]}</td>	
				</tr>";
		}
		$contact_list2.="</table>";
		
		$words="�@�@��103�Ǧ~�װ_�A�h�ưꤤ���~�ͱN�H�K�դJ�Ǥ覡��Ū�����B¾�դΤ��M�A�ǥͥi�ѦҭӤH����O�B�ʦV�B����ΤH��S�赥�]���A��ܳ̾A�X�ۤv���Ǯ����O�C�]���A�W����z�U���ձ��ι�@���ʡA�H��U�ǥͦۧڻ{�Ѥα������Ӷi���A�ô��ѾA�ʪ��ͲP�W����ĳ�A�O�ꤤ�ͲP���ɤu�@�����n�ؼСC<br>
	  �@�@������ꤤ�ǥͥͲP���ɾ���A���i�ǥͥͲP��ܯ�O�A�è�U�Юv�B�a���b���ɾǥͶi��ͲP�W���ɦ��Ҩ̾ڡA�Ш|���ۤ�]�p���ͲP���ɬ�����U�A�[�A�G�ǥͪ������y��B�U���߲z���絲�G�B�ǲߦ��G�ίS���{�B�ͲP���ɬ������A�óz�L�ͲP�o�i�W���ѡA���U�ǥͦb�i��i���W���ɦ���M���B���T���B�J�M�覡�C<br>
	 �@�@���F���Юv�B�ǥͤήa����F�Ѧp��ϥΥ�������U�A���O�����p�Z�G<br>
	 <br><b><u>���Ѯv����</u></b><br>
	�@�@����U���W���A�b���ѾǮվɮv�B���ɱЮv���ǥͥͲP���ɬ����H���@�M�t�ΡB���T�������P��T�A�H��U�ǥͶi��i����ܡA�E�J�󥼨ӵo�i����V�C<br>
	�@�@�o���ͲP���ɬ�����U���\�εۭ��b�u��Ƭ����v�P�u���ɡv��譱�C�b��ƻ`���ΰO���譱�A�ǮձЮv�i�Ѧҥؿ����ҦC��g�ɶ��A�B�ά����ҵ{�A��U�ǥͧ�����ƫظm�C�p�G�ӤH���������B�߲z���絲�G�B�U���ǲߦ��G�ίS���{�B�ͲP�o�i�W���ѤλP�v���Q�ץͲP�W�����Ըߤ��e���C�ѩ�o�����ɬ�����U�������e�A�P�ͲP�ɮ׽ҵ{�ǲ߳�s���A�]���A��ĳ�ɮv�P���ɱЮv�إߨ�P�ξ�X����A��U�ǥͷJ��ö�g������ơC�Ǯեi�Q�ήa����B�Z�˷|�ο�¾���y�����ʡA�V�a��������U���\��Τ��e�]�Ѿ\�u���a�����ܡv�^�C�ɮv�λ��ɦѮv�N��U�o���ǥͮɡA��i�w��u���ꤤ�ͪ��ܡv�i���Ū�A�H�W�i�a���ξǥ͹��U���{�ѡC<br>
	�@�@�����ͲP���ɬ����]��U��21���^�A�Цb�P�ǥͶi��ͲP�԰ӫ᧹�����������C�n�����Юv���O�A����U�������ɬ����A�лE�J��ǥͪ��ͲP���ɻP�W���A�Z�O�P�ǥͤήa���Q�׬���ĳ�D�A���i��g���U��������C�]���A�i�H�Ҽ{�N�o����U�P�ǥͻ��ɸ��B��@�_�O�ޡA��K�H��µ�g�C�̫�A�b�ۤ��g�ͲP�o�i�W���ѮɡA�i�H�ܽоǥͤήa���ھڳo�T�~�`������T�A�@�P�Q�ק����A��U�ǥͶi��A�ʤ��i����ܡC<br>
	�@�@�@��������U���ɥѾǮլ����B�ǲΤ@�O�s�C�o�پǥͶ�g�ɡA�д����ǥͧ����O�ޡA�H�K�]�򥢳y��������|�A�v�T����ͲP���ɤ��i��C�ǥͲ��~�ɡA��������U�i�o�پǥͥ��H�ѦҹB�ΡA������ƭY�����B�ǻݯd�s�A�Цۦ�v�L�C���~�A�Y�J�ǥͲ��ʡ]��Z�B��ǵ��^�A��������U���H���y������Ƥ@���ಾ�C<br>
	�@<br><b><u>���ꤤ�ͪ���</u></b><br>
	�@�@�o���ͲP���ɬ�����U�D�n�b��U�P�ǰO���ӤH�ͲP�W���һݪ�������ơA�H�Q�b�E�~�Ű��ɾǶi����ܮɡA��������B�t�Ϊ���T�i�ѰѦҡC<br>
	�@�@�n�p���ܳ̾A�X�ۤv���ͲP�i���H�ǮզU��쪺�ǲߡB�U�����ά��ʤά����߲z���絥�A���i�H���U�P�ǭ̤F�Ѧۤv���H��S��B�M���B���쵥�C�Ǯտ�z���ͲP�o�i�Ш|�ҵ{�ά��ʡB�ͲP�ɮ׸�Ƶ��A�]�i�H��U�z�z�L����B�����ӻ{�Ѧۤv�A�H�ΤF�Ѱ����B¾�դΤ��M���ǮկS��A�Ы�ұz�Ұ����ʦV�B������絲�G����H�O�ݩ�ǳN�ɦV�H�άO����A�X�NŪ¾�~�Ǯժ����ظs��H<br>
	�@�@�C�@����g��U�ɡA�Ʊ�z����H�{�u���A�סA�f�V��Ҩç���������ơA�o�ˤ~��ظm���T�B���㪺��T�A���ǮզѮv�ήa���R���F�ѱz���ӤH�S��B�i���ݨD�έӤH���~�b�귽�P����A�N�U�ؼv�T�ͲP�M�����]���ǤJ�Ҷq�A�z�L�Q�סB�����A���U�z�W���X�@�ӾA�X�ۤv���ͲP�ؼСC<br>
	�@<br><b><u>���a������</u></b><br>
	�@�@�q�Ĥl�@���a�A�C��a���N��J�F�L�ƪ��ߤO�A���Ѥj�q���Ш|�귽�A�Ʊ�Ĥl���d�����B�ּ־ǲߡA�ï��ܳ̾A�X���o�i��V�A�v�B��{�ۤv���z�Q�C�����A�Ǯը�U�ǥͫظm�o���ͲP���ɬ�����U�A�Ʊ�J���ӤH�ͲP�W���B�i����ܩһݪ���ơA�z�L�͵������ɾ��{�A�P�a���@�_�i��Ĥl�����ӡA���U�Ĥl���H�ͤ�V�A�çƱ�C�ӫĤl����ܨ�ҷR�B�֨�ҾܡA�y�C��ŦX�ۤv�ʦV�P���쪺�Ѧa���A�ɱ��i�{���~�A�o�������A�����U��U�~��¼���C<br>
	�@�@�q�\�h��s�ι�����ҡA�p�G�Ĥl�i�H�M���ۤv������ί�O�A�åB�]�w�n���ӵo�i���ؼСA�N����ߵL���E�B�����}���B��w���¥ؼЫe�i�C�]���Ұ����O�ӤH�ҷR�A�ҥH�৹����J�B�R�������P���O�F�S�]�����z�Q�B���ؼСA�ҥH�@�N����쩳�A�䦨�N��H���q�I<br>
	�@�@�b�j�վA�ʴ��~�B�h���o�i���ɥN�A�ڭ̬۫H�C�ӫĤl�����ӤH���x���Ѧa�C�p���U�Ĥl�o���u�կ�O�óW���ͲP��V�A�O�ǮջP�a���@�P�����D�C��ĳ�z�Ѧҳo����U���U�������A��ɶ���Ĥl���Bťť�Ĥl���Q�k�A���n�ɥi�P�ǮզѮv�@�_�Q�סA�H��U�Ĥl�b�ͲP�x�y���A���A�X����D�A���L�̱a�ۺ��������֡A�i�|���G�A�L�۩��֡B�����B�R��S���N�q���H�͡I<br>
";
		
		//page 3
		$mystory="<p align='left'>�@�B�ڪ������G��<br>�@�]�@�^�ۧڻ{��<br>�@�@�@�ЦP�ǴN�z�{�Ѫ��ۤv�@�Ŀ�A�i�ƿ�C</p>";
		//����өʡB�U�����ʰѷӪ�
		$personality_items=SFS_TEXT('�ө�(�H��S��)');
		$activity_items=SFS_TEXT('�U������');
	
		//���o�ڪ������G�ƬJ�����
		$query="select personality,interest,specialty from career_mystory where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		
		//����ۧڻ{�ѦU�Ӷ��ت����e
		$personality_array=unserialize($res->fields['personality']);
		$interest_array=unserialize($res->fields['interest']);
		$specialty_array=unserialize($res->fields['specialty']);
		
		$personality_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�ө�(�H��S��)</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
			
		$activities="";
		foreach($activity_items as $key=>$value){
			$activities.="($key)$value ";
		}
		
		/*
		$interest_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�𶢿���</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
		
		$specialty_checkox="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�M��</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr><tr>";
		*/

		
		for($i=$min;$i<=$max;$i++){
			$personality_checkox.="<td>";
			foreach($personality_items as $key=>$value){
				$color=$personality_array[$i][$key]?'#0000ff':'#aaaaaa';
				$checked=$personality_array[$i][$key]?'��':'��';
				$personality_checkox.="$checked<font color='$color'>$value</font><br>";
			}
			$personality_checkox.="</td>";
			
			/*
			$interest_checkox.="<td>";
			foreach($activity_items as $key=>$value){
				$color=$interest_array[$i][$key]?'#ff0000':'#000000';
				$checked=$interest_array[$i][$key]?'��':'��';
				$interest_checkox.="$checked<font color='$color'>$value</font><br>";
			}
			$interest_checkox.="</td>";
			
			$specialty_checkox.="<td>";
			foreach($activity_items as $key=>$value){
				$color=$specialty_array[$i][$key]?'#ff0000':'#000000';
				$checked=$specialty_array[$i][$key]?'��':'��';
				$specialty_checkox.="$checked<font color='$color'>$value</font><br>";
			}
			$specialty_checkox.="</td>";
			*/
			
			$interest_checkox.="<td valign='top'>�ڳ��w�q�ƪ����ʡG<br>";
			foreach($activity_items as $key=>$value){
				$interest_checkox.=$interest_array[$i][$key]?"$key. $value ":"";
			}
			$interest_checkox.="</td>";
			
			$specialty_checkox.="<td valign='top'>�ھժ����ơG<br>";
			foreach($activity_items as $key=>$value){
				$specialty_checkox.=$specialty_array[$i][$key]?"$key. $value ":"";
			}
			$specialty_checkox.="</td>";
			
		}
		$personality_checkox.='</tr></table>';
		//$interest_checkox.='</tr></table>';
		//$specialty_checkox.='</tr></table>';	
		$activities="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=3>�U������</td><td colspan=3>$activities</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td colspan=3>�~��</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>
		<tr><td colspan=3>�𶢿���</td>$interest_checkox</tr>
		<tr><td colspan=3>�M��</td>$specialty_checkox</tr></table>";
		
		$mystory.="$personality_checkox $new_page $activities";
		
		
		
		//page 4
		$mystory2="<p align='left'>�@�]�G�^¾�~�P��<br>�@�@�@�z�L�P�v���B�a�H�B�ˤͪ����q�P���ɡA�N���U��z�良��¾�~���F�ѡB���f�V�W���ۤv���Ӫ��i���C�лP�z�ҫH���Τ���F�ѱz���v���B�a�H�B�ˤͰQ�׫�A��g�ΤĿ�U�C���D�C</p>";
		//¾�~�P��-���D�}�C�w�q
		$suggestion_question=array(1=>'�a�H�B�v���οˤʹ��g��ĳ�ڥ��ӥi��ܪ�¾�~',2=>'���ګ�ĳ���H',3=>'��ĳ�ڿ�ܳo��¾�~����]');
		$myown_question=array(1=>'�ڳ̷P���쪺¾�~',2=>'�ڹ�o¾�~�P���쪺��]',3=>'�o��¾�~�ݨ�ƪ��Ǿ��B��O�B�M���Ψ�L����');
		$others_question=array(1=>'�ڷQ�n�i�@�B�F�ѭ���¾�~');
		
		//������¾�~�ɭ���������ѷӪ�
		$weight_items=SFS_TEXT('���¾�~�ɭ���������');
		
		//���o�ڪ������G�ƬJ�����
		$query="select occupation_suggestion,occupation_myown,occupation_others,occupation_weight from career_mystory where student_sn=$student_sn";
		$res=$CONN->Execute($query);
		
		//����ۧڻ{�ѦU�Ӷ��ت����e
		$suggestion_array=unserialize($res->fields['occupation_suggestion']);
		$myown_array=unserialize($res->fields['occupation_myown']);
		$others_array=unserialize($res->fields['occupation_others']);
		$weight_array=unserialize($res->fields['occupation_weight']);

		$suggestion_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�a�H�B�v���οˤͪ���ĳ</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($suggestion_question as $key=>$value){
			$suggestion_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$suggestion_array[$i][$key];
				$suggestion_list.="<td>$mydata</td>";
			}
			$suggestion_list.='</tr>';		
		}
		$suggestion_list.='</table><br>';	
		
		
		$myown_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�ڳ̷P���쪺¾�~</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($myown_question as $key=>$value){
			$myown_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$myown_array[$i][$key];
				$myown_list.="<td>$mydata</td>";
			}
			$myown_list.='</tr>';		
		}
		$myown_list.='</table><br>';
		
		
		$others_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td colspan=4>�ڷQ�n�i�@�B�F�Ѫ�¾�~</td></tr>
		<tr bgcolor='#ffcccc' align='center'><td>�ݡ@�@�@�@�D</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>";	
		foreach($others_question as $key=>$value){
			$others_list.="<tr><td>$key. $value</td>";
			for($i=$min;$i<=$max;$i++){
				$mydata=$others_array[$i][$key];
				$others_list.="<td>$mydata</td>";
			}
			$others_list.='</tr>';		
		}
		$others_list.='</table><br>';
		
		//��������@�]�P�W���{�����c���P�^
		$weight_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
			<tr bgcolor='#ccccff' align='center'><td colspan=4>���¾�~�ɡA�ڭ���������(�i�ƿ�)</td></tr>
			<tr bgcolor='#ffcccc' align='center'><td width=200>��g����</td><td>{$class_year[$min]}��</td><td>{$class_year[$min+1]}��</td><td>{$class_year[$min+2]}��</td></tr>
			<tr>
			<td valign='top' width=300>
			<li>�i��ͲP�W���ɡA����M�P�A�ѭӤH�S��A�j���ǮջP¾�~��ơA�P�ɦҶq�a�H�N���B���|�P�����ܾE�B�U���U�O���O�]�����C</li>
			<li>�b�ӤH�S�誺��M�P�A�Ѥ譱�A���F����B��O�~�A�u�@�����[�]�ӤH����������^�]�O���n�v�T�]���C</li>
			<li>�]�K�B�E�~�Ŷ�g�^</li>	
			</td>";
		
		for($i=$min;$i<=$max;$i++){
			$weight_list.="<td>";
			foreach($weight_items as $key=>$value){
				$color=$weight_array[$i][$key]?'#0000ff':'#000000';
				$checked=$weight_array[$i][$key]?'��':'��';
				$weight_list.="$checked<font color='$color'>$value</font><br>";
			}
		}
		$weight_list.="</td></tr></table>";	
		
		$mystory2.=$suggestion_list.$myown_list.$others_list.$weight_list;

		$psy_test="<p align='left'>�G�B�U���߲z����<br>";
		
		$menu_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����(1)',4=>'��L����(2)');
		foreach($menu_arr as $id=>$item){
			//���o�ʦV����J�����
			$query="select * from career_test where student_sn=$student_sn and id=$id";
			$res=$CONN->Execute($query);
			if($res){
				while(!$res->EOF){
					$sn=$res->fields['sn'];
					$content=unserialize($res->fields['content']);
					$title=$content['title'];
					$test_result=$content['data'];

					$study=$res->fields['study'];
					$job=$res->fields['job'];
					
					$content_list="<br>�@( $id ) $item<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>
						<tr bgcolor='#ccffcc' align='center'><td colspan=2><b>$title</b></td></tr><tr></tr>
						<tr bgcolor='#ffcccc' align='center'><td>����</td><td>���e���G</td></tr>";
					if($test_result){
						foreach($test_result as $key=>$value) $content_list.="<tr><td>$key</td><td align='center'>$value</td></tr>";
					} else $content_list.="<tr align='center'><td colspan=2 height=100>�S���o�{������������I</td></tr>";
					$content_list.="</table>���ھڴ��絲�G�A�åB�Ѧҿ���ξǷ~���Z�G<br>�b�ɾǤ譱�A�ھA�X�NŪ�]�Ǯ����O�M��O�^�G $study
						<br>�b�N�~�譱�A�ھA�X�q�ơ]�u�@���O�^�G $job<br><br>";

					$res->MoveNext();
				}
			} else $content_list="<center><font size=5 color='#ff0000'><br><br>���o�{����{$menu_arr[$menu]}�����I<br><br></font></center>";
		}	
		
		$psy_test.=$content_list;
		
	
		
		//page 5
		$study_spe="<p align='left'>�T�B�ǲߦ��G�ίS���{";
		
		//���o���ǲߦ��Z���
		$fin_score=cal_fin_score(array($student_sn),$stud_seme_arr);

		$link_ss=array("chinese"=>"�y��-���","english"=>"�y��-�^�y","math"=>"�ƾ�","social"=>"���|","nature"=>"�۵M�P�ͬ����","art"=>"���N�P�H��","health"=>"���d�P��|","complex"=>"��X����");
		//��������Y
		$study_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
				<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td>";
		foreach($link_ss as $key=>$value) $study_list.="<td>$value</td>";
		$study_list.="<td>���ڪ��ǲߪ�{�A�ڻ{��</td></tr>";
		
		//���e
		foreach($stud_seme_arr as $seme_key=>$year_seme){			
			$study_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>";
			foreach($link_ss as $key=>$value) $study_list.="<td>{$fin_score[$student_sn][$key][$year_seme]['score']}</td>";
			$study_list.="<td>{$ponder_array[$seme_key]}</td></tr>";
		}
		$study_list.="</table>";
		
		
		//���o�Ш|�|�Ҧ��Z���
		$exam_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr bgcolor='#c4d9ff' align='center'><td>�����ɶ�</td><td>���</td><td>�^�y</td><td>�ƾ�</td><td>�۵M</td><td>���|</td><td>�g�@����</td></tr>";
		$query="select * from career_exam where student_sn=$student_sn order by update_time desc";
		$res=$CONN->Execute($query);
		if($res){
			$exam_list.="<tr align='center'>
				<td>{$res->fields['update_time']}</td>
				<td>{$res->fields['c']}</td>
				<td>{$res->fields['e']}</td>
				<td>{$res->fields['m']}</td>
				<td>{$res->fields['n']}</td>
				<td>{$res->fields['s']}</td>
				<td>{$res->fields['w']}</td>
				</tr>";			
			} else $exam_list.="<tr align='center'><td colspan=7>���o�{�Ш|�|�Ҧ��Z���</td></tr>";
		$exam_list.="</table>";
		
		//���o��A�ন�Z���
		$fitness_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
			<tr bgcolor='#c4d9ff' align='center'>
			<td>�~��</td><td>�Ǵ�</td>
			<td>����<br>(cm)</td>
			<td>�魫<br>(kg)</td>
			<td>BMI����<br>(kg/m<sup>2</sup>)</td>
			<td>����~��</td>
			<td>�����e�s<br>(cm) [%]</td>
			<td>���װ_��<br>(��) [%]</td>
			<td>�ߩw����<br>(cm) [%]</td>
			<td>�ߪ;A��<br>(��) [%]</td>
			<td>�~��</td>
			<td>����</td>
			</tr>";
		$query="select * from fitness_data where student_sn=$student_sn order by c_curr_seme";
		$res=$CONN->Execute($query);
		while(!$res->EOF){
			$c_curr_seme=$res->fields['c_curr_seme'];
			$seme_key=array_search($c_curr_seme,$stud_seme_arr);
			//�P�w����
			$g=0;
			$s=0;
			$c=0;
			$passed=0;
			for($i=1;$i<=4;$i++) {
				$field_name='prec'.$i;
				if($res->fields[$field_name]>=85) $g++;
				if($res->fields[$field_name]>=75) $s++;
				if($res->fields[$field_name]>=50) $c++;
				if($res->fields[$field_name]>=25) $passed++;  //�q�L���e�з�  �{���{�]��25%�H�W
			}				
			$medal='';
			if($g==4) $medal="��"; elseif($s==4) $medal="�� "; elseif($c==4) $medal="��";
			$fitness_list.="<tr align='center'>
				<td>$seme_key</td><td>$c_curr_seme</td>
				<td>{$res->fields['tall']}</td>
				<td>{$res->fields['weigh']}</td>
				<td>{$res->fields['bmt']}</td>
				<td>{$res->fields['test_y']}-{$res->fields['test_m']}</td>
				<td>{$res->fields['test1']} [{$res->fields['prec1']}]</td>
				<td>{$res->fields['test2']} [{$res->fields['prec2']}]</td>
				<td>{$res->fields['test3']} [{$res->fields['prec3']}]</td>
				<td>{$res->fields['test4']} [{$res->fields['prec4']}]</td>
				<td>{$res->fields['age']}</td>
				<td>$medal</td>
				</tr>";			
			$res->MoveNext();
		}
		$fitness_list.="</table><font size=1><br>�]1�^�˴����ءG<br>
�@�@A.�٭@�O�G�@�����}�����װ_���C<br>
�@�@B.�X�n�סG������e�s�C<br>
�@�@C.���o�O�G�ߩw�����C<br>
�@�@D.�ߪͭ@�O�G�]���]�k�͡G800���ءB�k�͡G1,600���ء^�C<br>
   �]2�^�����зǡG�u��A�ন�Z�`�����G�v�P�u��@����A�ন�Z���G�v�Ҥ������ص����A���u�ĭp�C�~�ŤW�Ǵ��ܤE�~�ŤW�Ǵ��������˴����Z�A�U�����зǻ����p�U�G
   <table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=9px;' bordercolor='#111111' width=100%>
   <tr><td>�`�����G����</td><td>�`�����G�з�</td><td>�涵���G����</td><td>�涵���G�з�</td></tr>
<tr><td>����</td><td>�|�����Z���F�`�Ҧʤ�����85�H�W��</td><td>���P</td><td>�涵���Z�F�`�Ҧʤ�����85�H�W��</td></tr>
<tr><td>�Ƚ�</td><td>�|�����Z���F�`�Ҧʤ�����75�H�W��</td><td>�ȵP</td><td>�涵���Z�F�`�Ҧʤ�����75�H�W��</td></tr>
<tr><td>�ɽ�</td><td>�|�����Z���F�`�Ҧʤ�����50�H�W��</td><td>�ɵP</td><td>�涵���Z�F�`�Ҧʤ�����50�H�W��</td></tr>
<tr><td>����</td><td>�|�����Z���F�`�Ҧʤ�����25�H�W��</td><td>����</td><td>�涵���Z�F�`�Ҧʤ�����25�H�W��</td></tr>
<tr><td>�ݥ[�j</td><td>�|�����Z�����@�����F�`�Ҧʤ�����25��</td><td>�ݥ[�j</td><td>�涵���Z���F�`�Ҧʤ�����25��</td></tr>
</table>
�]3�^�˴����Z�ҩ������U�C�G�ءG<br>
�@�@A.�Ш|���ɧU�]�m����A���˴������Z�ҩ��C<br>
�@�@B.�Ǯզۦ��˴����Z�ҩ��C<br>
�@�@����A���˴�������T�A�аѾ\�Ш|����A���http://www.fitness.org.tw/
</font>";
	
		$study_spe.="<br><br>1.�U���ǲߦ��Z $study_list<br>2.�ꤤ�Ш|�|�Ҫ�{ $exam_list<br>3.��A���˴���{ $fitness_list </p>";


	//page 6
	//��������Y
	$assistant_list="<p align='left'>�]�G�^�ڪ��g���]�F���B���Ρ^<br><br>�@1.�F���G��g���g��������թʡB�Z�ŷF���ΦU���]��^�p�Ѯv¾�ȡA���������@�Ǵ��H�W(�t���@�Ǵ�)�C
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>�F��</td><td>�p�Ѯv</td><td>�ۧڬ٫�</td>";
	//���e
	$act="<input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")'>";
	//Ū���F�����	
	$query="select * from career_self_ponder where student_sn=$student_sn and id='3-2'";
	$res=$CONN->Execute($query);
	$ponder_array=unserialize($res->fields['content']);
	
	foreach($stud_seme_arr as $seme_key=>$year_seme){			
		$assistant_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
		<td align='left'>1. {$ponder_array[$seme_key][1][1]}<br>2. {$ponder_array[$seme_key][1][2]}</td>
		<td align='left'>1. {$ponder_array[$seme_key][2][1]}<br>2. {$ponder_array[$seme_key][2][2]}</td>";
		$assistant_list.="<td align='left'>{$ponder_array[$seme_key][data]}</td></tr>";
	}
	$assistant_list.="</table></p>";

	
	//���θ��
	//��������Y
	$club_list="<p align='left'>�@2.���ΡG�ѥ[�Ǯթ�ҵ{���νҫ�]�t����δH�����^��I�����ΡA���@�Ǵ�/20�p�ɡC
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>���ΦW��</td><td>���Z</td><td>���¾��</td><td>�Ѯv���y</td><td>�ۧڬ٫�</td>";

	$query="select * from association where student_sn=$student_sn order by seme_year_seme";
	$res=$CONN->Execute($query);
	if($res){
		while(!$res->EOF){
			$seme_year_seme=$res->fields['seme_year_seme'];
			$seme_key=array_search($seme_year_seme,$stud_seme_arr);
			$club_score=$res->fields['score']?$res->fields['score']:'--';
			$feed_back=str_replace("\r\n",'<br>',$res->fields['stud_feedback']);
			$club_list.="<tr align='center'>
			<td>$seme_key</td><td>$seme_year_seme</td>
			<td>{$res->fields['association_name']}</td>
			<td>{$club_score}</td>
			<td>{$res->fields['stud_post']}</td>
			<td align='left'>{$res->fields['description']}</td>
			<td align='left'>$feed_back</td>
			</tr>";			
			$res->MoveNext();
		}
	} else $club_list.="<tr align='center'><td colspan=6 height=24>���o�{���ά��ʬ����I</td></tr>";
	$club_list.="</table></p>";
	
	//page 7
	//��������Y
	$race_list="<p align='left'>�]�T�^�ѻP�U���v�ɦ��G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'>
		<td>NO.</td><td colspan=2>�d��ʽ�</td><td>�v�ɦW��</td><td>�o���W��</td><td>�ҮѤ��</td><td>�D����</td><td>�Ƶ�</td>";

	//�U���v�ɦ��G
	$query="select * from career_race where student_sn=$student_sn order by certificate_date";
	$res=$CONN->Execute($query);
	if($res){
		while(!$res->EOF){
			$ii++;
			$sn=$res->fields['sn'];
			$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
			$race_list.="<tr align='center'>
				<td>$ii</td>
				<td>{$level_array[$res->fields['level']]}</td>
				<td>{$squad_array[$res->fields['squad']]}</td>
				<td align='left'>{$res->fields['name']}</td>
				<td>{$res->fields['rank']}</td>
				<td>{$res->fields['certificate_date']}</td>
				<td align='left'>{$res->fields['sponsor']}</td>
				<td align='left'>$memo</td>
				</tr>";	
			$res->MoveNext();
		}
	} else $race_list.="<tr align='center'><td colspan=7 height=24>���o�{�U���v�ɦ��G�����I</td></tr>";
	$race_list.="</table></p>";
	
	//page 8
	$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
	$reward_list="<p align='left'>�]�|�^�欰��{���g����<br>�@�����g���ӡG<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:9pt;' bordercolor='#111111' width=100%>
				<tr align='center' bgcolor='#ccccff'><td>NO.</td><td>�Ǵ��O</td><td>���g���</td><td>���g���O</td><td>���g�ƥ�</td><td>���g�̾�</td><td>�P�L���</td></tr>";
			
	//������w�ǥͪ����g����
	$seme_reward=array();
	$sql="SELECT * FROM reward WHERE student_sn=$student_sn ORDER BY reward_year_seme,reward_date";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	if($res)
	while(!$res->EOF)
	{
		$reward_kind=$res->fields['reward_kind'];
		$reward_cancel_date=$res->fields['reward_cancel_date'];
		$reward_year_seme=substr($res->fields['reward_year_seme'],0,-1).'-'.substr($res->fields['reward_year_seme'],-1);
		$recno++;
		$bgcolor=($reward_kind>0)?'#ccffcc':'#ffcccc';
		if($reward_cancel_date=='0000-00-00') $reward_cancel_date=''; else $bgcolor='#cccccc';
		$reward_list.="<tr bgcolor='$bgcolor' align='center'><td>$recno</td><td>$reward_year_seme</td><td>{$res->fields['reward_date']}</td><td>{$reward_arr[$res->fields['reward_kind']]}</td><td align='left'>{$res->fields['reward_reason']}</td><td align='left'>{$res->fields['reward_base']}</td><td>$reward_cancel_date</td></tr>";
		//�Ǵ��έp
		$reward_year_seme=$res->fields['reward_year_seme'];
		$seme_key=array_search($reward_year_seme,$stud_seme_arr);
		$reward_kind=$res->fields['reward_kind'];			
		
		switch($reward_kind){
			case 1:	$seme_reward_effective[$seme_key][1]++;	$seme_reward_effective['sum'][1]++;	break;
			case 2:	$seme_reward_effective[$seme_key][1]+=2;	$seme_reward_effective['sum'][1]+=2; break;
			case 3:	$seme_reward_effective[$seme_key][3]++;	$seme_reward_effective['sum'][3]++;	break;
			case 4:	$seme_reward_effective[$seme_key][3]+=2;	$seme_reward_effective['sum'][3]+=2; break;
			case 5:	$seme_reward_effective[$seme_key][9]++;	$seme_reward_effective['sum'][9]++;	break;
			case 6:	$seme_reward_effective[$seme_key][9]+=2;	$seme_reward_effective['sum'][9]+=2; break;
			case 7:	$seme_reward_effective[$seme_key][9]+=3;	$seme_reward_effective['sum'][9]+=3; break;
			case -1: $seme_reward_effective[$seme_key][-1]++;	$seme_reward_effective['sum'][-1]++; break;
			case -2: $seme_reward_effective[$seme_key][-1]+=2;	$seme_reward_effective['sum'][-1]+=2; break;
			case -3: $seme_reward_effective[$seme_key][-3]++;	$seme_reward_effective['sum'][-3]++; break;
			case -4: $seme_reward_effective[$seme_key][-3]+=2;	$seme_reward_effective['sum'][-3]+=2; break;
			case -5: $seme_reward_effective[$seme_key][-9]++;	$seme_reward_effective['sum'][-9]++; break;
			case -6: $seme_reward_effective[$seme_key][-9]+=2;	$seme_reward_effective['sum'][-9]+=2; break;
			case -7: $seme_reward_effective[$seme_key][-9]+=3;	$seme_reward_effective['sum'][-9]+=3; break;
		}
		//�P�L�έp
		if($reward_cancel_date<>'0000-00-00'){
			switch($reward_kind){
				case -1: $seme_reward_canceled[$seme_key][-1]++; $seme_reward_canceled['sum'][-1]++; break;
				case -2: $seme_reward_canceled[$seme_key][-1]+=2; $seme_reward_canceled['sum'][-1]+=2; break;
				case -3: $seme_reward_canceled[$seme_key][-3]++; $seme_reward_canceled['sum'][-3]++; break;
				case -4: $seme_reward_canceled[$seme_key][-3]+=2; $seme_reward_canceled['sum'][-3]+=2; break;
				case -5: $seme_reward_canceled[$seme_key][-9]++; $seme_reward_canceled['sum'][-9]++; break;
				case -6: $seme_reward_canceled[$seme_key][-9]+=2; $seme_reward_canceled['sum'][-9]+=2; break;
				case -7: $seme_reward_canceled[$seme_key][-9]+=3; $seme_reward_canceled['sum'][-9]+=3; break;
			}
		}			
		$res->MoveNext();
	} else $reward_list.="<tr><td colspan=12 align='center'><font size=5 color='#ff0000'>���o�{������g���ӡI</font></td>";
	$reward_list.="</table>";
	
	//�Ǵ��έp�C��
	//��������Y
	$seme_list="<br>�@�����g�έp�G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
	<tr align='center' bgcolor='#ffcccc'><td rowspan=2>�~��</td><td rowspan=2>�Ǵ�</td><td colspan=6 bgcolor='#ccccff'>���g����</td><td colspan=3 bgcolor='#cccccc'>��L�P�L����</td><td rowspan=2>�ۧڬ٫�</td></tr>
	<tr align='center'  bgcolor='#ccccff'><td>�j�\</td><td>�p�\</td><td>�ż�</td><td>ĵ�i</td><td>�p�L</td><td>�j�L</td><td bgcolor='#cccccc'>ĵ�i</td><td bgcolor='#cccccc'>�p�L</td><td bgcolor='#cccccc'>�j�L</td></tr>
	";
	//���e
	//Ū���ۧڬ٫���	
	$query="select * from career_self_ponder where student_sn=$student_sn and id='3-4'";
	$res=$CONN->Execute($query);
	$ponder_array=unserialize($res->fields['content']);
	
	foreach($stud_seme_arr as $seme_key=>$year_seme){			
		$seme_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>
			<td>{$seme_reward_effective[$seme_key][9]}</td><td>{$seme_reward_effective[$seme_key][3]}</td><td>{$seme_reward_effective[$seme_key][1]}</td><td>{$seme_reward_effective[$seme_key][-1]}</td><td>{$seme_reward_effective[$seme_key][-3]}</td><td>{$seme_reward_effective[$seme_key][-9]}</td>
			<td>{$seme_reward_canceled[$seme_key][-1]}</td><td>{$seme_reward_canceled[$seme_key][-3]}</td><td>{$seme_reward_canceled[$seme_key][-9]}</td>";
		$seme_list.="<td align='left'>{$ponder_array[$seme_key]}</td></tr>";
	}
	//���~�έp
	$seme_list.="<tr align='center' bgcolor='#ccccff'><td colspan=2 bgcolor='#ccffcc'>�N�Ǵ����έp</td>
		<td>{$seme_reward_effective['sum'][9]}</td><td>{$seme_reward_effective['sum'][3]}</td><td>{$seme_reward_effective['sum'][1]}</td><td>{$seme_reward_effective['sum'][-1]}</td><td>{$seme_reward_effective['sum'][-3]}</td><td>{$seme_reward_effective['sum'][-9]}</td>
		<td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-1]}</td><td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-3]}</td><td bgcolor='#cccccc'>{$seme_reward_canceled['sum'][-9]}</td>
		<td bgcolor='#ccffcc'>{$ponder_array['sum']}</td></tr>";
	$seme_list.="</table></p>";
	
	
	//page 9  �]���^�A�Ⱦǲ߬���
	$room_arr=room_kind();
	//��������Y
	$service_list="<p align='left'>�]���^�A�Ⱦǲ߬���<br><br>�@�����ӦC��G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
	<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>�A�Ȥ��</td><td colspan=2>�ѥ[�դ��~���@�A�Ⱦǲߨƶ��ά��ʶ���</td><td>������</td><td>�D����</td><td>�ۧڬ٫�</td>";

	$query="select a.*,b.* from stud_service_detail a inner join stud_service b on a.item_sn=b.sn where confirm=1 and student_sn=$student_sn order by year_seme";
	$res=$CONN->Execute($query);
	
	if($res){		
		while(!$res->EOF){
			$year_seme=$res->fields['year_seme'];
			$seme_key=array_search($year_seme,$stud_seme_arr);
			$feed_back=str_replace("\r\n",'<br>',$res->fields['stud_feedback']);
			$service_list.="<tr align='center'>
			<td>$seme_key</td><td>$year_seme</td>
			<td>{$res->fields['service_date']}</td> 
			<td>{$res->fields['item']}</td><td align='left'>{$res->fields['memo']}</td>
			<td>{$res->fields['minutes']}</td>
			<td>{$room_arr[$res->fields['department']]}</td>
			<td align='left'>$feed_back</td>
			</tr>";
			$seme_sum[$seme_key]+=$res->fields['minutes'];
			$res->MoveNext();
		}
	} else $service_list.="<tr align='center'><td colspan=6 height=24>���o�{�w�{�Ҫ��A�Ⱦǲ߬����I</td></tr>";
	
	$service_list.="</table>";
	//�έp��
	$service_list.="<br><br>�@���Ǵ��έp�G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
	<tr align='center' bgcolor='#ffcccc'><td>�~��</td><td>�Ǵ�</td><td>������</td><td>�A�Ȯɼ�</td></tr>";
	foreach($stud_seme_arr as $seme_key=>$year_seme){
		$minutes=$seme_sum[$seme_key]; $minutes_sum+=$minutes;
		$hours=round($minutes/60,2); $hours_sum+=$hours;			
		$service_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td><td>$minutes</td><td>$hours</td></tr>";
	}
	$service_list.="<tr align='center' bgcolor='#ffcccc'><td colspan=2>�N�Ǵ����έp</td><td>$minutes_sum</td><td>$hours_sum</td></tr></table></p>";
	
	//page 10  
	//��������Y
	$explore_list="<p align='left'>�]���^�ͲP�ձ����ʬ���
			<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
			<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��</td><td>�Ǵ�</td><td>�ձ��ǵ{�θs��</td><td>���ʤ覡</td><td>�ѻP�ձ����ʫ��X��Ӹs��P���쪺�{��</td><td>�ۧڬ٫�</td>";
	//����өʡB�U�����ʰѷӪ�
	$course_array=SFS_TEXT('�ͲP�ձ��ǵ{�θs��');
	$activity_array=SFS_TEXT('�ͲP�ձ����ʤ覡');

	//���o�ͲP�ձ����ʬJ�����
	$query="select * from career_explore where student_sn=$student_sn order by seme_key";
	$res=$CONN->Execute($query);
	if($res){
		while(!$res->EOF){
			$ii++;
			$sn=$res->fields['sn'];
				$self_ponder=str_replace("\r\n",'<br>',$res->fields['self_ponder']);
				$explore_list.="<tr align='center'>
					<td>$ii</td>
					<td>{$res->fields['seme_key']}</td>
					<td>{$stud_seme_arr[$res->fields['seme_key']]}</td>
					<td>{$course_array[$res->fields['course_id']]}</td>
					<td>{$activity_array[$res->fields['activity_id']]}</td>
					<td>{$res->fields['degree']}</td>
					<td align='left'>$self_ponder</td>
					</tr>";	
			$res->MoveNext();
		}
	} else $explore_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP�ձ����ʬ����I</td></tr>";
	$explore_list.="</table></p>";
	
	//page 11 
	//����ͲP��V��Ҷ��ذѷӪ�
	$ponder_items=SFS_TEXT('�ͲP��V��Ҷ���');

	//���o�J�����
	$query="select ponder from career_view where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	$ponder_array=unserialize($res->fields['ponder']);
	
	$ponder_list="<p align='left'>�|�B�ͲP�ξ㭱���[<br>�@���A�X�ۤv���ͲP��V<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px; width:100%' bordercolor='#111111'>
	<tr bgcolor='#ccccff' align='center'><td>NO.</td><td>����</td><td>���e</td></tr>";
		
	$ponder_list.="<td bgcolor='$bgcolor'>";
	foreach($ponder_items as $key=>$value){
		$ii++;
		$ponder_list.="<tr><td align='center'>$ii</td><td>$value</td><td>{$ponder_array[$key]}</td></tr>";
	}
	$ponder_list.='</tr></table></p>';
	
	
	//����ͲP��ܤ�V�ѷӪ�
	$direction_items=SFS_TEXT('�ͲP��ܤ�V');
	//���o�J�����
	$query="select direction from career_view where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	$direction_array=unserialize($res->fields['direction']);
	$direction_list="<p align='left'>�@�]�@�^�P�a���ξǮձЮv�Q�׫�A�ۤv�Q�n��ܪ���V�G<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr bgcolor='#ccccff' align='center'><td>����</td><td>�ۤv���Q�k</td><td>�a��������</td><td>�ǮձЮv����ĳ</td><td>�Ƶ�</td></tr>";
	
	$direction_initial=array(1=>'self',2=>'parent',3=>'teacher');
	for($i=1;$i<=3;$i++){
		$direction_list.="<tr><td align='center'>$i</td>";
		foreach($direction_initial as $key=>$value){
			$target_value=$direction_array['item'][$i][$value];
			$target=$direction_items[$target_value];
			$direction_list.="<td>$target</td>";				
		}
		$direction_list.="<td>{$direction_array['memo'][$i]}</td></tr>";
	}
	
	$direction_list.='</table>';
	
	$checked=$direction_array['identical']?'�O':'�_';
	$direction_list.="<br>�@�]�G�^�Q�@�Q<br>�@�@1.�ۤv���Q�k�O�_�M�a������ΦѮv��ĳ�@�P�H
		<br>�@�@�@$checked �A��]�G{$direction_array['reason']}
		<br>�@�@2.�p�G�ڪ��Q�k�P�a�������椣�P�A�i�H�p�󷾳q�O�H<br>{$direction_array['communicate']}";
	$direction_list.='</p>';
	
	
	//�a�z��m�P��q
	
	//gmap here
	$geodata = '
<p align="left">
���A�ѷQ��Ū�Ǯժ��a�z��m�B�����ǮջP��a������q���p�A�O��ܧ��@�Ǯծɪ����n�Ҷq�]���C��ĳ�i�̤U�C�B�J�i���ҡG
</p>
<p align="left">
�]�@�^�̤U�C�K�մN�ǰϦ�F�ϡA��X�ۤv��a�Ҧb���ϰ��m�üе��O���C
</p>
<p align="left">
�]�G�^��X�z�Q��Ū�Ǯժ��Ҧb�ϰ��m�A�ä��O�е��O���C
</p>
<p align="left">			
�]�T�^�C�@�ҷQ��Ū�ǮջP��a�̫K������q�覡�B�ݪ�O���ɶ��P����C
</p>';
$geodata .= "<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>";			
$geodata .= '<tr><td><div id="test1" class="gmap3"></div></td></tr></table>';
	
	
	$course_list="<p align='left'>�@�]�T�^�Q��Ū���ǵ{�ά�O�ξǮաG<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr align='center' bgcolor='#ffcccc'>
				<td>���@��</td><td>�Ǯ�</td><td>�ǵ{�ά�O</td><td>�a�z��m</td><td>��q�覡</td><td>����ɶ�</td><td>���𨮸�</td><td>�Ƶ�</td>";
	//���@�Ǯ�	
	$geodataSchool = array();
	
	//����ҵ{���@
	$query="select * from career_course where student_sn=$student_sn order by aspiration_order";
	$res=$CONN->Execute($query);
	if($res){
		while(!$res->EOF){
			$ii=$res->fields['aspiration_order'];
			$sn=$res->fields['sn'];
				$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
				$course_list.="<tr align='center'>
					<td>$ii</td>
					<td>{$res->fields['school']}</td>
					<td>{$res->fields['course']}</td>
					<td>{$res->fields['position']}</td>
					<td>{$res->fields['transportation']}</td>
					<td>{$res->fields['transportation_time']}</td>
					<td>{$res->fields['transportation_toll']}</td>
					<td align='left'>$memo</td>
					</tr>";
			$geodataSchool[] = $res->fields['school'];
			$res->MoveNext();
		}
	} else $course_list.="<tr align='center'><td colspan=7 height=24>���o�{�Q��Ū���ǵ{�ά�O�����I</td></tr>";
	$course_list.="</table></p>";
	
	//���B�ͲP�o�i�W����
	//����J�����
	$query="select sn,aspiration_order,school,course,factor from career_course where student_sn=$student_sn order by aspiration_order";
	$res=$CONN->Execute($query);
	$evaluate_count=$res+1;
	while(!$res->EOF){
		$ii=$res->fields['aspiration_order'];
		$evaluate[$ii]['sn']=$res->fields['sn'];
		$evaluate[$ii]['school']=$res->fields['school'];
		$evaluate[$ii]['course']=$res->fields['course'];
		$evaluate[$ii]['factor']=unserialize($res->fields['factor']);
		$res->MoveNext();
	}
	//��������Y
	$evaluate_list="<p align='left'>���B�ͲP�o�i�W����<br>�@���ͲP���֪�G�N�ڷQ��Ū�������ΰ�¾�B���M�Ǯդά�O�A�����U���Ҽ{�]���P�C�ӿﶵ���ŦX�{�סA�ö�J�u0��5�v�����ơA5���N��D�`�ŦX�A0���N��D�`���ŦX�C
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'>
		<td bgcolor='#ddffcf'><p align='right'>�����@�Ǯա�</p><p align='left'>���Ҽ{�]����</p></td>";
	foreach($evaluate as $order=>$evaluate_data){
		$evaluate_list.="<td>$order<br>{$evaluate_data['school']}<br>{$evaluate_data['course']}</td>";
	}
	$evaluate_list.='</tr>';

	//����Ҽ{�]������
	$factor_items=array('self'=>'�ӤH�]��','env'=>'���Ҧ]��','info'=>'��T�]��');
	foreach($factor_items as $item=>$title){
		$factor=SFS_TEXT($title);
		$evaluate_list.="<tr bgcolor='#ddffdd'><td colspan=$evaluate_count>�� $title</td></tr>";
		foreach($factor as $key=>$data){
			$evaluate_list.="<tr><td>�@ -$data</td>";
			foreach($evaluate as $order=>$evaluate_data){
				$evaluate[$order]['sum']+=$evaluate_data['factor'][$item][$key];
				if($order==$_POST['edit_order']){
					$edit_radio='';
					for($i=1;$i<=5;$i++){
						$checked=($evaluate_data[factor][$item][$key]==$i)?'checked':'';
						$color=($evaluate_data[factor][$item][$key]==$i)?'#ff0000':'#000000';
						$edit_radio.="<input type='radio' name='evaluate[$item][$key]' value=$i $checked><font color='$color'>$i</font>";	
					}					
					$evaluate_list.="<td bgcolor='#fcffcf' align='center'>$edit_radio<input type='hidden' name='sn' value='{$evaluate_data['sn']}'</td>";
				} else { 
					$evaluate_list.="<td align='center'>{$evaluate_data[factor][$item][$key]}</td>"; 
				}
			}
			$evaluate_list.='</tr>';
		}			
	}	
	//�[�J�`�p�C
	$evaluate_list.="<tr></tr><tr bgcolor='#ddffdd' align='center'><td>���@�@�`�@�@�@�p�@�@��</td>";
	foreach($evaluate as $order=>$value){
		$evaluate_list.="<td><b>{$value['sum']}<b></td>"; 
	}		
	$evaluate_list.="</tr></table></p>";
			
	//�������߲z���絲�G
	$query="select * from career_test where student_sn=$student_sn and id<3";
	$res=$CONN->Execute($query);
	while(!$res->EOF){
		$id=$res->fields['id'];
		$highest_arr=explode(',',$res->fields['highest']);
		foreach($highest_arr as $key=>$value) $career_test[$id][$key]=$value;	
		$res->MoveNext();
	}
	
	$psy_result="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr align='center'><td rowspan=2 bgcolor='#ffcccc'>�����߲z���絲�G</td>
			<td bgcolor='#ffcccc'>�ʦV������Ƴ̰���3��������</td><td>{$career_test[1][0]}</td><td>{$career_test[1][1]}</td><td>{$career_test[1][2]}</td></tr>
		<tr align='center'><td bgcolor='#ffcccc'>���������Ƴ̰���3��������</td><td>{$career_test[2][0]}</td><td>{$career_test[2][1]}</td><td>{$career_test[2][2]}</td></tr>
		</table><br>";	
	
	/*
	$psy_result="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
		<tr align='center' bgcolor='#ffcccc'><td colspan=3>�����߲z���絲�G</td></tr><tr align='center' valign='top'>";
	//���o����J�����
	$item_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����(1)',4=>'��L����(2)');
	foreach($item_arr as $key=>$title){
		$query="select * from career_test where student_sn=$student_sn and id=$key";
		$res=$CONN->Execute($query);
		if($res){
			while(!$res->EOF){
				$sn=$res->fields['sn'];
				$content=unserialize($res->fields['content']);

				$title=$content['title'];
				$test_result=$content['data'];
				$study=$res->fields['study'];
				$job=$res->fields['job'];
				
				$content_list="<td><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
						<tr bgcolor='#ccffcc' align='center'><td colspan=2><b>$title</b></td></tr><tr></tr>
						<tr bgcolor='#ffcccc' align='center'><td>����</td><td>���e���G</td></tr>";
				if($test_result){
					foreach($test_result as $key2=>$value) $content_list.="<tr><td>$key2</td><td align='center'>$value</td></tr>";
				} else $content_list.="<tr align='center'><td colspan=2 height=100>�S���o�{������������I</td></tr>";
				
				$content_list.="<tr bgcolor='#fcccfc'><td colspan=2>���ھڴ��絲�G�A�b�ɾǤ譱�A�ھA�X�NŪ�G $study<br>���ھڴ��絲�G�A�b�N�~�譱�A�ھA�X�q�ơG $job</td></tr></table></td>";
				
				$psy_result.=$content_list;
//echo $content_list;				
				$res->MoveNext();
			}
	} else $content_list="<td><center><font size=2 color='#ff0000'>���o�{����{$item_arr[$key]}�����I<br></font></center></td>";	
	}
	$psy_result.="</tr></table><br>";	
	*/
//exit;		
	//���o���ǲߦ��Z���
	$fin_score=cal_fin_score(array($student_sn),$stud_seme_arr);
	$link_ss=array("chinese"=>"�y��-���","english"=>"�y��-�^�y","math"=>"�ƾ�","social"=>"���|","nature"=>"�۵M�P�ͬ����","art"=>"���N�P�H��","health"=>"���d�P��|","complex"=>"��X����");
	//��������Y
	$study_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
	<tr align='center' bgcolor='#ffcccc'><td rowspan=2>�ǲߪ�{<br>(���Ǵ��������Z)</td>";
	foreach($link_ss as $key=>$value) $study_list.="<td>$value</td>";
	
	//���e
	/*
	foreach($stud_seme_arr as $seme_key=>$year_seme){			
		$bgcolor=($curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
		$readonly=($curr_seme_key==$seme_key)?'':'readonly';
		$study_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>";
		foreach($link_ss as $key=>$value) $study_list.="<td>{$fin_score[$student_sn][$key][$year_seme]['score']}</td>";
	}
	*/
	//�`���Z
	$study_list.="<tr align='center' bgcolor='#ffffcc'>";
	foreach($link_ss as $key=>$value) $study_list.="<td><b>{$fin_score[$student_sn][$key]['avg']['score']}</b></td>";
	$study_list.="</tr></table>";
	
	$way_result.="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr bgcolor='#ffcccc' align='center'><td>�ͲP�ؼ�</td></tr><tr><td>�ڷQ��Ū���Ǯ�-�ǵ{�G";
	//����J�����
	$query="select aspiration_order,school,course from career_course where student_sn=$student_sn and aspiration_order>0 order by aspiration_order";
	$res=$CONN->Execute($query);
	//$evaluate_count=$res+1;
	while(!$res->EOF){
		$way_result.="({$res->fields['aspiration_order']}){$res->fields['school']}-{$res->fields['course']}�@ ";
		$res->MoveNext();
	}
	$way_result.="</font></td></tr></table>";
	
	//�ͲP��ܤ�V
	//����ͲP��ܤ�V�ѷӪ�
	$direction_items=SFS_TEXT('�ͲP��ܤ�V');
	
	//���o�v����X�N���J�����
	$query="select * from career_opinion where student_sn=$student_sn";
	$res=$CONN->Execute($query);
	if($res){
		while(!$res->EOF){
			$ii++;
			$sn=$res->fields['sn'];				
			$parent=' ,'.$res->fields['parent'].',';	
			$parent_radio='';
	
			foreach($direction_items as $d_key=>$d_value){
				$comp=','.$d_key.',';
				$checked=strpos($parent,$comp)?'��':'��';
				$color=strpos($parent,$comp)?'#0000ff':'#000000';
				$parent_radio.="<font color='$color'>$checked$d_value </font>";					
			}
			$parent_memo=$res->fields['parent_memo'];
			
			$tutor=' ,'.$res->fields['tutor'].',';
			foreach($direction_items as $d_key=>$d_value){
				$comp=','.$d_key.',';
				$checked=strpos($tutor,$comp)?'��':'��';
				$color=strpos($tutor,$comp)?'#0000ff':'#000000';
				$tutor_radio.="<font color='$color'>$checked$d_value </font>";	
			}
			$tutor_memo=$res->fields['tutor_memo'];
			
			$guidance=' ,'.$res->fields['guidance'].',';
			foreach($direction_items as $d_key=>$d_value){
				$comp=','.$d_key.',';
				$checked=strpos($guidance,$comp)?'��':'��';
				$color=strpos($guidance,$comp)?'#0000ff':'#000000';
				$guidance_radio.="<font color='$color'>$checked$d_value </font>";					
			}
			$guidance_memo=$res->fields['guidance_memo'];
			
			$opinions_list.="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
						<tr bgcolor='#ffcccc' align='center'><td colspan=2>�v����X�N��</td><td>�@ñ�@���@</td></tr>";
			
			$opinions_list.="<tr><td align='center'>�a���N��</td><td>��X�H�W������ơA�ڧƱ�Ĥl��ܡG$parent_radio<br>�����G$parent_memo</td><td></td></tr>
									<tr><td align='center'>�ɮv�N��</td><td>��X�H�W������ơA��ĳ�ǥͿ�Ū�G$tutor_radio<br>�����G$tutor_memo</td><td></td></tr>
									<tr><td align='center'>���ɱЮv�]���ɤp�ա^�N��</td><td>��X�H�W������ơA��ĳ�ǥͿ�Ū�G$guidance_radio<br>�����G$guidance_memo</td><td></td></tr>";
			
			$today=date("Y �~ m �� d ��");
			$opinions_list.="<tr><td colspan=3>�]���欰�ӽа���¾��Χޯ�ǵ{�M����^<br><br>
		�զW�G$school_long_name<br><br>
		�ǥͩm�W�G$stud_name �@�@�@�@ ���������~�G$curr_class_name �@ ���D�������~ <br><br>          
		�ӿ�H�G �@�@�@�@�@�@�@�@�@�@ �ӿ�B�ǥD���G �@�@�@�@�@�@�@�@�@�@�@�@ ������G $today</td></tr></table><br>";
			
			$res->MoveNext();
		}
	} else {  $opinions_list="<br><br><br><center><font size=4 color='#ff0000'>���o�{����{$menu_arr[$menu]}�����I</font></center>";	}
	
	//���B��L�ͲP���ɬ���
	$guidance_list="<br>���B��L�ͲP���ɬ���<br>�]�@�^�ͲP���ɬ����]�Ѿɮv�λ��ɱЮv��g�^<br>
�@�@1.�оɮv�B���ɱЮv�P�ǥͩήa���i��ͲP�Ը߻��ɫ�A�Ψ�L�A��ɾ��]�p�G�ǥͩʦV�ο������ӧO�����B�ͲP���������ˮ֦^�X�B�a����ίZ�˷|�y�ͰQ�סB�a�X�ιq�X�������^�A�N���ɭ��I�Ϋ�ĳ�O���󥻭��A�@���E�~�ŻP�ǥͰQ�ץͲP�o�i�W���Ѯɤ��ѦҡC<br>
�@�@2.�Ը߻��ɤ��e�дx���U�~�ťͲP���ɮ֤ߤ��[�]�C�~��--�ۧڹ�ı�P�����G���~�챴�B�K�~��--�ͲPı��P�ձ��G�{�ѥͲP���s�B�E�~��--�ͲP�����P�i����ܡ^�C<br>
�@�@3.��ĳ�Юv�i�v�L�����H��K�H�ɰO���Ϋظm��q���ɮפ��A�A�w���N������B�K���U�C<br>
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#ffcccc' align='center'><td>NO.</td><td>���</td><td>��H</td><td>���ɭ��I�Ϋ�ĳ</td><td>���ɱЮv</td><td>�������</td></tr>";
	//����J���Ը߬���
	$query="select * from career_guidance where student_sn=$student_sn order by guidance_date";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
	if($res){
		while(!$res->EOF){
			$ii++;
			$sn=$res->fields['sn'];
			$emphasis=str_replace("\r\n",'<br>',$res->fields['emphasis']);
			$guidance_list.="<tr align='center'>
			<td>$ii</td>						
			<td>{$res->fields['guidance_date']}</td>
			<td>{$res->fields['target']}</td>
			<td align='left'>$emphasis</td>
			<td>{$res->fields['teacher_name']}</td>	
			<td>{$res->fields['update_time']}</td>
				</tr>";	
			$res->MoveNext();
		}
	} else $guidance_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP���ɬJ���Ը߬����I</td></tr>";
	$guidance_list.="</table>";
	
	//��������Y
	$consultation_list="�]�G�^�ͲP�Ը߬����]�ѾǥͶ�g�^<br>
�@�@�z���P�ǮձЮv�ήa���Q�׹L�P���ӤɾǩδN�~�������Ʊ���?�v���P�z�Q�ת����e�Ϋ�ĳ�A�i�H�@���E�~�Ŷi��ͲP��ܮɪ��ѦҡC�бz�N�C�Ǵ��P�v���Q�צ����ͲP�W�������e�K�n�O���󥻭��C<br>
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��</td><td>���</td><td>�z�Ըߪ��v��</td><td>�Q�׭��I�ηN��</td><td>�Ƶ�</td>";
	
	//����J���Ը߬���
	$query="select * from career_consultation where student_sn=$student_sn order by seme_key";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
	if($res){
		while(!$res->EOF){
			$ii++;
			$sn=$res->fields['sn'];
			$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
			$emphasis=str_replace("\r\n",'<br>',$res->fields['emphasis']);
			$consultation_list.="<tr align='center'>
				<td>$ii</td>
				<td>{$res->fields['seme_key']}</td>
				<td>{$res->fields['consultation_date']}</td>
				<td>{$res->fields['teacher_name']}</td>						
				<td align='left'>$emphasis</td>
				<td align='left'>$memo</td>
				</tr>";	
			$res->MoveNext();
		}
	} else $consultation_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP���ɬJ���Ը߬����I</td></tr>";
	$consultation_list.="</table>";
	
	//��������Y
	$parent_list="�]�T�^�a������<br>	
�@�@�Ĥl�b��ܰꤤ���~��Q��Ū���ǮծɡA�a�����N���P���y�D�`���n�C�бz��U�Ĥl�@�_�����o���ͲP���ɬ�����U�A���L���A�X�ۤv���o�i��V�C<br>
�@�@�бz�Ѿ\�Ĥl�b���Ǧ~�פw��������ơA�g�U���Ĥl�����y�P��ĳ�A�ô����Ĥl�N����Uú��ǮձЮv�C���±z�I<br>
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr align='center' bgcolor='#ffcccc'><td>NO.</td><td>�~��-�Ǵ�</td><td>���</td><td>�Ѿ\���</td><td>���Ĥl�����y�Ϋ�ĳ</td><td>�ˮv���q�ɮvñ��</td>";
	
	//����J���Ը߬���
	$query="select * from career_parent where student_sn=$student_sn order by seme_key";
	$res=$CONN->Execute($query) or die("SQL���~:$query");
	if($res){
		while(!$res->EOF){
			$ii++;
			//�Ѿ\����٭쬰�}�C
			$items_array=unserialize($res->fields['items']);
			
			$sn=$res->fields['sn'];
			$items_list='';
			foreach($items as $key=>$value){
				$color=$items_array[$key]?'#ff0000':'#000000';
				$checked=$items_array[$key]?'��':'��';
				$items_list.="$checked $value<br>";
			}
			$items_list.="";
			
			$suggestion=str_replace("\r\n",'<br>',$res->fields['suggestion']);
			$tutor_confirm=str_replace("\r\n",'<br>',$res->fields['tutor_confirm']);
			$parent_list.="<tr align='center'>
				<td>$ii</td>
				<td>{$res->fields['seme_key']}</td>
				<td>{$res->fields['suggestion_date']}</td>
				<td align='left'>$items_list</td>						
				<td align='left'>$suggestion</td>						
				<td align='left'>{$res->fields['tutor_confirm']}<br>{$res->fields['tutor_name']}-{$res->fields['confirm_date']}</td>						
				</tr>";	
			$res->MoveNext();
		}
	} else $parent_list.="<tr align='center'><td colspan=7 height=24>���o�{�ͲP���ɮa�������y�Ϋ�ĳ�����I</td></tr>";
	$parent_list.="</table>";
	
	$memo="����<br>�Q�T¾�s�P�����ʦV����B������礧�������R���G<br>
<font size=1>�@�@�@�B�Q�T¾�s�P�����ʦV����B������礧�������R���G�A�D�ѱıШ|����2010�~�e�U��߻O�W�v�d�j�Ƕi��u���˰�����ǾǥͿ�ߧ����Ш|�ҵ{����������լd�u���s�v�A�g�լd�ثe�h�ưꤤ�Ǯմ��M�ϥΤ��ʦV�B�������]�h�]���ʦV����B�ڳ��w�����ơB�ꤤ�ͲP����q��^�����D�n���R��s����H�A�G�L�k�[�\�Ҧ��ǮըϥΤ���������A���U�դ��i�N�������礤���U�����絲�G�ۦ�Ѧҹ�ӡC<br>
�@�@�G�B�A�ʤ�¾�P�ʦV����α��Ҧ�¾�P�������Y�����|�������i�u¾�P��T�t�ΡG�s�ҫ��B�s�]�p�B�s�^�m�v���ѤQ�T¾�s�������R���G�C<br>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
<tr align='center'>
	<td>����W��</td><td>�h�]��<br>�ʦV����</td><td>�ڳ��w������</td><td>�ꤤ�ͲP<br>����q��</td><td>�A�ʤ�¾�P<br>�ʦV����</td><td>���Ҧ�¾�P<br>�������</td>
</tr>
<tr align='center' bgcolor='#ffcccc'>
<td>
�X����</td><td>����欰<br>��Ǫ�</td><td>�ҩe�|<br>¾�~�V�m��</td><td>�߲z�X����</td><td>�O�W�v�j<br>�ߴ�����</td><td>�O�W�v�j<br>


�ߴ�����</td>
</tr>
<tr align='center' bgcolor='#ccccff'>
<td>
<p align='right'>�s�s�~�N</p><p align='left'>¾�s�W��</p></td>
<td>1984</td><td>1987</td><td>
2000</td>
<td>
2011</td>
<td>
2011</td>
</tr>
</thead>
<tr align='center'>
<td>
����s</td>
<td>
�y����z<br>
�ƾǱ��z<br>
�Ŷ����Y<br>
������z</td>
<td>
����<br>
�u�~�Ͳ�<br>
���~�ư�<br>
���</td>
<td>
�A�u��<br>
�Ʋz��<br>
�A�ȫ�</td>
<td>
�ƾ�<br>
�Ŷ�<br>
��Ǳ��z</td>
<td>
R�]��Ϋ��^<br>
I�]��s���^<br>
C�]�ưȫ��^</td>
</tr>
<tr align='center'>
<td>
�ʤO��<br>
��s</td>
<td>
�y����z<br>
�ƾǱ��z<br>
�Ŷ����Y<br>
������z</td>
<td>
����<br>
�ӤH�A��<br>
�u�~�Ͳ�<br>
�P��</td>
<td>
�A�u��<br>
�Ʋz��<br>
�A�ȫ�</td>
<td>
�y��<br>
�Ŷ�<br>
�޿���z<br>
��Ǳ��z</td>
<td>
R�]��Ϋ��^<br>
S�]���|���^</td>
</tr>
<tr align='center'>
<td>
�q���P�q<br>
�l�s</td>
<td>
�ƾǱ��z<br>
�Ŷ����Y<br>
��H���z</td>
<td>
���<br>
����<br>
�u�~�Ͳ�<br>
�O��</td>
<td>
�A�u��<br>
�Ʋz��<br>
�A�ȫ�</td>
<td>
�ƾ�<br>
�Ŷ�<br>
�޿���z</td>
<td>
R�]��Ϋ��^<br>
I�]��s���^</td>
</tr>
<tr align='center'>
<td>
�g��P<br>
�ؿv�s</td>
<td>
�ƾǱ��z<br>
�Ŷ����Y<br>
��H���z<br>
��ı�t�׻P�T��</td>
<td>
�ؿv�G���<br>
���N<br>
����<br>
���<br>
�g��G���<br>
����<br>
���N<br>
�ӤH�A��<br>
���|�A��</td>
<td>
�A�u��<br>
�Ʋz��<br>
������<br>
��ѫ�</td>
<td>
�ƾ�<br>
�Ŷ�<br>
�޿���z<br>
���P</td>
<td>
R�]��Ϋ��^<br>
A�]���N���^</td>
</tr>
<tr align='center'>
<td>
�Ƥu�s</td>
<td>
�ƾǱ��z<br>
��H���z<br>
��ı�t�׻P�T��</td>
<td>
���<br>
����<br>
�u�~�Ͳ�</td>
<td>
�Ʋz��<br>
�A�u��<br>
��ѫ�</td>
<td>
�ƾ�<br>
�޿���z<br>
�[��</td>
<td>
R�]��Ϋ��^<br>
I�]��s���^<br>
A�]���N���^</td>
</tr>
<tr align='center'>
<td>
�ӷ~�P<br>
�޲z�s</td>
<td>
�y����z<br>
�ƾǱ��z<br>
��H���z<br>
��ı�t�׻P�T��</td>
<td>
���~�ư�<br>
�P��<br>
�ӤH�A��</td>
<td>
�A�ȫ�<br>
��ѫ�<br>
�k�ӫ�</td>
<td>
�y��<br>
�ƾ�<br>
�޿���z</td><td>
E�]���~���^<br>
C�]�ưȫ��^<br>
S�]���|���^</td>
</tr>
<tr align='center'>
<td>
�]�p�s</td>
<td>
�y����z<br>
�Ŷ����Y<br>
��H���z<br>
��ı�t�׻P�T��</td>
<td>
���N<br>
�P��<br>
����<br>
���</td>
<td>
������<br>
�k�ӫ�<br>
�A�u��</td>
<td>
�Ŷ�<br>
�[��<br>
���P<br>
�зN</td>
<td>
A�]���N���^<br>
R�]��Ϋ��^</td>
</tr>
<tr align='center'>
<td>
�A�~�s</td>
<td>
�ƾǱ��z<br>
��H���z<br>
��ı�t�׻P�T��</td>
<td>
�ʴӪ�<br>
���<br>
����</td>
<td>
�A�u��<br>
�Ʋz��<br>
������<br>
�A�ȫ�</td>
<td>
�޿���z<br>
�[��<br>
�зN</td>
<td>
R�]��Ϋ��^<br>
S�]���|���^<br>
I�]��s���^</td>
</tr>
<tr align='center'>
<td>
���~�s</td>
<td>
�y����z<br>
�ƾǱ��z</td>
<td>
�u�~�Ͳ�<br>
���<br>
���N<br>
����</td>
<td>
�A�u��<br>
�Ʋz��<br>
�A�ȫ�<br>
��ѫ�</td>
<td>
�ƾ�<br>
�޿���z<br>
�зN</td>
<td>
R�]��Ϋ��^<br>
E�]���~���^<br>
S�]���|���^</td>
</tr>
<tr align='center'>
<td>
�a�F�s</td>
<td>
�y����z<br>
�Ŷ����Y<br>
��ı�t�׻P�T��</td>
<td>
���N<br>
�P��<br>
�ӤH�A��</td>
<td>
�A�ȫ�<br>
������<br>
�Ʋz��<br>
�k�ӫ�</td>
<td>
�y��<br>
�Ŷ�<br>
���P<br>
�зN</td>
<td>
S�]���|���^<br>
A�]���N���^</td>
</tr>
<tr align='center'>
<td>
�\�ȸs</td>
<td>
�y����z<br>
�ƾǱ��z<br>
��ı�t�׻P�T��</td>
<td>
�ӤH�A��<br>
�P��<br>
���N</td>
<td>
�A�ȫ�<br>
������<br>
�A�u��</td>
<td>
�Ŷ�<br>
�[��<br>
���P<br>
�зN</td>
<td>
S�]���|���^<br>
R�]��Ϋ��^</td>
</tr>
<tr align='center'>
<td>
�����s</td>
<td>
������z<br>
��ı�t�׻P�T��</td>
<td>
�ʴӪ�<br>
���<br>
����<br>
�P��</td>
<td>
�A�u��<br>
�Ʋz��<br>
�A�ȫ�</td>
<td>
�޿���z<br>
�[��</td>
<td>
R�]��Ϋ��^<br>
E�]���~���^<br>
I�]��s���^</td>
</tr>
<tr align='center'>
<td>
���Ƹs</td>
<td>
�Ŷ����Y<br>
������z<br>
��ı�t�׻P�T��</td>
<td>
����<br>
�u�~�Ͳ�<br>
���</td>
<td>
�A�u��<br>
�A�ȫ�<br>
�Ʋz��</td>
<td>
�y��<br>
�Ŷ�<br>
��Ǳ��z</td>
<td>R�]��Ϋ��^<br>S�]���|���^</td>
	</tr>
</table>
�@��ƨӷ��G�}���X�]2010�^�C���˰�����ǾǥͿ�ߧ����Ш|�ҵ{����������լd�u���s�C�O�_�G�Ш|���C<br>
�@���`�ʡ]2010�^�C¾�P��T�t�ΡG�s�ҫ��B�s�]�p�B�s�^�m�A���|�������i�C</font>

$new_page

<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
<tr align='center' bgcolor='#ffcccc'><td rowspan=2>�Ǵ��O</td><td colspan=2>{$class_year[$min]}��</td><td colspan=2>{$class_year[$min+1]}��</td><td colspan=2>{$class_year[$min+2]}��</td></tr>
<tr align='center' bgcolor='#ffcccc'><td>��1�Ǵ�</td><td>��2�Ǵ�</td><td>��1�Ǵ�</td><td>��2�Ǵ�</td><td>��1�Ǵ�</td><td>��2�Ǵ�</td></tr>
<tr style='height: 72.9pt' align='center'><td>�f�\<br>�ֳ�</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr style='height: 72.9pt' align='center'><td>�f�\<br>���</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr style='height: 72.9pt' align='center'><td>�Ƶ�</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
";
	
		$rpt.="<center><P style='font-size:36px; color:blue; font-family:�з���'><br><br>�ꤤ�ǥͥͲP���ɬ�����U</p><br>(101.8-104.6)<br><P style='font-size:12px; color:red;'>�m�ǥͭӤH��ơA�Ч����O�ޡA�ÿ�u�O�K��h�n</P><br><br><br><br><br><br>
		<h3><table align='center'><tr><td>�ǮզW�١G</td><td>$school_long_name</td></tr><tr><td>�ǥͩm�W�G</td><td>$stud_name</td></tr></table></h3>$contact_list</center>
		$new_page $room_list<br>$contact_list2
		$new_page $words
		$new_page $mystory $new_page $mystory2
		$new_page $psy_test
		$new_page $study_spe
		$new_page $assistant_list<br>$club_list
		$new_page $race_list
		$new_page $reward_list $seme_list
		$new_page $service_list
		$new_page $explore_list
		$new_page $ponder_list		
		$new_page $direction_list<br>$course_list<br><br>
		$geodata
		$new_page $evaluate_list
		$new_page $psy_result $study_list $way_result
		$new_page $opinions_list
		$new_page $guidance_list
		$new_page $consultation_list
		$new_page $parent_list
		$new_page $memo
		";
		
		$rpt.=$new_page;
	}
	echo '<html>	<head>'."\n";
	echo '<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>'."\n";
	echo '<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>'."\n";
	echo '<script type="text/javascript" src="'.$SFS_PATH_HTML.'javascripts/gmap3.js"></script>'."\n";			
	echo '<script type="text/javascript" src="'.$SFS_PATH_HTML.'javascripts/markerwithlabel.js"></script>'."\n";	
	echo "
	<script type='text/javascript'>
      $(function(){
        var addressArr = {};";
	 foreach ($geodataSchool as $ii=>$schoolName)
        echo "addressArr['[".($ii+1)."] $schoolName'] = '$schoolName';";
        
     echo "
		addressArr['�ڪ��a'] = '$stud_addr'; 
     	$.each(addressArr , function(label ,address) {
        $('#test1').gmap3({
          defaults:{ 
            classes:{
              Marker:MarkerWithLabel
            }
          },
          map:{
            address:address,
            options:{
              zoom: 8,
            }
          },
          marker:{
            address:address,
            options:{
              labelContent: '$425K',
              labelAnchor: new google.maps.Point(52, -2),
              labelClass: 'labels',
              labelStyle: {opacity: 0.75},
              labelContent:  label
            }
          }
        });
       });
        
     });
    </script>	\n";
	echo '
	<style>
		.labels {font-size:10px; color: break; background:#af0;  white-space:nowrap; padding:2px}
      .gmap3{
        margin: 20px auto;
        border: 1px dashed #C0C0C0;
        width: 800px;
        height: 300px;
      }
    </style>
			';
	echo '</head><body>';
	echo $rpt;
	echo '</body></html>';
	exit;
}




//�q�X����
head("�ͲP���ɳ����X");

echo <<<HERE
<script>

function tagall(status,s) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].name==s) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}

function check_select() {
  var i=0; j=0; answer=true;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].checked) {
		if(document.myform.elements[i].name=='student_sn[]') j++;
    }
    i++;
  }
  
  if(j==0) { alert("�|������ǥ͡I"); answer=false; }
  
  return answer;
}

</script>
HERE;

//�Ҳտ��
print_menu($menu_p,$linkstr);

if($c_id){
	//�r��ﶵ
	$font_array=array(0=>'',1=>'',);
	$font_radio="<inpit type='radio' name='font' value=";
	
	$class_select.="<input type='checkbox' name='stud_check' onclick='javascript:tagall(this.checked,\"student_sn[]\");'>�������/������� <input type='submit' name='go'  value='�����X' onclick='this.form.target=\"_BLANK\"; return check_select();'>";
	$student_select='';
	//���;ǥͦW��
	$query="select a.student_sn,a.seme_num,b.stud_name,b.stud_sex from `stud_seme` a inner join stud_base b on a.student_sn=b.student_sn where seme_year_seme='$curr_year_seme' and seme_class='{$c_id}' order by a.seme_num";
	$res=$CONN->Execute($query) or die("SQL���~�G<br>$query");
	while(!$res->EOF){
		$i++;
		$checked=($student_sn==$res->fields['student_sn'])?'checked':'';
		$color=($res->fields['stud_sex']==1)?'#0000ff':'#ff0000';
		$color=($student_sn==$res->fields['student_sn'])?'#00ff00':$color;
		$student_select.="<input type='checkbox' name='student_sn[]' value='{$res->fields['student_sn']}' $checked><font color='$color'>({$res->fields['seme_num']}) {$res->fields['stud_name']}</font> ";
		if($i%7==0) $student_select.="<br>";
		
		$res->MoveNext();
	}
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#aa1111' width=700>
<tr><td valign='top'>$class_select</td></tr><tr><td>$student_select</td></tr></table></form></font>";

echo $main;

foot();

?>
