<?php
// $Id: paper_upload.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_REQUEST[year_seme])){
	$ys=explode("-",$_REQUEST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}else{
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�
}

/*
//���o���ЯZ�ťN��
$class_num=get_teach_class();
$class_all=class_num_2_all($class_num);
if(empty($class_num)){
	$act="error";
	$error_title="�L�Z�Žs��";
	$error_main="�䤣��z���Z�Žs���A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z�����и�ƿ�J�t�Τ��C
	</ol>";
}
*/

//�D���]�w
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

$act=$_REQUEST[act];


if($_REQUEST[chknext]){
	$ss_temp = "&chknext=$_REQUEST[chknext]&nav_next=$_REQUEST[nav_next]";
}

//$stud_id=$_REQUEST[stud_id];


//����ʧ@�P�_
if (isset($_POST[cmd])){
	printed_chk($sel_year,$sel_seme);
}
$main=&main_form($sel_year,$sel_seme,$_REQUEST[class_id],$stud_id);
/*
if($act=="save"){
	save_score_nor($sel_year,$sel_seme,$_REQUEST[student_sn],$_REQUEST[nor_score],$_REQUEST[nor_score_memo]);
	save_score_oth($sel_year,$sel_seme,$stud_id);
	header("location: {$_SERVER['PHP_SELF']}?sel_year=$sel_year&sel_seme=$sel_seme&class_id=$_REQUEST[class_id]&stud_id=$stud_id".$ss_temp);
}elseif($_REQUEST[error]==1){
	user_error("�ӯZ�ŵL�ǥ͸�ơA�L�k�~��C<ol>
	<li>�нT�{�z�����ЯZ�šC
	<li>�нT�{�аȳB�w�g�N�z���ǥ͸�ƿ�J�t�Τ��C
	<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php'>".$SFS_PATH_HTML."school_affairs/student_reg/create_data/mstudent2.php</a>)</ol>",256);
	}else{
	if($_REQUEST[chknext]){$stud_id=$_REQUEST[nav_next];}
	$main=&main_form($sel_year,$sel_seme,$_REQUEST[class_id],$stud_id);
}
*/

//�q�X����
head("�޲z�W�Ǧ��Z��");
?>


<script language="JavaScript">
<!-- Begin
function jumpMenu_seme(){
	location="<?php echo $_SERVER['PHP_SELF']?>?act=<?php echo $act;?>&year_seme=" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
}

function jumpMenu_seme_1(){
	location="<?php echo $_SERVER['PHP_SELF']?>?act=<?php echo $act;?>&year_seme=<?php echo $_REQUEST[year_seme]?>&class_id=" + document.myform.class_id.options[document.myform.class_id.selectedIndex].value;
}
//  End -->
</script>

<?php
echo $main;
foot();

function &main_form($sel_year,$sel_seme,$class_id,$stud_id){
	global $CONN,$performance_option,$school_menu_p,$performance,$SFS_PATH_HTML,$UPLOAD_URL;
	$seme_year_seme = sprintf("%d%d",$sel_year,$sel_seme);
	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");
	$order_by = (isset($_GET[query])) ? $_GET[query]:"class_num";
	$sort_type = (isset($_GET[sort])) ? $_GET[sort]:"";
	$sort_sw = ($sort_type=="ASC") ? "DESC" :"ASC";
	$sql = "select * from score_paper_upload where curr_seme = '$seme_year_seme' order by $order_by $sort_type";
	$seme_sort = ($order_by == "curr_seme") ? "&sort=".$sort_sw :"&sort=ASC";
	$class_sort = ($order_by == "class_num") ? "&sort=".$sort_sw :"&sort=ASC";
	$time_sort = ($order_by == "time") ? "&sort=".$sort_sw :"&sort=ASC";
	$printed_sort = ($order_by == "printed") ? "&sort=".$sort_sw :"&sort=ASC";

	//echo $sql;
	$paper_list = $CONN->Execute($sql);



	$tool_bar=&make_menu($school_menu_p);
    

	
	
	$main="
	$tool_bar
        <table bgcolor='#9EBCDD' cellspacing=0 cellpadding=4>
        <tr bgcolor='#FFFFFF'><td bgcolor='#BDD3FF' valign=top>
                <table>
                <form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
                <tr><td valign=top align=center>
                $date_select<br>
                $class_select<br>
                $stud_select
                </td></tr>
                </form>
                </table>
        </td><td valign=top>$stud_all</td></tr>
        </table>
        <script src='functions.js' type='text/javascript' language='javascript'></script>            
	<form method='post' action='$_SERVER[PHP_SELF]'>
	<table border='0' cellpadding='5'>
	<tr><th colspan='6'><input type='submit' name='cmd' value='��s�s�d����'></th></tr>
	<tr>
	    <th style='border: 1px solid #FFCC99'><a href='$_SERVER[PHP_SELF]?query=curr_seme$seme_sort'>�Ǵ�</a></th>
	    <th><a href='$_SERVER[PHP_SELF]?query=class_num$class_sort'>�Z�O</a></th>
	    <th>���Z��</th>
	    <th>�W�Ǫ�</th>
	    <th><a href='$_SERVER[PHP_SELF]?query=time$time_sort'>�W�Ǯɶ�</a></th>
	    <th><a href='$_SERVER[PHP_SELF]?query=printed$printed_sort'>�s�d����</a></th>
	</tr>
 	"; 
	while ($paper = $paper_list->FetchRow()){
		$spu_sn = $paper[spu_sn];
		$check = ($paper["printed"] == 1) ?"checked":" ";
		$main2="
		<tr  onmouseover=\"setPointer(this, 0, 'over', '#DDDDDD', '#CCFFCC', '#FFCC99');\" onmouseout=\"setPointer(this, 0, 'out', '#DDDDDD', '#CCFFCC', '#FFCC99');\" onmousedown=\"setPointer(this, 0, 'click', '#DDDDDD', '#CCFFCC', '#FFCC99');\">
		    <td valign='top' style='border: 1px solid #FFCC99' bgcolor='#DDDDDD'>$paper[curr_seme]</td>
		    <td valign='top'  bgcolor='#DDDDDD'>$paper[class_num]</td>
		    <td valign='top'  bgcolor='#DDDDDD'><a href='{$UPLOAD_URL}score_paper_upload/$paper[file_name]'>$paper[file_name]</a></td>
		    <td valign='top'  bgcolor='#DDDDDD'>$paper[log_id]</td>
		    <td valign='top'  bgcolor='#DDDDDD' nowrap='nowrap'>$paper[time]</td>
		    <td valign='top'  bgcolor='#DDDDDD'><input type='checkbox' name='printed_ckbox[$spu_sn]' value=1 $check></td>
		</tr>
		";
		$main.=$main2;
	}
	$main.="
	<tr><th colspan='6'><input type='submit' name='cmd' value='��s�s�d����'></th></tr>
	</table>
	</form>
	";
	return $main;
}


function printed_chk($sel_year,$sel_seme){
	global $CONN;
	$sql="update score_paper_upload set printed=0 where curr_seme='$sel_year$sel_seme'";
	$CONN->Execute($sql) or trigger_error("sql ���~ $sql",E_USER_ERROR);
//	print_r($_POST["printed_ckbox"]);
	if (isset($_POST["printed_ckbox"])){
		while (list($key, $val) = each($_POST["printed_ckbox"])) {
        //              echo "$key => $val\n";
			$sql= "update score_paper_upload set printed=$val where spu_sn=$key";
			$CONN->Execute($sql) or trigger_error("sql ���~ $sql",E_USER_ERROR);
		}
	}
}


?>
