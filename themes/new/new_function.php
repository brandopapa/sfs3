<?php

// $Id: new_function.php 7856 2014-01-13 07:34:06Z brucelyc $

// logo ��
function print_logo_image($image,$title="") {
	global $SFS_PATH_HTML,$SFS_PATH;
	return "<img alt=\"$title\" src=\"$SFS_PATH_HTML".get_path($_SERVER['SCRIPT_FILENAME'])."/images/$image\">";
}

/***
�L�X�Ҳ�
$module[$i][msn] �{���N��
$module[$i][showname] �{���W��
$module[$i][isopen] �O�_�����ݻ{�ҵ{�� (1 �N��ܬO)
***/

//$col_num=>�ϥܤ����X��
function print_module($msn="",$index=0,$col_num=4) {
	global $SFS_PATH_HTML,$nocols,$SFS_PATH,$THEME_URL,$FOLDER,$THEME_COLOR;
	
	//���o�Ǯձ��v session ,hami 2003-3-25
	$session_prob = get_session_prot();

	//�Y�O�ثe�b�Ĥ@�h�A�h���n�q�X����ϥܿ��A�Y�O�j��Ĥ@�h�A�h�q�X����ϥܿ��
	if(!empty($msn) or empty($_SESSION['session_tea_name'])){
		
		//�p�G���O�b�����άO���n�J�A���o�Ӥ������U�Ҧ�[�Ұ�]�Ҳ� array
		$module = get_module($msn);

		//�q�X�����T��
		if ($index)	include "$SFS_PATH/include/open_all.php";
		
		//���e��
		$tw=$col_num*50;
		
		$main="<table width='$tw' align='center' border='0' cellpadding='10' cellspacing='0' class='small'>";
		
		$a=$col_num;

		//$m�����U�C�Ӥ@�ҲաA�O�}�C
		foreach($module as $m){
			//�Ҳսs��
			$pro_kind_id=$m[msn];
			//�Ҳդ���W��
			$pro_kind_name=$m['showname'];
			//�Ҳեؿ��W��
			$pro_dir_name=$m['dirname'];
			//�Ҳչ���
			$icon=($THEME_COLOR)?$THEME_COLOR."_new_icon.png":"new_icon.png";
			//��Ʈw�O�_�����ɬ���
			$icon=(empty($m['icon_image']))?$icon:$m['icon_image'];
			//�O�Ҳ��٬O����
			$kind=$m['kind'];
			//�����ɦW
			$home_index="";
			//�Ҳո��|
			$store_path="$SFS_PATH/modules";
			//�O�_�}��
			$pro_isopen=$m['isopen'];
		
			$tr=(($a%$col_num)==0)?"<tr>":"";
			$tr2=(($a%$col_num)==$col_num-1)?"</tr>\n":"";
			$pic=(empty($pro_dir_name))?$SFS_PATH_HTML."images/$icon":$SFS_PATH_HTML."modules/$pro_dir_name/images/$icon";
			$real_pic=(empty($pro_dir_name))?$SFS_PATH."/images/$icon":$SFS_PATH."/modules/$pro_dir_name/images/$icon";

			$show_pic=(is_file($real_pic) and file_exists($real_pic))?$pic:$THEME_URL."/images/no_icon.gif";

			$show_pic=($m['kind']=="����")?$THEME_URL."/images/".$FOLDER:$show_pic;
			$url=($kind=="�Ҳ�")?$SFS_PATH_HTML."modules/$pro_dir_name/":"$_SERVER[SCRIPT_NAME]?_Msn=$pro_kind_id";
			
			//���]���s���B�ϥ�
			if(!is_null($_SESSION[$session_prob][$pro_kind_id]) || $pro_isopen=='1') {
				if ($home_index=="none")$home_index="";
				$main.="
				$tr
				<td align='center' valign='top' nowrap>
				<a href=\"$url\">
				<img src=\"$show_pic\" border=0 alt=\"$pro_kind_name\">
				<br>$pro_kind_name</a></td>
				$tr2";
				$a++;
			}

		}
		$main.="</table></center>\n";
	}else{
		$main=&my_web();
	}
	echo $main;
}

//���o����Ҳճs��
function &get_big_module($col_num=4,$mode="") {
	global $SFS_PATH_HTML,$nocols,$SFS_PATH, $CONN,$THEME_URL,$THEME_URL,$FOLDER,$FOLDER_OPEN;
	
	//���o�Ǯձ��v session ,hami 2003-3-25
	$session_prob = get_session_prot();
	
	//�Y�O�ثe�b�Ĥ@�h�A�h���n�q�X����ϥܿ��
	if(empty($_SESSION['session_tea_name']))return;
	
	$close_pic="<img src='".$THEME_URL."/images/close.png' width=16 height=16 border=0>";

	$arr = array();
	
	//�O�p���Υ���j���
	if($mode=="small"){
		$main="<form name='p' method='post'>
		<td align='right' nowrap>
		�D�������G<select name='bm' class='small'  onChange=\"if(document.p.bm.value!='')change_link(document.p.bm.value)\">";
	}else{
		$main="<td valign='top' align='right' nowrap width='100'  bgcolor='#F7F7F7' >
		<a href='".$THEME_URL."/chang_mode.php?cmk=close_left_menu&v=1'>$close_pic</a>
		<table border='0' cellpadding='2' cellspacing='0' align='center'>
		";
	}
	
	$query = "select msn,showname,isopen,kind,icon_image from sfs_module where islive='1' and kind='����' and of_group='0' order by sort";
	$result = $CONN->Execute($query);
	$i =0 ;
	$home_index="index.php";
	while (list($pro_kind_id,$pro_kind_name,$pro_isopen,$kind,$icon) = $result->FetchRow()){
		//�p���
		if($mode=="small"){
			if(!is_null($_SESSION[$session_prob][$pro_kind_id]) || $pro_isopen) {
				if ($home_index=="none")	$home_index="";
				$selected=($_SERVER[REQUEST_URI]=="/index.php?_Msn=$pro_kind_id")?"selected":"";
				$main.="
				<option value='".$SFS_PATH_HTML."index.php?_Msn=$pro_kind_id' $selected>$pro_kind_name</option>
				";
			}		
		}else{
		//�j���
			$pic=(empty($pro_dir_name))?
			$SFS_PATH_HTML."images/$icon":
			$SFS_PATH_HTML."modules/$pro_dir_name/images/$icon";
		
			$real_pic=(empty($pro_dir_name))?$SFS_PATH."/images/$icon":$SFS_PATH."/modules/$pro_dir_name/images/$icon";

			$show_pic=(is_file($real_pic) and file_exists($real_pic))?$pic:$THEME_URL."/images/no_icon.png";
			$folder_pic=($pro_kind_id==$_GET[_Msn])?$FOLDER_OPEN:$FOLDER;
			$show_pic=($kind=="����")?$THEME_URL."/images/$folder_pic":$show_pic;

			if(!is_null($_SESSION[$session_prob][$pro_kind_id]) || $pro_isopen) {
				if ($home_index=="none")	$home_index="";
				$main.="
				<tr>
				<td align='center' valign='top' nowrap class='small'>
				<a href=\"".$SFS_PATH_HTML."index.php?_Msn=$pro_kind_id\">
				<img src=\"$show_pic\" border=0><br>$pro_kind_name</a></td>
				</tr>
				<tr>
				<td height=10></td>
				</tr>";
			}
			$a++;
		}
	}
	
	//�B�~�Ҳ�
	$main.=($mode=="small")?"<option value='".$SFS_PATH_HTML."index.php?_Msn=other'>�B�~�Ҳ�</option>":"
	<tr>
	<td align='center' valign='top' nowrap class='small'>
	<a href=\"".$SFS_PATH_HTML."index.php?_Msn=other\">	
	<img src=\"".$THEME_URL."/images/".(($FOLDER=="fc.gif")?"frc.png":"folder_red.png")."\" width=48 height=48 border=0><br>�B�~�Ҳ�</a></td>
	</tr>
	<tr>
	<td height=10></td>
	</tr>";
	
	$main.=($mode=="small")?"</select></td></form><td valign='center' nowrap><a href='".$THEME_URL."/chang_mode.php?cmk=close_left_menu&v=0'>$close_pic</a></td>":"</table></td>\n";
	return $main;
}


//�L�X���Y�s��
function &print_location() {
	global $SFS_PATH_HTML,$SFS_THEME,$CDCLOGIN,$HTTPS;
	//���o�s��
	
	if ($_SESSION['session_log_id']){
		$b=$_SESSION['session_tea_name'] . "�n�J�U<a href='".$SFS_PATH_HTML."login.php?logout=yes'><img src='".$SFS_PATH_HTML."themes/$SFS_THEME/images/exit.png' alt='' width='16' height='16' hspace='3' border='0' align='absmiddle'>�n�X</a>";
	}else{
		if ($HTTPS=="") $LOGINURL=$SFS_PATH_HTML;
		else $LOGINURL=$HTTPS;
		$b=($CDCLOGIN)?"<a href=\"$SFS_PATH_HTML"."login.php?cdc=1\">���ҵn�J</a> &nbsp; | &nbsp; <a href=\"$SFS_PATH_HTML"."login.php\">�@��n�J</a>":"<a href=\"$LOGINURL"."login.php\">�n�J�t��</a>";
	}

	$main[]=get_sfs_path($_REQUEST["_Msn"]);
	$main[]=$b;
	return $main;
}

//�L�X��� menu
function print_menu($menu,$link="",$page=0) {
	$main=&make_menu($menu,$link,$page);
	echo $main;
}

//�L�X��� menu
function &make_menu($menu,$link="",$page=0) {
	global $SFS_PATH_HTML,$SFS_THEME;

	if ($link !=""){
		$link ="?".$link;
	}
	$the_script  = substr (strrchr ($_SERVER[SCRIPT_NAME], "/"), 1);
	$button="";
	while (list($tid,$tname) = each($menu)) {
		if ($tid == $the_script ) {
			$button.="<td class='tab' bgcolor='#FFF158'>&nbsp;<a href=\"$tid"."$link\">$tname</a>&nbsp;</td>";
		}else{
			$button.="<td class='tab' bgcolor='#EFEFEF'>&nbsp;<a href=\"$tid"."$link\">$tname</a>&nbsp;</td>";
		}
	}
	$main="
	<table cellspacing=1 cellpadding=3><tr>
	$button
	</tr></table>
	";
	return $main;
}


//�ӤH�Ƥ���
function &my_web(){
	global $SFS_PATH_HTML,$nocols,$SFS_PATH, $CONN;
	include_once $SFS_PATH."/include/sfs_case_signpost.php";

	//�ˬd�t�γ]�w
	$chk_sys_setup=&chk_sys_setup();
	//���
	$p=get_main_prob("",1,"online_form");
	$sign_form=(!empty($p[msn]))?school_sign_form():"";
	//���i
	$p=($_SESSION['session_who']=="�Юv")?get_main_prob("",1,"new_board"):"";
	$all_post=(!empty($p[msn]))?showPost():"";
	//��ܤW���n�J�ɶ�
	$today=date("Y-m-d G:i:s",mktime (date("G"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	$tableName = "login_log";
	$teacher_sn = $_SESSION['session_tea_sn'];
	$Create_db="CREATE TABLE if not exists $tableName (
	   log_id int(10) unsigned NOT NULL  auto_increment,
	   teacher_sn smallint(6) unsigned NOT NULL  ,
	   login_time datetime NOT NULL default '0000-00-00 00:00:00' ,
	   PRIMARY KEY  (log_id))";
	mysql_query($Create_db);
	$result = mysql_query("select login_time from $tableName where teacher_sn = $teacher_sn");
	$recordSet = mysql_fetch_row($result);
	if ($recordSet != NULL) {
	list($login_time) = $recordSet;
	$result = mysql_query("update $tableName set login_time = '$today' where teacher_sn = $teacher_sn");
	$recordSet = mysql_fetch_row($result);
	} else {
	$login_time = $today;
	$sql_select = "insert into $tableName (teacher_sn,login_time) values ('$teacher_sn','$today')";
	$recordSet = $CONN->Execute($sql_select);
	}

	$main="	
	<p>".$_SESSION['session_tea_name']."�z�n�G�w��ϥξǰȨt��
	";
	if ($login_time==$today) {
	   $main.="</p>�z�O�Ĥ@���n�J���t��<br><br>";
	} else {
	   $main.="<font color=#000088><small>&nbsp;&nbsp;(�W���n�J�ɶ��G$login_time)</small></font></p>";
	}   
	$main.="	
	<table width='98%' align='center'>
	<tr><td valign='top'>$all_post<br>$sign_form</td>
	<td align='right' valign='top'>$chk_sys_setup</td></tr>
	</table>
	";
	
	return $main;
}


//�ֳt�s�����
function fast_link(){
	global $SFS_PATH_HTML,$THEME_URL,$CONN;
	//���o�Ǯձ��v session ,hami 2003-3-25
	$session_prob = get_session_prot();
	
	//���o�ثe�����Ҧb���Ҳեؿ��W��
	$SCRIPT_NAME=$_SERVER[SCRIPT_NAME];
	$SN=explode("/",$SCRIPT_NAME);
	$dirname=$SN[count($SN)-2];
	//���X�Ҳսs��
    $sql_select = "SELECT msn FROM sfs_module where dirname='$dirname'";
    $recordSet=$CONN->Execute($sql_select) or user_error("SQL�y�k���~�G $sql_select",256);
    list($msn)= $recordSet -> FetchRow();
			
	//���o�n�J�᪺�Ҳ��v��
	foreach ($_SESSION[$session_prob] as $pro_kind_id => $of_group) {
		//���o�Ҳո�T
		$prob=get_main_prob($pro_kind_id);
		if(empty($prob['islive']))continue;

		$sort=$prob['sort'];
		$blank=($prob['kind']=="����")?"�� ":"�@�E";

		//$selected=($_REQUEST[_Msn]==$prob['msn'])?"selected":"";
		
		if($_REQUEST[_Msn]==$prob['msn']){
			$selected="selected";
		}elseif(empty($_REQUEST[_Msn]) and $msn==$prob['msn']){
			$selected="selected";
		}else{
			$selected="";
		}
		$url=($prob['kind']=="����")?$SFS_PATH_HTML."index.php?_Msn=$prob[msn]":$SFS_PATH_HTML."modules/".$prob['dirname']."/index.php";

		//��ӤH�i�Ϊ��Ҳթ��}�C��
		$man_p[$of_group][$sort]="<option value='$url' $selected>".$blank.$prob[showname]."</option>\n";

		//�D�n�����}�C
		if(empty($of_group)){
			$main_prob[$sort]=$pro_kind_id;
		}
	}
	//�D�n�����Ƨ�
	ksort ($main_prob);
	reset ($main_prob);

	//�Ҳդ����Ƨ�
	ksort ($man_p);
	reset ($man_p);

	foreach ($main_prob as $main_pro_kind_order=>$main_pro_kind_id){
		//�D�n�Ҳ�
		$all_power.=$man_p[0][$main_pro_kind_order];
		ksort ($man_p[$main_pro_kind_id]);
		reset ($man_p[$main_pro_kind_id]);
		foreach ($man_p[$main_pro_kind_id] as $order=>$value){
			//���U�Ҳ�
			$all_power.=$value;
		}
	}

	$all_power="
	<table cellspacing='0' cellpadding='0' class='small'><tr>
	<form name='power' method='post'><td><font color='#FFFFFF'>�ֳt�s���G</font></td><td>
	<select name='fast_link' size='1' class='small' onChange=\"if(document.power.fast_link.value!='')change_link(document.power.fast_link.value)\">
	$all_power
	</select></td><td valign='center'><a href='".$THEME_URL."/chang_mode.php?cmk=close_fast_link&v=1'><img src='".$THEME_URL."/images/close.png' width=16 height=16 border=0></a></td>
	</form>
	</tr></table>
	";
	return $all_power;
}


//�t�Φ۰��ˬd
function &chk_sys_setup($sel_year="",$sel_seme=""){
	global $CONN,$SFS_PATH_HTML;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	$isroot=who_is_root();
	$id_sn=$_SESSION[session_tea_sn];
	if(empty($isroot[$id_sn][p_id]))return;
	
	
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

	$main="<table bgcolor='#F60A64' cellspacing=1 cellpadding=2>
	<tr><td align='center'><b><font color='#000000' size=2><font color='#FFF158'>$sel_year</font>�Ǧ~�ײ�<font color='#FFF158'>$sel_seme</font>�Ǵ�</font><br><font color='white' size=2>�t�γ]�w�۰��ˬd</font></b></td></tr>
	<tr bgcolor='#FFFFF'><td class='small'>";

	//�ˬd�Ǯհ򥻳]�w
	$sql_select = "SELECT count(*) FROM school_base WHERE sch_cname='�ն�ۥѳn���y��' or  sch_cname_s='�ն�ۥѳn���y��' or   sch_cname_ss='�ն�ۥѳn���y��'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($n)= $recordSet->FetchRow();
	if($n>0){
		$main.="�|���]�w�G�y<a href='".$SFS_PATH_HTML."modules/school_setup/'>�Ǯհ򥻳]�w</a>�z<br>";
	}

	//�ˬd�Z�ų]�w
	$sql_select = "SELECT count(*) FROM school_class WHERE year='$sel_year' and semester='$sel_seme' and enable='1'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($n1)= $recordSet->FetchRow();
	$main.=($n1>0)?"<a href='".$SFS_PATH_HTML."modules/every_year_setup/class_year_setup.php?act=view&sel_year=$sel_year&sel_seme=$sel_seme'>���զ@ $n1 �Z</a><br>":"�|���]�w�G�y<a href='".$SFS_PATH_HTML."modules/every_year_setup/class_year_setup.php?act=setup&sel_year=$sel_year&sel_seme=$sel_seme'>�Z�ų]�w</a>�z<br>";

	//�ˬd�Ҹճ]�w
	$sql_select = "SELECT setup_id FROM score_setup WHERE year='$sel_year' and semester='$sel_seme' and enable='1'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($setup_id)= $recordSet->FetchRow();
	$main.=(!empty($setup_id))?"<a href='".$SFS_PATH_HTML."modules/every_year_setup/score_setup.php'>�[�ݥ��Ǵ��Ҹճ]�w</a><br>":"�|���]�w�G�y<a href='".$SFS_PATH_HTML."modules/every_year_setup/score_setup.php?act=setup&sel_year=$sel_year&sel_seme=$sel_seme'>�Ҹճ]�w</a>�z<br>";

	//�ˬd�ҵ{�]�w
	$sql_select = "SELECT count(ss_id) FROM score_ss WHERE year='$sel_year' and semester='$sel_seme' and enable='1'";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	list($n2)= $recordSet->FetchRow();
	$main.=(!empty($n2))?"<a href='".$SFS_PATH_HTML."modules/every_year_setup/ss_setup.php?act=viewall&sel_year=$sel_year&sel_seme=$sel_seme'>�[�ݦU�~�Žҵ{�]�w</a><br>":"�|���]�w�G�y<a href='".$SFS_PATH_HTML."modules/every_year_setup/ss_setup.php'>�ҵ{�]�w</a>�z<br>";

	//�ˬd�Ҫ�]�w
	$n3=0;
	$sql_select = "SELECT class_id FROM score_course WHERE year='$sel_year' and semester='$sel_seme' group by class_id";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while(list($nn)= $recordSet->FetchRow()){
		$n3++;
	}


	if(empty($n3)){
		$main.="�|���]�w�G�y<a href='".$SFS_PATH_HTML."modules/every_year_setup/course_setup.php'>�Ҫ�]�w</a>�z<br>";
	}elseif($n1!=$n3){
		$main.="<a href='".$SFS_PATH_HTML."modules/every_year_setup/course_setup.php'>�Ҫ�����A��".$n3."�Z</a><br>";
	}else{
		$main.="<a href='".$SFS_PATH_HTML."modules/every_year_setup/course_setup.php'>�Ҫ�]�wOK</a><br>";
	}

	$main.="</td></tr></table>";

	return $main;
}
?>
