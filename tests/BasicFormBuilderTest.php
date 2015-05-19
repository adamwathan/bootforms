<?php

use AdamWathan\BootForms\BasicFormBuilder;
use AdamWathan\Form\FormBuilder;

class BasicFormBuilderTest extends PHPUnit_Framework_TestCase
{
	private $form;
	private $builder;

	public function setUp()
	{
		$this->builder = new FormBuilder;
		$this->form = new BasicFormBuilder($this->builder);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testRenderTextGroup()
	{
		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="text" name="email" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithValue()
	{
		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="text" name="email" id="email" class="form-control" value="example@example.com"></div>';
		$result = $this->form->text('Email', 'email')->value('example@example.com');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Email is required.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="form-group has-error"><label class="control-label" for="email">Email</label><input type="text" name="email" id="email" class="form-control"><p class="help-block">Email is required.</p></div>';
		$result = $this->form->text('Email', 'email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithErrorOverridesCustomHelpBlock()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Email is required.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="form-group has-error"><label class="control-label" for="email">Email</label><input type="text" name="email" id="email" class="form-control"><p class="help-block">Email is required.</p></div>';
		$result = $this->form->text('Email', 'email')->helpBlock('some custom text');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithOldInputAndDefaultValue()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email')->defaultValue('test@test.com');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithDefaultValue()
	{
		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="text" name="email" id="email" class="form-control" value="test@test.com"></div>';
		$result = $this->form->text('Email', 'email')->defaultValue('test@test.com');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithOldInputAndError()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

		$this->builder->setOldInputProvider($oldInput);

		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Email is required.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="form-group has-error"><label class="control-label" for="email">Email</label><input type="text" name="email" value="example@example.com" id="email" class="form-control"><p class="help-block">Email is required.</p></div>';
		$result = $this->form->text('Email', 'email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderPasswordGroup()
	{
		$expected = '<div class="form-group"><label class="control-label" for="password">Password</label><input type="password" name="password" id="password" class="form-control"></div>';
		$result = $this->form->password('Password', 'password');
		$this->assertEquals($expected, $result);
	}

	public function testRenderPasswordGroupDoesntKeepOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('password');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="form-group"><label class="control-label" for="password">Password</label><input type="password" name="password" id="password" class="form-control"></div>';
		$result = $this->form->password('Password', 'password');
		$this->assertEquals($expected, $result);
	}

	public function testRenderPasswordGroupWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Password is required.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="form-group has-error"><label class="control-label" for="password">Password</label><input type="password" name="password" id="password" class="form-control"><p class="help-block">Password is required.</p></div>';
		$result = $this->form->password('Password', 'password');
		$this->assertEquals($expected, $result);
	}

	public function testRenderButton()
	{
		$expected = '<button type="button" class="btn btn-default">Click Me</button>';
		$result = $this->form->button('Click Me');
		$this->assertEquals($expected, $result);
	}

	public function testRenderButtonWithNameAndAlternateStyling()
	{
		$expected = '<button type="button" name="success" class="btn btn-success">Click Me</button>';
		$result = $this->form->button('Click Me', 'success', 'btn-success');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSubmit()
	{
		$expected = '<button type="submit" class="btn btn-default">Submit</button>';
		$result = $this->form->submit();
		$this->assertEquals($expected, $result);
	}

	public function testRenderSubmitWithAlternateStyling()
	{
		$expected = '<button type="submit" class="btn btn-success">Submit</button>';
		$result = $this->form->submit('Submit', 'btn-success');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSubmitWithValue()
	{
		$expected = '<button type="submit" class="btn btn-success">Sign Up</button>';
		$result = $this->form->submit('Sign Up', 'btn-success');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelect()
	{
		$expected = '<div class="form-group"><label class="control-label" for="color">Favorite Color</label><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div>';

		$options = array('1' => 'Red', '2' => 'Green', '3' => 'Blue');
		$result = $this->form->select('Favorite Color', 'color', $options);
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithSelected()
	{
		$expected = '<div class="form-group"><label class="control-label" for="color">Favorite Color</label><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3" selected>Blue</option></select></div>';
		$options = array('1' => 'Red', '2' => 'Green', '3' => 'Blue');
		$result = $this->form->select('Favorite Color', 'color', $options)->select('3');
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Color is required.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="form-group has-error"><label class="control-label" for="color">Favorite Color</label><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select><p class="help-block">Color is required.</p></div>';

		$options = array('1' => 'Red', '2' => 'Green', '3' => 'Blue');
		$result = $this->form->select('Favorite Color', 'color', $options);
		$this->assertEquals($expected, $result);
	}

	public function testRenderSelectWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('2');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="form-group"><label class="control-label" for="color">Favorite Color</label><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2" selected>Green</option><option value="3">Blue</option></select></div>';

		$options = array('1' => 'Red', '2' => 'Green', '3' => 'Blue');
		$result = $this->form->select('Favorite Color', 'color', $options);
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckbox()
	{
		$expected = '<div class="checkbox"><label class="control-label"><input type="checkbox" name="terms" value="1">Agree to Terms</label></div>';
		$result = $this->form->checkbox('Agree to Terms', 'terms');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Must agree to terms.');

		$this->builder->setErrorStore($errorStore);

		$expected = '<div class="has-error checkbox"><label class="control-label"><input type="checkbox" name="terms" value="1">Agree to Terms</label><p class="help-block">Must agree to terms.</p></div>';
		$result = $this->form->checkbox('Agree to Terms', 'terms');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('1');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="checkbox"><label class="control-label"><input type="checkbox" name="terms" value="1" checked="checked">Agree to Terms</label></div>';
		$result = $this->form->checkbox('Agree to Terms', 'terms');
		$this->assertEquals($expected, $result);
	}

	public function testRenderCheckboxChecked()
	{
		$expected = '<div class="checkbox"><label class="control-label"><input type="checkbox" name="terms" value="1" checked="checked">Agree to Terms</label></div>';
		$result = $this->form->checkbox('Agree to Terms', 'terms')->check();
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadio()
	{
		$expected = '<div class="radio"><label class="control-label"><input type="radio" name="color" value="red">Red</label></div>';
		$result = $this->form->radio('Red', 'color', 'red');
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Sample error');

		$this->builder->setErrorStore($errorStore);
		$expected = '<div class="has-error radio"><label class="control-label"><input type="radio" name="color" value="red">Red</label><p class="help-block">Sample error</p></div>';
		$result = $this->form->radio('Red', 'color', 'red');
		$this->assertEquals($expected, $result);
	}

	public function testRenderRadioWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('red');

		$this->builder->setOldInputProvider($oldInput);

		$expected = '<div class="radio"><label class="control-label"><input type="radio" name="color" value="red" checked="checked">Red</label></div>';
		$result = $this->form->radio('Red', 'color', 'red');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextarea()
	{
		$expected = '<div class="form-group"><label class="control-label" for="bio">Bio</label><textarea name="bio" rows="10" cols="50" id="bio" class="form-control"></textarea></div>';
		$result = $this->form->textarea('Bio', 'bio');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextareaWithRows()
	{
		$expected = '<div class="form-group"><label class="control-label" for="bio">Bio</label><textarea name="bio" rows="5" cols="50" id="bio" class="form-control"></textarea></div>';
		$result = $this->form->textarea('Bio', 'bio')->rows(5);
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextareaWithCols()
	{
		$expected = '<div class="form-group"><label class="control-label" for="bio">Bio</label><textarea name="bio" rows="10" cols="20" id="bio" class="form-control"></textarea></div>';
		$result = $this->form->textarea('Bio', 'bio')->cols(20);
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextareaWithOldInput()
	{
		$oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
		$oldInput->shouldReceive('hasOldInput')->andReturn(true);
		$oldInput->shouldReceive('getOldInput')->andReturn('Sample bio');

		$this->builder->setOldInputProvider($oldInput);
		$expected = '<div class="form-group"><label class="control-label" for="bio">Bio</label><textarea name="bio" rows="10" cols="50" id="bio" class="form-control">Sample bio</textarea></div>';
		$result = $this->form->textarea('Bio', 'bio');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextareaWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Sample error');

		$this->builder->setErrorStore($errorStore);
		$expected = '<div class="form-group has-error"><label class="control-label" for="bio">Bio</label><textarea name="bio" rows="10" cols="50" id="bio" class="form-control"></textarea><p class="help-block">Sample error</p></div>';
		$result = $this->form->textarea('Bio', 'bio');
		$this->assertEquals($expected, $result);
	}

	public function testRenderInlineCheckbox()
	{
		$expected = '<label class="checkbox-inline"><input type="checkbox" name="terms" value="1">Agree to Terms</label>';
		$result = $this->form->inlineCheckbox('Agree to Terms', 'terms');
		$this->assertEquals($expected, $result);
	}

	public function testRenderInlineRadio()
	{
		$expected = '<label class="radio-inline"><input type="radio" name="color" value="Red">Red</label>';
		$result = $this->form->inlineRadio('Red', 'color');
		$this->assertEquals($expected, $result);
	}

	public function testFormOpen()
	{
		$expected = '<form method="POST" action="">';
		$result = $this->form->open();
		$this->assertEquals($expected, $result);
	}

	public function testFormOpenGet()
	{
		$expected = '<form method="GET" action="">';
		$result = $this->form->open()->get();
		$this->assertEquals($expected, $result);
	}

	public function testFormOpenCustomAction()
	{
		$expected = '<form method="POST" action="/login">';
		$result = $this->form->open()->action('/login');
		$this->assertEquals($expected, $result);
	}

	public function testFormClose()
	{
		$expected = '</form>';
		$result = $this->form->close();
		$this->assertEquals($expected, $result);
	}

	public function testCsrfToken()
	{
		$this->form->setToken('1234');
		$expected = '<input type="hidden" name="_token" value="1234">';
		$result = $this->form->token();
		$this->assertEquals($expected, $result);
	}

	public function testFormOpenPut()
	{
		$expected = '<form method="POST" action=""><input type="hidden" name="_method" value="PUT">';
		$result = $this->form->open()->put();
		$this->assertEquals($expected, $result);
	}

	public function testFormOpenDelete()
	{
		$expected = '<form method="POST" action=""><input type="hidden" name="_method" value="DELETE">';
		$result = $this->form->open()->delete();
		$this->assertEquals($expected, $result);
	}

	public function testRenderDateGroup()
	{
		$expected = '<div class="form-group"><label class="control-label" for="birthday">Birthday</label><input type="date" name="birthday" id="birthday" class="form-control"></div>';
		$result = $this->form->date('Birthday', 'birthday');
		$this->assertEquals($expected, $result);
	}

	public function testRenderEmailGroup()
	{
		$expected = '<div class="form-group"><label class="control-label" for="email">Email</label><input type="email" name="email" id="email" class="form-control"></div>';
		$result = $this->form->email('Email', 'email');
		$this->assertEquals($expected, $result);
	}

	public function testRenderFileGroup()
	{
		$expected = '<div class="form-group"><label class="control-label" for="file">File</label><input type="file" name="file" id="file"></div>';
		$result = $this->form->file('File', 'file');
		$this->assertEquals($expected, $result);
	}

	public function testRenderFileGroupWithError()
	{
		$errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
		$errorStore->shouldReceive('hasError')->andReturn(true);
		$errorStore->shouldReceive('getError')->andReturn('Sample error');

		$this->builder->setErrorStore($errorStore);
		$expected = '<div class="form-group has-error"><label class="control-label" for="file">File</label><input type="file" name="file" id="file"><p class="help-block">Sample error</p></div>';
		$result = $this->form->file('File', 'file');
		$this->assertEquals($expected, $result);
	}

	public function testCanAddClassToUnderlyingControl()
	{
		$expected = '<div class="form-group"><label class="control-label" for="color">Favorite Color</label><select name="color" id="color" class="form-control my-class"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div>';

		$options = array('1' => 'Red', '2' => 'Green', '3' => 'Blue');
		$result = $this->form->select('Favorite Color', 'color', $options)->addClass('my-class');
		$this->assertEquals($expected, $result);
	}

	public function testRenderTextGroupWithLabelClass()
	{
		$expected = '<div class="form-group"><label class="control-label required" for="email">Email</label><input type="text" name="email" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email')->labelClass('required');
		$this->assertEquals($expected, $result);
	}

	public function testBindObject()
	{
		$object = $this->getStubObject();
		$this->form->bind($object);
		$expected = '<div class="form-group"><label class="control-label" for="first_name">First Name</label><input type="text" name="first_name" value="John" id="first_name" class="form-control"></div>';
		$result = $this->form->text('First Name', 'first_name');
		$this->assertEquals($expected, $result);
	}


	public function testCanHideLabels()
	{
		$expected = '<div class="form-group"><label class="control-label sr-only" for="email">Email</label><input type="text" name="email" id="email" class="form-control"></div>';
		$result = $this->form->text('Email', 'email')->hideLabel();
		$this->assertEquals($expected, $result);
	}

	public function testRenderInputGroupWithBeforeAddon()
	{
		$expected = '<div class="form-group"><label class="control-label" for="username">Username</label><div class="input-group"><span class="input-group-addon">@</span><input type="text" name="username" id="username" class="form-control"></div></div>';
		$result = $this->form->inputGroup('Username', 'username')->beforeAddon('@');
		$this->assertEquals($expected, $result);
	}

	public function testRenderInputGroupWithAfterAddon()
	{
		$expected = '<div class="form-group"><label class="control-label" for="site">Site</label><div class="input-group"><input type="text" name="site" id="site" class="form-control"><span class="input-group-addon">.com.br</span></div></div>';
		$result = $this->form->inputGroup('Site', 'site')->afterAddon('.com.br');
		$this->assertEquals($expected, $result);
	}

	public function testRenderInputGroupChangeTypeWithBothAddon()
	{
		$expected = '<div class="form-group"><label class="control-label" for="secret">Secret</label><div class="input-group"><span class="input-group-addon">before</span><input type="password" name="secret" id="secret" class="form-control"><span class="input-group-addon">after</span></div></div>';
		$result = $this->form
			->inputGroup('Secret', 'secret')
			->type('password')
			->beforeAddon('before')
			->afterAddon('after');
		$this->assertEquals($expected, $result);
	}

	private function getStubObject()
	{
		$obj = new stdClass;
		$obj->email = 'johndoe@example.com';
		$obj->first_name = 'John';
		$obj->last_name = 'Doe';
		$obj->date_of_birth = new \DateTime('1985-05-06');
		$obj->gender = 'male';
		$obj->terms = 'agree';
		return $obj;
	}
}
