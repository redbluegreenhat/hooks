<?php

namespace BlueSelene\Hooks\Exception;

use \BlueSelene\Hooks\Exception\HooksBaseException;

/**
 * Thrown when the wrong number of parameters is given when firing a hook
 */
class IncorrectNumberOfParametersException extends HooksBaseException {}