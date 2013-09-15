<?php namespace AdamWathan\BootForms;

use Illuminate\Support\ServiceProvider;

class BootFormsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBasicFormBuilder();
		$this->registerHorizontalFormBuilder();
		$this->registerBootForm();
	}

	protected function registerBasicFormBuilder()
	{
		$this->app['bootform.basic'] = $this->app->share(function($app)
		{
			return new BasicFormBuilder($app['adamwathan.form']);
		});
	}

	protected function registerHorizontalFormBuilder()
	{
		$this->app['bootform.horizontal'] = $this->app->share(function($app)
		{
			return new HorizontalFormBuilder($app['adamwathan.form']);
		});
	}

	protected function registerBootForm()
	{
		$this->app['bootform'] = $this->app->share(function($app)
		{
			return new BootForm($app['bootform.basic'], $app['bootform.horizontal']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('bootform');
	}

}