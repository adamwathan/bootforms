<?php namespace AdamWathan\BootForms\Elements;

use Illuminate\Contracts\Support\Htmlable;

class OffsetFormGroup implements Htmlable
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
            $class .= sprintf('col-%s-offset-%s col-%s-%s ', $breakpoint, $sizes[0], $breakpoint, $sizes[1]);
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

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml() {
        return $this->render();
    }
}
