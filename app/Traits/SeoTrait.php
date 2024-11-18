<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;

trait SeoTrait
{
    public function seo(string $title = null, string $description = null, string $image = null)
    {
        $logo = asset('images/meta-logo.png');

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);
        // if ($image) {
            OpenGraph::addImage($image ?? $logo);
        // }
    }
}
