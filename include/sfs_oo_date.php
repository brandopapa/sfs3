<?php

// $Id: sfs_oo_date.php 5310 2009-01-10 07:57:56Z hami $
// ���N date_class.php

class date_class {
var $formname="dateform";
var $demo = "1975-5-1";
var $date_arr = array(); //�ˬd����}�C

function date_class ($formname='') {
	if ($formname<>'')
		$this->formname = $formname;
}

function date_add($item_name,$value='',$can_be_null=0)  { //�s�W����ˬd
	$this->date_arr[]=$item_name;
	//$this->can_be_null[]=$can_be_null;
	
	$res = "<input type='hidden' name='$item_name'> \n";
	$res .= "<input type='hidden' name='flag_$item_name' value='$can_be_null'> \n";
	$res .= "���� <input type=\"text\" size=\"8\" maxlength=\"10\" name=\"temp_$item_name\" value=\"";
	if ($value)
		$res .=$this->DtoCh($value);
	$res .="\">";
	if ($this->demo!='none')
		$res .="(��:".$this->DtoCh($this->demo).")";
	return $res;
}

function DtoTw($dday="", $st="-") {
 if (!$dday) //�ϥιw�]���
  $dday = date("Y-m-j");
  //��褸����אּ������  $st�����j�Ÿ�
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	$d[0] = $d[0] - 1911 ;

	$cday = $d[0]."�~".$d[1]."��".$d[2]."��" ;
	return $cday ;
}


function DtoCh($dday="", $st="-") {
  if (!$dday) //�ϥιw�]���
  $dday = date("Y-m-j");
  //��褸����אּ������  $st�����j�Ÿ�
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	$d[0] = $d[0] - 1911 ;

	$cday = $d[0]."-".$d[1]."-".$d[2] ;
	return $cday ;
}

function ChtoD($dday, $st="-") {
  //��������אּ�褸���  $st�����j�Ÿ�
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	$d[0] = $d[0] + 1911 ;

	$cday = $d[0]."-".$d[1]."-".$d[2] ;
	return $cday ;
}

function Getday($dday ,$st="-") {
  //��褸��������o���  $st�����j�Ÿ�
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
  //$d[0] = $d[0] - 1911 ;

  //�ର�Ʀr�Ǧ^
	return intval($d[2]) ;	
}	

function GetdayAdd($dday ,$dayn,$st="-") {
  //������[����
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	return date("Y-m-d",mktime(0,0,0,$d[1],$d[2] + $dayn,$d[0])) ;
}

function GetMonthAdd($dday ,$monthn,$st="-") {
  //������[���
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}  
	return date("Y-m-d",mktime(0,0,0,$d[1]+$monthn,$d[2] ,$d[0])) ;
}

function GetYearAdd($dday ,$yearn,$st="-") {
  //������[��~
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}  
	return date("Y-m-d",mktime(0,0,0,$d[1],$d[2] ,$d[0]+$yearn)) ;
}

function StrToDate($dday ,$st="-") {
  //�r��榡�ର����榡
	$tok = strtok($dday,$st) ;
	$i = 0 ;
	while ($tok) {
		$d[$i] =$tok ;
		$tok = strtok($st) ;
		$i = $i+1 ;
	}
	return mktime(0,0,0,$d[1],$d[2] ,$d[0]+$yearn) ;
}

function date_javascript() {
?>

<script language="JavaScript">
function twToDate(DateString,Dilimeter)
{
if (DateString==null) return false;
if (Dilimeter=='' || Dilimeter==null)
Dilimeter = '-';
var tempArray;
var tempa=0;	
var ttt ;
tempArray = DateString.split(Dilimeter);
tempa = parseInt(tempArray[0])+1911;	
ttt = tempa.toString();
ttt = ttt+Dilimeter+tempArray[1]+Dilimeter+tempArray[2];	
return  ttt;	
}

function IsDate(DateString , Dilimeter)
{
if (DateString==null) return false;
if (Dilimeter=='' || Dilimeter==null)
Dilimeter = '-';
var tempy='';
var tempm='';
var tempd='';
var mm=0;
var tempArray;
if (DateString.length<8 && DateString.length>10)
return false; 
tempArray = DateString.split(Dilimeter);
if (tempArray.length!=3)
return false;
if (tempArray[0].length==4)
{
tempy = tempArray[0];
tempd = tempArray[2];
}
else
{
tempy = tempArray[2];
tempd = tempArray[1];
}
tempm = tempArray[1];
if((tempm.length==2)&&(tempm.substring(0,1)=='0'))
tempm = tempm.substring(2,1);
if((tempd.length==2)&& (tempd.substring(0,1)=='0'))
tempd = tempd.substring(2,1);
var tDateString = tempy + '/'+tempm.toString() + '/'+tempd.toString()+' 8:0:0';
var tempDate = new Date(tDateString);
if (isNaN(tempDate))
return false;
if (((tempDate.getUTCFullYear()).toString()==tempy) && (tempDate.getMonth()==parseInt(tempm)-1) && (tempDate.getDate()==parseInt(tempd)))
{
return true;
}
else
{
return false;
}
}

//-->
</script>
<?php
}

function do_check(){
?>
<script language="JavaScript">
function date_check()
{
	var OK=true;	
	var chk_date='';	
<?php
for($i=0 ;$i<count($this->date_arr);$i++) {
	//if($this->can_be_null[$i]==1 and =="") $go_check=false;	
//echo "alert('".$this->can_be_null[$i]."');";
//echo "if(chk_date=='NaN-undefined-undefined') { $chk_date='NULL'; }";
//echo "alert(chk_date);";
	//echo "	   alert('birthday_value='+document.".$this->formname.".".$this->date_arr[$i].".value + '\\n '); \n";
	//echo "	   alert(document.".$this->formname.".flag_".$this->date_arr[$i].".value + '\\n '); \n";
	
	echo "if(document.".$this->formname.".flag_".$this->date_arr[$i].".value==1 && document.".$this->formname.".temp_".$this->date_arr[$i].".value=='') { \n";
	echo "  } else { \n";
	//echo "  alert('���L����ˬd'); } else { \n";
	echo "	chk_date = twToDate(document.".$this->formname.".temp_".$this->date_arr[$i].".value,'-');\n";	
//echo "  alert('chk_date ='+chk_date); \n";
	echo "  if(IsDate(chk_date)){ \n";
//echo "  alert(document.".$this->formname.".".$this->date_arr[$i].".value); \n";
//echo "  alert('����ˬd�q�L!'); \n";	
	echo "	   document.".$this->formname.".".$this->date_arr[$i].".value = chk_date; \n";
//echo "  alert('�g�J�᪺��:'+document.".$this->formname.".".$this->date_arr[$i].".value); \n";
	echo "} else {\n";
	echo "	   alert(document.".$this->formname.".temp_".$this->date_arr[$i].".value + '\\n ���O���T�����'); \n";
	echo "     document.".$this->formname.".temp_".$this->date_arr[$i].".focus();\n";
	echo "	   OK=false; }	\n";
	echo "}	\n";
	
}

?>
return OK;
}
//-->
</script>
<?php	
}

}
?>
