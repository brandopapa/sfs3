<?php                                                                                                                             
// $Id: tea_show.php 8673 2015-12-25 02:23:33Z qfon $
//���J�]�w��
include "exam_config.php";
//session_start();
include "header.php";
$grade_img = array("face_1.gif","face_2.gif","face_3.gif","face_4.gif","face_5.gif");
$exam_id = $_GET[exam_id];
if ($exam_id=='')
	$exam_id=intval($_POST[exam_id]);
$stud_id = $_GET[stud_id];
if ($stud_id=='')
	$stud_id = $_POST[stud_id];
//���q�B�z
include "header.php";
if($_SESSION[session_log_id]<>'') {
	if($_POST[key] == '���U���q') {
		$_POST[exam_id]=intval($_POST[exam_id]);
		$query = "select stud_id from exam_stud where exam_id= '$_POST[exam_id]' ";
		$result = $CONN->Execute($query);
		while (!$result->EOF) {
			$stud_id = $result->fields["stud_id"];	
			$temp = "tea_comment_".$stud_id;
			$tea_comment = $_POST[$temp];
			$temp = "tea_grade_".$stud_id;
			$tea_grade = intval($_POST[$temp]);
		
			$query2 = "update exam_stud set tea_comment='$tea_comment' ";
			if ($tea_grade !="")
				$query2 .= ",tea_grade=$tea_grade";
			$query2 .= " where exam_id= '$_POST[exam_id]' and stud_id ='$stud_id' ";
			$CONN->Execute($query2) ;
			$result->MoveNext();
		}
		echo "���q�w��s!!";
		redir( "$_SERVER[PHP_SELF]?exam_id=$_POST[exam_id]" ,1);
		exit;
	}
	
	if($_GET[key] == 'del'){
		
///mysqli	
$mysqliconn = get_mysqli_conn();
$stmt = "";
if ($stud_id <> "") {
    $stmt = $mysqliconn->prepare("select f_name from exam_stud where stud_id=? and exam_id='$exam_id'");
    $stmt->bind_param('s', $stud_id);
}
$stmt->execute();
$stmt->bind_result($f_namex);
$stmt->fetch();
$stmt->close();
///mysqli
		$f_name= $upload_path."e_".$exam_id."/".$stud_id."_".$f_namex;

		/*
		$query = "select f_name from exam_stud where stud_id='$stud_id' and exam_id='$exam_id'";
		$res = $CONN->Execute($query);
		$f_name= $upload_path."e_".$exam_id."/".$stud_id."_".$res->fields[0];
		//echo $f_name;exit;
		*/
		$query = "delete from exam_stud where stud_id='$stud_id' and exam_id='$exam_id'";
		$CONN->Execute($query);
		if(file_exists ($f_name))
       	        	unlink($f_name);
	}		
		
}

//�u�}���O
if (isset($_GET[cool])){
	$sql_update = "update exam_stud set cool = '$_GET[cool]' where exam_id= '$exam_id' and stud_id = '$stud_id' ";
	$result = $CONN->Execute($sql_update) or die ($sql_update);
}

//�@�~�W�ٳB�z
$exam_id=intval($exam_id);
$query = "select exam.exam_name,exam.exam_memo ,exam.teach_id,exam.teach_name,exam.exam_isupload,exam_kind.class_id,exam_kind.e_upload_ok from exam,exam_kind where exam.e_kind_id = exam_kind.e_kind_id and exam.exam_id='$exam_id' ";
$result = $CONN->Execute($query) or die($query);
$teach_id = $result->fields["teach_id"]; //�Юv�N��
$teach_name = $result->fields["teach_name"]; //�Юv�m�W
$exam_name = $result->fields["exam_name"];
$exam_memo = $result->fields["exam_memo"];
$e_upload_ok = $result->fields["e_upload_ok"];
$class_id = $result->fields["class_id"];
$exam_isupload = $result->fields["exam_isupload"];
//��ܧ@�~�Z��
echo "<h3>�Z�šG".get_class_name($class_id)." ���ɱЮv�G$teach_name</h3>";

//���o�ǥͦ~�ůZ��
if (isset($_SESSION[session_curr_class_num]))
	$curr_class = substr($_SESSION[session_curr_class_num],0,3 );


//�P�_�O�_�}�l�W�ǧ@�~ exam_isupload == 1
//�P�_�O�_���ӯZ�ǥͩΫ��ɱЮv�A�A�����W���v��		
echo "<center>";

$temp_class = sprintf("%03d%d%d",curr_year(),curr_seme(),substr($_SESSION[session_curr_class_num],0,3));
if ($exam_isupload == '1' && (($e_upload_ok == '1' && $class_id == $temp_class)||($teach_id == $_SESSION[session_log_id])) )
echo "<a href=\"tea_upload.php?exam_id=$exam_id&exam_name=$exam_name\">�W�ǧ@�~</a>&nbsp;&nbsp;";
echo "<a href=\"$_SERVER[PHP_SELF]?e_kind_id=$e_kind_id&exam_id=$exam_id\">���s��z</a>&nbsp;&nbsp;";
echo "<a href=\"exam_list.php\">�^�@�~�C���</a></center>";
echo "<form method=\"post\" action=\"tea_show.php\">";
echo "<table  border=1 >\n";
echo "<tr><td valign=top><table bordercolorlight=#ACBAF9 border=1 cellspacing=0 cellpadding=0 bgcolor=#C6FBCE bordercolordark=#DFE2FD width=100%>\n";
echo "<tr bgColor=\"#80ffff\"><td colspan=5 align=center ><font size=4><b>$e_kind_name </b></font></td></tr>\n";
echo "<tr><td colspan=5><font color=red size=3>�@�~�W�١G$exam_name<hr size=1>�����G $exam_memo</font></td></tr>\n";
echo "<tr><td width=165 align=\"center\" >�m�W</td><td width=65 align=\"center\" >���G</td><td width=220 align=\"center\" >���y</td><td width=70 align=\"center\" >�o��</td>";

if ($_SESSION[session_log_id] == $teach_id){
echo "<td>�R��</td>";
}

echo "</tr>\n";


//�@�~�i��
$exam_id=intval($exam_id);
$sql_select = "select exam_stud.*,exam.exam_id,exam.exam_name,exam.exam_memo,exam.exam_source_isopen,exam.e_kind_id
               from exam_stud,exam where exam.exam_id = exam_stud.exam_id              
               and exam_stud.exam_id= '$exam_id' order by exam_stud.stud_num";
$result = $CONN->Execute($sql_select) or die ($sql_select);

while (!$result->EOF) {
	$exam_id = $result->fields["exam_id"];
	$e_kind_id = $result->fields["e_kind_id"];
	$stud_name = $result->fields["stud_name"];
	$f_name = $result->fields["f_name"];
	$tea_comment = $result->fields["tea_comment"];
	$tea_grade = $result->fields["tea_grade"];
	$stud_num = $result->fields["stud_num"];
	$memo = $result->fields["memo"];
	$stud_id = $result->fields["stud_id"];
	$cool = $result->fields["cool"];
	$exam_source_isopen =$result->fields["exam_source_isopen"]; 
	
	//��ܹϥ�
	$temp_score = "&nbsp;";
	if ($tea_grade >= 90) 
		$temp_score = "<img src=\"images/$grade_img[0]\" alt=\"�u\">";
	else if ($tea_grade >=80) 
		$temp_score = "<img src=\"images/$grade_img[1]\" alt=\"��\">";
	else if ($tea_grade >=70) 
		$temp_score = "<img src=\"images/$grade_img[2]\" alt=\"�A\">";
	else if ($tea_grade >=60) 
		$temp_score = "<img src=\"images/$grade_img[3]\" alt=\"��\">";
	else if ($tea_grade >0 and $tea_grade < 60) 
		$temp_score = "<img src=\"images/$grade_img[4]\" alt=\"�B\">";
		
	$temp = explode(".", $f_name);	
	$pp = trim(strtolower($temp[count($temp)-1]));
	//����
	if (chop($memo) != ""){
		$memo2 = nl2br($memo);
		$memo=" alt=\"$memo\" ";
	}
	
	if ($tea_grade == 0 && $_SESSION[session_log_id]=="")
		$tea_grade ="&nbsp;";
	if ($tea_comment == "" && $_SESSION[session_log_id]=="")
		$tea_comment ="&nbsp;";
	if(substr($stud_id,0,4) != "demo" )
	 	$stud_name_temp = "$stud_num �� -- <a href=\"show_owner.php?stud_id=$stud_id&e_kind_id=$e_kind_id\">$stud_name</a>";
	 else
	 	$stud_name_temp = "�Юv�ܽd";
	//�ϥ�
	if ($cool == "1")
		$cool_img ="<img src=\"images/cool.gif\">";
	else
		$cool_img = "";
		
	//  �޲z�� 	
	if ($_SESSION[session_log_id] == $teach_id){
		if ($cool == "1")
			$set_cool = "<a href=\"$_SERVER[PHP_SELF]?cool=0&exam_id=$exam_id&stud_id=$stud_id\"><font color=red>Uncool</font></a>";
		else
			$set_cool = "<a href=\"$_SERVER[PHP_SELF]?cool=1&exam_id=$exam_id&stud_id=$stud_id\"><font size=+2><i>c</i></font>ool</a>";	              
	}
	
	if ($color_i++ % 2 == 0 )	 
		echo "<tr bgcolor=\"#E3FEDE\">";
	else
		echo "<tr>";
	echo "<td  align=center>$set_cool $cool_img $stud_name_temp </td>";
	echo "<td  >";
	//���Y�ɳB�z
	if ( $pp== "zip" ) {
		echo "<a href=\"".$uplaod_url."e_".$exam_id."/".$stud_id."/ \" target=\"_blank\">�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >";
	}
	else { 
	    if (($pp=="jpg")and ($_SESSION[session_log_id] == $teach_id)) { //�X�{�p��
	       echo "<img src=\"" . $uplaod_url . "e_" . $exam_id . "/" . $stud_id . "_".$f_name."\" width=\"160\" height=\"120\"> \n" ; 
	    }
		//���a�u�W���� mm=freemind sb=scratch
		$urlte = urlencode($uplaod_url."e_".$exam_id."/".$stud_id."_".trim($f_name));
		if($pp=="mm"){	
			echo "<a href=\"mm_show.php?name=".urlencode($stud_name_temp)."&tn=".urlencode($exam_name)."&uu=".$urlte."\" target=\"_blank\">�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >";
		}elseif($pp=="sb"){
			echo "<a href=\"sb_show.php?name=".urlencode($stud_name_temp)."&tn=".urlencode($exam_name)."&uu=".$urlte."&memo=".$memo2."\" target=\"_blank\">�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >";
		}else{
			echo "<a href=\"".$uplaod_url."e_".$exam_id."/".$stud_id."_".$f_name."\" target=\"_blank\">�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >";
		}   
		
		//name �ݥ[�J�ǥͥN��
		if ($_SESSION[session_log_id] == $teach_id){
			echo "<td><input type=text size=30 name=tea_comment_".$stud_id." value=\"$tea_comment\"></td>";
			echo "<td align=center><input type=text size=8 name=tea_grade_".$stud_id." value=\"$tea_grade\" > $temp_score</td>";
		}
		else {
			if(substr($stud_id,0,4) == "demo" ) //�Юv
				echo "<td colspan=2>&nbsp;</td>";
			else {				
				echo "<td >$tea_comment</td>";
				if ($is_score_img) //��ܵ���(�b exam_config.php ���]�w)
					echo "<td align=\"center\">$temp_score</td>"; 
				else
					echo "<td align=\"center\">$tea_grade</td>"; 
			}
		}
	
		if($exam_source_isopen =="1" && (($pp== "php" )|| ($pp == "php3"))) {
			echo "&nbsp;�U&nbsp;<a href=\"".$uplaod_url."/e_".$exam_id."/".$stud_id."_".$temp[0].".phps\">�d�ݭ�l��</a>";
		}

	}

	echo"</td>";
	if ($_SESSION[session_log_id] == $teach_id){
		echo "<td><a href=\"$_SERVER[PHP_SELF]?key=del&f_name=e_$exam_id/$stud_id"."_$f_name&stud_id=$stud_id&e_kind_id=$e_kind_id&exam_id=$exam_id\">�R��</a></td>";
	}
	echo "</tr>";

	$stud_id_arr[]=$stud_id	;
	$result->MoveNext();
};


if ($_SESSION[session_log_id] == $teach_id){
	//����@�~�C��
	$class_id_temp = substr($class_id,-3);
	$study_year_temp = intval(substr($class_id,0,3));
	$query = "select stud_id,stud_name,curr_class_num from stud_base where curr_class_num like '$class_id_temp%' and stud_study_cond=0  order by curr_class_num ";
	$result = $CONN->Execute($query) or die ($query);
	while (!$result->EOF) {
		$class_num = intval(substr($result->fields[2],-2));
		if (!in_array ($result->fields[0], $stud_id_arr))
		echo "<tr><td align=center>".$class_num." �� -- ".$result->fields[1]."</td><td colspan=4>�|������</td></tr>";
		$result->MoveNext();
	}

	echo "<br><tr><td colspan=4 align=right>
		<input type=\"hidden\" name=\"exam_id\" value=\"$exam_id\">
		<input type=\"submit\" name=\"key\" value=\"���U���q\"></td></tr>";
}

?>
</table>
</td></tr>
</table>
</form>
�ϥܡG<img src="images/cool.gif"> -- <font size =+2><i>�� </i></font>��I
<hr width=300 size=1>
<a href="exam_list.php">�^�@�~�C���</a>
<? include "footer.php"; ?>
