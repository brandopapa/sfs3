<?php
// $Id: output_xml.php 7270 2013-04-22 02:32:24Z infodaes $

if (!$_POST['sid']){
exit;
}

session_id($_POST['sid']);
session_start();

require "config.php";
require "class.php";

require_once 'Crypt/DiffieHellman.php';
require_once('Crypt/CBC.php');
include 'security.php';
sfs_check();

if ($_POST['getkey']=='true'){

$alice = new Crypt_DiffieHellman($_POST['serverp'], $_POST['serverg']);

$alice_pubKey = $alice->generateKeys()->getPublicKey(Crypt_DiffieHellman::BINARY);

$_SESSION['alicepk']=$alice_pubKey;

$alice_computeKey = $alice->computeSecretKey(base64_decode($_POST['serverpk']),Crypt_DiffieHellman::BINARY)->getSharedSecretKey(Crypt_DiffieHellman::BINARY);

$_SESSION['alicesk']=$alice_computeKey;


echo base64_encode($_SESSION['alicepk']);

}else{

/*
echo base64_encode($_SESSION['alicesk']);
exit;
*/

$key=$_SESSION['alicesk'];
//$iv=base64_decode($_POST['iv']);

$aeskey=hash('md5',base64_encode($_SESSION['alicesk']));

/*
echo $aeskey;
exit;
*/

$move_kind_arr=array("0"=>" -- �п�� -- ","8"=>"�ծ�","5"=>"���~");

$all_reward=$_POST['all_reward'];


//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_POST[year_seme])){
	$sel_year=intval(substr($_POST[year_seme],0,-1));
	$sel_seme=substr($_POST[year_seme],-1,1);
	$year_seme=$_POST[year_seme];
} else {
	$sel_year=curr_year(); //�ثe�Ǧ~
	$sel_seme=curr_seme(); //�ثe�Ǵ�
	$year_seme=sprintf("%03d",$sel_year).$sel_seme;
}

//�������O���
$sel1=new drop_select();
$sel1->s_name="move_kind";
$sel1->id=$_POST[move_kind];
$sel1->arr=$move_kind_arr;
$sel1->has_empty=false;
$sel1->is_submit=true;
$smarty->assign("move_kind_sel",$sel1->get_select());

//�Ǵ����
$sel1=new drop_select();
$sel1->s_name="year_seme";
$sel1->id=$year_seme;
$sel1->arr=get_class_seme();
$sel1->has_empty=false;
$sel1->is_submit=true;
$smarty->assign("year_seme_sel",$sel1->get_select());

if ($_POST[move_kind]=="8") {
		$smarty->assign("form_kind","1");
} else {
		$smarty->assign("form_kind","2");
}

$query="select a.*,b.stud_name from stud_move a ,stud_base b where a.student_sn=b.student_sn and a.move_year_seme='".intval($year_seme)."' and a.move_kind='$_POST[move_kind]' order by a.move_date desc,a.stud_id desc";
//���X�Ҧ��O��
$res=$CONN->Execute($query) or die($query);
$smarty->assign("stud_move",$res->GetRows());

if ($_POST[out_arr]) {
	$xml_obj=new sfsxmlfile();
	$xml_obj->student_sn=$_POST[choice];
	$xml_obj->output();
	$smarty->assign("data_arr",$xml_obj->out_arr);
	$smarty->assign("sex_arr",array("1"=>"�k","2"=>"�k"));
	echo "<pre>";
	print_r($xml_obj->out_arr);
	echo "</pre>";
	exit;
}

//�p�G�T�w��XXML�ɮ�
if ($_POST[output_xml]) {
	//�Ӹ�O��	
	$sn=implode(",",array_keys($_POST[choice]));
	$test=pipa_log("XML�ץX�@�~\r\n�ǥͬy�����G$sn\r\n");
	
	$xml_obj=new sfsxmlfile();
	$xml_obj->student_sn=$_POST[choice];
	$xml_obj->output();
	//���y���
	$smarty->assign("data_arr",$xml_obj->out_arr);
	//�ʧO�}�C
	$smarty->assign("sex_arr",array("1"=>"�k","2"=>"�k"));
	//�����O�}�C (�Ƶ��Ȥ�����)
	$smarty->assign("stud_kind_arr",stud_kind());
	//�ҷ����O�}�C
	$smarty->assign("id_kind_arr",stud_country_kind());
	//�ǥͯZ�ũʽ�}�C
	$smarty->assign("class_kind_arr",stud_class_kind());
	
	//�ǥͯS��Z���O�}�C
	$smarty->assign("spe_kind_arr",stud_spe_kind());
	//�ǥͯS��Z�W�ҩʽ�}�C
	$smarty->assign("spe_class_id_arr",stud_spe_class_id());
	//�ǥͯS��Z�Z�O�}�C
	$smarty->assign("spe_class_kind_arr",stud_spe_class_kind());
	//�ꤤ�p�P�w SFS 4.0 �����ץ�
	$smarty->assign("jhores",$IS_JHORES);
	//�J�Ǹ��}�C
	$smarty->assign("preschool_status_arr",stud_preschool_status());
	
	//���׷~�}�C
	$smarty->assign("grad_kind_arr",grad_kind());

	//�s�\�}�C
	$smarty->assign("is_live_arr",is_live());
	//�P�����Y�}�C
	$smarty->assign("f_rela_arr",fath_relation());
	//�P�����Y�}�C
	$smarty->assign("m_rela_arr",moth_relation());
	//�P���@�H���Y�}�C
	$smarty->assign("g_rela_arr",guardian_relation());
	//�Ǿ��}�C
	$smarty->assign("edu_kind_arr",edu_kind());
	//�S�̩j�f�}�C
	$smarty->assign("bs_calling_kind_arr",bs_calling_kind());
	
	//�ͲP���ɦҼ{�]���}�C
	$factor_items=array('self'=>'�ӤH�]��','env'=>'���Ҧ]��','info'=>'��T�]��');
	foreach($factor_items as $item=>$title){
		$factors[$item]=SFS_TEXT($title);				
	}
	$smarty->assign("factors",$factors);
	
	//����U�Ǵ����X�u���
	$query="select * from seme_course_date order by seme_year_seme,class_year";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$current_seme_year_seme=$res->fields[seme_year_seme];
		$row_data=$res->FetchRow();
		$seme_course_date_arr[$current_seme_year_seme][$row_data['class_year']]=$row_data['days'];
	}
	$smarty->assign("seme_course_date_arr",$seme_course_date_arr);
	
	//���ɭӮ׸�Ʀ]���e�A�����p���t�μȮɤ��洫, �Hnull�ȳB�z
	
//echo "<pre>";	
//print_r($xml_obj->out_arr);
//echo "</pre>";	
//exit;

	$filename=$SCHOOL_BASE['sch_id'].$school_long_name.date('Ymd')."�ǥ�XML_3_0�洫���.xml";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-Type:text/xml; charset=utf-8");

	//�Nsmarty��X����ƥ�cache��
	ob_start();
	$smarty->display("student_3_0.tpl");
	$xmls=ob_get_contents();
	ob_end_clean();


	//�N�ŭȥHnull���N
	$xmls=str_replace("><",">null<",$xmls);
	//$xmls=iconv("Big5","UTF-8",$xmls);
	//�নUnicode���X�ɮ�
	//$xmlsutf8=iconv("Big5","UTF-8",$xmls);
	//$xmls='This is a test';	
	echo Security::encrypt($xmls, $aeskey);
	exit;
}

//�ꤤ�[�J�ͲP���ɿ�X�ﶵ
$checked=$IS_JHOES?'checked':'';
$career_checkbox="<input type='checkbox' name='career' value=1 $checked>��X�ꤤ�ͲP���ɤ�U���(�ݦ��w�ˬ����Ҳ�)";
$smarty->assign("career_checkbox",$career_checkbox);

$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","XML�洫�@�~");
$smarty->assign("SFS_MENU",$toxml_menu);
$smarty->display("toxml_output_xml.tpl");
}
?>
