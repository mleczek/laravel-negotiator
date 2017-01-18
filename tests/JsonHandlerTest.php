<?php


namespace Mleczek\Negotiator\Tests;


use Mleczek\Negotiator\Handlers\JsonHandler;
use Mleczek\Negotiator\Tests\Fixtures\XmlableModelFixture;
use PHPUnit\Framework\TestCase;

class JsonHandlerTest extends TestCase
{
    public function testArrayOfXmlableModels()
    {
        $json = '[{"id":1},{"id":2}]';
        $array = [
            ['id' => 1],
            ['id' => 2],
        ];

        $handler = new JsonHandler();
        $result = $handler->handle($array);

        $this->assertEquals($json, $result);
    }
}