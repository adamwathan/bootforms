<?php namespace AdamWathan\BootForms;

use Illuminate\Html\FormBuilder;

class BootForm
{
	private $builder;

	private $basicFormBuilder;

	public function __construct(BasicFormBuilder $basicFormBuilder)
	{
		$this->basicFormBuilder = $basicFormBuilder;
	}


	public function open(array $options = array())
	{
		$this->builder = $this->basicFormBuilder;
		return $this->builder->open($options);
	}


	public function __call($method, $parameters)
	{
  		return call_user_func_array(array($this->builder, $method), $parameters);
  	}
}