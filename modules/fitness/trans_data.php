<?php
// $Id: index.php 5310 2009-01-10 07:57:56Z hami $
//�ߪ;A��Ѥ�'��"�ഫ����

if ($_POST['mode']=="trans") {
 
 $buffer = explode("\n",$_POST['data']);
 foreach ($buffer as $B) {
  $data=explode(",",$B);
  echo $data[0].",";
  for ($i=1;$i<count($data);$i++) {
   $D=explode("'",$data[$i]);
   $S=$D[0]*60+$D[1];
   echo $S;
   if ($i<count($data)-1) echo ",";
  }
  echo "<br>";
 }
} // end if


?>
<table border="0">
	<tr>
		<td>�ߪ;A��Ѥ�'��"�ഫ����,</td>
		</tr>
	<tr>
		<td>����Ш|����l��K��excel, �A�t�s�� CVS, �A�Q�ΰO�ƥ��}�ҶK�L��</td>
		</tr>
	</table>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <input type="hidden" name="mode" value="trans">
 <textarea cols="80" rows="20" name="data"></textarea>
 <input type="submit" value="�e�X">
</form>
