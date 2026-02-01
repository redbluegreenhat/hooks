<?php
/**
 * SPDX-License-Identifier: MPL-2.0
 * Copyright 2026 Alex <alex@blueselene.com>
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public License, v. 2.0. If a copy of the MPL was not distributed with this file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

namespace BlueSelene\Hooks;

use \BlueSelene\Hooks\Exception\HookAlreadyDefinedException;
use \BlueSelene\Hooks\Exception\HookHandlerWrongSubclassException;
use \BlueSelene\Hooks\Exception\HookNotDefinedException;
use \BlueSelene\Hooks\Exception\IncorrectNumberOfParametersException

/**
 * The Hooks class. Registers hooks, allows specifying an interface or class that hook handlers should implement/extend for any specific hooks, and allows you to fire those hooks at any moment.
 */
class Hooks {

	private array $hooks = []; 

	public function __construct() {}

	/**
	 * Registers a new hook
	 * 
	 * @param string $hookName the name for the hook, must be unique
	 * @param ?string $requiredClass A class that hook handlers for this hook will be checked for using the is_subclass_of() function, this check is skipped if null
	 * @param string $methodName The method of hook handlers that will be called when fired
	 * @param int $parameters Number of parameters that will be required when firing this hook
	 * @return void
	 */
	public function registerNewHook(string $hookName, ?string $requiredClass, string $methodName, int $parameters): void {
		if (isset($this->hooks[$hookName])) {
			throw new HookAlreadyDefinedException("Hook {$hookName} is already defined");
		}
		$this->hooks[$hookName] = [
			'requiredClass' => $requiredClass,
			'methodName' => $methodName,
			'parameters' => $parameters,
			'handlers' => [],
		];
		return;
	}

	/**
	 * Registers a hook handler for a previously-defined hook
	 * 
	 * @param string $hookName The hook in question
	 * @param object $hookHandler The hook handler
	 * @return void
	 */
	public function registerHookHandler(string $hookName, object $hookHandler): void {
		if (!isset($this->hooks[$hookName])) {
			throw new HookNotDefinedException("Hook {$hookName} is undefined. Did you miss a call to Hooks::registerNewHook somewhere?");
		}
		if (!is_null($this->hooks[$hookName]['requiredClass'])) {
			if (!is_subclass_of($hookHandler, $this->hooks[$hookName]['requiredClass'])) {
				throw new HookHandlerWrongSubclassException('Hook handler is not a subclass of a required class');
			}
		}
		$this->hooks[$hookName]['handlers'][] = $hookHandler;
	}

	/**
	 * Fires a hook, calling all the handlers
	 * @param string $hookName The hook in question
	 * @param mixed ...$params An arbitrary number of hook parameters
	 * @return array<mixed> The values returned by all the hook handlers, in order from when they were called. Empty array if there are no hook handlers
	 */
	public function fireHook(string $hookName, ...$params): array {
		if (!isset($this->hooks[$hookName])) {
			throw new HookNotDefinedException("Hook {$hookName} is undefined. Did you miss a call to Hooks::registerNewHook somewhere?");
		}
		if (count($params) !== $this->hooks[$hookName]['parameters']) {
			throw new IncorrectNumberOfParametersException('Incorrect number of parameters for hook');
		}
		$returnArray = [];
		$methodName = $this->hooks[$hookName]['methodName'];
		foreach ($this->hooks[$hookName]['handlers'] as $handler) {
			$returnArray[] = $handler->$methodName(...$params);
		}
		return $returnArray;
	}
}