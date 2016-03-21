<?php

namespace OpenTracing;

use Psr\Log\AbstractLogger;

class SpanLogger extends AbstractLogger
{
    /**
     * @var Span
     */
    private $span;

    public function __construct(Span $span) {
        $this->span = $span;
    }
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $context['severity'] = $level;
        $this->span->log(microtime(true), $message, $context);
    }
}