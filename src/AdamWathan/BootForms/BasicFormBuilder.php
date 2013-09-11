<?php namespace AdamWathan\BootForms;

use AdamWathan\Form\FormBuilder;
use AdamWathan\BootForms\Elements\FormGroup;
use Illuminate\Session\Store as Session;

class BasicFormBuilder
{

	private $controlOptions = array('class' => 'form-control');

	private $builder;
	private $session;

	public function __construct(FormBuilder $builder)
	{
		$this->builder = $builder;
	}


	protected function formGroup($label, $control)
	{
		return new FormGroup($label, $control);
	}


	protected function getValidationClass($name)
	{
		return '';
		if (! $this->hasErrors() || ! $this->hasError($name)) {
			return '';
		}
		
		return 'has-error';
	}

	
	public function text($label, $name, $value = null)
	{
		$label = $this->builder->label($label, $name)->forId($name);
		$control = $this->builder->text($name)->value($value)->id($name)->addClass('form-control');

		return $this->formGroup($label, $control);
	}

	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->builder, $method), $parameters);
	}
}