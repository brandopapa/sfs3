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

$seme_year_seme=$SETUP['now_year_seme'];

//�ثe�B�z���Ǧ~�Ǵ�
$sel_year = substr($SETUP['now_year_seme'],0,3);
$sel_seme = substr($SETUP['now_year_seme'],-1);

//����Z�ų]�w�̪��Z�ŦW��
$class_base= class_base($curr_year_seme);

$score_sn=$_GET['sn'];
$scope=$_GET['scope'];
$Cyear=$_GET['Cyear'];

$paper_setup=get_paper_sn($SETUP['now_year_seme'],$Cyear,$scope);

//�w��w���~��

 		if($Cyear>2){
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","�۵M�P�ͬ����"=>"nature","���|"=>"social","���d�P��|"=>"health","���N�P�H��"=>"art","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","nature"=>"�۵M�P�ͬ����","social"=>"���|","health"=>"���d�P��|","art"=>"���N�P�H��","complex"=>"��X����");
		} else {
			$ss_link=array("�y��"=>"language","�ƾ�"=>"math","���d�P��|"=>"health","�ͬ�"=>"life","��X����"=>"complex");
			$link_ss=array("language"=>"�y��","math"=>"�ƾ�","health"=>"���d�P��|","life"=>"�ͬ�","complex"=>"��X����");
		}

$sql="select a.*,b.stud_id,b.stud_name,b.curr_class_num from resit_exam_score a,stud_base b where a.sn='$score_sn' and a.student_sn=b.student_sn";
$res=$CONN->Execute($sql) or die ("Ū���ը���Ƶo�Ϳ��~! SQL=".$sql);
$row=$res->fetchRow();
$curr_class_num=$row['curr_class_num'];

$seme_class=substr($curr_class_num,0,3);
$seme_num=substr($curr_class_num,-2);

echo "<font color=red>�ɦҾǴ��O�G".$C_year_seme."</font><br>";
echo "<font color=red>�ɦһ��G".$link_ss[$scope]."</font>�A".$class_base[$seme_class].$seme_num."�� ".$row['stud_name']."�A�ɦұo���G".$row['score']."<br>";
echo "<hr><br>";

$items=unserialize($row['items']);
$answers=unserialize($row['answers']);
?>
 <table border="0">
 	<tr>
 	  <td>
 	  <span id="show_buttom">
 	  	<input type="button" id="list_paper_end" value="�����˵�" onclick="window.close()">
 	  	<table border='0'>
 	  	
		<?php
		$i=0;
    foreach ($items as $k=>$v) {
    	$i++;
				?>
				<tr><td><hr></td></tr>
				<tr>
					<td><?php echo show_item($v,2,$answers[$k],$i);?></td>
				</tr>
				<?php 			  
    
    } // end foreach
		?>
		</table>
 	  </span>
 	  </td>
 	</tr>
 </table> 	


