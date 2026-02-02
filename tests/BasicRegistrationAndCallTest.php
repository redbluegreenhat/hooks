<?php declare(strict_types=1);

require_once 'InterfaceFoo.php';
require_once 'ClassBar.php';

use \PHPUnit\Framework\TestCase;
use \BlueSelene\Hooks\Exception\HookAlreadyDefinedException;
use \BlueSelene\Hooks\Exception\HookHandlerWrongSubclassException;
use \BlueSelene\Hooks\Exception\HookNotDefinedException;
use \BlueSelene\Hooks\Exception\IncorrectNumberOfParametersException;
use \BlueSelene\Hooks\Exception\MethodNotImplementedException;
use \BlueSelene\Hooks\Hooks;

final class BasicRegistrationAndCallTest extends TestCase {
	public function testBasicRegistrationAndCall(): void {
		$hook = new Hooks();
		$handler = new class {
			public function echo(string $world): int {
				return 20;
			}
		};
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
		$result = $hook->fireHook('test', 'world');
		$this->assertSame($result[0], 20);
	}

	public function testBasicRegistrationAndCallWithInterfaces(): void{
		$hook = new Hooks();
		$handler = new Bar();
		$hook->registerNewHook('test', Foo::class, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
		$result = $hook->fireHook('test', 'world');
		$this->assertSame($result[0], 20);
	}

	public function testExceptionThrownOnUndefinedHooks(): void  {
		$this->expectException(HookNotDefinedException::class);
		$hook = new Hooks();
		$handler = new class {
			public function echoInvalid(string $world): int {
				return 20;
			}
		};
		$hook->registerHookHandler('test', $handler);
	}

	public function testExceptionThrownWhenDefiningHooksTwice(): void {
		$this->expectException(HookAlreadyDefinedException::class);
		$hook = new Hooks();
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerNewHook('test', null, 'echo', 1);
	}

	public function testExceptionThrownOnClassWithNoHandlerMethod(): void {
		$this->expectException(MethodNotImplementedException::class);
		$hook = new Hooks();
		$handler = new class {
			public function echoInvalid(string $world): int {
				return 20;
			}
		};
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
	}

	public function testExceptionThrownOnTooFewParametersOnCall(): void {
		$this->expectException(IncorrectNumberOfParametersException::class);
		$hook = new Hooks();
		$handler = new class {
			public function echo(string $world): int {
				return 20;
			}
		};
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
		$hook->fireHook('test');
	}

	public function testExceptionThrownOnTooManyParametersOnCall(): void {
		$this->expectException(IncorrectNumberOfParametersException::class);
		$hook = new Hooks();
		$handler = new class {
			public function echo(string $world): int {
				return 20;
			}
		};
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
		$hook->fireHook('test', 'world', 'too many');
	}

	public function testExceptionThrownOnWrongSubclassHandler(): void {
		$this->expectException(HookHandlerWrongSubclassException::class);
		$hook = new Hooks();
		$handler = new class {
			public function echo(string $world): int {
				return 20;
			}
		};
		$hook->registerNewHook('test', Foo::class, 'echo', 1);
		$hook->registerHookHandler('test', $handler);
	}

	public function testCallOrderIsRegistrationOrder(): void {
		$hook = new Hooks();
		$handler1 = new class {
			public function echo(string $world): int {
				return 20;
			}
		};
		$handler2 = new class {
			public function echo(string $world): int {
				return 30;
			}
		};
		$hook->registerNewHook('test', null, 'echo', 1);
		$hook->registerHookHandler('test', $handler1);
		$hook->registerHookHandler('test', $handler2);
		$result = $hook->fireHook('test', 'world');
		$this->assertSame($result[1], 30);
		$this->assertSame($result[0], 20);
	}
}