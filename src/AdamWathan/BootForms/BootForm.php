<?php namespace AdamWathan\BootForms;

/**
 * Class BootForm
 * @package AdamWathan\BootForms
 * @method \AdamWathan\Form\Elements\Text text($name)
 * @method \AdamWathan\Form\Elements\Date date($name)
 * @method \AdamWathan\Form\Elements\Email email($name)
 * @method \AdamWathan\Form\Elements\Hidden hidden($name)
 * @method \AdamWathan\Form\Elements\TextArea textarea($name)
 * @method \AdamWathan\Form\Elements\Password password($name)
 * @method \AdamWathan\Form\Elements\Checkbox checkbox($name, $value = 1)
 * @method \AdamWathan\Form\Elements\RadioButton radio($name, $value = null)
 * @method \AdamWathan\Form\Elements\Button button($value, $name = null)
 * @method \AdamWathan\Form\Elements\Button submit($value = 'Submit')
 * @method \AdamWathan\Form\Elements\Select select($name, $options = [])
 * @method \AdamWathan\Form\Elements\Label label($label)
 * @method \AdamWathan\Form\Elements\File file($name)
 * @method setOldInputProvider(\AdamWathan\Form\OldInput\OldInputInterface $oldInputProvider)
 * @method setErrorStore(\AdamWathan\Form\ErrorStore\ErrorStoreInterface $errorStore)
 * @method setToken($token)
 * @method string close()
 * @method string token()
 * @method bool hasError($name)
 * @method string getError($name, $format = null)
 * @method  bind($data)
 * @method mixed getValueFor($name)
 * @method \AdamWathan\Form\Elements\Select selectMonth($name)
 */
class BootForm
{
    /**
	 * @var BasicFormBuilder
	 */
    protected $builder;

    /**
	 * @var BasicFormBuilder
	 */
	protected $basicFormBuilder;

    /**
	 * @var HorizontalFormBuilder
	 */
	protected $horizontalFormBuilder;

    /**
	 * BootForm constructor.
	 * @param BasicFormBuilder $basicFormBuilder
	 * @param HorizontalFormBuilder $horizontalFormBuilder
	 */
    public function __construct(BasicFormBuilder $basicFormBuilder, HorizontalFormBuilder $horizontalFormBuilder)
    {
        $this->basicFormBuilder = $basicFormBuilder;
        $this->horizontalFormBuilder = $horizontalFormBuilder;
    }

    /**
	 * @return \AdamWathan\Form\Elements\FormOpen
	 */
    public function open()
    {
        $this->builder = $this->basicFormBuilder;
        return $this->builder->open();
    }

    /**
	 * @param $columnSizes
	 * @return \AdamWathan\Form\Elements\FormOpen
	 */
    public function openHorizontal($columnSizes)
    {
        $this->horizontalFormBuilder->setColumnSizes($columnSizes);
        $this->builder = $this->horizontalFormBuilder;
        return $this->builder->open();
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
