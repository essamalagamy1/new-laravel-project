<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PolicyController extends Controller
{
    public function privacy(): View
    {
        return $this->renderPolicy(
            title: __('lang.privacy_policy'),
            content: siteSetting()?->privacy_policy
        );
    }

    public function terms(): View
    {
        return $this->renderPolicy(
            title: __('lang.terms_and_conditions'),
            content: siteSetting()?->terms_and_conditions
        );
    }

    public function refund(): View
    {
        return $this->renderPolicy(
            title: __('lang.refund_policy'),
            content: siteSetting()?->refund_policy
        );
    }

    public function shipping(): View
    {
        return $this->renderPolicy(
            title: __('lang.shipping_policy'),
            content: siteSetting()?->shipping_policy
        );
    }

    public function about(): View
    {
        return $this->renderPolicy(
            title: __('lang.about_us'),
            content: siteSetting()?->about_us
        );
    }

    private function renderPolicy(string $title, ?string $content): View
    {
        $breadcrumbs = [
            [
                'label' => __('lang.home'),
                'link' => route('home'),
            ],
            [
                'label' => $title,
            ],
        ];

        return view('website.policy', [
            'title' => $title,
            'content' => $content,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
