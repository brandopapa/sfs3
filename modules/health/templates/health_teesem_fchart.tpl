{{* $Id: health_teesem_fchart.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>�t�t�����f�p�e�W�U�[��I��</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
<TABLE style="border-collapse: collapse; margin: auto; letter-spacing: -0.1em; font: 10pt �з���,�з���,serif; width: 480pt;{{if $smarty.post.allchart}} page-break-after: always;{{/if}}" cellSpacing="0" cellPadding="0" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font-size: 10pt; width: 480pt;" cellSpacing="0" cellPadding="0" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="{{$rows}}" style="font-size:14pt;">{{$school_data.sch_cname}}�@<strong>�t�t�����f�p�e�W�U�[��I��</strong></TD>
		</TR>
		<TR style="height: 20pt;">
		  <TD colSpan="10" style="text-align: left;">{{$class_data[$smarty.post.class_name]}}</TD>
		  <TD colSpan="{{$rows-10}}" style="text-align: right;">���Юv�m�W�G�@�@�@�@�@�@�@�@�@</TD>
		</TR>
		<TR style="height: 20pt;">
		  <TD colSpan="{{$rows}}" style="text-align: left;">�Ƶ��G�бN���ѥ[���f���p�e�]�Y���o�a���P�N�̡^���ǥ;��湺���C�ʮu�̥��u���v�A�X�u�B�����f�̥��u���v�A�X�u�������f�̥��u�G�v�C</TD>
		</TR>
        <TR>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; width: 15pt;" 
          rowSpan="2">�y<br>��</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid; width: 80pt;" 
          >�g�O</TD>
{{php}}
$this->_tpl_vars['w']=round(395/($this->_tpl_vars['rows']-2));
{{/php}}
{{foreach from=$date_arr item=d}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid; width: {{$w}}pt; text-align: center;" 
          >{{$d.week_no}}</TD>
{{/foreach}}
		  <TD style="border-right: windowtext 0pt solid; border-top: windowtext 0pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0pt solid;"
          ></TD>
		</TR>
        <TR>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�m�@�W</TD>
{{foreach from=$date_arr item=d}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$d.do_date|@substr:5:2}}<br>��<br>{{$d.do_date|@substr:8:2}}</TD>
{{/foreach}}
          <TD style="border-right: windowtext 0pt solid; border-top: windowtext 0pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0pt solid;"
		  ></TD>
		</TR>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num}}
{{assign var=sn value=$d.student_sn}}
        <TR>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$seme_num}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >{{$health_data->stud_base.$sn.stud_name}}</TD>
{{foreach from=$date_arr item=d key=i}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�@</TD>
{{/foreach}}
          <TD style="border-right: windowtext 0pt solid; border-top: windowtext 0pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0pt solid;"
		  ></TD>
		</TR>
{{/foreach}}
{{foreach from=$i_arr item=d}}
        <TR>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;"
		  ></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  ></TD>
{{foreach from=$date_arr item=d}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-left: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;"
		  >�@</TD>
{{/foreach}}
          <TD style="border-right: windowtext 0pt solid; border-top: windowtext 0pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0pt solid;"
		  ></TD>
		</TR>
{{/foreach}}
        <TR>
          <TD style="border-top: windowtext 1.5pt solid;"></TD>
          <TD style="border-top: windowtext 1.5pt solid;"></TD>
{{foreach from=$date_arr item=d}}
          <TD style="border-top: windowtext 1.5pt solid;"></TD>
{{/foreach}}
          <TD></TD>
		</TR>
		</TBODY>
	  </TABLE><br>
	</TD>
  </TR>
  </TBODY>
</TABLE>
</BODY></HTML>
