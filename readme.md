# Alerts for Laravel 5, 6 and 7

[![Build Status](https://img.shields.io/travis/prologuephp/alerts/master.svg?style=flat-square)](https://travis-ci.org/prologuephp/alerts)
[![Quality Score](https://img.shields.io/scrutinizer/g/prologuephp/alerts.svg?style=flat-square)](https://scrutinizer-ci.com/g/prologuephp/alerts)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](license.md)
[![Packagist Version](https://img.shields.io/packagist/v/prologue/alerts.svg?style=flat-square)](https://packagist.org/packages/prologue/alerts)
[![Total Downloads](https://img.shields.io/packagist/dt/prologue/lock.svg?style=flat-square)](https://packagist.org/packages/prologue/alerts)

Global site messages in Laravel 7, 6 and 5. Helps trigger notification bubbles with a simple API, both in the current page, and in the next page (using flash data).

Created by [Dries Vints](https://github.com/driesvints) - he first got the idea after [a blog post](http://toddish.co.uk/blog/global-site-messages-in-laravel-4/) by [Todd Francis](http://toddish.co.uk/). This package uses much of the concepts of his blog post as well as the concept of alert levels which [Illuminate's Log package](https://github.com/illuminate/log) uses. Maintained by [Cristian Tabacitu](https://github.com/tabacitu) thanks to its use in [Backpack for Laravel](http://backpackforlaravel.com/).

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

You can install the package for your Laravel 6 project through Composer.

```bash
$ composer require prologue/alerts
```

For Laravel 5.4 and below, register the service provider in `app/config/app.php`.

```php
'Prologue\Alerts\AlertsServiceProvider',
```

Add the alias to the list of aliases in `app/config/app.php`.

```php
'Alert' => 'Prologue\Alerts\Facades\Alert',
```

## Configuration

The packages provides you with some configuration options.

To create the configuration file, run this command in your command line app:

```bash
$ php artisan vendor:publish --provider="Prologue\Alerts\AlertsServiceProvider"
```

The configuration file will be published here: `config/prologue/alerts.php`.

## Usage

### Adding Alerts

Since the main `AlertsMessageBag` class which powers the package is an extension of Illuminate's `MessageBag` class, we can leverage its functionality to easily add messages.

```php
Alert::add('error', 'Error message');
```

### Adding Alerts Through Alert Levels

By default, the package has some alert levels defined in its configuration file. The default levels are `success`, `error`, `warning` and `info`. The `AlertsMessageBag` checks if you call one of these levels as a function and registers your alert which you provided with the correct key.

This makes adding alerts for certain alert types very easy:

```php
Alert::info('This is an info message.');
Alert::error('Whoops, something has gone wrong.');
```

You can of course add your own alert levels by adding them to your own config file. [See above](#configuration) on how to publish the config file.

### Flashing Alerts To The Session

Sometimes you want to remember alerts when you're, for example, redirecting to another route. This can be done by calling the `flash` method. The `AlertsMessageBag` class will put the current set alerts into the current session which can then be used after the redirect.

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
@endforeach
```

Or if you'd like to display a single alert for a certain alert level.

```php
@if (Alert::has('success'))
    {{ Alert::first('success') }}
@endif
```

Display all messages for each alert level:

```php
@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert alert-{{ $type }}">{{ $message }}</div>
    @endforeach
@endforeach
```

Doing something if there are any messages:

```php
@if (Alert::count())
    show this
@endif
```

Checking or showing the error count:
```php
@if (Alert::count('error'))
    There are {{ Alert::count('error') }} errors.
@endif
```

If you'd like to learn more ways on how you can display messages, please [take a closer look to Illuminate's `MessageBag` class](https://github.com/illuminate/support/blob/master/MessageBag.php).

## Changelog

You view the changelog for this package [here](changelog.md).

## License

Prologue Alerts is licensed under the [MIT License](license.md).
