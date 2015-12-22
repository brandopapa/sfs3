<?php

// $Id: sfs_case_ado.php 8642 2015-12-16 05:08:52Z hsiao $
//���oMySQLi�s�u
function get_mysqli_conn() {
    global $mysql_host, $mysql_user, $mysql_pass, $mysql_db;
    $mysqliconn = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    if ($mysqliconn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    //echo $mysqli->host_info . "\n";
    return $mysqliconn;
}

//���o mysql �t���ܼ�
function get_mysql_var() {
    global $CONN;
    // �T�w�s�u����
    if (!$CONN)
        user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I", 256);

    // init
    $resarr = array();

    $query = "show variables ";
    $res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query", 256);
    while (!$res->EOF) {
        $resarr[$res->fields[0]] = $res->fields[1];
        $res->MoveNext();
    }
    return $resarr;
}

//���u��
class ado_grid_menu {

    var $action_script = ""; //����{��
    var $action_path = ""; //�{�����|
    var $data_link;    //��Ʈw�s��	
    var $row = 18;      //��ܵ���
    var $width = 120;   //�e
    var $key_item = "";  // ������W
    var $bgcolor = "#FFFFFF";
    var $formname = "gridform";
    var $fontsize = "13px";
    var $sql_str = "";   //SQL �R�O	
    var $count_row = 0;  //�`����
    var $link_str = "--"; //�s���r��
    var $display_item = array(); //�����W�}�C
    var $display_color = array(); //����C��}�C
    var $color_index_item = "";  //�C��P�_���
    var $select_item = array(); // option �}�C
    var $color_item = array(); // option �}�C
    var $default_color = false; //�ϥιw�]������C��
    var $default_color_item = array("#734B45", "#736745", "#647345", "#447073", "#444473", "#634473", "#734368", "#733C47");
    var $br_num = 10; //�έp�r�괫�����
    var $up_str = ""; //�W����ܦr��
    var $down_str = ""; //�U����ܦr��
    var $disabled = 0; //�ܬ����i�ާ@�_
    var $dispaly_nav = true; // ��ܤU����s
    var $top_option = ""; //�Ĥ@�ӿﶵ��r
    var $nodata_name = "�L���";
    var $class_ccs = "";
    var $show_item_tol = true; //��ܤ��P���O�έp

    function ado_grid_menu($action_script = '', $action_path = '', $data_link = null) {
        if ($action_script != '')
            $this->action_script = $action_script;
        else
            $this->action_script = $_SERVER['SCRIPT_NAME'];
        $this->action_path = $action_path;
        $this->data_link = $data_link;
    }

//����R�O
    function do_query() {

        $conn = $this->data_link;
        $res_arr = array();
        $display_arr = array();
        //������
        $display_arr = $this->display_item;
        $num = count($display_arr);

        $result = $conn->Execute($this->sql_str) or user_error("���楢�ѡI<br>$this->sql_str", 256);
        $this->count_row = $result->RecordCount();

        if ($this->count_row < $this->row)
            $this->row = $this->count_row;

        while (!$result->EOF) {
            $temp = "";
            for ($i = 0; $i < $num; $i++) {
                $temp .= $result->fields[$display_arr[$i]];
                if ($i + 1 < $num)
                    $temp .= $this->link_str;
            }
            $this->select_item[$result->fields[$this->key_item]] = $temp;
            if ($this->color_index_item) {
                //�ϥιw�]�C��
                if ($this->default_color)
                    $this->display_color[$result->fields[$this->color_index_item]] = $this->get_color_item($c++);

                $this->color_item[$result->fields[$this->key_item]] = $result->fields[$this->color_index_item];
            }
            $result->MoveNext();
        }
    }

// ���
    function print_grid($key, $up_str = "", $down_str = "") {
        global $SFS_PATH_HTML;
        if ($up_str) //�W����ܦr��
            $this->up_str = $up_str;
        if ($down_str) //�U����ܦr��
            $this->down_str = $down_str;
        if ($this->dispaly_nav) {//�W�߿��
            echo "<SCRIPT>function " . $this->formname . "_update(s_value) {document." . $this->formname . "." . $this->key_item . ".value=s_value; document." . $this->formname . ".submit();}</SCRIPT>\n";
            if ($this->disabled) //�ܬ����i�ާ@�_
                echo "<form name=\"" . $this->formname . "\" method=post action=\"" . $this->action_script . "\" disabled>\n";
            else
                echo "<form name=\"" . $this->formname . "\" method=post action=\"" . $this->action_script . "\">\n";
        }
        echo "<table width=\"1\" cellspacing=0 cellpadding=0>\n";
        if ($this->up_str)
            echo "<tr ><td align=center " . $this->class_ccs . ">" . $this->up_str . "</td></tr>";
        echo "<tr><td " . $this->class_ccs . ">";
        echo "<img src=\"" . $SFS_PATH_HTML . "images/pixel_clear.gif\" width=\"" . $this->width . "\" height=1>";
        echo "</td></tr>\n";

        if ($this->count_row == 0 && $this->dispaly_nav)
            echo "</tr><td align=center " . $this->class_ccs . ">" . $this->nodata_name . "</td></tr>\n";
        else {
            echo "<tr " . $this->class_ccs . "><td align=center " . $this->class_ccs . ">\n";
            if ($this->dispaly_nav) //�W�߿��
                echo "<select style=\"background-color:" . $this->bgcolor . ";font-size: " . $this->fontsize . "\" onchange=\"document." . $this->formname . ".submit()\" size=\"" . $this->row . "\" name=\"" . $this->key_item . "\">\n";
            else
                echo "<select style=\"background-color:" . $this->bgcolor . ";font-size: " . $this->fontsize . "\"  size=\"" . $this->row . "\" name=\"" . $this->key_item . "\">\n";
            $ii = 1;
            if ($this->top_option)
                echo "<option value=\"\">" . $this->top_option . "</option>\n";
            while (list($tid, $tname) = each($this->select_item)) {
                if ($this->color_index_item)
                    $temp_color = " STYLE=\"color: " . $this->display_color[$this->color_item[$tid]] . "\" \n";
                if (strval($tid) === $key) {
                    echo "<option $temp_color value=\"$tid\" selected >$tname</option>\n";
                    $nav_prior = $temp_id;
                    $flag = 1;
                    $this_row = $ii;
                } else
                    echo "<option $temp_color value=\"$tid\">$tname</option>\n";
                $temp_id = $tid;
                if ($flag > 0) {
                    if ($flag == 2) {
                        $nav_next = $temp_id;
                        $flag = 0;
                    } else
                        $flag++;
                }
                $ii++;
            }
            $ii--;
            echo "</select>\n";
            echo "</td>\n";
            echo "</tr>\n";
            if ($this->dispaly_nav) {
                echo "<tr >\n";
                echo "<td align=center " . $this->class_ccs . ">���ơG $this_row / $ii</td>\n";
                echo "</tr>\n";
                //�έp���P�ﶵ
                if ($this->color_index_item && $this->show_item_tol) {
                    $color_tol = @array_count_values(array_values($this->color_item));
                    echo "<tr><td align=center " . $this->class_ccs . " >";
                    reset($color_tol);
                    while (list($tid, $tname) = each($color_tol)) {
                        echo "<font color=" . $this->display_color[$tid] . ">*$tname</font>&nbsp;";
                        if ($iii++ % ($this->br_num) == ($this->br_num - 1))
                            echo "<BR />";
                    }
                    echo "</td></tr>\n";
                }
                echo "<tr><td align=center>";
                if (strlen($nav_prior) > 0)
                    echo "&nbsp;<input type=button value=\"  ^  \" onclick=\"" . $this->formname . "_update('$nav_prior')\" >";
                else
                    echo "&nbsp;<input type=button value=\"  ^  \" disabled >";
                if ($nav_next <> "")
                    echo "&nbsp;<input type=button value=\"  v  \" onclick=\"" . $this->formname . "_update('$nav_next')\" >";
                else
                    echo "&nbsp;<input type=button value=\"  v  \" disabled >";
                echo "</td></tr>\n";
            }
        }
        if ($this->down_str != "")
            echo "<tr><td align=center>" . $this->down_str . "</td></tr>";
        echo "<input type=hidden name=nav_prior value=\"$nav_prior\">\n";
        echo "<input type=hidden name=nav_next value=\"$nav_next\">\n";
        echo "</table>";
        if ($this->dispaly_nav)//�W�߿��
            echo "</form>\n";
    }

// ���
    function get_grid_str($key, $up_str = "", $down_str = "") {
        global $SFS_PATH_HTML;
        $res_str = '';
        if ($up_str) //�W����ܦr��
            $this->up_str = $up_str;
        if ($down_str) //�U����ܦr��
            $this->down_str = $down_str;
        if ($this->dispaly_nav) {//�W�߿��
            $res_str = "\n<SCRIPT>\n function " . $this->formname . "_update(s_value) {\n document." . $this->formname . "." . $this->key_item . ".value=s_value;\n document." . $this->formname . ".submit();\n}\n</SCRIPT>\n";
            if ($this->disabled) //�ܬ����i�ާ@�_
                $res_str .= "<form name=\"" . $this->formname . "\" method=post action=\"" . $this->action_script . "\" disabled>\n";
            else
                $res_str .= "<form name=\"" . $this->formname . "\" method=post action=\"" . $this->action_script . "\">\n";
        }
        $res_str .= "<table width=\"1\" cellspacing=0 cellpadding=0>\n";
        if ($this->up_str)
            $res_str .= "<tr ><td align=center " . $this->class_ccs . ">" . $this->up_str . "</td></tr>";
        $res_str .= "<tr><td " . $this->class_ccs . ">";
        $res_str .= "<img src=\"" . $SFS_PATH_HTML . "images/pixel_clear.gif\" width=\"" . $this->width . "\" height=1>";
        $res_str .= "</td></tr>\n";

        if ($this->count_row == 0 && $this->dispaly_nav)
            $res_str .= "</tr><td align=center " . $this->class_ccs . ">" . $this->nodata_name . "</td></tr>\n";
        else {
            $res_str .= "<tr " . $this->class_ccs . "><td align=center " . $this->class_ccs . ">\n";
            if ($this->dispaly_nav) //�W�߿��
                $res_str .= "<select style=\"background-color:" . $this->bgcolor . ";font-size: " . $this->fontsize . "\" onchange=\"document." . $this->formname . ".submit()\" size=\"" . $this->row . "\" name=\"" . $this->key_item . "\">\n";
            else
                $res_str .= "<select style=\"background-color:" . $this->bgcolor . ";font-size: " . $this->fontsize . "\"  size=\"" . $this->row . "\" name=\"" . $this->key_item . "\">\n";
            $ii = 1;
            if ($this->top_option)
                $res_str .= "<option value=\"\">" . $this->top_option . "</option>\n";
            while (list($tid, $tname) = each($this->select_item)) {
                if ($this->color_index_item)
                    $temp_color = " STYLE=\"color: " . $this->display_color[$this->color_item[$tid]] . "\" \n";
                if ($tid == $key) {
                    $res_str .= "<option $temp_color value=\"$tid\" selected >$tname</option>\n";
                    $nav_prior = $temp_id;
                    $flag = 1;
                    $this_row = $ii;
                } else
                    $res_str .= "<option $temp_color value=\"$tid\">$tname</option>\n";
                $temp_id = $tid;
                if ($flag > 0) {
                    if ($flag == 2) {
                        $nav_next = $temp_id;
                        $flag = 0;
                    } else
                        $flag++;
                }
                $ii++;
            }
            $ii--;
            $res_str .= "</select>\n";
            $res_str .= "</td>\n";
            $res_str .= "</tr>\n";
            if ($this->dispaly_nav) {
                $res_str .= "<tr >\n";
                $res_str .= "<td align=center " . $this->class_ccs . ">���ơG $this_row / $ii</td>\n";
                $res_str .= "</tr>\n";
                //�έp���P�ﶵ
                if ($this->color_index_item && $this->show_item_tol) {
                    $color_tol = @array_count_values(array_values($this->color_item));
                    $res_str .= "<tr><td align=center " . $this->class_ccs . " >�p�G";
                    reset($color_tol);
                    while (list($tid, $tname) = each($color_tol))
                        $res_str .= "<font color=" . $this->display_color[$tid] . ">��$tname</font>&nbsp;";
                    $res_str .= "</td></tr>\n";
                }
                $res_str .= "<tr><td align=center>";
                if (strlen($nav_prior) > 0)
                    $res_str .= "&nbsp;<input type=button value=\"  ^  \" onclick=\"" . $this->formname . "_update('$nav_prior')\" >";
                else
                    $res_str .= "&nbsp;<input type=button value=\"  ^  \" disabled >";
                if ($nav_next <> "")
                    $res_str .= "&nbsp;<input type=button value=\"  v  \" onclick=\"" . $this->formname . "_update('$nav_next')\" >";
                else
                    $res_str .= "&nbsp;<input type=button value=\"  v  \" disabled >";
                $res_str .= "</td></tr>\n";
            }
        }
        if ($this->down_str != "")
            $res_str .= "<tr><td align=center>" . $this->down_str . "</td></tr>";
        $res_str .= "<input type=hidden name=nav_prior value=\"$nav_prior\">\n";
        $res_str .= "<input type=hidden name=nav_next value=\"$nav_next\">\n";
        $res_str .= "</table>";
        if ($this->dispaly_nav)//�W�߿��
            $res_str .= "</form>\n";

        return $res_str;
    }

    function get_color_item($i) {
        $cc = $i % (count($this->default_color_item));
        return $this->default_color_item[$cc];
    }

}

//���o����T
function get_field_info($tablename) {
    global $CONN;

    if (!$tablename)
        user_error("�S���ǤJtablename�I���ˬd�I", 256);

    // �T�w�s�u����
    if (!$CONN)
        user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I", 256);

    $query = "select d_table_name ,d_field_name ,d_field_cname ,d_field_type ,d_field_order ,d_is_display from sys_data_field WHERE d_table_name = '$tablename' order by d_field_name ";
    $dataSet = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$query", 256);

    // init $data

    $data = array();

    //echo $query;
    while (!$dataSet->EOF) {
        $data[$dataSet->fields[d_field_name]][d_field_name] = $dataSet->fields[d_field_name];
        $data[$dataSet->fields[d_field_name]][d_field_type] = $dataSet->fields[d_field_type];
        $data[$dataSet->fields[d_field_name]][d_field_cname] = $dataSet->fields[d_field_cname];

        $data[$dataSet->fields[d_field_name]][d_field_order] = $dataSet->fields[d_field_order];
        $data[$dataSet->fields[d_field_name]][d_is_display] = $dataSet->fields[d_is_display];
        $dataSet->MoveNext();
    }

    return $data;
}

//end -- function get_field_info 

class checkbox_class {

    var $arr; //�ﶵ�Ȱ}�C
    var $id = ''; //�w��ܰ}�C( �H','�j�} )
    var $s_name = "check"; // ��J����W��
    var $cols = 4; //�C�C�Ӽ�
    var $css = '';
    var $is_color = false;
    var $color = "yellow";

    function do_select() {
        if ($this->css <> '')
            $this->css = " class=" . $this->css;
        $arr = explode(",", $this->id);

        echo "<table border=0 cellpadding=0 cellspacing=0 width=100% " . $this->css . ">\n";
        echo "<tr>";
        while (list($tid, $tname) = each($this->arr)) {
            if (in_array($tid, $arr)) {
                if ($this->is_color)
                    echo "<td bgcolor=\"" . $this->color . "\"><input type=\"checkbox\" name=\"" . $this->s_name . "[]\" value=\"$tid\" checked > $tname </td>";
                else
                    echo "<td><input type=\"checkbox\" name=\"" . $this->s_name . "[]\" value=\"$tid\" checked > $tname </td>";
            } else
                echo "<td><input type=\"checkbox\" name=\"" . $this->s_name . "[]\" value=\"$tid\"  > $tname </td>";
            if (($i++ % $this->cols) == $this->cols - 1)
                echo "</tr><tr>";
        }
        echo "</tr></table>";
    }

    function show_select() {
        $arr = explode(",", $this->id);
        $temp = '';
        while (list($tid, $tname) = each($this->arr)) {
            if (in_array($tid, $arr))
                $temp .= " $tname �B";
        }
        echo substr($temp, 0, -2);
    }

}

function change_addr_str($addr) {
    global $addr;
    //����	
    $temp_str = split_addr_str("��", 1);
    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);
    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);
    $res[] = $temp_str;

    //�m��	
    $temp_str = split_addr_str("�m", 1);
    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);

    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);

    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);

    $res[] = $temp_str;

    //����	
    $temp_str = split_addr_str("��", 1);
    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);

    $res[] = $temp_str;

    //�F
    $res[] = split_addr_str("�F", 1);

    //��
    $temp_str = split_addr_str("��", 1);
    if ($temp_str == "")
        $temp_str = split_addr_str("��", 1);

    $res[] = $temp_str;

    //�q
    $res[] = split_addr_str("�q", 1);

    //��
    $res[] = split_addr_str("��", 1);

    //��
    $res[] = split_addr_str("��", 1);

    //��
    $temp_str = split_addr_str("��");

    $temp_arr = explode("-", $temp_str);
    if (count($temp_arr) > 1) {
        $res[] = $temp_arr[0] . "��";
        $res[] = "��" . $temp_arr[1];
    } else {
        $res[] = $temp_arr[0] . "��";
        $res[] = "";
    }

    //��
    $res[] = split_addr_str("��", 1);

    //�Ӥ�
    if ($addr != "")
        $temp_str = "��" . substr(chop($addr), 2);
    else
        $temp_str = "";

    $res[] = $temp_str;

    return $res;
}

function split_addr_str($str, $last = 0) {
    global $addr;
    $temp = explode($str, $addr);
    if (count($temp) == 1)
        return "";
    else if ($last == 1) {
        $addr = substr($addr, strlen($temp[0]) + strlen($str));
        return trim($temp[0]) . $str;
    } else if ($last == 2) {
        $addr = substr($addr, strlen($temp[0]) + strlen($str));
        return $str . trim($temp[0]);
    } else {
        $addr = substr($addr, strlen($temp[0]) + strlen($str));
        return trim($temp[0]);
    }
}

?>
