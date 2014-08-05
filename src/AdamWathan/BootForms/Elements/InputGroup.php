<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\BootForms\Elements\FormGroup;

class InputGroup extends Element
{
	private $formGroup;
	private $beforeAddon = array();
	private $afterAddon = array();

	public function __construct(FormGroup $formGroup, $class = '')
	{
		$this->formGroup = $formGroup;
		$this->addClass('input-group');
		if (!empty($class)) $this->addClass($class);
	}

	public function beforeAddon($addon)
	{
		$this->beforeAddon[] = $addon;
		return $this->formGroup;
	}

	public function afterAddon($addon)
	{
		$this->afterAddon[] = $addon;
		return $this->formGroup;
	}

	protected function renderAddons($addons)
	{
		$html = '';
		foreach ($addons as $addon) {
			$html .= '<span class="input-group-addon">';
			$html .= $addon;
			$html .= '</span>';
		}

		return $html;
	}

	public function render()
	{
		$html = '<div';
		$html .= $this->renderAttributes();
		$html .= '>';
		$html .= $this->renderAddons($this->beforeAddon);
		$html .= $this->formGroup->control();
		$html .= $this->renderAddons($this->afterAddon);
		$html .= '</div>';
		
		return $html;
	}
}