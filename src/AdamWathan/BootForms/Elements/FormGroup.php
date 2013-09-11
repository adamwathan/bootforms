<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;
use AdamWathan\Form\Elements\Input;

class FormGroup extends Element
{
	private $label;
	private $input;

	public function __construct(Label $label, Input $input)
	{
		$this->label = $label;
		$this->input = $input;
		$this->addClass('form-group');
	}

	public function render()
	{		
		$html  = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .=  $this->label;
		$html .=  $this->input;

		// if ($this->hasError($name)) {
		// 	$html .= '<p class="help-block">' . $this->getError($name) . '</p>';
		// }

		$html .= '</div>';

		return $html;
	}

	public function placeholder($placeholder)
	{
		$this->input->placeholder($placeholder);
		return $this;
	}

	public function value($value)
	{
		$this->input->value($value);
		return $this;
	}

	public function defaultValue($value)
	{
		$this->input->defaultValue($value);
		return $this;
	}
}