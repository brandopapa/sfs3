<?php
// $Id: bookcode.php 8582 2015-11-04 07:26:54Z hsiao $

include "book_config.php";
// ���ݭn register_globals
if (!ini_get('register_globals')) {
    ini_set("magic_quotes_runtime", 0);
    extract($_POST);
    extract($_GET);
    extract($_SERVER);
}


if ($key == "���͹Ϯѱ��X") {
    $len = strlen($b_num);
    $temp = 1;
    for ($i = 1; $i <= $len; $i++)
        $temp = $temp * 10;
    settype($b_num, double);
    echo "<html><body><table border=0 cellPadding=2 cellSpacing=5 ><tr>";
    for ($i = 0; $i < $code_num; $i++) {
        //$core = substr($bookch1_id,0,3).".".substr(($temp+$b_num),1,$len);
        $core = substr(($temp + $b_num), 1, $len);
        $topname = $lib_name . "---" . substr($bookch1_id, 3, strlen($bookch1_id) - 3);
        echo "<td align=center nowrap><font size=2>$topname<BR>";
        barcode($core);
        echo "<br>$core</font></td>\n";
        if ($i % $barcore_cols == $barcore_cols - 1)
            echo"</tr><tr>";
        $b_num++;
    }
    echo "</tr></table>";
    echo "</body></html>";
    exit;
}

if ($stukey == "���ͭɮѱ��X") {
    echo "<html><body><table border=0 cellPadding=2 cellSpacing=5 ><tr>";
    for ($i = 0; $i < 10; $i++) {
        $s_no = "s_no_" . ($i + 1);
        if ($$s_no != "") {
            $query = "select stud_id,stud_name from stud_base where stud_id = '" . $$s_no . "'";
            $result = mysql_query($query, $conID);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
                //echo sprintf ("<img src=\"%s?code=%s&text=%s\">",$code_url,$row["stud_id"],$school_sshort_name."--".$row["stud_name"]);
                $core = $row["stud_id"];
                $topname = $school_sshort_name . "--" . $row["stud_name"];
                echo "<td align=center nowrap><font size=2>$topname<BR>";
                barcode($core);
                echo "<br>$core</font></td>\n";
            }
        }
        if ($i % $barcore_cols == $barcore_cols - 1)
            echo"</tr><tr>";
    }
    echo "</tr></table>";
    echo "</body></html>";
    exit;
}
if ($teakey == "���ͭɮѱ��X") {
    echo "<html><body><table border=0 cellPadding=2 cellSpacing=5 ><tr>";
    for ($i = 0; $i < 10; $i++) {
        $s_no = "s_no_" . ($i + 1);
        if ($$s_no != "") {
            $query = "select teach_id,name from teacher_base where teach_id = '" . $$s_no . "'";
            $result = mysql_query($query, $conID);
            if (mysql_num_rows($result) > 0) {
                $row = mysql_fetch_array($result);
//				echo sprintf ("<img src=\"%s?code=%s&text=%s\">",$code_url,$row["teach_id"],$school_sshort_name."--".$row["name"] );
                $core = $row["teach_id"];
                $topname = $school_sshort_name . "--" . $row["name"];
                echo "<td align=center nowrap><font size=2>$topname<BR>";
                barcode($core);
                echo "<br>$core</font></td>\n";
            }
        }
        if ($i % $barcore_cols == $barcore_cols - 1)
            echo"</tr><tr>";
    }
    echo "</tr></table>";
    echo "</body></html>";
    exit;
}
include "header.php";
$code_p = "$PHP_SELF";
$query = "select * from bookch1  order by bookch1_id";
$result = mysql_query($query, $conID);
//�������ﶵ
$i = 0;
$tt = "";
while ($row = mysql_fetch_array($result)) {
    if ($i > 0) {
        $tt .= sprintf(" <option value=\"%s\" >%s%s</option>", $row["bookch1_id"] . $row["bookch1_name"], $row["bookch1_id"], $row["bookch1_name"]);
    } else {
        $tt .= sprintf(" <option value=\"%s\" selected>%s%s</option>", $row["bookch1_id"] . $row["bookch1_name"], $row["bookch1_id"], $row["bookch1_name"]);
    }
    $i++;
}
?>
<script language="JavaScript">
<!-- Hide
    function checknum(checktext)
    {
        if (parseInt(checktext.value) == -1)
        {
            checktext.value = "";
            return;
        }
        if (checktext.value == "NaN") {
            checktext.value = ""
            return;
        }
    }
    function checkok()
    {
        var OK = true
        if (document.spost.b_num.value == "")
        {
            OK = false;
        }
        if (OK == false) {
            alert("�_�l�����i�ťաI�ЦA�Զ�I")
        }
        return OK
    }

    function checkok2()
    {
        var OK = true
        if (document.spost2.s_no.value == "")
        {
            OK = false;
        }
        if (OK == false) {
            alert("�Ǹ����i�ťաI�ЦA�Զ�I")
        }
        return OK
    }


    function checkok3()
    {
        var OK = true
        if (document.spost3.s_no.value == "")
        {
            OK = false;
        }
        if (OK == false) {
            alert("�Юv�N�����i�ťաI�ЦA�Զ�I")
        }
        return OK
    }
//-->
</script>

<form method="post" name="spost" action="<?php echo $code_p ?>"  onSubmit="return checkok()">
    <table border=1 width=90% align=center bgcolor=#ffaa00>
        <caption><font size=+2>�Ϯѱ��X�C�L</font></caption>
        <tr><td bgcolor="#8080FF" width=20% align=center><strong>������</strong></td>
            <td bgcolor="#8080FF" width=35% align=center><strong>�C�L�_�l��</strong></td>
            <td bgcolor="#8080FF" width=35% align=center><strong>�C�L���X��</strong></td>
        </tr><td>
            <select name="bookch1_id" size="1" >  
                <?php echo $tt ?> 
            </select></td>�@�@
        <td align=center><input type=text name="b_num" size=20 onBlur="checknum(this)"></td>
        <td align=center>
            <select name="code_num" size="5" >
                <option value=1 selected> 1��</option>
                <?php
                for ($i = 2; $i <= 40; $i++)
                    echo sprintf("<option value=%d >%2d��</option>", $i, $i);
                ?>
            </select></td>
        </tr>
        <tr><td  colspan="3" align=center><input type=submit name=key value="���͹Ϯѱ��X"></td></tr>
    </table>
</form>
<hr>
<form method="post" name="spost2" action="<?php echo $code_p ?>" >
    <table border=1 width=90% align=center bgcolor=#aaff00>
        <caption><font size=+2>�ǥͭɮ��ұ��X�C�L</font></caption>
        <td bgcolor="#8080FF" width=45% align=center><strong>��J�Ǹ�</strong></td>
        </tr>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<tr><td align=center>$i .<input type=text name=\"s_no_$i\" size=20 ></td></tr>";
        }
        ?>
        <tr><td  colspan="3" align=center><input type=submit name=stukey value="���ͭɮѱ��X"></td></tr>
    </table>
</form>
<hr>
<form method="post" name="spost3" action="<?php echo $code_p ?>"  >
    <table border=1 width=90% align=center bgcolor=#aaff00>
        <caption><font size=+2>�Юv�ɮ��ұ��X�C�L</font></caption>
        <tr>
            <td bgcolor="#8080FF" width=45% align=center><strong>��J�Юv�N��</strong></td>
        </tr>
        <?php
        for ($i = 1; $i <= 10; $i++) {
            echo "<tr><td align=center>$i .<input type=text name=\"s_no_$i\" size=20 ></td></tr>";
        }
        ?>
        <tr><td  colspan="3" align=center><input type=submit name=teakey value="���ͭɮѱ��X"></td></tr>
    </table>
</form>
</center>
<?php
include "footer.php";
?>
