<?php namespace AdamWathan\BootForms;

use Illuminate\Html\FormBuilder;

class BootForm
{
	private $builder;
	private $basicFormBuilder;
	private $horizontalFormBuilder;

	public function __construct(BasicFormBuilder $basicFormBuilder, HorizontalFormBuilder $horizontalFormBuilder)
	{
		$this->basicFormBuilder = $basicFormBuilder;
		$this->horizontalFormBuilder = $horizontalFormBuilder;
	}


	public function open()
	{
		$this->builder = $this->basicFormBuilder;
		return $this->builder->open();
	}

	public function openHorizontal($labelWidth, $controlWidth)
	{
		$this->horizontalFormBuilder->setLabelWidth($labelWidth);
		$this->horizontalFormBuilder->setControlWidth($controlWidth);
		$this->builder = $this->horizontalFormBuilder;
		return $this->builder->open();
	}

	public function __call($method, $parameters)
	{
  		return call_user_func_array(array($this->builder, $method), $parameters);
  	}
}