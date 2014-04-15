<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Label;

class GroupWrapper
{
	protected $formGroup;

	public function __construct($formGroup)
	{
		$this->formGroup = $formGroup;
	}

	public function render()
	{
		return $this->formGroup->render();
	}

	public function helpBlock($text)
	{
		$this->formGroup->helpBlock($text);
		return $this;
	}

	public function __toString()
	{
		return $this->render();
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->formGroup->control(), $method), $parameters);
		return $this;
	}
}
