<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>��p�ǵ��`�W�̭]���ئP�N�Ѥε�����</TITLE>
<META http-equiv=Content-Type content="text/html; charset=big5">
</HEAD>
<BODY>
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=year_name value=$seme_class|@substr:0:-2}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
{{php}}
$this->_tpl_vars['bd']=explode("-",$this->_tpl_vars['health_data']->stud_base[$this->_tpl_vars['sn']]['stud_birthday']);
{{/php}}
<TABLE style="border-collapse: collapse; margin: auto; letter-spacing: -0.1em; font: 12pt �з���,�з���,serif; page-break-after: always;" cellSpacing="0" cellPadding="0" width="640" border="0">
  <TBODY>
  <TR>
    <TD style="PADDING-RIGHT: 1pt; PADDING-LEFT: 1pt; PADDING-BOTTOM: 0cm; PADDING-TOP: 0cm;" width="640">
      <TABLE style="BORDER-COLLAPSE: collapse; text-align: center; vertical-align: middle;" cellSpacing="0" cellPadding="2" width="640" border="0">
        <TBODY>
        <TR style="height: 20pt;">
          <TD colSpan="10" style="font-size:16pt;"><strong>��p�ǵ��`�W�̭]���ئP�N�Ѥε�����</strong></TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�˷R���a���G<br>�@�@���ժ��N�w�ƶQ�l�̧����U�C�̭]���ءA�Х���U�����U�C�������ب�ñ�W��A�浹�p�B�ͱa�^�ǮաA�H�K�T�{�Q�l�̥i���鶶�Q�������ءC</TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">���򥻸��<br><span style="font-size:12pt;">&nbsp;<strong><u> {{$school_data.sch_cname}} </u></strong>�A�ǵ��m�W�G<strong><u> {{$health_data->stud_base.$sn.stud_name}} </u></strong>�A�Z�šG<strong><u> {{$year_data.$year_name|@substr:0:2}} </u></strong>�~<strong><u> {{$class_data.$seme_class}} </u></strong>�Z<strong><u> {{$seme_num}} </u></strong>�� <br>�X�ͤ���G<u> <strong>{{$bd.0-1911}}</strong> </u>�~<u> <strong>{{$bd.1}}</strong> </u>��<u> <strong>{{$bd.2}}</strong> </u>��A �p���q�ܡG<u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u></span></TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�������ج̭]����<br>
		  <TABLE BORDER="0" style="WIDTH:100%; font-size: 14pt;"><TR><TD>
		  &nbsp;{{if $smarty.post.inj.4}}��{{else}}��{{/if}}��q�}�˭��ճ�D�ӭM�ʦʤ�y�V�X�̭]�]Tdap�^<br>&nbsp;{{if $smarty.post.inj.7}}��{{else}}��{{/if}}�¯l�B�|�����B�w��¯l�V�X�̭]<br>&nbsp;{{if $smarty.post.inj.8}}��{{else}}��{{/if}}�y�P�̭]<br>&nbsp;����L�G<u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u>
		  </TD><TD style="vertical-align: top;">
		  {{if $smarty.post.inj.3}}��{{else}}��{{/if}}�p��·��f�A�̭]<br>{{if $smarty.post.inj.5}}��{{else}}��{{/if}}�饻�����̭]
		  </TD></TR></TABLE>
		  </TD>
		</TR>
		<TR style="height: 15pt; font-size: 14pt;">
		  <TD colSpan="10" style="text-align: left;">�����d����</TD>
		</TR>
        <TR style="height: 15pt">
          <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 1.5pt solid; border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          rowSpan="2">�������e</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid;" 
          colSpan="2" nowrap>�ФĿ靈�εL</TD>
		</TR>
        <TR style="height: 15pt">
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" >��</TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" >�L</TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >1.�H�e�w�����ث�O�_���Y���S������A�p�o���N�]40.5  �J�H�W�^�B��j�B���g�B��J�B���x3�p�ɥH�W�K���C</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >2.�O�_����P�@���̭]�ι�̭]�����󦨤�(�p���J�B�����ηs���)���L�Ӥ����C</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
 		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >3.�O�_���Y����Ŧ�B�xŦ�B��Ŧ�B�զ�f�B���g�K���f�v�C</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >4.�@�~�����_��j���p�C</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >5.�{�b���馳�L����f�x�A�p�o�N�]38.5�J�H�W�^�B�æR�B�I�l�x���K���Υ��A�ΤK�_���B�孷���B�����ġ]�������F�^���Ī��γ̪�T�Ѥ����L�N��B�Y�ĵ����ΡC</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 0.75pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >6.�̪�T�Ӥ봿�_�٦ת`�g�K�̲y�J��(�K�̦�M)�ΧK�̧��C<br> &nbsp; �̪񤻭Ӥ�O�_����L��α����R�ߪ`�g��G�s�~�C<br> &nbsp; �̪�Q�@�Ӥ뤺�O�_���R�ߪ`�g�����q�K�̲y�J�աC</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 0.75pt solid;" ></TD>
		</TR>
        <TR style="HEIGHT: 25pt">
          <TD style="border-left: windowtext 1.5pt solid; border-bottom: windowtext 1.5pt solid; border-right: windowtext 0.75pt solid; text-align: left;"
		  >7.���ط�餧��šG�B��<u> &nbsp; &nbsp; &nbsp; &nbsp; </u>�J �� �շ�<u> &nbsp; &nbsp; &nbsp; &nbsp; </u>�J</TD>
		  <TD style="border-right: windowtext 0.75pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" ></TD>
		  <TD style="border-right: windowtext 1.5pt solid; border-top: windowtext 0.75pt solid; border-bottom: windowtext 1.5pt solid;" ></TD>
		</TR>
		</TBODY>
	  </TABLE><br>
	  <span style="font-size: 14pt;">���Ƶ�</span><br><span style="font-size: 12pt;">���A�Υ��g�å͸p�֭����v�B�褧�K�_���B�孷�����t�����ݤ��Ī��A�e���o�ͺC�ʹ]���r�ɭP���g�Φ��`�A���i���a���ŪA�ΡC<br>���w���ߦ�ޯe�f�B��Ŧ�B�xŦ�����j�˯f�̡A����v�ˬd��A�M�w�O�_���ءA�����حn����v����C<br>���H�W�������G�Ы��U���̭]���T�ҡA�M�w�O�_�������ءC<br>���������������Ч����O�s���~�C</span>
	  <p style="font-size: 14pt;">��v������O�_���ءG���O &nbsp; ���_</p>
	  <TABLE BORDER="0" style="WIDTH:100%;"><TR><TD>
	  <p style="font-size: 14pt;">��vñ�W�G<u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u></p>
	  <p style="font-size: 14pt;">���س��G<u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u></p><br>
	  </TD><TD style="text-align: right;">
	  <p style="font-size: 14pt;">�P�N���خa��ñ�W�G<u> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u></p>
	  <p style="font-size: 14pt;">���ؤ���G<u> &nbsp; &nbsp; &nbsp; </u>�~<u> &nbsp; &nbsp; </u>��<u> &nbsp; &nbsp; &nbsp;</u>��</p><br>
	  </TD></TR></TABLE>
	</TD>
  </TR>
  </TBODY>
</TABLE>
{{/foreach}}
</BODY></HTML>
