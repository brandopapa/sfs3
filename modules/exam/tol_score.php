<?php
                                                                                                                             
// $Id: tol_score.php 8673 2015-12-25 02:23:33Z qfon $

//���J�]�w��
include "exam_config.php";
//session_start();
include "header.php";
$grade_img = array("face_1.gif","face_2.gif","face_3.gif","face_4.gif","face_5.gif");
//���q�B�z
include "header.php";
if($key =='���U���q') {
	$exam_id=intval($exam_id);
	$query = "select stud_id from exam_stud where exam_id= '$exam_id' ";
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)) {
		$stud_id = $row["stud_id"];	
		$temp = "tea_comment_".$stud_id;
		$tea_comment = $$temp;
		$temp = "tea_grade_".$stud_id;
		$tea_grade = $$temp;
		
		$query2 = "update exam_stud set tea_comment='$tea_comment' ";
		if ($tea_grade !="")
		$query2 .= ",tea_grade=$tea_grade";
		$query2 .= " where exam_id= '$exam_id' and stud_id ='$stud_id' ";
		mysql_query ($query2) ;
	}
	redir_str( "$PHP_SELF?exam_id=$exam_id" ,"���q�w��s!!",1);
	exit;
}

//�u�}���O
if (isset($cool)){
	$sql_update = "update exam_stud set cool = '$cool' where exam_id= '$exam_id' and stud_id = '$stud_id' ";
	$result = mysql_query ($sql_update,$conID) or die ($sql_update);
}

//�@�~�W�ٳB�z
$exam_id=intval($exam_id);
$query = "select exam.exam_name,exam.exam_memo ,exam.teach_id,exam.teach_name,exam.exam_isupload,exam_kind.class_id,exam_kind.e_upload_ok from exam,exam_kind where exam.e_kind_id = exam_kind.e_kind_id and exam.exam_id='$exam_id' ";
$result = mysql_query ($query) or die($query);
$row = mysql_fetch_array($result);
$teach_id = $row["teach_id"]; //�Юv�N��
$teach_name = $row["teach_name"]; //�Юv�m�W
$exam_name = $row["exam_name"];
$exam_memo = $row["exam_memo"];
$e_upload_ok = $row["e_upload_ok"];
$class_id = $row["class_id"];
$exam_isupload = $row["exam_isupload"];
//��ܧ@�~�Z��
echo "<h3>�Z�šG".get_class_name($class_id)." ���ɱЮv�G$teach_name</h3>";

//���o�ǥͦ~�ůZ��
if (isset($session_curr_class_num))
	$curr_class = substr($session_curr_class_num,1,2 );


//�P�_�O�_�}�l�W�ǧ@�~ exam_isupload == 1
//�P�_�O�_���ӯZ�ǥͩΫ��ɱЮv�A�A�����W���v��		
echo "<center>";
if ($exam_isupload == '1' && (($e_upload_ok == '1' && substr($class_id,-2) == $curr_class)||($teach_id == $session_log_id)) )
echo "<a href=\"tea_upload.php?exam_id=$exam_id&exam_name=$exam_name\">�W�ǧ@�~</a>&nbsp;&nbsp;";
echo "<a href=\"$PHP_SELF?e_kind_id=$e_kind_id&exam_id=$exam_id\">���s��z</a>&nbsp;&nbsp;";
echo "<a href=\"exam_list.php\">�^�@�~�C���</a></center>";
echo "<form method=\"post\" action=\"tea_show.php\">";
echo "<table  border=1 >\n";
echo "<tr><td valign=top><table bordercolorlight=#ACBAF9 border=1 cellspacing=0 cellpadding=0 bgcolor=#C6FBCE bordercolordark=#DFE2FD width=535>\n";
echo "<tr bgColor=\"#80ffff\"><td colspan=4 align=center ><font size=4><b>$e_kind_name </b></font></td></tr>\n";
echo "<tr><td colspan=4><font color=red size=3>�@�~�W�١G$exam_name<hr size=1>�����G $exam_memo</font></td></tr>\n";
echo "<tr><td width=165 align=\"center\" >�m�W</td><td width=65 align=\"center\" >���G</td><td width=220 align=\"center\" >���y</td><td width=70 align=\"center\" >�o��</td></tr>\n";

//�@�~�i��
$exam_id=intval($exam_id);
$sql_select = "select exam_stud.*,exam.exam_id,exam.exam_name,exam.exam_memo,exam.exam_source_isopen
               from exam_stud,exam where exam.exam_id = exam_stud.exam_id              
               and exam_stud.exam_id= '$exam_id' order by exam_stud.stud_num";
$result = mysql_query ($sql_select) or die ($sql_select);

while ($row = mysql_fetch_array($result)) {
	$exam_id = $row["exam_id"];
	$stud_name = $row["stud_name"];
	$f_name = $row["f_name"];
	$tea_comment = $row["tea_comment"];
	$tea_grade = $row["tea_grade"];
	$stud_num = $row["stud_num"];
	$memo = $row["memo"];	
	$stud_id = $row["stud_id"];
	$cool = $row["cool"];
	$exam_source_isopen =$row["exam_source_isopen"]; 
	
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
	$pp = $temp[count($temp)-1];
	//����
	if (chop($memo) != "")
		$memo=" alt=\"$memo\" ";
	
	if ($tea_grade == 0 && $session_log_id=="")
		$tea_grade ="&nbsp;";
	if ($tea_comment == "" && $session_log_id=="")
		$tea_comment ="&nbsp;";
	if(substr($stud_id,0,4) != "demo" )
	 	$stud_name_temp = "$stud_num �� -- $stud_name";
	 else
	 	$stud_name_temp = "�Юv�ܽd";
	//�ϥ�
	if ($cool == "1")
		$cool_img ="<img src=\"images/cool.gif\">";
	else
		$cool_img = "";
		
	//  �޲z�� 	
	if ($session_log_id == $teach_id){
		if ($cool == "1")
			$set_cool = "<a href=\"$PHP_SELF?cool=0&exam_id=$exam_id&stud_id=$stud_id\"><font color=red>Uncool</font></a>";
		else
			$set_cool = "<a href=\"$PHP_SELF?cool=1&exam_id=$exam_id&stud_id=$stud_id\"><font size=+2><i>c</i></font>ool</a>";	              
	}
	
	echo "<tr><td  align=center>$set_cool $cool_img $stud_name_temp </td>";
	echo "<td  align=center valign=middle>";
	//���Y�ɳB�z
	if ( $pp== "zip" ) {
		echo "<a href=\"".$uplaod_url."/e_".$exam_id."/".$stud_id."/ \" >�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >";
	}
	else { 
		echo "<a href=\"".$uplaod_url."/e_".$exam_id."/".$stud_id."_".$f_name."\" >�i��</a>&nbsp;<img src=\"images/memo.gif\" border=0 $memo >"; 
		//name �ݥ[�J�ǥͥN��
		if ($session_log_id == $teach_id){
			echo "<td><input type=text size=30 name=tea_comment_".$stud_id." value=\"$tea_comment\"></td>";
			echo "<td align=center><input type=text size=8 name=tea_grade_".$stud_id." value=\"$tea_grade\" > $temp_score</td>";
		}
		else {
			if(substr($stud_id,0,4) == "demo" ) //�Юv
				echo "<td colspan=2>&nbsp;</td>";
			else {				
				echo "<td >$tea_comment</td>";
				if ($is_scroe_img) //��ܵ���(�b exam_config.php ���]�w)
					echo "<td align=\"center\">$temp_score</td>"; 
				else
					echo "<td align=\"center\">$tea_grade</td>"; 
			}
		}
	
		if($exam_source_isopen =="1" && (($pp== "php" )|| ($pp == "php3"))) {
			echo "&nbsp;�U&nbsp;<a href=\"".$uplaod_url."/e_".$exam_id."/".$stud_id."_".$temp[0].".phps\">�d�ݭ�l��</a>";
		}

	}

	echo"</td></tr>";
};

if ($session_log_id == $teach_id){
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
