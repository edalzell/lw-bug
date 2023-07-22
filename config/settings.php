<?php

use NotificationChannels\Twilio\TwilioChannel;

return [
    'notifications' => [
        'channels' => [
            'mail' => 'mail',
            'sms' => TwilioChannel::class,
        ],
    ],
    'referral' => [
        'reward' => [
            'coupons' => [
                ['id' => 1, 'stripe_id' => env('REFERRAL_COUPON_FIRST')],
                ['id' => 2, 'stripe_id' => env('REFERRAL_COUPON_SECOND')],
                ['id' => 3, 'stripe_id' => env('REFERRAL_COUPON_THIRD')],
                ['id' => 4, 'stripe_id' => env('REFERRAL_COUPON_FOURTH')],
                ['id' => 5, 'stripe_id' => env('REFERRAL_COUPON_FIFTH')],
            ],
            'affiliate' => [
                'percentage' => 20,
            ],
        ],
    ],
];
