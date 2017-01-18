<?php


namespace Mleczek\Negotiator\Handlers;


use Mleczek\Negotiator\Contracts\ContentNegotiationHandler;
use Mleczek\Xml\Xmlable;

class XmlHandler implements ContentNegotiationHandler
{
    const ROOT_NAME = 'results';

    /**
     * @param mixed $data
     * @return mixed
     */
    public function handle($data)
    {
        if($data instanceof Xmlable) {
            return toXml($data);
        }

        return toXmlAs($data, self::ROOT_NAME);
    }
}