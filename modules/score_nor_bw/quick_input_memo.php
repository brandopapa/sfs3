<?php
// $Id: quick_input_memo.php 7701 2013-10-23 08:09:14Z smallduh $

// ���o�]�w��
include "config.php";

//�ϥΪ̻{��
sfs_check();

//������
$col_num = 3;
$signBtn = "�n�����y";
$temp_path = $UPLOAD_PATH.$path_str;

$seme_year_seme=($_GET['seme_year_seme'])?$_GET['seme_year_seme']:$_POST['seme_year_seme'];
$class_id=($_GET['class_id'])?$_GET['class_id']:$_POST['class_id'];

if($_POST[save_memo] =="y") {

	switch($_POST[save_type]){
		case "input":
				//�s�J��Ʈw 
				$sn_id_temp_arr = explode(",",$_POST[sn_id_hidden]);
				$error = false;
				
				while(list($id,$sn)=each($sn_id_temp_arr)) {
					
					if($sn){
					//�p�G�S����J�N��,����s���y
						
						if($_POST["m_$sn"]!=""){
							$comment="";
							$m_id = explode(";",$_POST["m_$sn"]);
							for($i=0;$i<count($m_id);$i++){
								$t_comment = addslashes(trans_id_to_memo($m_id[$i]));
							
								if(!$t_comment){
									$msg .= "�s��".($id+1).":�S��".$_POST["m_$sn"]."�o�ӥN�������y<br>";
									$error = true;
									continue;
									//exit;
								}
								$comment .= $t_comment."�A";	
							}
							$comment = substr($comment,0,-2);	
							$query = "update  stud_seme_score_nor set ss_score_memo='".$comment."' where student_sn =$sn and seme_year_seme =$seme_year_seme";
							$CONN->Execute($query) or die($query);
							
						}	
					}
				}
				
				break;
		case "import":
				echo "�B�z��!!!!<br>";
				
				//�ˬd�ɦW�O�_�۲�
				$filename=$seme_year_seme."_".$class_id."_nor_memo.csv";
				if (strcmp($filename,$_FILES['upload_file']['name'])!= 0){
					echo "�פJ�ɦW���~ !! ,�Ч�M $filename �ɦW�פJ!!";
					exit;
				}				
				$temp_file= $temp_path."nor_memo.csv";	
				
				copy($_FILES['upload_file']['tmp_name'] , $temp_file);	
				$fd = fopen($temp_file,"r");
				//���X�ӯZ�ǥ�student_sn��J�}�C
				$sql="select a.student_sn,a.seme_num  from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$class_id' and a.student_sn=b.student_sn and b.stud_study_cond=0 order by a.seme_num";

				$rs=$CONN->Execute($sql) or die($sql);
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
					
					//�����y��Ƥ~�B�z
					$comment="";		
					if($ck_tt[4]){
						//�p�G�O�N�X,���ഫ���
						if($_POST[m_type]=="digit"){
							$m_id = explode(";",$ck_tt[4]);	
							for($i=0;$i<count($m_id);$i++){
								$t_comment = addslashes(trans_id_to_memo($m_id[$i]));	
								
								if(!$t_comment){
									$msg .= "�y��".$ck_tt[2].":�S��".$ck_tt[4]."�o�ӥN�������y<br>";
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
						$query = "update  stud_seme_score_nor set ss_score_memo='".$comment."' where seme_year_seme = $seme_year_seme and student_sn=$student_sn";
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
		
	}
	if ($_POST[save_memo]) {
			$today=date("Y-m-d G:i:s",mktime (date("G"),date("i"),date("s"),date("m"),date("d"),date("Y")));
			$teacher_sn=$_SESSION['session_tea_sn'];
			$sel_year = intval(substr($seme_year_seme,0,3));
			$sel_seme = substr($seme_year_seme,3,1);
			$year = sprintf("%02d",substr($class_id,0,1));
			$sel_class_id = substr($seme_year_seme,0,3)."_".$sel_seme."_".$year."_".substr($class_id,1,2);
			$sql_update="select ccm_id from class_comment_admin where teacher_sn='$teacher_sn' and class_id='$sel_class_id' and sel_year='$sel_year' and sel_seme='$sel_seme'";
			$rs=$CONN->Execute($sql_update) or die($sql_update);
			$update_data=$rs->FetchRow();
			if (empty($update_data)) {
				$sql_update="insert into class_comment_admin (teacher_sn,class_id,sel_year,sel_seme,update_time,update_teacher_sn,sendmit) values ('$teacher_sn','$sel_class_id','$sel_year','$sel_seme','$today','$teacher_sn','1')";
			} else {
				$ccm_id=$rs->$update_data[ccm_id];
				$sendmit=($send_comment)?'0':'1';
				$sql_update="update class_comment_admin set update_time='$today',update_teacher_sn='$teacher_sn',sendmit='$sendmit' where ccm_id='$ccm_id'";
			}
			$CONN->Execute($sql_update) or die($sql_update);
	}
	echo "<html><body>
	<script LANGUAGE=\"JavaScript\">
	window.opener.document.form2.submit(); ";
	if(!$error)		
		echo "\n  alert('�@�~����!!');\n  window.close(); ";
		   
   	echo "</script>
	 $msg
	</body>
	</html>";
	exit;
}


switch ($_GET[act]){
	case "makefile":
			
			make_import_file();
			break;
	case "importfile":
			show_head("�פJ�y�z��r�ɮ�");
			import_csv();
			
			break;
	case "exportfile":
			show_head("�ץX�y�z��r�N�������ɮ�");
			export_memo();
			break;	
				
	default:
			show_head("��J�y�z��r�N��");
			main();
			break;
	
}	


function main(){
	global $CONN,$seme_year_seme,$class_id,$col_num,$signBtn;
$html="	
<table border=\"0\" bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"3\">
<tr bgcolor=\"white\">
<td>
<form name=\"myform1\" action=".$_SERVER['PHP_SELF']." method=\"post\">";
//�ˬdstud_seme_score_nor�O�_�w�g���ǥ͸��
	$sql="select a.student_sn,a.seme_num ,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$class_id' and a.student_sn=b.student_sn and b.stud_study_cond=0 order by a.seme_num";
	$rs=$CONN->Execute($sql) or die($sql);;
	$i=0;
	$stud_sn=array();
	while (!$rs->EOF) {
		$sn=$rs->fields["student_sn"];
		$stud_sn[]=$sn;
		$all_sn.=$sn.",";
		$st_name[$sn] = $rs->fields["stud_name"];
		$i++;
		$rs->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	$stud_numbers=$i;


$query = "select count(student_sn) as cc from stud_seme_score_nor where student_sn in ($all_sn) and seme_year_seme='$seme_year_seme'";
$res = $CONN->Execute($query);

if ($res->fields[0]<$stud_numbers) {
	
	for($j=0;$j<count($stud_sn);$j++){
		$sst = $stud_sn[$j];
		
		$sql="select student_sn from stud_seme_score_nor where student_sn='$sst'  and seme_year_seme='$seme_year_seme'";
		$rs=$CONN->Execute($sql);
		if (empty($rs->fields[student_sn])) {
			$query = "INSERT INTO stud_seme_score_nor(seme_year_seme,student_sn,ss_id,ss_score_memo)values('$seme_year_seme','$sst','0','')";
			$CONN->Execute($query);
		}
		$res->MoveNext();
	}
}

//�ˬd����

$query = "select a.student_sn,a.ss_score_memo,b.seme_num from stud_seme_score_nor a ,stud_seme  b where a.student_sn=b.student_sn and a.seme_year_seme='$seme_year_seme' and b.seme_year_seme='$seme_year_seme' and b.student_sn in ($all_sn) order by b.seme_num ";
$res= $CONN->Execute($query) or die($query);

	$html .="<table border=0 bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"3\">\n";
	$ii =0;
	$sn_id_hidden =""; 		
	while(!$res->EOF){

		$sn = $res->fields['student_sn'];		
		$sit_num = $res->fields['seme_num'];
		$stud_name = $st_name[$sn];

		if($ii % $col_num == 0)
			$html .= "<tr bgcolor='white'>";
		$html .= "<td>$sit_num</td>\n";
		if($res->fields[ss_score_memo])  $html .= "<td nowrap bgcolor=\"#C4D9FF\">$stud_name</td>\n";
			else 	$html .= "<td nowrap bgcolor=\"#FED3DB\">$stud_name</td>\n";
		$html .= "<td><input type=\"text\" name=\"m_$sn\" size=6 maxlength=10 value=\"\" onFocus=\"set_ower(this,$ii)\" onBlur=\"unset_ower(this)\"></td>\n";
		
		if($ii++ % $col_num == ($col_num-1))
			$html .= "</tr>\n";
		$sn_id_hidden .= "$sn,";
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
<input type=\"hidden\" name=\"seme_year_seme\" value=\"".$seme_year_seme."\">
<input type=\"hidden\" name=\"class_id\" value=\"".$class_id."\">
<input type=\"hidden\" name=\"sn_id_hidden\" value=\"".$sn_id_hidden."\">
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
function make_import_file(){
	global $CONN,$seme_year_seme,$class_id,$ss_id;	
	$query="select a.student_sn,a.seme_num ,b.stud_name ,b.stud_id from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$class_id' and a.student_sn=b.student_sn and b.stud_study_cond=0 order by a.seme_num";
	$res=$CONN->Execute($query) or die($query);;

   	$filename = $seme_year_seme."_".$class_id."_nor_memo.csv";
    	header("Content-disposition: filename=$filename");
    	header("Content-type: application/octetstream ; Charset=Big5");
    	//header("Pragma: no-cache");
    					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

    	header("Expires: 0");
    	$str = "�ǥͬy����,�ǥ;Ǹ�,�y��,�m�W,���y�ε��y�N�X\n";
	while(!$res->EOF){
		
		$str.= $res->fields[student_sn].",".$res->fields[stud_id].",".$res->fields[seme_num].",".$res->fields[stud_name].",\n";
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
	<td align=\"center\"><font size=2><a href=\"".$_SERVER['PHP_SELF']."?class_id=".$class_id."&teacher_course=".$teacher_course."&ss_id=".$ss_id."&seme_year_seme=".$seme_year_seme."&act=exportfile"."\">�ץX�N��������</a></font>
	</td>
	</tr>
</table>";	
}		
		
?>
