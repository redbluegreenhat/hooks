<?php
/**
 * SPDX-License-Identifier: MPL-2.0
 * Copyright 2026 Alex <alex@blueselene.com>
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public License, v. 2.0. If a copy of the MPL was not distributed with this file, You can obtain one at https://mozilla.org/MPL/2.0/.
 */

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when an attempt is made to define a hook twice
 */
final class HookAlreadyDefinedException extends HooksBaseException {}