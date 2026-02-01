<?php declare(strict_types=1);

use \PHPUnit\Framework\TestCase;
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
}