<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>���έp��</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
<TABLE style="border-collapse: collapse; margin: auto; font: 12pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
{{assign var=year value=$smarty.post.year_seme|@substr:0:3}}
        <TR style="height: 30pt; text-align: center;">
          <TD style="font-size:12pt;" colSpan="7">{{$school_data.sch_cname}} {{$year|intval}}�Ǧ~�� ��{{$smarty.post.year_seme|@substr:-1:1}}�Ǵ� ���έp��</TD>
		</TR>
        <TR style="height: 30pt; text-align: center;">
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          rowSpan="2" colSpan="2">�~�� / �ʧO</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="5">��@��@�P�@Ū</TD>
		</TR>
{{php}}$this->_tpl_vars['v'][9][9]=$this->_tpl_vars['v'][1][9]+$this->_tpl_vars['v'][2][9];{{/php}}
        <TR style="height: 30pt; text-align: center;">
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�L��</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�A��</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�L��</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�W��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�X�p</TD>
		</TR>
{{foreach from=$data_arr item=d key=i}}
{{foreach from=$sex_arr item=dd key=j}}
{{if $j=="all"}}{{assign var=b value=1.5}}{{else}}{{assign var=b value=0.75}}{{/if}}
{{if $i!="all"}}
        <TR style="height: 25pt; text-align: right;">
{{if $j==1}}
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; text-align: center;" 
          rowSpan="3">{{$i}}�@</TD>
{{/if}}
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext {{$b}}pt solid; text-align: center;" 
          >{{$dd}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$d.$j.0}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$d.$j.1}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$d.$j.2}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$d.$j.3}}�@</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$d.$j.all}}�@</TD>
		</TR>
{{/if}}
{{/foreach}}
{{/foreach}}
        <TR style="height: 30pt; text-align: right;">
		  <TD style="border-right: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; text-align: center;" 
          colSpan="2">�`�p</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$data_arr.all.all.0}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$data_arr.all.all.1}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$data_arr.all.all.2}}�@</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$data_arr.all.all.3}}�@</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext {{$b}}pt solid;" 
          >{{$data_arr.all.all.all}}�@</TD>
		</TR>
        <TR style="height: 90pt; text-align: right;">
          <TD style="font-size:12pt; border-top: windowtext 1.5pt solid; text-align: center;" colSpan="7">�ӿ�H�@�@�@�@�@�@�@�ժ��@�@�@�@�@�@�@�D���@�@�@�@�@�@�@�ժ��@�@�@�@�@�@�@</TD>
		</TR>
  </TBODY>
</TABLE>
</BODY></HTML>
