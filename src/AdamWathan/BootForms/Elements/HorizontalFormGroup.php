<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
use AdamWathan\Form\Elements\Label;

class HorizontalFormGroup extends FormGroup
{
    protected $controlSizes;

    public function __construct(Label $label, Element $control, $controlSizes)
    {
        parent::__construct($label, $control);
        $this->controlSizes = $controlSizes;
    }

    public function render()
    {
        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->label;
        $html .= '<div class="' . $this->getControlClass() . '">';
        $html .= $this->control;
        $html .= $this->renderHelpBlock();
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    protected function getControlClass()
    {
        $class = '';
        foreach ($this->controlSizes as $breakpoint => $size) {
            $class .= sprintf('col-%s-%s ', $breakpoint, $size);
        }
        return trim($class);
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->control, $method], $parameters);
        return $this;
    }
}
