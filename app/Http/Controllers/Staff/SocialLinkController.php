<?php

namespace App\Http\Controllers\Staff;

use App\Models\Settings;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Services\SocialLinkService;
use App\Http\Controllers\Controller;

class SocialLinkController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        if ($request->hasFile('icon')) {
            $url = uploadImage($request->icon, 'social-link');
        }

        SocialLinkService::forgetCache();

        SocialLink::create([
            'name' => $request->name,
            'link' => $request->url,
            'icon' => isset($url) ? $url : '',
            'full_url' => isset($url) ? asset($url) : '',
        ]);

        return redirect()->back()->withSuccess(__('Link successfully added.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLink $social_link)
    {
        $settings = Settings::first();
        $social_links = SocialLink::orderBy('order', 'ASC')->get();
        // $case_subscription_price = Meta::getSetting('case_subscription_price', 0);
        $cashier_stripe_fragrance_subscription = getStripeProduct();
        return view('staff.setting.general', compact('social_links', 'social_link', 'cashier_stripe_fragrance_subscription', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialLink $social_link)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        if ($request->hasFile('icon')) {
            deleteImage($social_link->icon);
            $url = uploadImage($request->icon, 'social-link');
        }

        SocialLinkService::forgetCache();

        $social_link->update([
            'name' => $request->name,
            'link' => $request->url,
            'icon' => isset($url) ? asset($url) : $social_link->icon,
            'full_url' => isset($url) ? asset($url) : $social_link->full_url,
        ]);
        
        return redirect()->back()->withSuccess(__('Link successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialLink $social_link)
    {
        if (file_exists($social_link->icon)) {
            deleteImage($social_link->icon);
        }

        SocialLinkService::forgetCache();

        $social_link->delete();

        return redirect()->back()->withSuccess(__('Link successfully deleted.'));
    }
}
