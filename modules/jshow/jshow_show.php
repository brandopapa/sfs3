<?php
// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $
//���o�]�w��
include_once "config.php";

sfs_check();

//���X�Ҧ��g���v��������
$P=get_jshow_checked_id();

$init_show=date('m')-1;

$iSHOW=($_POST['opt1']=="")?$init_show:$_POST['opt1'];

//�q�X����
head("Joomla!�����q�Ϻ޲z-�i�ϳ]�w");

$tool_bar=&make_menu($menu_p);

//�C�X���
echo $tool_bar;
?>
<style>
ul, li {
	margin: 0;
	padding: 0;
	list-style: none;
}
.abgne_tab {
	clear: left;
	width: 100%;
	margin: 10px 0;
}
ul.tabs {
	width: 100%;
	height: 32px;
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
}
ul.tabs li {
	float: left;
	height: 31px;
	line-height: 31px;
	overflow: hidden;
	position: relative;
	margin-bottom: -1px;	/* �� li ���U���ӾB�� ul ������ border-bottom */
	border: 1px solid #999;
	border-left: none;
	background: #e1e1e1;
}
ul.tabs li a {
	display: block;
	padding: 0 10px;
	color: #000;
	border: 1px solid #fff;
	text-decoration: none;
}
ul.tabs li a:hover {
	background: #ccc;
}
ul.tabs li.active  {
	background: #FFCCCC;
	border-bottom: 1px solid#fff;
}
ul.tabs li.active a:hover {
	background: #fff;
}
div.tab_container {
	clear: left;
	width: 100%;
	border: 1px solid #999;
	border-top: none;
	background: #fff;
}
div.tab_container .tab_content {
	padding: 20px;
}
div.tab_container .tab_content h2 {
	margin: 0 0 20px;
}
</style>
<script src ="include/jquery.blockUI.js" language="JavaScript"></script>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>"  enctype="multipart/form-data" >
 <input type="hidden" name="act" value="">
 <input type="hidden" name="opt1" value="<?php echo $opt1;?>">
 <table border="0">
 	<tr>
 		<td>��w������
 			<select size="1" name="kind_id" id="SELECT_kind_id">
 				<option value="">��ܤ�����</option>
 			<?php
 			foreach ($P as $p) {
 			?>
 			  <option value="<?php echo $p['kind_id'];?>" <?php if ($_POST['kind_id']==$p['kind_id']) { echo "selected";} ?>><?php echo $p['id_name'];?></option>
 			<?php
 			}
 			?> 	
 			</select>
 		</td>
 	</tr>
  </table>
 <?php
 if ($_POST['kind_id']!="") {
  	//���o�����ϳ]�w
  	$row=get_setup($_POST['kind_id']);
		if (count($row)>0) {
		  foreach ($row as $k=>$v) { ${$k}=$v; }
		}		

  ?>
  <table border="0">
 		<tr>
 	 		<td style="color:#FF0000"><?php echo $INFO;?></td>
 		</tr>
 	</table>
	<?php
 	if ($display_mode=='0' or $display_mode=='1') {
 	 //������w�n�i�ܪ��Ϥ�	
		//sumit�᪺�ʧ@ , �x�s
		if ($_POST['act']=='save') {
  		foreach($_POST['pic_set'] as $id=>$V) {
  		  $display=$V['display'];
  		  $display_sub=$V['display_sub'];
  		  $display_memo=$V['display_memo'];
  		  $sort=$V['sort'];
  		  $sql="update jshow_pic set display='$display',display_sub='$display_sub',display_memo='$display_memo',sort='$sort' where id='$id'";
  		  $res=$CONN->Execute($sql) or die("Error! sql=".$sql);
  		}
  		$INFO="<font color=red size=2>�w��".date("Y-m-d H:i:s")."�x�s����!</font>";
		}
		//�]�w���ǹϤ��n�i��	
		$sql="select count(*) as num from jshow_pic where kind_id='$kind_id' and display='1'";
	  $res=$CONN->Execute($sql) or die('SQL='.$sql);
    $C=$res->fields['num'];
		echo "�i�ϼҦ��G".$DISPLAY_M[$display_mode].$INFO.',�ثe�@��'.$C.'�i�Ϧb����';
		show_setup_all($_POST['kind_id']);  //���
		?>
		<input type="button" value="�x�s" onclick="document.myform.act.value='save';document.myform.submit()">
		<br>
		<font size="2">�����G�b joomla �Ҳպݥ�����ܡu�C�X���D�v�A���B���u�D�D�v�Ρu�����v�i�ܳ]�w�~�ॿ�`�e�{�C</font>
		<?php
 	} else {
 	//�̤���]�w	
		//sumit�᪺�ʧ@ , �x�s
		if ($_POST['act']=='save') {
			$init_pic_set=$_POST['init_pic_set'];
			$day_pic_set=serialize($_POST['DayPic']);
			$sql="update jshow_setup set init_pic_set='".$init_pic_set."',day_pic_set='".$day_pic_set."' where kind_id='".$kind_id."'";
			$res=$CONN->Execute($sql) or die("Error! sql=".$sql);	
  		$INFO="<font color=red size=2>�w��".date("Y-m-d H:i:s")."�x�s����!</font>";
 		}
 		//�̤����w�Ϥ�
 		echo "�i�ϼҦ��G<font color=blue>".$DISPLAY_M[$display_mode]."</font>";
		
		$DAY_SET=show_setup_day($_POST['kind_id']);
		?>
		<div class="abgne_tab">			
		<ul class="tabs">
		<?php
		//���ҭ�
		for ($i=1;$i<13;$i++) {
		?>
					<li><a href="#M<?php echo $i;?>"><?php echo $i;?>��</a></li>
		<?php
		} // end foreach
	  ?>
	  </ul>
	  <div class="tab_container">
	  	<?php for ($i=1;$i<=12;$i++) { ?>
	  	<div id="M<?php echo $i;?>" class="tab_content">
	  	 <?php
	  	 echo $DAY_SET[$i];
	  	 ?>
	  	</div>
	  	<?php 
	    } // end foreach 
	  ?>
	  </div>
		</div>  		
		<input type="button" value="�x�s" onclick="document.myform.act.value='save';document.myform.submit()">
		<?php
		echo $INFO;
		?>
	<table border="0">
	 <tr>
	 	<td><img src="img_show.php?kind_id=<?php echo kind_id;?>&id=<?php echo $init_pic_set;?>" id="pre_img_show"></td>
	 </tr>
	</table>
		<?php
 	}
} // end if ($POST['kind_id']=="")
?>

 

</form>
<Script>
 
 //��ܤ����Ϯ�
$("#SELECT_kind_id").change(function(){
 document.myform.act.value="";
 document.myform.submit();
});

 //��ܤ����Ϯ�
$(".SELECT_pic_id").change(function(){
 var pic_id=$(this).val();
 $("#pre_img_show").attr('src', 'img_show.php?kind_id=<?php echo $kind_id;?>&id='+pic_id);
 
});

//���ҥ\��
$(function(){
	// �w�]��ܲĤ@�� Tab
	var _showTab = <?php echo $iSHOW;?>;
	var $defaultLi = $('ul.tabs li').eq(_showTab).addClass('active');
	$($defaultLi.find('a').attr('href')).siblings().hide();
	// �� li ���ҳQ�I����...
	// �Y�n�令�ƹ����� li ���ҴN������, �� click �令 mouseover
	$('ul.tabs li').click(function() {
		// ��X li �����W�s�� href(#id)
		var $this = $(this),
			_clickTab = $this.find('a').attr('href');
		// ��ثe�I���쪺 li ���ҥ[�W .active
		// �ç�S�̤������� .active �������� class
		$this.addClass('active').siblings('.active').removeClass('active');
		// �H�J�۹��������e�����åS�̤���
		$(_clickTab).stop(false, true).fadeIn().siblings().hide();
		var res = _clickTab.substring(2);
		var init_showTab=res*1-1;
		document.myform.opt1.value=init_showTab;
		return false;
	}).find('a').focus(function(){
		this.blur();
	});
});


</Script>