<?php

//�M���B�zunicode to utf8�禡
//from http://www.ps3w.net/modules/psbb/?op=openthr&lead=1101

function utf8conv2charset($utf8str, $charset = 'BIG5') {
    mb_regex_encoding($charset); // �ŧi �n�i�� regex ���h�줸�s�X�ഫ�榡 �� $charset
    mb_substitute_character('long'); // �ŧi �ʽX�r��HU+16�i��X���аO���N
    $utf8str = mb_convert_encoding($utf8str, $charset, 'UTF-8');
    $utf8str = preg_replace('/U\+([0-9A-F]{4})/e', '"&#".intval("\\1",16).";"', $utf8str); // �NU+16�i��X�аO�ഫ��UnicodeHTML�X
    return $utf8str;
}

function unicod2utf8byChrCode($chrCode) {
    if (!is_integer($chrCode))
        return $chrCode;
    elseif ($chrCode < 0x80) { // ��@�r�� [0xxxxxxx]
        return chr($chrCode);
    } elseif ($chrCode >= 0x80 && $chrCode <= 0x07ff) {        // ���r�� [110xxxxx][10xxxxxx]
        $bin = sprintf('%011s', decbin($chrCode));
        $chrs = chr(intVal('110' . substr($bin, 0, 5), 2));
        $chrs.= chr(intVal('10' . substr($bin, 5), 2));
    } elseif ($chrCode >= 0x800 && $chrCode <= 0xFFFF) {        // �T�r�� [1110xxxx][10xxxxxx][10xxxxxx]
        $bin = sprintf('%016s', decbin($chrCode));
        $chrs = chr(intVal('1110' . substr($bin, 0, 4), 2));
        $chrs.= chr(intVal('10' . substr($bin, 4, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 10), 2));
    } elseif ($chrCode >= 0x10000 && $chrCode <= 0x1FFFFF) {     // �|�r�� [11110xxx][10xxxxxx][10xxxxxx][10xxxxxx]
        $bin = sprintf('%021s', decbin($chrCode));
        $chrs = chr(intVal('11110' . substr($bin, 0, 3), 2));
        $chrs.= chr(intVal('10' . substr($bin, 3, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 9, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 15), 2));
    } elseif ($chrCode >= 0x200000 && $chrCode <= 0x3FFFFFF) {    // ���r�� [111110xx][10xxxxxx][10xxxxxx][10xxxxxx][10xxxxxx]
        $bin = sprintf('%026s', decbin($chrCode));
        $chrs = chr(intVal('111110' . substr($bin, 0, 2), 2));
        $chrs.= chr(intVal('10' . substr($bin, 2, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 8, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 14, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 20), 2));
    } elseif ($chrCode >= 0x4000000 && $chrCode <= 0x7FFFFFFF) {    // ���r�� [1111110x][10xxxxxx][10xxxxxx][10xxxxxx][10xxxxxx][10xxxxxx]
        $bin = sprintf('%031s', decbin($chrCode));
        $chrs = chr(intVal('1111110' . substr($bin, 0, 1), 2));
        $chrs.= chr(intVal('10' . substr($bin, 1, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 7, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 13, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 19, 6), 2));
        $chrs.= chr(intVal('10' . substr($bin, 25), 2));
    } else { // ���~�B�z
        return "{[U?$chrCode]}";
    }
    return $chrs;
}

function unicodeHTMLconv2utf8($utf8strWithUnicodeHTMLstr, $suffix_semicolon_included = false) {
    $qms = $suffix_semicolon_included ? '' : '?';
    $pat[] = '/&#([0-9]+);' . $qms . '/e';
    $rep[] = "unicod2utf8byChrCode(\\1)";   // &#(10�i��);
    $pat[] = '/&#(x[0-9A-Fa-f]+);/e';
    $rep[] = "unicod2utf8byChrCode(0\\1)";  // &#x(16�i��);
    return preg_replace($pat, $rep, $utf8strWithUnicodeHTMLstr);
}

?>
