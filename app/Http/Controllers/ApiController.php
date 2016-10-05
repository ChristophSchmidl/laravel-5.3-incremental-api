<?php

namespace App\Http\Controllers;



use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $lessons
     * @param $data
     * @return mixed
     */
    protected function respondWithPagination(Paginator $lessons, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $lessons->total(),
                'total_pages' => $lessons->lastPage(),
                'current_page' => $lessons->currentPage(),
                'limit' => $lessons->perPage()
            ]
        ]);

        return $this->respond($data);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondCreated($message)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
            'message' => $message
        ]);
    }

}