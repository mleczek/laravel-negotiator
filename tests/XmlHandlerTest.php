<?php


namespace Mleczek\Negotiator\Tests;


use Mleczek\Negotiator\Handlers\XmlHandler;
use Mleczek\Negotiator\Tests\Fixtures\XmlableFixture;
use Mleczek\Negotiator\Tests\Fixtures\XmlableModelFixture;
use PHPUnit\Framework\TestCase;

class XmlHandlerTest extends TestCase
{
    public function testXmlable()
    {
        $data = new XmlableFixture();
        $expected = $data->toXml();

        $handler = new XmlHandler();
        $result = $handler->handle($data);

        $this->assertEquals($expected, $result);
    }

    public function testNonXmlable()
    {
        $data = [['test'], ['xyz']];
        $expected = '<?xml version="1.0" encoding="UTF-8"?><results><result><test/></result><result><xyz/></result></results>';

        $handler = new XmlHandler();
        $result = $handler->handle($data);

        $this->assertEquals($expected, $result);
    }

    public function testArrayOfXmlableModels()
    {
        $array = [new XmlableModelFixture(), new XmlableModelFixture()];
        $xml = '<?xml version="1.0" encoding="UTF-8"?><results><model/><model/></results>';

        $handler = new XmlHandler();
        $result = $handler->handle($array);

        $this->assertEquals($xml, $result);
    }
}