<?php

namespace App\Http\Controllers\Web\Backend;

use App\Business\Abstract\IDashboardService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardsController extends Controller
{
    private IDashboardService $dashboardService;

    function __construct(IDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function Dashboard():View {
        $data = $this->dashboardService->Dashboard()->Data();
        return view('backend.dashboard.dashboard',compact('data'));
    }

}
