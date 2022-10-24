<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Exceptions\HttpResponseException;

if (!function_exists('successResponse')) {
  /**
   * Greeting a person
   *
   * @param  string $person Name
   * @return string
   */
  function successResponse($data = '', $message = "Successfully process the request", $code = 200)
  {
    $res = [
      'data' => $data,
      'message' => $message,
      'status' => $code
    ];
    return response()->json($res, $code);
  }
}

if (!function_exists('errorResponse')) {
  /**
   * Greeting a person
   *
   * @param  string $person Name
   * @return string
   */
  function errorResponse($message = "Unable to process the request", $code = 400)
  {
    $res = [
      'message' => $message,
      'status' => $code
    ];
    Log::error($message);
    return response()->json($res, $code);
  }

  /**
   * Error Validation Response
   *
   * @param  string $message
   * @param  string $code
   * 
   * @return \Illuminate\Http\Exceptions\HttpResponseException
   */
  function errorValidation($message = "Unprocessable Entity", $code = 422)
  {
    $res = [
      'message' => $message,
      'status' => $code
    ];
    Log::error($message);
    throw new HttpResponseException(
      response()->json($res, $code)
    );
  }
}

