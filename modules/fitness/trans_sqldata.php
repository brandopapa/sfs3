<?php
// $Id: index.php 5310 2009-01-10 07:57:56Z hami $
//�ߪ;A��Ѥ�'��"�ഫ����

if ($_POST['mode']=="trans") {
 
 $m_stnum=$_POST['m_stnum'];
 $m_no=$_POST['m_no'];
 $m_sex=$_POST['m_sex'];
 
 $buffer = explode("\n",$_POST['data']);
 
 $D=array();
 
 foreach ($buffer as $B) {
    $W=explode("\t",$B);
    $P=$W[0];
    //�q $W[1]~$W[9] ���O�O 10����18�����ʤ���`�Ҽƾ�
   for ($i=1;$i<10;$i++) {
     $age=9+$i;
     $D[$age][$P]=$W[$i];  //�Y�~�ŬY�ʤ��񪺱`�Ҽƾ�   
   } // end for
 } // end foreach
  
  
 for ($i=10;$i<=18;$i++) {
 	$c=$m_stnum+$i-10;
  $P_DATA="INSERT INTO fitness_mod VALUES (".$c.",".$m_no.",".$m_sex.",".$i;
  //��1~99���ƾڥ[�W��
  for ($ii=1;$ii<100;$ii++) {
  	$P_DATA.=",".$D[$i][$ii];  
  }
  $P_DATA.=");";
  echo $P_DATA."<br>";
 } 
} // end if


?>
<table border="0">
	<tr>
		<td>�`�ҧ�s�ন sql ���O</td>
		</tr>
	<tr>
		<td>�K CVS ��</td>
		</tr>
	</table>
	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <input type="hidden" name="mode" value="trans">
	<table border="0" width="100%">
			<tr>
			<td>�`�ҫe�m�_�l�s��<input type="text" size="5" name="m_stnum"></td>
		</tr>
		<tr>
			<td>�`�ҽs��(0����,1�魫,2������e�s,3���װ_��60��,4�ߩw����,5�ߪ;A��,6BMI) <input type="text" size="30" name="m_no"></td>
		</tr>
		<tr>
			<td>�`�ҩʧO(1�k��,2�k��) <input type="text" size="30" name="m_sex"></td>
		</tr>
		<tr>
		 <td>
		 	<textarea cols="80" rows="20" name="data"></textarea>
		 	</td>	
		</tr>
		</table>

 
 
 <input type="submit" value="�e�X">
</form>
