<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>����P���`�q����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{foreach from=$health_data->stud_base item=d key=sn name=rows}}
{{assign var=year_name value=$d.seme_class|@substr:0:-2}}
{{assign var=class_name value=$d.seme_class|@substr:-2:2}}
{{assign var=class_name value=$class_name|@intval}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
<TABLE style="border-collapse: collapse; margin: auto; font: 14pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 14pt �з���,�з���,serif;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 16pt;">
          <TD colSpan="6" style="font-size:16pt;"><span style="font-size: 14pt;">{{$school_data.sch_cname}}</span>�@�@<strong>����P���`�q����</strong></TD>
		</TR>
		<TR>
		  <TD colSpan="6" style="text-align: left;">
		  <strong>{{$year_data.$year_name}}{{$class_data[$d.seme_class]}}�Z {{$d.seme_num}} �� {{$health_data->stud_base.$sn.stud_name}}</strong><br>
		  �˷R���a���G<br>
		  �����F�A�ѶQ�l�̪����O���p�A���նi�����P�z�ˤu�@�A���G�p�U�G<br>
		  </TD>
		</TR>
        <TR style="height: 20pt;font-size: 12pt;">
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="2">�r�����O</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="2">�B�����O</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="2" rowSpan="2">NTU����Ͽz��</TD>
		</TR>
        <TR style="height: 20pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�k��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" 
          >����</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�k��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" 
          >����</TD>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          >{{$dd.r.sight_o}}</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >{{$dd.l.sight_o}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >{{$dd.r.sight_r}}</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >{{$dd.l.sight_r}}</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="2">����P���`</TD>
		</TR>
		<TR>
		  <TD colSpan="6" style="text-align: left;">
		  �гt�a�Q�l�̨체����v�B�����i�@�B�E�v�A�ý���v�N�E�v���G����ᤧ�^����ѯť��Ѯv�]�ɮv�^���ٰ��d���ߡC���¦X�@�I
          <p style="font-size: 12pt; text-align: right;">{{$school_data.sch_cname}} ���d���ߡ@�q�ҡ@�@ {{$smarty.now|date_format:"%Y"}} �~ {{$smarty.now|date_format:"%m"}} �� {{$smarty.now|date_format:"%d"}} ��@�@</p>
		  <p style="border-bottom: dashed 4px;"></p>
		  <p style="font-size: 16pt; text-align: center; height: 16pt;"><strong>��|�]�E�ҡ^����ˬd�^��</strong></span></p>
		  <strong>{{$year_data.$year_name}}{{$class_data[$d.seme_class]}}�Z {{$d.seme_num}} ��       �ǥͩm�W�G{{$health_data->stud_base.$sn.stud_name}}</strong><br>
		  �@�B�E���|�ҦW�١G<br>
		  �G�B�ˬd����G�@�@�@�~�@�@�@��@�@�@��<br>
		  �T�B��vñ���G<br><br>
		  �|�B��v�ˬd���G�G�@�����`�@�����`�]�Щ�U�C���إ��ġA�i�ƿ�^<br>
		  �@1.�z���G�@�������@���k���@�������@�@���B��0.5�H�U<br>
		  �@2.�׵��G�@�����ס@���~�ס@���W�U�ס@���沴<br>
		  �@3.�}�������G�]������^<br>
		  �@�@(1)����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(2)�����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(3)�����G�@�������@���k���@�������@���׼ơG<u>�@�@</u><br>
		  �@�@(4)�������G��<br>
		  �@4.��L���`�G�]�е����^<br><br>
		  ���B��v��ĳ�B�z�G�]�i�ƿ�^<br>
		  �@��(1)�t�����B���@��(2)����@��(3)�B���v���@��(4)�I��<br>
		  �@��(5)�w���l�ܡ@�@��(6)��L<u>�@�@�@�@�@�@�@�@�@�@�@�@</u><br>
		  ���B���체����˩��~��v����]�G<br>
		  �@��(1)�t���v���@��(2)��q���K�@��(3)�a���S�ɶ��@��(4)�g�٧x��<br>
		  �@��(5)���ݭn�@�@��(6)��L<u>�@�@�@�@�@�@�@�@�@�@�@�@</u>
		  <p style="font-size: 14pt; text-align: right;">�a��ñ���G�@�@�@�@�@�@�@�@�~�@�@��@�@��</p>
		  </TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
</BODY></HTML>
