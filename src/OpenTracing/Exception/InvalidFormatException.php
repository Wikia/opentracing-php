<?php

namespace OpenTracing\Exception;

use InvalidArgumentException;

class InvalidFormatException extends InvalidArgumentException implements OpenTracingException
{
}
