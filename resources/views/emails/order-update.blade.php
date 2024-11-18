@extends('emails.template.layout')
@section('content')
    <table style="width: 100%; padding: 32px 40px; background-color: white;">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
                        @if ($order->status == 'pending' || $order->status == 'processing')
                            Your {{ $order->created_at->format('F') }} order is {!! $order->html_status !!}
                        @elseif($order->status == 'canceled')
                            Your {{ $order->created_at->format('F') }} order has been {!! $order->html_status !!}
                        @elseif($order->status == 'hold')
                            Your {{ $order->created_at->format('F') }} order is on {!! $order->html_status !!}
                        @elseif($order->status == 'in_transit')
                            Your {{ $order->created_at->format('F') }} order has {!! $order->html_status !!}
                        @elseif($order->status == 'completed')
                            Your {{ $order->created_at->format('F') }} order has been {!! $order->html_status !!}
                        @endif
                    </h2>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000; margin-bottom: 12px;">
                        Order Number: {{ $order->order_no ?? $order->id }}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
                        Please, check the order details page for more update.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    @foreach ($order->items as $item)
                        <table style="display: flex !important; align-items:center !important; flex-direction: row;align-items: center;margin: 32px 0px; padding: 24px 16px;gap: 24px;background: #FFFFFF;border: 1px solid #E6E6E6;">
                            <tr>
                                <td>
                                    <img src="{{ $item->product_image }}" alt="" style="width: 70px; height: 70px; object-fit: contain;">
                                </td>
                                <td>
                                    <h3
                                        style="margin-bottom: 4px;font-style: normal;font-weight: 500;font-size: 20px;line-height: 24px;color: #000000;">
                                        {{ $item->product_title }}
                                    </h3>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    @component('mail::button', ['url' => route('order')])
                        @if ($order->status == 'in_transit')
                            Track your order
                        @elseif($order->status == 'completed')
                            Review Your Experience
                        @else
                            Review Order History
                        @endif
                    @endcomponent

                    {{-- <a class="custom-flex" href=""
                        style="display: flex; justify-content: center; width: 100%; margin-bottom: 32px; align-items: center; padding: 16px 40px;width: 520px;height: 56px;background: #000000;border: 2px solid #000000; font-weight: 600;font-size: 16px;line-height: 24px;text-align: center;text-transform: uppercase; color: #FFFFFF;">

                    </a> --}}
                </td>
            </tr>
        </tbody>
    </table>
    {{-- <section style="padding: 32px 40px; background-color: white;">
        <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
            @if ($order->status == 'pending' || $order->status == 'processing')
                Your {{ $order->created_at->format('F') }} order is {!! $order->html_status !!}
            @elseif($order->status == 'canceled')
                Your {{ $order->created_at->format('F') }} order has been {!! $order->html_status !!}
            @elseif($order->status == 'hold')
                Your {{ $order->created_at->format('F') }} order is on {!! $order->html_status !!}
            @elseif($order->status == 'in_transit')
                Your {{ $order->created_at->format('F') }} order has {!! $order->html_status !!}
            @elseif($order->status == 'completed')
                Your {{ $order->created_at->format('F') }} order has been {!! $order->html_status !!}
            @endif
        </h2>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000; margin-bottom: 12px;">
            Tracking number: {{ $order->id }}
        </p>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
            Please allow 24 to 48 hours for your tracking details to update.
        </p>
        @foreach ($order->items as $item)
            <div
                style="display: flex;flex-direction: row;align-items: center;margin: 32px 0px; padding: 24px 16px;gap: 24px;background: #FFFFFF;border: 1px solid #E6E6E6;">
                <img src="{{ $item->product_image }}" alt="" style="width: 150px; height: auto; ">
                <div>
                    <h3
                        style="margin-bottom: 4px;font-style: normal;font-weight: 500;font-size: 20px;line-height: 24px;color: #000000;">
                        {{ $item->product_title }}
                    </h3>
                    <p
                        style=" margin-bottom: 6px;font-style: normal;font-weight: 500;font-size: 16px;line-height: 24px;color: #000000;">
                        {{ $item->purchase_option }}
                    </p>
                </div>
            </div>
        @endforeach
        <a href="{{ route('order') }}"
            style="width: 100%; margin-bottom: 32px; display: flex; justify-content:center; align-items: center; padding: 16px 40px;width: 520px;height: 56px;background: #000000;border: 2px solid #000000; font-weight: 600;font-size: 16px;line-height: 24px;text-align: center;text-transform: uppercase; color: #FFFFFF;">
            @if ($order->status == 'in_transit')
                Track your order
            @elseif($order->status == 'completed')
                Review Your Experience
            @else
                Review Order History
            @endif
        </a>
        @if ($order->status == 'processing')
            <p style="font-weight: 400;font-size: 16px;line-height: 22px;color: #000000; margin-bottom: 8px;">
                Your order is currently {{ $order->status }}, and you will receive an email when it’s packed and ready to
                leave our fulfillment center. It should reach you within 10 business days from you billing date.
            </p>
            <p style="font-weight: 400;font-size: 16px;line-height: 22px;color: #000000;">
                Because we’ve been taking additional safety precautions at our fulfillment center for COVID-19, your order
                may take an additional day or two to process
            </p>
        @endif
    </section> --}}
@endsection
