@extends('emails.template.layout')
@section('content')
    <table style="width: 100%; padding: 32px 40px; background-color: white;">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
                        Əziz {{ $user->first_name }},
                    </h2>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="margin-bottom:12px;font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
                        Mütləq ən yaxşı ətirlərimizdən birini sizlərə təqdim etdiyimizi bildirməkdən məmnunuq.
                        dünən qapının astanasında.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    @foreach ($order->items as $item)
                        <div
                            style="display: flex !important; align-items:center !important; flex-direction: row;align-items: center; padding: 24px 16px;gap: 24px;background: #FFFFFF;border: 1px solid #E6E6E6;">
                            <img src="{{ $item->product_image }}" alt="" style="width: 70px; height: 70px; object-fit: contain;">
                            <div>
                                <h3
                                    style="margin-bottom: 4px;font-style: normal;font-weight: 500;font-size: 20px;line-height: 24px;color: #000000;">
                                    {{ $item->product_title }}
                                </h3>
                                <p
                                    style=" margin-bottom: 6px;font-style: normal;font-weight: 500;font-size: 16px;line-height: 24px;color: #000000;">
                                    {{ $item->product?->brand?->name }}
                                </p>
                                <p>
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg width="24" height="24" viewBox="0 0 20 19" fill="#FF8A00"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.4135 15.8812L15.1419 18.8769C15.7463 19.2598 16.4967 18.6903 16.3173 17.9847L14.9512 12.6108C14.9127 12.4611 14.9173 12.3036 14.9643 12.1564C15.0114 12.0092 15.0991 11.8783 15.2172 11.7787L19.4573 8.24959C20.0144 7.78588 19.7269 6.86126 19.0111 6.81481L13.4738 6.45544C13.3247 6.44479 13.1816 6.39198 13.0613 6.30317C12.941 6.21437 12.8484 6.09321 12.7943 5.95382L10.7292 0.753229C10.673 0.605277 10.5732 0.477903 10.443 0.38802C10.3127 0.298137 10.1582 0.25 10 0.25C9.84176 0.25 9.68726 0.298137 9.55702 0.38802C9.42678 0.477903 9.32697 0.605277 9.27083 0.753229L7.20568 5.95382C7.15157 6.09321 7.05897 6.21437 6.93868 6.30317C6.81838 6.39198 6.67533 6.44479 6.52618 6.45544L0.98894 6.81481C0.273153 6.86126 -0.0144031 7.78588 0.542723 8.24959L4.78278 11.7787C4.90095 11.8783 4.9886 12.0092 5.03566 12.1564C5.08272 12.3036 5.08727 12.4611 5.0488 12.6108L3.78188 17.5945C3.56667 18.4412 4.46715 19.1246 5.19243 18.6651L9.58647 15.8812C9.71005 15.8025 9.85351 15.7607 10 15.7607C10.1465 15.7607 10.29 15.8025 10.4135 15.8812Z"
                                                fill="#FF8A00" />
                                        </svg>
                                    @endfor
                                </p>
                            </div>
                        </div>
                        @component('mail::button', [
                            'url' => route('product', [
                                'productType' => $item->product?->type,
                                'brandSlug' => $item->product?->brand?->slug,
                                'productSlug' => $item->product?->slug,
                                'ratings' => 'true',
                            ]),
                        ])
                            ŞƏRHLƏR YAZIN
                        @endcomponent
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
@endsection
