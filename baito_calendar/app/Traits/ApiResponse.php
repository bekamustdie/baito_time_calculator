<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected function success(
        mixed $data = null,
        string $message = 'Success',
        int $code = Response::HTTP_OK
    ):JsonResponse {
        return response()->json([
            'success'=> true,
            'message'=> $message,
            'data'=>$data
        ], $code);
    }

    public function created(
        mixed $data = null,
        string $message = 'Resource created successfully',   
    ): JsonResponse{
        return $this->success($data, $message , Response::HTTP_CREATED);
    }

    protected function error(
        string $message = 'Error',
        int $code = Response::HTTP_BAD_REQUEST,
        array $errors = []
    ):JsonResponse 
    {
        $response = [
            'success'=>false,
            'message'=>$message
        ];
        if ($errors !==[]){
            $response['errors']= $errors;
        }
        return response()->json($response, $code);
    }

    protected function notFound(string $message = 'Resourse not found '): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND);
    }

    protected function unathorized (string $message = 'Unauthorized'):JsonResponse
    {
        return $this->error($message, Response::HTTP_UNAUTHORIZED);
    }

    protected function forbidden (string $message = 'Forbidden'):JsonResponse
    {
        return $this->error($message, Response::HTTP_FORBIDDEN);
    }

    protected function validationErrror(array $errors, string $message ='Validation failed'): JsonResponse
    {
        return $this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY, $errors);
    }

}