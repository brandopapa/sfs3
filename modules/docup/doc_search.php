<?php
//$Id: doc_search.php 8754 2016-01-13 12:44:14Z qfon $
// --�t�γ]�w��
include "docup_config.php";
if ($is_standalone != "1")
    head("����Ʈw");
?>
<table border=0 width=100%>
    <form method=get name=myform action="<?php echo $PHP_SELF ?>">
        <tr><td align=center><B>���d��</B> &nbsp;<select name="doc_kind_id" >
                    <option value="">�������</option>

                    <?php
                    $post_office_p = room_kind();
                    $sql_select = "select doc_kind_id from docup_p  group by doc_kind_id ";
//$result = mysql_query($sql_select) or die ($sql_select);
                    $result = $CONN->Execute($sql_select) or die($sql_select);
                    while ($row = $result->FetchRow()) {
                        $tid = $row["doc_kind_id"];
                        if ($tid == $doc_kind_id) {
                            echo sprintf(" <option value=\"%s\" selected>%s</option>", $tid, $post_office_p[$tid]);
                            $board_name = $post_office_p[$tid];
                        } else
                            echo sprintf(" <option value=\"%s\">%s</option>", $tid, $post_office_p[$tid]);
                    }
                    echo "</select>";
                    ?>
                    &nbsp;<input type="text" name="s_str" maxlength=256 value="<?php echo stripslashes($s_str) ?>">
                    &nbsp;<input type="submit" name="key" value="�j�M"></td>
                    </tr>
                    </form>
                    </table>
                    <?php
                    $s_str = $_GET['s_str'];
                    $s_str = strip_tags($s_str);
                    if ($s_str) {
                        $s_str = '%' . strip_tags($s_str) . '%';
                        //�d�ߦr��B�z
                        $s_str = stripslashes($s_str);
                        $sstr = split('[ +]', $s_str, 10);
                        while (list($tid, $tname) = each($sstr)) {
                            if (chop($tname))
                                $tempstr .= " (docup_name like '%$tname%' ) and";
                        }
                        $tempstr = substr($tempstr, 0, -3);
                        $mysqliconn = get_mysqli_conn();
                        $stmt = "";
                        $sql_select = "SELECT count(*)  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and ";
                        if ($doc_kind_id != "") {
                            $stmt = $mysqliconn->prepare('SELECT count(*)  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and doc_kind_id=' . intval($doc_kind_id) . ' and docup_name like ?');
                            $sql_select .= " doc_kind_id='$doc_kind_id' and ";
                            $stmt->bind_param('s', $s_str);
                        } else {
                            $stmt = $mysqliconn->prepare('SELECT count(*)  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and docup_name like ? ');
                            $stmt->bind_param('s', $s_str);
                        }
                        //$sql_select .= "($tempstr) ";
                        $stmt->execute();
                        $stmt->bind_result($tol_num);
                        $stmt->fetch();
                        $stmt->close();

                        //$result = mysql_query($sql_select)or die($sql_select);
                        //$row = mysql_fetch_row($result);
                        //�d���`��
                        //$page_count=5;
                        $tol_num = $row[0];
                        $totalpage = intval($tol_num / $page_count);
                        if ($tol_num / $page_count <> 0)
                            $totalpage++;

                        //�P�_���Ʀp�G���s�b�Τ����`�ɡA���w����
                        if (!$page || $page < 1)
                            $page = 1;

                        if ($page > $totalpage)
                            $page = $totalpage;

                        //�d�߳�쪩��
                        $query = "select bk_id,board_name from board_kind order by bk_id";
                        $result = mysql_query($query);
                        while ($row = mysql_fetch_row($result))
                            $board_kind_p [$row[0]] = $row[1];

                        $start_row = ($page - 1) * $page_count;
                        $sql_select = "SELECT p.doc_kind_id , p.docup_p_id , p.docup_p_name ,  p.docup_p_memo  ,d.docup_name  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and ";
                        if ($doc_kind_id != "") {
                            $stmt = $mysqliconn->prepare("SELECT p.doc_kind_id , p.docup_p_id , p.docup_p_name ,  p.docup_p_memo  ,d.docup_name  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and doc_kind_id=" . $doc_kind_id . " and docup_name like ? order By p.doc_kind_id , p.docup_p_id ,d.docup_id ");
                            $stmt->bind_param('s', $s_str);
                        } else {
                            $stmt = $mysqliconn->prepare("SELECT p.doc_kind_id , p.docup_p_id , p.docup_p_name ,  p.docup_p_memo  ,d.docup_name  FROM docup_p p ,docup d where p.docup_p_id = d.docup_p_id and docup_name like ? order By p.doc_kind_id , p.docup_p_id ,d.docup_id ");
                            $stmt->bind_param('s', $s_str);
                        }
                        //$sql_select .= "($tempstr) order By p.doc_kind_id , p.docup_p_id ,d.docup_id ";
                        //$result = mysql_query($sql_select)or die($sql_select);
                        //echo $sql_select;
                        //�̫�@��
                        $stmt->execute();

                        $stmt->bind_result($doc_kind_id, $docup_p_id, $docup_p_name, $docup_p_memo, $docup_name);

                        $end_row = $page * $page_count;
                        if ($end_row > $tol_num)
                            $end_row = $tol_num;

                        echo "<table width=100% border=0 cellpadding=2 cellspacing=0>\n<tr><td bgcolor=green nowrap>\n<font size=-1 color=#ffffff>�w�j�M<b>$board_kind_p[$bk_id]</b>����<b>$s_str</b>�C &nbsp; </font></td><td bgcolor=green align=right nowrap><font size=-1 color=#ffffff> �@����<b>$tol_num</b>���d�ߵ��G�A�o�O��<b>" . ($start_row + 1) . "</b>-<b>$end_row</b>�� �C �j�M�@�O<b>" . get_page_time() . "</b>��C</font></td></tr>";
                        $link_str = "bk_id=$bk_id&s_str=" . urlencode($s_str);
                        echo "<tr><td colspan=2 align=right>�����G" . pagesplit($page, $totalpage, 5, $link_str);
                        echo "</td></tr></table>\n";
                        while ($stmt->fetch()) {
                            echo sprintf("<p><a href=doc_list.php?doc_kind_id=%d&docup_p_id=%d>%s,%s</a> -- <font color=green>( <i>%s</i>)</font><br>\n", $doc_kind_id, $docup_p_id, $post_office_p[$doc_kind_id], $docup_p_name, $docup_p_memo); //�����C��
                            echo sprintf("<font size=-1><b>...</b>%s<b>...</b></font></p>\n", chang_word_color($sstr, $docup_name, 100)); //�����C��		
                            echo "</p>\n";
                        }
                        $stmt->close();
                    }

//echo"<hr>";

                    if ($is_standalone != "1")
                        foot();
                    ?>
