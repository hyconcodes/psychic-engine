<?php

namespace App\Services\Bachs\DTOs;

readonly class WebhookEvent
{
    public function __construct(
        public string $id,
        public string $type,
        public ?string $createdAt,
        public array $data,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            type: $data['type'] ?? '',
            createdAt: $data['created_at'] ?? null,
            data: is_array($data['data'] ?? null) ? $data['data'] : [],
        );
    }

    public function chargeId(): ?string
    {
        return $this->data['charge_id'] ?? null;
    }

    public function checkoutId(): ?string
    {
        return $this->data['checkout_id'] ?? null;
    }

    public function reference(): ?string
    {
        return $this->data['reference'] ?? null;
    }
}
