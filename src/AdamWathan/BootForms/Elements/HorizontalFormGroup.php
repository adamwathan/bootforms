<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class HorizontalFormGroup extends FormGroup
{
	protected $controlWidth;

	public function __construct(Label $label, Element $control, $controlWidth = 10)
	{
		parent::__construct($label, $control);
		$this->controlWidth = $controlWidth;
	}

	public function render()
	{		
		$html  = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .=  $this->label;
		$html .= '<div class="' . $this->getControlClass() . '">';
		$html .=  $this->control;
		$html .= $this->renderHelpBlock();
		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

	public function setControlWidth($width)
	{
		$this->controlWidth = $width;
		return $this;
	}

	protected function getControlClass()
	{
		return 'col-lg-' . $this->controlWidth;
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->control, $method), $parameters);
		return $this;
	}
}