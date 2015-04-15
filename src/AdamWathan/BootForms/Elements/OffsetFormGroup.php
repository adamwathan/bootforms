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
		$class = '';
		foreach ($this->columnSizes as $breakpoint => $sizes) {
			$offset = 12 - $sizes[1];
			$class .= sprintf('col-%s-offset-%s col-%s-%s ', $breakpoint, $offset, $breakpoint, $sizes[1]);
		}
		return trim($class);

	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->control, $method), $parameters);
		return $this;
	}
}
