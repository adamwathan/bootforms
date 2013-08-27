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
		$this->app['bootform'] = $this->app->share(function($app)
		{
			$form = new BootFormBuilder($app['html'], $app['url'], $app['session']->getToken());

			return $form->setSessionStore($app['session']);
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