<?php                                                                                                                             
// $Id: ekind_edit.php 8673 2015-12-25 02:23:33Z qfon $
// --�t�γ]�w��
include "exam_config.php";

//�P�O�O�_���t�κ޲z��
$man_flag =  checkid($_SERVER[SCRIPT_FILENAME],1);

//�P�_�O�_���޲z�� $perr_man �}�C�]�w�b exam_config.php
if (!$man_flag) {	
	$str = "�A���Q���v�ϥΥ��\��A�ѦҨt�λ�����" ;
	redir("exam.php",3) ;
	exit;
}
$e_kind_id = $_GET[e_kind_id];
if ($e_kind_id =='')
	$e_kind_id = $_POST[e_kind_id];

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

//�R���B�z
if ($_GET[sel] =="delete"){
	include "header.php";
	
	//�Z�Ÿ��
	$e_kind_id=intval($e_kind_id);
	$query = "select class_id from exam_kind where e_kind_id = '$e_kind_id' ";
	$result = $CONN->Execute($query);
	$class_id = $result->fields[0];
	$temp_year = substr($class_id,4,1); //���o�~��	
	$temp_class = substr($class_id,5); //���o�Z��
	//�@�~�W��
	$query = "select exam_name from exam where e_kind_id = '$e_kind_id' ";
	$result = $CONN->Execute($query);
	$tt ="";
	while(!$result->EOF){
		$tt.= "<li>".$result->fields[0];
		$result->MOveNext();
	}
	
        echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"post\">\n"; 
        echo "�T�w�R�� <font color=red>$class_year[$temp_year]$class_name[$temp_class]�Z</font> �H<br>";
        if ($tt !="") 
        	echo "<br>�Ψ�Ҧ����@�~�A�p�U�C<br>".$tt;
        echo "<hr><input type=\"hidden\" name=\"e_kind_id\" value=\"$e_kind_id\">\n";
        echo "<input type=\"submit\" name=\"key\" value=\"�T�w�R��\" >\n";
        echo "&nbsp;&nbsp;<input type=button  value= \"�^�W��\" onclick=\"history.back()\">";

        echo "</form>";
        include "footer.php";
	exit;
}  
if ($_POST[key] =="�T�w�R��"){
	//�R���W�ǥؿ����
	$e_kind_id=intval($e_kind_id);
	$query = "select exam_id from exam where e_kind_id ='$e_kind_id'";
	$result = $CONN->Execute($query)or die($query);
	while (!$result->EOF) {
		$exam_id = $result->fields[0];
		//�ɮץؿ�
		$e_path = $upload_path."/e_".$result->fields[0]; 
		if (is_dir($e_path))
			exec( "rm -rf $e_path", $val );
		//�R���ǥͤW�ǰO��
		$sql_update = " delete from exam_stud ";	
		$sql_update .= " where exam_id='$exam_id' ";
		$CONN->Execute($sql_update)  or die ($sql_update);

		$result->MoveNext();
	}
	//�R�� �Z�Ÿ��
    $sql_update = " delete from exam_kind ";
	$sql_update .= " where e_kind_id='$e_kind_id' ";
	$result = $CONN->Execute($sql_update)  or die ($sql_update);  
	//�R�� �Z�ŧ@�~���
	$sql_update = " delete from exam ";
	$sql_update .= " where e_kind_id='$e_kind_id' ";
	$result = $CONN->Execute($sql_update)  or die ($sql_update); 
	
	header ("Location: ekind.php");
}

//�ק�B�z
if ($_POST[key] =="�ק�"){
	$class_id = $_POST[curr_year].$_POST[curr_class_year].$_POST[curr_class_name];
	$sql_update = "update exam_kind set e_kind_memo='$_POST[e_kind_memo]',e_kind_open='$_POST[e_kind_open]' ,e_upload_ok='$_POST[e_upload_ok]' ,class_id='$class_id'";
	$sql_update .= " where e_kind_id='$e_kind_id' ";
//	echo $sql_update;exit;
	$result = $CONN->Execute($sql_update)  or die ($sql_update);  
	header ("Location: ekind.php");
}

//���o�Z�Ū��ϸ��
$e_kind_id=intval($e_kind_id);
$sql_select = "select e_kind_id,e_kind_memo,e_kind_open,e_upload_ok from exam_kind";
$sql_select .= " where e_kind_id='$e_kind_id' ";
$result = $CONN->Execute($sql_select);
if ($result->RecordCount() > 0 ){
	$e_kind_id = $result->fields["e_kind_id"];	
	$e_kind_memo = $result->fields["e_kind_memo"];
	if ($result->fields["e_kind_open"]=="1")
		$e_kind_open =" checked ";
	else
		$e_kind_open ="";
	     
	if ($result->fields["e_upload_ok"]=="1")
		$e_upload_ok =" checked ";
	else
		$e_upload_ok ="";	     
}
   
include "header.php";
include "menu.php";

// $class_id 0-3 ->�Ǧ~ 4->�Ǵ� 5->�~�� 6- �Z�� 	
$curr_year = intval(substr($_GET[class_id],0,3))."�Ǧ~��";
if (substr($_GET[class_id],3,1) == 1 )
	$temp_seme = "�W�Ǵ�";
else
	$temp_seme = "�U�Ǵ�";
	
$temp_year = substr($_GET[class_id],4,1); //���o�~��	
$temp_class = substr($_GET[class_id],5); //���o�Z��

?>
<h3>�ק�Z�Ÿ��(<font color=red><?php echo $curr_year. $temp_seme ?></font>)</h3>
<form action ="<?php echo $_SERVER[PHP_SELF] ?>" method="post" >
<input type= hidden name=curr_class_id value="<?php echo $curr_class_id ?>" >
<table>

<tr>
	<td>�Z�ŦW��<br>
	<select	name="curr_class_year">
	<?php
	reset($class_year);
	 while(list($tkey,$tvalue)= each ($class_year)) {
		  if ($tkey == $temp_year)	  
			 echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		   else
			 echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
	}             	 
	?>


	</select>

	<select	name="curr_class_name">
	<?php
	$class_temp ="";
	reset($class_name);
	 while(list($tkey,$tvalue)= each ($class_name)) {
		if ($tkey == $temp_class)
			$class_temp .=  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			$class_temp .=   sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
	}             	 
	echo $class_temp ; 
	?>
 
 	</select>
	</td>
</tr>

<tr>
	<td>�O�_�}��i�ܧ@�~<br>
		<input type="checkbox" name="e_kind_open" value=1  <? echo $e_kind_open; ?>>
	</td>
</tr>

<tr>
	<td>�O�_�}��W�ǧ@�~<br>
		<input type="checkbox" name="e_upload_ok" value=1  <? echo $e_upload_ok; ?>>
	</td>
</tr>

<tr>
	<td>����<br>
		<textarea name="e_kind_memo" cols=40 rows=5 wrap=virtual><?php echo $e_kind_memo ?></textarea>
	</td>
</tr>
<tr>
	<td>
	<input type="hidden" name=e_kind_id value="<? echo $e_kind_id; ?>">
	<input type="hidden" name=curr_year value="<? echo substr($_GET[class_id],0,4); ?>">
	<input type="submit" name=key value="�ק�">
	&nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
	</td>
</tr>

</table>

<? include "footer.php"; ?>
