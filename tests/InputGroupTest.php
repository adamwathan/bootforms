<?php

use Mockery as m;
use AdamWathan\BootForms\Elements\InputGroup;

class InputGroupTest extends PHPUnit_Framework_TestCase
{
	public function testCanRenderBasicText()
	{
		$input = new InputGroup('email');
		$this->assertInstanceOf('AdamWathan\Form\Elements\Text', $input);

		$expected = '<div class="input-group"><input type="text" name="email"></div>';
		$result = $input->render();
		$this->assertEquals($expected, $result);		
	}

	public function testCanRenderBeforeAddon()
	{
		$input = new InputGroup('username');
		$this->assertEquals($input, $input->beforeAddon('@'));

		$expected = '<div class="input-group"><span class="input-group-addon">@</span><input type="text" name="username"></div>';
		$result = $input->render();
		$this->assertEquals($expected, $result);		
	}

	public function testCanRenderAfterAddonAndType()
	{
		$input = new InputGroup('mail');
		$this->assertEquals($input, $input->type('email'));
		$this->assertEquals($input, $input->afterAddon('@domain.com'));

		$expected = '<div class="input-group"><input type="email" name="mail"><span class="input-group-addon">@domain.com</span></div>';
		$result = $input->render();
		$this->assertEquals($expected, $result);		
	}
}