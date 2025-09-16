<?php

namespace Mvc\Controllers;

abstract class BaseController
{
    protected function redirectWithError(string $url, string $message): void
    {
        header("Location: {$url}?error=" . urlencode($message));
        exit;
    }

    protected function redirectWithSuccess(string $url, string $message): void
    {
        header("Location: {$url}?success=" . urlencode($message));
        exit;
    }
}
