<!-- $Id: prn_all_score2.tpl 5310 2009-01-10 07:57:56Z hami $  -->

{{if $break_page != ''}}{{$break_page}}{{/if}}
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
<tr>
<td class="empty" rowspan="2" style="font-size: 18pt; line-height: 20pt; font-family: �з���;" align="center">{{$school_name}} �ǥ;��y�O����</td>
<td class="empty" style="font-size: 12pt; line-height: 14pt;" align="left">�Ǹ��G{{$base.stud_id}}</td>
</tr>
<tr>
<td class="empty" style="font-size: 12pt; line-height: 14pt;" align="left">�m�W�G{{$base.stud_name}}</td>
</tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody><tr>
		<td class="top_left">�����Ҧr��</td>
		<td class="top">{{$base.stud_person_id}}</td>
		<td class="top">�X�ͦ~���</td>
		<td class="top">{{$base.stud_birthday}}</td>
		<td class="top">�ʧO</td>
		<td class="top">{{$base.stud_sex}}</td>
		<td class="top_right" rowspan="5" style="width: 3.6cm; height: 4.6cm;">{{$base.stud_photo_src}}</td>
	</tr>
	<tr>
		<td class="left_left">�s���q��</td>
		<td>{{$base.stud_tel_2}}</td>
		<td>�s���H</td>
		<td>{{$base.guardian_name}}</td>
		<td>���Y</td>
		<td>{{$guar_kind[$base.guardian_relation]}}</td>
	</tr>
	<tr>
		<td class="left_left">�s����}</td>
		<td colspan="5" align="left">{{$base.stud_addr_2}}</td>
	</tr>
	<tr>
		<td class="left_left">�J�Ǹ��</td>
		<td>{{$base.stud_mschool_name}}</td>
		<td>��(��)�~�ҮѦr��</td>
		<td colspan="3">{{$base.grade_word_num}}</td>
	</tr>
	<tr>
		<td class="left_left">���ʱ���</td>
		<td colspan="5" style="vertical-align: top;">{{include file=$prn_move_tpl}}</td>
	</tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody><tr style="height: 28pt;">
		<td class="left_left" align="center">�Ǧ~<br>�Ǵ�</td>
		{{foreach from=$seme_ary key=grade_seme item=data name=semes}}
		<td class="{{if $smarty.foreach.semes.iteration==$seme_num}}both_top{{else}}left_left{{/if}}" colspan="3" width="{{$seme_width}}%">{{$data.seme_title2}}</td>
		{{/foreach}}
	</tr>
	<tr style="height: 28pt;">
		<td class="left_left">�~�Z��</td>
		{{foreach from=$seme_ary key=grade_seme item=data name=semes}}
		<td colspan="3" class="{{if $smarty.foreach.semes.iteration==$seme_num}}both{{else}}left_left{{/if}}">{{$data.class_title}}</td>
		{{/foreach}}
	</tr>
	<tr>
		<td class="left_left">�ǲ�<br>���</td>
		{{foreach from=$seme_ary key=grade_seme item=data name=semes}}
		<td class="left_left">�`<br>��</td>
		<td>�ʤ���</td>
		<td {{if $smarty.foreach.semes.iteration==$seme_num}}class="right"{{/if}}>��<br>��</td>
		{{/foreach}}
	</tr>
	{{foreach from=$ss_link item=sl key=sslink name=ss_link}}
			<tr style="height: 28pt;">
				<td class="left_left">{{$link_ss[$sl]}}</td>
				{{foreach from=$semes item=si key=sj}}
					{{assign var=classid value=$cid.$si}}
					<td class="left_left">{{if $s_num.$classid.$sslink}}{{$s_num.$classid.$sslink}}{{else}}---{{/if}}</td>
					<td>{{if $all_score.$sn.$sl.$si.score}}{{$all_score.$sn.$sl.$si.score}}{{else}}-----{{/if}}</td>
					<td {{if ($sj+1)==$seme_num}}class="right"{{/if}}>{{if $all_score.$sn.$sl.$si.str}}{{$all_score.$sn.$sl.$si.str}}{{else}}---{{/if}}</td>
				{{/foreach}}
			</tr>
	{{/foreach}}
	<tr style="height: 28pt;">
		<td class="left_left">��`�ͬ�<br>��{</td>
		{{foreach from=$semes item=si key=sj}}
			<td class="left_left">---</td>
			<td>{{$nor_score.$sn.$si.score}}</td>
			<td {{if ($sj+1)==$seme_num}}class="right"{{/if}}>{{$nor_score.$sn.$si.str}}</td>
		{{/foreach}}
	</tr>
	<tr style="height: 28pt;">
		<td class="left_left">�ɮv</td>
		{{foreach from=$seme_ary key=grade_seme item=data}}
			<td colspan="3" {{if ($sj+1)==$seme_num}}class="both"{{else}}class="left_left"{{/if}}>{{$data.teacher_1}}</td>
		{{/foreach}}
	</tr>
	<tr>
		<td class="bottom_left">�ɮv���y</td>
		{{foreach from=$semes item=si key=sj}}
			<td colspan="3" class="memo">{{$nor_score.$sn.$si.word}}</td>
		{{/foreach}}
	</tr>
</table>
<br>
<table style="text-align: left;" border="0" cellpadding="0" cellspacing="0" width="610" align="center">
	<tbody><tr>
		<td class="empty" width="25%">�ӿ�H��</td>
		<td class="empty" width="25%">���U�ժ�</td>
		<td class="empty" width="25%">�аȥD��</td>
		<td class="empty" width="25%">�ժ�</td>
	</tr>
</tbody></table>

