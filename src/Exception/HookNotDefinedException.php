<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when an attempt is made to add a hook handler for a hook that does not exist
 */
class HookNotDefinedException extends HooksBaseException {}