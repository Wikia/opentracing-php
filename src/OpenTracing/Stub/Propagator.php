<?php

namespace OpenTracing\Stub;

use OpenTracing;
use OpenTracing\Injector;
use OpenTracing\Extractor;

class Propagator implements Injector, Extractor
{
    private $tracer = null;
    private $noopSpan = null;

    public function __construct(Tracer $tracer, Span $noopSpan)
    {
        $this->tracer = $tracer;
        $this->noopSpan = $noopSpan;
    }

    public function injectSpan(OpenTracing\Span $span, &$carrier)
    {
        // noop
    }

    public function joinTrace($operationName, &$carrier)
    {
        return $this->noopSpan;
    }
}