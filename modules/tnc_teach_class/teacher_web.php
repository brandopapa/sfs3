<?php

// $Id: teacher_web.php 8691 2015-12-25 03:12:24Z qfon $

/*
  �Юv�����Bemail���G
  prolin(prolin@sy3es.tnc.edu.tw) 90/3/8
*/

// --�t�γ]�w��
include "teach_config.php";



//������O�A�W�[
$modestr = array("0"=>"�����H��","x"=>"��F�H��","y"=>"��������" ,"z"=>"���",);
//�B�ǿ��
$post_office_p = room_kind();

$selmode=$_POST['selmode'];

  //$debug = 1;
  
  if (!isset($selmode))$selmode = '0' ;
  switch ($selmode) {
    case '0':	//����
      $wherestr = " and  email <>'' order by b.teach_title_id, b.class_num " ;
      break;
   case 'x':	//��F
      $wherestr = " and title_name not like '%�Юv' order by b.teach_title_id " ;
      break;      
      
    case 'z':	//���
      $wherestr = "  and title_name like '���%'  order by b.teach_title_id " ;
      break;
    case 'y':	//��������
      $wherestr = " and (selfweb <>'' or classweb <>'')  order by b.teach_title_id " ;
      break;       
    case 'a':	//���X��
      $wherestr = " and title_name like '���X%' order by b.class_num " ;
      break;       
            
    default:	//�@�ܤ��~�šB���X��B�귽�Z
      $wherestr = " and b.class_num LIKE '". intval($selmode) ."%' order by b.class_num " ;  
      break ;
  }    

  $sqlstr = " SELECT e.* ,a.name, b.post_kind, b.post_office, d.title_name ,b.class_num 
              FROM teacher_connect e, teacher_base a , teacher_post b, teacher_title d 
              where e.teach_id = a.teach_id and e.teach_id =b.teach_id  
              and b.teach_title_id = d.teach_title_id  
              and a.teach_condition = 0 " . $wherestr ;
  if ($debug) echo $sqlstr ;
$result = $CONN->Execute($sqlstr) or die ($sqlstr);			

?>  
<html>
<head>
<title><?php echo $school_short_name; ?>��¾���b���B����</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style type="text/css">
<!--
.tr1 {  background-color: #FFFF; text-align: center}
.tr2 {  background-color: #faeaea; text-align: center}
.trtop {  font-weight: bold; background-color: #CCCCFF; text-align: center}

a:visited {  text-decoration: none}
a:active {  text-decoration: none}

a:hover {  background-color: #66FF66}
a:link {  text-decoration: none}
-->
</style>
<script language="JavaScript">
	<!-- Begin

   	function jumpMenu(){
     location="<?php echo basename({$_SERVER['PHP_SELF']})."?selmode="?>" +document.myform.selmode.options[document.myform.selmode.selectedIndex].value;

	}
    //  End --> 
</script>
</head>

<?php 

  //include $head ;
?>
<body bgcolor="#FFFFFF">
<form name="myform" >
   <table width="95%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr bgcolor="#CCCCFF"> 
      <td width="66%"><?php echo $school_short_name ?>��¾���q�l�l��b���B�����@���� </td>
      <td width="34%"> ������O�G 
        <select name="selmode" onChange="jumpMenu()">
          <?php
          reset($modestr);
          while(list($tkey,$tvalue)= each ($modestr))
		  {
	      if ($tkey == $selmode)
		  echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
	      else
		  echo sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
          }              
            reset($class_year);
            while(list($tkey,$tvalue)= each ($class_year))
			{
	       if ($tkey == $selmode)
		   echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
	       else
		   echo sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
            
		    }   
          ?>
        </select>

    </td>
  </tr>
</table>

  <table width="95%" border="1" cellspacing="0" cellpadding="4" align="center" bordercolorlight="#6666FF" bordercolordark="#FFFFFF">
    <tr  class="trtop"> 
      <td  class="trtop">���</td>
      <td  class="trtop">¾��</td>
      <td  class="trtop">�m�W</td>
      <td  class="trtop">�q�l�l��  </td>
      <td  class="trtop">�ӤH����</td>
      <td  class="trtop">�Z�ź���</td>
    </tr>
    <?php
  //�C�L�X�ӤH���
  
  $rowi = 0  ;
  while(!$result->EOF)
    {     
      $s_unit= $result->fields["post_office"] ;

      //�j���ܦ�
      if ($rowi)
	  {
        $rowi = 0  ;	
        echo '<tr class="tr2">' ;
      }  
      else 
	  {
        $rowi = 1  ; 
        echo '<tr class="tr1">' ;
      } 
       
      //���
      echo "<td nowap>";
      if (strpos($post_office_p[$s_unit],'���'))
        echo "&nbsp" ;
      else
        if ($result->fields["class_num"]) {//�ť� 
          $temp_year = $class_year[substr($result->fields["class_num"],0,1)] ;
          $temp_class =$class_name[substr($result->fields["class_num"],1)] ;
          echo $temp_year . $temp_class ."�Z";
        }  
        else   echo $post_office_p[$s_unit] ;
      echo "</td>" ;   
       
      //¾��  
      echo "<td nowap>".$result->fields["title_name"]."</td>" ;
            
      //�m�W      
      echo "<td nowrap>".$result->fields["name"]."</td>" ;
      
      //�q�l�l��
      echo "<td nowrap>" ;
      if ($result->fields["email"]) 
           echo "<a href=\"mailto:".$result->fields["email"]."\"  target=\"_blank\">".$result->fields["email"]."</a> " ;
      else 
        echo "&nbsp" ;
      echo "</td>" ;  
            
      //�ӤH����
      echo "<td nowrap>" ;
      if ($result->fields["selfweb"]) 
           echo "<a href=\"".$result->fields["selfweb"]."\"  target=\"_blank\"><img src=\"images/myhome.gif\" border=\"0\"></a> " ;
      else 
        echo "&nbsp" ;
      echo "</td>" ;        
      
      //�Z�ź���
      echo "<td nowrap> " ;
      if ($result->fields["classweb"]) 
        echo "<a href=\"".$result->fields["classweb"]."\"  target=\"_blank\"><img src=\"images/home.gif\" border=\"0\"></a> " ;
      else 
        echo "&nbsp" ;  
      echo "</td>" ;  
      
      echo "</tr> \n" ;
      
      $result->MoveNext();
     }
	 
	 
?>
  </table>
</form>

<?php 

  foot() ; 
?>
