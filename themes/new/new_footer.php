<?php

// $Id: new_footer.php 5353 2009-01-20 00:48:40Z brucelyc $

global $PHP_SELF,$THEME_URL;
?>
<p>

</td></tr>
</table>
<table border='0' cellpadding='4' cellspacing='0' width='<?php echo _new_theme_width;?>' align='center' class='small'>
<tr bgcolor='#CACFFF'><td nowrap><?php echo up_button();?></td>
<td align='center' nowrap><?php echo $foot_str;?></td>
<td align='right' nowrap>���� <?php echo get_page_time() ?> ����</td></tr>
</table>



</body>
</html>


<?php
function up_button(){
	global $THEME_URL,$updir,$SFS_PATH_HTML,$SHOW_SFS_VER,
					$SFS_VER_DECLARE,$SFS_BUILD_DATE,$SFS_SCHOOL_LOGIN_PATH,
					$SFS_IS_CENTER_VER;

	$updir = updir(updir($_SERVER[SCRIPT_NAME]));

	if($updir){
		$main="<a href=\"$updir/\"><img src=\"$THEME_URL/images/u_arrow.png\" border=0 alt=�W�@�h></a>";
	} else {

		if ($SFS_IS_CENTER_VER) {
			$main="<a href=\"$SFS_PATH_HTML$SFS_SCHOOL_LOGIN_PATH/\">�^�ǮզC��</a> ";
		} else {
			$main=$SHOW_SFS_VER ? "$SFS_VER_DECLARE-$SFS_BUILD_DATE ".'&nbsp;' : '&nbsp;';
		}
	} 
	return $main;
} 
?>
