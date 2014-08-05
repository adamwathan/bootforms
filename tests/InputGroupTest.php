<?php

use Mockery as m;
use AdamWathan\BootForms\Elements\InputGroup;

class InputGroupTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
	}

	public function testCanRenderBeforeAddon()
	{
		$control = '<input type="text" name="username">';
		$formGroup = m::mock('AdamWathan\BootForms\Elements\FormGroup');
		$formGroup->shouldReceive('control')->once()->andReturn($control);
		
		$inputGroup = new InputGroup($formGroup, 'input-group-lg');
		$this->assertEquals($formGroup, $inputGroup->beforeAddon('@'));
		
		$expected = '<div class="input-group input-group-lg"><span class="input-group-addon">@</span>'.$control.'</div>';
		$result = $inputGroup->render();
		$this->assertEquals($expected, $result);
	}

	public function testCanRenderAfterAddon()
	{
		$control = '<input type="text" name="username">';
		$formGroup = m::mock('AdamWathan\BootForms\Elements\FormGroup');
		$formGroup->shouldReceive('control')->once()->andReturn($control);
		
		$inputGroup = new InputGroup($formGroup, 'input-group-lg');
		$this->assertEquals($formGroup, $inputGroup->afterAddon(',00'));
		
		$expected = '<div class="input-group input-group-lg">'.$control.'<span class="input-group-addon">,00</span></div>';
		$result = $inputGroup->render();
		$this->assertEquals($expected, $result);
	}
}