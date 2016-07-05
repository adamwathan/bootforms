<?php namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\HorizontalFormGroup;
use AdamWathan\BootForms\Elements\OffsetFormGroup;
use AdamWathan\Form\FormBuilder;

/**
 * Class HorizontalFormBuilder
 * @package AdamWathan\BootForms
 */
class HorizontalFormBuilder extends BasicFormBuilder
{
    protected $columnSizes;

    /**
     * @var FormBuilder
     */
    protected $builder;

    /**
     * HorizontalFormBuilder constructor.
     * @param FormBuilder $builder
     * @param array $columnSizes
     */
    public function __construct(FormBuilder $builder, $columnSizes = ['lg' => [2, 10]])
    {
        parent::__construct($builder);
        $this->columnSizes = $columnSizes;
    }

    /**
     * @param $columnSizes
     * @return $this
     */
    public function setColumnSizes($columnSizes)
    {
        $this->columnSizes = $columnSizes;
        return $this;
    }

    /**
     * @return \AdamWathan\Form\Elements\FormOpen
     */
    public function open()
    {
        return $this->builder->open()->addClass('form-horizontal');
    }

    /**
     * @param $label
     * @param $name
     * @param $control
     * @return Elements\GroupWrapper
     */
    protected function formGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)
            ->addClass($this->getLabelClass())
            ->addClass('control-label')
            ->forId($name);

        $control->id($name)->addClass('form-control');

        $formGroup = new HorizontalFormGroup($label, $control, $this->getControlSizes());

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $this->wrap($formGroup);
    }

    /**
     * @return array
     */
    protected function getControlSizes()
    {
        $controlSizes = [];
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $controlSizes[$breakpoint] = $sizes[1];
        }
        return $controlSizes;
    }

    /**
     * @return string
     */
    protected function getLabelClass()
    {
        $class = '';
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $class .= sprintf('col-%s-%s ', $breakpoint, $sizes[0]);
        }
        return trim($class);
    }

	/**
     * @param $value
     * @param null $name
     * @param string $type
     * @return OffsetFormGroup
     */
    public function button($value, $name = null, $type = "btn-default")
    {
        $button = $this->builder->button($value, $name)->addClass('btn')->addClass($type);
        return new OffsetFormGroup($button, $this->columnSizes);
    }

	/**
     * @param string $value
     * @param string $type
     * @return OffsetFormGroup
     */
    public function submit($value = "Submit", $type = "btn-default")
    {
        $button = $this->builder->submit($value)->addClass('btn')->addClass($type);
        return new OffsetFormGroup($button, $this->columnSizes);
    }

	/**
     * @param $label
     * @param $name
     * @return OffsetFormGroup
     */
    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);
        $checkGroup = $this->checkGroup($label, $name, $control)->addClass('checkbox');

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

	/**
     * @param $label
     * @param $name
     * @param $control
     * @return CheckGroup
     */
    protected function checkGroup($label, $name, $control)
    {
        $label = $this->builder->label($label, $name)->after($control);

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
     * @return OffsetFormGroup
     */
    public function radio($label, $name, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);
        $checkGroup = $this->checkGroup($label, $name, $control)->addClass('radio');

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

	/**
     * @param $label
     * @param $name
     * @param null $value
     * @return HorizontalFormGroup
     */
    public function file($label, $name, $value = null)
    {
        $control = $this->builder->file($name)->value($value);
        $label = $this->builder->label($label, $name)
            ->addClass($this->getLabelClass())
            ->addClass('control-label')
            ->forId($name);

        $control->id($name);

        $formGroup = new HorizontalFormGroup($label, $control, $this->getControlSizes());

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $formGroup;
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
