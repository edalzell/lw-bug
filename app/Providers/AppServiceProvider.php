<?php

namespace App\Providers;

use App\Contracts\Services\Twilio as TwilioContract;
use App\Models\Affiliate;
use App\Models\Message;
use App\Models\User;
use App\Services\Twilio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Twilio\Rest\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /** @var string $accountSid */
        $accountSid = config('services.twilio.account_sid');

        /** @var string $authToken */
        $authToken = config('services.twilio.auth_token');

        $this->app->singleton(
            Client::class,
            fn () => new Client($accountSid, $authToken)
        );

        $this->app->singleton(
            TwilioContract::class,
            fn () => app(Twilio::class)
        );

        /** @var string $apiBase */
        $apiBase = config('cashier.api_base');

        Cashier::$apiBaseUrl = $apiBase;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();

        // In production, merely log lazy loading violations.
        if ($this->app->isProduction()) {
            Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
                $class = get_class($model);

                info("Attempted to lazy load [{$relation}] on model [{$class}].");
            });
        }

        Relation::enforceMorphMap([
            'affiliate' => Affiliate::class,
            'message' => Message::class,
            'user' => User::class,
        ]);

        $this->bootDirectives();
    }

    private function bootDirectives(): void
    {
        Blade::directive('livewireCalendarScripts', function () {
            return <<<'HTML'
            <script>
                function onLivewireCalendarEventDragStart(event, eventId) {
                    event.dataTransfer.setData('id', eventId);
                }

                function onLivewireCalendarEventDragEnter(event, componentId, dateString, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();

                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className + ` ${dragAndDropClasses} `;
                }

                function onLivewireCalendarEventDragLeave(event, componentId, dateString, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();

                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className.replace(dragAndDropClasses, '');
                }

                function onLivewireCalendarEventDragOver(event) {
                    event.stopPropagation();
                    event.preventDefault();
                }

                function onLivewireCalendarEventDrop(event, componentId, dateString, year, month, day, dragAndDropClasses) {
                    event.stopPropagation();
                    event.preventDefault();

                    let element = document.getElementById(`${componentId}-${dateString}`);
                    element.className = element.className.replace(dragAndDropClasses, '');

                    const eventId = event.dataTransfer.getData('id');

                    window.Livewire.find(componentId).call('onEventDropped', eventId, year, month, day);
                }
            </script>
HTML;
        });

    }
}
