{{* $Id: fitness_print.tpl 7262 2013-04-10 07:30:00Z smallduh $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script language="JavaScript">
function openwindow(sn){
	window.open ("fitpass.php?student_sn="+sn,"�ӤH�@��","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420");
}
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4">
<form action="{{$smarty.server.PHP_SELF}}" method="post">
<tr>
<td bgcolor="#FFFFFF" valign="top">
{{$seme_menu}} {{$class_menu}} <input type="submit" name="cal_per" value="����ʤ�����"> <font size="3" color="blue">�������G<input type="text" name="test_y" size="3" value="{{$smarty.post.test_y}}">�~<input type="text" name="test_m" size="3" value="{{$smarty.post.test_m}}">�� <input type="submit" name="cal_age" value="�p��~��"> <input type="submit" name="print_html" value="�C�L"> | {{$all_students}} <input type="submit" name="export" value="�ץXCSV��"><input type="submit" name="export2" value="�ץX�M�L���Z�ҩ�CSV��"></font><br>
<font color="gold">��</font>85�H�H�W <font color="silver">��</font>75�H�H�W <font color="bronze">��</font>50�H�H�W <font color="red">��</font>24�H�H�U
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%">
<tr bgcolor="#c4d9ff">
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�ͤ�</td>
<td align="center">����<br>(cm)[�H]</td>
<td align="center">�魫<br>(kg)[�H]</td>
<td align="center">BMI����<br>(kg/m<sup>2</sup>)[�H]</td>
<td align="center">�����e�s<br>(cm)[�H]</td>
<td align="center">�ߩw����<br>(cm)[�H]</td>
<td align="center">���װ_��<br>(��)[�H]</td>
<td align="center">�ߪ;A��<br>(��)[�H]</td>
<td align="center">�~��</td>
<td align="center">����~��</td>
<td align="center">����</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
{{assign var=sn value=$d.student_sn}}
<tr bgcolor="white">
<td class="small">{{$d.seme_num}}</td>
<td class="small"><a OnClick="openwindow('{{$sn}}');" title="{{$d.stud_name}}���ӤH�@��"><font color="{{if $d.stud_sex==1}}blue{{elseif $d.stud_sex==2}}red{{else}}black{{/if}}">{{$d.stud_name}}</font></a></td>
<td style="text-align:right;">{{$d.stud_birthday}}</td>
<td style="text-align:right;">{{$fd.$sn.tall}}<font color="{{if $fd.$sn.prec_t>=85}}gold{{elseif $fd.$sn.prec_t>=75}}silver{{elseif $fd.$sn.prec_t>=50}}bronze{{elseif $fd.$sn.prec_t<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec_t}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.weigh}}<font color="{{if $fd.$sn.prec_w>=85}}gold{{elseif $fd.$sn.prec_w>=75}}silver{{elseif $fd.$sn.prec_w>=50}}bronze{{elseif $fd.$sn.prec_w<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec_w}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.bmt}}<font color="{{if $fd.$sn.prec_b>=85}}gold{{elseif $fd.$sn.prec_b>=75}}silver{{elseif $fd.$sn.prec_b>=50}}bronze{{elseif $fd.$sn.prec_b<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec_b}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.test1}}<font color="{{if $fd.$sn.prec1>=85}}gold{{elseif $fd.$sn.prec1>=75}}silver{{elseif $fd.$sn.prec1>=50}}bronze{{elseif $fd.$sn.prec1<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec1}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.test3}}<font color="{{if $fd.$sn.prec3>=85}}gold{{elseif $fd.$sn.prec3>=75}}silver{{elseif $fd.$sn.prec3>=50}}bronze{{elseif $fd.$sn.prec3<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec3}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.test2}}<font color="{{if $fd.$sn.prec2>=85}}gold{{elseif $fd.$sn.prec2>=75}}silver{{elseif $fd.$sn.prec2>=50}}bronze{{elseif $fd.$sn.prec2<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec2}}]</font></td>
<td style="text-align:right;">{{$fd.$sn.test4}}<font color="{{if $fd.$sn.prec4>=85}}gold{{elseif $fd.$sn.prec4>=75}}silver{{elseif $fd.$sn.prec4>=50}}bronze{{elseif $fd.$sn.prec4<25}}red{{else}}black{{/if}}">[{{$fd.$sn.prec4}}]</font></td>
<td style="text-align:center;">{{$fd.$sn.age}}</td>
<td style="text-align:center;">{{$fd.$sn.test_y}}-{{$fd.$sn.test_m}}</td>
<td style="text-align:center;">{{if $fd.$sn.reward}}{{$fd.$sn.reward}}{{else}}--{{/if}}</td>
</tr>
{{/foreach}}
{{foreach from=$avg item=d key=i}}
<tr style="text-align:right;background-color:white;">
<td class="small" colspan="3" bgcolor="#c4d9ff">{{$avg_title.$i}}����</td><td>{{$d.a_tall|@round:1}}</td><td>{{$d.a_weigh|@round:1}}</td><td>{{$d.a_bmt|@round:1}}</td><td>{{$d.a_test1|@round:1}}</td><td>{{$d.a_test3|@round:1}}</td><td>{{$d.a_test2|@round:1}}</td><td>{{$d.a_test4|@round:1}}</td><td align="center">--</td><td align="center">-----</td><td align="center">--</td>
</tr>
{{/foreach}}
<tr style="text-align:right;background-color:white;">
<td class="small" colspan="3" bgcolor="#c4d9ff">50�H�H�W�H��</td>
{{foreach from=$cou item=d}}
<td>{{$d}}</td>
{{/foreach}}
<td align="center">--</td><td align="center">-----</td><td align="center">--</td>
</tr>
</table>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�q2012.12.08�_�~�֭p��אּ���C�Ӥ�~�i�@��(�P�Ш|����A������p��覡�ۦP)�C</li>
	</ol>
</td></tr>
</table>
</td></tr></form></table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
