<?php	
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
//���ҬO�_�n�J
sfs_check(); 

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);
//Ū���ثe�ާ@���Ѯv���S���޲z�v , �f�t module-cfg.php �̪��]�w
//$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

if ($_POST['act']=='�x�s�]�w') {
 $now_year_seme=$_POST['now_year_seme'];
 $paper_mode=$_POST['paper_mode'];
 $start_time=$_POST['start_time'];
 $end_time=$_POST['end_time'];
 //Ū���ɦҾǴ��O�]�w
 $sql="select * from resit_seme_setup limit 1";
 $res=$CONN->Execute($sql);
 if ($res->recordcount()==0) {
  $sql="insert into resit_seme_setup (now_year_seme,paper_mode,start_time,end_time) values ('$now_year_seme','$paper_mode','$start_time','$end_time')";
 }else {
 	$sql="update resit_seme_setup  set now_year_seme='$now_year_seme',paper_mode='$paper_mode',start_time='$start_time',end_time='$end_time'";
 }
  $res=$CONN->Execute($sql) or die ('Error! SQL='.$sql);

$INFO="�w��".date("Y-m-d H:i:s")."�i���x�s!";

}



//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	

//Ū���ɦҾǴ��O�]�w
$sql="select * from resit_seme_setup limit 1";
$res=$CONN->Execute($sql);
if ($res->recordcount()==0) {
 $SETUP['start_time']=date("Y-m-d H:i:s");
 $SETUP['end_time']=date("Y-m-d H:i:s");
 $SETUP['paper_mode']='0';
} else {
 $SETUP=$res->fetchrow();
}

//Ū�� POST ��



/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();
//�C�X���
echo $tool_bar;
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return check_setup()">
<table border="1" style="border-collapse:collapse" bordercolor="#111111" bgcolor="#EDEDED">
<tr>
<td>
<table border="0" cellpadding="5">
 <tr>
 	<td align="right">�]�w�ҥθɦҾǴ��O</td>
 	<td>
		<select size="1" name="now_year_seme">
			<?php
				foreach ($class_seme_p as $k=>$v) {
					if ($curr_year>substr($k,0,3)*1+$CY_step) continue;
			?>
				<option value="<?php echo $k;?>" <?php if ($k==$SETUP['now_year_seme']) echo "selected";?>><?php echo $v;?></option>
			<?php
				}
			?>
		</select>
 	</td>
 </tr>
 <tr>
 		<td align="right" valign="top">����Ҧ�</td>
 		<td>
 			1.<input type="radio" name="paper_mode" value="0"<?php if ($SETUP['paper_mode']=='0') echo " checked";?>>�̸ը��ӧO�]�w�ɶ����<br>
 		  2.<input type="radio" name="paper_mode" value="1"<?php if ($SETUP['paper_mode']=='1') echo " checked";?>>�̤U�C�]�w�ɬq���}��Ҧ��ը�
 		</td>
 </tr>
 <tr>
 		<td align="right">����}�l�ɶ�</td>
 		<td><input type="text" name="start_time" size="20" value="<?php echo $SETUP['start_time'];?>"><font size="2" color="#800000">(�榡YYYY-MM-DD HH:MM:SS�A����Ҧ��]��2�~�ͮ�)</font></td>
 </tr>
 <tr>
 		<td align="right">��������ɶ�</td>
 		<td><input type="text" name="end_time" size="20" value="<?php echo $SETUP['end_time'];?>"><font size="2" color="#800000">(�榡YYYY-MM-DD HH:MM:SS�A����Ҧ��]��2�~�ͮ�)</font></td>
 </tr>
</table>
</td>
</tr>
</table>
<input type="submit" name="act" value="�x�s�]�w">
<br><br>
<font color="red"><?php echo $INFO;?></font>
</form>

<?php

//  --�{���ɧ�
foot();
?>
<script>
	
 function check_setup() {
 	
   var start_time=document.myform.start_time.value;
	 var end_time=document.myform.end_time.value;
    
    
    //�Ҹծɶ����
   	starttime=start_time.replace(/-/g, "/"); 
   	starttime=(Date.parse(starttime)).valueOf() ; // �����ഫ��Date���O�ҥN����
   	endtime=end_time.replace(/-/g, "/"); 
   	endtime=(Date.parse(endtime)).valueOf() ; // �����ഫ��Date���O�ҥN����
   	
   	//Ū������Ҧ�
   	for (var i=0; i<myform.paper_mode.length; i++) {
   	if (myform.paper_mode[i].checked)
   		{
      	var paper_mode = myform.paper_mode[i].value;
   		}
  	}
   	   	
    if (starttime>=endtime && paper_mode==1) {
     alert ("�Ҹյ����ɶ����o����ε���}�l�ɶ�!");
     return false;
    }	

   return true;
 }

</script>