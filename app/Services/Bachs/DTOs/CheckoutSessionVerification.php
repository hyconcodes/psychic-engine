<?php

namespace App\Services\Bachs\DTOs;

readonly class CheckoutSessionVerification
{
    public function __construct(
        public string $checkoutId,
        public string $status,
        public string $paymentStatus,
        public ?string $chargeId = null,
        public ?string $chargeStatus = null,
        public ?string $amount = null,
        public ?string $currency = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $charge = $data['charge'] ?? null;

        return new self(
            checkoutId: $data['checkout_id'],
            status: $data['status'],
            paymentStatus: $data['payment_status'] ?? 'unknown',
            chargeId: $charge['payment_id'] ?? null,
            chargeStatus: $charge['status'] ?? null,
            amount: $charge['amount'] ?? $data['amount'] ?? null,
            currency: $charge['currency'] ?? $data['currency'] ?? null,
        );
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'completed' && $this->paymentStatus === 'succeeded';
    }
}
