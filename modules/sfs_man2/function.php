<?php
// $Id: function.php 5480 2009-06-01 06:48:17Z brucelyc $

//�u����|�U���ؿ��}�C
function real_dir_array($dir){
	global $CONN,$SFS_PATH;

	if (!$dir) user_error("�S���ǤJdir�ѼơI���ˬd�I",256);

	$HIDDEN_DIR=non_display_path();
	$HIDDEN_DIR[]=".";
	$HIDDEN_DIR[]="..";
	if ($handle = opendir($dir)) {
		while (false != ($file = readdir($handle))) {
			if(in_array($file,$HIDDEN_DIR))continue;
			if(is_dir($dir."/".$file)){
				$real_dir[]=$file;
			}
		}

		closedir($handle);
	}
	return $real_dir;
}


//���o�¼Ҳջ�����
function get_auth_txt($module=""){
	global $SFS_PATH;
	$log="";
	$fpath_str = $SFS_PATH."/modules/".$module."/author.txt";
	if (is_file ($fpath_str)){
	$fd = fopen($fpath_str, "r");
		while ($buffer = fgets($fd, 4096)){
			$log.=$buffer."<BR>";
		}
		fclose($fd);
	}
	if(empty($log))$log="�L���󻡩��C";
	return $log;
}


//��X�Ҳժ�����
function get_of_group($curr_msn="",$name="of_group",$sel_group=0,$kind="�Ҳ�",$show_all=0){
	$option=get_msn_of_group($curr_msn,0,$sel_group,$show_all);
	if($kind == "����")
		$theData="<select name='$name'><option>����</option>$option</select>";
	else
		$theData="<select name='$name'>$option</select>";

	return $theData;
}

//�������j
function get_msn_of_group($curr_msn="",$group=0,$sel_group=0,$show_all=0){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$all=($show_all=='1')?"":"and msn<>'$curr_msn'";
	$sql_select="select msn,showname from sfs_module where kind='����' and of_group='$group' $all order by sort";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($msn,$showname)=$recordSet->FetchRow()){
		$name[$msn]=$showname;
		$module_name_arr[$msn] = $dirname;
	}

	if(empty($name) or sizeof($name)<=0)return;
	foreach($name as $msn=>$showname){
		$selected=($sel_group==$msn)?"selected":"";
		$module_name=get_module_path($group);
		$option.="<option value='$msn' $selected> $module_name / $showname</option>\n";
		$option.=get_msn_of_group($curr_msn,$msn,$sel_group,$show_all);
	}

	return $option;
}



//���o�Y�@���Ҳժ��W��
function get_module_name($msn){
	global $CONN;

	if (!$msn) user_error("�S���ǤJ�ҲեN�X�I���ˬd�I",256);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select="select showname from sfs_module where msn='$msn'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($showname)=$recordSet->FetchRow();
	return $showname;
}

//���v���
function power_set($curr_id_kind="",$name_1="id_kind",$name_2="id_sn",$name_3="is_admin",$MODULE_MAN,$MODULE_MAN_DESCRIPTION,$mode=0){
	$id_kind_array=array("�B��"=>"�B��","¾��"=>"¾��","�Юv"=>"�Юv","�Ǹ�"=>"�ǥ�","�a��"=>"�a��");
	
	//���v�Ҧ�
	$sel1 = new drop_select();
	$sel1->s_name = $name_1;
	$sel1->has_empty = true;
	$sel1->id = $curr_id_kind;
	$sel1->arr = $id_kind_array;
	$sel1->is_submit = true;
	$id_kind_sel=$sel1->get_select();
	if ($mode) return $id_kind_sel;
	
	if($curr_id_kind=="�B��"){
		$room=room_kind();
		$room[99]="�Ҧ��Юv";
		//�B��
		$sel1 = new drop_select();
		$sel1->s_name = "$name_2";
		$sel1->has_empty = true;
		$sel1->arr = $room;
		$select=$sel1->get_select();
	}elseif($curr_id_kind=="¾��"){
		//¾��
		$sel1 = new drop_select();
		$sel1->s_name = "$name_2";
		$sel1->has_empty = true;
		$sel1->arr = title_kind();
		$select=$sel1->get_select();
	}elseif($curr_id_kind=="�Юv"){
		$select=&select_teacher("$name_2");
	}elseif($curr_id_kind=="�Ǹ�"){
		$select="�]�ť����п�J�ǥͪ��Ǹ��^<br><input type='text' name='$name_2' size='6'>
		<input type='checkbox' name='$name_2' value='0' checked>���v���Ҧ��ǥ�";
	}elseif($curr_id_kind=="�a��"){
		$select="�]�ť����п�J�a�����y���s���^<br><input type='text' name='$name_2' size='6'>
		<input type='checkbox' name='$name_2' value='0' checked>���v���Ҧ��a��";
	}elseif(!empty($curr_id_kind)){
		$select="<input type='text' name='$name_2' size='8'>";
	}else{
		$select="";
	}
	
	//$root=(!empty($select) && $MODULE_MAN && $curr_id_kind=="�Юv")?"
	//prolin92-8-19�ק��e�i�H¾��
	$root=(!empty($select) && $MODULE_MAN && ($curr_id_kind=="�Юv" or $curr_id_kind=="¾��") )?"
        <select name='$name_3' size='1'>
        <option value='0' selected>�@���v��</option>
        <option value='1'>�޲z�v��</option>
        </select><br>�v������: $MODULE_MAN_DESCRIPTION<br>":"";
        $main="$id_kind_sel $select $root";

//	$root=(!empty($select))?"<input type='hidden' name='$name_3' value='0'>
//	":"";
	$main="$id_kind_sel $select $root";
	return $main;
}


//�P�w�ҲլO�_���зǼҲ�
function is_stand_module($dir,$dirname){
	if(file_exists($dir."/".$dirname."/module-cfg.php")){
		return true;
	}else{
		return  false;
	}
}

//���]�ϥΪ̪��A
function reset_user_state() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//��s�ثe�u�W�ϥΪ̪��A�����s���o���v�N��
	$CONN->Execute("update pro_user_state set pu_state=2 where pu_state=1") or user_error("�����s���ѡI",256);
	return ;
}

//�P�_�Y�@�������̫�@�ӱƧǽs��
function get_sort($of_group=0){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select="select max(sort) from sfs_module where of_group='$of_group'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($sort)=$recordSet->FetchRow();
	$sort+=1;
	return $sort;
}



//�ӼҲժ��W�@�h�s��
function get_up_path($curr_msn=0){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(empty($curr_msn))return "$_SERVER[PHP_SELF]";
	$sql_select="select of_group,showname from sfs_module where  msn='$curr_msn' order by sort";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($of_group,$showname)=$recordSet->FetchRow();
	$url="$_SERVER[PHP_SELF]?msn=$of_group";
	return $url;
}

//�Ҳո��|���h���|
function get_module_location($curr_msn=0,$home_name="����",$needlink=0){
    global $CONN,$SFS_PATH_HTML;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

        if(empty($curr_msn)){
                $m_name=($needlink)?"<a href='$_SERVER[PHP_SELF]'>$home_name</a>":$home_name;
                return $m_name;
        }
        $sql_select="select of_group,showname,kind from sfs_module where  msn='$curr_msn' order by sort";
        $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
        list($of_group,$showname,$kind)=$recordSet->FetchRow();
        $pre_path=get_module_location($of_group,$home_name,$needlink);
	if ($curr_msn == $_GET[msn])
        	$p.=($needlink)?$pre_path." / $showname":$pre_path."/ $showname";
	else
	        $p.=($needlink)?$pre_path." / <a href='$_SERVER[PHP_SELF]?msn=$curr_msn'>$showname</a>":$pre_path."/ $showname";

        return $p;
}

// �P�_�ӼҲլO�_�b pro_module �����e�U�ܼƱ���
function in_pro_module($dirname) {

	return get_sfs_module_set($dirname);
	/*
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if ($dirname) {
		$sql="select pm_id from pro_module where pm_name='$dirname'";
		$recordSet=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
		list($id)=$recordSet->FetchRow();
		if ($id) return true; else return false;
	}

	return false;
	*/
}
	
?>
