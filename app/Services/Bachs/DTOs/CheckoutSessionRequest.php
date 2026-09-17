<?php

namespace App\Services\Bachs\DTOs;

readonly class CheckoutSessionRequest
{
    public function __construct(
        public string $customerEmail,
        public string $customerName,
        public string $productId,
        public string $successUrl,
        public string $cancelUrl,
        public array $paymentMethodTypes = ['NGN_BANK_TRANSFER'],
        public ?string $reference = null,
        public ?array $metadata = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'customer' => [
                'email' => $this->customerEmail,
                'name' => $this->customerName,
            ],
            'product_cart' => [
                [
                    'product_id' => $this->productId,
                ],
            ],
            'payment_method_types' => $this->paymentMethodTypes,
            'success_url' => $this->successUrl,
            'cancel_url' => $this->cancelUrl,
        ];

        if ($this->reference !== null) {
            $data['reference'] = $this->reference;
        }

        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
        }

        return $data;
    }
}
