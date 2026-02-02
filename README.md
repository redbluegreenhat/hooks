## BlueSelene Hooks

A very simple and easy to use hooks library. You register your hooks, register your hook handlers, and go.

Written mostly for fun (and to have something that is easy to write PHPUnit tests for). MPL-2.0 licensed.

Requires at least PHP 8.3 (because that's the version I use and test with), but otherwise has no dependencies of its own.

### Usage

An example is probably best here.

```php

<?php

require 'vendor/autoload.php';

interface Foo {

	public function echo(string $world): void;
}

class Bar implements Foo {

	#[\Override]
	public function echo(string $world): void {
		echo 'Hello ' . $world . PHP_EOL;
	}
}

$hooks = new \BlueSelene\Hooks\Hooks();

/**
 * Name of the handler, what class should handlers extend or implement, method name, number of parameters
 */
$hooks->registerNewHook('test', Foo::class, 'echo', 1);


$hooks->registerHookHandler('test', new Bar());

/**
 * Name of the handler, followed by an arbitrary number of parameters, as long as they meet the number defined in Hooks::registerNewHook()
 * $result contains an array with the return values of all the handlers, in the order in which they were called (which happens to also be the order in which they are registered, from first to last)
 */
$result = $hooks->fireHook('test', 'world');

```