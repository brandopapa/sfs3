<?php
// $Id: bookcode_new.php 8732 2016-01-05 07:01:17Z hsiao $

include "book_config.php";
// ���ݭn register_globals
if (!ini_get('register_globals')) {
    ini_set("magic_quotes_runtime", 0);
    extract($_POST);
    extract($_GET);
    extract($_SERVER);
}


if ($key == "���͹Ϯѱ��X(�L������)") {
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
        <tr><td  colspan="3" align=center><input type=submit name=key value="���͹Ϯѱ��X(�L������)"></td></tr>
    </table>
</form>
</center>
<?php
include "footer.php";
?>
