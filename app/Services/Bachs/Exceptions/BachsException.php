<?php

namespace App\Services\Bachs\Exceptions;

use RuntimeException;

class BachsException extends RuntimeException
{
    public static function apiError(string $message, int $code = 0, ?\Throwable $previous = null): static
    {
        return new static("Bachs API error: {$message}", $code, $previous);
    }

    public static function networkError(\Throwable $previous): static
    {
        return new static('Failed to connect to Bachs API. Please try again.', 0, $previous);
    }

    public static function invalidResponse(): static
    {
        return new static('Invalid response from Bachs API.');
    }
}
