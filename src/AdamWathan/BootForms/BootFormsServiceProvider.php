<?php namespace AdamWathan\BootForms;

use AdamWathan\Form\ErrorStore\IlluminateErrorStore;
use AdamWathan\Form\FormBuilder;
use AdamWathan\Form\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;

class BootFormsServiceProvider extends ServiceProvider
{

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
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
        $this->registerBasicFormBuilder();
        $this->registerHorizontalFormBuilder();
        $this->registerBootForm();
    }

    protected function registerErrorStore()
    {
        $this->app['adamwathan.form.errorstore'] = $this->app->share(function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput()
    {
        $this->app['adamwathan.form.oldinput'] = $this->app->share(function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app['adamwathan.form'] = $this->app->share(function ($app) {
            $formBuilder = new FormBuilder;
            $formBuilder->setErrorStore($app['adamwathan.form.errorstore']);
            $formBuilder->setOldInputProvider($app['adamwathan.form.oldinput']);
            $formBuilder->setToken($app['session.store']->getToken());

            return $formBuilder;
        });
    }

    protected function registerBasicFormBuilder()
    {
        $this->app['bootform.basic'] = $this->app->share(function ($app) {
            return new BasicFormBuilder($app['adamwathan.form']);
        });
    }

    protected function registerHorizontalFormBuilder()
    {
        $this->app['bootform.horizontal'] = $this->app->share(function ($app) {
            return new HorizontalFormBuilder($app['adamwathan.form']);
        });
    }

    protected function registerBootForm()
    {
        $this->app['bootform'] = $this->app->share(function ($app) {
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
        return ['bootform'];
    }
}
