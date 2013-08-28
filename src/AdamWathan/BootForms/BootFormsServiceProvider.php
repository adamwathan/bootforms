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
		//
		$this->registerBasicFormBuilder();
		$this->registerBootForm();
	}

	// this should extend formbuilder instead of bootformbuilder
	protected function registerBasicFormBuilder()
	{
		$this->app['bootform.basic'] = $this->app->share(function($app)
		{
			$builder = new BasicFormBuilder($app['html'], $app['url'], $app['session']->getToken());

			return $builder->setSessionStore($app['session']);
		});
	}

	// this should have the real generators injected
	protected function registerBootForm()
	{
		$this->app['bootform'] = $this->app->share(function($app)
		{
			return new BootForm($app['bootform.basic']);
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