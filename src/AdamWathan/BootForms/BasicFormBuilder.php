<?php namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\FormGroup;
use AdamWathan\BootForms\Elements\GroupWrapper;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\InputGroup;
use AdamWathan\Form\FormBuilder;

/**
 * Class BasicFormBuilder
 * @package AdamWathan\BootForms
 */
class BasicFormBuilder
{
	/**
     * @var FormBuilder
     */
    protected $builder;

	/**
     * BasicFormBuilder constructor.
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

	/**
     * @param $label
     * @param $name
     * @param $control
     * @return GroupWrapper
     */
    protected function formGroup($label, $name, $control)
    {
        $label = $this->builder->label($label)->addClass('control-label')->forId($name);
        $control->id($name)->addClass('form-control');

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $this->wrap($formGroup);
    }

	/**
     * @param $group
     * @return GroupWrapper
     */
    protected function wrap($group)
    {
        return new GroupWrapper($group);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function text($label, $name, $value = null)
    {
        $control = $this->builder->text($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @return GroupWrapper
     */
    public function password($label, $name)
    {
        $control = $this->builder->password($name);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $value
     * @param null $name
     * @param string $type
     * @return \AdamWathan\Form\Elements\Button
     */
    public function button($value, $name = null, $type = "btn-default")
    {
        return $this->builder->button($value, $name)->addClass('btn')->addClass($type);
    }

	/**
     * @param string $value
     * @param string $type
     * @return \AdamWathan\Form\Elements\Button
     */
    public function submit($value = "Submit", $type = "btn-default")
    {
        return $this->builder->submit($value)->addClass('btn')->addClass($type);
    }

    /**
     * @param $label
     * @param $name
     * @param array $options
     * @return GroupWrapper
     */
    public function select($label, $name, $options = [])
    {
        $control = $this->builder->select($name, $options);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @return GroupWrapper
     */
    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);

        return $this->checkGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @return $this
     */
    public function inlineCheckbox($label, $name)
    {
        return $this->checkbox($label, $name)->inline();
    }

	/**
     * @param $label
     * @param $name
     * @param $control
     * @return GroupWrapper
     */
    protected function checkGroup($label, $name, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('checkbox'));
    }

	/**
     * @param $label
     * @param $name
     * @param $control
     * @return CheckGroup
     */
    protected function buildCheckGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)->after($control)->addClass('control-label');

        $checkGroup = new CheckGroup($label);

        if ($this->builder->hasError($name)) {
            $checkGroup->helpBlock($this->builder->getError($name));
            $checkGroup->addClass('has-error');
        }
        return $checkGroup;
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function radio($label, $name, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);

        return $this->radioGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return \AdamWathan\Form\Elements\RadioButton
     */
    public function inlineRadio($label, $name, $value = null)
    {
        return $this->radio($label, $name, $value)->inline();
    }

	/**
     * @param $label
     * @param $name
     * @param $control
     * @return GroupWrapper
     */
    protected function radioGroup($label, $name, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('radio'));
    }

	/**
     * @param $label
     * @param $name
     * @return GroupWrapper
     */
    public function textarea($label, $name)
    {
        $control = $this->builder->textarea($name);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function date($label, $name, $value = null)
    {
        $control = $this->builder->date($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function email($label, $name, $value = null)
    {
        $control = $this->builder->email($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function file($label, $name, $value = null)
    {
        $control = $this->builder->file($name)->value($value);
        $label = $this->builder->label($label, $name)->addClass('control-label')->forId($name);
        $control->id($name);

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $this->wrap($formGroup);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return GroupWrapper
     */
    public function inputGroup($label, $name, $value = null)
    {
        $control = new InputGroup($name);
        if (!is_null($value) || !is_null($value = $this->getValueFor($name))) {
            $control->value($value);
        }

        return $this->formGroup($label, $name, $control);
    }

	/**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
