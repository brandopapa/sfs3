<?php
//$Id$
// ���J�t�γ]�w��
require_once "config.php";
sfs_check();
head("��ƪ������");
print_menu($school_menu_p);
if($_POST['tables'] || $_POST['all_tables']) {
	//Ū���n��諸��ƪ��T
	if ($_POST['all_tables']) {
		$sql="SHOW TABLE STATUS FROM $mysql_db";
	} else {
		$tables_list="'".str_replace(",","','",$_POST['tables'])."'";
		$sql="SHOW TABLE STATUS FROM $mysql_db WHERE NAME IN ($tables_list)";
	}
	$res=$CONN->Execute($sql) or user_error("<FONT COLOR='RED'>Ū����ƪ��T���ѡI<br>$sql</FONT><BR>",256);
	$status_result=$res->getrows();
	$tables_count=count($status_result);
	echo "<BR>���z�n��� $tables_count �Ӹ�ƪ�G".$_POST['tables']."<HR>";
	//echo "<BR>����ƪ��T�G";	

	//Ū��table.xml -->��SVN�o�����ɮ�
	if (file_exists('table.xml')) {
		$xml = simplexml_load_file("table.xml");
		foreach($status_result as $key=>$table){
			$table_name=$table['Name'];
			echo "<FONT COLOR='BLUE'>��<B>$table_name</B>�@�r�X�G".$table['Collation']."�@�O�����ơG".$table['Rows']."�@��ƿ��j�p�G".$table['Data_length']."�@�Ыخɶ��G".$table['Create_time']."</FONT>";
			$sql2="SHOW COLUMNS FROM `$table_name`;";
			$res2=$CONN->Execute($sql2) or user_error("SHOW COLUMNS���ѡI<br>$sql2",256);
			$pri_key='';
			$uni_key='';
			$result='';
			//$xml_table=$xml->$table_name;
			while(! $res2->EOF){
				$field_name=$res2->fields[0];
				$xml_field=$xml->$table_name->Fields->$field_name;
				
				$is_different=False;
				$field_type=$res2->fields[1]; $xml_field_type=$xml_field->Type; if($field_type<>$xml_field_type) { $is_different=true; }
				$field_null=$res2->fields[2]; $xml_field_null=$xml_field->Null; if($field_null<>$xml_field_null) { $is_different=true; }
				$field_key=$res2->fields[3]; $xml_field_key=$xml_field->Key; if($field_key<>$xml_field_key) { $is_different=true; }
					if($field_key=='PRI') { $pri_key.=" $field_name ,"; } if($field_key=='UNI') { $uni_key.=" $field_name ,"; }
				$field_Default=$res2->fields[4]; $xml_field_Default=$xml_field->Default;
				//$field_Extra=$res2->fields[5];

				if($is_different) {
					$result.="<br>�����W�١G$field_name";
					$result.="<TABLE name='$table_name_$field_name' width='70%' align='center'  border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'>";
					$result.="<TR bgcolor='#CCFFCC'><TD>����T</TD><TD>�ڪ��ǰȨt��</TD><TD>�˪O��ƪ�</TD></TR>";
					$result.="<TR><TD>���A</TD><TD>$field_type</TD><TD>$xml_field_type</TD></TR>";
					$result.="<TR><TD>���\�ŭ�</TD><TD>$field_null</TD><TD>$xml_field_null</TD></TR>";
					$result.="<TR><TD>�������</TD><TD>$field_key</TD><TD>$xml_field_key</TD></TR>";
					$result.="<TR><TD>�w�]��</TD><TD>$field_Default</TD><TD>$xml_field_Default</TD></TR></TABLE>";
				}
				$res2->movenext();
			}
			echo "<BR>�@<FONT size=2 color=green>�������޸�T�G�@��PrimaryKey: $pri_key �@�@��UniqueKey: $uni_key</FONT>";
			echo $result?$result:'<BR><FONT COLOR="orange">�@�@�����������@�ϥΤ�����ƪ�P�˪O��Ƥ�ﵲ�G��۲šI�@����������</FONT>';
			echo "<HR>";
		}
	} else {
		exit('<BR><FONT COLOR="RED">���L�kŪ���˪������table.xml�I</FONT><BR>');
	}
}
echo "<BR><form action =\"{$_SERVER['SCRIPT_NAME']}\" method=post>������諸��ƪ�G<input type=text name=\"tables\" size=50 length=50><input type=\"submit\" name=\"all_tables\" value=\"�Ҧ���ƪ�\"><input type=\"submit\" name=\"go\" value=\"Go\"></form>";

foot();
?>
