<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();
?>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="./include/JSCal2-1.9/src/css/jscal2.css">

<?php

//�q�X����
head("�{�ҪA�Ⱦǲ߮ɼ�");

$tool_bar=&make_menu($school_menu_p);

//Ū���A�����O $ITEM[0],$ITEM[1].....
$M_SETUP=get_module_setup('stud_service');
$ITEM=explode(",",$M_SETUP['item']);

//�C�X���
echo $tool_bar;
	
//���o��Ʈw���Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);
//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']=='')?$curr_year.$curr_seme:$_POST['c_curr_seme'];

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//�w�]�C�X���{�Ҫ����
$_POST['listmode']=($_POST['listmode']==0)?2:$_POST['listmode'];

//���U�T�{
if ($_POST['confirm']==1 or $_POST['confirm']==-1) {
 $confirm=($_POST['confirm']+1)/2;
 foreach ($_POST['confirm_check'] as $sn) {
  $query="update stud_service set confirm='$confirm',confirm_sn='".$_SESSION['session_tea_sn']."' where sn='$sn'";
  mysql_query($query); 
 } 
}

?>
<!--- ��J��� --->
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" name="myform">
	<input type="hidden" name="confirm" value="0">
<table border="0" width="100%">
				<tr>
					<td>
						<font color="#800000">�п�ܾǴ��G</font>
				<select name="c_curr_seme" onchange="this.form.submit()">
					<option value="" style="color:#FF00FF">�п�ܾǴ�</option>
					<?php
					 foreach($class_seme_p as $tid=>$tname) {
						if (substr($tid,0,3)>$curr_year-3) {
			    ?>
      				<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   				<?php
      				} // end if
    				} // end while
		    ?>
				</select> 
				<Input Type="Radio" Name="listmode" Value="3" <?php if ($_POST['listmode']==3) echo "checked";?> onclick="this.form.submit()">�C�X����
				<Input Type="Radio" Name="listmode" Value="1" <?php if ($_POST['listmode']==1) echo "checked";?> onclick="this.form.submit()">�C�X�w�{��
				<Input Type="Radio" Name="listmode" Value="2" <?php if ($_POST['listmode']==2) echo "checked";?> onclick="this.form.submit()">�C�X���{��
				
		</td>
	</tr>
</table>
<table border="1" style="border-collapse:collapse" bordercolor="#800000" cellpadding="3" width="820">
	<tr bgcolor="#FFCCFF" style="font-size:10pt">
	 <td width="70" align="center">�A�Ȥ��</td>
	 <td width="70" align="center">�n����</td>
	 <td width="200" align="center">�A�Ȥ��e</td>
	 <td width="350" align="center">�ǥͦW��(�ɶ�:��)</td>
	 <td width="70" align="center"><input type="checkbox" name="init_check" value="1" onclick="checkall();">���A</td>
	 <td width="60" align="center">�{�Ҫ�</td>
	</tr>
<?php

$C[0]="<font style='color:#FF0000;font-size:9pt'>���{��</font>";
$C[1]="<font style='color:#0000FF;font-size:9pt'>�w�{��</font>";

if ($c_curr_seme!="") {
 $query="select * from stud_service where year_seme='$c_curr_seme'";
 
 switch ($_POST['listmode']) {
 	case '3':
 	  break;
 	case '1':
 	   $query.=" and confirm='1'";
 	  break;
 	case '2':
 	   $query.=" and confirm='0'";
 	  break;
 }
  $query.=" order by service_date desc";
 
 
 $res=mysql_query($query);
 if (mysql_num_rows($res)>0) {
 	while ($S=mysql_fetch_array($res)) {
 		$INPUT=($S['input_sn']==0)?$S['update_sn']:$S['input_sn'];
 ?>	
	<tr style="font-size:10pt">
	 <td width="70" align="center"><?php echo $S['service_date'];?></td>
	 <td width="70" align="center"><?php echo "<font style='font-size:8pt'>�i".getPostRoom($S['department'])."�j</font><br>".get_teacher_name($INPUT);?></td>
	 <td width="200"><?php echo '�i'.$S['item'].'�j<br>'.$S['memo'];?></td>
	 <td width="350"><span class="show_students" id="<?php echo $S['sn'];?>">�@�n�� <?php echo getService_num($S['sn']);?>�H�C(��ܦW��)</span>
	  <?php
	  //list_service_stud_noedit($S['sn']);
	  ?>	
	 </td>
	 <td width="70" align="center">
	 	<?php
	 	 if ($S['confirm']==0) {
	 	 ?>
	 	  <input type="checkbox" name="confirm_check[]" value="<?php echo $S['sn'];?>">
	 	 <?php
	 	 } else {
	 	 	if ($_POST['listmode']==1) {
	 	 	?>
	 	 	<input type="checkbox" name="confirm_check[]" value="<?php echo $S['sn'];?>">
	 	 	<?php
	 	 	}
	 	  echo $C[$S['confirm']];
	   }
	 	?>
	 
	 </td>
	 <td width="60" align="center"><?php echo get_teacher_name($S['confirm_sn']);?></td>
	</tr>	
 	
 	<?php
 	} // end while
 }
}
?>
</table>
<?php
 if ($_POST['listmode']==2 or $_POST['listmode']==3) {
?>
<table border="0" width="100%">
 <tr>
  <input type="button" value="�{�ҥH�W�Ŀﶵ�ت��A�Ȯɼ�" onclick="document.myform.confirm.value=1;document.myform.submit()" style="color:#0000FF">
 </tr>
</table>
<?php
}
?>
<?php
 if ($_POST['listmode']==1) {
?>
<table border="0" width="100%">
 <tr>
  <input type="button" value="�����H�W�Ŀﶵ�ت��A�Ȯɼ�" onclick="document.myform.confirm.value=-1;document.myform.submit()" style="color:#FF0000">
 </tr>
</table>
<?php
}
?>
</form>
<Script>
function checkall() {
	
	var j=0;
	if (document.myform.init_check.checked) { j=1; }
	
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name.substr(0,13)=='confirm_check') {
      document.myform.elements[i].checked=j;
    }
    i++;
  }
}	

$(".show_students").click(function(){
   
	   var show=$(this);
	   var sn=$(this).attr("id");
	   
    $.ajax({
   	type: "post",
    url: 'ajax_stud_service_list.php',
    data: { sn:sn },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~, �L�k���o�ǥͦW��!');
    },
    success: function(response) {
    	//alert('ajax request ���\!');
    	show.html(response);
      show.fadeIn();
    }
   });   // end $.ajax
   
});

</Script>