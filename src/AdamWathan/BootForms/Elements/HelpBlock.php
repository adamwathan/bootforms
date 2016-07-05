<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;

/**
 * Class HelpBlock
 * @package AdamWathan\BootForms\Elements
 */
class HelpBlock extends Element
{
	/**
     * @var string
     */
    private $message;

	/**
     * HelpBlock constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
        $this->addClass('help-block');
    }

	/**
     * @return string
     */
    public function render()
    {
        $html = '<p';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</p>';

        return $html;
    }
}
