<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;

class RadioList extends Element
{
	protected $radios;

	public function __construct($radios)
	{
		$this->radios = $radios;
	}

	public function render()
	{
		$html  = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .= $this->renderRadios();
		$html .= '</div>';

		return $html;
	}

	protected function renderRadios()
	{
		$result = '';
		foreach ($this->radios as $radio) {
			$result .= $radio->render();
		}
		return $result;
	}
}
