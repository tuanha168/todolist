<?php

namespace Laravel\Ui;

class AuthRouteMethods
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return callable
     */
    public function auth()
    {
        return function ($options = []) {
            $namespace = class_exists($this->prependGroupNamespace('Auth\LoginController')) ? null : 'App\Http\Controllers';

            $this->group(['namespace' => $namespace], function () use ($options) {
                // Login Routes...
                if ($options['login'] ?? true) {
                    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
                    $this->post('login', 'Auth\LoginController@login');
                }

                // Logout Routes...
                if ($options['logout'] ?? true) {
                    $this->post('logout', 'Auth\LoginController@logout')->name('logout');
                }

                // Registration Routes...
                if ($options['register'] ?? true) {
                    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
                    $this->post('register', 'Auth\RegisterController@register');
                }
            });
        };
    }

    /**
     * Register the typical confirm password routes for an application.
     *
     * @return callable
     */
    public function confirmPassword()
    {
        return function () {
            $this->get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
            $this->post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
        };
    }
}
