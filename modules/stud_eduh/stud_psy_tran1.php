<?php
// $Id: stud_psy_tran1.php 6150 2010-09-14 03:54:47Z brucelyc $

include "config.php";

sfs_check();

if($_POST['BtnSubmit']=='�פJ')
{
	if ($_FILES['import']['size'] >0 && $_FILES['import']['name'] != "")
	{
		//Ū�Xcsv���e
		$items_arr=array();
		$fp = fopen($_FILES['import']['tmp_name'],"r");
		while ($data = sfs_fgetcsv($fp,2000, ","))
		{
  			$items_arr[]=$data;
		}
		fclose($fp);
		
		//echo "<PRE>";
		//print_r($items_arr);
		//echo "</PRE>";
				
		//�ǳƶפJsql
		if(count($items_arr))
		{	$duplicated="<font size=2 color=#FF0000>";
			$sql.='INSERT INTO stud_psy_test(year,semester,student_sn,item,score,model,standard,pr,explanation,test_date,teacher_sn) VALUES';
			foreach($items_arr as $key=>$value)
			{
				$serial++;
				if($key)    //�Ĥ@�C�ߺD�����D�C  ���פJ
				{
					//�ˬd�O�_�w������  �Y��  �h�����פJ
					$record_year=$value[0];
					$record_semester=$value[1];
					$record_student_sn=$value[2];
					$record_item=$value[3];
					$record_test_date=$value[9];
					$check_sql="SELECT sn FROM stud_psy_test WHERE year=$record_year AND semester=$record_semester AND student_sn=$record_student_sn AND test_date='$record_test_date' AND item='$record_item';";
					$check_res=$CONN->Execute($check_sql) or user_error("�ˬd�O�_���ƶפJ����������ѡI<br>$check_sql",256);
			
					if(!$check_res->recordcount()){
					
						$items_value='';
						foreach($value as $field)
						{
							$items_value.='"'.$field.'",';
						}
						$sql.="(".substr($items_value,0,-1)."),";
					} else $duplicated.="#$serial $record_year �Ǧ~�ײ� $record_semester �Ǵ� $record_student_sn $record_item $record_test_date ���Ƥ����פJ!! <BR>";
				}
			}
			$duplicated.="</font>";
			
			$sql=substr($sql,0,-1);
			
			//echo $sql."<BR><BR>";
			
			$sql=str_replace('""','NULL',$sql);
			//echo $sql;
			//�}�l�i��פJ
			$res=$CONN->Execute($sql) or user_error("�פJ����������ѡI<br>$sql<br><br>���i��O���ɮפw�g�פJ�L�F!!",256);
			$executed='<BR><BR><font color=#0000FF>�� '.date('Y/m/d h:i:s')." �w�� ".$_FILES['import']['name']." �פJ������</font>";
		}
	}
}


head("�߲z����O�����");
 print_menu($menu_p);

$main="<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' id='AutoNumber1'>";
$main.="<form name='myform'  enctype='multipart/form-data' method='post' action='$_SERVER[PHP_SELF]'>
<tr bgcolor='#EEEEEE'>
<td colspan='2'>$submenu</td>
</tr>
  <tr bgcolor='#FFCCCC'><td align='center'>���@�@��</td><td align='center'>�ഫ�B�J</td></tr><tr>
    <td width='45%'>
<ul>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>����n�i�����H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>SFS3��߲z����έp�������۱Ш|�����y��ƥ洫�з� XML2.0 
  �]�p�A96�~���G��3.0�зǻP��2.0���P�C</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>�j�����Ǯդ��� 2.0 
  �зǻP�Ǯչ�Ⱦާ@�����A�Ħ����ۦ�w�q��Ӫ�����覡�i������C</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>�s���G�� XML 3.0 
  �зǲŦX�J���ǮչB�@�Ҧ��w�q�A���¦����������i�����ʧ@�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>�@�w�n�i�����H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>���ɬ����������U���|�N��ưѷ��ഫ��s������ӡA�Y�Q�ե��i�����A�N�|������^�������D�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>��˶i�����H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'>
  <font size='2'>SFS3�}�o�ζ��Ҷq�U�զۦ�w�q�����ѷӤ��P�A�B��@���i����F�ƦX�ʪ���ơC�b�����Τ@��X�޿�B��W�h�����p�U�A���H��ʪ��覡�i�����ʧ@�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>����{�Ǭ���H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>����{�Ǥ�4���q�G</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>(1)�N�������X��CSV�ɡC</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>(2)�U���s�榡�C</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>(3)�N���ɮץH�H�u�f�\�վ��A�H�s�榡�x�s�C</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>(4)�N�s�榡���ɮ׶פJ�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>���᪺�B�@�n�`�N���a��H</font>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>(1)���߲z��������אּ�b&quot;�߲z����O��(XML3.0�s) &quot;��g�C</font></p>
  </li>
</ul>
    </td>
    <td width='55%' valign='top'>
    <a href='old_psy_2_csv.php'>STEP 1: �����U���ª��ơC</a><BR><BR>
    <a href='stud_psy_test.csv'>STEP 2: �U���w�ƶפJ��CSV�s�榡�C</a><BR><BR>
    STEP 3: ��ӷs�榡�A�N�¸�ƽs��勵���s�榡(�O�o�N�������޸��]��)�C<BR><BR>
    STEP 4: �פJ�G<input type='file' name='import' size=15><input type='submit' value='�פJ' name='BtnSubmit'><BR><BR>
    $executed<BR><BR>$duplicated
    </td>
  </tr>
</table>
<input type='hidden' name='sel' value='$sel'>
</form>
";

echo $main;

foot();


?>
