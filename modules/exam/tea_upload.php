<?php
                                                                                                                             
// $Id: tea_upload.php 8743 2016-01-08 14:02:58Z qfon $

//�t�γ]�w��
include "exam_config.php";
$exam_id=$_POST[exam_id];
if ($exam_id=='')
	$exam_id = $_GET[exam_id];

$e_kind_id = $_POST[e_kind_id];

//mysqli
$mysqliconn = get_mysqli_conn();	



// �ˬd�ɮ� (zip �榡)
function list_file($m_path) {
	
	exec("ls -l ".$m_path , $result, $id);
			$i = 1;
			$temp_ok = "";
			while (isset($result[$i])) {
				$result[$i] = eregi_replace(" +", ",", $result[$i]);
				$line = explode(",", $result[$i]);
				
				if (!ereg("^d", $line[0]))  {					
					$temp_ok .= $line[8]."�W�� ����!<br>\n";
					$f_temp = explode(".", $line[8]);
					//�N .php .php3 �ɧאּ .phps
					//if ($f_temp[count($f_temp)-1] == 'php' || $f_temp[count($f_temp)-1] == 'php3')
					if (is_php_name($f_temp[count($f_temp)-1]))
						exec ( "mv $m_path/".$line[8]." $m_path/".$f_temp[0].".phps" , $val);
				}			
				else {
					 list_file($m_path."/".$line[8]);	
				}
				$i++;

			}
}

//�ˬd�ɮ�
//�ˬd�� return true 
function is_php_name ($chk) {
	global 	$limit_file_name ; //�����\�����ɦW �b exam_config.php ���]�w
	$flag = false;
	for($i=0;$i<count($limit_file_name);$i++)
		if ($chk == $limit_file_name[$i])
			$flag = true;
	return $flag;
}

session_start();
if ($_SESSION[session_stud_id] == "" && $_SESSION[session_log_id] == "" ){	
	$exename = $_SERVER[REQUEST_URI];
	include "checkid.php";
	exit;
}
//�Юv����
if ($_SESSION[session_log_id] !=""){
	$s_stud_id = "demo_".$_SESSION[session_log_id];
	$s_stud_name = addslashes ($_SESSION[session_tea_name]);
}
else {
	$s_stud_id = $_SESSION[session_stud_id];
	$s_stud_name = addslashes ($_SESSION[session_stud_name]);
}

if ($_POST[key] == "�W�ǧ@�~") {
	
	//�إߥؿ�
	if (!is_dir($upload_path))
		mkdir($upload_path, 0755); //�W�ǥؿ�

	$e_path = $upload_path."/e_".$_POST[exam_id];
	if (!is_dir($e_path))
		mkdir($e_path, 0755);//�@�~�ؿ�

	//�P�_�ɦW
	$f_name = $_FILES[infile][name];
	$f_size = $_FILES[infile][size];
	$f_temp = explode(".", $f_name);	
	//if ($f_temp[count($f_temp)-1] == 'php' || $f_temp[count($f_temp)-1] == 'php3')
	if (is_php_name($f_temp[count($f_temp)-1]))
		$f_name = $f_temp[0].".phps";
	else if ($f_temp[count($f_temp)-1] == 'zip' )

		$f_name_src = "zip";
	


	//�R�����ɮ�  
	$exam_id=intval($exam_id);
	$sql_update = "select * from  exam_stud \n";
	$sql_update .= "where stud_id='$s_stud_id' and exam_id='$exam_id'";
	$result = $CONN->Execute($sql_update)or die($sql_update);	
	$alias = $e_path."/".$s_stud_id."_".$result->fields["f_name"];
	$f_temp = explode(".", $alias);
	if (file_exists($alias))
		unlink($alias);
			
	
	//�[�J�ɶ��ܼ�
	$ff_name = time()."_".$f_name;

	$USR_DESTINATION = $e_path."/".$s_stud_id."_".$ff_name;
	if(file_exists($_FILES[infile][tmp_name])){
		copy($_FILES[infile][tmp_name], $USR_DESTINATION); 
		//��s��Ʈw		
		//$sql_update = "delete from  exam_stud \n";
		//$sql_update .= "where stud_id='$s_stud_id' and exam_id='$exam_id'";
		//$result = mysql_query ($sql_update);
		
		$query = "select stud_id from exam_stud where stud_id='$s_stud_id' and exam_id='$exam_id'";
		$result= $CONN->Execute($query);
		//�ǥͧ���
		$stud_num = substr($_SESSION[session_curr_class_num] ,-2);
		if ($result->RecordCount()== 0 ) { //�s�W���		
			/*
			$sql_insert = "insert into exam_stud (exam_id,stud_id,stud_name,stud_num,memo,f_name,f_size,f_ctime) values ('$exam_id','$s_stud_id','$s_stud_name','$stud_num','$_POST[memo] ','$ff_name ','$f_size','$now')";
			$CONN->Execute($sql_insert)or die ($sql_insert);
			*/
//mysqli
$sql_insert = "insert into exam_stud (exam_id,stud_id,stud_name,stud_num,memo,f_name,f_size,f_ctime) values ('$exam_id','$s_stud_id','$s_stud_name','$stud_num',?,'$ff_name ','$f_size','$now')";
$stmt = "";
$stmt = $mysqliconn->prepare($sql_insert);
$stmt->bind_param('s', $_POST[memo]);
$stmt->execute();
$stmt->close();
///mysqli	
			
			
			
		}
		else {
			/*
			$query = "update exam_stud set memo='$_POST[memo]',f_name='$ff_name',f_size='$f_size',f_ctime='$now'  where stud_id='$s_stud_id' and exam_id='$exam_id'";
			$CONN->Execute($query)or die ($query);
			*/
//mysqli
$query = "update exam_stud set memo=?,f_name='$ff_name',f_size='$f_size',f_ctime='$now'  where stud_id='$s_stud_id' and exam_id='$exam_id'";
$stmt = "";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s', $_POST[memo]);
$stmt->execute();
$stmt->close();
///mysqli	
		
		
		
		}
		$m_path = $e_path."/".$s_stud_id;
		//�p���ؿ��h�R����ӥؿ�
		if (is_dir($m_path))
			exec( "rm -rf $m_path", $val );
		if ($f_name_src == "zip"){		
			mkdir( $m_path , 0755);  //�ӤHzip�Ѷ}�ؿ�
			//�Ѷ}�ɮ�
			exec("unzip  $USR_DESTINATION -d $m_path",$val);

			//�C�X�ɮ��ˬd���L .php .php3 ��
			list_file($m_path);
			
		}
		if ($temp_ok =="") //�����^�@�~��
			header ("Location: tea_show.php?e_kind_id=$e_kind_id&exam_id=$exam_id");
		else {
			include "header.php";
			echo $temp_ok;
		}
			
	}
	else {
		include "header.php";
		echo "<h2>�ɮפW�ǥ���!!</h2><br>\n";
		echo "<form><input type=\"button\"  value= \"�^�W��\" onclick=\"history.back()\"></form>";
	}
	echo "<hr width=200><a href=\"tea_show.php?e_kind_id=$e_kind_id&exam_id=$exam_id\">�^�@�~�C��</a>";
	include "footer.php";
	exit;
}
$exam_id=intval($exam_id);
$sql_select = "select exam_kind.e_upload_ok,exam_kind.class_id,exam.exam_id,exam.teach_id,exam.exam_isupload from exam_kind,exam \n";       
$sql_select .= "where exam_kind.e_kind_id =exam.e_kind_id and  exam.exam_id='$exam_id'";
$result = $CONN->Execute($sql_select)or die($sql_select);
//���X�ϥξǥͪ��Ǧ~��(3�줸)�Ǵ�(1�줸)�~��(1�줸)�Ǵ�(1�줸)�Z�O(1~ �줸)
$tempc = sprintf("%03s%d%s",curr_year(),curr_seme(),substr($_SESSION[session_curr_class_num],0,strlen($_SESSION[session_curr_class_num])-2));
//echo "$tempc,$row[class_id]<BR>";
//�ˬd�W���v��
//�P�_�O�_�}�l�W�ǧ@�~ exam_isupload == 1
//�P�_�O�_���ӯZ�ǥͩΫ��ɱЮv�A�A�����W���v��
if (($result->fields["class_id"] != $tempc || $result->fields["e_upload_ok"] != "1")&& $result->fields["teach_id"] != $_SESSION[session_log_id] || $result->fields["exam_isupload"] != "1") {
	//echo "dddd:".$row["e_upload_ok"];
	echo "<h2>�����@�~�ثe�����v�W��</h2> ";
	echo "<form><input type=\"button\"  value= \"�^�W��\" onclick=\"history.back()\"></form>";
	include "footer.php";
	exit;
}

$sql_select = "select exam_id,stud_id,memo from exam_stud \n";
$sql_select .= "where stud_id='$s_stud_id' and exam_id='$exam_id'";
$result = $CONN->Execute($sql_select) or die($sql_select);
$memo = $result->fields["memo"]; 

include "header.php";
?>

<form  enctype="multipart/form-data" method="post">
<?php 
if ($_SESSION[session_tea_name] !="")
	echo "<h3>���ɦѮv�G$_SESSION[session_tea_name] </h3>";
else
	echo "<h3>�ǭ��G$_SESSION[session_stud_name] </h3>";
?>
<h3>�W�� <font color=red><?php echo stripslashes ($_GET[exam_name]); ?></font> �@�~</h3>
<table>

<tr>
	<td>�@�~����<br>
		<textarea name="memo" cols=40 rows=5 wrap=virtual><?php echo $memo ?></textarea>
	</td>
</tr>
<tr>
<td>
	�ɮצ�m<br><input type=file name="infile" size=36 >
</table>
	<input type="hidden"  name="exam_id" value="<?php echo $exam_id ?>">
	<input type="submit"  name="key" value="�W�ǧ@�~">
	
</form>
<hr width=200><a href="exam_list.php">�^�@�~�C��</a>
<?php
	include "footer.php";
?>
