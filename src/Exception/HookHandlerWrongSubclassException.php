<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exceptions\HooksBaseException;

/**
 * Thrown when a hook that required handlers to be a subclass of X do not implement or extend X
 */

class HookHandlerWrongSubclassException extends HooksBaseException {}