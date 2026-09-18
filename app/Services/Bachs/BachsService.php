<?php

namespace App\Services\Bachs;

use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\CheckoutSessionRequest;
use App\Services\Bachs\DTOs\CheckoutSessionResponse;
use App\Services\Bachs\DTOs\CheckoutSessionVerification;
use App\Services\Bachs\Exceptions\BachsException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BachsService implements BachsServiceInterface
{
    private string $apiKey;

    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('bachs.api_key');
        $this->baseUrl = config('bachs.base_url');
    }

    public function createCheckoutSession(CheckoutSessionRequest $request): CheckoutSessionResponse
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->timeout(30)->post("{$this->baseUrl}/v1/checkout-sessions", $request->toArray());

            if ($response->failed()) {
                Log::error('Bachs checkout creation failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw BachsException::apiError(
                    $response->json('detail', 'Unknown error'),
                    $response->status()
                );
            }

            return CheckoutSessionResponse::fromArray($response->json());
        } catch (BachsException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Bachs checkout connection failed', ['error' => $e->getMessage()]);

            throw BachsException::networkError($e);
        }
    }

    public function verifyCheckoutSession(string $checkoutId): CheckoutSessionVerification
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->timeout(30)->get("{$this->baseUrl}/v1/checkout-sessions/{$checkoutId}");

            if ($response->failed()) {
                Log::error('Bachs checkout verification failed', [
                    'checkout_id' => $checkoutId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw BachsException::apiError(
                    $response->json('detail', 'Verification failed'),
                    $response->status()
                );
            }

            return CheckoutSessionVerification::fromArray($response->json());
        } catch (BachsException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Bachs verification connection failed', [
                'checkout_id' => $checkoutId,
                'error' => $e->getMessage(),
            ]);

            throw BachsException::networkError($e);
        }
    }

    public function getPaymentMethods(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->timeout(15)->get("{$this->baseUrl}/v1/payment-methods");

            if ($response->failed()) {
                return [];
            }

            return $response->json('payment_methods', []);
        } catch (\Exception $e) {
            Log::error('Bachs payment methods fetch failed', ['error' => $e->getMessage()]);

            return [];
        }
    }

    public function createProduct(string $name, string $amount, string $currency = 'NGN', ?string $description = null): string
    {
        $payload = [
            'name' => $name,
            'description' => $description ?? "VocalPay - {$name}",
            'price' => [
                'currency' => $currency,
                'amount' => $amount,
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Accept' => 'application/json',
            ])->timeout(30)->post("{$this->baseUrl}/v1/products", $payload);

            if ($response->failed()) {
                Log::error('Bachs product creation failed', [
                    'name' => $name,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw BachsException::apiError(
                    $response->json('detail', 'Product creation failed'),
                    $response->status()
                );
            }

            return $response->json('id');
        } catch (BachsException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Bachs product connection failed', ['name' => $name, 'error' => $e->getMessage()]);

            throw BachsException::networkError($e);
        }
    }

    public function verifyWebhookSignature(string $rawBody, ?string $timestampHeader, ?string $signatureHeader): bool
    {
        $secret = config('bachs.webhook_secret');
        $tolerance = (int) config('bachs.webhook_tolerance', 300);

        if (! $secret || ! $timestampHeader || ! $signatureHeader) {
            return false;
        }

        $parts = [];
        foreach (explode(',', $signatureHeader) as $part) {
            if (str_contains($part, '=')) {
                [$key, $value] = explode('=', $part, 2);
                $parts[$key] = $value;
            }
        }

        $timestamp = (int) ($parts['t'] ?? 0);

        if ($timestamp <= 0 || abs(time() - $timestamp) > $tolerance) {
            return false;
        }

        $signatures = [];
        foreach (explode(',', $signatureHeader) as $part) {
            if (str_starts_with($part, 'v1=')) {
                $signatures[] = substr($part, 3);
            }
        }

        if ($signatures === []) {
            return false;
        }

        $message = $timestamp.'.'.$rawBody;
        $expected = hash_hmac('sha256', $message, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expected, $signature)) {
                return true;
            }
        }

        return false;
    }
}
