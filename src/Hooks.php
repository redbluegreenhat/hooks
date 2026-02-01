<?php
/**
 * SPDX-License-Identifier: MPL-2.0
 * Copyright 2026 Alex <alex@blueselene.com>
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public License, v. 2.0. If a copy of the MPL was not distributed with this file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

namespace BlueSelene\Hooks;

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
	 * @param int $parameters Number of parameters that will be passed when firing this hook
	 * @return void
	 */
	public function registerNewHook(string $hookName, ?string $requiredClass, string $methodName, int $parameters): void {
		if (isset($this->hooks[$hookName])) {
			throw new \Exception('Hook already declared!');
		}
		$this->hooks[$hookName] = [
			'requiredClass' => $requiredClass,
			'methodName' => $methodName,
			'parameters' => $parameters,
			'handlers' => [],
		];
		return;
	}

	public function registerHookHandler(string $hookName, object $hookHandler): void {
		if (!isset($this->hooks[$hookName])) {
			throw new \Exception('Hook not declared!');
		}
		if (!is_null($this->hooks[$hookName]['requiredClass'])) {
			if (!is_subclass_of($hookHandler, $this->hooks[$hookName]['requiredClass'])) {
				throw new \Exception('Hook handler does not implement the required class');
			}
		}
		$this->hooks[$hookName]['requiredClass']['handlers'][] = $hookHandler;
	}
}