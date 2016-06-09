<?php namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\HorizontalFormGroup;
use AdamWathan\BootForms\Elements\OffsetFormGroup;
use AdamWathan\Form\FormBuilder;

class HorizontalFormBuilder extends BasicFormBuilder
{
    protected $columnSizes;

    protected $builder;

    public function __construct(FormBuilder $builder, $columnSizes = ['lg' => [2, 10]])
    {
        $this->builder = $builder;
        $this->columnSizes = $columnSizes;
    }

    public function setColumnSizes($columnSizes)
    {
        $this->columnSizes = $columnSizes;
        return $this;
    }

    public function open()
    {
        return $this->builder->open()->addClass('form-horizontal');
    }

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

    protected function getControlSizes()
    {
        $controlSizes = [];
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $controlSizes[$breakpoint] = $sizes[1];
        }
        return $controlSizes;
    }

    protected function getLabelClass()
    {
        $class = '';
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $class .= sprintf('col-%s-%s ', $breakpoint, $sizes[0]);
        }
        return trim($class);
    }

    public function button($value, $name = null, $type = "btn-default")
    {
        $button = $this->builder->button($value, $name)->addClass('btn')->addClass($type);
        return new OffsetFormGroup($button, $this->columnSizes);
    }

    public function submit($value = "Submit", $type = "btn-default")
    {
        $button = $this->builder->submit($value)->addClass('btn')->addClass($type);
        return new OffsetFormGroup($button, $this->columnSizes);
    }

    public function checkbox($label, $name)
    {
        $control = $this->builder->checkbox($name);
        $checkGroup = $this->checkGroup($label, $name, $control)->addClass('checkbox');

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

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

    public function radio($label, $name, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);
        $checkGroup = $this->checkGroup($label, $name, $control)->addClass('radio');

        return new OffsetFormGroup($this->wrap($checkGroup), $this->columnSizes);
    }

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

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
