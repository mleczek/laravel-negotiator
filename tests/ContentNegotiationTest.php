<?php


namespace Mleczek\Negotiator\Tests;


use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;
use Mleczek\Negotiator\ContentNegotiation;
use Mleczek\Negotiator\Facades\ContentNegotiation as ContentNegotiationFacade;
use Mleczek\Negotiator\Handlers\JsonHandler;
use Mleczek\Negotiator\NegotiatorServiceProvider;
use Mleczek\Negotiator\Tests\Mocks\ResponseFactoryMock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ContentNegotiationTest extends TestCase
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var NegotiatorServiceProvider
     */
    protected $provider;

    public function setUp()
    {
        parent::setUp();

        $this->app = new Container();
        $this->app->singleton('app', 'Illuminate\Container\Container');
        $this->provider = new NegotiatorServiceProvider($this->app);
    }

    public function testFacade()
    {
        $this->provider->register();

        ContentNegotiationFacade::setFacadeApplication($this->app);
        ContentNegotiationFacade::contentTypes();
    }

    public function testDefaultSupportedContentTypes()
    {
        $negotiator = new ContentNegotiation($this->app);
        $response = new ResponseFactoryMock();
        $request = $this->createMock(Request::class);

        $this->provider->boot($negotiator, $response, $request);
        $result = $negotiator->contentTypes();

        $this->assertArraySubset(['application/json', 'application/xml'], $result);
    }

    public function testNegotitateMacro()
    {
        $negotiator = $this->createMock(ContentNegotiation::class);
        $negotiator->expects($this->exactly(2))->method('extend');
        $negotiator->expects($this->once())->method('negotiate');
        $response = new ResponseFactoryMock();
        $request = $this->createMock(Request::class);

        $this->provider->boot($negotiator, $response, $request);

        $this->assertTrue($response->hasMacro('negotiate'));
        $response->negotiate($request, []);
    }

    public function testNegotiateWithoutSuitableType()
    {
        $expected = '<mock/>';
        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('prefers')->willReturn('application/xml');

        $negotiator = new ContentNegotiation($this->app);

        $result = $negotiator->negotiate($request, [], ['application/xml' => $expected]);
        $this->assertEquals($expected, $result);
    }

    public function testNegotiateWithSuitableType()
    {
        $expected = '{"id":5}';
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(2))->method('prefers')->willReturn('application/json');

        $negotiator = new ContentNegotiation($this->app);
        $negotiator->extend('application/json', function() {
            return new JsonHandler();
        });

        $result = $negotiator->negotiate($request, ['id' => 5], ['unknown/type' => '...']);
        $this->assertEquals($expected, $result);
    }

    public function testUnsupportedType()
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(2))->method('prefers')->willReturn('application/json');
        $negotiator = new ContentNegotiation($this->app);

        $this->expectException(HttpException::class);
        $negotiator->negotiate($request, []);
    }
}