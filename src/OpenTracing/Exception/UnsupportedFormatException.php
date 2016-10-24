<?php

namespace OpenTracing\Exception;

use InvalidArgumentException;

class UnsupportedFormatException extends InvalidArgumentException implements OpenTracingException
{
}
