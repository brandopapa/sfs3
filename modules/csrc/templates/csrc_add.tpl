{{* $Id: csrc_add.tpl 5766 2009-11-25 08:01:31Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
{{dhtml_calendar_init src="`$SFS_PATH_HTML`javascripts/calendar.js" setup_src="`$SFS_PATH_HTML`javascripts/calendar-setup.js" lang="`$SFS_PATH_HTML`javascripts/calendar-tw.js" css="`$SFS_PATH_HTML`javascripts/calendar-brown.css"}}

<form name="myform" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr>
<td bgcolor="white">
<table style="width:100%;"><tr><td class="small">
<input type="hidden" name="sel_week" value="{{$weeks_arr.0}}">
<input type="hidden" name="act" value="">

<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small">
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�D���O</td>
<td style="background-color:white;text-align:left;">{{html_options name=item_id options=$item_arr selected=$smarty.post.item_id}}</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�����O</td>
<td style="background-color:white;text-align:left;">{{html_options name=sub_id options=$sub_arr selected=$smarty.post.sub_id}}</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�ɶ�</td>
<td style="background-color:white;text-align:left;">
<input type="text" size="19" maxlength="19" id="show_time" value="" disabled style="color:black;text-align:center;width:110px;">
<input type="button" value="��ܤ��" id="date_1">
</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�a�I</td>
<td style="background-color:white;text-align:left;">
<input type="radio" name="place" value="1">�դ��@�����<br>
<input type="radio" name="place" value="2">�դ������߳���<br>
<input type="radio" name="place" value="3">�ե~����<br>
</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�~�Z</td>
<td style="background-color:white;text-align:left;">{{html_options name=class_id options=$class_arr selected=$smarty.post.class_id}}</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�H��</td>
<td style="background-color:white;text-align:left;">
�]�ƥ󦺤`�@�@ <input type="text" name="dper" size="4"> �H<br>
�]�ƥ�˯f�@�@ <input type="text" name="aper" size="4"> �H<br>
�P�ƥ������L <input type="text" name="oper" size="4"> �H
</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">������</td>
<td style="background-color:white;text-align:left;">{{$smarty.session.session_tea_name}}</td>
</tr>
<tr>
<td style="background-color:#E6E9F9;text-align:center;">�Ƶ�</td>
<td style="background-color:white;text-align:left;"></td>
</tr>
</table>
</td></tr></table>
</td>
</tr>
</table>
</form>
{{dhtml_calendar inputField="show_time" ifFormat="%Y-%m-%d %H:%M:%S" showsTime="true" button="date_1" singleClick=false}}
<script>
<!--
RightNow = new Date();
Year = RightNow.getFullYear() + "";
document.getElementById('show_time').value=(Year.replace(/^\s*/g,"") + "-" + (RightNow.getMonth()+1) + "-" + RightNow.getDate() + " " + RightNow.getHours() + ":" + RightNow.getMinutes() + ":" + RightNow.getSeconds());
-->
</script>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
