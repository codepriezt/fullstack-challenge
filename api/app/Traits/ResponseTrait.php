<?php

namespace App\Traits;

use Illuminate\Http\Response;
use App\Http\Resources\DefaultResourceCollection;
use Illuminate\Http\JsonResponse;


trait ResponseTrait
{
    /**
     * @param null $error
     * @param null $data
     *
     * @return JsonResponse
     */

    public static function getResponse($case = null, string $message = null, $error = null, $data = null)
    {

        if (is_null($case)) {
            $case = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $code = null;
        $status = null;

        switch ($case) {
            case Response::HTTP_INTERNAL_SERVER_ERROR:
                $code = 500;
                $status = false;
                if (is_null($message)) {
                    $message = 'An error occurred, Please try again';
                }
                break;
            case Response::HTTP_BAD_REQUEST:
                $code = 400;
                $status = false;
                if (is_null($message)) {
                    $message = 'An invalid request was made, Please try again';
                }
                break;
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $code = 422;
                $status = false;
                if (is_null($message)) {
                    $message = 'An unprocessable request was made, Please try again';
                }
                break;
            case Response::HTTP_NOT_FOUND:
                $code = 404;
                $status = false;
                if (is_null($message)) {
                    $message = 'Requested resource not found';
                }
                break;
            case Response::HTTP_UNAUTHORIZED:
                $code = Response::HTTP_UNAUTHORIZED;
                $status = false;
                if (is_null($message)) {
                    $message = 'An unauthorized request was made, Please try again';
                }
                break;
            default:
                $code = Response::HTTP_OK;
                $status = true;
                if (is_null($message)) {
                    $message = 'Request Successful';
                }
                break;
        }

        if ($data instanceof DefaultResourceCollection) {
            $newData = $data->toArray($data);

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $newData['data'],
                'links' => $newData['links'],
                'meta' => $newData['meta'],
                'error' => $error
            ], $code);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $code);
    }

    /**
     * @param mixed|null $data
     */
    public static function success(string $message = null, $data = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'Request Successful';
        }

        if ($data instanceof DefaultResourceCollection) {
            $newData = $data->toArray($data);

            return response()->json([
              'status' => true,
                'message' => $message,
                'data' => $newData['data'],
                'links' => $newData['links'],
                'meta' => $newData['meta'],
                'error' => null
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'error' => null
        ], 200);
    }

    /**
     * @param null $error
     */
    public static function error(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'An error occurred, Please try again';
        }
        
        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 500);
    }

    /**
     * @param null $error
     */
    public static function unauthorized(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'An unauthorized request was made, Please try again';
        }

        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 403);
    }


    /**
     * @param null $error
     */
    public static function validationRequest(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'Validation error, Please try again';
        }

        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 422);
    }

    /**
     * @param null $error
     */
    public static function unauthenticated(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'An unauthenticated request was made, Please try again';
        }

        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 401);
    }

    /**
     * @param null $error
     */
    public static function notfound(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'Request resource not found';
        }

        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 404);
    }

    /**
     * @param null $error
     */
    public static function badRequest(string $message = null, $error = null): JsonResponse
    {
        if (is_null($message)) {
            $message = 'An invalid request was made, Please try again';
        }

        return response()->json(['status' => false, 'message' => $message, 'data' => null, 'error' => $error], 404);
    }
}
