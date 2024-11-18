<table style="width: 100%; background: rgb(0, 0, 0); padding-top: 25px;">
    <thead></thead>
    <tbody>
        <tr>
            <td style="text-align: center">
                @php
                    $social_media = App\Models\SocialLink::query()
                                                ->select(['id', 'name', 'link', 'icon', 'order', 'full_url'])
                                                ->orderBy('order', 'ASC')
                                                ->get();
                @endphp
                @foreach ($social_media as $key => $media)
                    <a href="{{ $media->link }}" style="padding-left: 10px; color: white;">
                        <img src="{{ $media->icon_url }}" style="width: 24px; height: 24px;" alt="{{ $media->name }}" />
                    </a>
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="padding-top:10px; text-align:center; color:white" colspan="{{ count($social_media) }}">
                &copy; scentQ {{ date('Y') }}.
            </td>
        </tr>
        <tr>
            <td style="padding-bottom:30px; padding-top:30px; text-align:center; color:white"
                colspan="{{ count($social_media) }}">
                <a style="color:white; padding-left:30px;" style="color: white;"
                    href="{{ route('page', 'privacy-policy') }}">
                    @if (config('misc.currency_code') == 'AZN' || 'BD')
                    Gizlilik Siyasəti
                    @else
                    Privacy Policy
                    @endif
                </a>
                <a style="color:white; padding-left:30px;" style="color: white;"
                    href="{{ route('page', 'terms-and-conditions') }}">
                    @if (config('misc.currency_code') == 'AZN' || 'BD')
                    Geri qaytarma siyasəti
                    @else
                    Refund Policy
                    @endif
                </a>
                <a style="color:white; padding-left:30px;" style="color: white;"
                    href="{{ route('page', 'terms-and-conditions') }}">
                    @if (config('misc.currency_code') == 'AZN' || 'BD')
                    Şərtlər və Qaydalar
                    @else
                    Terms And Conditions
                    @endif
                </a>
            </td>
        </tr>
    </tbody>
</table>
