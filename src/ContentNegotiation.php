<?php


namespace Mleczek\Negotiator;


use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Mleczek\Negotiator\Contracts\ContentNegotiationHandler;

class ContentNegotiation
{
    protected $app;

    /**
     * @var ContentNegotiationHandler[]
     */
    protected $handlers = [
        // 'application/json' => new JsonHandler(),
    ];

    /**
     * ContentNegotiation constructor.
     *
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Get list of supported content types.
     *
     * @return string[]
     */
    public function contentTypes()
    {
        return array_keys($this->handlers);
    }

    /**
     * Get $data in most suitable format
     * (negotiated via "Accepts" header).
     *
     * @param Request $request
     * @param mixed $data
     * @return mixed
     */
    public function negotiate(Request $request, $data)
    {
        $type = $request->prefers($this->contentTypes());
        if(is_null($type)) {
            // TODO: Throw exception (content type not supported)
        }

        return $this->handlers[$type]->handle($data);
    }

    /**
     * Set handler to run for specific content types.
     *
     * @param string|string[] $contentTypes
     * @param Closure $closure
     */
    public function extend($contentTypes, Closure $closure)
    {
        $contentTypes = (array) $contentTypes;
        $handler = $closure->call($this, $this->app);

        foreach($contentTypes as $type) {
            $this->handlers[$type] = $handler;
        }
    }
}