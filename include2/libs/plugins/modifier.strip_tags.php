<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
//$Id: modifier.strip_tags.php 6117 2010-09-10 15:13:53Z brucelyc $
/**
 * Smarty strip_tags modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip_tags<br>
 * Purpose:  strip html tags from text
 * @link http://smarty.php.net/manual/en/language.modifier.strip.tags.php
 *          strip_tags (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param boolean
 * @return string
 */
function smarty_modifier_strip_tags($string, $replace_with_space = true)
{
    if ($replace_with_space)
        return preg_replace('!<[^>]*?>!', ' ', $string);
    else
        return strip_tags($string);
}

/* vim: set expandtab: */

?>
