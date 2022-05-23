<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * The trait contains helper methods for generating Json responses
 */
trait JsonResponseTrait
{
    /**
     * Returns the response in json format
     *
     * @param array|Collection|EloquentCollection $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsonResponse($data, $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Returns a successful response, code 200
     *
     * @param array|Collection|EloquentCollection $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuccessfulJsonResponse($data): JsonResponse
    {
        return $this->getJsonResponse($data);
    }

    /**
     * Returns a response with a server error, code 500
     *
     * @param array|Collection|EloquentCollection $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getErrorJsonResponse($data): JsonResponse
    {
        return $this->getJsonResponse($data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Returns a validation error response, code 422
     *
     * @param array|Collection|EloquentCollection $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvalidJsonResponse($data): JsonResponse
    {
        return $this->getJsonResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Returns response resource not found, code 404
     *
     * @param array|Collection|EloquentCollection $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotFoundResponse($data): JsonResponse
    {
        return $this->getJsonResponse($data, Response::HTTP_NOT_FOUND);
    }
}
