{{* $Id: health_sight_ntu_list.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>����P���`�ǥͦW�U</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=i value=1}}
{{foreach from=$health_data->stud_base item=d key=sn name=rows}}
{{assign var=year_name value=$d.seme_class|@substr:0:1}}
{{assign var=class_name value=$d.seme_class|@substr:-2:2}}
{{assign var=class_name value=$class_name|@intval}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{if $i % 35 == 1}}
<TABLE style="border-collapse: collapse; margin: auto; font: 14pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 10pt �s�ө���,�s�ө���,serif;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
		<TR style="font: 16pt �s�ө���,�s�ө���,serif;">
		  <TD colSpan="9">����P�ˬd���`�ǥͦW�U</TD>
		</TR>
		<TR>
		  <TD colSpan="3" style="text-align: center;">{{$school_data.sch_cname}} {{$school_data.sch_id}}</TD>
		  <TD colSpan="6" style="text-align: right;">�C�L�ɶ��G{{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}}</TD>
		</TR>
        <TR style="height: 14pt;text-align: left;">
          <TD style="border-top: windowtext 1.5pt solid;">�~��</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�Z��</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�y��</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�m�W</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�ʧO</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�����Ҧr��</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�E�_</TD>
          <TD style="border-top: windowtext 1.5pt solid;">��L�E�_</TD>
          <TD style="border-top: windowtext 1.5pt solid;">�N�E��|</TD>
		</TR>
{{/if}}
        <TR style="height: 14pt;text-align: left;">
          <TD style="border-top: windowtext 0.75pt solid;">{{$year_data[$year_name]}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;">{{$class_data[$d.seme_class]}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;">{{$d.seme_num}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;">{{$d.stud_name}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;">{{if $d.stud_sex==1}}�k{{else}}�k{{/if}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;">{{$d.stud_person_id}}</TD>
          <TD style="border-top: windowtext 0.75pt solid;"></TD>
          <TD style="border-top: windowtext 0.75pt solid;"></TD>
          <TD style="border-top: windowtext 0.75pt solid;"></TD>
		</TR>
{{if $i % 35 == 0}}
        <TR style="height: 20pt;text-align: left;">
          <TD colSpan="9" style="border-top: windowtext 1.5pt solid;"></TD>
		</TR>
        <TR style="height: 60pt;text-align: left;">
          <TD colSpan="9" style="border-top: windowtext 1.5pt solid; vertical-align: top;">
		  <TABLE WIDTH=100% style="margin:auto;"><TR style="font-size: 10pt;">
		  <TD WIDTH=25%>�ӿ�H</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  <TD WIDTH=25%>�D��</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  </TR></TABLE>
		  </TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/if}}
{{assign var=i value=$i+1}}
{{/foreach}}
{{if $i % 35 != 1}}
        <TR style="height: 20pt;text-align: left;">
          <TD colSpan="9" style="border-top: windowtext 1.5pt solid;"></TD>
		</TR>
        <TR style="height: 60pt;text-align: left;">
          <TD colSpan="9" style="border-top: windowtext 1.5pt solid; vertical-align: top;">
		  <TABLE WIDTH=100% style="margin:auto;"><TR style="font-size: 10pt;">
		  <TD WIDTH=25%>�ӿ�H</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  <TD WIDTH=25%>�D��</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  </TR></TABLE>
		  </TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/if}}
</BODY></HTML>
