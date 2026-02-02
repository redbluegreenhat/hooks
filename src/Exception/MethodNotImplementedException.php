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
 * Thrown when a hook handler does not implement that hook's required method
 */

final class MethodNotImplementedException extends HooksBaseException {}