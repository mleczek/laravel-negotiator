<?php


namespace Mleczek\Negotiator;


use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Mleczek\Negotiator\Contracts\ContentNegotiationHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ContentNegotiation
{
    const UNSUPPORTED_TYPE_CODE = 415;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var ContentNegotiationHandler[]
     */
    protected $handlers = [
        // 'application/json' => new JsonHandler(),
    ];

    /**
     * ContentNegotiation constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
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
     * @param array $values Const values for specific types, eq. ['application/xml' => '<const/>']
     * @return mixed
     */
    public function negotiate(Request $request, $data, array $values = [])
    {
        // Const values for specific types
        $type = $request->prefers(array_keys($values));
        if (key_exists($type, $values)) {
            return $values[$type];
        }

        // Automatic conversion using defined handlers
        $type = $request->prefers($this->contentTypes());
        if(!key_exists($type, $this->handlers)) {
            throw new HttpException(self::UNSUPPORTED_TYPE_CODE, 'Cannot return response in specified format, use/change the "Accepts" header.');
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
        $handler = $this->container->call($closure, [$this->container]);

        foreach($contentTypes as $type) {
            $this->handlers[$type] = $handler;
        }
    }
}