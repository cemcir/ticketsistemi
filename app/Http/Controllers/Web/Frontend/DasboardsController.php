<?php

namespace App\Http\Controllers\Web\Frontend;
use App\Business\Abstract\IDashboardService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DasboardsController extends Controller
{
    private IDashboardService $dashboardService;

    function __construct(IDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function Home():View
    {
        $data = $this->dashboardService->Home()->Data();
        return view('frontend.dashboard.home',compact('data'));
    }

}
