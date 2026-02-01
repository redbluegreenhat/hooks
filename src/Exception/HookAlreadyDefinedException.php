<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when an attempt is made to define a hook twice
 */
final class HookAlreadyDefinedException extends HooksBaseException {}