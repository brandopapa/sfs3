{{* $Id: stud_basic_test_distest4_print_chc.tpl 5893 2010-03-08 06:04:51Z brucelyc $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>�K�դJ�Ǧb�ժ�{�ҩ���</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; font: 12pt Times New Roman,�з���,�з���; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt Times New Roman,�з���,�з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="20" style="font-size: 20pt; font-weight: bold;">�K�դJ�Ǧb�ժ�{�ҩ���</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�@�B�ǥͰ򥻸��</TD>
		</TR>
        <TR style="height: 30pt; font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�ǥͩm�W</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font-size: 18pt;" 
          colSpan="7">{{$stud_data.$sn.stud_name}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�ʡ@�O</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{if $stud_data.$sn.stud_sex==1}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{else}}<span style="font-size: 20pt;">��</span>�k�@<span style="font-size: 20pt;">��</span>�k{{/if}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�NŪ�Ǯ�</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid; font-size: 13pt;" 
          colSpan="7">{{$sch_arr.sch_cname}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="3">�͡@��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{$stud_data.$sn.stud_birthday}}</TD>
		</TR>
        <TR style="height: 30pt;font-size: 10pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�NŪ�~�Z�y��</TD>
{{assign var=y value=$seme_class|@substr:0:-2}}
          <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid; font: 13pt Times New Roman,�з���,�з���;" 
          colSpan="7"><span style="font-size: 18pt;">{{$y-6}} </span> �~ <span style="font-size: 18pt;"> {{$seme_class|@substr:-2:2|@intval}} </span> �Z�y���G<span style="font-size: 18pt;">{{$site_num}}</span></TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" 
          colSpan="3">�����Ҧr��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font: 16pt Times New Roman,�з���,�з���;" 
          colSpan="7">{{$stud_data.$sn.stud_person_id}}</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�G�B�b�ժ�{ &nbsp;( �T�Ǵ����j��Υ��� )</TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" 
          colSpan="7">����</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3">��G<br>�W�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3">��G<br>�U�Ǵ�</TD>
          <TD style="width:10%; border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3">��T<br>�W�Ǵ�</TD>
		  <TD style="width:10%; border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="4">����</TD>
		</TR>
{{foreach from=$s_arr item=sl key=j}}
        <TR style="height: 28pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; text-align: left;" 
          colSpan="7">�@{{$sl}}</TD>
{{foreach from=$seme_arr item=si key=i}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="3">{{$rowdata.$sn.$i.avg.$j.score}}</TD>
{{/foreach}}
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 16pt; font-weight: bold;" 
          colSpan="4">{{$rowdata.$sn.9991.avg.$j.score}}</TD>
		</TR>
{{/foreach}}
        <TR style="height: 30pt;font-size: 12pt;">
{{if $stud_data.$sn.stud_sex==1}}{{assign var=num value=$sex1}}{{else}}{{assign var=num value=$sex2}}{{/if}}
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">�`����</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$rowdata.$sn.9991.avg.avg.score}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">���T�~<br>���`�H<br>��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$sex0}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">���T�~<br>�ūe��<br>����</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$rowdata.$sn.9991.avg.avg.pr}}%</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">�T�~��<br>{{if $stud_data.$sn.stud_sex==1}}�k{{else}}�k{{/if}}���`<br>�H��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$num}}</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid;" colSpan="2">�T�~��<br>{{if $stud_data.$sn.stud_sex==1}}�k{{else}}�k{{/if}}�ͫe<br>�ʤ���</TD>
{{assign var=t value=$rowdata.$sn.5.10.score*7+$rowdata.$sn.5.3.score}}
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" colSpan="2">{{$rowdata.$sn.9991.avg.avg.pr2}}%</TD>
	</TR>
        <TR style="height: 0pt;">
          <TD colSpan="20"></TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="height: 40pt; text-align: left;">�T�B�b�ժ�{�ĭp�覡</TD>
		</TR>
		<TR>
		  <TD colSpan="20" style="text-align: left; font-size: 12pt;">
		  <TABLE style="width:100%;">
		  <TR>
		    <TD style="vertical-align: top;" nowrap>1.�ĭp�覡�G</TD>
		    <TD>�ĭp�T�Ǵ��]��G�W�B�U�Ǵ��B��T�W�Ǵ��^���j��ةw�����q���U�ۥ����]���ܤp�Ʋ�2��^�H�Υ����`���C</TD>
		  </TR>
		  <TR>
		    <TD style="vertical-align: top;" nowrap>2.�e�{�覡�G</TD>
		    <TD>�U�ꤤ�����O�e�{�ǥͦb����y��B�^�y�B�ƾǡB�۵M�P�ͬ���ޡB���|�����j����`���Z�ҥe�P�~�Ŧʤ���C</TD>
		  </TR>
		  </TABLE>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-top: windowtext 0.75pt dashed; text-align: right;" colSpan="4">�ꤤ�f��<br>�H���ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="8"></TD>
          <TD style="border-top: windowtext 0.75pt dashed; text-align: left;" colSpan="4">��@�@�@��<br>�аȳB�ֳ�</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="4"></TD>
		</TR>
        <TR>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
          <TD width="5%">&nbsp;</TD>
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
