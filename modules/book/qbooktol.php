<?php
                                                                                                                             
// $Id: qbooktol.php 5310 2009-01-10 07:57:56Z hami $

include "book_config.php";
include "header.php";
echo "<center><BR><H3>���չϮѫ� �ѥزέp��</H3>";
echo "<table border=1 width=80% align=center>";
echo "<tr><td bgcolor=#8080FF width=20% align=center><strong>������</strong></td>";
echo "<td bgcolor=#8080FF width=60% align=center><strong>�ϮѤ���</strong></td>";
echo "<td bgcolor=#8080FF width=20% align=center><strong>�ƶq(�U)</strong></td></tr>";
//$query = " select * from bookch1 order by bookch1_id ";
$query = "SELECT a.bookch1_id, a.bookch1_name, COUNT(*) AS cc  FROM bookch1 a, book b WHERE a.bookch1_id=b.bookch1_id GROUP BY b.bookch1_id";
$result= mysql_query($query,$conID);
$i=0;
$tol=0;
while ($row = mysql_fetch_array($result)){
	if ($i % 2 == 1 )
		echo "<tr bgcolor=#FFFF80>";
	else
		echo "<tr>";
	echo sprintf("<td  align=center >%s</td><td  align=center ><a href=\"%s?bookch1_id=%s\">%s</a></td><td align=center>%s</td></tr>",$row["bookch1_id"],"qbook.php",$row["bookch1_id"],$row["bookch1_name"],$row["cc"]);
	$tol +=$row["cc"];
}
echo "<tr><td bgcolor=#8080FF width=20% align=center><strong>�X�p</strong></td>";
echo "<td bgcolor=#8080FF width=60% align=center></td>";
echo "<td bgcolor=#8080FF width=20% align=center><strong>$tol</strong></td></tr>";
echo "</table>";
echo "</center>";
include "footer.php";
?>
