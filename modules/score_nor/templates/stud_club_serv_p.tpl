{{* $Id: cchk_body.htm 5522 2009-07-09 04:48:15Z infodaes $ *}}

{{$break_page}}

<P ALIGN=CENTER STYLE="font-size:16pt; font-family: �з���, cursive;">{{$school_name}} {{$class_info.ch_year}} {{$class_info.c_seme}}<br>{{$default_title}}</p>
<DIV STYLE="font-size: 14pt; font-family: �з���, cursive; text-align:center;">�Z�šG{{$class_info.c_year2}}{{$class_info.c_name}}�@�@�y���G{{$stud.seme_num}}�@�@�m�W�G{{$stud.stud_name}}</DIV>

<!-- �X�ʮu�έp -->
{{if $stud_absent=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>�ӤH�X�ʮu�έp</u></b></td>
	</tr>
	<tr>
	<td align="center">
  {{$absent_print}}
	</td>
	</tr>
</table>

{{/if}}

<!--�ӤH���g -->
{{if $stud_reward=="checked"}}
<br>
{{foreach from=$f item=d key=i}}
{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['i']]=0;{{/php}}
{{/foreach}}
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>�ӤH���g���</u></b><br><small>�έp�ɶ��G{{$seme_start_date}}~{{$seme_end_date}}</small></td>
	</tr>
	<tr>
	<td align="center">
<table width="100%">
{{if $stud_reward_detail=="checked"}}
<!-- ���Ӽ��D -->
<tr class="title_sbody2">
<td align="center" width="50"><span style="font-size:10pt;">�Ǧ~</span></td>
<td align="center" width="50"><span style="font-size:10pt;">�Ǵ�</span></td>
<td align="center"><span style="font-size:10pt;">���g�ƥ�</span></td>
<td align="center"><span style="font-size:10pt;">���g���O</span></td>
<td align="center"><span style="font-size:10pt;">���g�̾�</span></td>
<td align="center" width="80"><span style="font-size:10pt;">���g�ͮĤ��</span></td>
<td align="center" width="80"><span style="font-size:10pt;">�P�L���</span></td>
</tr>
<!-- ���Ӽ��D���� -->
<tr><td colspan="7"><hr size="2"></tr>
{{/if}}
{{foreach from=$reward_rows item=d}}
{{assign var=r_id value=$d.reward_kind}}
{{assign var=sel_year value=$d.reward_year_seme|@substr:0:-1}}
{{assign var=sel_seme value=$d.reward_year_seme|@substr:-1:1}}
{{assign var=k value=$d.reward_kind|@abs}}
{{if $d.reward_kind>0}}{{assign var=j value=0}}{{else}}{{assign var=j value=3}}{{/if}}
{{if $k==1}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+3]++;{{/php}}{{/if}}
{{if $k==2}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+3]+=2;{{/php}}{{/if}}
{{if $k==3}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+2]++;{{/php}}{{/if}}
{{if $k==4}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+2]+=2;{{/php}}{{/if}}
{{if $k==5}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]++;{{/php}}{{/if}}
{{if $k==6}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]+=2;{{/php}}{{/if}}
{{if $k==7}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]+=3;{{/php}}{{/if}}

{{if $stud_reward_detail=="checked"}}
<!-- ���ӳ��� -->
<tr class="title_sbody1">
<td align="center"><span style="font-size:10pt;">{{$sel_year}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$sel_seme}}</span></td>
<td align="left"><span style="font-size:10pt;">{{$d.reward_reason}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$reward_kind.$r_id}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$d.reward_base}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$d.reward_date}}</span></td>
<td align="center"><span style="font-size:10pt;">{{if $r_id>0}}---{{elseif $d.reward_cancel_date=="0000-00-00"}}���P�L{{else}}{{$d.reward_cancel_date}}{{/if}}</span></td>
</tr>
<!-- ���ӳ����I�� -->
{{/if}}
{{/foreach}}
<tr>
<td colspan="7"><hr size="2"></td>
</tr>
<tr>
<td colspan="7">
<table width="100%">
<tr>
<td align="center">�j�\</td>
<td align="center">�p�\</td>
<td align="center">�ż�</td>
<td align="center">�j�L</td>
<td align="center">�p�L</td>
<td align="center">ĵ�i</td>
</tr>
<tr>
{{foreach from=$f item=d key=i}}
{{assign var=tt value=$t.$i}}
<td align="center">{{$tt|@intval}}��</td>
{{/foreach}}
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="7"><hr size="2"></td>
</tr>
</table>
	
	</td>
	</tr>
</table>
{{/if}}

<!--�ӤH�Ǵ���ƦC�L�}�l -->
<!--��`�ͬ���{ -->
{{if $stud_chk_data=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>��`�ͬ���{</u></b></td>
	</tr>
</table>
{{$chk_data}}
{{/if}}
<!-- ���ά��� -->
{{if $stud_club=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>���ά��ʰO��</u></b></td>
	</tr>
</table>
<table border='2' cellpadding='3' cellspacing='0' width='100%' style="border-collapse:collapse;font-size:10pt" bordercolor="#111111">
	<TR>
		<td align="center" width="120">�ѥ[����</td>
		{{if $stud_club_score=="checked" }}
		<td align="center" width="30">���Z</td>
		{{/if}}
		<td align="center">�Юv���y</td>
		<td align="center">�ۧڬ٫�</td>
	</TR>
<!------ ��ܪ��ΰj�� ---->
{{foreach from=$club_detail item=club}}
  <tr>
    <td align="center">{{$club.association_name}}</td>
    {{if $stud_club_score=="checked" }}
    <td align="center">{{$club.score}}</td>
    {{/if}}
    <td>{{$club.description}}</td>
    <td>{{$club.stud_feedback}}</td>
  </tr>
{{/foreach}}
<!------ ������ܪ��ΰj�� ---->
</TABLE>
{{/if}}
<!-- end if $stud_club -->
{{if $stud_service=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>�A�Ⱦǲ߰O��</u></b></td>
	</tr>
</table>
<table border='2' cellpadding='3' cellspacing='0' width='100%' style="border-collapse:collapse;font-size:10pt" bordercolor="#111111">
	<TR>
		<td align="center" width="80">���</td>
		<td align="center">�ѥ[�դ��~���@�A�Ⱦǲߨƶ��ά��ʶ���</td>
		<td align="center" width="70">�ɼ�</td>
		<td align="center" width="100">�D����</td>
		<td align="center">�ۧڬ٫�</td>
	</TR>
<!------ ��ܪA�Ⱦǲ߰j�� ---->
{{foreach from=$service_detail item=service key=sn}}
  <tr>
  	<td align="center">{{$service.service_date}}</td>
    <td>�i{{$service.item}}�j{{$service.memo}}</td>
    <td align="center">{{$service.hour}}</td>
    <td align="center">{{$service.sponsor}}</td>
    <td>{{$service.feedback}}</td>
  </tr>
{{/foreach}}
<!------ ������ܪA�Ⱦǲ߰j�� ---->
</TABLE>
<table border="0" width="100%">
 <tr>
 	<td>	���Ǵ��A�Ⱦǲ��`�ɼƦ@�p<b> {{$HOURS}} </b>�p��</td>
 	</tr>
</table>
{{/if}}
<!-- end if $stud_service -->
<!-- �F����� -->
{{if $stud_leader=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>�F�����</u></b></td>
	</tr>
	<tr>
	<td align="center">
  {{$leader_print}}
	</td>
	</tr>
</table>
{{/if}}

<!-- �v�ɰO�� -->
{{if $stud_race=="checked"}}
<br>
<table border="0" width="100%">
	<tr>
	 <td align="center"><b><u>�ӤH�v�ɰO��</u></b></td>
	</tr>
	<tr>
	<td align="center">
  {{$race_print}}
	</td>
	</tr>
</table>
{{/if}}

<br>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=4 CELLSPACING=0>
	<THEAD>
		<TR>
			<TD COLSPAN=3 style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 1.5pt;">
				<DIV ALIGN=CENTER><FONT SIZE=3>�f��ñ��</FONT></DIV>
			</TD>
			<TD style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;">
				<DIV ALIGN=CENTER><FONT SIZE=3>�a���N���G</FONT></DIV>
			</TD>
		</TR>
	</THEAD>
	<TBODY>
		<TR>
			<TD WIDTH=17% style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 1.5pt;line-height: 8pt;">
				<DIV ALIGN=CENTER><FONT SIZE=1 STYLE="font-size: 10pt;">�� �v</FONT></DIV>
			</TD>
			<TD WIDTH=17% style="border-style: solid; border-width: 1.5pt 0.75pt 0pt 0pt;line-height: 8pt;">
				<DIV ALIGN=CENTER><FONT SIZE=1 STYLE="font-size: 10pt;">{{$sign_3_title}}</FONT></DIV>
			</TD>
			<TD WIDTH=17% style="border-style: solid; border-width: 1.5pt 1.5pt 0pt 0pt;line-height: 8pt;">
				<DIV ALIGN=CENTER><FONT SIZE=1 STYLE="font-size: 10pt;">�� ��</FONT></DIV>
			</TD>
			<TD ROWSPAN=2 WIDTH=49% VALIGN=BOTTOM style="border-style: solid; border-width: 1.5pt 1.5pt 1.5pt 0pt;">
				<DIV ALIGN=RIGHT><FONT SIZE=3>�a��ñ��</FONT></DIV>
			</TD>
		</TR>
		<TR style="height:60pt;">
			<TD style="border-style: solid; border-width: 0.75pt 0.75pt 1.5pt 1.5pt;">
				<DIV ALIGN=CENTER><BR></DIV>
			</TD>
			<TD style="border-style: solid; border-width: 0.75pt 0.75pt 1.5pt 0pt;">
				<DIV ALIGN=CENTER VALIGN=MIDDLE STYLE="margin-bottom: 0cm">
            {{if $img_3}}<IMG SRC="{{$img_3}}" ALIGN=CENTER WIDTH=48 HEIGHT=48 BORDER=0><BR CLEAR=LEFT>{{else}}<BR>{{/if}}
				</DIV>
			</TD>
			<TD style="border-style: solid; border-width: 0.75pt 1.5pt 1.5pt 0pt;">
				<DIV ALIGN=CENTER VALIGN=MIDDLE STYLE="margin-bottom: 0cm">
				{{if $img_1}}<IMG SRC="{{$img_1}}" ALIGN=CENTER WIDTH=48 HEIGHT=48 BORDER=0><BR CLEAR=LEFT>{{else}}<BR>{{/if}}
				</DIV>
			</TD>
		</TR>
	</TBODY>
</TABLE>
{{$default_txt}}