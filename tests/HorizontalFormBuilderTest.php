<?php

use AdamWathan\BootForms\HorizontalFormBuilder;
use AdamWathan\Form\FormBuilder;

class HorizontalFormBuilderTest extends PHPUnit_Framework_TestCase
{
    private $form;
    private $builder;

    public function setUp()
    {
        $this->builder = new FormBuilder;
        $this->form = new HorizontalFormBuilder($this->builder);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testFormOpen()
    {
        $expected = '<form method="POST" action="" class="form-horizontal">';
        $result = $this->form->open()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenGet()
    {
        $expected = '<form method="GET" action="" class="form-horizontal">';
        $result = $this->form->open()->get()->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormOpenCustomAction()
    {
        $expected = '<form method="GET" action="/search" class="form-horizontal">';
        $result = $this->form->open()->get()->action('/search')->render();
        $this->assertEquals($expected, $result);
    }

    public function testFormClose()
    {
        $expected = '</form>';
        $result = $this->form->close();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroup()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithCustomWidths()
    {
        $this->form->setColumnSizes(['lg' => [3, 9]]);
        $expected = '<div class="form-group"><label class="col-lg-3 control-label" for="email">Email</label><div class="col-lg-9"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithMultipleBreakpointSizes()
    {
        $this->form->setColumnSizes(['xs' => [5, 7], 'lg' => [3, 9]]);
        $expected = '<div class="form-group"><label class="col-xs-5 col-lg-3 control-label" for="email">Email</label><div class="col-xs-7 col-lg-9"><input type="text" name="email" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithValue()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" value="example@example.com"></div></div>';
        $result = $this->form->text('Email', 'email')->value('example@example.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithAttribute()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" maxlength="50"></div></div>';
        $result = $this->form->text('Email', 'email')->attribute('maxlength', '50')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Email is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control"><p class="help-block">Email is required.</p></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithOldInputAndDefaultValue()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('example@example.com');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control"></div></div>';
        $result = $this->form->text('Email', 'email')->defaultValue('test@test.com')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextGroupWithDefaultValue()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" id="email" class="form-control" value="test@test.com"></div></div>';
        $result = $this->form->text('Email', 'email')->defaultValue('test@test.com')->render();
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

        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="email">Email</label><div class="col-lg-10"><input type="text" name="email" value="example@example.com" id="email" class="form-control"><p class="help-block">Email is required.</p></div></div>';
        $result = $this->form->text('Email', 'email')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroup()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control"></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupDoesntKeepOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('password');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control"></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderPasswordGroupWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Password is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="password">Password</label><div class="col-lg-10"><input type="password" name="password" id="password" class="form-control"><p class="help-block">Password is required.</p></div></div>';
        $result = $this->form->password('Password', 'password')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButton()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><button type="button" class="btn btn-default">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithCustomColumnSizes()
    {
        $this->form->setColumnSizes(['lg' => [3, 9]]);
        $expected = '<div class="form-group"><div class="col-lg-offset-3 col-lg-9"><button type="button" class="btn btn-default">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderButtonWithMultipleBreakpointSizes()
    {
        $this->form->setColumnSizes(['xs' => [5, 7], 'lg' => [3, 9]]);
        $expected = '<div class="form-group"><div class="col-xs-offset-5 col-xs-7 col-lg-offset-3 col-lg-9"><button type="button" class="btn btn-default">Click Me</button></div></div>';
        $result = $this->form->button('Click Me')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSubmit()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><button type="submit" class="btn btn-default">Submit</button></div></div>';
        $result = $this->form->submit()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckbox()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="checkbox"><label><input type="checkbox" name="terms" value="1">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Must agree to terms.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="has-error checkbox"><label><input type="checkbox" name="terms" value="1">Agree to Terms</label><p class="help-block">Must agree to terms.</p></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('1');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="checkbox"><label><input type="checkbox" name="terms" value="1" checked="checked">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxChecked()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="checkbox"><label><input type="checkbox" name="terms" value="1" checked="checked">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->check()->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxWithAdditionalAttributes()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="checkbox"><label><input type="checkbox" name="terms" value="1" data-foo="bar">Agree to Terms</label></div></div></div>';
        $result = $this->form->checkbox('Agree to Terms', 'terms')->attribute('data-foo', 'bar')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadio()
    {
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="radio"><label><input type="radio" name="color" value="red">Red</label></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="has-error radio"><label><input type="radio" name="color" value="red">Red</label><p class="help-block">Sample error</p></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioWithOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('red');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><div class="col-lg-offset-2 col-lg-10"><div class="radio"><label><input type="radio" name="color" value="red" checked="checked">Red</label></div></div></div>';
        $result = $this->form->radio('Red', 'color', 'red')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextarea()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithRows()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="5" cols="50" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->rows(5)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithCols()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="20" id="bio" class="form-control"></textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->cols(20)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('Sample bio');

        $this->builder->setOldInputProvider($oldInput);
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control">Sample bio</textarea></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderTextareaWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="bio">Bio</label><div class="col-lg-10"><textarea name="bio" rows="10" cols="50" id="bio" class="form-control"></textarea><p class="help-block">Sample error</p></div></div>';
        $result = $this->form->textarea('Bio', 'bio')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelect()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select></div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Color is required.');

        $this->builder->setErrorStore($errorStore);

        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2">Green</option><option value="3">Blue</option></select><p class="help-block">Color is required.</p></div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderSelectWithOldInput()
    {
        $oldInput = Mockery::mock('AdamWathan\Form\OldInput\OldInputInterface');
        $oldInput->shouldReceive('hasOldInput')->andReturn(true);
        $oldInput->shouldReceive('getOldInput')->andReturn('2');

        $this->builder->setOldInputProvider($oldInput);

        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="color">Favorite Color</label><div class="col-lg-10"><select name="color" id="color" class="form-control"><option value="1">Red</option><option value="2" selected>Green</option><option value="3">Blue</option></select></div></div>';

        $options = ['1' => 'Red', '2' => 'Green', '3' => 'Blue'];
        $result = $this->form->select('Favorite Color', 'color', $options)->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderDateGroup()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="birthday">Birthday</label><div class="col-lg-10"><input type="date" name="birthday" id="birthday" class="form-control"></div></div>';
        $result = $this->form->date('Birthday', 'birthday')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroup()
    {
        $expected = '<div class="form-group"><label class="col-lg-2 control-label" for="file">File</label><div class="col-lg-10"><input type="file" name="file" id="file"></div></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }

    public function testRenderFileGroupWithError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->andReturn('Sample error');

        $this->builder->setErrorStore($errorStore);
        $expected = '<div class="form-group has-error"><label class="col-lg-2 control-label" for="file">File</label><div class="col-lg-10"><input type="file" name="file" id="file"><p class="help-block">Sample error</p></div></div>';
        $result = $this->form->file('File', 'file')->render();
        $this->assertEquals($expected, $result);
    }
}
