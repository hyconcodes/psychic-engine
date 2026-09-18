<?php

namespace App\Http\Controllers\Webhook;

use App\Actions\ActivatePlan;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\UserSubscription;
use App\Models\WebhookEvent;
use App\Services\Bachs\Contracts\BachsServiceInterface;
use App\Services\Bachs\DTOs\WebhookEvent as WebhookEventDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BachsWebhookController extends Controller
{
    public function __construct(
        private readonly BachsServiceInterface $bachs,
        private readonly ActivatePlan $activatePlan,
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $rawBody = $request->getContent();

        if (! $this->bachs->verifyWebhookSignature(
            $rawBody,
            $request->header('X-Bachs-Timestamp'),
            $request->header('X-Bachs-Signature-V2') ?? $request->header('X-Bachs-Signature'),
        )) {
            Log::warning('Bachs webhook signature verification failed');

            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $event = WebhookEventDto::fromArray($request->json()->all());

        if ($event->id === '' || WebhookEvent::where('event_id', $event->id)->exists()) {
            return response()->json(['received' => true]);
        }

        $this->process($event);

        WebhookEvent::create([
            'event_id' => $event->id,
            'event_type' => $event->type,
            'payload' => $request->json()->all(),
            'processed_at' => now(),
        ]);

        return response()->json(['received' => true]);
    }

    private function process(WebhookEventDto $event): void
    {
        switch ($event->type) {
            case 'collection.succeeded':
                $this->handleSucceeded($event);
                break;

            case 'collection.failed':
                $this->markFailed($event);
                break;

            case 'checkout.expired':
                $this->markExpired($event);
                break;

            case 'checkout.completed':
                Log::info('Bachs checkout completed', ['checkout_id' => $event->checkoutId()]);
                break;

            default:
                Log::info('Unhandled Bachs webhook event', ['type' => $event->type]);
        }
    }

    private function handleSucceeded(WebhookEventDto $event): void
    {
        $checkoutId = $event->checkoutId() ?? $event->reference();

        if (! $checkoutId) {
            Log::warning('Bachs collection.succeeded without checkout_id or reference', ['event' => $event->id]);

            return;
        }

        $this->activatePlan->handle($checkoutId, $event->chargeId());
    }

    private function markFailed(WebhookEventDto $event): void
    {
        $checkoutId = $event->checkoutId() ?? $event->reference();

        if (! $checkoutId) {
            return;
        }

        UserSubscription::where('bachs_checkout_id', $checkoutId)
            ->where('status', 'pending')
            ->update(['status' => 'failed']);

        Transaction::where('bachs_checkout_id', $checkoutId)
            ->where('status', 'pending')
            ->update(['status' => 'failed']);
    }

    private function markExpired(WebhookEventDto $event): void
    {
        $checkoutId = $event->checkoutId() ?? $event->reference();

        if (! $checkoutId) {
            return;
        }

        UserSubscription::where('bachs_checkout_id', $checkoutId)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);
    }
}
