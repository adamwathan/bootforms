<?php namespace AdamWathan\BootForms\Elements;

/**
 * Class OffsetFormGroup
 * @package AdamWathan\BootForms\Elements
 */
class OffsetFormGroup
{
	/**
     * @var string
     */
    protected $control;
	/**
     * @var array
     */
    protected $columnSizes;

	/**
     * OffsetFormGroup constructor.
     * @param string $control
     * @param array $columnSizes
     */
    public function __construct($control, $columnSizes)
    {
        $this->control = $control;
        $this->columnSizes = $columnSizes;
    }

	/**
     * @return string
     */
    public function render()
    {
        $html = '<div class="form-group">';
        $html .= '<div class="' . $this->getControlClass() . '">';
        $html .= $this->control;
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

	/**
     * @param array $columnSizes
     * @return $this
     */
    public function setColumnSizes(array $columnSizes)
    {
        $this->columnSizes = $columnSizes;
        return $this;
    }

	/**
     * @return string
     */
    protected function getControlClass()
    {
        $class = '';
        foreach ($this->columnSizes as $breakpoint => $sizes) {
            $class .= sprintf('col-%s-offset-%s col-%s-%s ', $breakpoint, $sizes[0], $breakpoint, $sizes[1]);
        }
        return trim($class);
    }

	/**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

	/**
     * @param $method
     * @param $parameters
     * @return $this
     */
    public function __call($method, $parameters)
    {
        call_user_func_array([$this->control, $method], $parameters);
        return $this;
    }
}
