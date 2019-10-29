<?php

namespace App\Libraries;

use Log;
use Response;

trait APIResponse
{

    public function sendResponse($status_code = 200, $response = null, $error = [],
                                 $custom_error_code = null, $extra_fields = [])
    {
        $status = $status_code === 200;

        $error = !empty($error) ? [
            'custom_code' => $custom_error_code,
            'message' => $error
        ] : null;

        $return = [
            'status' => $status,
            'response' => $response,
            'error' => $error
        ];

        foreach ($extra_fields as $key => $field) {

            $return[$key] = $field;
        }

        Log::info(print_r($return, true));

        return Response::json($return, $status_code);
    }

}
