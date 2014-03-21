<?php namespace AdamWathan\BootForms;

use AdamWathan\Form\FormBuilder;
use AdamWathan\BootForms\Elements\HorizontalFormGroup;
use AdamWathan\BootForms\Elements\OffsetFormGroup;
use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\HelpBlock;

class HorizontalFormBuilder extends BasicFormBuilder
{
	private $labelWidth;
	private $controlWidth;

	protected $builder;

	public function __construct(FormBuilder $builder)
	{
		$this->builder = $builder;
		$this->labelWidth = 2;
		$this->controlWidth = 10;
	}

	public function setLabelWidth($width)
	{
		$this->labelWidth = $width;
		return $this;
	}

	public function setControlWidth($width)
	{
		$this->controlWidth = $width;
		return $this;
	}

	public function open()
	{
		return $this->builder->open()->addClass('form-horizontal');
	}	

	protected function formGroup($label, $name, $control)
	{
		$label = $this->builder->label($label, $name)
		->addClass($this->getLabelClass())
		->addClass('control-label')
		->forId($name);

		$control->id($name)->addClass('form-control');

		$formGroup = new HorizontalFormGroup($label, $control, $this->controlWidth);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$formGroup->addClass('has-error');
		}

		return $formGroup;
	}

	protected function getLabelClass()
	{
		return 'col-lg-' . $this->labelWidth;
	}

	public function submit($value = "Submit", $type = "btn-default")
	{
		$button = $this->builder->submit($value)->addClass('btn')->addClass($type);
		return new OffsetFormGroup($button, $this->controlWidth);
	}

	public function checkbox($label, $name)
	{
		$control = $this->builder->checkbox($name);
		$checkGroup = $this->checkGroup($label, $name, $control)->addClass('checkbox');

		return new OffsetFormGroup($checkGroup, $this->controlWidth);
	}

	protected function checkGroup($label, $name, $control)
	{
		$label = $this->builder->label($label, $name)->after($control);

		$checkGroup = new CheckGroup($label);

		if ($this->builder->hasError($name)) {
			$checkGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$checkGroup->addClass('has-error');
		}

		return $checkGroup;
	}

	public function radio($label, $name, $value = null)
	{	
		if (is_null($value)) {
			$value = $label;
		}

		$control = $this->builder->radio($name, $value);
		$checkGroup = $this->checkGroup($label, $name, $control)->addClass('radio');

		return new OffsetFormGroup($checkGroup, $this->controlWidth);
	}

	public function file($label, $name, $value = null)
	{
		$control = $this->builder->file($name)->value($value);
		$label = $this->builder->label($label, $name)
			->addClass($this->getLabelClass())
			->addClass('control-label')
			->forId($name);

		$control->id($name);

		$formGroup = new HorizontalFormGroup($label, $control, $this->controlWidth);

		if ($this->builder->hasError($name)) {
			$formGroup->helpBlock(new HelpBlock($this->builder->getError($name)));
			$formGroup->addClass('has-error');
		}

		return $formGroup;
	}

	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->builder, $method), $parameters);
	}
}