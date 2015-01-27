<?php
require  "config.php";
$class_base =class_base();
$classNumber = (int)$_GET['selClass'];

$query = "SELECT a.id,a.title, a.student_sn, DATE_FORMAT(a.publish_time,'%Y-%m-%d')  AS date, a.hits, a.class_number ,b.stud_name FROM artical_detail a LEFT JOIN stud_base b ON a.student_sn=b.student_sn
WHERE a.class_number LIKE '$classNumber%' ORDER BY a.publish_time DESC";
$res = $CONN->Execute($query) or die($query);


head();
print_menu($menu_p);
?>
<h1><?php echo $class_base[$classNumber]?> ���峹�C��</h1>
<table>
<thead>
<tr>
<th>�s��</th>
<th>�D�D</th>
<th>�@��</th>
<th>�o���ɶ�</th>
<th>�I�\��</th>

</tr>
</thead>
<tbody>
<?php foreach($res as $row):?>
<tr>
<td><?php echo $row['id']?></td>
<td><a href="show.php?id=<?php echo $row['id']?>"><?php echo $row['title']?></a></td>
<td><a href="showStudent.php?selStudent=<?php echo $row['student_sn']?>"><?php echo $row['stud_name']?></a></td>
<td><?php echo $row['date']?></td>
<td><?php echo $row['hits']?></td>
</tr>
<?php endforeach?>
</tbody>


</table>


<?php foot()?>