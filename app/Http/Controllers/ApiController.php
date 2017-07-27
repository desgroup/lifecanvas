<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{

    /**
     * Property holds the HTTP status code for an api response.
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Returns the property storing the HTTP status code for api responses.
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the property storing the HTTP status code for api responses.
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a response in json for the api.
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $pagination
     * @param $data
     * @param $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination($pagination, $data, $limit) {
        $data = array_merge($data, [
            'pagination' => [
                'count' => $pagination->count(),
                'total_pages' => $pagination->total(),
                'per_page' => $pagination->perPage(),
                'last_page' => $pagination->lastPage(),
                'current_page' => $pagination->currentPage(),
                'has_more_pages' => $pagination->hasMorePages(),
                'next_page' => $pagination->nextPageUrl() . '&limit=' . $limit,
                'previous_page' => $pagination->previousPageUrl() . '&limit=' . $limit
            ]
        ]);
        return $this->respond($data);
    }

    /**
     * Formats an non-error response for an api request.
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithoutError($message)
    {
        return $this->respond([
            'message' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Formats an error response for an api request.
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Returns a 201 Success code after a record is added.
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseAddSuccess($message = 'Addition made.')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_CREATED)
            ->respondWithoutError($message);
    }

    /**
     * Returns a 202 Success code after a record is updated.
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseUpdateSuccess($message = 'Update made.')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_ACCEPTED)
            ->respondWithoutError($message);
    }

    /**
     * Returns a 404 Not Found response for an api request.
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * Returns a 422 Validation Error response for an api request.
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseValidationError($message = 'Validation Error.')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message);
    }

    /**
     * Returns an Internal Error response for an api request.
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }
}