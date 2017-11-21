<?php

namespace App\Traits;

use Exception;
use App\Exceptions\WrongFieldsException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        if ($exception instanceof WrongFieldsException) {
            $message = $exception->getMessage();
            $message = (!empty($message) ? $message : 'Invalid data parameters');

            return $this->jsonResponse([
                'errors' => [
                    'params' => $exception->getParams(),
                    'message' => $message,
                    'type' => 'invalid_param_error'
                ]
            ], 400);
        }

        if ($exception instanceof HttpException) {

            return $this->jsonResponse([
                'errors' => [
                    'message' => "Unable to resolve the request {$request->getPathInfo()}",
                    'type' => "invalid_request_error"
                ]
            ], $exception->getStatusCode());
        }

        return $this->jsonResponse([
            'errors' => [
                'message' => 'Internal server error',
                'type' => 'internal_server_error'
            ]
        ], 500);
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
}
