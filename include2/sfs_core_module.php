<?php

// $Id: sfs_core_module.php 5999 2010-08-19 03:36:10Z brucelyc $

//���o�Ӥ����U���@�h���Ҧ��Ұʪ��ҲոԲӸ��
function get_module($msn="") {
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//�ˬd��Ʈw��s�{��
	include dirname(__FILE__)."/sfs_upgrade_list.php";

	$arr = array();

	//���o�ثe���|�U���Ҳ�
	if($msn=="other"){
		//���o��֦��v�����ҲջP����
		$all_power=get_prob_power($_SESSION['session_tea_sn'],$_SESSION['session_who']);
		$ok_power=array_keys($all_power);

		//���o�Ө������ϥΪ��j�M����
		$who_where=who_chk($_SESSION['session_tea_sn'],$_SESSION['session_who'] );

		//���o���v���ӨϥΪ̥i�ϥΪ������μҲ��v��
		$sql_select = "select pro_kind_id from pro_check_new where $who_where";
		$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);
		while(list($m)=$recordSet->FetchRow()){
			$where.="msn=$m or ";
		}

		// �W�������������
		if ($where) $where="of_group!=0 and (".substr($where,0,-4).")"; else return array();


	}else{
		$where=(empty($msn))?"kind='����' and of_group='0'":"of_group='$msn' order by sort";

	}

	$sql_select="select * from sfs_module where islive='1' and $where";

	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$i=0;
	while($m=$recordSet->FetchRow()){
		$ofgroup=$m[of_group];
		if(in_array($ofgroup,$ok_power)) continue;
		$arr[$i]= $m;
		$i++;
	}
	return $arr;
}

//�ˬd�ϥΪ̪��A
function check_user_state() {
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	//�t�X���ߺݪ�������,�O���Ǯ�ID by hami 2003-3-26
	$session_prob = get_session_prot();
	//�ˬd�ϥΪ̪��A
	$query = "select pu_state from pro_user_state where teacher_sn='{$_SESSION['session_tea_sn']}' and pu_state=2";
	$result = $CONN->Execute($query) or trigger_error("SQL ���~<Br>$query",E_USER_ERROR);
	if ($result->RecordCount() == 0) {
		//�R���W�L�@�ѰO��
		$CONN->Execute("delete from pro_user_state where now()-pu_time>1000000");
	}
	else {
		//���s���o�Ҳ�
		$_SESSION[$session_prob]=get_prob_power($_SESSION['session_tea_sn'],$_SESSION['session_who']);
		$query = "update pro_user_state set pu_state=1 where teacher_sn='{$_SESSION['session_tea_sn']}'";
		$CONN->Execute($query) or trigger_error($query,E_USER_ERROR);
	}
	return ;

}

//���o�Ҳո��
function get_main_prob($id="",$pro_islive="",$name=""){
    global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$and_pro_islive=($pro_islive==1)?"and islive=1":"";
	if(!empty($id)){
		$w="msn='$id'";
	}elseif(!empty($name)){
		$w="dirname='$name'";
	}else{
		return;
	}

	// init $main
	$main=array();

	$sql_select = "SELECT * FROM sfs_module where $w $and_pro_islive";
    // �n�ˬd�O�_Ū�����\?
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$main=$recordSet->FetchRow();
	return $main;
}

//���o�Y�Ҳթ��U�Ҳժ��s��
function get_parent_prob($id=""){
    global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select = "SELECT * FROM sfs_module where of_group='$id' order by sort";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$main=array();
	while($all=$recordSet->FetchRow()){
		$main[]=$all;
	}
	return $main;
}


// �Ҳճ]�w�ѷ� : ����Ҳճ]�w�� module-cfg.php
// �o�Ө禡�w�g�ǳƥh���F�A�ФŦA�ϥΡC�Ч�� get_module_setup()
function get_sfs_module_set($module_name='',$del=0) {
        global $CONN,$SFS_PATH;
        if ($module_name==''){
                $temp = get_store_path();
                $temp_arr = explode("/",$temp);
                $module_name=$temp_arr[count($temp_arr)-1];
        }
        $is_get_set = false;
        if ($del==1) { //�R���O��
                $query = "delete from pro_module_main where pm_name='$module_name'";
                $CONN->Execute($query);
                $query = "delete from pro_module where pm_name='$module_name'";
                $CONN->Execute($query);
                $is_get_set =true;
        }
        else {
                $query = "select b.pm_item,b.pm_value from pro_module_main a ,pro_module b where a.pm_name=b.pm_name and a.pm_name='$module_name'";
                $res = $CONN->Execute($query);
                //�w���w�]��
                if (!$res->EOF) {
                        while(!$res->EOF) {
                                $res_arr[$res->fields[0]] = $res->fields[1];
                                $res->MoveNext();
                        }
                        return $res_arr;
                }
                else
                        $is_get_set =true;
        }

	 //�[�J�w�]��
        if ($is_get_set) {
		$default_set = $SFS_PATH."/modules/".$module_name."/module-cfg.php";
		if (!file_exists($default_set))
			trigger_error("�䤣��w�]���ɮ� $default_set", E_USER_ERROR);
		require "$default_set";
		while(list($id,$arr) = each($SFS_MODULE_SETUP)) {
			$pm_item = trim($arr['var']);
			$pm_memo = addslashes(trim($arr['msg']));
			if (is_array($arr['value'])){
				$temp_value = array_keys($arr['value']);
				$pm_value = addslashes($temp_value[0]);
			}
			else
				$pm_value = addslashes(trim($arr['value']));
			$query = "insert into pro_module(pm_name,pm_item,pm_memo,pm_value) values('$module_name','$pm_item','$pm_memo','$pm_value')";
			$CONN->Execute($query);
		}
		//�R�����~���
		$CONN->Execute("delete from pro_module_main where pm_name=''");
		//�[�J pro_module_main ���
		$MODULE_PRO_KIND_NAME = addslashes($MODULE_PRO_KIND_NAME);
		if ($MODULE_UPDATE=="") $MODULE_UPDATE="0000-00-00";
		$query = "replace into pro_module_main(pm_name,m_display_name,m_ver,m_create_date) values('$module_name','$MODULE_PRO_KIND_NAME','$MODULE_UPDATE_VER','$MODULE_UPDATE')";
		$CONN->Execute($query) or trigger_error($query, E_USER_ERROR);

		$query = "select pm_item,pm_value from pro_module where pm_name='$module_name'";
		$res = $CONN->Execute($query);
		while(!$res->EOF) {
			$res_arr[$res->fields[0]] = $res->fields[1];
			$res->MoveNext();
		}
		return $res_arr;
	}

}


//���o�Ө������ϥΪ��j�M����
function who_chk($sn="",$who=""){
	global $CONN,$conID;
	if($who=="�Юv"){
		//�����o�ӱЮv�ݩ���ӳB�ǡB����¾��
		$sql_select = "select teach_title_id,post_office from teacher_post where teacher_sn='$sn'";
		$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);
		list($teach_title_id,$post_office) = $recordSet->FetchRow();

		$where="((id_kind='�Юv' and id_sn='$sn') or (id_kind='¾��' and id_sn='$teach_title_id') or (id_kind='�B��' and id_sn='$post_office') or (id_kind='�B��' and id_sn='99'))";
	}elseif($who=="�a��"){
		$where="(id_kind='��L' and id_sn='$sn') or (id_kind='��L' and id_sn='0')";
	}elseif($who=="�ǥ�"){
		$where="(id_kind='�Ǹ�' and id_sn='$sn') or (id_kind='�Ǹ�' and id_sn='0') ";
	}elseif($who=="��L"){
		$where="id_kind='��L' and id_sn='$sn'";
	}
	//$where .=" and (p_end_date is null or p_end_date >= now())";

	//�L��ɴ��@�k�A�ˬd�ǮլO�_����s�v����ƪ�A���[�W�v�������
	$fields = mysql_list_fields($mysql_db, "pro_check_new", $conID);
	$columns = mysql_num_fields($fields);
	$chk_end_date=false;
	for ($i = 0; $i < $columns; $i++) {
		if(mysql_field_name($fields, $i) =="p_end_date"){
			$chk_end_date=true;
		}
	}

	if($chk_end_date){$where .=" and (p_end_date is null or p_end_date >= now())";}

	return $where;
}


//���o�n�J�̥i�ϥΪ��Ҳ��v��
function get_prob_power($sn="",$who=""){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$msn_array=array();
	//���o�Ө������ϥΪ��j�M����
	$where=who_chk($sn,$who);
	//���o���v���ӨϥΪ̥i�ϥΪ������μҲ��v��
	$sql_select = "select pro_kind_id from pro_check_new where $where";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);


	// init $ok_prob
	$ok_prob=array();

	while(list($pro_kind_id) = $recordSet->FetchRow()){
		//$prob[$pro_kind_id]=$is_admin;

		//�ݦ�$pro_kind_id�O�ݩ�����٬O�Ҳ�
		$this_prob=get_main_prob($pro_kind_id);

		if($this_prob[kind]=="����"){
			//��X���U�Ҧ������H�μҲաA�H�K���v���L;
			$ok_prob_array=parent_prob_poser($pro_kind_id,$who,$sn);
			$ok_prob[$pro_kind_id]=$this_prob[of_group];
			foreach($ok_prob_array as $a=>$b){
				$ok_prob[$a]=$b;
			}
		}elseif($this_prob[kind]=="�Ҳ�"){
			//���p�O�ҲաA��ܸӼҲլO�B�~���v���ӨϥΪ̪�;
			$ok_prob[$pro_kind_id]=$this_prob[of_group];
		}
	}
	return $ok_prob;
}

//���o�Y�������U�Ҧ��ҲեH�Φ��������s��
function parent_prob_poser($pro_kind_id="",$who,$sn){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if (!$who) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	if (!$sn) user_error("�S���ǤJ�ѼơI���ˬd�C",256);

	$sql_select = "select msn, isopen,of_group,kind from sfs_module where of_group='$pro_kind_id'";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);

	// init $main
	$main=array();

	while(list($id,$isopen,$of_group,$kind) = $recordSet->FetchRow()){
		//�ӼҲժ��ϥΪ̬����]�w�C

		if($kind=="����"){
			//�ݬݸӤ������L���v�A�Y�S�B�~���v����~�ӤW�Ӥ������v���A�������N�O���\�ϥ�
			$have_power=check_kind_have_power($id);
			if(!$have_power){
				//�S���B�~���v���ܡA�]�N�Ӥ������v�A�é��U��
				$main[$id]=$of_group;
				$mainkind=parent_prob_poser($id,$who,$sn);
				foreach($mainkind as $a=>$b){
					$main[$a]=$b;
				}
			}
		}elseif($kind=="�Ҳ�"){
			$main[$id]=$of_group;
		}
	}
	return $main;
}

//�ݬݸӤ������L�B�~���v�A�Y�S�B�~���v��ܰO���W�Ӥ������v���A�������N�O���\�ϥ�
function check_kind_have_power($msn){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// �T�w���ǤJ�Ѽ�
	if (!$msn) user_error("�S���ǤJ�ѼơI���ˬd�C",256);

	//���o���v���ӨϥΪ̥i�ϥΪ������μҲ��v��
	$sql_select = "select pro_kind_id from pro_check_new where pro_kind_id=$msn";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);

	while(list($pro_kind_id) = $recordSet->FetchRow()){
		if($pro_kind_id) return true;
	}
	return false;
}

/*
//���o�n�J�̥i�ϥΪ��Ҳ��v��
function get_prob_power($sn="",$who=""){
	global $CONN;
	$msn_array=array();

	if($who=="�Юv"){
		//�����o�ӱЮv�ݩ���ӳB�ǡB����¾��
		$sql_select = "select teach_title_id,post_office from teacher_post where teacher_sn='$sn'";
		$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);
		list($teach_title_id,$post_office) = $recordSet->FetchRow();

		$where="((id_kind='�Юv' and id_sn='$sn') or (id_kind='¾��' and id_sn='$teach_title_id') or (id_kind='�B��' and id_sn='$post_office') or (id_kind='�B��' and id_sn='99'))";
		$kind_who="�Юv";
	}elseif($who=="�a��"){
		$where="(id_kind='��L' and id_sn='$sn') or (id_kind='��L' and id_sn='0')";
		$kind_who="��L";
	}elseif($who=="�ǥ�"){
		$where="id_kind='�ǥ�' and id_sn='$sn'";
		$kind_who="�ǥ�";
	}elseif($who=="��L"){
		$where="id_kind='��L' and id_sn='$sn'";
		$kind_who="��L";
	}
	//���o���v���ӱЮv�γB�ǩ�¾�٪��Ҳ�
	$sql_select = "select pro_kind_id,is_admin from pro_check_new where $where";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);

	while(list($pro_kind_id,$is_admin) = $recordSet->FetchRow()){
		if(in_array($pro_kind_id,$msn_array)){
		//�p�G�u�Ҳսs���@�ˡA����His_admin=1�@���D�n����
			if($prob[$pro_kind_id]==0 and $is_admin=='1'){
				$prob[$pro_kind_id]=$is_admin;
			}
		}else{
			$prob[$pro_kind_id]=$is_admin;
			$msn_array[]=$pro_kind_id;
		}

		//��X�ӽs�����U�Ҧ��s��
		$c_prob=parent_prob_poser($pro_kind_id,$kind_who,$sn);
		$c_prob=substr($c_prob,0,-1);
		$child_prob=explode(",",$c_prob);
		if(sizeof($child_prob)>0){
			foreach($child_prob as $child_id){
				$prob[$child_id]=get_prob_power_set($child_id,$kind_who,$sn);
			}
		}
	}
	return $prob;
}



//���o�Y�ӼҲաA�Y�H�����v���A
function get_prob_power_set($pro_kind_id,$id_kind="",$id_sn=""){
	global $CONN;
	$sql_select = "select is_admin from pro_check_new where pro_kind_id='$pro_kind_id' and id_kind='$id_kind' and id_sn='$id_sn'";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error("��Ƴs�����~�G".$sql_select, E_USER_ERROR);
	list($is_admin) = $recordSet->FetchRow();
	if(empty($is_admin))$is_admin=0;
	return $is_admin;
}
*/


// ���ѼҲէ@�̨��o�Q���ު� "�Ҳ��ܼ�"�A�ӼҲէ@�̫K�i�w����ܼƪ��{�p�A���A���{���ʧ@
// ��p�G����C����ܯd�����ƪ��w�]�Ȭ� 15 ���A�{�b�g�� "�Ҳճ]�w" �קאּ 10�A����
// �Ҳյ{���惡�n���P���A���禡�N�O���ѼҲէ@�̡A��K���o�o���ܼƪ��{�p�A�Ӥ����C��Ҳ�
// �@�̳��n�w��o�����g�@�Ө禡�C
//
// �ѼƳW�w�G
//
// �ǤJ�G�ܼ� $pm_name : �Ҳժ��^��W�١A�ҭȡGlunch
// �Ǧ^�G$MSETUP �@���}�C���Ѧ�(reference)
//
// �I�s�k�ΨҡG
//
// $pm_name="lunch";
// $MSETUP =& get_module_setup($pm_name)
//
// �g�W�z�I�s����A�Ҳէ@�̨����ܼƪ���k�G
//
// ���]�����ܼƦ��G page_num �Bhave_line
//
// �h�G
//
// $page_num  = $MSETUP[page_num];
// $have_line = $MSETUP[have_line]
//

// ���o�Q���ު� "�Ҳ��ܼ�" key �� ��
function &get_module_setup($pm_name) {
	global $CONN;

	// �S���ǤJ�ҲզW�١A�����B�z�C
	if (!$pm_name) trigger_error("���~�G �S���ǤJ�Ҳխ^��W��! ���ˬd!", E_USER_ERROR);

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// �Ǧ^�}�C���H��l�ơA�H�K�L�ȮɡA�Ǧ^����C
	$MSETUP=array();

	// ���X�����ܼƪ��W�٤έ�
	$sql="SELECT pm_item, pm_value FROM pro_module WHERE pm_name='$pm_name'";

	// �� select ���G�@�w�n�ˬd�O�_�����X�F�F
	if (!($res=$CONN->Execute($sql))) {
		print $CONN->ErrorMsg();
	} else {
		while ($ar=$res->FetchRow()) {
			$MSETUP[$ar[0]]=$ar[1];
		}
	}
	// access ���A�� function�A�@�w�n���Ǧ^��
	return $MSETUP;
}


// �إ߼Ҳո��|��]�s��php����^
function Creat_Module_Path(){
    global $CONN,$UPLOAD_PATH,$SFS_PATH_HTML;
    // ��� array Ū�J�覡
    if(file_exists($UPLOAD_PATH."Module_Path.txt"))
	return true;
	// �T�w�s�u����
     if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);


    //����X�Ҧ�����
    $sql_select = "SELECT msn,showname,dirname,sort,isopen,islive,of_group FROM sfs_module where kind='����'";
    $recordSet=$CONN->Execute($sql_select) or user_error("SQL�y�k���~�G $sql_select",256);
    $MPath  = array();

    while (list($msn, $showname, $dirname, $sort, $isopen, $islive, $of_group) = $recordSet -> FetchRow()) {
	    $g=($main_kind[$of_group])?" $main_kind[$of_group] /":"";
		$main_kind[$msn]="$g <a href='".$SFS_PATH_HTML."index.php?_Msn=$msn'>$showname</a>";
        $kk[] = $msn;
        $MPath[$msn]=$main_kind[$msn];
    }

    $sql_select = "SELECT msn,showname,dirname,sort,isopen,islive,of_group FROM sfs_module where kind='�Ҳ�'";

    $recordSet = $CONN -> Execute($sql_select);
    while (list($msn, $showname, $dirname, $sort, $isopen, $islive, $of_group) = $recordSet -> FetchRow()) {
       $kn = (in_array($of_group, $kk))?$main_kind[$of_group]:"�L";
       $MPath[$msn]="$kn / <a href='".$SFS_PATH_HTML."modules/$dirname/'>$showname</a>";
    }
    $string = serialize($MPath);

	//�ˬd data ����ƪ�O�_���إߡA�Y���ɮ�Ū�g�v�O�_�w�g�ץ�
	if (@!opendir($UPLOAD_PATH)) {
		user_error("�Ҳո��|�ɡ]Module_Path.php�^�}�ҿ��~�A�i���]�p�U�G<ol><li>�z�i��|���إ� <font color='blue'><b>$UPLOAD_PATH</b></font> �ؿ��C</li><li><font color='blue'><b>$UPLOAD_PATH</b></font>  �ؿ����ݩʥ��]�w��<font color='red'><b>�i�g�J</b></font>�I<ul><li>Linux �U�G<font color='darkGreen'><b>chmod 777 $UPLOAD_PATH</b></font></li></ul></li></ol>",256);
	}
	if(!is_writable ($UPLOAD_PATH)){
		user_error("<font color='blue'><b>$UPLOAD_PATH</b></font> �ؿ��L�k�g�J�C<br>Linux �U�G<font color='darkGreen'><b>chmod 777 $UPLOAD_PATH</b></font>",256);
	}

	//�}���ɮ׼g�J���
	$fp = fopen ($UPLOAD_PATH."Module_Path.txt", "aw") or user_error("�L�k�}�� $UPLOAD_PATH �ؿ�",256);
	fputs($fp, $string);
	fclose($fp);
	return true;
}

//�۰ʨ��o�Ҳռ��D
function get_module_title(){
	global $CONN,$SFS_PATH_HTML,$UPLOAD_PATH,$MODULE_DIR;
	//�Ҳռ��D���o�u�����ǡG��Ʈw�Ҳժ����D�Amodule-cfg.php�������D�A���S���h�ۭq���D
	$SCRIPT_NAME=$_SERVER[SCRIPT_NAME];
	$SN=explode("/",$SCRIPT_NAME);
	$dirname=$SN[count($SN)-2];

	//���X���D
    $sql_select = "SELECT showname FROM sfs_module where dirname='$dirname'";
    $recordSet=$CONN->Execute($sql_select) or user_error("SQL�y�k���~�G $sql_select",256);
    list($title)= $recordSet -> FetchRow();

	if(empty($title)){
		include_once $MODULE_DIR.$dirname."/module-cfg.php";
		$title=$MODULE_PRO_KIND_NAME;
	}

	return $title;
}

// ��ƪ�ɯŨ禡
//
// $sql ���ɯ�SQL���O
// $chk_field_arr ���ˬd�������}�C,�w�]�Ȭ��Ű}�C,�Y���ˬd
// $chk_field_arr ���G���}�C,�w�q�p�U:
//     $chk_field_arr[0][table_name] ��ƪ�W
//     $chk_field_arr[0][field_name] ���W
//     $chk_field_arr[0][field_type] ��쫬�A (�ŭȥN���ˬd)
//     $chk_field_arr[0][check_in_table] ���s�b��ƪ� (0 -> ���s�b, 1 -> �s�b)

function upgrade_table($sql,$chk_field_arr=array()) {
        global $CONN;
        if (count($chk_field_arr)==0) {
                return $CONN->Execute($sql);
        }
        else {
                for($i=0;$i<count($chk_field_arr);$i++){
                        //�C�X�����
                        $res = $CONN->MetaColumns($chk_field_arr[$i][table_name]);

                        $temp_flag = 0;
                        foreach($res as $v) {
                                if($v->name ==  $chk_field_arr[$i][field_name]){
                                        $temp_field_type = $v->type;
                                        $temp_flag= 1;
                                        break;
                                }
                        }
                        if(!($chk_field_arr[$i][check_in_table] ^ $temp_flag)) {
                                if ($chk_field_arr[$i][field_type] =='')
                                        $do_query_flag = true;
                                else if($chk_field_arr[$i][field_type] != $temp_field_type)
                                        $do_query_flag = true;
                                else
					$do_query_flag = false;
                        }
                        else
                                $do_query_flag = false;

                }
                if ($do_query_flag)
                        return $CONN->Execute($sql);
                else
                        return false;
        }
}
?>
