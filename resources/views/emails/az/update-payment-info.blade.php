@extends('emails.template.layout')
@section('content')
    <section style="padding: 32px 40px; background-color: white;">
        <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
            Salam {{Zafor}}, Zəhmət olmasa Ödəniş Məlumatınızı Yeniləyin
        </h2>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
            Ən son ödənişinizi emal etmək mümkün olmadı. Bu, kart nömrəsinin dəyişməsi, istifadə müddəti və ya ləğvi və ya hətta bankınızın ödənişi tanımaması ilə bağlı ola bilər.
        </p>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
            Bu ayın ətrini əldə etmək üçün, <a href="#" style="color: black; text-decoration: underline">ödəniş məlumatınızı yeniləyin.
            </a>
        </p>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000; margin-bottom: 32px;">
            Biz ödənişi yenidən almağa cəhd edəcəyik və seçdiyiniz ödəniş metodunuzla bağlı hər hansı problemlə üzləşsək, sizə məlumat verəcəyik.</p>
        <a href="#" style="width: 100%; display: flex; justify-content:center; align-items: center; padding: 16px 40px;width: 520px;height: 56px;background: #000000;border: 2px solid #000000; font-weight: 600;font-size: 16px;line-height: 24px;text-align: center;text-transform: uppercase; color: #FFFFFF;">
            İndi yeniləyin
        </a>
    </section>
@endsection
