<?php	
header('Content-type: text/html;charset=big5');
// $Id: index.php 5310 2009-01-10 07:57:56Z smallduh $
//���o�]�w��
include_once "config.php";
//���ҬO�_�n�J
sfs_check(); 

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ɦҾǴ��O�]�w
$sql="select * from resit_seme_setup limit 1";
$res=$CONN->Execute($sql);
$SETUP=$res->fetchrow();
$C_year_seme=substr($SETUP['now_year_seme'],0,3)."�Ǧ~�� �� ".substr($SETUP['now_year_seme'],-1)." �Ǵ�";
//�ثe�B�z���Ǧ~�Ǵ�
$sel_year = substr($SETUP['now_year_seme'],0,3);
$sel_seme = substr($SETUP['now_year_seme'],-1);

//�w��w���~��
$Cyear=$_POST['Cyear'];

//�T�{�i�ɦҪ��~��
//�Ҧp: �H�ꤤ�Ө�, �{���Ǧ~ 103 , �Y�ҥ� 102�Ǧ~, �u��ҸӦ~���@�~�ũM�G�~��, �]���T�~�Ťw���~
// �ꤤ�ΰ�p�P�w $IS_JHORES=6 (�ꤤ) , $IS_JHORES=0 (��p)
if ($IS_JHORES==6) {
	$SY=$curr_year-3;   //�H103����, ����I�� 100
} else {
	$SY=$curr_year-6;   //�H103����, ����I�� 97
}

//�s�@�~�ſ��
$sy_circle=$sel_year-$SY;	
$now_cy=3-$sy_circle;

$class_year_list="
  <select size='1' name='Cyear' onchange='this.form.submit()'>
   <option value=''>�п�ܦ~��</option>";
   for ($i=1;$i<=$sy_circle;$i++) {
    $CY=$i+$IS_JHORES;
    $NCY=$CY+$now_cy;
    $class_year_list.="<option value='$CY'".(($CY==$Cyear)?" selected":"").">".$school_kind_name[$CY]."�� (�ثe�NŪ".$school_kind_name[$NCY]."��)</option>";
   }    
$class_year_list.="
  </select>
";


 		if($Cyear>2){
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
		} else {
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
		}
// POST����檺�{��
//�]�w�ը��Aajax,����� exit
if ($_POST['act']=='setup_paper') {	
  $scope=$_POST['scope'];
	$sql="select * from resit_paper_setup where seme_year_seme='".$SETUP['now_year_seme']."' and class_year='$Cyear' and scope='$scope'";	
	$res=$CONN->Execute($sql);
  if ($res->recordcount()) {
   $start_time=$res->fields['start_time'];
   $end_time=$res->fields['end_time'];
   $timer_mode=$res->fields['timer_mode'];
   $timer=$res->fields['timer'];
   $relay_answer=$res->fields['relay_answer'];
   $items=$res->fields['items'];
   $double_papers=$res->fields['double_papers'];
  } else {
   $start_time=date('Y-m-d H:i:00');
   $end_time=date('Y-m-d H:i:00');
   $timer_mode=0;
   $timer=45;
   $relay_answer=0;
   $items=0;
   $double_papers=0;
  }	
   $main="
   <input type='hidden' name='scope' value='$scope'>
   <table border='0' cellpadding='3'>
   	<tr>
   	  <td colspan='2' style='color:#800000'><b>".$link_ss[$scope]."���</b>�ը��]�w</td>
   	</tr>
   	<tr>
   		<td>�Ҹն}�l�ɶ�</td>
   		<td><input type='text' size='20' name='start_time' value='$start_time'></td>
   	</tr>
   	<tr>
   		<td>�Ҹյ����ɶ�</td>
   		<td><input type='text' size='20' name='end_time' value='$end_time'></td>
   	</tr>
   	<tr>
   		<td>�p�ɼҦ�</td>
   		<td>
   		    <input type='radio' name='timer_mode' value='0'".(($timer_mode==0)?" checked":"").">�ӧO�p��
   		    <input type='radio' name='timer_mode' value='1'".(($timer_mode==1)?" checked":"").">�P�ɭp��
   		</td>
   	</tr>
   	<tr>
   		<td>�p�ɮɶ�</td>
   		<td><input type='text' size='5' name='timer' value='$timer'>����</td>
   	</tr>
   	<tr>
   		<td>�X�D�Ҧ�</td>
   		<td>�H����<input type='text' size='5' name='items' value='$items'>�D����(��J0���ܥ���)</td>
   	</tr>
   	<tr>
   		<td>�����ߧY���Ѹѵ�</td>
   		<td>
   		    <input type='radio' name='relay_answer' value='0'".(($relay_answer==0)?" checked":"").">�_
   		    <input type='radio' name='relay_answer' value='1'".(($relay_answer==1)?" checked":"").">�O
   		</td>
   	</tr>
   	<tr>
   		<td>�_�u��O�_�i�A���</td>
   		<td>
   		    <input type='radio' name='double_papers' value='0'".(($double_papers==0)?" checked":"").">�_
   		    <input type='radio' name='double_papers' value='1'".(($double_papers==1)?" checked":"").">�O
   		    <br><font size=2>(�w�]�u�_�v�A�i�קK���a�n�J�P�b�����л��)</font>
   		</td>
   	</tr>

   </table>

   ";

	echo $main;
  exit();
} // end if ($_POST['act']=='setup_paper')

//�x�s�ը��]�w
if ($_POST['act']=='setup_paper_submit') {
		
  $scope=$_POST['scope'];
	$sql="select * from resit_paper_setup where seme_year_seme='".$SETUP['now_year_seme']."' and class_year='$Cyear' and scope='$scope'";	
	$res=$CONN->Execute($sql);
	
	$start_time=$_POST['start_time'];
	$end_time=$_POST['end_time'];
	$timer_mode=$_POST['timer_mode'];
	$timer=$_POST['timer'];
	$items=$_POST['items'];
	$relay_answer=$_POST['relay_answer'];
	$double_papers=$_POST['double_papers'];
	
	if ($res->recordcount()) {
	  $sql="update resit_paper_setup set start_time='$start_time',end_time='$end_time',timer_mode='$timer_mode',timer='$timer',items='$items',relay_answer='$relay_answer',double_papers='$double_papers' where seme_year_seme='".$SETUP['now_year_seme']."' and class_year='$Cyear' and scope='$scope'";
    $res=$CONN->Execute($sql) or die ('Error! Query='.$sql);
	} else {
	  $sql="insert into resit_paper_setup (seme_year_seme,class_year,scope,start_time,end_time,timer_mode,timer,items,relay_answer,double_papers) values ('".$SETUP['now_year_seme']."','$Cyear','$scope','$start_time','$end_time','$timer_mode','$timer','$items','$relay_answer','$double_papers')";
	  $res=$CONN->Execute($sql) or die ('Error! Query='.$sql);
	}
	
	echo $link_ss[$scope]."���ը��]�w�x�s����!";
	
  exit();
}


//�x�s���D
if ($_POST['act']=='edit_paper_submit') {		 
	$opt2=$_POST['opt2'];
	$item_scope=$_POST['item_scope'];
	$paper_setup=get_paper_sn($SETUP['now_year_seme'],$Cyear,$item_scope);
  $item_sn=$_POST['item_sn'];
  
  $question=trim($_POST['question']);
  $cha=trim($_POST['cha']);
  $chb=trim($_POST['chb']);
  $chc=trim($_POST['chc']);
  $chd=trim($_POST['chd']);
  $answer=$_POST['answer'];

	//�B�z�Ϥ� ���o $fig_q,$fig_a,$fig_b,$fig_c,$fig_d ���ӭ�
	$fig_array=array("q","a","b","c","d");
	foreach ($fig_array as $v) {
		$target_fig="thefig_".$v;
		$target_fig_name="fig_".$v;
		${$target_fig_name}="";
	   if ($_FILES[$target_fig]!="") {	   	
	   	//������ɦW
      $expand_name=explode(".",$_FILES[$target_fig]['name']);
      $nn=count($expand_name)-1;
      $ATTR=strtolower($expand_name[$nn]); //��p�g���ɦW
      if ($ATTR=='jpg' or $ATTR=='png') {
          $img_info = getimagesize($_FILES[$target_fig]['tmp_name']);
    			$xx   = $img_info['0'];
    			$yy   = $img_info['1'];
					$imgtype=$_FILES[$target_fig]['type'];
					
          $sFP=fopen($_FILES[$target_fig]['tmp_name'],"r");				//���J�ɮ�
       		$sFile=addslashes(fread($sFP,filesize($_FILES[$target_fig]['tmp_name'])));
       		$sFile=base64_encode($sFile);
    			
    			$sql="insert into resit_images (filetype,xx,yy,content) values ('$imgtype','$xx','$yy','$sFile')";
					$res=$CONN->Execute($sql);					
		     	list(${$target_fig_name})=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
      } 
     } //end if	
	} // end foreach

  //echo "'$fig_q','$fig_a','$fig_b','$fig_c','$fig_d'";
  //exit();

  if ($item_sn=='') {
	 //�s�W���D
	 $sql="insert into resit_exam_items (paper_sn,question,cha,chb,chc,chd,fig_q,fig_a,fig_b,fig_c,fig_d,answer) values ('".$paper_setup['sn']."','$question','$cha','$chb','$chc','$chd','$fig_q','$fig_a','$fig_b','$fig_c','$fig_d','$answer')";
	 $res=$CONN->Execute($sql) or die ("Error! SQL=".$sql);
	 //���o�̫᪺ sn , �H��̫ܳ�s�誺���D	
	 list($Last_item_sn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
  } else {
   $item_org=get_item($item_sn);
   //�Y������,�R�����
   	$fig_array=array("q","a","b","c","d");
	  foreach ($fig_array as $v) {
		 $target_fig="fig_".$v;
		 if ($item_org[$target_fig]>0) {
		   if (${$target_fig}>0 or $_POST['del_fig'][$v]) {
		     $CONN->Execute("delete from resit_images where sn='".$item_org[$target_fig]."'");
		   } else {
		     ${$target_fig}=$item_org[$target_fig];
		   }
		 }
		} // end foreach
		
		$sql="update resit_exam_items set question='$question',cha='$cha',chb='$chb',chc='$chc',chd='$chd',fig_q='$fig_q',fig_a='$fig_a',fig_b='$fig_b',fig_c='$fig_c',fig_d='$fig_d',answer='$answer' where sn='$item_sn'";
		$res=$CONN->Execute($sql) or die ("�ק���D����! SQL=".$sql);
	
   //�s����D        
   $Last_item_sn=$item_sn; 
  }
  //�O���s����D���A
  $_POST['act']=($opt2!='')?$opt2:'edit_paper';  
} // end if edit_paper_submit

//�ק���D
if ($_POST['act']=='edit_paper_update') {		 
  $item_sn=$_POST['item_sn'];
	$item_scope=$_POST['item_scope'];
	$item=get_item($item_sn);
	//�ק粒�n��^���ʧ@
  $opt2=$_POST['opt2'];
  //�O���s����D���A
  $_POST['act']='edit_paper';  
}

//�R�����D
if ($_POST['act']=='edit_paper_delete') {		 
  $item_sn=$_POST['item_sn'];
	$item_scope=$_POST['item_scope']; 
	$item_org=get_item($item_sn);	
   //�Y������,�R�����
   	$fig_array=array("q","a","b","c","d");
	  foreach ($fig_array as $v) {
		 $target_fig="fig_".$v;
		 if ($item_org[$target_fig]>0) {
		     $CONN->Execute("delete from resit_images where sn='".$item_org[$target_fig]."'");
		 }
		} // end foreach
		//�R�����D
 	  $CONN->Execute("delete from resit_exam_items where sn='".$item_org['sn']."'");
	//�R�����n��^���ʧ@
  $_POST['act']=$_POST['opt2'];  
} // end if $_POST['act']=='edit_paper_delete'

//�x�s�פJ�����D
if ($_POST['act']=='upload_paper_save') {		 
	$item_scope=$_POST['item_scope'];
	$paper_setup=get_paper_sn($SETUP['now_year_seme'],$Cyear,$item_scope);
  
  foreach ($_POST[field] as $I=>$P) {
    $save=0;
   if ($_POST['save_it'][$I]==1) {
    foreach ($P as $k=>$v) {
      if ($_POST['to_field'][$k]!='none') {
       $save=1;
       $f=$_POST['to_field'][$k];
       ${$f}=$v;       
      } // end if    
    } // end foreach ($P as $k=>$v)
  	
  	if ($question=='' and $cha=='' and $chb=='' and $chc=='' and $chd=='' and $answer=='') continue;
  	
  	$sql="insert into resit_exam_items (paper_sn,question,cha,chb,chc,chd,answer) values ('".$paper_setup['sn']."','$question','$cha','$chb','$chc','$chd','$answer')";
    $res=$CONN->Execute($sql) or die("�x�s�o�Ϳ��~�F! SQL=".$sql);
   } // end if ($_POST['save_it'][$I]==1)
  } // end foreach ($_POST[field] as $I=>$P)
  //�������C�X���D
  $_POST['act']='list_paper';  
} // end if edit_paper_submit

//�վ�ѵ� - �x�s
//�x�s�פJ�����D
if ($_POST['act']=='list_paper_answer_save') {		 
	$item_scope=$_POST['item_scope'];
  
  foreach ($_POST['answer'] as $sn=>$v) {
    $sql="update resit_exam_items set answer='$v' where sn='$sn'";
    $res=$CONN->Execute($sql) or die('�x�s�ѵ����ѡISQL='.$sql);
  } // end foreach ($_POST[field] as $I=>$P)
  //�������C�X���D
  $_POST['act']='list_paper';  
} // end if list_paper_answer_save


//**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D

head();
//�C�X���
echo $tool_bar;
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="opt1" value="">
	<input type="hidden" name="opt2" value="<?php echo $opt2;?>">
<?php
 echo "<font color=red>�ɦҾǴ��O�G".$C_year_seme."</font><br>";
 echo "�п�ܩR�D���~�šG".$class_year_list;
 
 if ($Cyear!="") { 
 	?>
 <table border="0" width="100%">
  <tr>
  	<!--���e�� -->
    <td width="480" valign="top" rowspan="2">
    	
 		<table border="1"  style="border-collapse:collapse;font-size:10pt" bordercolor="#111111" cellpadding="3" width="100%">
 		 <tr bgcolor="#FFCCFF" width="100%">
 			<td align="center">���O</td>
 			<td align="center">�D�� </td>
 			<td align="center">�ާ@</td>
 		 </tr>
 		<?php
 		foreach ($ss_link as $k=>$v) {
 			
 			if ($_POST['opt1']!="") {
 			  $display=($_POST['opt1']==$v)?"bloak":"none";
 			  //�ثe�ާ@���O��� $item_scope �O��
 			  $item_scope=$_POST['opt1'];
 			} else { 				
 			  $display="table-row"; 			  
 			}
 			
 			//�p�⥻����D��
 			$sql="select a.* from resit_exam_items a, resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='".$SETUP['now_year_seme']."' and b.class_year='$Cyear' and b.scope='$v'";
 			$res=$CONN->Execute($sql);
 			$num=$res->RecordCount();
			//�T�{�w�ҥΡA�_�h��T���s disable 					
 			$sql="select * from resit_paper_setup where seme_year_seme='".$SETUP['now_year_seme']."' and class_year='$Cyear' and scope='$v'";	
			$res=$CONN->Execute($sql);
			$disabled=($res->recordcount()==0)?"disabled":"";
 		  ?>
 		  <tr width="100%" class="scope_table" id="<?php echo $v;?>" style="background-Color:#FFFFFF;display:<?php echo $display;?>">
 		    <td><?php echo $k;?></td>
 		    <td align="center"><?php echo $num;?></td>
 				<td align="center">
 					<input type="button" value="�]�w�ը�" class="setup_paper" id="btn-<?php echo $v;?>-setup">
 					<input type="button" value="�פJ���D" class="upload_paper" id="btn-<?php echo $v;?>-upload" <?php echo $disabled;?>>
 					<input type="button" value="�u�W�R�D" class="edit_paper" id="btn-<?php echo $v;?>-edit" <?php echo $disabled;?>>
 					<input type="button" value="�˵����D" class="list_paper" id="btn-<?php echo $v;?>-list" <?php echo $disabled;?>>
 				</td>
 		  </tr>
 		  <?php
 		} 		
 		?>
 	  </table>
    </td>
  	<!--�k�e�� -->
    <td valign="top">
		<span id="show_right"></span>
    </td>
  </tr>
  <tr>
  	<td>
  		<div id="setup_paper_readme" style="display:none">
  			<input type="button" id="setup_paper_submit" value="�x�s�]�w"><br>
  		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>����:<br>
   1.���ĥΡu�ӧO�p�ɡv�Ҧ��ɡA�ǥͬҥi��o�ۦP���p�ɮɶ��@���C<br>
   2.���ĥΡu�P�ɭp�ɡv�Ҧ��ɡA�ǥͩ�ۦP���ɶ������ҸաC<br>
   3.�Y�u�Ǵ��ɦҳ]�w�v������Ҧ��]�w���u�̤U�C�]�w�ɬq���}��<br>�Ҧ��ը��v�A�h���B�Ҹծɶ������]�w�L����@�ΡC<br>
      </font>
      </div>
  	</td>
  </tr> 
 </table>
 <?php
 if ($_POST['act']=='edit_paper') {
 ?>
 <input type="hidden" name="item_scope" value="<?php echo $item_scope;?>">
 <input type="hidden" name="item_sn" value="<?php echo $item['sn'];?>">
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  	<?php form_item($item);?>
 	  </span>
 	  </td>
 	</tr>
 	<tr>
  	<td>
  		<div id="edit_paper_readme" style="display:block">
  			<input type="button" id="edit_paper_submit" value="�x�s���D">
  			<input type="button" id="edit_paper_end" value="�����R�D">
  			<br>
  			<?php
  			 if ($Last_item_sn) {
  			?>
  				<table border='1' bordercolor='#FFFFFF' cellspacing='0' bordercolordark='#FFFFFF' bordercolorlight='#800000'>
   					<tr bgcolor='#FFCC66'>
    				 	<td style='font-size:10pt;color:#0000cc'><img src='.\images\filefind.png'>�˵����e���D</td>
   					</tr>
   					<tr>
     					<td><?php echo show_item($Last_item_sn);?></td>
   					</tr>
  				</table>
  			<?php
  		  } //end if ($Last_item_sn)
  			?>
  		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>�s����D����:<br>
      1.���D�i�W�Ǫ��ϡA�t�Ψå�������Ϥj�p�A�����F�������[�ξ\Ū���ξA�סA�оA�׽վ���D�����Ϥj�p�C<br>
      2.�D�F�����ϡA�e�׺ɥi�ण�W�L 400px�F��ت��e�׺ɥi�ण�W�L200px�C<br>
      3.�ﶵ�Y�t�Ϥ��A��ĳ���Q��ø�ϳn��վ�|�ӿﶵ���Ϥ��j�p(�e�ΰ�)�۪�C
      </font>
      </div>
      
  		<div id="edit_paper_readme" style="display:block">
  		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>�u�W�R�D����:<br>
      1.�p�G�ӻ��w���ǥͰѥ[�ɦҡA���D��Ʈw���ŧ�ʡA�C
      </font>
      </div>
  	</td>
  </tr> 
 </table> 	
 	<?php
  
  } // end if $_POST['act']=='edit_paper'

 //�פJ���D
 if ($_POST['act']=='upload_paper') {
 ?>
 <input type="hidden" name="item_scope" value="<?php echo $item_scope;?>">
 <input type="hidden" name="item_sn" value="<?php echo $item['sn'];?>">
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  <textarea name="items" cols="78" rows="5"></textarea><br>
 	  �нT�{�_����R�r��Ÿ��G<br>
 	  ��1�_��Ÿ�<input type='text' name='cut[]' value='.' size='10'><br>
 	  ��2�_��Ÿ�<input type='text' name='cut[]' value='(A)' size='10'><br>
 	  ��3�_��Ÿ�<input type='text' name='cut[]' value='(B)' size='10'><br>
 	  ��4�_��Ÿ�<input type='text' name='cut[]' value='(C)' size='10'><br>
 	  ��5�_��Ÿ�<input type='text' name='cut[]' value='(D)' size='10'><br>
 	  ��6�_��Ÿ�<input type='text' name='cut[]' value='' size='10'><br>
 	  ��7�_��Ÿ�<input type='text' name='cut[]' value='' size='10'><br>
 	  ��8�_��Ÿ�<input type='text' name='cut[]' value='' size='10'><br>
 	  ��9�_��Ÿ�<input type='text' name='cut[]' value='' size='10'>
	  </span>
 	  </td>
 	</tr>
 	<tr>
  	<td>
  		<div id="edit_paper_readme" style="display:block">
  			<input type="button" id="upload_paper_submit" value="���R���D">
  			<input type="button" id="edit_paper_end" value="���}">
  			<br>
  		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>�פJ���D����:<br>
      1.�ĥζפJ�覡�A�i�P�ɫإߦh�D��r�����D�C<br>
      2.������ϳ����A�����פJ������A�ĭק���D�覡�v�D�W�ǡC<br>
      3.�K�W����r�������@�D�@�檺�榡�C
      
      </font>
      </div>
  	</td>
  </tr> 
 </table> 	
 	<?php
  
  } // end if $_POST['act']=='edit_paper'


//�פJ���D�W�Ǥ�r
if ($_POST['act']=='upload_paper_submit') {	
	
	$items=stripslashes($_POST['items']);
	$buffer = explode("\n",$items);  //�H����Ÿ�, ���Ƥ���
  //�}�l
  $i=0;
  foreach ($buffer as $P )  {
  	$i++;
  	//�H�_��Ÿ��@����Ƥ���̾�, �̦h10��
  	$j=0;
  	$j_max=0;
 		$P=trim($P); //�h���e��ť�
		foreach ($_POST['cut'] as $C) {
  	  if ($C!="") {  	
    		$NewP=explode($C,$P,2);
  	    $j++;
  	    $P_item[$i][$j]=trim($NewP[0]);
  	    $P=trim($NewP[1]);
  	  }  	
  	} // end foreach
    $j++;
    $P_item[$i][$j]=$P; //�Ѿl��r
    if ($j>$j_max) { $j_max=$j; }
  } // end foreach
	
	//�}�l�զX�� from
	$content="";
	for ($I=1;$I<=$i;$I++) {
	 //���
	 $content_tr=$content_td="";
	 for ($J=1;$J<=$j_max;$J++) {
	  $content_td.="<td><input type='text' size='12' name='field[$I][$J]' value='".$P_item[$I][$J]."'></td>";
	 }
	 //�C
	 $content_tr="
	  <tr class='upload_table'>
	   <td align='center'><input type='checkbox' name='save_it[$I]' value='1' checked></td>
	   $content_td
	  </tr>
	 ";
	 $content.=$content_tr;
	}
	
	//���D��
	 for ($J=1;$J<=$j_max;$J++) {
	  $content_title.="
	  <td>
  		<select size='1' name='to_field[$J]'>
    		<option value='none'>���x�s</option>
    		<option value='question'>�D�F</option>
    		<option value='cha'>���A</option>
    		<option value='chb'>���B</option>
    		<option value='chc'>���C</option>
    		<option value='chd'>���D</option>
    		<option value='answer'>�ѵ�</option>
  		</select>	  
	  </td>";
	 }
	$content_title="<tr bgcolor='#FFCC66'><td>�x�s</td>$content_title</tr>";
	$main="
	  <table border='0'>
	  $content_title
	  $content
	  </table>
	";
	//�}�l�e�{
	?>
	<input type="hidden" name="item_scope" value="<?php echo $item_scope;?>">
	<?php
  echo $main;
  ?>
  <input type="button" id="upload_paper_save" value="�x�s���D">
	<input type="button" id="edit_paper_end" value="���}">
	<br>
 		<font size='2' color='#0000cc'>
      <img src='./images/filefind.png'>�ާ@����:<br>
      1.�п�w�C�@���n���������D���ءC<br>
      2.�p�G������ƭn�˱�A�п�ܡu���x�s�v�C<br>
      3.�`�N�A����������ƽФŭ��СA�H�K��Ʈw�X��!      
      </font>

  <?php
}



 //�˵����D 
 if ($_POST['act']=='list_paper') {
 ?>
 <input type="hidden" name="item_scope" value="<?php echo $item_scope;?>">
 <input type="hidden" name="item_sn" value="<?php echo $item['sn'];?>">
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  	<input type="button" id="list_paper_end" value="�����˵�">
 	  	<input type="button" id="list_paper_answer" value="�վ�ѵ�">
 	  	<table border='0'>
 	  	
		<?php
 			$sql="select a.sn from resit_exam_items a, resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='".$SETUP['now_year_seme']."' and b.class_year='$Cyear' and b.scope='$item_scope'";
 			$res=$CONN->Execute($sql);
 			$row=$res->GetRows();
 			foreach ($row as $K) {
 			  $sn=$K['sn'];
				?>
				<tr><td><hr></td></tr>
				<tr>
					<td><?php echo show_item($sn);?></td>
				</tr>
				<?php 			  
 			}
		?>
		</table>
 	  </span>
 	  </td>
 	</tr>
 </table> 	
 	<?php
  
  } // end if $_POST['act']=='list_paper'
 
 //�˵����D 
 if ($_POST['act']=='list_paper_answer') {
 ?>
 <input type="hidden" name="item_scope" value="<?php echo $item_scope;?>">
 <input type="hidden" name="item_sn" value="<?php echo $item['sn'];?>">
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  	<input type="button" id="list_paper_end" value="�����˵�">
 	  	<input type="button" style="color:#FF0000" id="list_paper_answer_save" value="�x�s�ѵ�">
 	  	<table border='0'> 	  	
		<?php
 			$sql="select a.sn from resit_exam_items a, resit_paper_setup b where a.paper_sn=b.sn and b.seme_year_seme='".$SETUP['now_year_seme']."' and b.class_year='$Cyear' and b.scope='$item_scope'";
 			$res=$CONN->Execute($sql);
 			$row=$res->GetRows();
 			foreach ($row as $K) {
 			  $sn=$K['sn'];
				?>
				<tr><td><hr></td></tr>
				<tr>
					<td><?php echo show_item($sn,1);?></td>
				</tr>
				<?php 			  
 			}
		?>
		</table>
 	  </span>
 	  </td>
 	</tr>
 </table> 	
 	<?php  
  } // end if $_POST['act']=='list_paper_answer_save' 
 
 } //end if $Cyear 
?>
</form>
<?php
//  --�{���ɧ�
foot();
?>

<Script> 
 <?php
 foreach ($ss_link as $v) {
  $JavaArray.="\"".$v."\",";
 }
 $JavaArray=substr($JavaArray,0,strlen($JavaArray)-1);
 ?>
 //�w�q�Ҧ����
 var AllScope=[<?php echo $JavaArray;?>]; 

//�ƹ����X���J
$(".scope_table").hover(function(){
	 $(this).css("background-color","#FFFFAA");
	},function(){
	 $(this).css("background-color","#FFFFFF");	
})

//�ƹ����X���J
$(".upload_table").hover(function(){
	 $(this).css("background-color","#AAFFAA");
	},function(){
	 $(this).css("background-color","#FFFFFF");	
})

//�ƹ����X���J
$(".items_table").hover(function(){
	 $(this).css("background-color","#AAAAFF");
	},function(){
	 $(this).css("background-color","#FFFFFF");	
})

//�]�w�ը�
$(".setup_paper").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
	var act='setup_paper';
	var Cyear='<?php echo $Cyear;?>';
	   
  $.ajax({
   	type: "post",
    url: 'resit_assign.php',
    data: { act:act,scope:scope,Cyear:Cyear },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~!');
    },
    success: function(response) {
    	$('#show_right').html(response);
      $('#show_right').fadeIn(); 
      setup_paper_readme.style.display='block';
      setup_paper_readme.style.display='block';
      //for (index = 0; index < AllScope.length; ++index) {
      //  var ss=AllScope[index];        
      //	document.getElementById(ss).style.display = 'block';         
			//}
			
    } // end success
	});   // end $.ajax
})

//�x�s�ը��]�w
$("#setup_paper_submit").click(function(){
	var act='setup_paper_submit';
	var scope=document.myform.scope.value;
	var start_time=document.myform.start_time.value;
	var end_time=document.myform.end_time.value;
	var Cyear='<?php echo $Cyear;?>';
	var timer=document.myform.timer.value;
	var items=document.myform.items.value;
	//���o timer_mode , �ѩ�O�Q�� ajax �ʺA���ͪ��e���A�o��L�k�ϥ� jQuery ����
	for (var i=0; i<myform.timer_mode.length; i++) {
   if (myform.timer_mode[i].checked)
   {
      var timer_mode = myform.timer_mode[i].value;
   }
  }
  //���o relay_answer
	for (var i=0; i<myform.relay_answer.length; i++) {
   if (myform.relay_answer[i].checked)
   {
      var relay_answer = myform.relay_answer[i].value;
   }
  }
  
  //���o double_papers
	for (var i=0; i<myform.double_papers.length; i++) {
   if (myform.double_papers[i].checked)
   {
      var double_papers = myform.double_papers[i].value;
   }
  }	

   	//�Ҹծɶ����
   	starttime=start_time.replace(/-/g, "/"); 
   	starttime=(Date.parse(starttime)).valueOf() ; // �����ഫ��Date���O�ҥN������
   	endtime=end_time.replace(/-/g, "/"); 
   	endtime=(Date.parse(endtime)).valueOf() ; // �����ഫ��Date���O�ҥN������
    if (starttime>=endtime) {
     alert ("�Ҹյ����ɶ����o����ε���}�l�ɶ�!");
     return false;
    }	
	
  $.ajax({
   	type: "post",
    url: 'resit_assign.php',
    data: { act:act,scope:scope,Cyear:Cyear,start_time:start_time,end_time:end_time,timer:timer,items:items,timer_mode:timer_mode,relay_answer:relay_answer,double_papers:double_papers },
    dataType: "text",
    error: function(xhr) {
      alert('ajax request �o�Ϳ��~!');
    },
    success: function(response) {
    	$('#show_right').html(response);
      $('#show_right').fadeIn(); 
      setup_paper_readme.style.display='none';
      for (index = 0; index < AllScope.length; ++index) {
        var ss=AllScope[index];        
        //document.getElementById(ss).style.display = 'block';
        //����s�� disabled ����
        if (ss==scope) {
          var btnID="btn-"+ss+"-upload";
          document.getElementById(btnID).disabled = false;         
          var btnID="btn-"+ss+"-edit";
          document.getElementById(btnID).disabled = false;         
          var btnID="btn-"+ss+"-list";
          document.getElementById(btnID).disabled = false;         
        }         
			}
    }
	});   // end $.ajax 
 
})


//�u�W�R�D
$(".edit_paper").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
	  
  document.myform.act.value='edit_paper';
  document.myform.opt1.value=scope;
  
  document.myform.submit();

})

//�x�s���D , ���}���~�Ż��C��
$("#edit_paper_submit").click(function(){
	//�]�w opt1 ���Y���, �H�K�C������ܸӻ��
	document.myform.opt1.value=document.myform.item_scope.value;
  document.myform.act.value='edit_paper_submit';

  chk_submit=check_form_item();

  if (chk_submit) {
	 document.myform.submit();
	}

})

//�ק���D
$(".edit_paper_update").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var item_sn=NewArray[1];

	//�]�w opt1 ���Y���, �H�K�C������ܸӻ��
	document.myform.opt1.value=document.myform.item_scope.value;
	document.myform.opt2.value='<?php echo $_POST['act'];?>';
  document.myform.act.value='edit_paper_update';
  document.myform.item_sn.value=item_sn;
	document.myform.submit();
})

//�R�����D
$(".edit_paper_delete").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var item_sn=NewArray[1];
  
  confirm_delete=confirm("�z�T�w�n�R�����D�H\n�y�����G"+item_sn);
  
  if (confirm_delete) {
		//�]�w opt1 ���Y���, �H�K�C������ܸӻ��
		document.myform.opt1.value=document.myform.item_scope.value;
		document.myform.opt2.value='<?php echo $_POST['act'];?>';
  	document.myform.act.value='edit_paper_delete';
  	document.myform.item_sn.value=item_sn;
		document.myform.submit();
  }
})

//�����R�D , ���}���~�Ż��C��
$("#edit_paper_end").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
	 
	for (index = 0; index < AllScope.length; ++index) {
    var ss=AllScope[index];        
  	document.getElementById(ss).style.display = 'block';         
  }
  //�M���R�D��html , �קK�~�e
	$('#show_buttom').html("");
	edit_paper_readme.style.display='none'; 	

})

//�����˵� , ���}���~�Ż��C��
$("#list_paper_end").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
	 
	for (index = 0; index < AllScope.length; ++index) {
    var ss=AllScope[index];        
  	document.getElementById(ss).style.display = 'block';         
  }
  //�M���R�D��html , �קK�~�e
	$('#show_buttom').html("");

})

//�˵����D
$(".list_paper").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
	  
  document.myform.act.value='list_paper';
  document.myform.opt1.value=scope;
  
  document.myform.submit();

})

//�˵����D - �վ�ѵ�
$("#list_paper_answer").click(function(){
  
  document.myform.act.value='list_paper_answer';
  document.myform.opt1.value=document.myform.item_scope.value;
  
  document.myform.submit();

})

//�˵����D - �վ�ѵ��x�s
$("#list_paper_answer_save").click(function(){
  
  document.myform.act.value='list_paper_answer_save';
  document.myform.opt1.value=document.myform.item_scope.value;
  
  document.myform.submit();

})


//�פJ���D
$(".upload_paper").click(function(){
	var btnID=$(this).attr("id");
	var NewArray = new Array();
�@var NewArray = btnID.split("-");
  var scope=NewArray[1];
		
  document.myform.act.value='upload_paper';
  document.myform.opt1.value=scope;
  
  document.myform.submit();

})

//���R���D
$("#upload_paper_submit").click(function(){
	//�]�w opt1 ���Y���, �H�K�C������ܸӻ��
	document.myform.opt1.value=document.myform.item_scope.value;
  document.myform.act.value='upload_paper_submit';

  if (document.myform.items.value=='') {
   alert('���K�J�����r!');
   return false;
  }  
	document.myform.submit();
})

//�x�s���D
$("#upload_paper_save").click(function(){
	//�]�w opt1 ���Y���, �H�K�C������ܸӻ��
	document.myform.opt1.value=document.myform.item_scope.value;
  document.myform.act.value='upload_paper_save';
	document.myform.submit();
})

//������D����
function check_form_item() {
 if (document.myform.question.value=='') {
   alert('�D�F����J!');
   return false;
 }
 if (document.myform.cha.value=='' && document.myform.thefig_a.value=='' && ($("#del_fig_a").length == 0 || $("#del_fig_a").attr('checked'))) {
   alert('���(A)����J!');
   return false; 
 }

 if (document.myform.chb.value=='' && document.myform.thefig_b.value=='' && ($("#del_fig_b").length == 0 || $("#del_fig_b").attr('checked'))) {
   alert('���(B)����J!');
   return false; 
 }

 if (document.myform.chc.value=='' && document.myform.thefig_c.value=='' && ($("#del_fig_c").length == 0 || $("#del_fig_c").attr('checked'))) {
   alert('���(C)����J!');
   return false; 
 }

 if (document.myform.chd.value=='' && document.myform.thefig_d.value=='' && ($("#del_fig_d").length == 0 || $("#del_fig_d").attr('checked'))) {
   alert('���(D)����J!');
   return false; 
 }
 //�ˬd�ѵ����S���I��
 var method =$("input[name='answer']:checked").val(); //radio ���ȡA�`�N�g�k
 if( typeof(method) == "undefined"){ // �`�N�ˬd�����S��������g�k�A�o��O���
   alert( "�п���ѵ��I");
  return false;
 }

 return true;
 
}

</Script>