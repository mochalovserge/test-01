<?php

namespace App\Traits;

use Exception;
use App\Exceptions\WrongFieldsException;
use Illuminate\Http\Request;

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

        /*switch (true) {
            case $this->isBadRequestHttpException($exception):
                return $this->badRequestHttpException($exception->getMessage());
            case $this->isNotFoundHttpException($exception):
                return $this->notFoundHttpException($request->getPathInfo());
            default:
                return $this->fatalErrorException();
        }*/
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