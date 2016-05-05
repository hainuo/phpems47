<?php

class html
{
	public $G;

    public function __construct(&$G)
    {
    	$this->G = $G;
    }

    public function buildHtml($fields,$values = NULL)
    {
    	if(!is_array($fields))return false;
    	$forms = array();
    	foreach($fields as $field)
    	{
	    	$tmp = array();
	    	if($field['fieldhtmltype'] != 'auto')
	    	{
		    	if($field['fieldvalues'])$field['fieldvalues'] = $this->_buildValues($field['fieldvalues']);
		    	if($field['fieldhtmlproperty'])$field['fieldhtmlproperty'] = $this->_buildValues($field['fieldhtmlproperty']);
		    	$field['fieldhtmltype'] = strtolower($field['fieldhtmltype']);
		    	if(is_array($values))$field['fieldhtmlproperty'][] = array('key' => 'value', 'value' => $values[$field['field']]);
		    	elseif($field['fielddefault'])$field['fieldhtmlproperty'][] = array('key' => 'value', 'value' => $field['fielddefault']);
		    	$field['fieldhtmlproperty'][] = array('key' => 'name', 'value' => 'args['.$field['field'].']');
		    	$field['fieldhtmlproperty'][] = array('key' => 'id', 'value' => $field['field']);
	    	}
	    	$tmp['title'] = $field['fieldtitle'];
	    	$tmp['id'] = $field['field'];
	    	$tmp['type'] = $field['fieldhtmltype'];
	    	$tmp['describe'] = $field['fielddescribe'];
    		if(is_array($values))
    		$tmp['html'] = $this->$field['fieldhtmltype'](array('pars'=>$field['fieldhtmlproperty'],'values'=>$field['fieldvalues'],'default'=>$values[$field['field']]));
    		else
    		$tmp['html'] = $this->$field['fieldhtmltype'](array('pars'=>$field['fieldhtmlproperty'],'values'=>$field['fieldvalues'],'default'=>$field['fielddefault']));
    		$forms[] = $tmp;
    	}
    	return $forms;
    }

    private function _buildValues($values = false)
    {
    	if(!$values)return false;
    	$v = array();
    	$tmp = explode("\n",$values);
    	foreach($tmp as $value)
    	{
			$t = explode('=',$value,2);
			$v[] = array('key'=>$t[0],'value'=>trim($t[1]));
    	}
    	return $v;
    }

    public function auto($args)
    {
    	return html_entity_decode($args['pars']);
    }

    public function text($args)
    {
    	$str = "<input type=\"text\" ";
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
    	}
    	$str .= "/>";
    	return $str;
    }

    public function htmltime($args)
    {
    	if(!$args['default'])$args['pars'][] = array('key'=>'value' ,'value'=>date("Y-m-d H:i:s"));
    	else
    	foreach($args['pars'] as $id => $p)
    	{
			if($p['key'] == 'value')
			{
				$args['pars'][$id] = array('key'=>'value' ,'value'=>date("Y-m-d H:i:s",$args['default']));
				break;
			}
    	}
    	return $this->text($args);
    }

    public function htmldate($args)
    {
    	$pram = 0;
    	if(!$args['default'])$args['pars'][] = array('key'=>'value' ,'value'=>date("Y-m-d"));
    	else
    	foreach($args['pars'] as $id => $p)
    	{
			if($p['key'] == 'value')
			{
				$args['pars'][$id] = array('key'=>'value' ,'value'=>date("Y-m-d",$args['default']));
			}
			if($p['key'] == 'class')
			{
				$args['pars'][$id]['value'] = $args['pars'][$id]['value'].' datepicker';
				$pram = 1;
				$args['pars'][$id]['value'] = str_replace('datepicker ','',$args['pars'][$id]['value']);
			}
    	}
    	if(!$pram)$args['pars'][] = array('key'=>'class' ,'value'=>'datepicker');
    	return $this->text($args);
    }

    public function password($args)
    {
    	$str = "<input type=\"password\" ";
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $key => $p)
	    	{
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
    	}
    	$str .= "/>";
    	return $str;
    }

    public function textarea($args)
    {
    	$str = "<textarea ";
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] != 'value')
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
    	}
    	$str .= ">";
    	$str .= $args['pars']['value'];
    	$str .= "</textarea>";
    	return $str;
    }

    public function _radio($pars,$value,$default,$index)
    {
    	//$str = "<label><input type=\"radio\" ";
    	$str = "<input type=\"radio\" ";
    	if(is_array($pars))
    	{
	    	foreach($pars as $key => $p)
	    	{
	    		if($p['key'] != 'value')
	    		{
	    			if($p['key'] == 'id')
	    			$str .= "{$p['key']}=\"{$p['value']}{$index}\" ";
	    			else
	    			$str .= "{$p['key']}=\"{$p['value']}\" ";
	    		}
	    	}
    	}
    	if($value['value'] == $default)
    	//$str .= "value=\"{$value['value']}\" checked/> {$value['key']}</label>&nbsp;&nbsp;";
    	$str .= "value=\"{$value['value']}\" checked/> {$value['key']}&nbsp;&nbsp;";
    	else
    	//$str .= "value=\"{$value['value']}\" /> {$value['key']}</label>&nbsp;&nbsp;";
    	$str .= "value=\"{$value['value']}\" /> {$value['key']}&nbsp;&nbsp;";
    	return $str;
    }

    public function radio($args)
    {
    	$str = "";
    	unset($args['pars']['value']);
    	foreach($args['values'] as $key => $p)
    	{
    		$str .= $this->_radio($args['pars'],$p,$args['default'],$key);
    	}
    	return $str;
    }

    public function thumbtext($args)
    {
    	$str = "<input type=\"text\" ";
    	$id = NULL;
    	$classinfo = false;
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] == 'id')
				$id = $p['value'];
	    		if($p['key'] == "class")
	    		{
	    			$str .= "{$p['key']}=\"inline uploadimg\" ";
	    			$classinfo = true;
	    		}
	    		else
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
	    	if(!$classinfo)
	    	{
	    		$str .= 'class="inline uploadimg" ';
	    	}
	    	if(!$id)
	    	{
	    		$id = 'up'.md5($str);
	    		$str .= 'id="'.$id.'" ';
	    	}
    	}
    	$str .= "thumb=\"true\"/>\n<span class=\"button\"><a id=\"{$id}_button\"></a></span>\n<a class=\"viewsup button\" href=\"javascript:;\" onclick=\"javascript:if($('#{$id}').val() && $('#{$id}').val() != '')$.zoombox.open($('#{$id}').val());\">查看图片</a>\n<span id=\"{$id}_msg\">&nbsp;</span>";
    	return $str;
    }

    public function thumb($args)
    {
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] == 'id')
				$id = $p['value'];
	    		if($p['key'] == "name")
	    		$name = $p['value'];
	    		if($p['key'] == "value")
	    		$value = $p['value'];
	    	}
	    	if(!$id)
	    	$id = 'form'.$name;
	    	if(!$value)$value = 'app/core/styles/images/noimage.gif';
    	}
    	$str = "<div class=\"thumbuper pull-left\"><div class=\"thumbnail\"><a href=\"javascript:;\" class=\"second label\"><em class=\"uploadbutton\" id=\"{$id}\" exectype=\"thumb\"></em></a><a href=\"javascript:;\" onclick=\"javascript:$('#{$id}_view').attr('src','app/core/styles/images/noimage.gif');$('#{$id}_value').val('');\" class=\"second2 label\" title=\"重置\"><em class=\"icon-remove\"></em></a><div class=\"first\" id=\"{$id}_percent\"></div><div class=\"boot\"><img src=\"{$value}\" id=\"{$id}_view\"/><input type=\"hidden\" name=\"{$name}\" value=\"{$value}\" id=\"{$id}_value\"/></div></div></div>";
    	return $str;
    }

    public function picture($args)
    {
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] == 'id')
				$id = $p['value'];
	    		if($p['key'] == "name")
	    		$name = $p['value'].'[]';
	    		if($p['key'] == "value")
	    		$values = $p['value'];
	    	}
	    	if(!$id)
	    	$id = 'form'.$name.'[]';
	    	//$values = explode(',',$values);
	    	$values = unserialize($values);
    	}
    	$str = "<div class=\"thumbuper pull-left\"><div class=\"thumbnail\"><a href=\"javascript:;\" class=\"second label\"\"><em class=\"uploadbutton\" id=\"{$id}\" exectype=\"rows\"></em></a><div class=\"first\" id=\"{$id}_percent\"></div><div class=\"boot\"><img src=\"app/core/styles/images/noimage.gif\" id=\"{$id}_view\"/></div></div></div>";
    	$str .= "<div class=\"sortable\" id=\"{$id}_range\">";
    	if(is_array($values))
    	{
	    	foreach($values as $value)
	    	{
	    		if($value)
	    		$str .= "<div class=\"thumbuper pull-left\"><div class=\"thumbnail\"><a href=\"javascript:;\" onclick=\"javascript:$.removeUploadedImage(this);\" class=\"second label\"><em class=\"icon-remove\"></em></a><div class=\"boot\"><img src=\"{$value}\"><input name=\"{$name}\" value=\"{$value}\" type=\"hidden\"></div></div></div>";
	    	}
    	}
    	return $str.'</div>';
    }

    public function videotext($args)
    {
    	$str = "<input type=\"text\" ";
    	$id = NULL;
    	$classinfo = false;
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] == 'id')
				$id = $p['value'];
	    		if($p['key'] == "class")
	    		{
	    			$str .= "{$p['key']}=\"inline uploadvideo\" ";
	    			$classinfo = true;
	    		}
	    		else
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
	    	if(!$classinfo)
	    	{
	    		$str .= 'class="inline uploadvideo" ';
	    	}
	    	if(!$id)
	    	{
	    		$id = 'up'.md5($str);
	    		$str .= 'id="'.$id.'" ';
	    	}
    	}
    	$str .= "thumb=\"true\"/>\n<span class=\"button\"><a id=\"{$id}_button\"></a></span>\n<span id=\"{$id}_msg\">&nbsp;</span>";
    	return $str;
    }

    public function editor($args = NULL)
    {
    	$str = "<textarea ";
    	if(is_array($args['pars']))
    	{
	    	$par = 0;
	    	foreach($args['pars'] as $p)
	    	{
	    		if($p['key'] != 'value')
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    		else $value = $p['value'];
	    		if($p['key'] == 'class')
	    		{
	    			$par = 1;
	    			if($p['value'] == 'ckeditor')
	    			$str .= "{$p['key']}=\"{$p['value']}\" ";
	    			else
	    			$str .= "{$p['key']}=\"{$p['value']} ckeditor\" ";
	    		}
	    	}
    	}
    	if(!$par)$str .= " class=\"ckeditor\" ";
    	$str .= ">".$value."</textarea>";
    	return $str;
    }

    public function files($args)
    {
		$str = "<input type=\"file\" ";
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $key => $p)
	    	{
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
    	}
    	$str .= "/>";
    	return $str;
    }

    public function checkBox($args)
    {
    	if($args['default'] != NULL)
    	$args['default'] = explode(',',$args['default']);
    	return $this->_checkBox($args);
    }

    public function _checkBox($args,$isArray = false)
    {
    	$str = "<label class=\"checkbox inline\"><input type=\"checkbox\" ";
    	$v = '';
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $key => $p)
	    	{
	    		if($p['key'] == 'name' && $isArray)$p['value'] .= '[]';
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    		if($p['key'] == 'value')$v = $p['value'];
	    	}
    	}
    	if($args['default'] != NULL && in_array($v,$args['default']))
    	$str .= "checked";
    	$str .= "/>".$args['values']['key'].'</label>';
    	return $str;
    }

    public function checkBoxArray($args)
    {
		foreach($args['pars'] as $id => $p)
		{
			if($p['key'] == 'value')
			{
				unset($args['pars'][$id]);
				break;
			}
		}
    	$str = '';
    	if($args['default'] != NULL)
    	$args['default'] = unserialize($args['default']);
    	foreach($args['values'] as $p)
    	{
			$tmp = $args;
    		unset($tmp['values']);
    		$tmp['pars'][] = array('key'=>'value','value' => $p['value']);
    		$tmp['values'] = $p;
    		$str .= $this->_checkBox($tmp,true);
    	}
    	return $str;
    }

    public function select($args)
    {
    	unset($args['pars']['value']);
    	$str = "<select ";
    	if(is_array($args['pars']))
    	{
	    	foreach($args['pars'] as $key => $p)
	    	{
	    		$str .= "{$p['key']}=\"{$p['value']}\" ";
	    	}
    	}
    	$str .= ">";
    	if(is_array($args['values']))
    	{
	    	foreach($args['values'] as $p)
	    	{
	    		if($p['value'] == $args['default'])
	    		$str .= "<option value='{$p['value']}' selected>{$p['key']}</option>\n";
	    		else
	    		$str .= "<option value='{$p['value']}'>{$p['key']}</option>\n";
	    	}
    	}
    	$str .= "</select>";
    	return $str;
    }
}
?>