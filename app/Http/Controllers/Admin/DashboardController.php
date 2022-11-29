<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Controller for the dashboard
 */
class DashboardController extends Controller
{
    /**
     * Shows the controller
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $title = 'Dashboard';
        $crumbStart = 'Admin';
        $crumbEnd = 'Dashboard';

        return view('admin.dashboard', compact(
            'title',
            'crumbStart',
            'crumbEnd'
        ));
    }
}
