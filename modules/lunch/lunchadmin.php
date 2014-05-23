<?php

require "config.php";
sfs_check();

// �ˬd php.ini �O�_���} file_uploads ?
check_phpini_upload();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
}

// �}�l���
$begdate=($_GET['begdate']) ? $_GET['begdate'] : $_POST['begdate'];

$module_name=basename(dirname(__FILE__));
$base=$UPLOAD_PATH.$module_name.'/';
if (!file_exists($base)) @mkdir($base,0755);
$today_year = date("Y")-1911;
$url_base=$UPLOAD_URL.$module_name.'/';

// ���ѬP���X�A���o�g�@���   
$mday = date(  "w" );
if ($mday>0) $weekfirst = GetdayAdd(date("Y-m-d"),($mday-1)*-1);
	else $weekfirst = GetdayAdd(date("Y-m-d"),1);

// ���w�����g�P���@���
if ($begdate) {    
   $mday = date(  "w" ,StrToDate($begdate));
   $begdate = GetdayAdd($begdate,($mday-1)*-1);
}   
  
// �Y�����w�}�l����A�h���V�o�@�g
if ($begdate == 0)   $begdate = $weekfirst ;
// �o�g�����
$enddate = GetdayAdd($begdate ,$WEEK_DAYS-1); 
  
$nextweek = GetdayAdd($begdate , 7);   //�U�@�g
$prevweek = GetdayAdd($begdate , -7);	 //�e�@�g

//������
$supplier=$_REQUEST['supplier'];

if ($supplier and $_POST['Submit']) {
	//echo '<pre>';
	//print_r($_FILES);
	//echo '</pre>';
	foreach($_POST['content'] as $md=>$data){
		$pid=$data['pid'];
		$fdate=$data[date];
		if($pid){
			$sqlstr = "UPDATE lunchtb SET pdate='$data[date]',pMday='$md',pFood='$data[food]',pMenu='$data[menu]',pFruit='$data[fruit]',pPs='$data[ps]',pDesign='$supplier',pNutrition='$data[nutri]' WHERE pN='$pid'";
			$result = $CONN->Execute($sqlstr); 
			$myID=$pid;
		} else {
			$sqlstr = "insert into lunchtb(pdate,pMday,pFood,pMenu,pFruit,pPs,pDesign,pNutrition) values('$data[date]','$md','$data[food]','$data[menu]','$data[fruit]','$data[ps]','$supplier','$data[nutri]')" ;
			$result = $CONN->Execute($sqlstr); 
			$myID=$CONN->Insert_ID();		
		}		
		
		//�W�ǷӤ��B�z
		$path=$base.(substr($fdate,0,4)-1911);
		if (!file_exists($path)) @mkdir($path,0755);
		$new_file_path=$path."/";
		
		//�Ӥ�
		$new_file_name=$fdate."-".$myID.".jpg";			
		upload_lunch_file($_FILES[myfile], $md, $new_file_path, $new_file_name);
		
		//����X���
		$new_file_name=$fdate."-".$myID."-cer.jpg";
		upload_lunch_file($_FILES[certify], $md, $new_file_path, $new_file_name);
	}
	header("Location: lunch.php?begdate=$begdate");
//exit;
}


// �U�@�g �� �W�@�g ����}
$linknext = basename($_SERVER['PHP_SELF'])."?begdate=$nextweek&supplier=$supplier";
$linknow = basename($_SERVER['PHP_SELF'])."?begdate=$weekfirst&supplier=$supplier";
$linkprev = basename($_SERVER['PHP_SELF'])."?begdate=$prevweek&supplier=$supplier";
 
head("���\���еn��");

if(checkid($_SERVER['SCRIPT_FILENAME'],1))
{
	$Designer="<select name='supplier' onchange='this.form.submit();'><option></option>";
	foreach($DESIGN as $key=>$value){
		$selected=($value==$supplier)?'selected':'';
		$Designer.="<option value='$value'$selected>$value</option>";	
	}
	$Designer.="</select>";	
	$main.="<td>$Designer</td>";
	$main="<form method='post' enctype='multipart/form-data' action='$_SERVER[SCRIPT_NAME]'>
			<table><tr>
			<td>
			�����\����G".DtoCh($begdate)." ~ ".DtoCh($enddate)."�@<a href='$linkprev'> <img src='./images/prev.png' width=12 border=0 alt='�e�@�g' title='�e�@�g'></a>
			<a href='$linknow'><img src='./images/now.png' width=12 border=0 alt='���g' title='���g'></a>	
			<a href='$linknext'><img src='./images/next.png' width=12 border=0 alt='�U�@�g' title='�U�@�g'></a></td>
			<td>
			�@�@�@�����г]�p�̡G$Designer 
			<input type='hidden' name='begdate' value='$begdate'> <input type='submit' name='Submit' value='�n��'>
			<input type='reset' name='Submit2' value='���]'>
			</td>
			<td align='right'>�@�@<a href='lunch.php?begdate=$begdate'><img src='./images/view.png' alt='�^�s���Ҧ�' title='�^�s���Ҧ�' border=0 height=24></a></td>
			</tr></table>
			<table border='2' cellpadding='7' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>";
	if($supplier){
		//Ū����Ʈw
		$sqlstr="SELECT * FROM lunchtb WHERE pDesign='$supplier' AND pDate BETWEEN '$begdate' AND '$enddate'";
		$result=$CONN->Execute($sqlstr);
		unset($food);
		while($nb=$result->FetchRow()) {
			$md = $nb[pMday];			//���o�P���X
			$food[$md]["date"]= $nb[pDate];
			$food[$md]["food"]= $nb["pFood"];	//�D��
			$food[$md]["menu"]= $nb["pMenu"];	//���
			$food[$md]["fruit"]= $nb["pFruit"];	//���G
			$food[$md]["ps"]= $nb["pPs"];		//�Ƶ�
			$food[$md]["design"]= $nb["pDesign"];	//�]�p��
			$food[$md]["pid"]= $nb["pN"];	//���޸�
			$food[$md]["nutri"]= $nb["pNutrition"];	//��i����
			$food[$md]["photo"]=$nb[pDate]."-".$nb[pN].".jpg";  //��l��	
		   $food[$md]["s_photo"]="s-".$food[$md]["photo"];  //�Y��	   
		   $food[$md]["certify"]=$nb[pDate]."-".$nb[pN]."-cer.jpg";  //��l��	
		   $food[$md]["s_certify"]="s-".$food[$md]["certify"];  //�Y��	  
			if($nb["pDesign"]!=""){
				$WeekDesign=$nb["pDesign"];
			}
		}

		$main.="<tr bgcolor='#FFFFCC' align='center'><td>���@�@��</td>";
		//for ($i=1;$i<=$WEEK_DAYS; $i++) {
		//	$main .="<td>�P��".$WEEK_DATE[$i-1]."</td>";
		//}
		for ($md=1 ; $md<=$WEEK_DAYS ;$md++) {
			 $my_date=$food[$md]["date"]?"<br>( ".substr($food[$md]["date"],-5)." )":'';
			 $main .= " <td width='18%'>�P��".$WEEK_DATE[$md-1]."$my_date</td>" ;
		}
		$main .= "</tr>";

		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>�D�@�@��</td>";
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<td><input type='text' name='content[$md][food]' size='$INPUT_SIZE' value='".$food[$md]['food']."'></td>";
		}
		$main .= "</tr>";
		
		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>��@�@��</td>";
		for($md=1; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<td><textarea name='content[$md][menu]' rows='$TEXTAREA_ROWS_SIZE' cols='".$TEXTAREA_COLS_SIZE."'>".$food[$md]['menu']."</textarea></td>";
		}
		$main .= "</tr>";

		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>���@�@�G</td>";
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<td><input type='text' name='content[$md][fruit]' size=$INPUT_SIZE' value='".$food[$md]['fruit']."'></td>";
		}
		$main .= "</tr>";

		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>��i����</td>";
		for($md=1; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<td><textarea name='content[$md][nutri]' rows='$TEXTAREA_ROWS_SIZE' cols='".$TEXTAREA_COLS_SIZE."'>".$food[$md]['nutri']."</textarea></td>";
		}
		$main .= "</tr>";

		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>�ơ@�@��</td>";
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<td><input type='text' name='content[$md][ps]' size='$INPUT_SIZE' value='".$food[$md]['ps']."'></td>";
		}
		$main .= "</tr>";

		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>�ӡ@�@��</td>";
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$photo_url=$url_base.(substr($food[$md][photo],0,4)-1911);				
			$show_photo=$photo_url.'/'.$food[$md]['s_photo'];	
				$link_photo=$photo_url.'/'.$food[$md]['photo'];						
			$s_photo=$base.(substr($food[$md][photo],0,4)-1911).'/'.$food[$md]['s_photo'];
				$link_s_photo=$base.(substr($food[$md][photo],0,4)-1911).'/'.$food[$md]['photo'];
			if (file_exists($s_photo) && is_file($s_photo)){
				$my_photo= "<a href='$link_photo' target='_BLANK'><img src='$show_photo' border=0></a><br>" ;
			} else $my_photo='';
			$main .= "<td>$my_photo<input type='file' name='myfile[$md]' size='11' ></td>";
		}
		$main .= "</tr>";
		
		$main .= "<tr bgcolor='#FFFFFF' align='center'><td bgcolor='#DDFFDD'>�����ҩ�</td>";
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$certify_url=$url_base.(substr($food[$md][certify],0,4)-1911);				
			$show_certify=$certify_url.'/'.$food[$md]['s_certify'];	
				$link_certify=$certify_url.'/'.$food[$md]['certify'];						
			$s_certify=$base.(substr($food[$md][certify],0,4)-1911).'/'.$food[$md]['s_certify'];
				$link_s_certify=$base.(substr($food[$md][certify],0,4)-1911).'/'.$food[$md]['certify'];
			if (file_exists($s_certify) && is_file($s_certify)){
				$my_certify= "<a href='$link_certify' target='_BLANK'><img src='$show_certify' border=0></a><br>" ;
			} else $my_certify='';
			$main .= "<td>$my_certify<input type='file' name='certify[$md]' size='11' ></td>";
		}
		$main .= "</tr>";

		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$main .= "<input type='hidden' name='content[$md][pid]' value='".$food[$md]['pid']."'>";
		}
		
		for($md=1 ; $md<=$WEEK_DAYS ; $md++) {
			$mydate=$food[$md]['date']?$food[$md]['date']:GetdayAdd($begdate,$md-1);  //���\����P�w
			$main .= "<input type='hidden' name='content[$md][date]' value='$mydate'>";
		}

	} else $main.="<tr><td align='center'><font size=3 color='brown'>�Х���ܭ��г]�p�̡I</font></td></tr>";
	$main.="</table><p><font style='font-size:12px' color='blue'>���Ӥ��ȯ�W��JPG�榡�A�e�q�б���b1MB�H�U�C</font></p></form>";
	echo $main;
} else echo "<center><font size=5 color='red'><BR><BR>�z�����޲z�v���A�L�k�s�W�έק�I</font></center>";
	
foot();


function upload_lunch_file($myfile, $k, $new_file_path, $new_file_name){

	if($myfile[error][$k]==1){
		error_die('�ɮפj�p�W�X php.ini:upload_max_filesize ����C');
		//die('�W�Ǫ��Ӥ��e�q�L�j');
	}elseif($myfile[error][$k]==2){
		error_die('�ɮפj�p�W�X MAX_FILE_SIZE ����C');
	}elseif($myfile[error][$k]==3){
		error_die('�ɮ׶ȳQ�����W�ǡC');
	}

	$new_file=$new_file_path.$new_file_name;  //��l��
	$s_new_file=$new_file_path.'s-'.$new_file_name;  //�Y��	
	if (is_uploaded_file($myfile[tmp_name][$k]) AND $myfile[error][$k]==0 and $myfile[size][$k]>0){
		if (file_exists($new_file) and is_file($new_file)) {
			//echo "�R��<br> ";
			unlink($new_file);
		}
		@move_uploaded_file($myfile[tmp_name][$k],$new_file);
		ImageResize($new_file, $s_new_file);
	}

}

function ImageResize($from_filename, $save_filename, $in_width=160, $in_height=120, $quality=100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    // ���o�Y�b���d�򤺪����
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);

    $image = imagecreatefromjpeg($from_filename);

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagejpeg($image_new, $save_filename, $quality);
}

function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, �p�G����w�p�Y�Ϫ��p�N�����Y
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}
  
?>