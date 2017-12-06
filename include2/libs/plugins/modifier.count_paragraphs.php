<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
//$Id: modifier.count_paragraphs.php 6117 2010-09-10 15:13:53Z brucelyc $
/**
 * Smarty count_paragraphs modifier plugin
 *
 * Type:     modifier<br>
 * Name:     count_paragraphs<br>
 * Purpose:  count the number of paragraphs in a text
 * @link http://smarty.php.net/manual/en/language.modifier.count.paragraphs.php
 *          count_paragraphs (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return integer
 */
function smarty_modifier_count_paragraphs($string)
{
    // count \r or \n characters
    return count(preg_split('/[\r\n]+/', $string));
}

/* vim: set expandtab: */

?>
