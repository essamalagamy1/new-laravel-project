<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class SiteSettingResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        $paymentTransactionDetails = [
            [
                'title' => $this->payment_transaction_details['title'] ?? null,
                'value' => $this->payment_transaction_details['value'] ?? null,
            ],
        ];

        if (! empty($this->payment_transaction_details['title_2']) || ! empty($this->payment_transaction_details['value_2'])) {
            $paymentTransactionDetails[] = [
                'title' => $this->payment_transaction_details['title_2'] ?? null,
                'value' => $this->payment_transaction_details['value_2'] ?? null,
            ];
        }

        return [
            'name' => $this->name,
            'logo_white' => $this->getFirstMediaUrl('logo_white'),
            'logo_black' => $this->getFirstMediaUrl('logo_black'),
            'favicon' => $this->getFirstMediaUrl('favicon'),
            'payment_transaction_details' => $paymentTransactionDetails,
            'tax_percentage' => (float) $this->tax_percentage,
            'color_primary' => $this->color_primary,
            'color_secondary' => $this->color_secondary,
            'color_accent' => $this->color_accent,
            'description' => $this->description,
            'about_us' => $this->about_us,
            'shipping_returns' => $this->shipping_returns,
            'privacy_policy' => $this->privacy_policy,
            'terms_and_conditions' => $this->terms_and_conditions,
            'refund_policy' => $this->refund_policy,
            'shipping_policy' => $this->shipping_policy,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'maintenance_mode' => (bool) $this->maintenance_mode,
        ];
    }
}
