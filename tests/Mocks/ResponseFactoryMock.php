<?php


namespace Mleczek\Negotiator\Tests\Mocks;


use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Traits\Macroable;

class ResponseFactoryMock implements ResponseFactory
{
    use Macroable;

    /**
     * Return a new response from the application.
     *
     * @param  string $content
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\Response
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }

    /**
     * Return a new view response from the application.
     *
     * @param  string $view
     * @param  array $data
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\Response
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        // TODO: Implement view() method.
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array $data
     * @param  int $status
     * @param  array $headers
     * @param  int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        // TODO: Implement json() method.
    }

    /**
     * Return a new JSONP response from the application.
     *
     * @param  string $callback
     * @param  string|array $data
     * @param  int $status
     * @param  array $headers
     * @param  int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        // TODO: Implement jsonp() method.
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param  \Closure $callback
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        // TODO: Implement stream() method.
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string $file
     * @param  string $name
     * @param  array $headers
     * @param  string|null $disposition
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        // TODO: Implement download() method.
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string $path
     * @param  int $status
     * @param  array $headers
     * @param  bool|null $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectTo($path, $status = 302, $headers = [], $secure = null)
    {
        // TODO: Implement redirectTo() method.
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param  string $route
     * @param  array $parameters
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRoute($route, $parameters = [], $status = 302, $headers = [])
    {
        // TODO: Implement redirectToRoute() method.
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param  string $action
     * @param  array $parameters
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToAction($action, $parameters = [], $status = 302, $headers = [])
    {
        // TODO: Implement redirectToAction() method.
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param  string $path
     * @param  int $status
     * @param  array $headers
     * @param  bool|null $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        // TODO: Implement redirectGuest() method.
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param  string $default
     * @param  int $status
     * @param  array $headers
     * @param  bool|null $secure
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToIntended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        // TODO: Implement redirectToIntended() method.
    }
}