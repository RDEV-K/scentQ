<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Carbon\Carbon;
use App\Models\Faq;
use App\Models\Cart;
use App\Models\Meta;
use App\Models\Note;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Family;
use App\Models\Review;
use App\Models\Product;
use App\Models\FaqGroup;
use App\Models\QuizItem;
use App\Models\Settings;
use App\Models\Taxonomy;
use App\Traits\SeoTrait;
use App\Models\QueueItem;
use App\Models\Collection;
use App\Traits\KlaviyoTrait;
use Illuminate\Http\Request;
use App\Models\NoteExtraText;
use App\Services\PlanService;
use App\Mail\CardDeclinedMail;
use App\Models\MailSubscriber;
use App\Models\ProductSubType;
use App\Models\PurchaseOption;
use App\Models\QuizItemOption;
use Barryvdh\DomPDF\Facade\Pdf;
use Torann\GeoIP\Facades\GeoIP;
use App\Helpers\TemplateBuilder;
use App\Models\ProductOfTheMonth;
use App\Notifications\SendRefLink;
use Illuminate\Support\Facades\DB;
use App\Models\QueuePurchasePolicy;
use App\Models\TeamMember;
use Google\Service\Fitness\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Validation\ValidationException;

use function Clue\StreamFilter\fun;

class MiscController extends Controller
{
    use SeoTrait, KlaviyoTrait;

    function index(Request $request, $gen = 'women')
    {
        // Get user's IP address
        $ipAddress = request()->ip();

        // Cache the location based on IP address
        $location = Cache::rememberForever("location_{$ipAddress}", function () use ($ipAddress) {
            return GeoIP::getLocation($ipAddress);
        });

        $countryCode = strtolower($location->iso_code);

        // Cache the language setting forever based on the user's IP address
        $language = Cache::rememberForever("lang_{$countryCode}", function () use ($countryCode) {
            return $this->getLanguageByCountryCode($countryCode);
        });
        config(['misc.lang' => $language]);


        // if ($user = $request->user('web')) return redirect($user->home);
        $this->seo(
            'ScentQ Monthly Perfume Subscription Box just for ' . currencyConvertWithSymbol(fiftyPercentOff()),
            'Just ' . currencyConvertWithSymbol(fiftyPercentOff()) . ' Indulge in over 1600 luxury designer fragrances every month. Enjoy free shipping and case. Cancel anytime.'
        );

        $page = Cache::remember(
            'homepage_for_' . $gen,
            now()->addHours(3),
            fn() => Page::query()->with('metas')->where('slug', $gen)->firstOrFail()
        );

        return inertiaWithMeta($page);
    }

    private function getLanguageByCountryCode($countryCode)
    {

        $countryToLang = [
            'af' => 'fa',      // Afghanistan
            'al' => 'sq',      // Albania
            'dz' => 'ar',      // Algeria
            'as' => 'en',      // American Samoa
            'ad' => 'ca',      // Andorra
            'ao' => 'pt',      // Angola
            'ai' => 'en',      // Anguilla
            'ag' => 'en',      // Antigua and Barbuda
            'ar' => 'es',      // Argentina
            'am' => 'hy',      // Armenia
            'aw' => 'nl',      // Aruba
            'au' => 'en',      // Australia
            'at' => 'de',      // Austria
            'az' => 'az',      // Azerbaijan
            'bs' => 'en',      // Bahamas
            'bh' => 'ar',      // Bahrain
            'bd' => 'bn',      // Bangladesh
            'bb' => 'en',      // Barbados
            'by' => 'be',      // Belarus
            'be' => 'nl',      // Belgium
            'bz' => 'en',      // Belize
            'bj' => 'fr',      // Benin
            'bm' => 'en',      // Bermuda
            'bt' => 'dz',      // Bhutan
            'bo' => 'es',      // Bolivia
            'ba' => 'bs',      // Bosnia and Herzegovina
            'bw' => 'en',      // Botswana
            'br' => 'pt',      // Brazil
            'bn' => 'ms',      // Brunei
            'bg' => 'bg',      // Bulgaria
            'bf' => 'fr',      // Burkina Faso
            'bi' => 'fr',      // Burundi
            'kh' => 'km',      // Cambodia
            'cm' => 'fr',      // Cameroon
            'ca' => 'en',      // Canada
            'cv' => 'pt',      // Cape Verde
            'ky' => 'en',      // Cayman Islands
            'cf' => 'fr',      // Central African Republic
            'td' => 'fr',      // Chad
            'cl' => 'es',      // Chile
            'cn' => 'zh',      // China
            'co' => 'es',      // Colombia
            'km' => 'ar',      // Comoros
            'cd' => 'fr',      // Congo (DRC)
            'cg' => 'fr',      // Congo (Republic)
            'cr' => 'es',      // Costa Rica
            'ci' => 'fr',      // Côte d’Ivoire
            'hr' => 'hr',      // Croatia
            'cu' => 'es',      // Cuba
            'cy' => 'el',      // Cyprus
            'cz' => 'cs',      // Czech Republic
            'dk' => 'da',      // Denmark
            'dj' => 'fr',      // Djibouti
            'dm' => 'en',      // Dominica
            'do' => 'es',      // Dominican Republic
            'ec' => 'es',      // Ecuador
            'eg' => 'ar',      // Egypt
            'sv' => 'es',      // El Salvador
            'gq' => 'es',      // Equatorial Guinea
            'er' => 'ti',      // Eritrea
            'ee' => 'et',      // Estonia
            'et' => 'am',      // Ethiopia
            'fj' => 'en',      // Fiji
            'fi' => 'fi',      // Finland
            'fr' => 'fr',      // France
            'ga' => 'fr',      // Gabon
            'gm' => 'en',      // Gambia
            'ge' => 'ka',      // Georgia
            'de' => 'de',      // Germany
            'gh' => 'en',      // Ghana
            'gr' => 'el',      // Greece
            'gd' => 'en',      // Grenada
            'gt' => 'es',      // Guatemala
            'gn' => 'fr',      // Guinea
            'gw' => 'pt',      // Guinea-Bissau
            'gy' => 'en',      // Guyana
            'ht' => 'ht',      // Haiti
            'hn' => 'es',      // Honduras
            'hk' => 'zh',      // Hong Kong
            'hu' => 'hu',      // Hungary
            'is' => 'is',      // Iceland
            'in' => 'hi',      // India
            'id' => 'id',      // Indonesia
            'ir' => 'fa',      // Iran
            'iq' => 'ar',      // Iraq
            'ie' => 'en',      // Ireland
            'il' => 'he',      // Israel
            'it' => 'it',      // Italy
            'jm' => 'en',      // Jamaica
            'jp' => 'ja',      // Japan
            'jo' => 'ar',      // Jordan
            'kz' => 'kk',      // Kazakhstan
            'ke' => 'sw',      // Kenya
            'ki' => 'en',      // Kiribati
            'kp' => 'ko',      // North Korea
            'kr' => 'ko',      // South Korea
            'kw' => 'ar',      // Kuwait
            'kg' => 'ky',      // Kyrgyzstan
            'la' => 'lo',      // Laos
            'lv' => 'lv',      // Latvia
            'lb' => 'ar',      // Lebanon
            'ls' => 'en',      // Lesotho
            'lr' => 'en',      // Liberia
            'ly' => 'ar',      // Libya
            'li' => 'de',      // Liechtenstein
            'lt' => 'lt',      // Lithuania
            'lu' => 'fr',      // Luxembourg
            'mo' => 'zh',      // Macau
            'mk' => 'mk',      // North Macedonia
            'mg' => 'mg',      // Madagascar
            'mw' => 'en',      // Malawi
            'my' => 'ms',      // Malaysia
            'mv' => 'dv',      // Maldives
            'ml' => 'fr',      // Mali
            'mt' => 'mt',      // Malta
            'mh' => 'en',      // Marshall Islands
            'mr' => 'ar',      // Mauritania
            'mu' => 'en',      // Mauritius
            'mx' => 'es',      // Mexico
            'fm' => 'en',      // Micronesia
            'md' => 'ro',      // Moldova
            'mc' => 'fr',      // Monaco
            'mn' => 'mn',      // Mongolia
            'me' => 'sr',      // Montenegro
            'ma' => 'ar',      // Morocco
            'mz' => 'pt',      // Mozambique
            'mm' => 'my',      // Myanmar (Burma)
            'na' => 'en',      // Namibia
            'nr' => 'en',      // Nauru
            'np' => 'ne',      // Nepal
            'nl' => 'nl',      // Netherlands
            'nz' => 'en',      // New Zealand
            'ni' => 'es',      // Nicaragua
            'ne' => 'fr',      // Niger
            'ng' => 'en',      // Nigeria
            'nu' => 'en',      // Niue
            'nf' => 'en',      // Norfolk Island
            'mp' => 'en',      // Northern Mariana Islands
            'no' => 'no',      // Norway
            'om' => 'ar',      // Oman
            'pk' => 'ur',      // Pakistan
            'pw' => 'en',      // Palau
            'ps' => 'ar',      // Palestinian Territories
            'pa' => 'es',      // Panama
            'pg' => 'en',      // Papua New Guinea
            'py' => 'es',      // Paraguay
            'pe' => 'es',      // Peru
            'ph' => 'tl',      // Philippines
            'pl' => 'pl',      // Poland
            'pt' => 'pt',      // Portugal
            'pr' => 'es',      // Puerto Rico
            'qa' => 'ar',      // Qatar
            'ro' => 'ro',      // Romania
            'ru' => 'ru',      // Russia
            'rw' => 'rw',      // Rwanda
            'kn' => 'en',      // Saint Kitts and Nevis
            'lc' => 'en',      // Saint Lucia
            'vc' => 'en',      // Saint Vincent and the Grenadines
            'ws' => 'en',      // Samoa
            'sm' => 'it',      // San Marino
            'st' => 'pt',      // São Tomé and Príncipe
            'sa' => 'ar',      // Saudi Arabia
            'sn' => 'fr',      // Senegal
            'rs' => 'sr',      // Serbia
            'sc' => 'fr',      // Seychelles
            'sl' => 'en',      // Sierra Leone
            'sg' => 'en',      // Singapore
            'sk' => 'sk',      // Slovakia
            'si' => 'sl',      // Slovenia
            'sb' => 'en',      // Solomon Islands
            'so' => 'so',      // Somalia
            'za' => 'en',      // South Africa
            'ss' => 'en',      // South Sudan
            'es' => 'es',      // Spain
            'lk' => 'si',      // Sri Lanka
            'sd' => 'ar',      // Sudan
            'sr' => 'nl',      // Suriname
            'sz' => 'en',      // Swaziland
            'se' => 'sv',      // Sweden
            'ch' => 'de',      // Switzerland
            'sy' => 'ar',      // Syria
            'tw' => 'zh',      // Taiwan
            'tj' => 'tg',      // Tajikistan
            'tz' => 'sw',      // Tanzania
            'th' => 'th',      // Thailand
            'tl' => 'pt',      // Timor-Leste
            'tg' => 'fr',      // Togo
            'to' => 'en',      // Tonga
            'tt' => 'en',      // Trinidad and Tobago
            'tn' => 'ar',      // Tunisia
            'tr' => 'tr',      // Turkey
            'tm' => 'tk',      // Turkmenistan
            'tv' => 'en',      // Tuvalu
            'ug' => 'en',      // Uganda
            'ua' => 'uk',      // Ukraine
            'ae' => 'ar',      // United Arab Emirates
            'gb' => 'en',      // United Kingdom
            'us' => 'en',      // United States
            'uy' => 'es',      // Uruguay
            'uz' => 'uz',      // Uzbekistan
            'vu' => 'bi',      // Vanuatu
            've' => 'es',      // Venezuela
            'vn' => 'vi',      // Vietnam
            'ye' => 'ar',      // Yemen
            'zm' => 'en',      // Zambia
            'zw' => 'en'       // Zimbabwe
        ];

        return $countryToLang[$countryCode] ?? 'en';
    }


    function sendRefLink(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        // $request->validate([
        //     'email' => 'required|email'
        // ]);
        if ($request->email == "") {
            return redirect()->back()->withSuccess(__('Email address required'));
        }
        Notification::route('mail', $request->email)
            ->notify(new SendRefLink($user, $request->email));
        return redirect()->back()->withSuccess(__('Invitation Email Sent'));
    }

    /**
     * Display the specified order invoice.
     *
     * @param \App\Models\Order $order
     * @param string $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View|void
     */
    public function invoice(Order $order, $type = 'html')
    {
        // return 333;


        // $pdf = app('dompdf.wrapper');
        // $context = stream_context_create([
        //     'ssl' => [
        //         'verify_peer' => FALSE,
        //         'verify_peer_name' => FALSE,
        //         'allow_self_signed' => TRUE,
        //     ]
        // ]);

        // $pdf = Pdf::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);
        // $pdf->getDomPDF()->setHttpContext($context);
        // $pdf->loadView('staff.order.invoice', compact('order'));


        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->loadView('staff.order.invoice', compact('order'));

        return $pdf->stream('order.pdf');

        // $pdf = Pdf::loadView('staff.order.invoice', compact('order'))->setOptions(['defaultFont' => 'sans-serif']);


        // return $pdf->download('example.pdf');


        // if (!$order instanceof Order) return abort(404);

        // return view('staff.order.invoice', compact('order'));
    }

    function brands()
    {
        $this->seo(
            'Designer Fragrance Brands - Discover Your Favorites',
            'Explore our selection of over 100 high-end and niche fragrance brands, and find your new signature scent. Subscribe today and receive monthly samples from your favorite brands.'
        );

        // push data to klaviyo
        $this->browseProduct(request()->url());

        $page = Page::query()->with('metas')->where('slug', 'all-brand')->firstOrFail();
        return inertiaWithMeta($page);
    }

    function product($productType, $brandSlug, $productSlug)
    {
        session()->put('intended_brand_slug', $brandSlug);
        session()->put('intended_product_slug', $productSlug);
        /* @var Product $product */
        $product = Product::with(['sub_type', 'purchase_options', 'related_products' => function ($q) {
            $q->with(['product' => function ($p2) {
                $p2->with(['brand'])->withAvg('reviews', 'rate');
            }]);
        }, 'metas', 'terms', 'families', 'labels', 'brand' => function ($q) {
            $q->withCount('products');
        }, 'notes' => function ($q) {
            $q->withCount('products');
        }, 'badges'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->where('type', $productType)
            ->where('slug', $productSlug)
            ->where('status', 'published')
            ->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            })
            ->firstOrFail();

        $already_subscribed = 0;
        if (\auth()->check() && (\auth()->user()->subscription('personal'))) {
            $already_subscribed = 1;
            /* @var User $user */
            $user = \auth()->user();
            $subscription = $user->subscription('personal');
            // $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        } else {
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        }

        $taxonomies = [];
        // $taxonomies = Taxonomy::query()->with(['terms' => function ($q) {
        //     $q->withCount(['reviews as reviews_count' => function ($subquery) {
        //         $subquery->join('review_term_relation AS rtr', 'reviews.id', '=', 'rtr.review_id');
        //     }]);
        // }])->get();

        $reviewsGroupCount = Review::query()->selectRaw('COUNT(*) as total_rate, rate')->where('product_id', $product->id)->groupBy('rate')->pluck('total_rate', 'rate');
        $reviews = $product->reviews()->with(['user', 'terms'])->orderByDesc('created_at')->paginate();
        $NoteExtraText = NoteExtraText::whereNotNull('description_text')->first();

        $related_products = Product::where('for', $product->for)
            ->where('type', $product->type)
            ->with(['brand'])
            ->withAvg('reviews', 'rate')
            ->inRandomOrder()
            ->latest()->take(15)->get();

        $seo_description = htmlspecialchars(trim(strip_tags(str_replace("&nbsp;", '', $product->content))));
        // Split the description into sentences using a period followed by a space as the delimiter
        $sentences = preg_split('/\.\s+/', $seo_description);

        // Check if there are at least 2 sentences before accessing them
        if (count($sentences) >= 2) {
            // Display the first two sentences
            $first_tw_sen = $sentences[0] . '. ' . $sentences[1];
        } else {
            // Handle the case when there are not enough sentences
            // For example, set $first_tw_sen to the entire $seo_description
            $first_tw_sen = $seo_description;
        }

        $this->seo(
            $product->title . ' ' . $product->brand?->name,
            $first_tw_sen,
            $product->image['url']
        );
        return inertiaWithMeta($product, compact('product', 'already_subscribed', 'plan', 'taxonomies', 'reviewsGroupCount', 'reviews', 'NoteExtraText', 'related_products'))->title($product->title . ' ' . $product->brand?->name);
    }

    function refreshReviews(Request $request)
    {

        $productType = $request->productType;
        $brandSlug = $request->brandSlug;
        $productSlug = $request->productSlug;

        $product = Product::with(['sub_type', 'purchase_options', 'related_products' => function ($q) {
            $q->with(['product' => function ($p2) {
                $p2->with(['brand'])->withAvg('reviews', 'rate');
            }]);
        }, 'metas', 'terms', 'families', 'labels', 'brand' => function ($q) {
            $q->withCount('products');
        }, 'notes' => function ($q) {
            $q->withCount('products');
        }, 'badges'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->where('type', $productType)
            ->where('slug', $productSlug)
            ->where('status', 'published')
            ->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            })
            ->firstOrFail();

        $already_subscribed = 0;
        if (\auth()->check() && (\auth()->user()->subscription('personal'))) {
            $already_subscribed = 1;
            /* @var User $user */
            $user = \auth()->user();
            $subscription = $user->subscription('personal');
            // $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        } else {
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        }

        $taxonomies = Taxonomy::query()->with(['terms' => function ($q) {
            $q->withCount('reviews');
        }])->get();

        $reviewsGroupCount = Review::query()->selectRaw('COUNT(*) as total_rate, rate')->where('product_id', $product->id)->groupBy('rate')->pluck('total_rate', 'rate');
        $reviews = $product->reviews()->with(['user', 'terms'])->orderByDesc('created_at')->paginate();
        $NoteExtraText = NoteExtraText::whereNotNull('description_text')->first();

        return $reviews;
    }

    function filterData(Request $request)
    {
        $query = Product::query()->inRandomOrder()
            ->withAvg('reviews', 'rate');

        $with = ['brand'];

        if (is_array($request->with)) {
            $with = array_merge($with, $request->with);
        }
        $query->with($with);

        if ($request->type) {
            // check gender
            if ($request->type == "men" || $request->type == "women" || $request->type == "both") {
                if ($request->type == "men") {
                    $query->where('for', "him");
                } elseif ($request->type == "women") {
                    $query->where('for', "her");
                } else {
                    $query->where('for', "both");
                }
            } else {
                if (is_array($request->type)) {
                    $types = $request->type;
                } else {
                    $types = [$request->type];
                }
                $query->whereIn('type', $types);
            }
        }

        if ($request->has('keyword') && $request->keyword !== null) {
            $query->where('title', 'LIKE', "$request->keyword%")
                ->orWhereHas('brand', function ($q) use ($request) {
                    $q->where('name', 'LIKE', "$request->keyword%");
                });
        }

        if ($request->except) {
            if (is_array($request->except)) {
                $excepts = $request->except;
            } else {
                $excepts = [$request->except];
            }
            $query->whereNotIn('id', $excepts);
        }

        if ($request->for) {
            if (is_array($request->for)) {
                $for = $request->for;
            } else {
                $for = [$request->for];
            }
            $query->whereIn('for', $for);
        }

        if (is_array($request->sub_types)) {
            $query->whereIn('product_sub_type_id', $request->sub_types);
        }

        if ($request->recommend) {
            /* @var User $user */
            $user = $request->user('web');
            if ($user) {
                $familyIds = $user->families()->pluck('families.id');
                $query->whereHas('families', function ($q) use ($familyIds) {
                    $q->whereIn('families.id', $familyIds);
                });
            }
        }

        // if ($request->highRetail) {
        //     $query->where('retail_value', '>=', 150);
        // }

        if (is_array($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        } else if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if (is_array($request->notes)) {
            $ids = $request->notes;
            $query->whereHas('notes', function ($q) use ($ids) {
                $q->whereIn('notes.id', $ids);
            });
        }

        if (is_array($request->collections)) {
            $ids = $request->collections;
            $query->whereHas('collections', function ($q) use ($ids) {
                $q->whereIn('collections.id', $ids);
            });
        }

        if (is_array($request->terms)) {
            $ids = $request->terms;
            $query->whereHas('terms', function ($q) use ($ids) {
                $q->whereIn('terms.id', $ids);
            });
        }

        if (is_numeric($request->rate)) {
            $minRate = (int)$request->rate;
            $maxRate = $minRate + 0.99;
            $query->havingRaw('reviews_avg_rate BETWEEN ? AND ?', [$minRate, $maxRate]);
        }

        if ($request->limit) {
            $query->limit($request->limit);
        }

        if ($request->bestSelling) {
            $query
                ->withCount('reviews')
                ->withCount('topSell')
                ->orderBy('reviews_count', 'desc')
                ->orderBy('top_sell_count', 'desc');
            // $query->withCount('line_items')->orderByDesc('line_items_count');
        } else if ($request->topRated) {
            $query->orderByDesc('reviews_avg_rate');
        } else if ($request->new) {
            $query->orderByDesc('id');
        } else if ($request->order_by && in_array($request->order, ['asc', 'desc'])) {
            $query->orderBy($request->order_by, $request->order);
        }

        if ($request->segments) {
            return $query->get()->groupBy('type');
        }

        if ($request->has('keyword') && $request->keyword !== null) {

            $perPage = $request->perpage ?? 12;

            // Apply existing filters
            $results = $query->paginate($perPage);

            // Add 10 random data items from the Product model
            $additionalRandomData = Product::inRandomOrder()->withAvg('reviews', 'rate')->with($with)->take(10)->get();

            // Merge the additional data with the original results
            $mergedResults = $results->merge($additionalRandomData);

            // Create a new paginator manually
            $page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $mergedResults->slice(($page - 1) * $perPage, $perPage)->all();

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $mergedResults->count(),
                $perPage,
                $page,
                ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
            );

            return $paginator;
        }

        if ($request->paginate) {

            return $query->paginate($request->perpage ?? 12);
        }

        return $query->get();
    }

    function getNoteDetails(Request $request)
    {
        $id = $request->note;
        $query = Note::where('id', $id)->first();
        return $query;
    }

    function smartRecommendations()
    {
        $quizItems = QuizItem::with('options')->orderBy('serial', 'asc')->get();
        $page = Page::query()->with('metas')->where('slug', 'smart-recommendations')->firstOrFail();

        // push data to klaviyo
        $this->browseProduct(request()->url());
        return inertiaWithMeta($page, compact('quizItems'));
    }

    /**
     * @throws ValidationException
     */
    function smartRecommendationsStore(Request $request)
    {
        $request->validate([
            'type' => 'required|in:feminine,masculine',
            'preference' => 'required|array',
            'preference.*' => 'required|exists:quiz_item_options,id',
        ]);
        if (\auth()->check()) {
            self::setQuizPreferences($request->type, $request->preference);
            return redirect()->route('show.recommendation.products');
        } else {
            session()->put('scent-type', $request->type);
            session()->put('scent-preference', $request->preference);
            return redirect()->route('register', ['quiz' => 1]);
        }
    }

    static function setQuizPreferences($type, $preference)
    {
        try {
            DB::beginTransaction();
            Meta::query()->updateOrCreate(['holder_type' => User::class, 'holder_id' => \auth()->id(), 'name' => 'scent-type'], ['content' => $type]);
            Meta::query()->updateOrCreate(['holder_type' => User::class, 'holder_id' => \auth()->id(), 'name' => 'scent-preference'], ['content' => json_encode($preference)]);
            $preferenceIds = array_values($preference);
            //            $family = Family::query()->withCount(['quiz_options' => function ($q) use ($preferenceIds) {
            //                $q->whereIn('quiz_item_options.id', $preferenceIds);
            //            }])->orderByDesc('quiz_options_count')->first();
            $familyIds = Family::query()->whereHas('quiz_options', function ($q) use ($preferenceIds) {
                $q->whereIn('quiz_item_options.id', $preferenceIds);
            })->pluck('families.id')->toArray();
            if (count($familyIds)) {
                /* @var User $user */
                $user = \auth('web')->user();
                $user->families()->attach($familyIds);
            }
            session()->forget(['scent-type', 'scent-preference']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    function about()
    {
        return inertia('About');
    }

    public
    function showPasswordForm()
    {
        return inertia('User/ChangePassword')->title("Change Password");
    }

    public
    function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed'
        ]);

        if (!Hash::check($request->current_password, $user->password)) throw ValidationException::withMessages(['current_password' => __('Old Password Is wrong')]);

        $p = $user->update(['password' => Hash::make($request->password)]);

        if (!$p) {
            throw ValidationException::withMessages(['current_password' => __('Unable To Update Password')]);
        } else {
            return redirect()->back()->withSuccess(__('Password Updated Successfully'));
        }
    }

    public
    function showPersonalInfoForm()
    {
        return inertia('User/PersonalInfo')->title('Update Personal Info');
    }

    /**
     * @throws ValidationException
     */
    public
    function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'nullable|string|max:191',
            'email' => [
                'required',
                'email:dns',
                'max:191',
                'unique:users,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/', // Allows both Gmail and Yahoo formats
            ],

            'dob' => 'nullable|date',
            'gender' => 'required|string|in:male,female',
            // 'avatar' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000'
        ], [
            'dob.*' => __('Invalid Date Of Birth')
        ]);

        $pera = $request->only(['first_name', 'last_name', 'email', 'gender']);

        if ($request->dob) {
            $pera['dob'] = Carbon::parse($request->dob);
        }

        try {
            if ($request->avatar) {

                $old_avatar = $user->avatar;

                // Use preg_replace to extract the path
                $pattern = '/http[s]?:\/\/[^\s]+\//';
                $replacement = '';
                $updatedString = preg_replace($pattern, $replacement, $old_avatar);

                if (Storage::disk(config('filesystems.default'))->exists('avatar/' . $updatedString)) {
                    Storage::disk(config('filesystems.default'))->delete('avatar/' . $updatedString);
                }

                if (gettype($request->avatar) == 'string') {
                    // Get the base64 encoded image from the request
                    $base64Image = $request->avatar;

                    // Decode the base64 string to binary image data
                    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

                    // Generate a unique filename for the image, e.g., using a timestamp
                    $filename = 'avatar/' . time() . '.png';

                    // Store the image in the S3 bucket
                    Storage::disk(config('filesystems.default'))->put($filename, $imageData);

                    // Optionally, you can save the filename to a database or use it as needed
                    // For example, if you want to display the image, you can return its URL:
                    $imageUrl = Storage::disk(config('filesystems.default'))->url($filename);

                    $pera['avatar'] = $imageUrl;
                } else {
                    $url = uploadImage($request->avatar, 'avatar');
                    $pera['avatar'] = asset($url);
                }
            }
            $p = $user->update($pera);
        } catch (\Exception $exception) {
            report($exception);
        }
        if (!$p) {
            throw ValidationException::withMessages(['first_name' => 'Unable to Update Personal Info']);
        } else {
            return redirect()->back()->withSuccess('Personal Info Updated Successfully');
        }
    }

    public function filter(Request $request, $type = null)
    {
        if ($type == 'cologne') {
            $this->seo(
                'Cologne Search and Filter - Discover Your Next Signature Scent',
                'Browse our collection of over 1600 designer colognes for men, and use our search and filter options to find your ideal scent. Subscribe today and receive monthly samples of your top picks.'
            );
        } else {
            $this->seo(
                'Perfume Search and Filter - Find Your Ideal Scent',
                'Browse our extensive selection of over 1600 designer perfumes for women, and use our search and filter options to find your perfect match. Subscribe today and receive monthly samples of your top picks.'
            );
        }

        $user = $request->user();
        if (!$type) return redirect($user->home);
        $notes = Note::query()->select(['id', 'name'])->get();
        $brands = Brand::query()->select(['id', 'name'])->get();
        $subTypes = ProductSubType::query()->select(['id', 'name'])->whereHas('metas', function ($q) use ($type) {
            /* @var Builder $q */
            $q->where('name', 'add_to')->where('content', $type);
        })->get();
        $taxonomies = Taxonomy::query()->select(['id', 'name'])->with('terms', function ($q) use ($type) {
            /* @var Builder $q */
            $q->select(['id', 'taxonomy_id', 'name', 'image'])->whereHas('metas', function ($q) use ($type) {
                /* @var Builder $q */
                $q->where('name', 'add_to')->where('content', $type);
            });
        })->whereHas('metas', function ($q) use ($type) {
            /* @var Builder $q */
            $q->where('name', 'add_to')->where('content', $type);
        })->whereHas('terms')->get();

        $topTaxonomies = $taxonomies->filter(function ($taxonomy, $taxonomyIndex) {
            return $taxonomyIndex < 2;
        })->map(function ($taxonomy) {
            $taxonomy->setRelation('terms', $taxonomy->terms->filter(function ($term, $termIndex) {
                return $termIndex < 4;
            }));
            return $taxonomy;
        });

        $filterTitle = ucfirst(str_replace('-', ' ', $type));

        // push data to klaviyo
        $this->browseProduct(request()->url());

        return inertia('Filter', compact('type', 'notes', 'brands', 'subTypes', 'taxonomies', 'topTaxonomies', 'filterTitle'))->title($filterTitle);
    }

    public
    function subFilter(Request $request, $type, $slug)
    {
        $user = $request->user();
        if (!$type) return redirect($user->home);
        $notes = Note::query()->select(['id', 'name'])->get();
        $brands = Brand::query()->select(['id', 'name'])->with('metas')->get();
        $subTypes = ProductSubType::query()->select(['id', 'name'])->with('metas')->get();
        $taxonomies = Taxonomy::query()->select(['id', 'name'])->with('terms', function ($q) use ($type) {
            /* @var Builder $q */
            $q->select(['id', 'taxonomy_id', 'name', 'image'])->whereHas('metas', function ($q) use ($type) {
                /* @var Builder $q */
                $q->where('name', 'add_to')->where('content', $type);
            });
        })->whereHas('metas', function ($q) use ($type) {
            /* @var Builder $q */
            $q->where('name', 'add_to')->where('content', $type);
        })->whereHas('terms')->get();

        $topTaxonomies = $taxonomies->filter(function ($taxonomy, $taxonomyIndex) {
            return $taxonomyIndex < 2;
        })->map(function ($taxonomy) {
            $taxonomy->setRelation('terms', $taxonomy->terms->filter(function ($term, $termIndex) {
                return $termIndex < 4;
            }));
            return $taxonomy;
        });

        $filterTitle = ucfirst(str_replace('-', ' ', $type));

        $subType = null;
        if ($slug) {
            $subType = ProductSubType::query()->where('slug', $slug)->firstOrFail();
            $filterTitle = $subType->name;
        }

        return inertia('Filter', compact('type', 'notes', 'brands', 'subTypes', 'taxonomies', 'topTaxonomies', 'subType', 'filterTitle'))->title($filterTitle);
    }

    public function productOfTheMonth($type)
    {
        /* @var Product $product */
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $queue_item = ProductOfTheMonth::where('year', $year)->where('month', $month)->first();
        $product = Product::with(['sub_type', 'purchase_options', 'related_products' => function ($q) {
            $q->with(['product' => function ($p2) {
                $p2->with(['brand'])->withAvg('reviews', 'rate');
            }]);
        }, 'metas', 'terms', 'families', 'labels', 'brand' => function ($q) {
            $q->withCount('products');
        }, 'notes' => function ($q) {
            $q->withCount('products');
        }, 'badges'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->where('status', 'published')
            ->where('id', $queue_item?->product_id)
            ->first();
        if (!$product) {
            return redirect()->back()->withStatus('This month product not found.');
        }

        $already_subscribed = 0;
        if (\auth()->check() && (\auth()->user()->subscription('personal'))) {
            $already_subscribed = 1;
            /* @var User $user */
            $user = \auth()->user();
            $subscription = $user->subscription('personal');
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
        } else {
            $plan = Plan::query()->where('is_default', true)->domain(getCurrentDomain())->first();
        }

        $taxonomies = Taxonomy::query()->with(['terms' => function ($q) {
            $q->withCount('reviews');
        }])->get();

        $reviewsGroupCount = Review::query()->selectRaw('COUNT(*) as total_rate, rate')->where('product_id', $product->id)->groupBy('rate')->pluck('total_rate', 'rate');
        $reviews = $product->reviews()->with(['user', 'terms'])->orderByDesc('created_at')->paginate();
        $NoteExtraText = NoteExtraText::whereNotNull('description_text')->first();

        $products = Product::with('brand')->where('brand_id', $product->brand_id)->latest()->take(12)->get();

        return inertia('Product2', compact('product', 'products', 'already_subscribed', 'plan', 'taxonomies', 'reviewsGroupCount', 'reviews', 'NoteExtraText'));

        // $currentMonth = date('n');
        // $currentYear = date('Y');
        // $productItem = ProductOfTheMonth::where('month', $currentMonth)->where('year', $currentYear)->with('product', function ($query) {
        //     $query->withAvg('reviews', 'rate')->with(['brand', 'notes']);
        // })->where('type', $type)->firstOrFail();

        // if ($productItem) {
        //     $ids = $productItem->product->terms()->pluck('terms.id')->toArray();
        //     $taxonomies = Taxonomy::query()->with(['terms' => function ($q) use ($ids) {
        //         $q->whereIn('terms.id', $ids);
        //     }])->whereHas('terms', function ($q) use ($ids) {
        //         $q->whereIn('terms.id', $ids);
        //     })->get();
        // } else {
        //     $taxonomies = [];
        // }

        // $previousPM = ProductOfTheMonth::query()->selectRaw('*, (year+(month/12)) as cyear')->with('product', function ($q) {
        //     $q->with('brand');
        // })->where('month', '<', $currentMonth)->orWhere('year', '<', $currentYear)->orderByDesc('cyear')->get();
        // // $prod


        // return inertia('productOfTheMonth', compact('productItem', 'previousPM', 'taxonomies'))->title($type . ' of the month');
    }

    public
    function getProductMonth($id)
    {
        $productItem = ProductOfTheMonth::with(['product' => function ($query) {
            $query->withAvg('reviews', 'rate')->with(['brand', 'notes']);
        }])->where('id', $id)->firstOrFail();

        if ($productItem) {
            $ids = $productItem->product->terms()->pluck('terms.id')->toArray();
            $taxonomies = Taxonomy::query()->with(['terms' => function ($q) use ($ids) {
                $q->whereIn('terms.id', $ids);
            }])->whereHas('terms', function ($q) use ($ids) {
                $q->whereIn('terms.id', $ids);
            })->get();
        } else {
            $taxonomies = [];
        }

        $previousPM = ProductOfTheMonth::query()->selectRaw('*, (year+(month/12)) as cyear')->with('product', function ($q) {
            $q->with('brand');
        })->where('month', '<', $productItem->month)->orWhere('year', '<', $productItem->year)->orderByDesc('cyear')->get();

        return inertia('productOfTheMonth', compact('productItem', 'previousPM', 'taxonomies'))->title('Product Of The Month');
    }

    public
    function getProductOfTheMonth()
    {
        $month = now()->format('m');
        $month_name = now()->format('F');
        $year = now()->format('Y');

        $product_of_month = ProductOfTheMonth::where('year', $year)->where('month', $month)->with(['product'])->first();

        if (!$product_of_month) {
            return redirect('/')->withError('There are no product for this month.');
        }

        $product = $product_of_month->product()->with(['sub_type', 'purchase_options', 'related_products' => function ($q) {
            $q->with(['product' => function ($p2) {
                $p2->with(['brand'])->withAvg('reviews', 'rate');
            }]);
        }, 'metas', 'terms', 'families', 'labels', 'brand' => function ($q) {
            $q->withCount('products');
        }, 'notes' => function ($q) {
            $q->withCount('products');
        }, 'badges'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rate')
            ->where('status', 'published')
            ->firstOrFail();

        $already_subscribed = 0;
        if (\auth()->check() && (\auth()->user()->subscription('personal'))) {
            $already_subscribed = 1;
            /* @var User $user */
            $user = \auth()->user();
            $subscription = $user->subscription('personal');
            // $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        } else {
            $plan = Plan::domain(getCurrentDomain())->where('is_default', true)->first();
        }

        $taxonomies = [];
        // $taxonomies = Taxonomy::query()->with(['terms' => function ($q) {
        //     $q->withCount('reviews');
        // }])->get();

        $reviewsGroupCount = Review::query()->selectRaw('COUNT(*) as total_rate, rate')->where('product_id', $product->id)->groupBy('rate')->pluck('total_rate', 'rate');
        $reviews = $product->reviews()->with(['user', 'terms'])->orderByDesc('created_at')->paginate();
        $NoteExtraText = NoteExtraText::whereNotNull('description_text')->first();

        $related_products = Product::where('for', $product->for)
            ->where('type', $product->type)
            ->with(['brand'])
            ->withAvg('reviews', 'rate')
            ->latest()->take(15)->get();

        $seo_description = htmlspecialchars(trim(strip_tags(str_replace("&nbsp;", '', $product->content))));
        // Split the description into sentences using a period followed by a space as the delimiter
        $sentences = preg_split('/\.\s+/', $seo_description);

        // Check if there are at least 2 sentences before accessing them
        if (count($sentences) >= 2) {
            // Display the first two sentences
            $first_tw_sen = $sentences[0] . '. ' . $sentences[1];
        } else {
            // Handle the case when there are not enough sentences
            // For example, set $first_tw_sen to the entire $seo_description
            $first_tw_sen = $seo_description;
        }

        $this->seo(
            $product->title . ' ' . $product->brand?->name,
            $first_tw_sen,
            $product->image['url']
        );

        return inertia('ProductOfTheMonth', compact(
            'product',
            'already_subscribed',
            'plan',
            'taxonomies',
            'reviewsGroupCount',
            'reviews',
            'NoteExtraText',
            'related_products',
            'month_name',
            'product_of_month'
        ))->title('Product of the month');
        // return inertia('AllProductOfTheMonth', compact('product'))->title('Product of the month');
    }

    public
    function collections($type)
    {
        $gen = $type;
        $page = Page::query()->with('metas')->where('slug', 'collection-for-' . $gen)->firstOrFail();
        return inertiaWithMeta($page, compact('gen'));
    }

    public
    function singleCollection($type, $slug)
    {
        $gen = $type;
        $collection = Collection::where('for', $type)->where('slug', $slug)->firstOrFail();
        return inertia('SingleCollection', compact('collection', 'gen'))->title($collection->name);
    }

    public function brand($slug)
    {
        if (!$slug) return abort(404);

        $brand = Brand::where('slug', $slug)->firstOrFail();
        $brandProducts = Product::where("brand_id", $brand->id)->with(["brand", "badges", "labels", "notes"])->withAvg('reviews', 'rate')->get();

        return inertia('Brand', compact('brand', 'brandProducts'))->title($brand->name);
    }

    public function getPage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $data = [];

        if ($page->slug == 'about-us') {

            $data['members'] = TeamMember::latest('id')->get();

            $this->seo(
                'About ScentQ - Our Mission and Story',
                'Learn more about ScentQ and our commitment to providing high-quality, affordable fragrance subscription services. Discover our story and the team behind the brand.'
            );
        }
        if ($page->slug == 'refund-policy') {
            $this->seo(
                'ScentQ Refund Policy - Satisfaction Guaranteed',
                "Learn more about our refund policy and our commitment to customer satisfaction. If you're not completely satisfied with your ScentQ subscription, we'll make it right."
            );
        }
        if ($page->slug == 'terms-and-conditions') {
            $this->seo(
                'ScentQ Terms and Conditions - Know Your Subscription Rights',
                "Read our terms and conditions to understand the rights and responsibilities of your ScentQ subscription. Discover how we protect your privacy and ensure your satisfaction."
            );
        }

        return inertiaWithMeta($page, $data);
    }

    public function contactUs()
    {
        $this->seo(
            'Get In Touch With US',
            "We value your interest and aim to provide exceptional customer service. Our contact page serves as a gateway for you to connect with us effortlessly. Whether you have questions about our fragrances, need assistance with an order, or want to share feedback, our dedicated team is here to help. Find our contact information below, and we look forward to hearing from you and assisting you in any way we can."
        );
        return inertia('ContactUs')->title(__('Get In Touch With US'));
    }

    public function faq()
    {
        $this->seo(
            'Faq',
            "We value your interest and aim to provide exceptional customer service. Our contact page serves as a gateway for you to connect with us effortlessly. Whether you have questions about our fragrances, need assistance with an order, or want to share feedback, our dedicated team is here to help. Find our contact information below, and we look forward to hearing from you and assisting you in any way we can."
        );

        $groups = Cache::remember('faq_group_faqs', now()->addDays(7), function () {
            return FaqGroup::with('faqs')->get();
        });

        return inertia('NewFaqs', [
            'groups' => $groups
        ])->title(__('Faq'));
    }

    public function aboutUs()
    {
        return 333;

        $this->seo(
            'About Us',
            "We value your interest and aim to provide exceptional customer service. Our contact page serves as a gateway for you to connect with us effortlessly. Whether you have questions about our fragrances, need assistance with an order, or want to share feedback, our dedicated team is here to help. Find our contact information below, and we look forward to hearing from you and assisting you in any way we can."
        );
        return inertia('AboutUs')->title(__('Get In Touch With US'));
    }

    public function subscriber(Request $request)
    {
        $param = $request->validate([
            'email' => 'required|email|max:191'
        ]);
        $res = MailSubscriber::query()->updateOrCreate($param);
        return redirect()->back()->withSuccess(__('Subscribed Successfully'));
    }

    public function unsubscribeFromMailList(Request $request, $email)
    {
        $mailItem = MailSubscriber::query()->where('email', $email)->firstOrFail();
        $mailItem->delete();
        return inertia('Unsubscribe', compact('email'))->title(__('Unsubscribed Successfully'));
    }

    public function queuePurchasePage(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        $max_count = 1;
        $policies = QueuePurchasePolicy::all();
        $queue_items = QueueItem::query()->with('product', function ($q) {
            $q->with(['brand', 'purchase_options' => function ($q2) {
                $q2->where('type', 'subscription');
            }]);
        })->whereNotNull('addedBy_type')->whereHas('queue', function ($q) use ($user) {
            /* @var Builder $q */
            $q->where('user_id', $user->id)->whereDoesntHave('order');
        })->get();
        if ($user->subscribed('personal')) {
            $subscription = $user->subscription('personal');
            $plan = Plan::query()->where('stripe_id', $subscription->stripe_price)->first();
            if ($plan) {
                $max_count = $plan->product_count;
            }
        }
        return inertia('QueuePurchase', compact('policies', 'queue_items', 'max_count'))->title('Purchase Queue');
    }

    function queuePurchase(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.purchase_option_id' => 'required|exists:purchase_options,id',
                'policy_id' => 'nullable|exists:queue_purchase_policies,id',
            ]);
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
        /* @var User $user */
        $user = $request->user('web');
        $items = array_map(function ($item) {
            /* @var Product $product */
            $product = Product::findOrFail($item['product_id']);
            if (isset($item['purchase_option_id'])) {
                /* @var PurchaseOption $purchase_option */
                $purchase_option = $product->purchase_options()->findOrFail($item['purchase_option_id']);
            } else {
                $purchase_option = null;
            }
            $params = [
                'product_id' => $product->id,
                'purchase_option_id' => $purchase_option?->id,
                'special' => true,
            ];
            $params['product_title'] = $product->title;
            $params['product_image'] = $product->image ? $product->image['thumb_url'] : null;
            $params['purchase_option'] = $purchase_option?->quantity_text;
            $params['amount'] = $purchase_option?->price ?? 0;
            // $params['amount'] = $purchase_option?->price ?? $product->retail_price;
            $params['quantity'] = 1;
            $params['subtotal'] = $params['quantity'] * $params['amount'];
            // $params['tax'] = round($params['subtotal'] * (($product->tax ?? 0) / 100), config('misc.round')); // tax in percent
            return $params;
        }, $request->items);

        try {
            DB::beginTransaction();
            /* @var Cart $cart */
            $user->cart()->delete();
            $cart = $user->cart()->firstOrCreate([]);
            $policy = QueuePurchasePolicy::where('id', $request->policy_id)->first();
            $net_total = array_reduce($items, function ($acc, $item) {
                return $acc + $item['subtotal'];
            }, 0);
            if ($policy) {
                $amount = count($request->items) - 1;
                $policy_discount = $amount * $policy->discount;
            }
            $cart->items()->createMany($items);
            $cart->update([
                'policy_discount' => $policy_discount ?? 0,
            ]);
            (new CartItemController)->recalculateCartAndCoupon($cart);
            DB::commit();
            return redirect()->route('checkout');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    function getRecommendationsProducts(Request $request)
    {
        $query = Product::query()->withAvg('reviews', 'rate');
        $with = ['brand'];
        if (is_array($request->with)) {
            $with = array_merge($with, $request->with);
        }
        $query->with($with);

        /* @var User $user */
        $user = auth()->user('web');
        if ($user) {
            $familyIds = $user->families()->pluck('families.id');
            $query->whereHas('families', function ($q) use ($familyIds) {
                $q->whereIn('families.id', $familyIds);
            });
        }

        if ($request->paginate) {
            return $query->paginate($request->perpage ?? 12);
        }

        return $query->get();
    }

    function recommendationsProducts()
    {
        $this->seo(
            'Smart Recommendations - Find Your Perfect Fragrance Match',
            "Take our quick and easy fragrance quiz and receive personalized scent recommendations based on your preferences. Subscribe today and start discovering new scents that you'll love."
        );

        $user = auth()->user();
        $quiz_answer = Meta::where('name', 'scent-preference')->where('holder_type', 'App\Models\User')->where('holder_id', $user->id)->first();
        if (!$quiz_answer) {
            return back();
        }

        $quiz_answer_option = json_decode($quiz_answer->content);

        $quiz_items = QuizItemOption::whereIn('id', $quiz_answer_option)->get()->map(function ($q) {
            return $q->title;
        });

        return inertia('RecommendationProducts', compact('quiz_items'))->title('Smart Recommendations - Find Your Perfect Fragrance Match');
    }

    function getPlans()
    {
        $plans = PlanService::getPersonalPlansOrderByProductCount();

        return response()->json(['plans' => $plans]);
    }

    function getRecommendationProduct(Request $request)
    {
        $with = ['brand'];

        if (is_array($request->with)) {
            $with = array_merge($with, $request->with);
        }

        $user = auth()->user('web');

        $cacheKey = 'recommended_product_' . count($with);

        if ($user) {
            $cacheKey .= "_{$user->id}";
        }

        $products = Cache::remember($cacheKey, now()->addHours(6), function () use ($with, $user) {
            $query = Product::query()->withAvg('reviews', 'rate');
            $query->with($with);

            if ($user) {
                $familyIds = $user->families()->pluck('families.id');
                $query->whereHas('families', function ($q) use ($familyIds) {
                    $q->whereIn('families.id', $familyIds);
                });
            }

            return $query->limit(4)->get();
        });

        return $products;
    }

    function getNewProduct(Request $request)
    {
        $with = ['brand', 'purchase_options'];

        if (is_array($request->with)) {
            $with = array_merge($with, $request->with);
        }

        $cacheKey = 'new_products' . count($with);

        $seconds = now()->addMinutes(30)->getTimestamp() - now()->getTimestamp();

        if ($request->has('keyword') && $request->keyword !== null) {
            $query = Product::query()->withAvg('reviews', 'rate');
            $query->with($with);
            $query->latest();

            if ($request->has('keyword') && $request->keyword !== null) {
                $query->where('title', 'LIKE', "$request->keyword%")
                    ->orWhereHas('brand', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "$request->keyword%");
                    });
            }

            // Get the latest 30 products
            $latestProducts = $query->limit(30)->get();

            // Add 10 random data items from the Product model
            $additionalRandomData = Product::inRandomOrder()->withAvg('reviews', 'rate')->with($with)->take(14)->get();

            // Merge the additional data with the original results
            $mergedResults = $latestProducts->merge($additionalRandomData);


            // Randomly pick 10 products from the latest 30 products
            $randomProducts = $mergedResults->random(10);

            return $randomProducts;
        } else {
            $products = Cache::remember($cacheKey, $seconds, function () use ($with, $request) {
                $query = Product::query()->withAvg('reviews', 'rate');
                $query->with($with);
                $query->latest();

                $query->when($request->keyword, function ($q) use ($request) {
                    $q->where('title', 'LIKE', "$request->keyword%");
                });

                // Get the latest 30 products
                $latestProducts = $query->limit(30)->get();

                // Add 10 random data items from the Product model
                $additionalRandomData = Product::inRandomOrder()->withAvg('reviews', 'rate')->with($with)->take(14)->get();

                // Merge the additional data with the original results
                $mergedResults = $latestProducts->merge($additionalRandomData);


                // Randomly pick 10 products from the latest 30 products
                $randomProducts = $mergedResults->random(10);

                return $randomProducts;
            });
        }

        return $products;
    }

    public function getUserCart()
    {
        $user = auth()->id();
        $cart = Cart::where('user_id', $user)
            ->with([
                'items',
                'items.product',
                'items.product.sub_type',
                'items.product.brand',
                'items.product.purchase_options'
            ])
            ->first();

        return response()->json($cart);
    }

    public function filterGender(Request $request, $type = null)
    {
        $gender = "both";

        if ($type == 'cologne') {
            $this->seo(
                'Cologne Search and Filter - Discover Your Next Signature Scent',
                'Browse our collection of over 1600 designer colognes for men, and use our search and filter options to find your ideal scent. Subscribe today and receive monthly samples of your top picks.'
            );
        } elseif ($type == 'men') {
            $gender = 'him';
            $this->seo(
                'Men Search and Filter - Discover Your Next Signature Scent',
                'Browse our collection of over 1600 designer colognes for men, and use our search and filter options to find your ideal scent. Subscribe today and receive monthly samples of your top picks.'
            );
        } elseif ($type == 'women') {
            $gender = 'her';
            $this->seo(
                'Women Search and Filter - Discover Your Next Signature Scent',
                'Browse our collection of over 1600 designer colognes for men, and use our search and filter options to find your ideal scent. Subscribe today and receive monthly samples of your top picks.'
            );
        } else {
            $this->seo(
                'Perfume Search and Filter - Find Your Ideal Scent',
                'Browse our extensive selection of over 1600 designer perfumes for women, and use our search and filter options to find your perfect match. Subscribe today and receive monthly samples of your top picks.'
            );
        }

        $user = $request->user();

        if (!$type) return redirect($user->home);

        $notes = Note::query()->select(['id', 'name'])->get();
        $brands = Brand::query()->select(['id', 'name'])->get();

        $subTypes = ProductSubType::query()->select(['id', 'name'])->whereHas('metas', function ($q) use ($type) {
            /* @var Builder $q */
            $q->where('name', 'add_to')->where('content', $type);
        })->get();


        $taxonomies = Taxonomy::query()->select(['id', 'name'])->with('terms', function ($q) use ($type) {
            /* @var Builder $q */
            $q->select(['id', 'taxonomy_id', 'name', 'image'])->whereHas('metas', function ($q) use ($type) {
                /* @var Builder $q */
                $q->where('name', 'add_to')->where('content', $type);
            });
        })->whereHas('metas', function ($q) use ($type) {
            /* @var Builder $q */
            $q->where('name', 'add_to')->where('content', $type);
        })->whereHas('terms')->get();

        $topTaxonomies = $taxonomies->filter(function ($taxonomy, $taxonomyIndex) {
            return $taxonomyIndex < 2;
        })->map(function ($taxonomy) {
            $taxonomy->setRelation('terms', $taxonomy->terms->filter(function ($term, $termIndex) {
                return $termIndex < 4;
            }));
            return $taxonomy;
        });

        $filterTitle = ucfirst(str_replace('-', ' ', $type));

        // push data to klaviyo
        $this->browseProduct(request()->url());

        return inertia('FilterGender', compact('type', 'notes', 'brands', 'subTypes', 'taxonomies', 'topTaxonomies', 'filterTitle'))->title($filterTitle);
    }


    function getUpcomingShipment()
    {
        if (auth()->check()) {

            $user = auth()->user();
            $order=Order::where('user_id', $user->id)->latest()->first();
            if ($order){
                $shipping_address = OrderAddress::where('order_id', $order->id)->first() ?? '';
            }else{
                $shipping_address = $user->addresses()->where('type', 'shipping')->first() ?? '';
            }
//            $shipping_address = $user->addresses ? $user->addresses->where("type", "shipping")->first() : '';
            $order_count = 1;
            $items = [];
            $date = '';

            // $upcoming_order = $user->orders()
            //     ->where('queue_id', '!=', null)
            //     ->whereMonth('created_at', Carbon::now()->month)
            //     ->where('status', '!=', 'completed')
            //     ->first();
            // if ($upcoming_order) {
            //     $items = $upcoming_order->items()->with('product')->get();
            //     $date = Carbon::now()->format('M d, Y');
            // }

            // if (!$upcoming_order) {
            //     $order_count = 0;
            //     $month = date('n') + 1;
            //     $year = date('Y');
            //     $queue = $user->queues()
            //         ->where('year', $year)
            //         ->where('month', $month)
            //         ->first();
            //     if ($queue) {
            //         $items = $queue->items()->with('product')->get();
            //         $date = Carbon::now()->addMonth(1)->format('M d, Y');
            //     }
            // }

            $order_count = 0;
            $month = date('n');
            $year = date('Y');
            $queue = $user->queues()
                ->where('year', $year)
                ->where('month', $month)
                ->first();
            if ($queue) {
                $items = $queue->items()->with('product')->get();
                $date = Carbon::now()->format('M d, Y');
            }

            return response()->json([
                'address' => $shipping_address,
                'order' => $order_count,
                'products' => $items,
                'date' => $date,
            ]);
        } else {

            return response()->json([
                'status' => 401,
                'message' => 'unauthenticated'
            ]);
        }
    }

    /**
     * get recommendation products for search
     */
    public function getRecommendationsProductsForSearch()
    {
        $products = Product::with(['brand', 'reviews']) // Eager load 'brand' and 'reviews' relationship
        ->whereHas('reviews', function ($query) {
            $query->where('rate', 5)
                ->orWhere('rate', '>', 4);
        })
            ->inRandomOrder()
            ->limit(30)
            ->get();

        return response()->json(['products' => $products]);
    }

    public function getDefaultPlan()
    {
        $user = auth()->user();
        try {
            if ($user->subscription('personal')) {

                $sub = $user->subscription('personal');
                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('stripe_id', $sub?->stripe_price)->first();
            } else {
                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
            }
        } catch (\Throwable $th) {
            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('is_default', true)->first();
        }

        return $plan;
    }

    public function getSubscriptionData(Request $request, $plan = null)
    {
        // if plan come from frontend
        if ($request->plan && $request->plan !== null) {
            FacadesSession::put('select_plan', $request->plan);
            // check plan is exist
            $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $request->plan)->first();
            if (!$plan) {
                $plan = $this->getDefaultPlan();
            }
        } else {
            if (FacadesSession::get('select_plan')) {
                $select_plan = FacadesSession::get('select_plan');

                $plan = Plan::query()->where('type', 'personal')->with(['autoCoupon', 'freeProduct'])->domain(getCurrentDomain())->where('id', $select_plan)->first();
            } else {
                $plan = $this->getDefaultPlan();
            }

        }

        $check_sub = DB::table('subscriptions')->where('user_id', auth()->id())->first();

        $first_time_subscribe = false;
        $total_price = 0;
        if($plan) {
            $total_price = $plan->total_price ?? 0;
        } else {
            $total_price = 0;
        }

        $setting = Settings::first();

        if (is_null($check_sub) && $setting?->first_month_subscribe_discount_status) {

            $plans = json_decode($plan, true);

//            $originalAmount = $plan->price_par_product;
            $totalAmount = 0;
            if($plan) {
                $totalAmount = $plan->totalAmount ?? 0;
            } else {
                $totalAmount = 0;
            }

            $discountedAmount = $setting?->first_month_subscribe_discount_percentage;

            // Convert the percentage to a decimal representation
            // $discountFactor = $discountPercentage / 100;

            // Calculate the discounted amount
            // $discountedAmount = $originalAmount * $discountFactor;

            $resultAmount = $totalAmount - $discountedAmount;


            $plans['total_price'] = $resultAmount;
            $plan = (object)$plans;
            $first_time_subscribe = true;
        }

        $coup = null;
        if (cache()->has('subscribe-extra-coupon-' . auth()->id())) {
            $coup = cache()->get('subscribe-extra-coupon-' . auth()->id());
        }


        return response()->json([
            'first_time_subscribe' => $first_time_subscribe,
            'plan' => $plan,
            'coup' => $coup,
            'total_price' => $total_price
        ]);

        // $plan = Plan::query()->where('is_default', true)->first();
        // $check_sub = DB::table('subscriptions')->where('user_id', auth()->id())->first();
        // $first_time_subscribe = false;

        // if (is_null($check_sub)) {
        //     $plans = json_decode($plan, true);
        //     $price = $plan->total_price / 2;
        //     $plans['total_price'] = $price;
        //     $plan = (object)$plans;
        //     $first_time_subscribe = true;
        // }
    }

    public function newArrivals($type = null)
    {
        $this->seo(
            'New Arrivals - The Latest and Greatest in Designer Fragrances',
            'Stay up-to-date with the newest additions to our collection of over 1600 designer perfumes and colognes. Try something new and exciting every month with ScentQ.'
        );

        // push data to klaviyo
        $this->browseProduct(request()->url());

        return inertia('NewArrivals', compact('type'))->title('New Arrivals - The Latest and Greatest in Designer Fragrances');
    }

    public function subscriptionProductEdit(Request $request)
    {
        session()->put('replace_product', $request->product);
        return redirect()->route('new.arrivals');
    }

    public function cardDeclinedMail()
    {
        $user = auth()->user();

        $view = new CardDeclinedMail($user);
        Mail::to($user->email)->send($view);
        return back();
    }

    public function getRandomProduct()
    {
        $products = Product::inRandomOrder()->withAvg('reviews', 'rate')->with(['brand'])->take(10)->get();

        return response()->json($products);
    }

    public function removeSubscriptionItems()
    {
        $user = auth()->user();
        $cart = Cart::query()->with('items')->firstOrCreate(['user_id' => $user->id]);

        $subs_items = $cart->items()->where('purchase_option_type', 'subscription')->get();
        if ($subs_items) {

            $month = now()->format('m');
            $year = now()->format('Y');
            $queue = $user->queues()->where('year', $year)->where('month', $month)->with('items')->first();

            try {
                foreach ($subs_items as $key => $item) {
                    if ($queue) {
                        $queue_items = $queue->items()->where('product_id', $item->product_id)->first();
                        if ($queue_items) {
                            $queue_items->delete();
                        }
                    }
                    $item->delete();
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        (new CartItemController())->recalculateCartAndCoupon($cart);

        session()->flash('success', 'Subscription item removed.');
        return back();
    }

    public function storeSearchHistory(Request $request)
    {
        try {
            if ($request['value']) {
                $this->searchHistory($request['value']);
            }
            return response(true);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }

    public function ratingHistory(Request $request)
    {
        $user = auth()->user();
        $ratings = $user->reviews()->with(['product.brand'])->latest()->paginate($request->amount ?? 6);

        return inertia('User/RatingHistory', compact('ratings'))->title('Rating & Reviews - The Latest and Greatest in Designer Fragrances');
    }
}
