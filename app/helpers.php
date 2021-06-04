<?php
/**
 * Created by PhpStorm.
 * User: mohammedsehweil
 * Date: 22/09/20
 * Time: 12:04 AM
 */

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists("general_response")) {
    /**
     *
     * General Response that will return in all apis
     * @param $data
     * @param null $message
     * @return JsonResponse|ResourceCollection
     */
    function general_response($data, $message = null)
    {
        // This is workaround since api resource pagination doesn't work with response()->json()
        if ($data instanceof ResourceCollection) {
            return $data;
        }
        $response = array_merge([
            'data' => $data,
        ], $message ? ['message' => $message] : []);

        return response()->json($response, 200);
    }
}

if (!function_exists("error_response")) {
    /**
     *
     * Error Response.
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    function error_response($code = Response::HTTP_INTERNAL_SERVER_ERROR, $message = null)
    {
        if (!$message) {
            $message = Response::$statusTexts[$code];
        }

        return response()->json(['error' => $message], $code);
    }
}

if (!function_exists("validation_response")) {
    /**
     *
     * Validation Response.
     * @param $fieldUnderValidation
     * @param $validationRules
     * @return JsonResponse
     */
    function validation_response($fieldUnderValidation, $validationRules)
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => [
                $fieldUnderValidation => array_map(function ($rule) {
                    return ['key' => $rule];
                }, $validationRules)
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

if (!function_exists("scalify")) {
    /**
     * @param $data
     * Return first element in array or element itself.
     * @return mixed|null
     */
    function scalify($data)
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        return is_array($data) ? $data[0] ?? null : $data;
    }
}

