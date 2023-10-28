<?php

namespace App\Services\Singleton\Logger;

use Carbon\Carbon;

/**
 * WARNING: This class registered as Singleton here.
 */
class LoggerVanilla
{
    private static ?LoggerVanilla $instance = null;
    private array $logs;

    public static function getInstance(): ?LoggerVanilla
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    /**
     * @param $message
     * @return void
     */
    public function logMessage($message): void
    {
        $this->logs[] = [
            'time' => Carbon::now(),
            'message' => $message
        ];
    }

    /**
     * @return false|string
     */
    public function getLog(): false|string
    {
        return json_encode($this->logs);
    }
}
