{{* $Id: stud_basic_test_distest3_print.tpl 5844 2010-02-10 15:18:23Z brucelyc $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>99����ϰ���¾�K�դJ�Ǧb�ժ�{�ҩ���</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class name=rows}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; font: 12pt Times New Roman,�з���,�з���; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt Times New Roman,�з���,�з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="8" style="font-size: 20pt; font-weight: bold;">�����99�Ǧ~�װ�����¾�K�դJ��<br>�b�ժ�{�ҩ���</TD>
		</TR>
		<TR>
		  <TD colSpan="8" style="height: 40pt; text-align: left;">�@�B�ǥͰ򥻸��</TD>
		</TR>
        <TR style="height: 30pt; font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�ǥͩm�W</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font-size: 18pt;" 
          colSpan="3">{{$stud_data.$sn.stud_name}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�ʡ@�O</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="3">{{if $stud_data.$sn.stud_sex==1}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{else}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{/if}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�NŪ�Ǯ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid; font-size: 13pt;" 
          colSpan="3">{{$sch_arr.sch_cname}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" 
          >�͡@��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="3">{{$stud_data.$sn.stud_birthday}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�NŪ�Z��</TD>
{{assign var=y value=$seme_class|@substr:0:-2}}
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="3"><span style="font-size: 18pt;">{{$y-6}} </span> �~ <span style="font-size: 18pt;"> {{$seme_class|@substr:-2:2|@intval}} </span> �Z�y���G<span style="font-size: 18pt;">{{$site_num}}</span></TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          >�����Ҧr��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font: 16pt Times New Roman,�з���,�з���;" 
          colSpan="3">{{$stud_data.$sn.stud_person_id}}</TD>
		</TR>
		<TR>
		  <TD colSpan="8" style="height: 40pt; text-align: left;">�G�B�b�ժ�{</TD>
		</TR>
        <TR style="height: 27pt;font-size: 14pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: left;" 
          colSpan="3">�@����</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >��G<br>�W�Ǵ�</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >��G<br>�U�Ǵ�</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >��T<br>�W�Ǵ�</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >����</TD>
		  <TD style="width:12.5%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          >PR��</TD>
		</TR>
{{foreach from=$s_arr item=sl key=j}}
        <TR style="height: 28pt;font-size: 14pt;">
{{if $j==1}}
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          rowSpan="3">�@�y��<br>�@���</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="2">�@{{$sl}}</TD>
{{elseif $j==2 || $j==3}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="2">�@{{$sl}}</TD>
{{else}}
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="3">�@{{$sl}}</TD>
{{/if}}
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          >{{$rowdata.$sn.0.$j.score}}</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          >{{$rowdata.$sn.1.$j.score}}</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          >{{$rowdata.$sn.2.$j.score}}</TD>
          <TD style="width:12.5%; border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          >{{$rowdata.$sn.3.$j.score|string_format:"%.2f"}}</TD>
		  <TD style="width:12.5%; border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 16pt; font-weight: bold;" 
          >{{$rowdata.$sn.3.$j.pr}}</TD>
		</TR>
{{/foreach}}
        <TR style="height: 0pt;">
          <TD style="border-top: windowtext 1.5pt solid;" colSpan="8"></TD>
		</TR>
		<TR>
		  <TD colSpan="8" style="height: 40pt; text-align: left;">�T�B�b�ժ�{�ĭp�覡</TD>
		</TR>
		<TR>
		  <TD colSpan="8" style="text-align: left; font-size: 12pt;">
		  <TABLE style="width:100%;">
		  <TR>
		    <TD style="vertical-align: top;" nowrap>1.�ĭp�覡�G</TD>
		    <TD>�ĭp�T�Ǵ��]��G�W�B�U�Ǵ��B��T�W�Ǵ��^�C�j��줧�Ǵ����Z�]���ܤp�Ʋ�2��^�C</TD>
		  </TR>
		  <TR>
		    <TD style="vertical-align: top;" nowrap>2.�e�{�覡�G</TD>
		    <TD>�U�ꤤ�����O�e�{�ǥͦb�y����B�ƾǻ��B�۵M�P�ͬ���޻��B���|���B���d�P��|���B���N�P�H����B��X���ʻ�쵥�K���ʤ����š]PR�ȡ^�C</TD>
		  </TR>
		  </TABLE>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-top: windowtext 0.75pt dashed; text-align: right;" colSpan="2">�ꤤ�f��<br>�H���ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="3"></TD>
          <TD style="border-top: windowtext 0.75pt dashed; text-align: left;" colSpan="2">��@�@�@��<br>�аȳB�ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="3"></TD>
		</TR>
        <TR>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
          <TD width="12.5%">&nbsp;</TD>
		</TR>
		</TBODY>
	  </TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
{{/foreach}}
</BODY></HTML>
