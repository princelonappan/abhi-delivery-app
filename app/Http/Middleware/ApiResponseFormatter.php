<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFormatter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $responseArray = [
            'data' => json_decode($response->getContent()),
            'code' => $response->getStatusCode()
        ];
        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
            case Response::HTTP_CREATED;
                $responseArray['message'] = 'The requested operation successfully completed';
                $responseArray['success'] = true;
                break;
            case Response::HTTP_BAD_REQUEST:
                $responseArray['message'] = 'Input error in the request';
                $responseArray['success'] = false;
                break;
            case Response::HTTP_UNAUTHORIZED:
                $responseArray['message'] = 'The request is unauthorized';
                $responseArray['success'] = false;
                break;
            case Response::HTTP_NOT_FOUND:
                $responseArray['message'] = 'The requested resource is not found';
                $responseArray['success'] = false;
                break;

           case Response::HTTP_METHOD_NOT_ALLOWED:
                $responseArray['message'] = 'Methods is not allowed for the requested route';
                $responseArray['success'] = false;
                break;

            case Response::HTTP_INTERNAL_SERVER_ERROR:
                $responseArray['message'] = "A server error occurred. Please try again later";
                $responseArray['success'] = false;
                break;

            default:
                $responseArray['message'] = 'Some error occurred. Please try again later';
                $responseArray['success'] = false;
            break;
        }
        return response()->json($responseArray, $response->getStatusCode());
    }
}
