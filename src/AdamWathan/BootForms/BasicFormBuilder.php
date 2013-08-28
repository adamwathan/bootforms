<?php namespace AdamWathan\BootForms;

use Illuminate\Html\FormBuilder;

class BasicFormBuilder extends FormBuilder {

	public function textGroup($label, $name, $value = null, $groupOptions = array(), $textOptions = array(), $labelOptions = array())
	{
		$input = $this->text($name, $value, $textOptions);

		return $this->inputGroup($input, $label, $name, $groupOptions, $labelOptions);
	}


	public function emailGroup($label, $name, $value = null, $groupOptions = array(), $emailOptions = array(), $labelOptions = array())
	{
		$input = $this->email($name, $value, $emailOptions);

		return $this->inputGroup($input, $label, $name, $groupOptions, $labelOptions);
	}


	public function passwordGroup($label, $name, $groupOptions = array(), $passwordOptions = array(), $labelOptions = array())
	{
		$input = $this->password($name, $passwordOptions);

		return $this->inputGroup($input, $label, $name, $groupOptions, $labelOptions);
	}

	public function textareaGroup($label, $name, $value = null, $rows = 5, $groupOptions = array(), $textareaOptions = array(), $labelOptions = array())
	{
		$input = $this->textarea($name, $value, $rows, $textareaOptions);

		return $this->inputGroup($input, $label, $name, $groupOptions, $labelOptions);
	}

	protected function inputGroup($input, $label, $name, $groupOptions = array(), $labelOptions = array())
	{
		$groupOptions = $this->addClass('form-group', $groupOptions);

		$groupOptions = $this->addValidationState($name, $groupOptions);
		
		$html = '<div' . $this->html->attributes($groupOptions) . '>';
		$html .= $this->label($name, $label, $labelOptions);
		$html .= $input;

		if ($this->hasError($name)) {
			$html .= '<p class="help-block">' . $this->getError($name) . '</p>';
		}

		$html .= '</div>';

		return $html;
	}


	protected function addValidationState($name, $options)
	{
		if (! $this->hasErrors()) {
			return $options;
		}

		if ($this->hasError($name)) {
			$options = $this->addClass('has-error', $options);
		}

		return $options;
	}

	protected function hasErrors()
	{
		return $this->session->has('errors');
	}

	protected function hasError($key)
	{
		if ( ! $this->hasErrors()) {
			return false;
		}

		$errors = $this->session->get('errors');

		return $errors->has($key);
	}

	protected function getError($key)
	{
		if ( ! $this->hasError($key)) {
			return null;
		}

		$errors = $this->session->get('errors');

		return $errors->first($key);		
	}


	public function checkboxGroup($label, $name, $value = 1, $checked = null, $groupOptions = array(), $checkboxOptions = array(), $labelOptions = array())
	{
		$groupOptions = $this->addClass('checkbox', $groupOptions);

		return '<div' . $this->html->attributes($groupOptions) . '><label>' . $this->checkbox($name, $value, $checked, $checkboxOptions) . $label .'</label></div>';
	}


	public function label($name, $value = null, $options = array())
	{
		$options = $this->addClass('control-label', $options);

		return parent::label($name, $value, $options);
	}

	
	public function text($name, $value = null, $options = array())
	{
		$options = $this->addClass('form-control', $options);
		
		return parent::text($name, $value, $options);
	}


	public function email($name, $value = null, $options = array())
	{
		$options = $this->addClass('form-control', $options);
		
		return parent::email($name, $value, $options);
	}


	public function password($name, $options = array())
	{
		$options = $this->addClass('form-control', $options);
		
		return parent::password($name, $options);
	}


	public function textarea($name, $value = null, $rows = 5, $options = array())
	{
		$options = $this->addClass('form-control', $options);

		$options = $this->addOption('rows', $rows, $options);

		return parent::textarea($name, $value, $options);
	}


	protected function addClass($class, $options)
	{
		return $this->addOption('class', $class, $options);
	}


	protected function addOption($option, $value, $options)
	{
		if ( ! isset($options[$option])) {
			$options[$option] = "";
		}

		$options[$option] = trim($options[$option] .= " " . $value);

		return $options;
	}


	public function submit($value = null, $type = 'btn-default', $options = array())
	{
		$options = $this->addClass('btn', $options);
		$options = $this->addClass($type, $options);

		return parent::submit($value, $options);
	}
}