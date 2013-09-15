<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class OffsetFormGroup extends Element
{
	protected $control;
	protected $controlWidth;

	public function __construct(Element $control, $controlWidth = 10)
	{
		$this->control = $control;
		$this->controlWidth = $controlWidth;
		$this->addClass('form-group');
	}

	public function render()
	{		
		$html  = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .= '<div class="' . $this->getControlClass() . '">';
		$html .=  $this->control;
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
		$offset = 12 - $this->controlWidth;
		return 'col-lg-offset-' . $offset . ' col-lg-' . $this->controlWidth;
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->control, $method), $parameters);
		return $this;
	}
}