<?php

namespace App\Services\Bachs\DTOs;

readonly class CheckoutSessionResponse
{
    public function __construct(
        public string $checkoutId,
        public string $checkoutUrl,
        public string $status,
        public ?string $expiresAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            checkoutId: $data['checkout_id'],
            checkoutUrl: $data['checkout_url'],
            status: $data['status'],
            expiresAt: $data['expires_at'] ?? null,
        );
    }
}
