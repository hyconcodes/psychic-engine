<?php

namespace App\Services\Bachs\Contracts;

use App\Services\Bachs\DTOs\CheckoutSessionRequest;
use App\Services\Bachs\DTOs\CheckoutSessionResponse;
use App\Services\Bachs\DTOs\CheckoutSessionVerification;

interface BachsServiceInterface
{
    public function createCheckoutSession(CheckoutSessionRequest $request): CheckoutSessionResponse;

    public function verifyCheckoutSession(string $checkoutId): CheckoutSessionVerification;

    public function getPaymentMethods(): array;

    public function createProduct(string $name, string $amount, string $currency = 'NGN', ?string $description = null): string;

    public function verifyWebhookSignature(string $rawBody, ?string $timestampHeader, ?string $signatureHeader): bool;

    public function listBanks(string $country = 'NG'): array;

    public function resolveBankAccount(string $accountNumber, string $bankCode, string $country = 'NG'): array;

    public function createPayoutDestination(string $name, string $currency, string $accountNumber, string $bankCode): string;

    public function createPayout(string $destination, string $amount, string $reference): array;
}
