{{* $Id: health_analyze_sight_class2.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<fieldset class="small" style="width:30%;">
<legend style="color:blue;font-size:12pt;">���O���p</legend>
<select name=status_id>
{{html_options options=$sight_chk_status selected=$smarty.post.status_id}}
</select>
</fieldset>
<fieldset class="small" style="width:30%;">
<legend style="color:blue;font-size:12pt;">�z����O</legend>
�r��
<select name="o_value">
{{html_options options=$sight_value selected=$smarty.post.o_value}}
</select>�@
�B��
<select name="r_value">
{{html_options options=$sight_value selected=$smarty.post.r_value}}
</select>
</fieldset>
<input type="hidden" name="sel" id="sel" value="{{$smarty.post.sel}}">
<input type="button" value="�}�l�z��" OnClick="document.getElementById('sel').value='1';this.form.submit();">