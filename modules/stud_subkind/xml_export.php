<?php
// $Id: xml_export.php 7712 2013-10-23 13:31:11Z smallduh $

include "config.php";
include "../../include/sfs_case_dataarray.php";
sfs_check();

//�ؼШ���t_id
$type_id=($_REQUEST[type_id]);

//���������O���O�N��
$m_arr = get_sfs_module_set("stud_subkind");
if($m_arr['foreign_id']=='') $m_arr['foreign_id']='100';
if($m_arr['yuanzhumin_id']=='') $m_arr['yuanzhumin_id']='9';

//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

if($type_id==$m_arr['foreign_id'])
{

//�w�q��O�N�X
$nationality=array(
"�w�D��"=>"020",
"���ԧB�p�X�j����"=>"784",
"���I��"=>"4",
"�w�a�d�Τڥ��F"=>"28",
"�^�ݦw�c��"=>"660",
"�����ڥ���"=>"8",
"�Ȭ�����"=>"51",
"���ݦw�a�C��"=>"530",
"�w����"=>"24",
"�n���w"=>"10",
"���ڧ�"=>"32",
"�����ļ���"=>"16",
"���a�Q"=>"40",
"�D�j�Q��"=>"36",
"���|��"=>"533",
"�����s�q"=>"248",
"�ȶ���M"=>"31",
"�i�h���Ȼ��������"=>"70",
"�i�h����"=>"70",
"�ڨ��h"=>"52",
"�s�[��"=>"50",
"��Q��"=>"56",
"���N�Ǫk��"=>"854",
"�O�[�Q��"=>"100",
"�ڪL"=>"48",
"�Z���a"=>"108",
"���n"=>"204",
"�ʼ}�F"=>"60",
"�Z�ܡF�Z�ܩM������"=>"96",
"�Z�ܩM������"=>"96",
"���Q����"=>"68",
"�ڦ�"=>"76",
"�ګ���"=>"44",
"����"=>"64",
"�i���S�q"=>"74",
"�i����"=>"72",
"�իXù��"=>"112",
"������"=>"84",
"�[���j"=>"124",
"�i�i���s�q"=>"166",
"��G���D�@�M��"=>"180",
"���D�F���D�@�M��"=>"140",
"��G�@�M��"=>"178",
"��h"=>"756",
"�H������"=>"384",
"��J�s�q"=>"184",
"�w�J�s�q"=>"184",
"���Q"=>"152",
"�س���"=>"120",
"����j��"=>"156",
"���ؤH���@�M��"=>"156",
"���ۤ��"=>"170",
"�����j���["=>"188",
"�j��"=>"192",
"���w��"=>"132",
"�t�Ϯq"=>"162",
"�ɴ��Ǵ�"=>"196",
"���J�F���J�@�M��"=>"203",
"�w��"=>"276",
"�N���a"=>"262",
"����"=>"208",
"�h�̥��J"=>"212",
"�h�����[�@�M��"=>"214",
"�h�����["=>"214",
"�����ΧQ��"=>"12",
"�̥ʦh"=>"218",
"�R�F����"=>"233",
"�J��"=>"818",
"�輻����"=>"732",
"�̧Q����"=>"232",
"��Z��"=>"724",
"������"=>"231",
"����"=>"246",
"����"=>"242",
"�֧J���s�q"=>"238",
"�K�Jù�����"=>"583",
"�K�Jù������p��"=>"583",
"�kù�s�q"=>"234",
"�k��"=>"250",
"�[�^"=>"266",
"�^��"=>"826",
"�j���C�A�P�_�R�����p�X����"=>"826",
"��稺�F"=>"308",
"��v��"=>"268",
"�k�ݦc�Ȩ�"=>"254",
"�ڦ�q"=>"831",
"�{��"=>"288",
"����ù��"=>"292",
"�泮��"=>"304",
"�̤��"=>"270",
"�X����"=>"324",
"�ʼw�|���q"=>"312",
"���D�X����"=>"226",
"��þ"=>"300",
"�n��v�ȤΫn��©_�s�q"=>"239",
"�ʦa����"=>"320",
"���q"=>"316",
"�X���Ȥ��"=>"624",
"�\�Ȩ�"=>"328",
"����"=>"344",
"���w�γ���Ҹs�q"=>"334",
"�����Դ�"=>"340",
"�Jù�J���"=>"191",
"���a"=>"332",
"�I���Q"=>"348",
"�L��"=>"360",
"�L�ץ����"=>"360",
"�R����"=>"372",
"�H��C"=>"376",
"�����q"=>"833",
"�L��"=>"356",
"�^�ݦL�׬v�a��"=>"86",
"��ԧJ"=>"368",
"���"=>"364",
"��ԥ촵���@�M��"=>"364",
"�B�q"=>"352",
"�q�j�Q"=>"380",
"�A��"=>"832",
"���R�["=>"388",
"����"=>"400",
"�饻"=>"392",
"�֨�"=>"404",
"�N���N��"=>"417",
"�Z�H�����"=>"116",
"�N���ڴ�"=>"296",
"����"=>"174",
"�t�J�����h�֤Υ�����"=>"659",
"�_��"=>"408",
"���A���D�D�q�H���@�M��"=>"408",
"����"=>"410",
"�j������"=>"410",
"�n��"=>"410",
"��¯S"=>"414",
"�}�Ҹs�q"=>"136",
"���ħJ"=>"398",
"�d��"=>"418",
"�d�H�����D�@�M��"=>"418",
"���ڹ�"=>"422",
"�t�S���"=>"662",
"�C�䴰���n"=>"438",
"�������d"=>"144",
"�����"=>"430",
"�����"=>"426",
"�߳��{"=>"440",
"�c�˳�"=>"442",
"�Բ����"=>"428",
"�Q���"=>"434",
"������"=>"504",
"���ǭ�"=>"492",
"�����h��"=>"498",
"�����h�˦@�M��"=>"498",
"�X�S����ù"=>"499",
"���F�[���["=>"450",
"���к��s�q"=>"584",
"����y"=>"807",
"���Q"=>"466",
"�q�l"=>"104",
"�X�j"=>"496",
"�X�j�a��"=>"496",
"�D��"=>"446",
"�_�����ȯǸs�q"=>"580",
"�k�ݰ��B���J"=>"474",
"�T�Q�𥧨�"=>"478",
"�X��ԯS�q"=>"500",
"�����L"=>"470",
"�Ҩ��贵"=>"480",
"�����a��"=>"462",
"���ԫ�"=>"454",
"�����"=>"484",
"���Ӧ��"=>"458",
"���T��J"=>"508",
"�Ǧ̤��"=>"516",
"�s�ب��h���Ȯq"=>"540",
"����"=>"562",
"�պ֧J�q"=>"574",
"�`�ΧQ��"=>"566",
"���[�ԥ�"=>"558",
"����"=>"528",
"����"=>"578",
"���y��"=>"524",
"�վ|"=>"520",
"�ë®q"=>"570",
"�îJ"=>"570",
"�æ���"=>"554",
"����"=>"512",
"�ڮ���"=>"591",
"���|"=>"604",
"�k�ݬ��������"=>"258",
"�ڥ��ȯôX����"=>"598",
"��߻�"=>"608",
"�ڰ򴵩Z"=>"586",
"�i��"=>"616",
"�t�ǤαK�ҭ۸s�q"=>"666",
"�֯S�d�q"=>"612",
"�i�h���U"=>"630",
"�ڰǴ��Z"=>"275",
"�����"=>"620",
"���["=>"585",
"�کԦc"=>"600",
"�d�F"=>"634",
"�d����"=>"638",
"ù������"=>"642",
"�뺸����"=>"688",
"�Xù��"=>"643",
"�Xù���p��"=>"643",
"�c�w�F"=>"646",
"�F�Q�a���ԧB"=>"682",
"��ù���s�q"=>"90",
"��u��"=>"690",
"Ĭ��"=>"736",
"���"=>"752",
"�s�[�Y"=>"702",
"�t���Ǯ��q"=>"654",
"����������"=>"705",
"���ˤڤΦy�֮q"=>"744",
"������J"=>"703",
"��l�s"=>"694",
"�t���Q��"=>"674",
"�뤺�[��"=>"686",
"�����Q��"=>"706",
"Ĭ�Q�n"=>"740",
"�t�h�����L���"=>"678",
"�ĺ��˦h"=>"222",
"�ԧQ��"=>"760",
"�ԧQ�Ȫ��ԧB�@�M��"=>"760",
"�v������"=>"748",
"�g�J���ζ}�촵�s�q"=>"796",
"�d�w"=>"148",
"�k�ݫn���ݦa"=>"260",
"�h��"=>"768",
"����"=>"764",
"��N�J"=>"762",
"���J�Ҹs�q"=>"772",
"�F�ҨZ"=>"626",
"�g�w��"=>"795",
"�𥧦��"=>"788",
"�F�["=>"776",
"�g�ը�"=>"792",
"�d���F�Φ��ڭ�"=>"780",
"�R�˾|"=>"798",
"�O�W"=>"158",
"���إ���"=>"158",
"�Z�|����"=>"834",
"�Z�|�����p�X�@�M��"=>"834",
"�Q�J��"=>"804",
"�Q�z�F"=>"800",
"������æ�p�q"=>"581",
"����"=>"840",
"���Q��X����"=>"840",
"�Q�Ԧc"=>"858",
"�Q���O�J"=>"860",
"�Ч�"=>"336",
"�t��ˤή�稺�B"=>"670",
"�e�����"=>"862",
"�^�ݺ����ʸs�q"=>"92",
"���ݺ����ʸs�q"=>"850",
"�V�n"=>"704",
"�U����"=>"548",
"�U�����P��𨺮q"=>"876",
"�ļ���"=>"882",
"����"=>"887",
"���ȯS"=>"175",
"�n�D"=>"710",
"�|���"=>"894",
"���ګ�"=>"716"
);



//���Ѫ����
$today=(date("Y")-1911).date("�~m��d��");


// ���X�Z�Ű}�C
//$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
//$class_base = class_base($curr_year_seme);




//���o�Юv�ҤW�~�šB�Z��
$session_tea_sn = $_SESSION['session_tea_sn'] ;
$query =" select class_num  from teacher_post  where teacher_sn  ='$session_tea_sn'  ";
$result =  $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query",256) ;
$row = $result->FetchRow() ;
$class_num = $row["class_num"];

$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];

if( checkid($SCRIPT_FILENAME,1) OR $class_num) {

//�Ĥ@���q----���Xstud_base�X�G���ǥ�
$type_select="SELECT a.*,left(a.curr_class_num,length(a.curr_class_num)-2) as class_id,right(a.curr_class_num,2) as num,b.* FROM stud_base a left join stud_domicile b ON a.student_sn=b.student_sn WHERE a.stud_study_cond=0 AND a.stud_kind like '%,$type_id,%'";
$type_select.=(!checkid($SCRIPT_FILENAME,1) AND $class_num<>'')?" AND curr_class_num like '$class_num%'":"";
$type_select.=" ORDER BY curr_class_num";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
//�Nstudent_sn�ন�}�C�r��
$select_sn='';
$select_id='';
$key_sn=array();

//���o�������Y�ѷ�
$family_kind=sfs_text("�a�x����");

while ($data=$recordSet->FetchRow()) {
          $select_sn.=$data['student_sn'].",";
		  $select_id.="'".$data['stud_id']."',";
		  $key_sn[$data['stud_id']]=$data['student_sn'];

          $stud_data[$data['student_sn']]['class_id']=$data['class_id'];
          $stud_data[$data['student_sn']]['stud_id']=$data['stud_id'];
          $stud_data[$data['student_sn']]['stud_name']=$data['stud_name'];
          $stud_data[$data['student_sn']]['stud_sex']=($data['stud_sex']==1)?"�k":"�k";
          $stud_data[$data['student_sn']]['stud_birthday']=$data['stud_birthday'];
          $stud_data[$data['student_sn']]['stud_person_id']=$data['stud_person_id'];
          $stud_data[$data['student_sn']]['stud_kind']=$data['stud_kind'];
          $stud_data[$data['student_sn']]['yuanzhumin']="�@��";
		  $stud_data[$data['student_sn']]['sse_family_kind']=$family_kind[$m_arr['default_family_kind']];


		  //�ѪR�����m��
		  $analy_arr=array("country"=>array("��","��"),"downtown"=>array("�m","��","��","��"));
		  $analy_add=array("addr_1"=>$data['stud_addr_1'],"addr_2"=>$data['stud_addr_2']);

		foreach($analy_add as $addr_key=>$addr_value){
		  foreach($analy_arr as $key=>$analy_item){
			foreach($analy_item as $value){
					$pos=strpos($addr_value,$value);
					if($pos) {
						$stud_data[$data['student_sn']][$addr_key][$key]=substr($addr_value,0,$pos+strlen($value));
						$addr_value=substr($addr_value,$pos+strlen($value));
						$stud_data[$data['student_sn']][$addr_key]['left']=$addr_value;
						break;
						}
				}
			}
			}

//echo "<PRE>";
//print_r($stud_data);
//echo "</PRE>";


          $stud_data[$data['student_sn']]['stud_addr_2']=$data['stud_addr_2'];
          $stud_data[$data['student_sn']]['stud_addr_a']=$data['stud_addr_a'];
          $stud_data[$data['student_sn']]['stud_addr_b']=$data['stud_addr_b'];
          $stud_data[$data['student_sn']]['stud_addr_c']=$data['stud_addr_c'];
          $stud_data[$data['student_sn']]['stud_addr_d']=$data['stud_addr_d'];
          $stud_data[$data['student_sn']]['stud_addr_e']=$data['stud_addr_e'];
          $stud_data[$data['student_sn']]['stud_addr_f']=$data['stud_addr_f'];
          $stud_data[$data['student_sn']]['stud_addr_g']=$data['stud_addr_g'];
          $stud_data[$data['student_sn']]['stud_addr_h']=$data['stud_addr_h'];
          $stud_data[$data['student_sn']]['stud_addr_i']=$data['stud_addr_i'];
          $stud_data[$data['student_sn']]['stud_addr_j']=$data['stud_addr_j'];
          $stud_data[$data['student_sn']]['stud_addr_k']=$data['stud_addr_k'];
          $stud_data[$data['student_sn']]['stud_addr_l']=$data['stud_addr_l'];
          $stud_data[$data['student_sn']]['stud_addr_m']=$data['stud_addr_m'];
          $stud_data[$data['student_sn']]['stud_tel_1']=$data['stud_tel_1'];
          $stud_data[$data['student_sn']]['stud_tel_2']=$data['stud_tel_2'];
          $stud_data[$data['student_sn']]['num']=$data['num'];
          $stud_data[$data['student_sn']]['fath_name']=$data['fath_name'];
          $stud_data[$data['student_sn']]['fath_alive']=$data['fath_alive'];
          $stud_data[$data['student_sn']]['moth_name']=$data['moth_name'];
          $stud_data[$data['student_sn']]['moth_alive']=$data['moth_alive'];
          $stud_data[$data['student_sn']]['guardian_name']=$data['guardian_name'];

          $guardian_relation=guardian_relation();
          $relation_code=$data['guardian_relation'];
          $stud_data[$data['student_sn']]['guardian_relation']=$guardian_relation[$relation_code];

          $stud_data[$data['student_sn']]['guardian_phone']=$data['guardian_phone'];
          $stud_data[$data['student_sn']]['guardian_hand_phone']=$data['guardian_hand_phone'];
          }
$select_sn=substr($select_sn,0,-1);
$select_id=substr($select_id,0,-1);

//�ĤG���q----���Xstud_subkind����
$type_select="SELECT * FROM stud_subkind WHERE type_id='$type_id' AND student_sn IN ($select_sn)";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

//�N��ƥ[�J$stud_data�}�C��
while ($data=$recordSet->FetchRow()) {
          $stud_data[$data['student_sn']]['clan']=$data['clan'];
          $stud_data[$data['student_sn']]['area']=$nationality[$data['area']];
          $stud_data[$data['student_sn']]['memo']=$data['memo'];
          $stud_data[$data['student_sn']]['note']=$data['note'];
          }

//3rd���q----���X�����ڸs
$type_select="SELECT * FROM stud_subkind WHERE type_id='".$m_arr['yuanzhumin_id']."' AND student_sn IN ($select_sn)";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
//�N��ƥ[�J$stud_data�}�C��
while ($data=$recordSet->FetchRow()) {
	$stud_data[$data['student_sn']]['yuanzhumin']=$data['clan'];
          }

//4th���q----���X���ݪ��A
$type_select="SELECT stud_id,sse_family_kind FROM stud_seme_eduh WHERE seme_year_seme='$curr_year_seme' AND stud_id IN ($select_id)";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
//�N��ƥ[�J$stud_data�}�C��
while ($data=$recordSet->FetchRow()) {
	$stud_data[$key_sn[$data['stud_id']]]['sse_family_kind']=$family_kind[$data['sse_family_kind']];
          }


################################    ��X XML    ##################################
$filename = $school_id.$school_short_name."�ǥͨ��� $class_num [ $type_id ] �M�U.XML";
$Str="<?xml version='1.0' encoding='UTF-8' ?>
<!DOCTYPE ���y�洫��� SYSTEM 'dtd_stu_1.dtd'>
<���y�洫���>\r\n";

$sn_data=explode(',',$select_sn);

foreach($sn_data as $sn)
{
$Str.="  <�ǥͰ򥻸��>
    <�ҷӸ��X>".$stud_data[$sn]['stud_person_id']."</�ҷӸ��X>
    <�ǥͩm�W>".$stud_data[$sn]['stud_name']."</�ǥͩm�W>
    <�ǥͩʧO>".$stud_data[$sn]['stud_sex']."</�ǥͩʧO>
    <�ǥͥͤ�>".$stud_data[$sn]['stud_birthday']."</�ǥͥͤ�>
    <�����O>".$stud_data[$sn]['yuanzhumin']."</�����O>
    <�Ш|��_�ǮեN��>".$SCHOOL_BASE['sch_id']."</�Ш|��_�ǮեN��>
    <�{�b�~��>".substr($stud_data[$sn]['class_id'],0,1)."</�{�b�~��>
    <�{�b�Z��>".substr($stud_data[$sn]['class_id'],1,2)."</�{�b�Z��>
    <���y�a�}_����>".$stud_data[$sn]['addr_1']['country']." </���y�a�}_����>
    <���y�a�}_�m����>".$stud_data[$sn]['addr_1']['downtown']."</���y�a�}_�m����>
    <���y�a�}>".$stud_data[$sn]['addr_1']['left']."</���y�a�}>
    <���y�q��>".$stud_data[$sn]['stud_tel_1']."</���y�q��>
    <�q�T�a�}_����>".$stud_data[$sn]['addr_2']['country']."</�q�T�a�}_����>
    <�q�T�a�}_�m����>".$stud_data[$sn]['addr_2']['downtown']."</�q�T�a�}_�m����>
    <�q�T�a�}>".$stud_data[$sn]['addr_2']['left']."</�q�T�a�}>
    <�q�T�q��>".$stud_data[$sn]['stud_tel_2']."</�q�T�q��>
    <���ݪ��A>".$stud_data[$sn]['sse_family_kind']."</���ݪ��A>
    <���@�H_�m�W>".$stud_data[$sn]['guardian_name']."</���@�H_�m�W>
    <���@�H_�s���q��>".$stud_data[$sn]['guardian_phone']."</���@�H_�s���q��>
    <���@�H_��ʹq��>".$stud_data[$sn]['guardian_hand_phone']."</���@�H_��ʹq��>
    <�P���@�H�����Y>".$stud_data[$sn]['guardian_relation']."</�P���@�H�����Y>
    <���Υ����~�y�H�h>".$stud_data[$sn]['clan']."</���Υ����~�y�H�h>
    <���Υ����y>".$stud_data[$sn]['area']."</���Υ����y>
    <���Υ��O�_���o���إ�����y>".$stud_data[$sn]['memo']."</���Υ��O�_���o���إ�����y>
  </�ǥͰ򥻸��>\r\n";
}
$Str.="</���y�洫���>";

$Str=iconv("Big5","UTF-8",$Str);


header("Content-type: application/xml");
header("Content-disposition: attachment; filename=$filename");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");

echo $Str;
} else { echo "\n<script language=\"Javascript\"> alert (\"�z�å��Q���v�ϥΦ��Ҳ�(�D�ɮv�μҲպ޲z��)�I\")</script>"; }
} else { echo "\n<script language=\"Javascript\"> alert (\"���ˬd�ܼƳ]�w!!�I\")</script>"; }
?>
