<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Text;

class InputGroup extends Text
{
    protected $beforeAddon = [];
    protected $afterAddon = [];
    protected $classAddon = [];
    protected $addonID;

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

    public function addAddonClass($class)
    {
        $this->classAddon[] = $class;

        return $this;
    }

    public function addAddonId($id)
    {
        $this->addonID = $id;

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
            $html .= sprintf('<span %sclass="input-group-addon%s">%s</span>', $this->renderAddonsId(), $this->renderAddonsClass(), $addon);
        }

        return $html;
    }

    protected function renderAddonsId()
    {
        if($this->addonID) {
            return sprintf('id="%s"' . ' ', $this->addonID);
        }
    }

    protected function renderAddonsClass()
    {
        $html = '';

        foreach($this->classAddon as $class) {
            $html .= ' ' . $class;
        }

        return $html;
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
