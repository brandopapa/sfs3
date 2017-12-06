{{* $Id: list.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

{{include file="$SFS_TEMPLATE/header.tpl"}}

<script>
function tagall(item,status) {
  var i =0;
  item=item+"[]";
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name==item) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}

function check_select(item) {
  var i=0; k=0; answer=true;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].checked) {
		if(document.myform.elements[i].name==item) k++;
    }
    i++;
  }
  if(k==0) { alert("尚未選取要簽認的請假紀錄！"); answer=false; }
 
  return answer;
}

</script>

{{include file="$SFS_TEMPLATE/menu.tpl"}}

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">

<tr><td bgcolor="#FFFFFF">

<table width="100%">

<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}">
<input type="hidden" name="go" value="">

<tr>

<td>{{$year_seme_menu}} {{$abs_kind}}　請假人:{{$leave_teacher_menu}}　代理人:{{$leave_deputy_menu}}　{{$month}}　{{ $d_check4_menu}} 　
<a  href='record.php'><u>新增假單</u></a></td>

</tr>

<tr><td>

<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">

<tr bgcolor="#E1ECFF" align="center">

<td>序號</td>
<td >教師姓名</td>
<td>假別</td>
<td>事由</td>
<td >開始時間<br>結束時間</td>
<td>日數時數</td>

<td>課務</td>

<td><input type="checkbox" name="deputy_all" onclick="tagall('deputy',this.checked)"><input type="submit" name="act" value="職務代理人" onclick="if(confirm('確定要進行職務代理人簽核？')) { this.form.go.value='deputy';}"></td>
<td><input type="checkbox" name="check1_all" onclick="tagall('check1',this.checked)"><input type="submit" name="act" value="{{$check1}}" onclick="if(confirm('確定要進行{{$check1}}簽核？')) { this.form.go.value='check1';}"></td>
{{if $isAdmin}}
<td><input type="checkbox" name="check2_all" onclick="tagall('check2',this.checked)"><input type="submit" name="act" value="{{$check2}}" onclick="if(confirm('確定要進行{{$check2}}簽核？')) { this.form.go.value='check2';}"></td>
<td><input type="checkbox" name="check3_all" onclick="tagall('check3',this.checked)"><input type="submit" name="act" value="{{$check3}}" onclick="if(confirm('確定要進行{{$check3}}簽核？')) { this.form.go.value='check3';}"></td>
<td><input type="checkbox" name="check4_all" onclick="tagall('check4',this.checked)"><input type="submit" name="act" value="{{$check4}}" onclick="if(confirm('確定要進行{{$check4}}簽核？')) { this.form.go.value='check4';}"></td>
{{else}}
<td>{{$check2}}</td>
<td>{{$check3}}</td>
<td>{{$check4}}</td>
{{/if}}
</tr>

{{foreach from=$absent item=a name=absent}}

<tr bgcolor="#ddddff" align="center" OnMouseOver="sbar(this)" OnMouseOut="cbar(this)">

<td width=30>{{$a.id}}<br>
{{if ($a.status=="0" and $a.check1_sn =="0" and $a.check2_sn =="0" and $a.check3_sn =="0" and $a.check4_sn =="0") or $isAdmin }}
	<input type="image" src="images/edit.png" name="edit[{{$a.id}}]" alt="修改資料"> 
	<input type="image" src="images/del.png" name="del[{{$a.id}}]" alt="刪除假單" onclick="return confirm('確定刪除假單?')">
{{/if}}


</td>

<td width=80 nowrap="nowrap"><font size=3>{{$tea_arr[$a.teacher_sn]|replace:'--':'<br />'}}</font><br/>
    {{$a.record_date|date_format:"%Y-%m-%d"}}
</td>
<td>{{$abs_kind_arr[$a.abs_kind]}}
	{{if ($a.abs_kind==52 )}} 
		<input type="image" src="images/supply.png" name="outlay[{{$a.id}}]" alt="差旅費處理">
	{{/if}}
	<br><font color=blue>{{$a.note}}</font></td>
<td  width=80 >{{$a.reason}}
<br><font color=blue>{{$a.locale}}</font>
{{if $a.note_file}}<a href="{{$upload_url}}school/teacher_absent/{{$a.note_file}}">下載證明文件</a>{{/if}}
</td>
<td td width=120><font size=3>{{$a.start_date|date_format:"%Y-%m-%d %H:%M"}}<br>

{{$a.end_date|date_format:"%Y-%m-%d %H:%M"}}</font></td>

<td>
{{if $a.day>0 }}{{$a.day}}日{{/if}}
{{if $a.hour>0 }}{{$a.hour}}時{{/if}}
</td>

<td>
{{$course_kind_arr[$a.class_dis]}}<br>
<input type="image" src="images/supply.png" name="class_t[{{$a.id}}]" alt="課務處理">
</td>

<td>{{$tea_arr[$a.deputy_sn]}}
{{if $a.status=="1" }}
	{{if $a.check1_sn =="0" }}
		<input type="image" src="images/del.png" name="deputy_c[{{$a.id}}]" alt="我要取消">
	{{/if}}
	<br>{{$a.deputy_date|date_format:"%Y-%m-%d"}}
{{elseif $a.deputy_sn>0}}
	<br><input type="checkbox" name="deputy[]" value="{{$a.id}}"><font color="red">待確認</font>
{{/if}}


</td>
<td>{{$tea_arr[$a.check1_sn]}}
{{if $a.check1_sn>0}}
	{{if $a.check2_sn =="0" and $a.check1_sn == $session_tea_sn  }}
		<input type="image" src="images/del.png" name="check1_c[{{$a.id}}]" alt="我要取消">
	{{/if}}
	<br>{{$a.check1_date|date_format:"%Y-%m-%d"}}
{{elseif $a.status== "1"}}
	<br><input type="checkbox" name="check1[]" value="{{$a.id}}"><font color="red">待確認</font>
{{/if}}

</td>

<td>{{$tea_arr[$a.check2_sn]}}
{{if $a.check2_sn > "0" }}
	{{if $a.check3_sn =="0" and $a.check2_sn == $session_tea_sn  and $isAdmin}}
		<input type="image" src="images/del.png" name="check2_c[{{$a.id}}]" alt="我要取消">
	{{/if}}
	<br>{{$a.check2_date|date_format:"%Y-%m-%d"}}
{{elseif $a.check1_sn > "0"  }}
    {{if $a.title_kind < 12}}
	<br>{{if $isAdmin}}<input type="checkbox" name="check2[]" value="{{$a.id}}">{{/if}}<font color="red">待確認</font>
    {{/if}}
{{/if}}
</td>
<td>{{$tea_arr[$a.check3_sn]}}
{{if $a.check3_sn > "0"}}
	{{if $a.check4_sn =="0" and $a.check3_sn == $session_tea_sn and $isAdmin }}
		<input type="image" src="images/del.png" name="check3_c[{{$a.id}}]" alt="我要取消">
	{{/if}}
	<br>{{$a.check3_date|date_format:"%Y-%m-%d"}}
{{elseif $a.check2_sn > "0"  or ( $a.check1_sn > "0" and $a.title_kind > 11)}}
	<br>{{if $isAdmin}}<input type="checkbox" name="check3[]" value="{{$a.id}}">{{/if}}<font color="red">待確認</font>
{{/if}}
</td>

<td>{{$tea_arr[$a.check4_sn]}}
{{if $a.check4_sn > "0" }}
	{{if $a.check4_sn == $session_tea_sn and $isAdmin}}
		<input type="image" src="images/del.png" name="check4_c[{{$a.id}}]" alt="我要取消">
	{{/if}}
	<br>{{$a.check2_date|date_format:"%Y-%m-%d"}}
{{elseif $a.check3_sn >"0" and $a.check4_sn == 0}}
	<br>{{if $isAdmin}}<input type="checkbox" name="check4[]" value="{{$a.id}}">{{/if}}<font color="red">待確認</font>
{{/if}}

</td>

</tr>

{{/foreach}}

</table></td>

</tr>

</form>

</table></td>

</tr>

</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}



<script language="JavaScript1.2">

<!-- Begin

function sbar(st){st.style.backgroundColor="#F3F3F3";}

function cbar(st){st.style.backgroundColor="";}

//  End -->

</script>