<?php

// $Id: lunch.php 7773 2013-11-18 08:40:00Z infodaes $

//************************************ 
//  ���\���Ф��G
//  by �L�±�
// �L�±Ӫ��b�I�ߤu�@�{
//  http://sy3es.tnc.edu.tw/~prolin
//  89/9/17   ver:0.3
//************************************

require "config.php" ;

$begdate=$_GET['begdate'];
$PHP_SELF = basename($_SERVER['PHP_SELF']) ;
$module_name=basename(dirname(__FILE__));
$url_base=$UPLOAD_URL.$module_name.'/';
$base=$UPLOAD_PATH.$module_name.'/';
$today_year = date("Y")-1911;


//���ѬP���X�A���o�P�@���   
$mday = date("w" );

if ($mday>0) {
	$weekfirst = GetdayAdd(date("Y-m-d"),($mday-1)*-1);
} else {
	$weekfirst = GetdayAdd(date("Y-m-d"),1);
}

if ($begdate) {    //�b���P�ΤU�P
   $mday = date(  "w" ,StrToDate($begdate));
   $begdate = GetdayAdd($begdate,($mday-1)*-1);   	//���w�����P�P���@���
}   
  
if ($begdate == 0)   $begdate = $weekfirst ;		//�����w�A���V�o�@�P
$enddate = GetdayAdd($begdate ,$WEEK_DAYS-1); 	 //�o�P����� 
  

if ($_GET["m"]) {   //�����
  $nextweek = GetMonthAdd($begdate , 1);   //�U��
  $prevweek = GetMonthAdd($begdate , -1);	 //�W��
  $linknext = "<a href='$PHP_SELF?begdate=$nextweek&m=1'><img src='./images/next.png' width=12 border=0 alt='����' title='����'></a>";
  $linknow = "<a href='$PHP_SELF?begdate=$weekfirst&m=1'><img src='./images/now.png' width=12 border=0 alt='����' title='����'></a>";
  $linkprev = "<a href='$PHP_SELF?begdate=$prevweek&m=1'><img src='./images/prev.png' width=12 border=0 alt='�W��' title='�W��'></a>";
  
} else {
  $nextweek = GetdayAdd($begdate , 7);   //�U�P�@
  $prevweek = GetdayAdd($begdate , -7);	 //�e�@�P	
  $linknext = "<a href='$PHP_SELF?begdate=$nextweek'><img src='./images/next.png' width=12 border=0 alt='�U�@�g' title='�U�@�g'></a>" ;
  $linknow = "<a href='$PHP_SELF?begdate=$weekfirst'><img src='./images/now.png' width=12 border=0 alt='���g' title='���g'></a>";
  $linkprev = "<a href='$PHP_SELF?begdate=$prevweek'><img src='./images/prev.png' width=12 border=0 alt='�e�@�g' title='�e�@�g'></a>" ;
}
  
//�O�_���W�ߪ��ɭ�
if ($IS_STANDALONE)
	include "header.php";
else
	head("���\����");
   
if ($_GET["m"]) {
	$mode="<a href='$PHP_SELF?m=0'><img src='./images/week.png' width=16 border=0 alt='�����ܶg��ܼҦ�' title='�����ܶg��ܼҦ�'></a>";
	$mday = substr($begdate,0,7);
	$filter = "WHERE pDate like '$mday%'";
} else {
	$mode.="<a href='$PHP_SELF?m=1'><img src='./images/month.png' width=16 border=0 alt='�����ܤ���ܼҦ�' title='�����ܤ���ܼҦ�'></a>";
	$filter = "WHERE pDate between '$begdate' and '$enddate'";
	$mday=DtoCh($begdate)." ~ ".DtoCh($enddate);
}

//$title = "<center>$show_week_str</center>";
$title="<table style='font-size: $font_size;' width=100%><tr><td align='right'>������G<font color='blue'>$mday</font> �@ $linkprev $linknow $linknext �@ $mode</td></tr></table>";
echo $title ;

//����w�}�C���t��
$sqlstr= "SELECT DISTINCT pDesign FROM lunchtb $filter";
$rs = $CONN->Execute($sqlstr);
$DESIGN=array();
while(!$rs->EOF) {
	$DESIGN[]=$rs->fields[0];
	$rs->MoveNext();
}

if (count($DESIGN)<=1 ) //�A�X�ª��B��@���]�p
   show_lunch_table() ;
else {   		//��a�H�W
   for($j=0; $j<count($DESIGN); $j++){ 
      show_lunch_table($DESIGN[$j]) ;	
   }	
}

function show_lunch_table($DESIGN="") {
	global $begdate,$enddate, $WEEK_DAYS ,$WEEK_DATE ,$CONN, $base,$url_base,$linkprev,$linknow,$linknext,$font_size,$column_bgcolor_m,$column_bgcolor_w;
	if($_GET["m"]) { //���
		$mday = substr($begdate,0,7);
		$sqlstr = "SELECT * FROM lunchtb WHERE pDate like '$mday%'" ;   	
		if($DESIGN) $sqlstr .= " and pDesign='$DESIGN'" ;
		$sqlstr .= " order by pDate " ;

		$result = $CONN->Execute($sqlstr) ;
		if($result) {
			while ($nb=$result->FetchRow()) {
				$md = $nb[pMday];			//���o�P���X

				$pMenu= nl2br($nb[pMenu]);	//���
				$pNutri= nl2br($nb[pNutrition]);	//��i����
				$food["photo"]=$nb[pDate]."-".$nb[pN].".jpg";  //��l��	
				$food["s_photo"]="s-".$food["photo"];  //�Y��

				if ($md ==1) 
					$tr_c = " bgcolor='#EEEEEE' " ;
				else  
					$tr_c = " " ;   
				
				//$show_photo=$photo_url.'/'.$food['s_photo'];
				$photo_url=$url_base.(substr($nb[pDate],0,4)-1911);
				$show_photo=$photo_url.'/'.$food['s_photo'];
				
				//	$s_photo=$photo_path.'/'.$food['s_photo'];
				$s_photo=$base.(substr($nb[pDate],0,4)-1911).'/'.$food['s_photo'];;
				
				if (file_exists($s_photo) && is_file($s_photo)){
					$my_photo= '<img src="'.$show_photo .'">'. "" ;
				}	
				
				//�X���ҩ�
				$certify_url=$url_base.(substr($nb[pDate],0,4)-1911);
				$show_certify=$certify_url.'/'.$food['s_certify'];
				
				//	$s_certify=$certify_path.'/'.$food['s_certify'];
				$s_certify=$base.(substr($nb[pDate],0,4)-1911).'/'.$food['s_certify'];;
				
				if (file_exists($s_certify) && is_file($s_certify)){
					$my_certify= '<img src="'.$show_certify .'">'. "" ;
				}
				
				
				if ($nb[pFood]) {
					$main .= "<tr $tr_c ><td>$nb[pDate]</td><td align='center'>$md</td><td>$nb[pFood]</td><td>$pMenu</td><td>$nb[pFruit]</td><td>$pNutri</td><td>$nb[ps]</td><td>$my_photo</td><td>$my_certify</td>";
					$main .= "<tr> " ;
				}
				unset($food);
				unset($my_photo);
			}
			$main = "�����г]�p�̡G<font color=blue><b>$DESIGN</b></font></u></b>
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size: $font_size;' bordercolor='#111111' id='AutoNumber1'>
				<tr bgcolor='$column_bgcolor_m' align='center'><td>���</td><td>�P��</td><td>�D��</td><td>���</td><td>���G</td><td>��i����</td><td>�Ƶ�</td><td>�Ӥ�</td><td>����X���ҩ�</td></tr> 
					$main</table><br>" ;
		}	

    } else { //�g
		//Ū����Ʈw
		$sqlstr = "SELECT * FROM lunchtb WHERE pDate between '$begdate' and '$enddate'";
		if($DESIGN) $sqlstr.=" and pDesign = '$DESIGN' ";
		$result = $CONN->Execute($sqlstr) ;
		if($result) {
			while ($nb=$result->FetchRow()) {
			   $md = $nb[pMday];			//���o�P���X
			   $food[$md]["date"]= $nb[pDate];
			   $food[$md]["food"]= $nb[pFood];	//�D��
			   $food[$md]["menu"]= $nb[pMenu];	//���
			   $food[$md]["fruit"]= $nb[pFruit];	//���G
			   $food[$md]["ps"]= $nb[pPs];		//�Ƶ�
			   $food[$md]["design"]= $nb[pDesign];	//�]�p��
			   $food[$md]["nutri"]= $nb[pNutrition];	//��i����
			   $food[$md]["photo"]=$nb[pDate]."-".$nb[pN].".jpg";  //��l��	
			   $food[$md]["s_photo"]="s-".$food[$md]["photo"];  //�Y��	   
			   $food[$md]["certify"]=$nb[pDate]."-".$nb[pN]."-cer.jpg";  //��l��	
			   $food[$md]["s_certify"]="s-".$food[$md]["certify"];  //�Y��	   
			}
			
				
				//�ˬd���L�޲z�v��
				if(checkid($_SERVER['SCRIPT_FILENAME'],1)) $is_admin_link="<a href='lunchadmin.php?begdate=".$begdate."&supplier=".$food[$md]['design']."'><img src='./images/admin.png' alt='�޲z' title='�޲z' width=16 border=0></a>"; else $is_admin_link='';
				//�C�X���Ъ��
				$main = "�����г]�p�̡G<font color=blue><b>".$food[$md]['design']."</b> $is_admin_link</font></u></b>";
				$main .= "<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size: $font_size;' bordercolor='#111111' id='AutoNumber1' width='100%'>
							<tr bgcolor='$column_bgcolor_w' align='center'> 
								<td class='td_sboady1' align='center'>���@�@��</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
					 $my_date=$food[$md]["date"]?"<br>( ".substr($food[$md]["date"],-5)." )":'';
					 $main .= " <td width='18%'>�P��".$WEEK_DATE[$md-1]."$my_date</td>" ;
				}

				$main .= "</tr>";
				$main .= "<tr align='center'>"; 
				$main .= "<td>�D�@�@��</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						if ($food[$md]["food"]) $main .= "<td>" . $food[$md]["food"] . "</td>" ;
						else $main .= "<td>&nbsp;</td>" ;
				}

				$main .= "</tr>";
				$main .= "<tr align='center'>"; 
				$main .= "<td>��@�@��</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						if ($food[$md]["menu"]) $main .= "<td>". nl2br($food[$md]['menu']) ."</td>" ;
						else $main .= "<td>&nbsp;</td>" ;
				}

				$main .= "</tr>";
				$main .= "<tr align='center'>"; 
				$main .= "<td>���@�@�G</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						if ($food[$md]["fruit"]) $main .= "<td>" . $food[$md]['fruit']. "</td>" ;
						else $main .= "<td>&nbsp;</td>" ;
				}

				$main .= "</tr>";

				$main .= "<tr align='center'>"; 
				$main .= "<td>��i����</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						if ($food[$md]["nutri"]) $main .= "<td>". nl2br($food[$md]['nutri']) ."</td>" ;
						else $main .= "<td>&nbsp;</td>" ;
				}

				$main .= "</tr>";
				$main .= "<tr align='center'>"; 
				$main .= "<td>�ӡ@�@��</td>";
				
				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						$main .= "<td>&nbsp;";					
						$photo_url=$url_base.(substr($food[$md][photo],0,4)-1911);				
						$show_photo=$photo_url.'/'.$food[$md]['s_photo'];	
							$link_photo=$photo_url.'/'.$food[$md]['photo'];						
						$s_photo=$base.(substr($food[$md][photo],0,4)-1911).'/'.$food[$md]['s_photo'];
							$link_s_photo=$base.(substr($food[$md][photo],0,4)-1911).'/'.$food[$md]['photo'];
						if (file_exists($s_photo) && is_file($s_photo)){
							$main .= "<a href='$link_photo' target={$md}_photo><img src='$show_photo' border=0></a>" ;
						}
						$main .= "</td>" ;
				}
				$main .= "</tr>";

				
				$main .= "<tr align='center'>"; 
				$main .= "<td>�����ҩ�</td>";
				
				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						$main .= "<td>&nbsp;";
						
						$certify_url=$url_base.(substr($food[$md]['certify'],0,4)-1911);				
						$show_certify=$certify_url.'/'.$food[$md]['s_certify'];
							$link_certify=$photo_url.'/'.$food[$md]['certify'];		
						$s_certify=$base.(substr($food[$md][certify],0,4)-1911).'/'.$food[$md]['s_certify'];
							$link_s_certify=$base.(substr($food[$md][certify],0,4)-1911).'/'.$food[$md]['certify'];
						if (file_exists($s_certify) && is_file($s_certify)){
							$main .= "<a href='$link_certify' target={$md}_certify><img src='$show_certify' border=0></a>" ;
						}
						$main .= "</td>" ;
				}
				$main .= "</tr>";
				
				$main .= "<tr align='center'>"; 
				$main .= "<td>�ơ@�@��</td>";

				for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
						if ($food[$md]["ps"]) $main.="<td>".$food[$md]['ps']."</td>";
						else $main .= "<td>&nbsp;</td>" ;
				}
				$main .= "</tr>";

				$main .= "</table><p>";
			}
		}	
		echo $main;	
}


?>
