<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait RestExceptionHandlerTrait
{
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Exception $exception)
    {
        //print_r($exception);


        switch (true) {
            case $this->isNotFoundHttpException($exception):
                return $this->notFoundHttp($request);
            case $this->isModelNotFoundException($exception):
                return $this->modelNotFound();
            default:
                return $this->badRequest();
        }
    }

    /**
     * @param $exception
     * @return bool
     */
    protected function isFatalErrorException($exception) {
        return $exception instanceof FatalErrorException;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fatalError() {
        return $this->jsonResponse([
            'error' => [
                'message' => "Bad request",
                'type' => 'fatal_error',
            ]
        ], 500);
    }

    /**
     * @param $exception
     * @return bool
     */
    protected function isNotFoundHttpException($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundHttp(Request $request)
    {
        return $this->jsonResponse([
            'error' => [
                'message' => "Unable to resolve the request {$request->getPathInfo()}",
                'type' => 'invalid_request_error',
            ]
        ], 404);
    }






    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Bad request', $statusCode = 400)
    {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($message = 'Record not found', $statusCode = 404)
    {
        return $this->jsonResponse(['error' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, $statusCode = 404)
    {
        $payload = $payload ?: [];

        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $exception
     * @return bool
     */
    protected function isModelNotFoundException(Exception $exception)
    {
        return $exception instanceof ModelNotFoundException;
    }

}