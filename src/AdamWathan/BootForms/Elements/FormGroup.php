<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class FormGroup extends Element
{
	protected $label;
	protected $control;
	protected $helpBlock;
	protected $inputGroup;

	public function __construct(Label $label, Element $control)
	{
		$this->label = $label;
		$this->control = $control;
		$this->addClass('form-group');
	}

	public function render()
	{
		$html  = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .= $this->label;
		$html .= $this->renderInputGroup();
		$html .= $this->renderHelpBlock();
		$html .= '</div>';

		return $html;
	}

	public function inputGroup($class = "")
	{
		if (!isset($this->inputGroup)) {
			$this->inputGroup = new InputGroup($this, $class);
		}

		return $this->inputGroup;
	}

	protected function renderInputGroup()
	{
		if ($this->inputGroup) {
			return $this->inputGroup->render();
		}

		return $this->control;
	}

	public function helpBlock($text)
	{
		if (isset($this->helpBlock)) {
			return;
		}
		$this->helpBlock = new HelpBlock($text);
		return $this;
	}

	protected function renderHelpBlock()
	{
		if ($this->helpBlock) {
			return $this->helpBlock->render();
		}

		return '';
	}

	public function control()
	{
		return $this->control;
	}

	public function label()
	{
		return $this->label;
	}

	public function __call($method, $parameters)
	{
		call_user_func_array(array($this->control, $method), $parameters);
		return $this;
	}
}
