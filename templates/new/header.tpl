{{php}}
//$Id: header.tpl 5959 2010-06-14 23:40:50Z hami $
// �B�~�� javascript �[�J
global $injectJavascript;
$injectJavascript = ($this->_smarty_vars['capture']['injectJavascript'])?$this->_smarty_vars['capture']['injectJavascript']: '';
//���Y
head($this->get_template_vars("module_name"));
{{/php}}