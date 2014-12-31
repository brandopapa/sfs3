<?php

// $Id: sfs_case_dataarray.php 8252 2014-12-23 02:04:39Z smallduh $
// �U�ظ�ư}�C
// ���N�� data_array_function.php

//�b�Ǳ��Ρq�|���Ψ�r
function study_cond() {
	 return array("0"=>"�b�y","1"=>"��X","2"=>"��J","3"=>"�����_��","4"=>"��Ǵ_��","5"=>"���~","6"=>"���","7"=>"�X��","8"=>"�ծ�","9"=>"�ɯ�","10"=>"����","11"=>"���`","12"=>"����","13"=>"�s�ͤJ��","14"=>"��Ǵ_��","15"=>"�b�a�۾�");
}

//�ǥͨ����O
function stud_kind(){
	$res = SFS_TEXT("stud_kind");
	if (count($res))
		return $res;
	else
	return array("0"=>"�@��ǥ�","1"=>"���H�ݻ�","2"=>"�a���ݻ�","3"=>"�C���J��","4"=>"�j���ӥx�̿˪�","5"=>"�\���l�k","6"=>"���~����","7"=>"��D��","8"=>"��æ��","9"=>"����","10"=>"�~�y��","11"=>"���u��","12"=>"���~�H���l�k","13"=>"��|�Z�u","14"=>"�C���˴�","15"=>"��¾���l�k","16"=>"���п��(�]��)","17"=>"���п��(�]�f)","18"=>"���߻�ê(�˩w)","19"=>"��L");
}

//�Z�ũʽ�
function stud_class_kind(){
	return array("0"=>"�@��Z","1"=>"�S��Z");
}

//�S��Z���O
function stud_spe_kind() {
	$res = SFS_TEXT("stud_spe_kind");
	if (count($res))
		return $res;
	else
	return array("1"=>"��ê��","2"=>"���u��","3"=>"�귽�Z");
}

//�S��Z�W�ҩʽ�
function stud_spe_class_id() {
	$res = SFS_TEXT("stud_spe_class_id");
	if (count($res))
		return $res;
	else
	return array("1"=>"������","2"=>"������");
}

//�S��Z�Z�O
function stud_spe_class_kind() {
	$res = SFS_TEXT("spe_class_kind");
	if (count($res))
		return $res;
	else
	return array("1"=>"�Ҵ�","2"=>"�ҩ�","3"=>"���o","4"=>"���j����","5"=>"�Ҿ�","6"=>"���n","7"=>"�Ұ�","8"=>"�ҭ}","9"=>"�Ҥ�(�ϻ�)","10"=>"�y��","11"=>"���߻�ê","12"=>"�ǲߧx��","13"=>"�b�a�Ш|","14"=>"�h����ê","15"=>"�@�봼���u��","16"=>"����","17"=>"���N","18"=>"�R��","19"=>"��|","20"=>"��L");
}

//�J�Ǹ��
function stud_preschool_status() {
	$res = SFS_TEXT("preschool_status");
	if (count($res))
		return $res;
	else
		return array("0"=>"���ǰ�","1"=>"�j�ǰ�","2"=>"�H���NŪ","3"=>"�H���NŪ");
}

//���ɭӮ׽s���q�|���Ψ�r
function stud_eduh() {
	$res = SFS_TEXT("stud_eduh");
	if (count($res))
		return $res;
	else
		return array("1"=>"��������","2"=>"�ɮv�श","3"=>"�V�ɳB�श","4"=>"�ӮץD�ʫt��","99"=>"��L");
}

//���ɭӮ׽s���q�|���Ψ�r
function eh_caes() {
	$res = SFS_TEXT("eh_caes");
	if (count($res))
		return $res;
	else
		return array("1"=>"�欰","2"=>"�ǲߧx�Z","3"=>"����","4"=>"�H�����Y","5"=>"��ʱШ|","6"=>"�a�x�A�����}","7"=>"�ͲP�W��","8"=>"�v�����Y","9"=>"�����[","99"=>"��L");
}

//���ɭӮ׽s���q�|���Ψ�r
function eh_meth() {
	$res = SFS_TEXT("eh_meth");
	if (count($res))
		return $res;
	else
		return array("1"=>"�~�V�ʧ����欰","2"=>"���V�ʧ����欰","3"=>"����","4"=>"���a�X��","5"=>"�t��.�۩�","6"=>"�İʦ欰","7"=>"�k��","8"=>"�J�{�欰","9"=>"�e������","10"=>"����","11"=>"�ʤ��}�A��","12"=>"���~�ǯ�","13"=>"�C��","14"=>"�ѥ[���}����","15"=>"���","16"=>"���","17"=>"�l�r","18"=>"�ܰs","99"=>"��L");
}

//¾�ٰ}�C
function title_kind() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $arr
	$arr=array();

	$res = $CONN->Execute("select  teach_title_id ,title_name from teacher_title  where enable=1 order by teach_title_id ") or user_error("Ū�����ѡI",256);
	while (!$res->EOF) {
		$arr[$res->fields[0]] = $res->fields[1];
		$res->MoveNext();	
	}
	return $arr;
}

//¾�O�}�C
function post_kind(){
	$res = SFS_TEXT("post_kind");
	if (count($res))
		return $res;
	else
		return array("1"=>"�ժ�","2"=>"�Юv�ݥD��","3"=>"�D��","4"=>"�Юv�ݲժ�","5"=>"�ժ�","6"=>"�ɮv","7"=>"�M���Юv","8"=>"��߱Юv","9"=>"�եαЮv","10"=>"�N�z/�N�ұЮv","11"=>"�ݥ��Юv","12"=>"¾��","13"=>"�@�h","14"=>"ĵ��","15"=>"�u��");
}

//�x���}�C
function official_level(){
	$res = SFS_TEXT("official_level");
	if (count($res))
		return $res;
	else
		return array("1"=>"²��","2"=>"�˥�","3"=>"�e��");
}

//�B�����O�}�C
function room_kind(){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $arr
	$arr =array();

	$result = $CONN->Execute("select room_id , room_name from school_room where enable=1 order by room_id") or user_error("Ū�����ѡI",256);
	while (!$result->EOF){
		$arr[$result->fields[0]] = $result->fields[1];
		$result->MoveNext();
	}
	return $arr;
}


//�Юv�{�p�}�C
function remove() {
	$res = SFS_TEXT("remove");
	if (count($res))
		return $res;
	else
	return array ("0"=>"�b¾","1"=>"�եX","2"=>"�h��","3"=>"�N�Ҵ���","4"=>"�껺");
}


//�Юv�ҷӰ}�C
function tea_check_kind() {
	$res = SFS_TEXT("tea_check_kind");
	if (count($res))
		return $res;
	else
	return array("1"=>"����ά������˩w�X��","2"=>"��߱Юv","3"=>"�եαЮv�n�O","4"=>"�n�O��","5"=>"��L");
}

//�Юv�ҷӪ��A�}�C
function teach_check_kind() {
	$res = SFS_TEXT("teach_check_kind");
	if (count($res))
		return $res;
	else
	return array("1"=>"�˩w","2"=>"�n�O","3"=>"�f�d","A"=>"����ά�����n�O","B"=>"�D������n�O","C"=>"�޳N�Юv�n�O","D"=>"�եαЮv�n�O","E"=>"��߱Юv");
}

//�Юv�D�n���л��q��96�~�Ш|������]�w�r
function teach_category($level=0) {
	$res = SFS_TEXT("teach_category");
	if (count($res))
		return $res;
	else
		if ($level==0)
			return array("11"=>"����","15"=>"�^�y","17"=>"�m�g�y��","20"=>"���d�P��|","30"=>"���|","40"=>"�ƾ�","50"=>"���N�P�H��","60"=>"�۵M�P�ͬ����","70"=>"��X����","80"=>"��L");
		else
			return array("11"=>"����","15"=>"�^�y","91"=>"���d�Ш|","92"=>"��|","93"=>"���v","94"=>"�a�z","95"=>"����","96"=>"���N","97"=>"����","98"=>"��t���N","99"=>"�ͪ�","9A"=>"�z��","9B"=>"�a��","9C"=>"�q��","9D"=>"�ͬ����","9E"=>"�a�F","9F"=>"���x","9G"=>"����","80"=>"��L");
}

//�����}�C
function birth_state(){
	$res = SFS_TEXT("birth_state");
	if (count($res))
		return $res;
	else
	return array("01"=>"�x�_��","02"=>"������","03"=>"�y����","04"=>"�򶩥�","05"=>"�x�_��","06"=>"��鿤","07"=>"�s�˿�","08"=>"�s�˥�","09"=>"�]�߿�","10"=>"�x����","11"=>"�x����","12"=>"�n�뿤","13"=>"���ƿ�","14"=>"���L��","15"=>"�Ÿq��","16"=>"�Ÿq��","17"=>"�x�n��","18"=>"�x�n��","19"=>"������","20"=>"�̪F��","21"=>"�x�F��","22"=>"�Ὤ��","23"=>"���","24"=>"������","25"=>"�s����");
}

//�嫬
function blood(){
	return array("1"=>"A","2"=>"B","3"=>"O","4"=>"AB");
}


//�Ҹ��O
function stud_country_kind(){
	return array("0"=>"�����Ҧr��","1"=>"�@�Ӹ��X","2"=>"�~�d�Ҹ��X");
}

//�Ǿ�
function edu_kind(){
	$res = SFS_TEXT("edu_kind");
	if (count($res))
		return $res;
	else
		return array("1"=>"�դh","2"=>"�Ӥh","3"=>"�j��","4"=>"�M��","5"=>"����","6"=>"�ꤤ","7"=>"��p���~","8"=>"��p�w�~","9"=>"�Ѧr(���N��)","10"=>"���Ѧr");
}

//�H�ƨt��¾�ٰ}�C�q�|���Ψ�r
function tnc_post_kind(){
		return array("1"=>"�ժ�","2"=>"�Юv�ݥD��","3"=>"�D��","4"=>"�Юv�ݲժ�","5"=>"�ժ�","6"=>"�ɮv","7"=>"�M���Юv","8"=>"��߱Юv","9"=>"�եαЮv","10"=>"�N�z/�N�ұЮv","11"=>"�ݥ��Юv","12"=>"¾��","13"=>"�@�h","14"=>"ĵ��","15"=>"�u��");
}

//�ƨt�Ωx���}�C�q�|���Ψ�r
function tnc_official_level(){
		return array("1"=>"²��","2"=>"�˥�","3"=>"�e��");
}

//�Ǿ��O
function tea_edu_kind() {
	return array ("1"=>"��s�Ҳ��~(�դh)","2"=>"��s�Ҳ��~(�Ӥh)","3"=>"��s�ҥ|�Q�Ǥ��Z���~","4"=>"�v�j�αШ|�ǰ|���~","5"=>"�j�ǰ|�դ@���t���~(���ײ߱Ш|�Ǥ�)","6"=>"�j�ǰ|�դ@���t���~(�L�ײ߱Ш|�Ǥ�)","7"=>"�v�d�M�첦�~","8"=>"��L�M�첦�~","9"=>"�v�d�Ǯղ��~","10"=>"�x�ƾǮղ��~","11"=>"��L");
}


//¾�~�O�q�|���Ψ�r
function occu_kind(){
	return array("1"=>"�h","2"=>"�A","3"=>"�u","4"=>"��","5"=>"�x","6"=>"��","7"=>"�A��","8"=>"��L","9"=>"��");
}

//�P���@�H���Y�q�|���Ψ�r
function guar_kind(){
	return array("1"=>"���l","2"=>"���l","3"=>"���k","4"=>"���k","5"=>"��L");
}

//�ӤH�f�v��ơq�|���Ψ�r
function per_sick_kind() {
	$res = SFS_TEXT("per_sick_kind");
	if (count($res))
		return $res;
	else
	return array("1"=>"��Ŧ�f","2"=>"B���x���a��","3"=>"�|����","4"=>"���w","5"=>"�ͪ�","6"=>"���k","7"=>"���","8"=>"��Ŧ�f","9"=>"��ͯf","10"=>"�͵���","11"=>"����","12"=>"�S�����","13"=>"����","14"=>"����","15"=>"���~�Ī��L��","16"=>"�����","17"=>"�w��¯l","18"=>"�p��·�","19"=>"�˴H");
}

//�a�گf�v���
function fam_sick_kind() {
	$res = SFS_TEXT("fam_sick_kind");
	if (count($res))
		return $res;
	else	
	return array("1"=>"������","2"=>"�}���f","3"=>"B���x���a��","4"=>"���w","5"=>"�믫�e�f","6"=>"�͵���","7"=>"�L�өʯe�f","8"=>"��Ŧ��ޯe�f","9"=>"�����c�e�f","10"=>"�~�F","11"=>"?�L");
}


//�ǲ߻��]�w
function course9() {
	$res = SFS_TEXT("course9");
	if (count($res))
		return $res;
	else	
	return array("1"=>"�y��","2"=>"���d�P��|","3"=>"���|","4"=>"���N�P�H��","5"=>"�۵M�P���","6"=>"�ͬ�","7"=>"�ƾ�","8"=>"��X����","9"=>"�u�ʾǲ�"); 
}

//���|���O�]�w�q�|���Ψ�r
function course5() {
	$res = SFS_TEXT("course5");
	if (count($res))
		return $res;
	else	
	return array("1"=>"�w","2"=>"��","3"=>"��","4"=>"�s","5"=>"��"); 
}


//��س]�w
function subject_kind() {	
	$res = SFS_TEXT("subject_kind");
	if (count($res))
		return $res;
	else	
	return array("1"=>"��y","2"=>"�ƾ�","3"=>"���|","4"=>"�۵M","5"=>"�D�w�P���d","6"=>"�ͬ��P�۲z","7"=>"��|","8"=>"�Ѫk","9"=>"����","10"=>"����","11"=>"���y","12"=>"�q��","13"=>"�m�g�о�","14"=>"�ͬ��Ш|","15"=>"�𶢱Ш|","16"=>"���|�A��","17"=>"��μƾ�","18"=>"��έ^��","19"=>"�u������","20"=>"���ɬ���","21"=>"���ά���","22"=>"¾�~�ͬ�");

}


// �����O�q�|���Ψ�r
function native_kind(){ 
	return array("1"=>"����","2"=>"�ɮL","3"=>"���A","4"=>"�Q","5"=>"�|��","6"=>"���W","7"=>"���n","8"=>"����","9"=>"����");
}

// �������Y�q�|���Ψ�r
function fath_moth_kind(){ 
	return array("1"=>"�P��","2"=>"����","3"=>"���~","4"=>"���B","5"=>"��L");
}

// �a�x��^�q�|���Ψ�r
function family_amb_kind(){ 
	return array("1"=>"�ܩM��","2"=>"�M��","3"=>"���q","4"=>"���M��","5"=>"�ܤ��M��");
}

// �����ޱФ覡�q�|���Ψ�r
function leading_style_kind(){ 
	return array("1"=>"���D��","2"=>"�v�¦�","3"=>"�����","4"=>"��L");
}


// �g�٪��p�q�|���Ψ�r
function economics_kind(){ 
	return array("1"=>"�I��","2"=>"�p�d","3"=>"���q","4"=>"�M�H","5"=>"�h�x");
}

// �~�����ҡq�|���Ψ�r
function live_atmosphere_kind(){ 
	return array("1"=>"��v��","2"=>"�ӷ~��","3"=>"�V�X(��B�ӡB�u)","4"=>"�x����","5"=>"�A��","6"=>"����","7"=>"�u�q��","8"=>"�s�a","9"=>"��L");
}

// �~�����ҡq�|���Ψ�r
function live_school_kind(){ 
	return array("1"=>"��b�a��(�ǰϤ�)","2"=>"��b�a��(�ǰϥ~)","3"=>"�H�~�ˤͮa","4"=>"��L");
}


 // �ٿ�
function bs_calling_kind(){
	return array("1"=>"�S","2"=>"��","3"=>"�n","4"=>"�f");
}

// �O�_�q�|���Ψ�r
function yes_no(){ 
	return array("1"=>"�O","2"=>"�_");
}

// �s�\
function is_live(){ 
	return array("1"=>"�s","2"=>"�\ ");
}

// �P�����Y
function fath_relation(){ 
	return array("1"=>"�ͤ�","2"=>"�i��","3"=>"�~��");
}


// �P�����Y
function moth_relation(){ 
	return array("1"=>"�ͥ�","2"=>"�i��","3"=>"�~��");
}

// �P���@�H���Y
function guardian_relation(){ 
	return array("1"=>"���l","2"=>"���k","3"=>"���l","4"=>"���k","5"=>"���]","6"=>"�S��","7"=>"�S�f","8"=>"�j��","9"=>"�n�f","10"=>"�B���h���c","11"=>"��L");
}

// ���g�q2003-6-18 by hami�r
function stud_rep_kind() { 
	return array("1"=>"�j�\\","2"=>"�p�\\","3"=>"�ż�","4"=>"�j�L","5"=>"�p�L","6"=>"ĵ�i");	
}

//�ǥͰ��O �q2003-6-18 by hami�r
function stud_abs_kind(){
	return array("1"=>"�ư�","2"=>"�f��","3"=>"�m��","4"=>"���|","5"=>"����","6"=>"��L");
}

//�Юv���O �q2004-9-29 by brucelyc   2011-2-14 extend by infodaes�r
function tea_abs_kind(){
	return array("11"=>"�ư�","12"=>"�a�x���U��","21"=>"�f��","22"=>"�Ͳz��","31"=>"���t","41"=>"�B��","42"=>"���e��","43"=>"�Y��","44"=>"�y����","45"=>"������","46"=>"�ల","47"=>"����","52"=>"���t��","53"=>"���X","61"=>"��L","23"=>"�����f��","81"=>"��","82"=>"�ɥ�","91"=>"���讽�ذ�","92"=>"���x���ذ�","93"=>"�a����");
}

//�ײ��~�O �q2005-1-7 by brucelyc�r
function grad_kind(){
	return array("1"=>"���~","2"=>"�׷~");
}

//�ˮ֪�ﶵ
function chk_kind(){
	return array("1"=>"�����ŦX","2"=>"�j�����ŦX","3"=>"�����ŦX","4"=>"�ݧ�i");
}

//��`�ͬ���{��r����
function nor_text(){
	return array(0=>"��`�欰",1=>"���鬡��",2=>"���@�A��_�դ�",3=>"���@�A��_�ե~",4=>"�S���{_�դ�",5=>"�S���{_�ե~");
}

//�U�װ��d�t�Τ��w��
//�����魫
function hWHDiag(){
	return array("1"=>"�a�کʸG�p","2"=>"���ʿ�w","3"=>"�S�o�ʸG�p","4"=>"�ͪ��E���ʥF","5"=>"�z�S�Ǥ�g","A"=>"�L�T�w�E�_","B"=>"�E�v���`","N"=>"�䥦�E�_","Z"=>"���N�E");
}

function hWHID(){
	return array("-2"=>"�髬�G�z","-1"=>"�魫�L��","0"=>"�魫���`","1"=>"�魫�L��","2"=>"�髬�έD");
}

//���O
function hSightDiag(){
	return array("1"=>"���","2"=>"����","3"=>"����","4"=>"���&����","5"=>"����&����","7"=>"�z��","N"=>"�䥦");
}

function hSightManage(){
	return array("1"=>"���O�O��","2"=>"�I�Īv��","3"=>"�t���B�v","4"=>"�a�����B�z","5"=>"�����","6"=>"�w���ˬd","7"=>"�B���v��","8"=>"�t���v��","9"=>"�t����������","N"=>"�䥦");
}

function hSolidDiag(){
	return array("1"=>"�׵�","2"=>"�z��","3"=>"�סB�z��","4"=>"��������","A"=>"�L�T�w�E�_","B"=>"�E�v���`","N"=>"��L���e","Z"=>"���N��");
}

function hSquintKind(){
	return array("1"=>"���׵�","2"=>"�~�׵�","3"=>"�W�׵�","4"=>"�U�׵�","5"=>"�~�۱׵�","6"=>"���۱׵�","7"=>"�·��ʱ׵�","9"=>"��L");
}


//���d�ˬd
function hCheckKind(){
	return array("1"=>"��Ŧ�f�z��","2"=>"�ݳ����","3"=>"�x�\��","4"=>"�ǥ\��","5"=>"����","6"=>"����","7"=>"�ϫ��x��","8"=>"�Ы��x��","9"=>"���ֵ߯�����");
}

function hCheckDep(){
	return array("1"=>"����","2"=>"����","3"=>"��Ŧ��","4"=>"�c����","5"=>"�ջ���","6"=>"�~��","7"=>"����","8"=>"�y���v����","9"=>"�ݵĬ�","10"=>"�ֽ���","11"=>"�L�Ӭ�","12"=>"�s���N�¬�","13"=>"��Υ~��","14"=>"���g�~��","15"=>"�믫��","16"=>"����","17"=>"�����c��");
}

//�S��e�f
function hDiseaseKind(){
	return array("02"=>"�͵���","03"=>"��Ŧ�f","04"=>"�x��","05"=>"���","06"=>"��Ŧ�f","07"=>"���w","08"=>"�����ʯT�H","09"=>"��ͯf","10"=>"�����g","11"=>"���`��","12"=>"�}���f","13"=>"�߲z�κ믫�ʯe�f","14"=>"���g","15"=>"���v�ʳh��","16"=>"���j��N","17"=>"�L�Ӫ���","99"=>"��L");
}

//���j�e�f
function hSeriousDiseaseKind(){
	return array("01"=>"���n���Ϊ����v�������g","02"=>"���ѩʾ���]�l���`","03"=>"�Y������ʤΦA�ͤ��}�ʳh��","04"=>"�C�ʵǰI��(���r�g)�A���������w���z�R�v����","05"=>"�ݲר��v���������ʦ���K�̯g�Ըs","06"=>"�C�ʺ믫�f","07"=>"���ѩʷs���N�²��`�e�f","08"=>"�ߡB�͡B�G�z�B��Ŧ�B���g�B���f�t�ε������ѩʷ�άV���鲧�`","09"=>"�N�S�˭��n�F�����ʤ����G�Q�H�W�F���C���N�S�˦X�֤��x�\���ê��","10"=>"������Ŧ�B��Ŧ�B��Ŧ�B�xŦ�ΰ��貾�ӫᤧ�l�ܪv��","11"=>"�p��·��B���ʳ·��B������Ҥް_�����g�B�٦סB���f�B��Ŧ�����ֵo�g��","12"=>"���j�ж˥B���Y���{�ר�F�ж��Y���{�פ��ƤQ�����H�W��","13"=>"�]�I�l�I�ܪ����ϥΩI�l����","14"=>"�]�z�D�j�q�����Υ��h�\��A�Ψ䥦�C�ʯe�f�ް_�Y����i���}��","15"=>"�]����B�δ�������ް_���Y���������f�ΪŮ���g�A�񦳩I�l�B�`���ί��g�t�Τ��ֵo�g�B�ݪ����v����","16"=>"���g�ٵL�O�g","17"=>"���ѩʧK�̤����g","18"=>"����l�˩ίf�ܩҤް_�����g�B�٦סB�ֽ��B���f�B�ߪ͡B�c���θz�G�����ֵo�g��","19"=>"¾�~�f","20"=>"��ʸ���ޯe�f","21"=>"�h�o�ʵw�Ưg","22"=>"���ѩʦ٦׵��Y�g","23"=>"�~�֤����ѷ","24"=>"��Ưf","25"=>"�x�w�Ưg","26"=>"������Ҥް_�����g�B�٦סB���f�B��Ŧ�B��Ŧ�����ֵo�g","27"=>"�~�Ψ�ƦX�����r�ʧ@�Ρ]�Q�}�f�^","28"=>"��ѧK�̯ʥF�g�Ըs","29"=>"�B�ʯ��g���e�f�䨭�߻�ê��","30"=>"�w���f","99"=>"�u���e�f");
}

//���߻�ê
function hBodyMindKind(){
	return array("01"=>"��ı��ê��","02"=>"ťı�����ê��","03"=>"���ž����ê��","04"=>"�n������λy�������ê��","05"=>"�����ê��","06"=>"�����ê��","07"=>"���n���x���h�\���","08"=>"�C���l�˪�","09"=>"�Ӫ��H","10"=>"�����g��","11"=>"�۳��g��","12"=>"�C�ʺ믫�f�w��","13"=>"�h����ê��","14"=>"�x�ʡ]���v���^���w�g��","15"=>"�g�����åͥD�޾����{�w�A�]�u���e�f�ӭP���ߥ\���ê","99"=>"��L�g�����åͥD�޾����{�w����ê��");
}

function hBodyMindLevel(){
	return array("1"=>"����","2"=>"����","3"=>"����","4"=>"������");
}

function hInfLegal(){
	return array("000"=>"��L","001"=>"�N��","002"=>"�˴H","002a"=>"�ƶ˴H","003"=>"�F�����","004"=>"��ߩʵg�e","005"=>"�������r�]�L��]�^","0050"=>"�����⸲��y��","0051"=>"�׬r��ߤ��r","0054"=>"�z������","0058"=>"��L�ӵߩʭ������r","006"=>"���̤کʵg�e","0080"=>"�z�D�X��ʤj�z��߷P�V�g","0092"=>"���m","010a"=>"�}��ʪ͵���","011"=>"���֯f(���}��ʪ͵��֥~)","012"=>"��L���֯f","0130"=>"���֩ʸ�����","020"=>"����","022"=>"���j�f","025"=>"����j","026"=>"�ߧ�f","030"=>"��f","032"=>"�ճ�","033"=>"�ʤ�y","0341"=>"�V����","0360"=>"�y��ʸ����轤��","037"=>"�}�˭�","042"=>"��ѧK�̯ʥF�g�Ըs","044"=>"�֢ע�P�V","045"=>"�p��·��g","045a"=>"��ʵL�O����·�","0461"=>"�w���g","052"=>"���k","055"=>"�¯l","056"=>"�w��¯l","060"=>"�����f","061"=>"�n����","0620"=>"�饻����","0654"=>"�n���X������n����J�g�Ըs","0701"=>"��ʯf�r�ʨx���ϫ�","0703"=>"��ʯf�r�ʨx���Ы�","0705"=>"��ʯf�r�ʨx���ѫ�","070d"=>"��ʯf�r�ʨx���ҫ�","070e"=>"��ʯf�r�ʨx���ӫ�","070x"=>"��ʯf�r�ʨx�����w��","071"=>"�g���f","072"=>"�|����","074"=>"�J�F�_","0743"=>"�⨬�f�g","0749"=>"�z�f�r�P�V�ֵo���g","078"=>"�z�G��","0786"=>"�~�L�f�r�X���","0788"=>"��i�ԯf�r�X���","080"=>"�y��ʴ��l�˴H","0812"=>"�~�ίf","0820"=>"�a��ʴ��l�˴H","0820"=>"�a��ʴ��l�˴H","0830"=>"�߼�","084"=>"�įe","087"=>"�^�k��","090"=>"���r","098"=>"�O�f","100"=>"�_��������f","1048"=>"�ܩi�f","125"=>"�嵷�ίf","3200"=>"�Iŧ�ʢꫬ�ݦ��߷P�V�g","321"=>"�f�r�ʸ�����","390"=>"�����","4461"=>"�t�T��g","4808"=>"�~�L�f�r�ͯg�Ըs","4828"=>"�h��x�H�f","487"=>"�y��ʷP�_","487a"=>"�y��ʷP�_���g","7710"=>"���ѩʼw��¯l�g�Ըs","7713"=>"�s�ͨ�}�˭�","SARS"=>"�Y����ʩI�l�D�g�Ըs");
}

function hInfManage(){
	return array("A"=>"�ͯf���W��","B"=>"�ͯf�b�a��","C"=>"�ͯf��|");
}

function get_folk_kind(){
	return array("����","����","����","����","�S","��","�j","�f");
}

//�Юv��� (�Ȩ��b¾)
function teacher_array() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $teacher_array
	$teacher_array=array();
	$sql_select = "select name,teacher_sn from teacher_base where teach_condition='0' order by name";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
		$teacher_array[$teacher_sn]=$name;
	}
	return $teacher_array;
}

//�Юv��� (�����b¾)
function teacher_array_all() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $teacher_array
	$teacher_array=array();
	$sql_select = "select name,teacher_sn from teacher_base order by name";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
		$teacher_array[$teacher_sn]=$name;
	}
	return $teacher_array;
}

//�Ǵ��Z�žɮv�m�W�ѷӨ禡
function class_teacher() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	// init $teacher_array
	$class_teacher_array=array();
	$sql_select = "select class_id,teacher_1 from school_class where enable=1 order by class_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while (list($class_id,$teacher_1) = $recordSet->FetchRow()) {
		$class_teacher_array[$class_id]=$teacher_1;
	}
	return $class_teacher_array;
}

//���o���y��]
function stud_obtain_kind(){
	return array("1"=>"���y","2"=>"�H���NŪ","3"=>"�H���NŪ","4"=>"�Ӯ׫O�@","5"=>"�~�y");
}

//�Ӯ׫O�@���O
function stud_safeguard_kind(){
	return array("1"=>"�׶�","2"=>"�a��","3"=>"�оi�w�m");
}



?>
