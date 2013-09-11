<?php

use AdamWathan\BootForms\BasicFormBuilder;
use AdamWathan\Form\FormBuilder;

class BasicFormBuilderTest extends PHPUnit_Framework_TestCase
{
	private $form;

	public function setUp()
	{
		$builder = new FormBuilder;
		$this->form = new BasicFormBuilder($builder);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testRenderTextGroup()
	{
		$expected = '<div class="form-group"><label for="email">Email</label><input type="text" name="email" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email')->render();
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithValue()
	{
		$expected = '<div class="form-group"><label for="email">Email</label><input type="text" name="email" id="email" class="form-control" value="example@example.com"></div>';
		$result = $this->form->text('Email', 'email')->value('example@example.com')->render();
		$this->assertEquals($expected, $result);
	}
}