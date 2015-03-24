<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class OffsetFormGroup extends Element
{
	protected $control;
	protected $columnSizes;

	public function __construct(Element $control, $columnSizes)
	{
		$this->control = $control;
		$this->columnSizes = $columnSizes;
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

	public function setColumnSizes($columnSizes)
	{
		$this->columnSizes = $columnSizes;
		return $this;
	}

	protected function getControlClass()
	{
		$offset = 12 - $this->columnSizes['lg'][1];
		return 'col-lg-offset-' . $offset . ' col-lg-' . $this->columnSizes['lg'][1];
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->control, $method), $parameters);
		return $this;
	}
}
