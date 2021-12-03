<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function render_page($page_slug, $page_data = null) {
        // var_dump($page_data);
        if (!$page_data) {
            return view($page_slug);
        }
        return view($page_slug)->with($page_data);
    }
}
