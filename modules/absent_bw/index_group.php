<?php

// $Id: index.php 7731 2013-10-29 05:45:26Z smallduh $

/* ���o�]�w�� */
include_once "config.php";

sfs_check();

$sel_year=curr_year();
$sel_seme=curr_seme();
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
$SAVE_INFO=array();
$SAVE_INFO[0]=$SAVE_INFO[1]=$SAVE_INFO[2]=0;
$INFO="";
if ($_POST['act']=='�x�s�n�O') {
	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
	//exit(); 
	
  foreach ($_POST['selected_students'] as $student_sn) {
  	//���o�Z�šA�榡�Ʀ� class_id , ���o�@stud_id , �A�Q�� add_one �禡�s�J
  	$query="select a.seme_class,a.seme_num,b.stud_id,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.student_sn=b.student_sn and a.student_sn='$student_sn'";
  	$res=$CONN->Execute($query) or die ("SQL �o�Ϳ��~! ".$query);
  	$row=$res->FetchRow();
    //print_r($row);	
  	//$class_id�榡102_1_07_15 (102�~��1�Ǵ�7�~15�Z)
  	$class_id=sprintf('%03d_%d_%02d_%02d',$sel_year,$sel_seme,substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	add_one($sel_year,$sel_seme,$class_id,$row['stud_id'],$_POST[s]);	
	}	
	$INFO="�ާ@��T�G".date("Y-m-d H:i:s")."�ǤJ ".$SAVE_INFO[0]." �����, ���\�x�s ".$SAVE_INFO[1]." ��, �t�� ".$SAVE_INFO[2]." ������.�@�Y�ݭק�A�ЧQ�Ρu���m�ҵn�O�v�\��C";  
}


if(!empty($_REQUEST[this_date])){
        $d=explode("-",$_REQUEST[this_date]);
}else{
        $d=explode("-",date("Y-m-d"));
}
$year=(empty($_REQUEST[year]))?$d[0]:$_REQUEST[year];
$month=(empty($_REQUEST[month]))?$d[1]:$_REQUEST[month];
$day=(empty($_REQUEST[day]))?$d[2]:$_REQUEST[day];

$cal = new MyCalendar;
$cal->setStartDay(1);
$cal->getDateLink();
$mc=$cal->getMonthView($month,$year,$day);
  $the_cal="
   <table cellspacing='1' cellpadding='2' bgcolor='#E2ECFC' class='small'>
       <tr bgcolor='#FEFBDA'>
         <td align='center'>
           <a href='$_SERVER[SCRIPT_NAME]?act=$_REQUEST[act]&this_day=$today&class_id=$class_id' class='box'><img src='".$SFS_PATH_HTML."images/today.png' alt='�^�줵��' width='16' height='16' hspace='2' border='0' align='absmiddle'>�^�줵��</a>
         </td></tr>
         <tr bgcolor='#FFFFFF'><td>$mc</td></tr>
    </table>";

$act=$_REQUEST[act];



//�q�X����
head("����n�O");
$tool_bar=&make_menu($school_menu_p);

        for ($j=1;$j<=6;$j++)
        $js.="
		function disableall_cb_".$j."() {
			var uf=document.myform.include_uf.checked;
			var df=document.myform.include_df.checked;
			var max_i=document.myform.cb_".$j.".length;
			if (uf & df) {
			  for (i=0;i<max_i;i++) {
			    document.myform.cb_".$j."[i].checked=false;
			    document.myform.cb_".$j."[i].disabled=true;
			  }
			} else {
				if (uf) document.myform.cb_".$j."[0].checked=!document.myform.cb_".$j."[0].checked;
				if (df) document.myform.cb_".$j."[(max_i-1)].checked=!document.myform.cb_".$j."[(max_i-1)].checked;
			  for (i=1;i<(max_i-1);i++) {
			    document.myform.cb_".$j."[i].checked=!document.myform.cb_".$j."[i].checked;
			  }
			  document.myform.cb_".$j."_all.checked=false;
			}
		}
                function ableall_cb_".$j."() {
                  for (i=0;i<document.myform.cb_".$j.".length;i++) {
                    document.myform.cb_".$j."[i].disabled=false;
                  }
                }
        ";

echo "<style type=\"text/css\">
<!--
.calendarTr {font-size:12px; font-weight: bolder; color: #006600}
.calendarHeader {font-size:12px; font-weight: bolder; color: #cc0000}
.calendarToday {font-size:12px; background-color: #ffcc66}
.calendarTheday {font-size:12px; background-color: #ccffcc}
.calendar {font-size:11px;font-family: Arial, Helvetica, sans-serif;}
.dateStyle {font-size:15px;font-family: Arial; color: #cc0066; font-weight: bolder}
-->
</style>
<script language=\"JavaScript\">
        $js
</script>
";

$main=&signForm($sel_year,$sel_seme);
echo $tool_bar;
$main="<form action='$_SERVER[SCRIPT_NAME]' method='post' name='myform'>
<table border='1' style='border-collapse:collapse' cellpadding='5' bordercolor='#D1D1D1' bgcolor='#F0F0F0'>
 <tr><td>
<table border='0'>
<tr><td valign='top'>".$main."</td><td valign='top'>".$the_cal."</td></tr></table>";
echo $main;

//���o�ثe�Ҧ��Z��
$class_array=class_base();

?>
<table border="0" width="100%">
 <tr>
   <td>���w��ǥͦW��(�жi��̫�Ŀ�A���U�u�x�s�n�O�v)</td>
 </tr>
 <tr>
   <td>
   	<table border="2" style="border-collapse:collapse" bordercolor="#111111" bgcolor="#FFDDDD" width="100%">
   		<tr>
   			<td><span id="show_selected_students">�ثe�L�w��W��</span></td>
   		</tr>
   	</table>   
   </td>
 </tr>
 <tr>
  <td style="color:#FF0000;font-size:10pt"><?php echo $INFO;?></td>
 </tr>
</table>
</td></tr>
</table>

</form>
<form method="post" name="myform2" action="<?php echo $_SERVER['php_self'];?>">
<table border="0">
 <tr>
  <td>����ܯZ��
  	<select name="the_class" size="1" id="the_class">
  	 <option value="">�п�ܯZ��</option>
					<?php
					 foreach ($class_array as $k=>$v) {
					 ?>
					 <option value="<?php echo $k;?>" ><?php echo $v;?></option>
					 <?php
					 }
					?>  	 
  	</select> <input type="button" id="chk_all" value="����"><input type="button" id="chk_all_clear" value="������">
  	</td>	
 </tr>
 <tr>
 	<td>
 	
 		<span id="the_students"></span>
 	</td>
 </tr>
 <tr>
   <td><input type="button" value="�w��o�Ǿǥ�" id="btn_select_students"></td>
 </tr>
</table>
</form>
<Script>
 $("#the_class").change(function(){
    $.ajax({
   	type: "post",
    url: 'ajax_return_students.php',
    data: { the_class: $('#the_class').val() , pre_selected:$('#pre_selected').val() },
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~, �L�k���o�ǥͦW��!');
    },
    success: function(response) {
    	$('#the_students').html(response);
      $('#the_students').fadeIn();      
    }
   });   // end $.ajax
 }); // end #the_class

 $("#btn_select_students").click(function(){
 	//�B�z�Ŀ諸�W��, �����}�C
 	var selectedItems = new Array();
 		$("input[name*='chk_student[]']:checked").each(function() {
 					selectedItems.push($(this).val());
 		});

 if (selectedItems .length == 0)
     alert("�ФĿ�ǥ�");
 else
 	
 	�@//�ǰe�Q�Ŀ諸�W��(�ন�H;�j�}���r��)�Τw�w��(pre_selected)�� hidden ��
    $.ajax({
   	type: "post",
    url: 'ajax_select_students.php',
    data: { items:selectedItems.join(';') , pre_selected:$('#pre_selected').val() },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~, �L�k���o�ǥͦW��!');
    },
    success: function(response) {
    	$('#show_selected_students').html(response);
      $('#show_selected_students').fadeIn(); 
      //�̫�Ǧ^�W�檺 table  �� <input type="hidden" name="pre_selected">
    }
   });   // end $.ajax
 }); // end #the_class

//����
$("#chk_all").click(function(){
  $(".chk_student").attr("checked","true");
});

//������
$("#chk_all_clear").click(function(){
  $(".chk_student").attr("checked","");
});


</Script>
<?php

foot();


//�C�X��g���
function &signForm($sel_year,$sel_seme){
	
	        global $year,$month,$day,$CONN,$weekN,$IS_JHORES;

        //�H7�`�Ҭ��з�
        $all_sections=7;
           for($i=1;$i<=$all_sections;$i++){
                  $sections_txt.="<td>$i �`</td>";
           }

        //���o���m�����O
        $absent_kind_array= SFS_TEXT("���m�����O");
        $option="
        <option value=''></option>";
        foreach($absent_kind_array as $k){
                $option.="<option value='$k'>$k</option>\n";
        }


                $scond=study_cond();
                $tool="���m�Һ���";
                $seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
                
								$fday=mktime(0,0,0,$month,$day,$year);
                $dd=getdate($fday);
                $fday-=($dd[wday]-1)*86400;
                for ($j=0;$j<=5;$j++) {
                        //���o�Ӿǥ͸��
                        $smkt=$fday+$j*86400;
                        $syear=date("Y",$smkt);
                        $smonth=date("m",$smkt);
                        $sday=date("d",$smkt);
                        $dd=getdate($smkt);
                        $did=date("Y-m-d",$smkt);
                        $pid=date("Y-m-d",$fday-7*86400);
                        $fid=date("Y-m-d",$fday+7*86400);
                        $e_name="cb_".$dd[wday];
                        
                        //�m�Һ���
                        $select="<select name='s[$did][kind]' id='tool'>$option</select>";
                        $checked="checked";

                        $sections_data="";
                        $close_allday=false;
                        
												//�C�@�`�Ҫ��Ŀ����
                         for($i=1;$i<=$all_sections;$i++){
                                $sv="<input type='checkbox' id='$e_name' name='s[$did][section][]' value='$i'>";
                                $sections_data.="<td>$sv</td>\n";
                         }


                        //�ɺX
                        $ufv="<input type='checkbox' id='$e_name' name='s[$did][section][]' value='uf'>";
                        $uf="<td bgcolor='#FBF8B9'>$ufv</td>";

                        //���X
                        $dfv="<input type='checkbox' id='$e_name' name='s[$did][section][]' value='df'>";
                        $df="<td bgcolor='#FFE6D9'>$dfv</td>";

                        //���
                        //�ݬO�_�n�����u��ѡv�\��
                        $disabled="";
                        
                        $allday="<input type='checkbox' id='".$e_name."_all' $disabled name='s[$did][section][]' value='allday' onClick=\"if (this.checked==false){javascript:ableall_$e_name() } else { javascript:disableall_$e_name()}\">";

                        $all_day="<td bgcolor='#E8F9C8'>$allday</td>";
                       
                        $data.="<tr bgcolor='#FFFFFF'>";
                        $data.="
                        <td align='center'>".$did."<br>(".$weekN[$dd[wday]-1].")</td>
                        $uf
                        $sections_data
                        $df
                        $all_day
                        <td bgcolor='#ECff8F9' vlign='middle'>$select</td>
                        </tr>";
                }
                $site_title=$pre_str."�y��".$next_str;
                $date_title="<td align='center'><a href='$_SERVER[SCRIPT_NAME]?this_date=$pid'>��</a><br>���<br><a href='$_SERVER[SCRIPT_NAME]?this_date=$fid'>��</a></td>";
        

        $main="        
        <font color=#0000FF>���Х���g���m�Ҹ�ơA�A�i��W���ܡG</font>
        <table cellspacing='0' cellpadding='0'0class='small'>
        <tr><td valign='top'>
                <table cellspacing='1' cellpadding='3' bgcolor='#C6D7F2' class='small'>
                <tr bgcolor='#E6F2FF'>

                $date_title
                <td bgcolor='#FBF8B9'>�ɺX</td>
                $sections_txt
                <td bgcolor='#FFE6D9'>���X</td>
                <td bgcolor='#E8F9C8'>���</td>
                <td bgcolor='#ECff8F9'>���m�Һ���</td>
                </tr>
                <form action='$_SERVER[SCRIPT_NAME]' method='post' name='myform'>
                $data
                </table>
        </td><td valign='top'>
                <input type='hidden' name='sel_year' value='$sel_year'>
                <input type='hidden' name='sel_seme' value='$sel_seme'>
                <input type='hidden' name='class_id' value='$class_id'>
                <input type='hidden' name='this_date' value='$year-$month-$day'>
                <input type='hidden' name='date' value='$year-$month-$day'>
		<div class='small'><input type='checkbox' name='include_uf' checked>��ѧt�ɺX</div>
		<div class='small'><input type='checkbox' name='include_df' checked>��ѧt���X</div>
                <input type='submit' name='act' value='�x�s�n�O'>";
        $main.="
                
        </td></tr>
        </table>
        ";
        return $main;
}

//�s�W���
function add_all($sel_year,$sel_seme,$class_id="",$date="",$data=array()){
	global $SAVE_INFO;
/*
s[091005][uf]
s[091005][section]
s[091005][df]
s[091005][allday]
s[091005][kind]
s[091005][date]
*/
        foreach($data as $id =>$v){
                foreach($v[section] as $section){
                        if(empty($v['kind']))continue;
                        add($sel_year,$sel_seme,$id,$class_id,$date,$section,$v['kind']);
                }
        }
        return;
}
//�s�W�@�H���
function add_one($sel_year,$sel_seme,$class_id="",$stud_id="",$data=array()){
	global $SAVE_INFO;
        foreach($data as $id =>$v){
                foreach($v[section] as $section){
                        if(empty($v['kind']))continue;
                        $SAVE_INFO[0]++;
                        add($sel_year,$sel_seme,$stud_id,$class_id,$id,$section,$v['kind']);
                }
        }
        return;
}

//�s�W��@�����
function add($sel_year,$sel_seme,$stud_id,$class_id="",$date,$section,$kind){
        global $CONN,$SAVE_INFO;
        $d=explode("-",$date);
        $c=explode("_",$class_id);
        //��data�ӧP�_�Ǧ~�P�Ǵ�
        $upA=array("1","8","9","10","11","12");
        $downA=array("2","3","4","5","6","7");

        if(in_array($d[1],$upA)) {//�W�Ǵ�
                $sel_year=($d[1]==1)?$d[0]-1912:$d[0]-1911;
                $sel_seme=1;
        }
        elseif(in_array($d[1],$downA)) {//�U�Ǵ�
                $sel_year=$d[0]-1912;
                $sel_seme=2;
        }
        $new_class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,$c[2]-($c[0]-$sel_year)+$IS_JHORES,$c[3]);
        
        $chk_sql="select * from stud_absent where year='$sel_year' and semester='$sel_seme' and stud_id='$stud_id' and date='$date' and section='$section'";
        $res_chk=$CONN->Execute($chk_sql);
        
        if ($res_chk->RecordCount()==0) {
         $sql_insert = "insert into stud_absent (year,semester,class_id,stud_id,date,absent_kind,section,sign_man_sn,sign_man_name,sign_time,month) values ('$sel_year','$sel_seme','$new_class_id','$stud_id','$date','$kind','$section','$_SESSION[session_tea_sn]','$_SESSION[session_tea_name]',now(),'$d[1]')";
         $CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
         sum_abs($sel_year,$sel_seme,$stud_id);
          $SAVE_INFO[1]++;
        } else {
          $SAVE_INFO[2]++;
        }
        return;
}

?>
