<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("�ͲP�ξ㭱���[");

//�Ҳտ��
print_menu($menu_p,$linkstr);

$menu=$_POST['menu'];


//����ǥͤ��y�a�}
$query="select stud_addr_2 from stud_base where student_sn=$student_sn";
$res=$CONN->Execute($query);
$stud_addr=$res->fields[0];

//����ǥͥ��Ǵ��NŪ�Z��
$query="select * from stud_seme where student_sn=$student_sn and seme_year_seme='$seme_year_seme'";
$res=$CONN->Execute($query);
$seme_class=$res->fields['seme_class'];
$seme_class_name=$res->fields['seme_class_name'];
$seme_num=$res->fields['seme_num'];
$stud_grade=substr($seme_class,0,-2);

//�x�s�����B�z
if($_POST['go']=='�x�s����'){
	switch($menu){
		case 1:
			$ponder=serialize($_POST['ponder']);
			//�ˬd�O�_�w���¬���
			$query="select sn from career_view where student_sn=$student_sn";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$sn=$res->fields[0];
			if($sn) $query="update career_view set ponder='$ponder' where sn=$sn";
				else $query="insert into career_view set student_sn=$student_sn,ponder='$ponder'";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
		case 2:
			$direction=serialize($_POST['direction']);
			//�ˬd�O�_�w���¬���
			$query="select sn from career_view where student_sn=$student_sn";
			$res=$CONN->Execute($query) or die("SQL���~:$query");
			$sn=$res->fields[0];
			if($sn) $query="update career_view set direction='$direction' where sn=$sn";
			else $query="insert into career_view set student_sn=$student_sn,direction='$direction'";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
	}
}
if($student_sn){
	//���Ϳ��
	$memu_select="���ڭn�˵��γ]�w�G";
	$menu_arr=array(1=>'�ͲP���',2=>'��ܤ�V',3=>'�Q��Ū�Ǭ�ξǮժ��a�z��q');
	foreach($menu_arr as $key=>$title){
		$checked=($menu==$key)?'checked':''; 
		$color=($menu==$key)?'#0000ff':'#000000'; 
		$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";}

	$act=$menu?"<center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>":"";
	switch($menu){
		case 1:
			//����ͲP��V��Ҷ��ذѷӪ�
			$ponder_items=SFS_TEXT('�ͲP��V��Ҷ���');
		
			//���o�J�����
			$query="select ponder from career_view where student_sn=$student_sn";
			$res=$CONN->Execute($query);
			$ponder_array=unserialize($res->fields['ponder']);
			
			$ponder_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px; width:100%' bordercolor='#111111'>
			<tr bgcolor='#ccccff' align='center'><td>NO.</td><td>����</td><td>���e</td></tr>";
				
			$ponder_list.="<td bgcolor='$bgcolor'>";
			foreach($ponder_items as $key=>$value){
				$ii++;
				$ponder_list.="<tr><td align='center'>$ii</td><td>$value</td><td><textarea name='ponder[$key]' style='border-width:1px; width=100%; height=100%;'>{$ponder_array[$key]}</textarea></td></tr>";
			}
			$ponder_list.='</tr></table>';
			
			$showdata="$ponder_list";
			
			break;
		case 2:	
			//����ͲP��ܤ�V�ѷӪ�
			$direction_items=SFS_TEXT('�ͲP��ܤ�V');
			//���o�J�����
			$query="select direction from career_view where student_sn=$student_sn";
			$res=$CONN->Execute($query);
			$direction_array=unserialize($res->fields['direction']);			
			$max=max(3,count($direction_array['item']));

			$direction_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#ccccff' align='center'><td>����</td><td>�ۤv���Q�k</td><td>�a��������</td><td>�ǮձЮv����ĳ</td><td>�Ƶ�</td></tr>";
			
			$direction_initial=array(1=>'self',2=>'parent',3=>'teacher');
			for($i=1;$i<=$max;$i++){
				$direction_list.="<tr bgcolor='#ffeeee'><td align='center'>$i</td>";
				foreach($direction_initial as $key=>$value){
					$target="<select name='direction[item][$i][$value]'><option value=''></option>";
					foreach($direction_items as $d_key=>$d_value){
							$target_value=$direction_array['item'][$i][$value];
							$selected=($d_key==$target_value)?'selected':'';
							$target.="<option value='$d_key' $selected>$d_value</option>";					
					}
					$target.='</select>';
					$direction_list.="<td>$target</td>";				
				}
				$direction_list.="<td><textarea name='direction[item][$i][memo]' style='border-width:1px; width=100%; height=100%;'>{$direction_array[item][$i][memo]}</textarea></td></tr>";
			}
			
			$direction_list.='</table>';
			
			$direction_list.="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>";
			$checked=$direction_array['identical']?'checked':'';
			$direction_list.="<tr><td align='center' rowspan=2 bgcolor='#ccffcc'>�Q<br><br>�@<br><br>�Q</td><td colspan=5>1.�ۤv���Q�k�O�_�M�a������ΦѮv��ĳ�@�P�H <input type='checkbox' name='direction[identical]' value=1 $checked>�O
				<br><br>��]�G<textarea name='direction[reason]' style='border-width:1px; width=100%; height=100%; background:#ffeeee'>{$direction_array['reason']}</textarea></td></tr>
				<tr><td colspan=5>2.�p�G�ڪ��Q�k�P�a�������椣�P�A�i�H�p�󷾳q�O�H<br><textarea name='direction[communicate]' style='border-width:1px; width=100%; height=100%; background:#ffeeee'>{$direction_array['communicate']}</textarea></td></tr>";

			$direction_list.='</table>';
			
			//�Q��Ū���Ǭ�
			//$query="select * from career_school where student_sn=$student_sn order by aspiration_order";
			//$res=$CONN->Execute($query);
			
			
			$showdata="$direction_list";
			
			break;
		case 3:
			if($_POST['go']=='�ק�'){
				$query="update career_course set aspiration_order='{$_POST['aspiration_order']}',school='{$_POST['school']}',course='{$_POST['course']}',position='{$_POST['position']}',transportation='{$_POST['transportation']}',transportation_time='{$_POST['transportation_time']}',transportation_toll='{$_POST['transportation_toll']}',memo='{$_POST['memo']}' where sn={$_POST['edit_sn']}";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$_POST['edit_sn']=0;
			} elseif($_POST['go']=='�R��'){
				$query="delete from career_course where sn={$_POST['edit_sn']}";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$_POST['edit_sn']=0;
			} elseif($_POST['go']=='�s�W'){
				$query="insert into career_course set student_sn=$student_sn,aspiration_order=0,school='�������ߡ�������(¾)',position='����',transportation='�B����������������B�������������B��',transportation_time='���ɡ���',transportation_toll='����'";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
			}	
			
			$act='';
			//��������Y
			$course_list="���ǥͪ��p���a�}�G $stud_addr �C<br>���ڷQ��Ū���ǵ{�ά�O�G<input type='submit' name='go' value='�s�W'><input type='hidden' name='edit_sn' value=''><input type='hidden' name='add' value=''>
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px; width:800px' bordercolor='#111111'>
				<tr align='center' bgcolor='#ffcccc'>
				<td>���@��</td><td>�Ǯ�</td><td>�ǵ{�ά�O</td><td>�a�z��m</td><td>��q�覡</td><td>����ɶ�</td><td>���𨮸�</td><td>�Ƶ�</td>";
			
			//����ҵ{���@
			$query="select * from career_course where student_sn=$student_sn order by aspiration_order";
			$res=$CONN->Execute($query);
			if($res){
				while(!$res->EOF){
					$ii=$res->fields['aspiration_order'];
					$sn=$res->fields['sn'];
					if($_POST['edit_sn']==$sn){
						foreach($level_array as $key=>$value){
							$checked=($key==$res->fields['level'])?'checked':'';
							$level_radio.="<input type='radio' name='level' value='$key' $checked>$value<br>";
						}
						foreach($squad_array as $key=>$value){
							$checked=($key==$res->fields['squad'])?'checked':'';
							$squad_radio.="<input type='radio' name='squad' value='$key' $checked>$value<br>";
						}
						$course_list.="<tr align='center' bgcolor='#ffffcc'>
							<td><input type='text' name='aspiration_order' value='$ii' size=3><input type='hidden' name='del_sn' value='{$_POST['edit_sn']}'>
							<br><input type='submit' value='�ק�' name='go' onclick='document.myform.edit_sn.value=\"$sn\";return confirm(\"�T�w�n\"+this.value+\"?\")'>
							<br><input type='submit' value='�R��' name='go' onclick='document.myform.edit_sn.value=\"$sn\"; return confirm(\"�T�w�n\"+this.value+\"?\")'>
							<br><input type='reset' value='����' onclick='this.form.submit();'>
							</td>
							<td><input type='text' name='school' value='{$res->fields['school']}'></td>
							<td><input type='text' name='course' value='{$res->fields['course']}' size=10></td>
							<td><input type='text' name='position' value='{$res->fields['position']}' size=10></td>
							<td><input type='text' name='transportation' value='{$res->fields['transportation']}' size=30></td>
							<td><input type='text' name='transportation_time' value='{$res->fields['transportation_time']}' size=10></td>
							<td><input type='text' name='transportation_toll' value='{$res->fields['transportation_toll']}' size=5></td>
							<td><textarea name='memo'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['memo']}</textarea></td>
							</tr>";
					} else {
						$memo=str_replace("\r\n",'<br>',$res->fields['memo']);
						$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#ccccff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_sn.value=\"$sn\"; document.myform.submit();'";
						$course_list.="<tr align='center' $java_script>
							<td>$ii</td>
							<td><input type='button' style='border-width:1px; color:blue; width=100%;' value='{$res->fields['school']}' onclick='calcRoute(\"$stud_addr\",\"{$res->fields['school']}\");'></td>
							<td>{$res->fields['course']}</td>
							<td>{$res->fields['position']}</td>
							<td>{$res->fields['transportation']}</td>
							<td>{$res->fields['transportation_time']}</td>
							<td>{$res->fields['transportation_toll']}</td>
							<td align='left'>$memo</td>
							</tr>";	
					}
					$res->MoveNext();
				}
			} else $course_list.="<tr align='center'><td colspan=7 height=24>���o�{�Q��Ū���ǵ{�ά�O�����I</td></tr>";
			$course_list.="</table>";
			
			$showdata="<br>$course_list";
		
		break;
	}
	$geodata=($menu==3)?'<SCRIPT type=text/javascript src="http://maps.googleapis.com/maps/api/js?sensor=false"></SCRIPT>

	<SCRIPT type=text/javascript>
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
	var oldDirections = [];
	var currentDirections = null;

	function initialize() {
	var myOptions = {
	zoom: '.$gmap_zoom.',
	center: new google.maps.LatLng('.$gmap_location.'),
	mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	directionsDisplay = new google.maps.DirectionsRenderer({
	"map": map,
	"preserveViewport": true,
	"draggable": true
	});
	directionsDisplay.setPanel(document.getElementById("directions_panel"));

	google.maps.event.addListener(directionsDisplay, "directions_changed",
	function() {
	if (currentDirections) {
	oldDirections.push(currentDirections);
	setUndoDisabled(false);
	}
	currentDirections = directionsDisplay.getDirections();
	});

	setUndoDisabled(true);

	calcRoute("'.$stud_addr.'","'.$school_short_name.'");
	}

	function calcRoute(start,end) {
		
	var mstart = start;
    var mend = end;

	var request = {
	origin:mstart,
	destination:mend,
	travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsService.route(request, function(response, status) {
	if (status == google.maps.DirectionsStatus.OK) {
	directionsDisplay.setDirections(response);
	}
	});
	}

	function undo() {
	currentDirections = null;
	directionsDisplay.setDirections(oldDirections.pop());
	if (!oldDirections.length) {
	setUndoDisabled(true);
	}
	}

	function setUndoDisabled(value) {
	document.getElementById("undo").disabled = value;
	}


	$(function(){ 
		initialize();
	})
	</SCRIPT>

	<DIV style="WIDTH: 75%; FLOAT: left; HEIGHT: 500" id=map_canvas></DIV>
	<DIV style="WIDTH: 25%; FLOAT: right; HEIGHT: 500; OVERFLOW: auto">
		<BUTTON style="MARGIN: auto; DISPLAY: block" id="undo" onclick=undo()>Undo</BUTTON> 
	<DIV style="WIDTH: 100%; font-size: 12px; color:blue;" id=directions_panel></DIV></DIV>':'';

}
$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'><table style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$class_select<br>$student_select</td><td valign='top'>$memu_select $showdata<br>$act $geodata</td></tr></table></form></font>";

echo $main;

foot();

?>
