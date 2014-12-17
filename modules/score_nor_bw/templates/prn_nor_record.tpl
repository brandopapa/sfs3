<!-- $Id: prn_nor_record.tpl 7690 2013-10-23 07:39:00Z smallduh $  -->

{{if $break_page != ''}}{{$break_page}}{{/if}}
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
<tr>
<td class="empty" rowspan="2" style="font-size: 18pt; line-height: 20pt; font-family: �з���;" align="center">{{$school_name}} �ǥͺ�X��{�O����</td>
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
{{assign var=sex value=$base.stud_sex}}
		<td class="top">�ʧO</td>
		<td class="top">{{$sex_kind.$sex}}</td>
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
		<td colspan="5" align="left">&nbsp;&nbsp;{{$base.stud_addr_2}}</td>
	</tr>
	<tr>
		<td class="left_left">�J�Ǹ��</td>
		<td>{{$base.stud_mschool_name}}</td>
		<td>��(��)�~�ҮѦr��</td>
		<td colspan="3">{{$base.grade_word_num}}</td>
	</tr>
	<tr>
		<td class="left_left">���ʱ���</td>
		<td colspan="5" style="vertical-align: top;">{{include file=prn_move.tpl}}</td>
	</tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="both_top" width="50">�Ǵ��O</td><td class="middle_top" width="50">�Ǧ~��</td><td class="middle_top" width="70">�Z�Ůy��</td><td class="middle_right">���`�ͬ���{</td>
	</tr>
{{foreach from=$seme_ary key=grade_seme item=data name=semes}}
	<tr style="height: 16pt;">
		<td class="both" width="50">{{$data.cseme}}</td><td class="middle_top" width="50">{{$data.year}}</td><td class="middle_top" width="70">{{if $data.num}}{{$data.num}}{{else}}---{{/if}}</td><td class="middle_right" style="text-align:left;">&nbsp;&nbsp;{{if $data.memo}}{{$data.memo}}{{else}}---{{/if}}</td>
	</tr>
{{/foreach}}
	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="both_top" width="50" rowspan="2">�Ǵ��O</td>
		<td class="middle_right" colspan="6">���g���� (��)</td>
		<td class="middle_right" colspan="6">�X�ʮu���� (�`)</td>
	</tr>
	<tr style="height: 16pt;">
		<td class="middle_top">�j�\</td>
		<td class="middle_top">�p�\</td>
		<td class="middle_top">�ż�</td>
		<td class="middle_top">�j�L</td>
		<td class="middle_top">�p�L</td>
		<td class="middle_right">ĵ�i</td>
		<td class="middle_top">�ư�</td>
		<td class="middle_top">�f��</td>
		<td class="middle_top">�m��</td>
		<td class="middle_top">���|</td>
		<td class="middle_top">����</td>
		<td class="middle_right">��L</td>
	</tr>
{{foreach from=$seme_ary key=grade_seme item=data name=semes}}
	<tr style="height: 16pt;">
		<td class="both">{{$data.cseme}}</td>
{{foreach from=$rew_data.$grade_seme item=d name=rew}}
		<td class="{{if $smarty.foreach.rew.iteration==6}}middle_right{{else}}middle_top{{/if}}">{{if $d}}{{$d}}{{else}}0{{/if}}</td>
{{/foreach}}
{{foreach from=$abs_data.$grade_seme item=d name=abs}}
		<td class="{{if $smarty.foreach.abs.iteration==6}}middle_right{{else}}middle_top{{/if}}">{{if $d}}{{$d}}{{else}}0{{/if}}</td>
{{/foreach}}
	</tr>
{{/foreach}}
<tr style="height: 16pt;">
  <td class="both_top">�p�p</td>
	{{foreach from=$rew_data_total item=d name=rew_total}}
			<td class="{{if $smarty.foreach.rew_total.iteration==6}}middle_right{{else}}middle_top{{/if}}">{{if $d}}{{$d}}{{else}}0{{/if}}</td>
	{{/foreach}}
	{{foreach from=$abs_data_total item=d name=abs_total}}
			<td class="{{if $smarty.foreach.abs_total.iteration==6}}middle_right{{else}}middle_top{{/if}}">{{if $d}}{{$d}}{{else}}0{{/if}}</td>
	{{/foreach}}  
</tr>

	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="70">���g���</td>
		<td class="middle_top" width="50">�Ǵ��O</td>
		<td class="middle_top" width="70">���g���O</td>
		<td class="middle_top">���g�ƥ�</td>
		<td class="middle_right" width="50">�P�L</td>
	</tr>
{{foreach from=$rew_record item=d}}
	<tr style="height: 16pt;">
		<td class="left_left">{{$d.reward_date}}</td>
{{assign var=sid value=$d.reward_year_seme}}
		<td class="middle_top">{{$seme_arr2.$sid}}</td>
{{assign var=rid value=$d.reward_kind}}
		<td class="middle_top">{{$reward_arr.$rid}}</td>
		<td class="middle_top" style="text-align:left">&nbsp;{{$d.reward_reason}}</td>
		<td class="middle_right">{{if $d.reward_div==1}}---{{else}}{{if $d.reward_cancel_date=="0000-00-00"}}�_{{else}}�O{{/if}}{{/if}}</td>
	</tr>
{{/foreach}}
	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="50">�Ǵ��O</td>
		<td class="middle_top" width="100">���ΦW��</td>
		<td class="middle_top" width="50">�ˮ�</td>
		<td class="middle_top" width="125">���ηF��</td>
		<td class="middle_right" width="285">�Z�ŷF��</td>
	</tr>
	{{foreach from=$club item=d}}
	<tr style="height: 16pt;">
	{{assign var=sid value=$d.seme_year_seme}}
		<td class="left_left">{{$seme_arr2.$sid}}</td>
		<td class="middle_top">{{$d.association_name}}</td>
		<td class="middle_top">{{$d.pass_txt}}</td>
		<td class="middle_top" width="125">{{if $title_arr.$sid.club_title==''}}---{{else}}{{$title_arr.$sid.club_title}}{{/if}}</td>
		<td class="middle_right" width="285">{{if $title_arr.$sid.class_title==''}}---{{else}}{{$title_arr.$sid.class_title}}{{/if}}</td>
	</tr>	
	{{/foreach}}
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="50">�Ǵ��O</td>
		<td class="middle_top" width="100">���</td>
		<td class="middle_top" width="290">�ѥ[�դ��~���@�A�Ⱦǲߨƶ��ά��ʶ���</td>
		<td class="middle_top" width="70">�ɶ�(��)</td>
		<td class="middle_right" width="100">�D����</td>
	</tr>
	{{foreach from=$service item=d}}
	<tr style="height: 16pt;">
	{{assign var=sid value=$d.year_seme}}
		<td class="left_left">{{$seme_arr2.$sid}}</td>
		<td class="middle_top">{{$d.service_date}}</td>
		<td class="middle_top" style="text-align:left;font-size:10pt">{{$d.item}}�G{{$d.memo}}</td>
		<td class="middle_top">{{$d.hours}}</td>
		<td class="middle_right" >{{$d.sponsor}}</td>
	</tr>	
	{{/foreach}}	
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
{{if $room_sign==1}}	
	<tr style="height: 32pt;">
		<td class="left_left" width="20%">�B��ñ��</td>
		<td class="middle_top">�ӿ�H</td>
	</tr>
{{else}}
		<tr style="height: 16pt;">
		<td class="left_left">�s �� �H</td>
		<td class="middle_top">�ǰȥD��</td>
		<td class="middle_right">�ա@�@��</td>
	</tr>
	<tr style="height: 16pt;">
		<td class="bottom_left">&nbsp;</td>
		<td class="bottom_middle">
    {{if $title_img_3}}	
     <img src="{{$title_img_3}}" height="120">
    {{else}}
		&nbsp;
		{{/if}}
	  </td>
		<td class="bottom_right">
    {{if $title_img_1}}	
     <img src="{{$title_img_1}}" height="120">
    {{else}}
		&nbsp;
		{{/if}}
		</td>	
	</tr>
{{/if}}	
	</tbody>
</table>
