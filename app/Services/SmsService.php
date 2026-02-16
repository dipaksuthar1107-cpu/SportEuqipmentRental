<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send a mock SMS by logging it to a specific file.
     *
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendSms($phone, $message)
    {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] SMS to: {$phone} | Message: {$message}" . PHP_EOL;
        
        // Log to laravel log for visibility
        Log::info("Mock SMS sent to {$phone}: {$message}");
        
        // Also log to a dedicated SMS log file
        $smsLogPath = storage_path('logs/sms.log');
        file_put_contents($smsLogPath, $logMessage, FILE_APPEND);
        
        return true;
    }
}
