<?php namespace AdamWathan\BootForms;

use Illuminate\Html\FormBuilder;
use Illuminate\Session\Store as Session;

class HorizontalFormBuilder
{

	private $controlOptions = array('class' => 'form-control');
	private $labelWidth;
	private $controlWidth;

	private $builder;
	private $session;

	public function __construct(FormBuilder $builder, Session $session)
	{
		$this->builder = $builder;
		$this->session = $session;
	}

	public function setLabelWidth($columns)
	{
		$this->labelWidth = $columns;
	}

	public function setControlWidth($columns)
	{
		$this->controlWidth = $columns;
	}

	public function open(array $options = array())
	{
		if ( ! isset($options['class'])) {
			$options['class'] = '';
		}

		$options['class'] = trim($options['class'] . ' ' . 'form-horizontal');

		return $this->builder->open($options);
	}

	protected function formGroup($name, $label, $control)
	{
		$formGroupClass = 'form-group';

		$formGroupClass = trim($formGroupClass . ' ' . $this->getValidationClass($name));
		
		$html = '<div class="' . $formGroupClass . '">';
		$html .= $this->label($name, $label);
		$html .= '<div class="col-lg-' . $this->controlWidth . '">';
		$html .= $control;
		
		if ($this->hasError($name)) {
			$html .= '<p class="help-block">' . $this->getError($name) . '</p>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}


	protected function getValidationClass($name)
	{
		if (! $this->hasErrors() || ! $this->hasError($name)) {
			return '';
		}
		
		return 'has-error';
	}

	protected function hasErrors()
	{
		return $this->session->has('errors');
	}

	protected function hasError($key)
	{
		if ( ! $this->hasErrors()) {
			return false;
		}

		return $this->getErrors()->has($key);
	}

	protected function getError($key)
	{
		if ( ! $this->hasError($key)) {
			return null;
		}

		return $this->getErrors()->first($key);		
	}

	protected function getErrors()
	{
		return $this->hasErrors() ? $this->session->get('errors') : null;
	}


	public function checkbox($label, $name, $value = 1, $checked = null)
	{
		$formGroup  = '<div class="form-group">';
		$formGroup .= '   <div class="col-lg-offset-' . $this->labelWidth . ' col-lg-' . $this->controlWidth . '">';
		$formGroup .= '     <div class="checkbox">';
		$formGroup .= '       <label>';
		$formGroup .= $this->builder->checkbox($name, $value, $checked) . $label;
		$formGroup .= '       </label>';
		$formGroup .= '     </div>';
		$formGroup .= '   </div>';
		$formGroup .= ' </div>';

		return $formGroup;
	}

	
	public function text($label, $name, $value = null)
	{
		$control = $this->builder->text($name, $value, $this->controlOptions);

		return $this->formGroup($name, $label, $control);
	}


	public function email($label, $name, $value = null)
	{
		$control = $this->builder->email($name, $value, $this->controlOptions);

		return $this->formGroup($name, $label, $control);
	}


	public function password($label, $name)
	{
		$control = $this->builder->password($name, $this->controlOptions);

		return $this->formGroup($name, $label, $control);
	}


	public function textarea($label, $name, $rows = 5, $value = null)
	{
		$options = array_merge($this->controlOptions, array('rows' => $rows));

		$control =  $this->builder->textarea($name, $value, $options);

		return $this->formGroup($name, $label, $control);
	}


	public function label($name, $value = null)
	{
		$options = array('class' => 'control-label col-lg-' . $this->labelWidth);

		return $this->builder->label($name, $value, $options);
	}


	public function submit($value = null, $type = 'btn-default', $options = array())
	{
		$options = array_merge(array('class' => 'btn ' . $type), $options);

		$formGroup  = '<div class="form-group">';
		$formGroup .= '   <div class="col-lg-offset-' . $this->labelWidth . ' col-lg-' . $this->controlWidth . '">';
		$formGroup .= $this->builder->submit($value, $options);
		$formGroup .= '   </div>';
		$formGroup .= ' </div>';

		return $formGroup;
	}

	public function __call($method, $parameters)
	{
		return call_user_func_array(array($this->builder, $method), $parameters);
	}
}