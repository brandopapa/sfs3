{{* $Id: health_accident_count.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<table cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="3">�Ǵ�</td>
<td rowspan="3">���</td>
<td colspan="3" rowspan="2">�ʧO</td>
<td colspan="3">�ɶ�</td>
<td colspan="11">�a�I</td>
<td colspan="15">����</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="2">�W<br>��</td>
<td rowspan="2">��<br>��</td>
<td rowspan="2">�U<br>��</td>
<td rowspan="2">�B<br>��<br>��</td>
<td rowspan="2">�C<br>��<br>��<br>��</td>
<td rowspan="2">��<br>�q<br>��<br>��</td>
<td rowspan="2">�M<br>��<br>��<br>��</td>
<td rowspan="2">��<br>�Y</td>
<td rowspan="2">��<br>��</td>
<td rowspan="2">�a<br>�U<br>��</td>
<td rowspan="2" nowrap>�鬡<br>�|��<br>�]��<br>�Τ�</td>
<td rowspan="2">�Z<br>��</td>
<td rowspan="2">��<br>�~</td>
<td rowspan="2">��<br>�L</td>
<td rowspan="2">�Y</td>
<td rowspan="2">�V</td>
<td rowspan="2">��</td>
<td rowspan="2">��</td>
<td rowspan="2">��</td>
<td rowspan="2">�I</td>
<td rowspan="2">��</td>
<td rowspan="2">�C<br>��</td>
<td rowspan="2">�f<br>��</td>
<td rowspan="2">��<br>��<br>��</td>
<td rowspan="2">�W<br>��</td>
<td rowspan="2">�y</td>
<td rowspan="2">�v<br>��</td>
<td rowspan="2">�U<br>��</td>
<td rowspan="2">�|<br>��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�X<br>�p</td>
<td>�k</td>
<td>�k</td>
</tr>
{{assign var=dd value=$rowdata}}
{{foreach from=$month_arr item=d}}
<tr style="background-color:{{cycle values="white,yellow"}};">
{{if $d==8}}<td rowspan="6">�W<br>��<br>��</td>{{elseif $d==2}}<td rowspan="6" style="background-color:yellow;">�U<br>��<br>��</td>{{/if}}
<td>{{$d}}</td>
<td>{{$dd.sex.3.$d}}</td>
<td>{{$dd.sex.1.$d}}</td>
<td>{{$dd.sex.2.$d}}</td>
<td> </td>
<td> </td>
<td> </td>
<td>{{$dd.place.1.$d}}</td>
<td>{{$dd.place.2.$d}}</td>
<td>{{$dd.place.3.$d}}</td>
<td>{{$dd.place.4.$d}}</td>
<td>{{$dd.place.5.$d}}</td>
<td>{{$dd.place.6.$d}}</td>
<td>{{$dd.place.7.$d}}</td>
<td>{{$dd.place.8.$d}}</td>
<td>{{$dd.place.9.$d}}</td>
<td>{{$dd.place.10.$d}}</td>
<td>{{$dd.place.999.$d}}</td>
<td>{{$dd.part.1.$d}}</td>
<td>{{$dd.part.2.$d}}</td>
<td>{{$dd.part.3.$d}}</td>
<td>{{$dd.part.4.$d}}</td>
<td>{{$dd.part.5.$d}}</td>
<td>{{$dd.part.6.$d}}</td>
<td>{{$dd.part.7.$d}}</td>
<td>{{$dd.part.8.$d}}</td>
<td>{{$dd.part.9.$d}}</td>
<td>{{$dd.part.10.$d}}</td>
<td>{{$dd.part.11.$d}}</td>
<td>{{$dd.part.12.$d}}</td>
<td>{{$dd.part.13.$d}}</td>
<td>{{$dd.part.14.$d}}</td>
<td>{{$dd.part.15.$d}}</td>
</tr>
{{/foreach}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">�`�p</td>
<td>{{$dd.sex.3.total}}</td>
<td>{{$dd.sex.1.total}}</td>
<td>{{$dd.sex.2.total}}</td>
<td> </td>
<td> </td>
<td> </td>
<td>{{$dd.place.1.total}}</td>
<td>{{$dd.place.2.total}}</td>
<td>{{$dd.place.3.total}}</td>
<td>{{$dd.place.4.total}}</td>
<td>{{$dd.place.5.total}}</td>
<td>{{$dd.place.6.total}}</td>
<td>{{$dd.place.7.total}}</td>
<td>{{$dd.place.8.total}}</td>
<td>{{$dd.place.9.total}}</td>
<td>{{$dd.place.10.total}}</td>
<td>{{$dd.place.999.total}}</td>
<td>{{$dd.part.1.total}}</td>
<td>{{$dd.part.2.total}}</td>
<td>{{$dd.part.3.total}}</td>
<td>{{$dd.part.4.total}}</td>
<td>{{$dd.part.5.total}}</td>
<td>{{$dd.part.6.total}}</td>
<td>{{$dd.part.7.total}}</td>
<td>{{$dd.part.8.total}}</td>
<td>{{$dd.part.9.total}}</td>
<td>{{$dd.part.10.total}}</td>
<td>{{$dd.part.11.total}}</td>
<td>{{$dd.part.12.total}}</td>
<td>{{$dd.part.13.total}}</td>
<td>{{$dd.part.14.total}}</td>
<td>{{$dd.part.15.total}}</td>
</tr>
</table><br>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="3">�Ǵ�</td>
<td rowspan="3">���</td>
<td colspan="24">���˺���</td>
<td colspan="9">�B�z�覡</td>
<td rowspan="3">�[<br>��<br>��<br>��<br>�D<br>��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="10">�N�~�ˮ`</td>
<td colspan="14">����e�w</td>
<td rowspan="2">��<br>�f<br>�@<br>�z</td>
<td rowspan="2">�B<br>��</td>
<td rowspan="2">��<br>��</td>
<td rowspan="2">��<br>��<br>�[<br>��</td>
<td rowspan="2">�q<br>��<br>�a<br>��</td>
<td rowspan="2">�a<br>��<br>�a<br>�^</td>
<td rowspan="2">��<br>��<br>�e<br>��</td>
<td rowspan="2">��<br>��<br>��<br>�|</td>
<td rowspan="2">��<br>�L<br>�B<br>�z</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>��<br>��</td>
<td>��<br>��<br>��</td>
<td>��<br>��<br>��</td>
<td>��<br>��<br>��</td>
<td>��<br>��</td>
<td>�`<br>�S<br>��</td>
<td>�m<br>�r<br>��</td>
<td>��<br>��</td>
<td>��<br>��</td>
<td>�~<br>��<br>��<br>�L</td>
<td>�o<br>�N</td>
<td>�w<br>�t</td>
<td>��<br>��<br>��<br>�R</td>
<td>�Y<br>�h</td>
<td>��<br>�h</td>
<td>�G<br>�h</td>
<td>��<br>�h</td>
<td>��<br>�m</td>
<td>�g<br>�h</td>
<td>��<br>��</td>
<td>�y<br>��<br>��</td>
<td>�l<br>�o</td>
<td>��<br>�e</td>
<td>��<br>��<br>��<br>�L</td>
</tr>
{{foreach from=$month_arr item=d}}
<tr style="background-color:{{cycle values="white,yellow"}};">
{{if $d==8}}<td rowspan="6">�W<br>��<br>��</td>{{elseif $d==2}}<td rowspan="6" style="background-color:yellow;">�U<br>��<br>��</td>{{/if}}
<td>{{$d}}</td>
<td>{{$dd.status.1.$d}}</td>
<td>{{$dd.status.2.$d}}</td>
<td>{{$dd.status.3.$d}}</td>
<td>{{$dd.status.4.$d}}</td>
<td>{{$dd.status.5.$d}}</td>
<td>{{$dd.status.6.$d}}</td>
<td>{{$dd.status.7.$d}}</td>
<td>{{$dd.status.8.$d}}</td>
<td>{{$dd.status.9.$d}}</td>
<td>{{$dd.status.10.$d}}</td>
<td>{{$dd.status.11.$d}}</td>
<td>{{$dd.status.12.$d}}</td>
<td>{{$dd.status.13.$d}}</td>
<td>{{$dd.status.14.$d}}</td>
<td>{{$dd.status.15.$d}}</td>
<td>{{$dd.status.16.$d}}</td>
<td>{{$dd.status.17.$d}}</td>
<td>{{$dd.status.18.$d}}</td>
<td>{{$dd.status.19.$d}}</td>
<td>{{$dd.status.20.$d}}</td>
<td>{{$dd.status.21.$d}}</td>
<td>{{$dd.status.22.$d}}</td>
<td>{{$dd.status.23.$d}}</td>
<td>{{$dd.status.24.$d}}</td>
<td>{{$dd.attend.1.$d}}</td>
<td>{{$dd.attend.2.$d}}</td>
<td>{{$dd.attend.3.$d}}</td>
<td>{{$dd.attend.4.$d}}</td>
<td>{{$dd.attend.5.$d}}</td>
<td>{{$dd.attend.6.$d}}</td>
<td>{{$dd.attend.7.$d}}</td>
<td>{{$dd.attend.8.$d}}</td>
<td>{{$dd.attend.9.$d}}</td>
<td>{{$dd.min.$d}}</td>
</tr>
{{/foreach}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td colspan="2">�`�p</td>
<td>{{$dd.status.1.total}}</td>
<td>{{$dd.status.2.total}}</td>
<td>{{$dd.status.3.total}}</td>
<td>{{$dd.status.4.total}}</td>
<td>{{$dd.status.5.total}}</td>
<td>{{$dd.status.6.total}}</td>
<td>{{$dd.status.7.total}}</td>
<td>{{$dd.status.8.total}}</td>
<td>{{$dd.status.9.total}}</td>
<td>{{$dd.status.10.total}}</td>
<td>{{$dd.status.11.total}}</td>
<td>{{$dd.status.12.total}}</td>
<td>{{$dd.status.13.total}}</td>
<td>{{$dd.status.14.total}}</td>
<td>{{$dd.status.15.total}}</td>
<td>{{$dd.status.16.total}}</td>
<td>{{$dd.status.17.total}}</td>
<td>{{$dd.status.18.total}}</td>
<td>{{$dd.status.19.total}}</td>
<td>{{$dd.status.20.total}}</td>
<td>{{$dd.status.21.total}}</td>
<td>{{$dd.status.22.total}}</td>
<td>{{$dd.status.23.total}}</td>
<td>{{$dd.status.24.total}}</td>
<td>{{$dd.attend.1.total}}</td>
<td>{{$dd.attend.2.total}}</td>
<td>{{$dd.attend.3.total}}</td>
<td>{{$dd.attend.4.total}}</td>
<td>{{$dd.attend.5.total}}</td>
<td>{{$dd.attend.6.total}}</td>
<td>{{$dd.attend.7.total}}</td>
<td>{{$dd.attend.8.total}}</td>
<td>{{$dd.attend.9.total}}</td>
<td>{{$dd.min.total}}</td>
</tr>
</table>
</td></tr></table>