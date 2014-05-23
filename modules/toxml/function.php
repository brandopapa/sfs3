<?php
// $Id: function.php 5310 2009-01-10 07:57:56Z hami $

function check_IE () {
	return strstr(getenv("HTTP_USER_AGENT"), 'MSIE')?true:false;
}

function xml_header () {
}

// ���Ҿ��y XML ��
// INPUT: XML �W�ǼȦs��
// RETURN: ���絲�G�r��
function validate_xml($tmpfile) {
	$phpver=explode(".",phpversion());
	//PHP5�ϥΨ禡
	if ($phpver[0]==5) {
		$dom = new DOMDocument();
		$dom->load($tmpfile);
		$mesg=($dom->validate())?"���ҥ��T�I�i�H�i��פJ�u�@":"��RXML�o�Ϳ��~";
		return $mesg;
	} else {
		//�ˬd�O�_��dtd
		if(check_dtd($tmpfile)){
			//��l�ƭ�R���A���w�s�X�覡��UTF-8
			$xml_parser = xml_parser_create("UTF-8");
			//�}���ɮ�
			if (!($fp = fopen($tmpfile, "r"))) {
				return $mesg.="�L�k�}�� $tmpfile �I<br>";
			}
			//Ū�J�ɮסA�í�RXML
			while ($data = fread($fp, 4096)) {
				//XML���~�ɳB�z
				if (!xml_parse($xml_parser, $data, feof($fp))) {
					//���~����ܪ��T��
					$mesg.=sprintf("XML Error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser));
				}
				if($mesg) return $mesg;
			}
			//dom����
			if (!$dom = xmldocfile($tmpfile)) {
				return $mesg.="��RXML�o�Ϳ��~<br>";
			} else {
				//�i��DTD����
				$tmpfile=EscapeShellCmd($tmpfile);
				exec("xmllint --valid --noout $tmpfile 2>&1" , $err );
				if(is_array($err)) $err_str=implode("",$err);
				if($err_str) 
					return iconv("UTF-8","Big5",$err_str);
				else 
					return "���ҥ��T�I�i�H�i��פJ�u�@";
			} 
			//�B�z�����òM���O����
			xml_parser_free($xml_parser);
		}else{
			return $mesg="��󤤥��t��student_call-2_0.dtd��ơI";
		}
	}
}

// �ˬd�W��XML�ɤ��O�_���X�k����󫬺A�ŧi
// INPUT: XML �W�ǼȦs��
// RETURN: 1 ��, 0 �S��
function check_dtd($tmpfile) {
  $hfile=fopen($tmpfile, "r") or trigger_error("�}�� $tmpfile ���~�A���ˬd $tmpfile �O�_��Ū���v?", E_USER_ERROR);
  while ($data=fgets($hfile, 1024)) {
    $rs=ereg("\<!DOCTYPE .+ SYSTEM \"student_call\-2_0\.dtd\"\>", $data);
    if ($rs) { fclose($hfile); return 1; }
  }
  fclose($hfile);
  return 0;
}
?>
