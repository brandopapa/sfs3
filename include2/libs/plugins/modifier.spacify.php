<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
//$Id: modifier.spacify.php 6117 2010-09-10 15:13:53Z brucelyc $
/**
 * Smarty spacify modifier plugin
 *
 * Type:     modifier<br>
 * Name:     spacify<br>
 * Purpose:  add spaces between characters in a string
 * @link http://smarty.php.net/manual/en/language.modifier.spacify.php
 *          spacify (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_spacify($string, $spacify_char = ' ')
{
    return implode($spacify_char,
                   preg_split('//', $string, -1, PREG_SPLIT_NO_EMPTY));
}

/* vim: set expandtab: */

?>
