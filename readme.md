# Prologue Phpconsole

Prologue Alerts is a package that handles global site messages.

I first got the idea for creating this package after [a blog post](http://toddish.co.uk/blog/global-site-messages-in-laravel-4/) I read by [Todd Francis](http://toddish.co.uk/). This package uses much of the concepts of his blog post as well as the concept of alert levels which [Illuminate's Log package](https://github.com/illuminate/log) uses.

Maintained by [Dries Vints](https://github.com/driesvints)  
[@driesvints](https://twitter.com/driesvints)  
[driesvints.com](http://driesvints.com)  

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
	- [Adding Alerts](#adding-alerts)
	- [Adding Alerts Through Alert Levels](#adding-alerts-through-alert-levels)
	- [Flashing Alerts To The Session](#flashing-alerts-to-the-session)
	- [Displaying Alerts](#displaying-alerts)
- [Changelog](#changelog)
- [License](#license)

## Installation

You can install the package for your Laravel 4 project through Composer.

Require the package in your `composer.json`.

```
"prologue/alerts": "dev-master"
```

Run composer to install or update the package.

```bash
$ composer update
```

Register the service provider in `app/config/app.php`.

```php
'Prologue\Alerts\AlertsServiceProvider',
```

Add the alias to the list of aliases in `app/config/app.php`.

```php
'Alert' => 'Prologue\Alerts\Facades\Alert',
```

## Configuration

The packages provides you with some configuration options.

To create the configuration file run this command in your command line app:

```bash
$ php artisan config:publish prologue/alerts
```

The configuration file will be published here: `app/config/packages/prologue/alerts/config.php`.

## Usage

### Adding Alerts

Since the main `AlertsMessageBag` class which powers the package is just an extension of Illuminate's `MessageBag` class we can leverage its functionality to easily add messages.

```php
Alerts::add('error', 'Error message');
```

### Adding Alerts Through Alert Levels

By default, the package has some alert levels defined in its configuration file. The default levels are `success`, `error`, `warning` and `info`. The `AlertsMessageBag` check if you call one of these levels as a function and registers your alert which you provided with the correct key.

This makes adding alerts for certain alert types very easy:

```php
Alert::info('This is an info message.');
Alert::error('Whoops, something has gone wrong.');
```

You can of course add your own alert levels by adding them to your own config file. [See above](#configuration) on how to publish the config file.

### Flashing Alerts To The Session

At some times you want to remember alerts when you're, for example, redirecting to another route. This can be done by calling the `flash` method. The `AlertsMessageBag` class will put the current set alerts into the current session which can then be used after the redirect.

```php
// Add some alerts and flash them to the session.
Alert::success('You have successfully logged in')->flash();

// Redirect to the admin dashboard.
return Redirect::to('dashboard');

// Display the alerts in the admin dashboard view.
return View::make('dashboard')->with('alerts', Alert::all());
```

### Displaying Alerts

Remember that the `AlertsMessageBag` class is just an extension of Illuminate's `MessageBag` class, which means we can use all of its functionality to display messages.

```php
@foreach (Alert::all() as $alert)
	{{ $alert }}
@endif
```

Or if you'd like to display a single alert for a certain alert level.

```php
@if (Alert::has('success'))
	{{ Alert::first('success') }}
@endif
```

If you'd like to learn more ways on how you can display messages, please [take a closer look to Illuminate's `MessageBag` class](https://github.com/illuminate/support/blob/master/MessageBag.php).

## Changelog

You view the changelog for this package [here](https://github.com/Prologue/Alerts/blob/master/changelog.md).

## License

Prologue Alerts is licensed under the [MIT License](https://github.com/Prologue/Alerts/blob/master/license.md).