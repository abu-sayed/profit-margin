<?php

namespace Application\Services;

class ErrorMessageService
{

    public static function getInternalServerErrorMessage(\Exception $exception): string
    {
        return $_SERVER['APP_ENV'] === 'dev' ? $exception->getMessage() : 'Internal Server Error';
    }
}
