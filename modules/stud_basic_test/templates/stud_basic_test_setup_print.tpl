{{* $Id: stud_basic_test_setup_print.tpl 7176 2013-03-01 03:54:11Z chiming $ *}}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>102�Ǧ~�װ�����Ǧb�վǲ߻�즨�Z�ҩ���-�S�����ǥ�</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{foreach from=$student_sn item=d key=seme_class name=rows}}
{{foreach from=$d item=sn key=site_num}}
<TABLE style="border-collapse: collapse; margin: auto; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle; font: 16pt �з���;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 30pt;">
          <TD colSpan="3" style="font: 16pt �ө���; font-weight: bold; border: windowtext 3pt solid; letter-spacing: -0.1em;">�S�����ǥ�</TD>
		  <TD colSpan="8"></TD>
		</TR>
        <TR style="height: 30pt;">
          <TD colSpan="11" style="font: 18pt �з���; font-weight: bold;"><span style="font-family: Times New Roman; font-weight: bold;">102</span>�Ǧ~�װ�����Ǧb�վǲ߻�즨�Z�ҩ���</TD>
		</TR>
        <TR style="height: 18pt; font-size: 12pt;">
          <TD style="text-align: left;" colSpan="6">�NŪ�ꤤ�G <span style="font-size: 16pt; letter-spacing: -0.1em;">{{$sch_arr.sch_cname}}</span></TD>
		  <TD style="text-align: left;" colSpan="5">�NŪ�ꤤ�N�X�G <span style="font: 18pt Times New Roman;">{{$sch_arr.sch_id}}</span></TD>
		</TR>
{{assign var=y value=$seme_class|@substr:0:-2}}
        <TR style="height: 18pt;font-size: 12pt;">
          <TD style="text-align: left;" colSpan="6">�Z�šG <span style="font: 18pt Times New Roman;">{{$y}}</span> �~ <span style="font: 18pt Times New Roman;">{{$seme_class|@substr:-2:2|@intval}}</span> �Z�@�@�m�W�G <span style="font-size: 16pt;">{{$stud_data.$sn.stud_name}}</span></TD>
          <TD style="text-align: left;" colSpan="5">�����ҲΤ@�s���G <span style="font: 18pt Times New Roman">{{$stud_data.$sn.stud_person_id}}</span></TD>
		</TR>
		<TR style="height: 6pt;"><TD colSpan="11"></TD></TR>
        <TR style="font-size: 12pt;">
          <TD style="text-align: left; vertical-align: top; letter-spacing: -0.1em;" colSpan="2">�ҥͯS�����O�G</TD>
		  <TD style="text-align: left; letter-spacing: -0.1em;" colSpan="9">{{if $stud_data.$sn.sp_kind==2}}��{{else}}��{{/if}} ����(����Ƥλy����O�ҩ�)�@{{if $stud_data.$sn.sp_kind==1}}��{{else}}��{{/if}} ����(������Ƥλy����O�ҩ�)<br>{{if $stud_data.$sn.kind==7}}��{{else}}��{{/if}} �ҥ~�u�q��ǧ޳N�H�~�l�k�@{{if $stud_data.$sn.kind==2}}��{{else}}��{{/if}} �F���u��~�u�@�H���l�k�@{{if $stud_data.$sn.kind==3}}��{{else}}��{{/if}} �X�å�<br>{{if $stud_data.$sn.sp_kind=='C'}}��{{else}}��{{/if}} ���߻�ê�͡@(�H�W�дN�ҥͳ̦��Q���S�����Ŀ�í��Ŀ�@��)</TD>
		</TR>
        <TR style="height: 27pt;font-size: 12pt; background-color: #EEEEEE;">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; text-align: center;" 
          colSpan="2" nowrap>���]�Ǭ�^</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�W<br><span style="font-family: Times New Roman;">(A)</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid;" 
          >�K�U<br><span style="font-family: Times New Roman;">(B)</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          >�E�W<br><span style="font-family: Times New Roman;">(C)</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; letter-spacing: -0.1em;" 
          colSpan="2">���(�Ǭ�)<br>�Ǵ����Z����<br><span style="font-family: Times New Roman;">( A + B + C ) / 3</span></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; letter-spacing: -0.1em;" 
          colSpan="2">���(�Ǭ�)<br>�Ǵ����Z����<br>�ƦW�ʤ���</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; letter-spacing: -0.1em;" 
          colSpan="2" nowrap>�S�����[�ᤧ<br>���(�Ǭ�)�Ǵ�<br>���Z���ձƦW�ʤ���</TD>
		</TR>
{{foreach from=$s_arr item=sl key=j}}
{{if $j==10}}
        <TR style="height: 20pt; font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2" rowSpan="2">{{$sl}}</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�K�W<span style="font-family: Times New Roman;">(D)</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�K�U<span style="font-family: Times New Roman;">(E)</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�E�W<span style="font-family: Times New Roman;">(F)</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="4" rowSpan="2">---</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 16pt; font-weight: bold;" 
          colSpan="2" rowSpan="3">---</TD>
		</TR>
{{/if}}
{{if $j<>3}}
        <TR style="height: 18pt;font-size: 12pt;">
          {{if $j<>10}}
		  <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; font-size: 12pt;" 
          colSpan="2">{{$sl}}</TD>
		  {{/if}}
		  {{assign var=sp_cal value=$stud_data.$sn.sp_cal}}
		  {{if $stud_data.$sn.kind==2 || $stud_data.$sn.kind==7}}{{assign var=sp_cal value=1}}{{/if}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable0==""}}---{{else}}{{$rowdata.$sn.0.$j.score}}{{/if}}</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable1==""}}---{{else}}{{$rowdata.$sn.1.$j.score}}{{/if}}</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;" 
          ><span style="font-family: Times New Roman;">{{if $sp_cal && $stud_data.$sn.enable2==""}}---{{else}}{{$rowdata.$sn.2.$j.score}}{{/if}}</span></TD>
          {{if $j<>10}}
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2"><span style="font-family: Times New Roman;">{{$rowdata.$sn.3.$j.score|string_format:"%.2f"}}</span></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2"><span style="font: 14pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.$j.pr}}</span></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;" 
          colSpan="2"><span style="font: 14pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.$j.ppr}}</span></TD>
		  {{/if}}
		</TR>
{{/if}}
{{/foreach}}
        <TR style="height: 28pt;font-size: 14pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt; letter-spacing: -0.1em;" 
          colSpan="2">�b��3�Ǵ����Z<br>�`����<br><span style="font-family: Times New Roman;">( D + E + F ) / 3</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3"><span style="font-family: Times New Roman;">{{$rowdata.$sn.3.10.score|string_format:"%.2f"}}</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt; letter-spacing: -0.1em;" 
          colSpan="2">�b��3�Ǵ����Z<br>�`����<br>���ձƦW�ʤ���</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2"><span style="font: 16pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.10.pr}}</span></TD>
		</TR>
        <TR style="height: 20pt; font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2" rowSpan="2">�S�����[����<br>���Ǵ����Z�`����</TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�K�W<span style="font-family: Times New Roman;">(G)</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�K�U<span style="font-family: Times New Roman;">(H)</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;" 
          >�E�W<span style="font-family: Times New Roman;">(I)</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 10pt;"
          colSpan="6" rowSpan="2">---</TD>
		</TR>
		<TR style="height: 18pt;font-size: 12pt;">
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">{{$rowdata.$sn.0.10.pscore|string_format:"%.2f"}}</span></TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">{{$rowdata.$sn.1.10.pscore|string_format:"%.2f"}}</span></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid;"><span style="font-family: Times New Roman;">{{$rowdata.$sn.2.10.pscore|string_format:"%.2f"}}</span></TD>
		</TR>
        <TR style="height: 28pt;font-size: 14pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt; letter-spacing: -0.1em;" 
          colSpan="2">�S����<span style="text-decoration: underline;">�[����</span><br>���b��3�Ǵ���<br>�Z�`����<br><span style="font-family: Times New Roman;">( G + H + I ) / 3</span></TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="3"><span style="font-family: Times New Roman;">{{$rowdata.$sn.3.10.pscore|string_format:"%.2f"}}</span></TD>
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; font-size: 12pt; letter-spacing: -0.1em;" 
          colSpan="4">�S����<span style="text-decoration: underline;">�[����</span><br>���b��3�Ǵ���<br>�Z�`����<br>���ձƦW�ʤ���</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2"><span style="font: 16pt Times New Roman; font-weight: bold;">{{$rowdata.$sn.3.10.ppr}}</span></TD>
		</TR>
        <TR style="height: 40pt;font-size: 12pt;">
          <TD style="border-right: windowtext 0.75pt solid; border-left: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid;" 
          colSpan="2">�Ƶ�</TD>
          <TD style="border-right: windowtext 1.5pt solid; border-left: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; text-align: left; letter-spacing: -0.1em;" 
          colSpan="9">1.�Ǵ����Z�����p��ܤp���I��ĤG��A�p���I��ĤT��|�ˤ��J�C<br>2.�ҫ��u�K�~�ŤW�Ǵ��B�K�~�ŤU�Ǵ��B�E�~�ŤW�Ǵ��v�Y�u�ꤤ�G�~�ŤW�Ǵ��B�G�~�ŤU�Ǵ��ΤT�~�ŤW�Ǵ��v�C<br>3.�S�����ͥ[���u�ݨ̦U�S�����[���k�W�W�w��z�A�����Z�ҩ���Y�H�ҥͯS�����O������������Ƥλy����O�ҩ�(�[����v35�H)���d�ҡG�Y G = D * (1+0.35)�A H = E * (1+0.35)�A I = F * (1+0.35)�C<br>4.���]�Ǭ�^���ƦC���ǥѤW�ܤU�̧Ǭ���y��B�^�y�B�ƾǡB���|�B�۵M�P�ͬ���ޡB���N�P�H��B���d�P��|�κ�X���ʡA���Ǥ��o���N�ܰʡC</TD>
		</TR>
        <TR style="height: 0pt;">
          <TD style="border-top: windowtext 1.5pt solid;" colSpan="11"></TD>
		</TR>
		<TR>
		  <TD colSpan="11" style="height: 5pt; text-align: left;"></TD>
		</TR>
        <TR style="height: 20pt;font-size: 12pt;">
          <TD style="border-top: windowtext 0.75pt dashed; text-align: right; color: CCCCCC;" colSpan="2">(�NŪ�ꤤ�W��)</TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="3"></TD>
          <TD style="border-top: windowtext 0.75pt dashed; text-align: left;" colSpan="3"></TD>
          <TD style="border-top: windowtext 0.75pt dashed;" colSpan="3"></TD>
		</TR>
        <TR style="height: 1pt;">
          <TD>&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
          <TD width="9%">&nbsp;</TD>
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
