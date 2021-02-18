<?php

namespace App\Libraries;

/**
 * One Way SMS Gateway API - Laravel Library
 * Worked on API Version 1.2
 *
 * Copyright (c) KINIDI Tech and other contributors
 * Released under the MIT license.
 * For more information, see https://kiniditech.com/ or https://github.com/vickzkater
 *
 * https://github.com/vickzkater/onewaysms-laravel
 */

use GuzzleHttp\Client;

class OnewaySms
{
    /**
     * @param String $mobile required | Destination mobile number must include country code (Example: 601234567)
     * @param String $message required | Text Message (MAX 459 chars = 3 SMS)
     * @param Boolean $debug optional
     * @param String $username optional | Username provided to user to connect to our service
     * @param String $password optional
     * 
     * @return Boolean/String
     */
    public static function send($mobile, $message, $debug = false, $username = null, $password = null)
    {


        if (!$username) {
            $username = 'API8YR8ASWL8V';
        }

        if (!$password) {
            $password = 'API8YR8ASWL8V8YR8A';
        }

        $api = 'http://gateway.onewaysms.sg:10002';

        if (!$username || !$password || !$api) {
            if ($debug) {
                return trans('global.onewaysms.credentials_not_set');
            } else {
                return false;
            }
        }
        
        $client = new Client();

        $result = $client->request('GET', $api . '/api.aspx', [
            'query' => [
                'apiusername' => $username,
                'apipassword' => $password,
                'senderid' => 'SWALMS',
                'mobileno' => $mobile,
                'message' => $message,
                'languagetype' => 1
            ]
        ]);

        $response = json_decode($result->getBody()->getContents());

        /*print_r($response);
        exit();*/


        // set return code
        $response_code = $response;
        if ($response_code > 0) {
            // Positive value – Success
            $response_status = true;
            $response_message = trans('global.onewaysms.success');
        } else {
            $response_status = false;
            switch ($response_code) {
                case -100:
                    $response_message = trans('global.onewaysms.invalid_details');
                    break;
                case -200:
                    $response_message = trans('global.onewaysms.invalid_senderid');
                    break;
                case -300:
                    $response_message = trans('global.onewaysms.invalid_phone');
                    break;
                case -400:
                    $response_message = trans('global.onewaysms.invalid_language_type');
                    break;
                case -500:
                    $response_message = trans('global.onewaysms.invalid_character');
                    break;
                case -600:
                    $response_message = trans('global.onewaysms.low_balance');
                    break;

                default:
                    $response_message = trans('global.onewaysms.unknown');
                    break;
            }
        }

        if ($debug) {
            $result = [
                'status' => $response_status,
                'code' => $response_code,
                'message' => $response_message
            ];

            // result sample:
            // array:3 [▼
            //     "status" => false
            //     "code" => -100
            //     "message" => "apipassname or apipassword is invalid"
            // ]
        } else {
            $result = [
                'status' => $response_status,
                'code' => $response_code,
                'message' => $response_message
            ]; // Boolean
        }

        return $result;
    }
}
