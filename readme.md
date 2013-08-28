BootForms
===============

BootForms is an extension of the Laravel 4 FormBuilder class designed to greatly simplify quick form generation with Bootstrap 3.

It's currently in it's early infancy, but I hope to add a lot of new features in the near future.

## Installing with Composer

BootForms will eventually be available via Packagist once the package is passed this very early alpha stage.

For now, you can install BootForms by first adding the repository to your `composer.json` file:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/adamwathan/bootforms"
        }
    ],
    "require": {
        "adam-wathan/boot-forms": "dev-master"
    }
}
```

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

## Using BootForms

Using BootForms is much like using the regular `Form` facade in Laravel 4, but it provides a little extra niceness specific to Bootstrap.

###Reduced Boilerplate

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

###Automatic Validation State

Another nice thing about BootForms is that it will automatically add error states and error messages to your controls if it sees an error for that control in the session.

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

###Horizontal Forms

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

## To Do

- Add support for select and radio elements
- Add inline form support
- Possibly add support for custom classes and other attributes. May muddy up syntax and defeat the purpose of the package though.