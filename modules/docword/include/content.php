<?php 
//���}�Y
function content_header() {
global $school_short_name,$page,$last_page,$page_count,$num_record,$QueryBeginDate,$QueryEndDate,$p_str;

$ptemp = $num_record - (($page) * $page_count);
if ( $ptemp > 0)
	$less_record = $page_count;
else
	$less_record = $page_count+$ptemp;
	
$temp = explode ("-",$QueryBeginDate);
$btemp = sprintf ("%d�~%d��%d��", $temp[0]-1911,$temp[1],$temp[2]);
$temp = explode ("-",$QueryEndDate);
$etemp = sprintf ("%d�~%d��%d��", $temp[0]-1911,$temp[1],$temp[2]);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title><?php echo $school_short_name ?> ����<?php echo $p_str ?>��</title>
</head>

<table border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;
 mso-padding-alt:0cm 1.4pt 0cm 1.4pt'>
 <tr>
  <td width=640 colspan=<?php if ($p_str!="�k��") echo 8; else echo 7; ?> valign=top style='width:479.8pt;padding:0cm 1.4pt 0cm 1.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'><?php echo $school_short_name ?>����<?php echo $p_str ?>��</span><span lang=EN-US><o:p></o:p></span></b></p>
  <p class=MsoNormal align=right style='font-size=8pt;text-align:right'><span
  style='font-size=10pt;font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'>�n������G<?php echo "$btemp �� $etemp" ?></span><span lang=EN-US><span
  style='mso-tab-count:1'>&nbsp;&nbsp; </span></span><span style='font-size=10pt;font-family:�s�ө���;
  mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman"'><?php echo "�� $page ��/�@ $last_page ��(���� $less_record ��)" ?></span><b><span lang=EN-US><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='height:30.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt;'>
  <td width=2 style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'
  width=2><p class='MsoNormal'>&nbsp;</td>
  <td width=62 style='width:46.4pt;border-top:1.5pt;border-left:1.5pt;
  border-bottom:.75pt;border-right:.75pt;border-color:windowtext;border-style:
  solid;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'>���帹</span></p>
  </td>
  <td width=70 style='width:52.6pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-left-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;' nowrap>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'>������<br>���</span></p>
  </td>
  <td width=72 style='width:54.0pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-left-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'>���o�帹</span></p>
  </td>
  <td width=<?php if ($p_str != "�k��") echo 252; else echo 324?> style='width:<?php if ($p_str != "�k��") echo 189; else echo 243?>pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-left-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'>���D��</span></p>
  </td>
  <?php if ($p_str != "�k��")
  echo "
  <td width=72 style='width:54.0pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-left-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:
  'Times New Roman''>��z���</span></p>
  </td>
  " ?>
  <td width=108 style='width:81.0pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext .75pt;border-right:solid windowtext 1.5pt;
  mso-border-left-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-family:�s�ө���;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
  "Times New Roman"'><?php echo $p_str ?></span></td>
  <td style='width:3.0pt;mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'
  width=2><p class='MsoNormal'>&nbsp;</td>
 </tr>
<?php
}


//�@�뤺�e����
function content_normal() {
global $doc1_id,$doc1_date,$doc1_word,$doc1_main,$doc1_unit_num1,$doc1_unit,$p_str;
?>
 <tr style='height:40.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
  <td style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'
  width=2><p class='MsoNormal'>&nbsp;</td>
  <td style='border-top:none;border-left:solid windowtext 1.5pt;
  border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-top-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><?php echo $doc1_id ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext .75pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><font size="2"><![if !supportEmptyParas]><?php echo "$doc1_date<BR><font size='-1'>$doc1_unit</font>" ?><![endif]></font><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext .75pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><font size="2"><?php echo $doc1_word ?><![endif]></font><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;
  border-bottom:solid windowtext .75pt;border-right:solid windowtext .75pt;
  mso-border-top-alt:solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;
  padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph;font-size=15;'><![if !supportEmptyParas]><?php echo substr($doc1_main,0,90)."..." ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <?php if ($p_str != "�k��")
  echo "
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext .75pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><?php echo $doc1_unit_num1 ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  " ?>
  <td style='border-top:none;border-left:none;
  border-bottom:solid windowtext .75pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;
  padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]>&nbsp;<![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'><p class='MsoNormal'>&nbsp;</td>
 </tr>
<?php
}

//���e����
function content_end() {
global $doc1_id,$doc1_date,$doc1_word,$doc1_main,$doc1_unit_num1,$doc1_unit,$p_str;
?>
<tr style='height:40.0pt;mso-row-margin-left:1.4pt;mso-row-margin-right:1.4pt'>
  <td style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'
  width=2><p class='MsoNormal'>&nbsp;</td>
  <td width=62 style='width:46.4pt;border-top:none;border-left:solid windowtext 1.5pt;
  border-bottom:solid windowtext 1.5pt;border-right:solid windowtext .75pt;
  mso-border-top-alt:solid windowtext .75pt;padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><?php echo $doc1_id ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext 1.5pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><font size="2"><![if !supportEmptyParas]><?php echo "$doc1_date<BR>$doc1_unit" ?><![endif]></font><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext 1.5pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><font size="2"><?php echo $doc1_word ?><![endif]></font><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='border-top:none;border-left:none;
  border-bottom:solid windowtext 1.5pt;border-right:solid windowtext .75pt;
  mso-border-top-alt:solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;
  padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph;font-size=15;'><![if !supportEmptyParas]><?php echo substr($doc1_main,0,90)."..." ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <?php if ($p_str != "�k��")
  echo "
  <td style='border-top:none;border-left:none;border-bottom:
  solid windowtext 1.5pt;border-right:solid windowtext .75pt;mso-border-top-alt:
  solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;padding:
  0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]><?php echo $doc1_unit_num1 ?><![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  " ?>
  <td style='border-top:none;border-left:none;
  border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .75pt;mso-border-left-alt:solid windowtext .75pt;
  padding:0cm 1.4pt 0cm 1.4pt;'>
  <p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><![if !supportEmptyParas]>&nbsp;<![endif]><span
  lang=EN-US><o:p></o:p></span></p>
  </td>
  <td style='mso-cell-special:placeholder;border:none;padding:0cm 0cm 0cm 0cm'><p class='MsoNormal'>&nbsp;</td>
 </tr>
<?php
}

//��󵲧�
function content_footer() {
?>
  
 <![if !supportMisalignedColumns]>
 <tr height=0>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
  <td style='border:none'></td>
 </tr>
 <![endif]>
</table>

</body>
</html>
<?php
}

//����
function page_break() {
?>
<span lang="EN-US" style="font-size:6.0pt;"><br clear="all" style="mso-special-character:line-break;page-break-before:always">
</span>
<?php
}
?>