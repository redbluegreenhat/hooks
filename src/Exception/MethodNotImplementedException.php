<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when a hook handler does not implement that hook's required method
 */

class MethodNotImplementedException extends HooksBaseException {}