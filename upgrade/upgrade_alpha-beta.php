<?php
include "../include/config.php";
require_once "../include/sfs_core_globals.php";
include "../include/sfs_case_PLlib.php";
include "../include/sfs_case_sql.php";
include "update_function.php";
set_time_limit(180) ;
$postBtn = "�}�l�ɯ�";
$alpha_arr = array("0325"=>"sfs-3.0.a4-20030325","0408"=>"sfs-3.0.a4-20030408","0415"=>"sfs-3.0.a4-20030415","0424"=>"sfs-3.0.a4-20030424","0428"=>"sfs-3.0.a4-20030428");


if ($_POST[do_key] == $postBtn) {
	if($_POST[sfs_var]!='') {
		$sql_str = "./alpha/".$_POST[sfs_var].".sql";
		$do_this = false;
		switch ($_POST[sfs_var]){
			case "0325":
				$do_this = !check_table($mysql_db,$conID,"sfs_module");
			break;
			case "0408":
			case "0415":
				$do_this = !check_table($mysql_db,$conID,"grad_stud");
			break;				
			case "0424":
				$do_this = !check_table($mysql_db,$conID,"school_day");
			break;
			case "0428":
				$do_this = !check_table($mysql_db,$conID,"board");
			break;


		}
		if ($do_this) {
			echo "<hr>��u���U�p�G�S�����~�T��,��ܦw�˦��\!!<br>,�p�G�����~�T��,�i�઺��]�O�A�w�g�ɯũΧ�ʤF��ƪ�<br>�A�٬O�i�H�N�W�C��sql �y�k�[�J �ΰѦ� <a href=\"$sql_str\" target=_blank>$sql_str</a> �ӧ�s��Ʈw" ;

			echo "<p><a href=\"$_SERVER[PHP_SELF]\">���s����{��</a><hr>";
			$sql_query = read_file($sql_str);
			do_sql($sql_query,$conID);
		}
		else {
			echo "<hr> ".$alpha_arr[$_POST[sfs_var]]." ,�w�g�ɯŤF!!";
		}
			echo "</body></html>";
		exit;
	}
}
?>
<html>
<meta http-equiv="Content-Type" content="text/html; Charset=Big5">
<body>
<form name=myform method=post action="<?php $_SERVER[PHP_SELF] ?>">
<table width="100%" cellspacing=1 cellpadding=2 bgcolor="blue">
<table width="95%" cellspacing=1 cellpadding=2 align="center" bgcolor="#fcffc6">
<tr>
<td><h2>SFS3 alpha �ɯŦ� Beta ���{��</h2><hr></td>
</tr>
<tr>
<td>
	<pre>
	�ɯŻ���:

	���{������ SFS3.0 alpha4 �ɯŦ� beta1 ��Ʈw�ഫ�{��,
	�p�G�z�� sfs3 alpha ���w�����W�u�ϥ�,��ĳ���楻�{���ɯūe
	��<font color=red size=4>�ƥ��A����Ʈw</font>,���{���ȴ����ഫ
	alpha �����X�ɪ���l����Ʈw�榡,�p�G�z<font color=red size=4>�w�F�ѤW�z����</font>,
	���ˬd�z������,�ǳƤɯŦ� SFS3.0 Beta1 !!
	</pre>

 </td>
</tr>
<tr>
<td>
��� alpha �������ɯ� &nbsp;&nbsp;
<?php
	$sel = new drop_select();
	$sel->s_name = "sfs_var";
	$sel->arr = $alpha_arr;
	$sel->top_option = "��� SFS3 alpha ����";
	$sel->do_select();		
?>
</td>
</tr>
<tr>
<td> <input type=submit name="do_key" value="<?php echo $postBtn ?>">
</table>
</table>
</form>
</body>
</html>


<?php
function do_sql($sql_query,$conID) {
if ($sql_query != '') {
    $pieces       = array();
    PMA_splitSqlFile_2($pieces, $sql_query, PMA_MYSQL_INT_VERSION);
    $pieces_count = count($pieces);

    // Copy of the cleaned sql statement for display purpose only (see near the
    // beginning of "db_details.php" & "tbl_properties.php")
    if ($sql_file != 'none' && $pieces_count > 10) {
         // Be nice with bandwidth...
       $sql_query_cpy = $sql_query = '';
    } else {
        $sql_query_cpy = implode(";\n", $pieces) . ';';
    }

    // Only one query to run
    if ($pieces_count == 1 && !empty($pieces[0]) ) {
        // sql.php will stripslash the query if get_magic_quotes_gpc
        if (get_magic_quotes_gpc() == 1) {
            $sql_query = addslashes($pieces[0]);
        } else {
            $sql_query = $pieces[0];
        }
        if (eregi('^(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(TABLE|DATABASE)[[:space:]]+(.+)', $sql_query)) {
            $reload = 1;
        }
       // include('./sql.php');
        exit();
    }

    // Runs multiple queries
    else  {
        for ($i = 0; $i < $pieces_count; $i++) {
            $a_sql_query = $pieces[$i];
            $result = mysql_query($a_sql_query,$conID);
            if ($result == FALSE) { // readdump failed
                $my_die = $a_sql_query;
		echo "���~���y�k :<br>$my_die <BR><br>";
                //break;
            }
            if (!isset($reload) && eregi('^(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(TABLE|DATABASE)[[:space:]]+(.+)', $a_sql_query)) {
                $reload = 1;
            }
        } // end for
    } // end else if
    unset($pieces);
} // end if

}


?>
