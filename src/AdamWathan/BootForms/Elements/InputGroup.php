<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Text;

/**
 * Class InputGroup
 * @package AdamWathan\BootForms\Elements
 */
class InputGroup extends Text
{
    /**
     * @var array
     */
    protected $beforeAddon = [];

    /**
     * @var array
     */
    protected $afterAddon = [];

    /**
     * @param $addon
     * @return $this
     */
    public function beforeAddon($addon)
    {
        $this->beforeAddon[] = $addon;

        return $this;
    }

    /**
     * @param $addon
     * @return $this
     */
    public function afterAddon($addon)
    {
        $this->afterAddon[] = $addon;

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->attributes['type'] = $type;
        return $this;
    }

    /**
     * @param array $addons
     * @return string
     */
    protected function renderAddons($addons)
    {
        $html = '';

        foreach ($addons as $addon) {
            $html .= '<span class="input-group-addon">';
            $html .= $addon;
            $html .= '</span>';
        }

        return $html;
    }

    /**
     * @return string
     */
    public function render()
    {
        $html = '<div class="input-group">';
        $html .= $this->renderAddons($this->beforeAddon);
        $html .= parent::render();
        $html .= $this->renderAddons($this->afterAddon);
        $html .= '</div>';

        return $html;
    }
}
