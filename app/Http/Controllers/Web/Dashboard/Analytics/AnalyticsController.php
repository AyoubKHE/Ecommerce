<?php

namespace App\Http\Controllers\Web\Dashboard\Analytics;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnalyticsController extends Controller
{
    public function index() {
        return view("dashboard.analytics.index");
    }
}
