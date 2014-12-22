{{* $Id: fitness_input.tpl 7816 2013-12-17 14:10:29Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
    <style type="text/css">
        .Box1:focus
        {
            border: thin solid #FFD633;
            -webkit-box-shadow: 0px 0px 3px #F7BB2E;
            -moz-box-shadow: 0px 0px 3px #F7BB2E;
            box-shadow: 0px 0px 3px #F7BB2E;
        }
        .Box1
        {
            height: 20px;
            width: 50px;
            text-align: justify;
            letter-spacing: 1px; /*CSS letter-spacing Property*/
            padding: 1px;
            font-size: medium;
            font-weight: bold;
            font-style: normal;
        }
        .Box2:focus
        {
            border: thin solid #FFD633;
            -webkit-box-shadow: 0px 0px 3px #F7BB2E;
            -moz-box-shadow: 0px 0px 3px #F7BB2E;
            box-shadow: 0px 0px 3px #F7BB2E;
        }
        .Box2
        {
            height: 20px;
            width: 50px;
            text-align: justify;
            letter-spacing: 1px; /*CSS letter-spacing Property*/
            padding: 1px;
            font-size: medium;
            font-weight: bold;
            font-style: normal;
        }

    </style>
<script language="JavaScript">
function openwindow(t){
	window.open ("quick_input.php?t="+t+"&class_num={{$class_num}}&c_curr_seme={{$smarty.post.year_seme}}","���Z�B�z","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420");
}
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4" width="620">
<form name="myform" action="{{$smarty.server.PHP_SELF}}" method="post">
<input type="hidden" name="act" value="">
<tr>
<td bgcolor="#FFFFFF" width="620">
<table border="0" bgcolor="#FFFFFF" width="100%">
  <tr>
<td bgcolor="#FFFFFF" valign="top"><p>{{$seme_menu}} {{$class_menu}} </p></td>
<td bgcolor="#FFFFFF" valign="top" align="right">�Τ@�]�w�������G<input type="text" name="check_test_date" value="" size="10"><input type="button" value="�]�w" onclick="tag_test_date()"><input  style="color:#FF0000" type="button" value="����x�s" onclick="document.myform.act.value='save';document.myform.submit()"></td>
  </tr>
  {{if $INFO || $admin}}
  <tr>
  <td colspan="2">
  {{if $admin}}
  <input type="button" value="�ץX���Ǵ����" onclick="document.myform.act.value='export';document.myform.submit()">
  {{/if}}
  <font size="2" color="red">{{$INFO}}</font>
  </td>
  </tr>
  {{/if}}
</table>
</td>
</tr>
<tr>
<td>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%">
<tr bgcolor="#c4d9ff">
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�Ǹ�</td>
<td align="center">�ͤ�</td>
<td align="center">������</td>
<td align="center">
	��I��a�о�
 <input type="checkbox" name="check_teach_swim" value="1" onclick="tag_teach_swim()">
</td>
<td align="center">�ŧO</td>
<td align="center">���Z</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
{{assign var=sn value=$d.student_sn}}
<tr bgcolor="white">
<td class="small">{{$d.seme_num}}</td>
<td class="small"><font color="{{if $d.stud_sex==1}}blue{{elseif $d.stud_sex==2}}red{{else}}black{{/if}}">{{$d.stud_name}}</font></td>
<td style="text-align:right;">{{$d.stud_id}}</td>
<td style="text-align:right;">{{$d.stud_birthday}}</td>
<td style="text-align:right;"><input type="text" size="10" name="test_date[{{$d.student_sn}}]" value="{{$fd.$sn.test_date}}"></td>
<td style="text-align:center;">
 <input type="checkbox" name="teach_swim[{{$d.student_sn}}]" value="1" {{if $fd.$sn.teach_swim==1}} checked{{/if}}>����I
</td>
<td style="text-align:right;"><input class="Box1" type="text" name="swim_class[{{$d.student_sn}}]" value="{{$fd.$sn.swim_class}}"></td>
<td style="text-align:right;"><input class="Box2" type="text" name="swim_score[{{$d.student_sn}}]" value="{{$fd.$sn.swim_score}}"></td>
</tr>
{{/foreach}}
</table>
<input style="color:#FF0000" type="button" value="����x�s" onclick="document.myform.act.value='save';document.myform.submit()">
</td></tr>
<tr>
<td bgcolor="#FFFFF" style="font-size:10pt">
�����G<br>
1.��102�Ǧ~�װ_�A�Ш|���n�D�U�žǮձN�ǥ͡u��a�P�۱ϯ�O�v������ƤW�ǦܱШ|����A����� <a href="http://www.fitness.org.tw/" target="_blank">http://www.fitness.org.tw/</a>�A�G�}�o���\��A��K���ұЮv��U��J��ƨþ�X��ƫ�ץX�C<br>
2.<font color=blue>�u�ŧO�v���</font>�G�Ш̱Ш|����|�p�������u���ꤤ�B�p�Ǿǥʹ�a�P�۱ϯ�O�򥻫��С]���š^�v���_�A�Ǯզp����I��a�оǡA���ǥͤw�z�L��������δ�a���ɨ��o��a��O�ҩ��̩Υѱ½ұЮv�{�w�㦳�U�Ŵ�a��O�̤��ݶi��W�ǧ@�~�C�Ш̧ǿ�J1-5�]�N��Ĥ@�ܤ��š^�A���F�Ĥ@�Ŵ�a��O�̽п�J0�A�]�G�L�k�i���˴��̽Яd�šC<br>													
3.<font color=blue>�u���Z�v���</font>�G�ĤT�ܤ��Žп�J���禨�Z�A5��28���J�u5.28�v�F28��01�A�п�J�u0.28�v�Y�i�A��ƥH�ᦨ�Z�L����˥h�C															

</td>
</tr>

</table>


</form>


{{include file="$SFS_TEMPLATE/footer.tpl"}}

    <script type="text/javascript">
    //������챱��
        $(".Box1").live("keydown", function (e) {
					if (e.keyCode == 13 || e.keyCode==40) {
						var allInputs = $(".Box1");
						for (var i = 0; i < allInputs.length; i++) {
							if (allInputs[i] == this) {
								//while ((allInputs[i]).name == (allInputs[i + 1]).name) {
								//	i++;
								//}

								if ((i + 1) < allInputs.length ){
											$(allInputs[i + 1]).focus();
										 if($(allInputs[i + 1]).val()!="") //�P�_�O���O�_����
                			{
                				$(allInputs[i + 1]).select(); //����ĪG
                			}

								}
							}
						} // end for
					} // end if e.keycode==13
				
					if (e.keyCode == 38) {
						var allInputs = $(".Box1");
						for (var i = 0; i < allInputs.length; i++) {
							if (allInputs[i] == this) {
								//while ((allInputs[i]).name == (allInputs[i + 1]).name) {
								//	i++;
								//}

								if (i>0 ){
											$(allInputs[i - 1]).focus();
										 if($(allInputs[i - 1]).val()!="") //�P�_�O���O�_����
                			{
                				$(allInputs[i - 1]).select(); //����ĪG
                			}											
								}
							}
						} // end for
					} // end if e.keycode==13
					
				});

				//���Z��챱��
        $(".Box2").live("keydown", function (e) {
					if (e.keyCode == 13 || e.keyCode==40) {
						var allInputs = $(".Box2");
						for (var i = 0; i < allInputs.length; i++) {
							if (allInputs[i] == this) {
								//while ((allInputs[i]).name == (allInputs[i + 1]).name) {
								//	i++;
								//}

								if ((i + 1) < allInputs.length ){
											$(allInputs[i + 1]).focus();
										 if($(allInputs[i + 1]).val()!="") //�P�_�O���O�_����
                			{
                				$(allInputs[i + 1]).select(); //����ĪG
                			}
								}
							}
						} // end for
					} // end if e.keycode==13
				
					if (e.keyCode == 38) {
						var allInputs = $(".Box2");
						for (var i = 0; i < allInputs.length; i++) {
							if (allInputs[i] == this) {
								//while ((allInputs[i]).name == (allInputs[i + 1]).name) {
								//	i++;
								//}

								if ((i - 1) >0 ){
											$(allInputs[i - 1]).focus();
										 if($(allInputs[i - 1]).val()!="") //�P�_�O���O�_����
                			{
                				$(allInputs[i - 1]).select(); //����ĪG
                			}
								}
							}
						} // end for
					} // end if e.keycode==13
					
				});

        
    </script>

<Script language="JavaScript">


   function tag_teach_swim() {
  		var i =0;
  		var status=document.myform.check_teach_swim.checked;
  		while (i < document.myform.elements.length)  {
    		if (document.myform.elements[i].name.substr(0,10)=='teach_swim') {
      		document.myform.elements[i].checked=status;
    		}
    		i++;
  		}
		}
	  function tag_test_date() {
  		var i =0;
  		var status=document.myform.check_test_date.value;
  		while (i < document.myform.elements.length)  {
    		if (document.myform.elements[i].name.substr(0,9)=='test_date') {
      		document.myform.elements[i].value=status;
    		}
    		i++;
  		}
		}

</Script>