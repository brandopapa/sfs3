<?php
//���o�]�w��
include_once "config.php";

sfs_check();

//���o�t�Τ��Ҧ��Ǵ����, �C�@�Ǧ~���G�ӾǴ�
$class_seme_p = get_class_seme(); 

//�ثe��w�Ǵ� , �Y����w�h�H��w���Ǵ��@�����ǥͯZ�Ůy�����̾�, �_�h�H�̷s�Ǵ����Ӹꬰ��
$c_curr_seme=$_POST['c_curr_seme'];

 //�p��ӾǴ�������϶�
 $year=sprintf("%d",substr($c_curr_seme,0,3));
 $seme=substr($c_curr_seme,-1);
 //�_�l��
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='start'";
 /* ��l php �� MySQL �禡
 $res=mysql_query($sql);
 list($st_date)=mysql_fetch_row($res);
 */
 /* ADODB �g�k*/
 $res=$CONN->Execute($sql) or die("SQL���~:$sql");
 $st_date=$res->fields[0];
 
 //������
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='end'";
 /* ��l php �� MySQL �禡
 $res=mysql_query($sql);
 list($end_date)=mysql_fetch_row($res);
 */
  /* ADODB �g�k*/
 $res=$CONN->Execute($sql) or die("SQL���~:$sql");
 $end_date=$res->fields[0];



//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

/** submit �᪺�ʧ@ **************************************************/
//�R���浧
if ($_POST['act']=='DeleteOne') {
	$sn=$_POST['option1'];
	$query="delete from career_race where sn='$sn'";
	//mysql_query($query);
	 $res=$CONN->Execute($query) or die("SQL���~:$query");
	$_POST['act']='limit_date';
}

/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
	
<table border="0" width="100%" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
<tr>
  <td  width="100%" valign="top" bgcolor="#ffffff">
<!--�̾Ǵ� -->
   <table border="0" width="100%">
     <tr>
      <td style="color:#800000">
      	<u><b>�����ҮѤ�����ݾǴ�</b></u>
				<select name="c_curr_seme" onchange="this.form.act.value='limit_date';this.form.submit()">
					<option value="">---</option>
					<?php
					foreach ($class_seme_p as $tid=>$tname) {
    			?>
    				<option style="color:#FF00FF" value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   				<?php
    			} // end while
    			?>
    		</select>
    		<?php
    		 if ($_POST['act']=='limit_date') {
    		?>
      	<font size=2>����G<?php echo $st_date;?>~<?php echo $end_date;?></font>
      	<?php } ?>
      	</td>
     </tr>
   </table>
</td>
<!--�̯Z�Ůy�� -->
<td  width="100%" valign="top" bgcolor="#ffffff">
	
</td>   
</table>
<!-- �}�l�q�X��� -->
<?php
if ($_POST['act']=='limit_date') {
 if ($c_curr_seme!="") $race_record=get_race_record($c_curr_seme,"","");
 list_race_record($race_record,0,1,'cr_input.php');
}
?>



</form>


