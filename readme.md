BootForms
===============

BootForms builds on top of my more general [Form](https://github.com/adamwathan/form) package by adding another layer of abstraction to rapidly generate markup for standard Bootstrap 3 forms. Probably not perfect for your super custom branded ready-for-release apps, but a *huge* time saver when you are still in the prototyping stage!

## Installing with Composer

You can install this package via Composer by including the following in your `composer.json`:

```json
{
    "require": {
        "adamwathan/bootforms": "v0.2"
    }
}
```

*Note: you could also require `dev-master` to test the latest version, but make sure you drop your `minimum-stability` to `dev`.*

### Laravel 4

If you are using Laravel 4, you can get started very quickly by registering the included service provider.

Modify the `providers` array in `app/config/app.php` to include the `BootFormsServiceProvider`:

```php
'providers' => array(
		//...
		'AdamWathan\BootForms\BootFormsServiceProvider'
	),
```

Add the `BootForm` facade to the `aliases` array in `app/config/app.php`:

```php
'aliases' => array(
		//...
		'BootForm' => 'AdamWathan\BootForms\Facades\BootForm'
	),
```

You can now start using BootForms by calling methods directly on the `BootForm` facade:

```php
BootForm::text('Email', 'email');
```

### Outside of Laravel 4

Usage outside of Laravel 4 is a little trickier since there's a bit of a dependency stack you need to build up, but it's not too tricky.

```php
$formBuilder = new AdamWathan\Form\FormBuilder;

$formBuilder->setOldInputProvider($myOldInputProvider);
$formBuilder->setErrorStore($myErrorStore);
$formBuilder->setToken($myCsrfToken);

$basicBootFormsBuilder = new AdamWathan\BootForms\BasicFormBuilder($formBuilder);
$horizontalBootFormsBuilder = new AdamWathan\BootForms\HorizontalFormBuilder($formBuilder);

$bootForm = new AdamWathan\BootForms\BootForm($basicBootFormsBuilder, $horizontalBootFormsBuilder);
```

> Note: You must provide your own implementations of `AdamWathan\Form\OldInputInterface` and `AdamWathan\Form\ErrorStoreInterface` when not using the implementations meant for Laravel 4.

## Using BootForms

### Reduced Boilerplate

Typical Bootstrap form boilerplate might look something like this:

```html
<form>
  <div class="form-group">
    <label class="control_label" for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name">
  </div>
  <div class="form-group">
    <label class="control_label" for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name">
  </div>
  <div class="form-group">
    <label class="control_label" for="date_of_birth">Date of Birth</label>
    <input type="date" class="form-control" id="date_of_birth">
  </div>
  <div class="form-group">
    <label class="control_label" for="email">Email address</label>
    <input type="email" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label class="control_label" for="password">Password</label>
    <input type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
```

Using the Laravel 4 `FormBuilder`, you would normally be able to get that down to this:

```php
{{ Form::open() }}
  <div class="form-group">
    {{ Form::label('first_name', 'First Name', array('class' => 'control_label')) }}
    {{ Form::text('first_name', null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    {{ Form::label('last_name', 'Last Name', array('class' => 'control_label')) }}
    {{ Form::text('last_name', null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    {{ Form::label('date_of_birth', 'Date of Birth', array('class' => 'control_label')) }}
    {{ Form::text('date_of_birth', null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    {{ Form::label('email', 'Email', array('class' => 'control_label')) }}
    {{ Form::email('email', null, array('class' => 'form-control')) }}
  </div>
  <div class="form-group">
    {{ Form::label('password', 'Password', array('class' => 'control_label')) }}
    {{ Form::password('password', array('class' => 'form-control')) }}
  </div>
  {{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
{{ Form::close() }}
```

BootForms makes a few decisions for you and allows you to pare it down a bit more:

```php
{{ BootForm::open() }}
	{{ BootForm::text('First Name', 'first_name') }}
	{{ BootForm::text('Last Name', 'last_name') }}
	{{ BootForm::text('Date of Birth', 'date_of_birth') }}
	{{ BootForm::email('Email', 'email') }}
	{{ BootForm::password('Password', 'password') }}
	{{ BootForm::submit('Submit') }}
{{ BootForm::close() }}
```

### Automatic Validation State

Another nice thing about BootForms is that it will automatically add error states and error messages to your controls if it sees an error for that control in the error store.

Essentially, this takes code that would normally look like this:

```php
<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
	<label class="control_label" for="first_name">First Name</label>
	<input type="text" class="form-control" id="first_name">
  {{ $errors->first('first_name', '<p class="help-block">:message</p>') }}
</div>
```

And reduces it to this:

```php
{{ BootForm::text('First Name', 'first_name') }}
```

...with the `has-error` class being added automatically if there is an error in the session.

### Horizontal Forms

To use a horizontal form instead of the standard basic form, simply swap the `BootForm::open()` call:

```php

// Width in columns of the left and right side
$labelWidth = 2;
$controlWidth = 10;

{{ BootForm::openHorizontal($labelWidth, $controlWidth) }}
  {{ BootForm::text('First Name', 'first_name') }}
  {{ BootForm::text('Last Name', 'last_name') }}
  {{ BootForm::text('Date of Birth', 'date_of_birth') }}
  {{ BootForm::email('Email', 'email') }}
  {{ BootForm::password('Password', 'password') }}
  {{ BootForm::submit('Submit') }}
{{ BootForm::close() }}
```

### Customizing Form Elements

If you need to customize your form elements in any way (such as adding a default value or placeholder to a text element), simply chain the calls you need to make and they will fall through to the underlying form element:

```php
// <div class="form-group">
//    <label class="control_label" for="first_name">First Name</label>
//    <input type="text" class="form-control" id="first_name" placeholder="John Doe">
// </div>
BootForm::text('First Name', 'first_name')->placeholder('John Doe');
```

For more information about what's possible, check out the documentation for [my basic Form package.](https://github.com/adamwathan/form)
