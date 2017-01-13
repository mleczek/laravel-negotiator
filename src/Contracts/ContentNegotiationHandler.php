<?php


namespace Mleczek\Negotiator\Contracts;


interface ContentNegotiationHandler
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function handle($data);
}