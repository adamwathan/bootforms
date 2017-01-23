<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Text;

class InputGroup extends Text
{
    protected $beforeAddon = [];
    protected $afterAddon = [];
    protected $addonClass = [];

    public function beforeAddon($addon)
    {
        $this->beforeAddon[] = $addon;

        return $this;
    }

    public function afterAddon($addon)
    {
        $this->afterAddon[] = $addon;

        return $this;
    }

    public function type($type)
    {
        $this->attributes['type'] = $type;
        return $this;
    }

    protected function renderAddons($addons)
    {
        $html = '';

        foreach ($addons as $addon) {
            $html .= sprintf('<span class="input-group-addon%s">%s</span>', $this->renderAddonClass(), $addon);
        }

        return $html;
    }

    public function addAddonCss($css)
    {
        $this->addonClass[] = $css;

        return $this;
    }

    protected function renderAddonClass()
    {
        $class = '';

        foreach ($this->addonClass as $css) {
            $class .= ' ' . $css;
        }

        return $class;
    }

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
