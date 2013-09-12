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


		// Create a help block object and set that if there's an error from the FormBuilder itself
		// if ($this->hasError($name)) {
		// 	$html .= '<p class="help-block">' . $this->getError($name) . '</p>';
		// }

		$html .= '</div>';

		return $html;
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->input, $method), $parameters);
		return $this;
	}
}