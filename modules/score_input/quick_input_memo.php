<?php
// $Id: quick_input_memo.php 7710 2013-10-23 12:40:27Z smallduh $
/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_studclass.php";

//�ޤJ���
//include "./myfun2.php";

//������
$col_num = 3;
$signBtn = "�n�����y";
$temp_path = $UPLOAD_PATH.$path_str;

//�ϥΪ̻{��
sfs_check();


$teacher_course= ($_GET['teacher_course']!="")?$_GET['teacher_course']:$_POST['teacher_course'];
$ss_id=($_GET['ss_id']!="")?$_GET['ss_id']:$_POST['ss_id'];
$seme_year_seme =($_GET['seme_year_seme']!="")?$_GET['seme_year_seme']:$_POST['seme_year_seme'];
$class_id = ($_GET['class_id']!="")?$_GET['class_id']:$_POST['class_id'];
/***************************************************************************************/
//  �Nteacher_id �ন teacher_sn �A�T�w�Ѯv�����Z������ƪ�A
    $teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
	$teacher_sn=$_SESSION['session_tea_sn'];
//    $sql="select teacher_sn from teacher_base where teach_id=$teacher_id";
//    $rs=$CONN->Execute($sql);
//    $teacher_sn = $rs->fields["teacher_sn"];
 
/***************************************************************************************/


if($_POST[save_memo] =="y") {
	
	switch($_POST[save_type]){
		case "input":
				//�s�J��Ʈw 
				$sss_id_temp_arr = explode(",",$_POST[sss_id_hidden]);
				$error = false;
				
				while(list($id,$sn)=each($sss_id_temp_arr)) {
					
					if($sn){
					//�p�G�S����J�N��,����s���y
						
						if($_POST["m_$sn"]!=""){
							$comment="";
							$m_id = explode(";",$_POST["m_$sn"]);
							for($i=0;$i<count($m_id);$i++){
								$t_comment = addslashes(trans_id_to_memo($m_id[$i]));
								
								if(!$t_comment){
									$msg .= "�s��".($id+1).":�S��".$m_id[$i]."�o�ӥN�������y<br>";
									$error = true;
									continue;
								}
								$comment .= $t_comment."�A";
							}
							$comment = substr($comment,0,-2);
							$query = "update  stud_seme_score set ss_score_memo='".$comment."' where sss_id=$sn";
							$CONN->Execute($query) or die($query);
						}	
					}
				}
				
				break;
		case "import":
				echo "�B�z��!!!!<br>";
				
				//�ˬd�ɦW�O�_�۲�
				$filename=$seme_year_seme."_".$class_id."_".$ss_id."_"."memo.csv";
				if (strcmp($filename,$_FILES['upload_file']['name'])!= 0){
					echo "�פJ�ɦW���~ !! ,�Ч�M $filename �ɦW�פJ!!";
					exit;
				}				
				$temp_file= $temp_path."memo.csv";	
				
				copy($_FILES['upload_file']['tmp_name'] , $temp_file);	
				$fd = fopen($temp_file,"r");
				//���X�ӯZ�ǥ�student_sn��J�}�C
				$sql="select student_sn from stud_base where curr_class_num like '$class_id%'and stud_study_cond='0'";
				$rs=$CONN->Execute($sql);
				$all_stud_sn = array();
				while (!$rs->EOF) {
					$all_stud_sn[]=$rs->fields[student_sn];
					$rs->MoveNext();
				}
				$j =0;
				$error = false;
				while($ck_tt = sfs_fgetcsv($fd, 2000, ",")) {
					if ($j++ == 0) //�Ĥ@�������Y�A���ˬd
                    				continue ;
                			
					if (substr($ck_tt[0],0,1)==0)
						$student_sn= substr($ck_tt[0],1);
					else
						$student_sn= trim($ck_tt[0]);
										
					if(!in_array($ck_tt[0],$all_stud_sn)){
						$msg .= "�y��".$ck_tt[2]."���ǥͬy����".$student_sn."����!!<br>";
						$error = true;
						continue;
					}
					$comment="";	
					//�����y��Ƥ~�B�z	
					if($ck_tt[4]){
						//�p�G�O�N�X,���ഫ���
						if($_POST[m_type]=="digit"){
							$m_id = explode(";",$ck_tt[4]);	
							for($i=0;$i<count($m_id);$i++){
								$t_comment = addslashes(trans_id_to_memo($m_id[$i]));
									
								if(!$t_comment){
									$msg .= "�y��".$ck_tt[2].":�S��".$m_id[$i]."�o�ӥN�������y<br>";
									$error = true;
									continue;							
									//exit;
								}
								$comment .= $t_comment."�A";	
							}
							$comment = substr($comment,0,-2);
						}
						else
							$comment = addslashes($ck_tt[4]);	
						$query = "update  stud_seme_score set ss_score_memo='".$comment."' where seme_year_seme = $seme_year_seme and ss_id=$ss_id and student_sn=$student_sn";
						$CONN->Execute($query) or die($query);
					}
					else{
						$msg .= "�y��".$ck_tt[2].":�S����J���y���<br>";
						$error = "true";
					}	
					$j++;
													    			
				}
				unlink($temp_file);
				break;	
		case "export":
   				$filename = $_POST[comm_length]."_".$_POST[level]."_memo.csv";
   				
   				$kind_sel="select kind_name from comment_kind where kind_serial = $_POST[comm_length] and (kind_teacher_id='0' or kind_teacher_id='$teacher_id')";
				$comm_kind=$CONN->Execute($kind_sel);
				
  				$level_sel="select level_serial,level_name  from comment_level where  level_teacher_id='0' or level_teacher_id='$teacher_id'";
  				//echo $level_sel;
				$comm_level=$CONN->Execute($level_sel);
				$level_array=array();
				while(!$comm_level->EOF){
					$level_array[$comm_level->fields[level_serial]]=$comm_level->fields[level_name];
					$comm_level->MoveNext();				
				}
   				if($_POST[level]=="all")
   					$what_level="";
   				else 	$what_level = "and level='$_POST[level]'";
   				$sel="select serial,level,comm from comment where kind='$_POST[comm_length]' $what_level and (teacher_id='0' or teacher_id='$teacher_id') order by level,serial";
				$comm_text=$CONN->Execute($sel);
				$str = "�Ǹ�,����,����,���y\n";
				while(!$comm_text->EOF){
					$str .= $comm_text->fields[serial].",".$comm_kind->fields[kind_name].",".$level_array[$comm_text->fields[level]].",".$comm_text->fields[comm]."\n";
					$comm_text->MoveNext();
				}
   				
    				header("Content-disposition: filename=$filename");
    				header("Content-type: application/octetstream ; Charset=Big5");
    				//header("Pragma: no-cache");
    								//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
				header("Expires: 0");				
				echo $str;
				exit;
				break;
		case "import_com":
	
				$temp_file= $temp_path."_comment.csv";	
				copy($_FILES['upload_file']['tmp_name'] , $temp_file);	
				$fd = fopen($temp_file,"r");
				$j =0;
				if($_POST[share]=="ON") $t_id ="0";
				else $t_id = $teacher_id;
				while($ck_tt = sfs_fgetcsv($fd, 2000, ",")) {
					if ($j++ == 0) //�Ĥ@�������Y�A���ˬd
                    				continue ;
					//����Ƥ~�B�z	
					if($ck_tt[0]){
						$comm = addslashes($ck_tt[0]);
						$query = "INSERT INTO `comment`(`teacher_id`,`subject`,`property`,`kind`,`level`,`comm`) VALUES ('$_POST[t_id]','','','$_POST[comm_length]', '$_POST[level]', '$comm')";
						$CONN->Execute($query) or die($query);
					}	
					$j++;
				}
				unlink($temp_file);
				break;			
	}
	echo "<html><body>
	<script LANGUAGE=\"JavaScript\">
	window.opener.document.myform.submit(); ";
	if(!$error)		
		echo "\n  alert('�@�~����!!');\n  window.close(); ";
		   
   	echo "</script>
	 $msg
	</body>
	</html>";
	exit;
}

switch ($_GET[act]){
	case "exportdata":
			make_import_file(1);
			break;
	case "makefile":
			make_import_file(0);
			break;
	case "importfile":
			show_head("�פJ�y�z��r�ɮ�");
			import_csv();
			break;
	case "exportfile":
			show_head("�ץX�y�z��r�N�������ɮ�");
			export_memo();
			break;	
	case "import_comment":
			show_head("�פJ���y");
			import_comm();	
			break;					
	default:
			show_head("��J�y�z��r�N��");
			main();
			break;
}	


function main(){
	global $CONN,$teacher_id,$seme_year_seme,$class_id,$ss_id,$col_num,$signBtn,$teacher_course;
$html="	
<table border=\"0\" bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"3\">
<tr bgcolor=\"white\">
<td valign='top'>
<form name=\"myform1\" action=".$_SERVER['PHP_SELF']." method=\"post\">";

if(strstr ($teacher_course, 'g')){
	$group_arr=explode("g",$teacher_course);
	//$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);
	$ss_id=$group_arr[1];
	$sql="select student_sn from elective_stu where group_id='{$group_arr[0]}' ";
	$rs=$CONN->Execute($sql) or trigger_error($sql,256);
	while(!$rs->EOF){
		$student_sn_arr[]=$rs->fields['student_sn'];
		$rs->MoveNext();
	}
	$student_sn_str=implode(",",$student_sn_arr);
	$query="
	select a.sss_id , a.student_sn,a.ss_score_memo,b.stud_id,b.stud_name,b.curr_class_num
	from stud_seme_score a ,stud_base b
	where a.student_sn in( $student_sn_str )
	and b.student_sn in( $student_sn_str )
	and a.student_sn=b.student_sn
	and a.ss_id ='$ss_id'
	and a.seme_year_seme='$seme_year_seme'
	and b.stud_study_cond=0
	order by b.curr_class_num ";
}else{
	$query = "select a.sss_id , a.student_sn,a.ss_score_memo,b.stud_id,b.stud_name,b.curr_class_num from stud_seme_score a ,stud_base b where a.student_sn=b.student_sn and a.ss_id ='$ss_id' and a.seme_year_seme='$seme_year_seme' and b.curr_class_num like '$class_id%' and b.stud_study_cond=0 order by b.curr_class_num ";
}

$res= $CONN->Execute($query) or trigger_error($query);
	$is_has_data = $res->RecordCount();

	$html .="<table border=0 bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"3\" >\n";
	$ii =0;
	$sss_id_hidden ="";
	while (!$res->EOF){

		$sn = $res->fields[student_sn];		
		$sit_num = substr($res->fields[curr_class_num],-2);
		$stud_name = $res->fields[stud_name];
		$sss_id = $res->fields[sss_id];

		if($ii % $col_num == 0)
			$html .= "<tr bgcolor='white'>";
		$html .= "<td>$sit_num</td>\n";
		if($res->fields[ss_score_memo])  $html .= "<td nowrap bgcolor=\"#C4D9FF\">$stud_name</td>\n";
			else 	$html .= "<td nowrap bgcolor=\"#FED3DB\">$stud_name</td>\n";
		$html .= "<td><input type=\"text\" name=\"m_$sss_id\" size=6  value=\"\" onFocus=\"set_ower(this,$ii)\" onBlur=\"unset_ower(this)\"></td>\n";
		
		if($ii++ % $col_num == ($col_num-1))
			$html .= "</tr>\n";
		$sss_id_hidden .= "$sss_id,";
		$res->MoveNext();
	}
	
	if(($ii%$col_num)!=0){
		$html .= "<td colspan=\"".(3*($col_num-($ii%$col_num1)))."\"></td>"; 
		$html .= "</tr>\n";
	}		
	$html .= "</table>
<input type=\"button\" name=\"do_key\" value=".$signBtn." onClick=\"document.myform1.submit()\">
&nbsp;&nbsp;<input type=\"button\" name=\"go_away\" value=\"���\" onClick=\"check_change()\">
&nbsp;&nbsp;<input type=\"button\" name=\"reset_allBtn\" value=\"�M��\" onClick=\"reset_all()\">

<input type=\"hidden\" name=\"ss_id\" value=\"".$ss_id."\">
<input type=\"hidden\" name=\"class_id\" value=\"".$class_id."\">
<input type=\"hidden\" name=\"sss_id_hidden\" value=\"".$sss_id_hidden."\">
<input type=\"hidden\" name=\"save_memo\" value=\"y\">
<input type=\"hidden\" name=\"save_type\" value=\"input\">
</form>
</td>
<td valign=\"top\">�ϥλ����G
<li>�w�g���y�z��r��ƾǥͩm�W�I���C�⬰<span style=\"background-color: #C4D9FF\">�Ŧ�</span>�A�|������ƾǥͩm�W�I����<span style=\"background-color: #FED3DB\">����</span>�C</li>
<li>�p�G�S����J��ơA�h��Ƥ��|��s�C</li> 
<li>�n������y�A�ШϥΤ���(;)���j�A�Ҧp:56;12�C</li> 
</td>
</table>
<script >
var ss=0;
var is_change = false;
function set_default(){
document.myform1.elements[ss].focus();
}

function check_change(){
if(is_change){
	if (confirm('�z�w�g����ƬO�_�n���} ?'))
		window.close();
}
else
	window.close();
}


function set_ower(thetext,ower) {
ss=ower;
thetext.style.background = '#FFFF00';
//thetext.select();
return true;
}

function unset_ower(thetext) {
thetext.style.background = '#FFFFFF';
return true;
}

function reset_all() {
	for (var i=0;i<document.myform1.elements.length;i++)
	 {
	    var e = document.myform1.elements[i];
	    if (e.type == 'text')
        	       e.value = '';
	}
  document.myform1.elements[0].focus();
}

// handle keyboard events
if (navigator.appName == \"Mozilla\")
   document.addEventListener(\"keyup\",keypress,true);
else if (navigator.appName == \"Netscape\")
   document.captureEvents(Event.KEYPRESS);

if (navigator.appName != \"Mozilla\")
    document.onkeypress=keypress;

function keypress(e) {
	
   if (navigator.appName == \"Microsoft Internet Explorer\")
      tmp = window.event.keyCode;
   else if (navigator.appName == \"Navigator\")
	tmp = e.which;
   else if (navigator.appName == \"Navigator\"||navigator.appName == \"Netscape\")
       tmp = e.keyCode;
  if( document.myform1.elements[ss].type != 'text')
		return true;
        else if (tmp == 13){ 
		var tt = parseFloat(document.myform1.elements[ss].value);
		if (isNaN(tt)){			
			alert('���~���N��!');
			document.myform1.elements[ss].value ='';
			return false;
		}
		else{
			ss++;
			document.myform1.elements[ss].focus();
			is_change = true;
			return true;
		}	
		
	}
        else    return true;
}
</script>
</body>
</html>";
	echo $html;
	

}
//���o���y���e
function trans_id_to_memo($id){
	global $CONN,$teacher_id;
	$sql = "SELECT comm FROM comment WHERE serial='$id' and (teacher_id='0' or teacher_id='$teacher_id')";

	$rs=$CONN->Execute($sql);
	$comm = $rs->fields['comm'];
	return $comm;	
	
}

//�פJ�ɮ�
function import_csv(){
	global $seme_year_seme,$class_id,$ss_id;;
$html="	
  <table border=\"0\" width=\"92%\" bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
      <td width=\"50%\" bgcolor=\"#C4D9FF\">
       <form method=\"POST\" action=\"".$_SERVER[PHP_SELF]."\" enctype=\"multipart/form-data\" name=\"myform1\">
       		<font size=2>�Ы��y�s���z��ܶפJ�ɮרӷ��G</font><br><input type=file name='upload_file'><br>
       		<font size=2>�п�ܶפJ�ɮ׵��y�����G</font><br>
       		<input type=\"radio\" value=\"digit\" name=\"m_type\">�N�X
       		<input type=\"radio\" value=\"word\" name=\"m_type\">��r���e
       		
          <p>
          <input type=\"submit\" value=\"�פJ�ɮ�\" name=\"B1\" onClick=\"return checkok();\"></p>
	<input type=\"hidden\" name=\"ss_id\" value=\"".$ss_id."\">
	<input type=\"hidden\" name=\"class_id\" value=\"".$class_id."\">
	<input type=\"hidden\" name=\"seme_year_seme\" value=\"".$seme_year_seme."\">
	<input type=\"hidden\" name=\"save_memo\" value=\"y\">
	<input type=\"hidden\" name=\"save_type\" value=\"import\">
        </form>
        <p>�@</td>
        <td bgcolor=\"#FFFFFF\" valign=\"top\">
        <b>�ϥλ����G</b>
        <li>�פJ�ɮסA�Ш̷ӻs�@�X���ɮ׿�J�A�Ĥ@�C�����W�١A���|�Q�B�z�C</li>
        <li>�n������y�A�ШϥΤ���(;)���j�A�Ҧp:56;12�C</li> 
        <li>�פJ�ɮ������A�i�H����r���y�μƦr�N�X�A�b�פJ�ɭn��ܥ��T�����C</li>
        </td>
    </tr>
  </table>
<script language=\"JavaScript\">  
function set_default(){
}
function checkok() {
	if (document.myform1.upload_file.value=='') {
		  alert('��������ɮ�');
		  return false;
	}	
	if (!(document.myform1.m_type[0].checked ||document.myform1.m_type[1].checked )) {
		  alert('��������ɮפ����y����');
		  return false;
	}		
}
//-->
</script>  
";
      
 echo $html;	
	
}
//�s�@�פJ��
function make_import_file($mode=0){
	global $CONN,$seme_year_seme,$class_id,$ss_id,$teacher_course;

	$filename=$seme_year_seme."_".$class_id."_".$ss_id."_memo.csv";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	$str="�ǥͬy����,�ǥ;Ǹ�,�y��,�m�W,���y";
	if ($mode==0) $str.="�ε��y�N�X";
	$str.="\n";

	if(strstr($teacher_course,"g")){
		$group_arr=explode("g",$teacher_course);
		$ss_id=$group_arr[1];
		$sql="select student_sn from elective_stu where group_id='{$group_arr[0]}' ";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		while(!$rs->EOF){
			$student_sn_arr[]=$rs->fields['student_sn'];
			$rs->MoveNext();
		}
		$student_sn_str=implode(",",$student_sn_arr);
		$query="
			select a.sss_id,a.student_sn,a.ss_score_memo,b.stud_id,b.stud_name,b.curr_class_num
			from stud_seme_score a ,stud_base b
			where a.student_sn in( $student_sn_str )
			and b.student_sn in( $student_sn_str )
			and a.student_sn=b.student_sn
			and a.ss_id='$ss_id'
			and a.seme_year_seme='".$seme_year_seme."'
			and b.stud_study_cond=0
			order by b.curr_class_num ";
	}else{
		$query = "select a.sss_id,a.student_sn,a.ss_score_memo,b.stud_id,b.stud_name,b.curr_class_num from stud_seme_score a,stud_base b where a.student_sn=b.student_sn and a.ss_id='$ss_id' and a.seme_year_seme='$seme_year_seme' and b.curr_class_num like '".$class_id."%' and b.stud_study_cond=0 order by b.curr_class_num";
	}
	$res= $CONN->Execute($query) or trigger_error($query);
	while(!$res->EOF){
		$sit_num = substr($res->fields[curr_class_num],-2);
		$memo=($mode==0)?"":$res->fields[ss_score_memo];
		$str.= $res->fields[student_sn].",".$res->fields[stud_id].",".$sit_num.",\"".$res->fields[stud_name]."\",\"".$memo."\"\n";
		$res->MoveNext();
	}
	echo $str;
	exit;
}
//�ץX���y��
function export_memo(){
	global $CONN,$teacher_id;

	$sel="select * from comment_kind where kind_teacher_id='0' or kind_teacher_id='$teacher_id'";
	$comm_len=$CONN->Execute($sel);
	while(!$comm_len->EOF){
		$tmp_value=$comm_len->fields[0];
		$tmp_name=$comm_len->fields[2];
		$selected=($comm_length==$tmp_value)?"selected":"";
		$len.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_kind=$tmp_name;
		$comm_len->MoveNext();
	}
	$comm_length_select="���O�G<select name='comm_length'>
				<option value=''>������O</option>$len</select>\n";
	
	$sel="select * from comment_level where level_teacher_id='0' or level_teacher_id='$teacher_id'";
	$comm_lev=$CONN->Execute($sel);
	while(!$comm_lev->EOF){
		$tmp_value=$comm_lev->fields[0];
		$tmp_name=$comm_lev->fields[2];
		$selected=($level==$tmp_value)?"selected":"";
		$select.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_level=$tmp_name;
		$comm_lev->MoveNext();
	}
	$level_select="���šG<select name='level'>
			<option value=''>��ܵ���</option>$select
			<option value='all'>����</option>
			</select>\n";
	
	
echo "
<table cellSpacing=\"1\" cellPadding=\"4\" width=\"100%\" bgColor=\"#1e3b89\">
  <tbody>
    <tr bgColor=\"#e1ecff\">
      <td width=\"50%\">
        <form name=\"myform1\" action=\"".$_SERVER[PHP_SELF]."\" method=\"post\">
        ".$comm_length_select.$level_select."
        
       </td> 
       <td rowspan=\"2\" valign=\"top\" bgColor=\"#ffffff\">
        <b>�ϥλ����G</b>
        <li>�Юv�u��ϥΦ@�P���Φۤv�إߪ����y�D</li>
        </td>
     </tr>
     <tr bgColor=\"#ffffff\">
       <td><input type=\"submit\" value=\"�ץX�N��������\" name=\"send_comm_back\" onClick=\"return checkok();\" >
       <input type=\"hidden\" name=\"save_memo\" value=\"y\">
	<input type=\"hidden\" name=\"save_type\" value=\"export\">
       </td>
    </tr>
  </tbody>
</table>
<script language=\"JavaScript\">
function checkok() {
	if (document.myform1.comm_length.selectedIndex=='') {
		  alert('���O�������');
		  return false;
	}	
	if (document.myform1.level.selectedIndex=='') {
		  alert('���ť������');
		  return false;
	}		
}

function set_default(){
}
//-->
</script>		
</form>";

	
}
//
function show_head($msg){
	global $seme_year_seme,$class_id,$ss_id,$teacher_course;
echo "
<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\">
<head>
<title>".$msg."</title>
</head>
<body onLoad=\"set_default()\">
<table border=\"0\" width=\"90%\">
	<tr>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."\">��J�N��</a></font>
	</td>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=importfile"."\">�פJ���y�ɮ�</a></font>
	</td>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=makefile"."\">�s�@�פJ�ɮ�</a></font>
	</td>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=exportdata"."\">�ץX���y�ɮ�</a></font>
	</td>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=exportfile"."\">�ץX�N��������</a></font>
	</td>
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=import_comment"."\">�פJ���y</a></font>
	</td>	
	</tr>
</table>";	
}		
function import_comm(){
	global $CONN,$teacher_id;
	$t_id =$teacher_id;
	//�P�O�O�_���Ҳպ޲z��
	$man_flag = checkid($_SERVER[SCRIPT_FILENAME],1) ;

	if ($man_flag){
		$sel="select * from comment_kind where kind_teacher_id='0'";
		$t_id= "0";
	}	
	else	
		$sel="select * from comment_kind where kind_teacher_id='0' or kind_teacher_id='$teacher_id'";
	
	$comm_len=$CONN->Execute($sel);
	
	while(!$comm_len->EOF){
		$tmp_value=$comm_len->fields[0];
		$tmp_name=$comm_len->fields[2];
		$selected=($comm_length==$tmp_value)?"selected":"";
		$len.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_kind=$tmp_name;
		$comm_len->MoveNext();
	}
	$comm_length_select="<font size=2>���O�G</font><select name='comm_length'>
				<option value=''>������O</option>$len</select>\n";
	if ($man_flag)
		$sel="select * from comment_level where level_teacher_id='0'";
	else
		$sel="select * from comment_level where level_teacher_id='0' or level_teacher_id='$teacher_id'";
	$comm_lev=$CONN->Execute($sel);
	while(!$comm_lev->EOF){
		$tmp_value=$comm_lev->fields[0];
		$tmp_name=$comm_lev->fields[2];
		$selected=($level==$tmp_value)?"selected":"";
		$select.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_level=$tmp_name;
		$comm_lev->MoveNext();
	}
	$level_select="<font size=2>���šG</font><select name='level'>
			<option value=''>��ܵ���</option>$select
			</select><br>\n";
	
	
echo "
<table cellSpacing=\"1\" cellPadding=\"4\" width=\"100%\" bgColor=\"#1e3b89\">
  <tbody>
    <tr bgColor=\"#e1ecff\">
      <td width=\"50%\">
        <form name=\"myform1\" action=\"".$_SERVER[PHP_SELF]."\" method=\"post\" enctype=\"multipart/form-data\">
        
        ".$comm_length_select.$level_select.$show_share."
       <font size=2>�Ы��y�s���z��ܶפJ�ɮרӷ��G</font><br><input type=file name='upload_file'><br> 
       </td> 
       <td rowspan=\"2\" valign=\"top\" bgColor=\"#ffffff\">
        <b>�ϥλ����G</b>
        <li>���Ҳպ޲z�Юv�פJ�����y�����ձЮv�@�ΡD</li>
        <li>�@��Юv�פJ�����y�u��ۤv�ϥΡD</li>
        <li>�Ш̷����O�ε��Ť��O�פJ���y�D</li>
        <li>�ЧQ�� excel �Ψ�L�u����J���y�A�s�� csv �ɡA�ëO�d�Ĥ@�C���D�ɡA�p <a href=commentdemo.csv target=new>�d����</a></li>
        </td>
     </tr>
     <tr bgColor=\"#ffffff\">
       <td><input type=\"submit\" value=\"�פJ���y\" name=\"send_comm_back\" onClick=\"return checkok();\" >
        <input type=\"hidden\" name=\"save_memo\" value=\"y\">
	<input type=\"hidden\" name=\"save_type\" value=\"import_com\">
	<input type=\"hidden\" name=\"t_id\" value=\"$t_id\">
       </td>
    </tr>
  </tbody>
</table>
<script language=\"JavaScript\">
function checkok() {
	if (document.myform1.comm_length.selectedIndex=='') {
		  alert('���O�������');
		  return false;
	}	
	if (document.myform1.level.selectedIndex=='') {
		  alert('���ť������');
		  return false;
	}
	if (document.myform1.upload_file.value=='') {
		  alert('��������ɮ�');
		  return false;
	}				
}

function set_default(){
}
//-->
</script>		
</form>";
}
?>
