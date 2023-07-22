<?php

namespace App\Providers;

use App\Actions\Affiliate;
use App\Actions\Member;
use App\Actions\Stripe\DispatchStripeEvent;
use App\Events\AffiliateCreated;
use App\Events\CustomerSubscriptionCreated;
use App\Events\CustomerSubscriptionDeleted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Cashier\Events\WebhookHandled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AffiliateCreated::class => [
            Affiliate\SendOnboardingEmail::class,
        ],

        CustomerSubscriptionCreated::class => [
            Member\OnboardMember::class,
        ],
        CustomerSubscriptionDeleted::class => [
            Member\OffboardMember::class,
        ],
        WebhookHandled::class => [DispatchStripeEvent::class],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
