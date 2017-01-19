<?php


namespace Mleczek\Negotiator;


use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Mleczek\Negotiator\Handlers\JsonHandler;
use Mleczek\Negotiator\Handlers\XmlHandler;

class NegotiatorServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(Container $container, ResponseFactory $response)
    {
        $negotiator = new ContentNegotiation($container, $response);
        $this->app->instance(ContentNegotiation::class, $negotiator);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @param ContentNegotiation $negotiator
     * @param ResponseFactory $response
     * @param Request $request
     * @return void
     */
    public function boot(ContentNegotiation $negotiator, ResponseFactory $response, Request $request)
    {
        // Default supported content types
        $negotiator->extend('application/json', function () {
            return new JsonHandler();
        });

        $negotiator->extend('application/xml', function () {
            return new XmlHandler();
        });

        // Content negotiation  macro:
        // response()->negotiate($data)
        $response->macro('negotiate', function ($data) use ($negotiator, $request, $response) {
            return $negotiator->negotiate($request, $data);
        });
    }
}