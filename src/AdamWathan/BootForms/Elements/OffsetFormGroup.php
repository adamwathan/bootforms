<?php namespace AdamWathan\BootForms\Elements;

class OffsetFormGroup
{
    protected $control;
    protected $columnSizes;

    public function __construct($control, $columnSizes)
    {
        $this->control = $control;
        $this->columnSizes = $columnSizes;
    }

    public function render()
    {
        $html = '<div class="form-group">';
        $html .= '<div class="' . $this->getControlClass() . '">';
        $html .= $this->control;
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

    public function __toString()
    {
        return $this->render();
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->control, $method], $parameters);
        return $this;
    }
}
