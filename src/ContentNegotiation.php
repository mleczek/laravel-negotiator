<?php


namespace Mleczek\Negotiator;


use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @var ResponseFactory
     */
    protected $response;

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
    public function __construct(Container $container, ResponseFactory $response)
    {
        $this->container = $container;
        $this->response = $response;
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
     * @return Response
     */
    public function negotiate(Request $request, $data, array $values = [])
    {
        $availableTypes = array_keys($values) + $this->contentTypes();
        $preferedType = $request->prefers($availableTypes);

        // Const values for specific types
        if (key_exists($preferedType, $values)) {
            $content = $values[$preferedType];
            return $this->response->make($content)
                ->header('Content-Type', $preferedType);
        }

        // Automatic conversion using defined handlers
        if(!key_exists($preferedType, $this->handlers)) {
            throw new HttpException(self::UNSUPPORTED_TYPE_CODE, 'Cannot return response in specified format, use/change the "Accepts" header.');
        }

        $content = $this->handlers[$preferedType]->handle($data);
        return $this->response->make($content)
            ->header('Content-Type', $preferedType);
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