<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when a hook that required handlers to be a subclass of X do not implement or extend X
 */

final class HookHandlerWrongSubclassException extends HooksBaseException {}