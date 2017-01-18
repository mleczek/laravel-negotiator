<?php


namespace Mleczek\Negotiator\Handlers;


use Mleczek\Negotiator\Contracts\ContentNegotiationHandler;

class JsonHandler implements ContentNegotiationHandler
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function handle($data)
    {
        return json_encode($data);
    }
}