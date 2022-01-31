<?php

namespace App\Helpers;

trait Response
{
    public function responseMaker($data = null, $http_code = 200, $message = null)
    {
        if (empty($message)) {
            switch ($http_code) {
                case 200: // 成功
                    $message = 'OK';
                    break;
                case 201: // 資源已經建立成功
                    $message = 'Created';
                    break;
                case 202: // 伺服器已接受請求，但尚未處理。最終該請求可能會也可能不會被執行。
                    $message = 'Accepted';
                    break;
                case 204: // 伺服器成功處理，但沒有返回內容
                    $message = 'No Content';
                    break;
                case 205: // 伺服器成功處理，但沒有返回內容，要求前端重新整理view
                    $message = 'Reset Content';
                    break;
                case 400: // 參數不足
                    $message = 'Bad Request';
                    break;
                case 401: // 權限不足 未登入
                    $message = 'Unauthorized';
                    break;
                case 403: // Forbidden
                    $message = 'Forbidden';
                    break;
                case 404: // Not Found
                    $message = 'Not Found';
                    break;
                case 405: // 方法不允許，或是沒有安排此方法
                    $message = 'Method Not Allowed';
                    break;
                case 500: // 伺服器遇到了一個未曾預料的狀況，導致了它無法完成對請求的處理
                    $message = 'Internal Server Error';
                    break;
                case 999: // Forbidden
                    $message = 'Error';
                    break;
            }
        }
        $timediff = microtime(true) - LARAVEL_START;

        return response()->json([
            'message'  => $message,
            'data'     => $data,
            'duration' => $timediff,
        ], $http_code);
    }
}
