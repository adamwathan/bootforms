<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Label;

class GroupWrapper
{
    protected $formGroup;
    protected $target;

    public function __construct($formGroup)
    {
        $this->formGroup = $formGroup;
        $this->target = $formGroup->control();
    }

    public function render()
    {
        return $this->formGroup->render();
    }

    public function helpBlock($text)
    {
        $this->formGroup->helpBlock($text);
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function addGroupClass($class)
    {
        $this->formGroup->addClass($class);
        return $this;
    }

    public function removeGroupClass($class)
    {
        $this->formGroup->removeClass($class);
        return $this;
    }

    public function groupData($attribute, $value)
    {
        $this->formGroup->data($attribute, $value);
        return $this;
    }

    public function labelClass($class)
    {
        $this->formGroup->label()->addClass($class);
        return $this;
    }

    public function hideLabel()
    {
        $this->labelClass('sr-only');
        return $this;
    }

    public function inline()
    {
        $this->formGroup->inline();
        return $this;
    }

    public function group()
    {
        $this->target = $this->formGroup;
        return $this;
    }

    public function label()
    {
        $this->target = $this->formGroup->label();
        return $this;
    }

    public function control()
    {
        $this->target = $this->formGroup->control();
        return $this;
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->target, $method], $parameters);
        return $this;
    }
}
