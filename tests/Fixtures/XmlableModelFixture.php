<?php


namespace Mleczek\Negotiator\Tests\Fixtures;


use Illuminate\Database\Eloquent\Model;
use Mleczek\Xml\Xmlable;
use Mleczek\Xml\XmlElement;

class XmlableModelFixture extends Model implements Xmlable
{
    /**
     * Get object xml representation
     * (plain or meta description).
     *
     * @return array|string|XmlElement
     */
    public function xml()
    {
        return ['model'];
    }
}