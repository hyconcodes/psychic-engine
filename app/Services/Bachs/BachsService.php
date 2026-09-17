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
}
