<?php

namespace OpenTracing\Exception;

use InvalidArgumentException;

class InvalidCarrierException extends InvalidArgumentException implements OpenTracingException
{
}
