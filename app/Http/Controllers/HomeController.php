<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserDownloads;
use App\Models\UserMemberships;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('membership.details')->has('membership')->get();
        $recent_users = $users->sortByDesc('id')->take(30);
        $newbie = $users->where('membership.details.id', '=', '1');
        $nerds = $users->where('membership.details.id', '=', '2');
                
        $grouped_nerds = $nerds->groupBy(function ($d) {
            return Carbon::parse($d->created_at)->format('n');
        });

        $grouped_newbie = $newbie->groupBy(function ($d) {
            return Carbon::parse($d->created_at)->format('n');
        });

        $earnings = Transaction::sum('amount');
        $last_week_earnings = Transaction::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('amount');
        $current_week_earnings = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        $percent_earnings = !$last_week_earnings ? 0 : ($current_week_earnings - $last_week_earnings) / ($current_week_earnings + $last_week_earnings) * 100;


        $subscriptions = UserMemberships::where('status', 1)->count();
        $last_week_subscriptions = UserMemberships::where('status', 1)->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $current_week_subscriptions = UserMemberships::where('status', 1)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $percent_subscriptions = !$last_week_subscriptions ? 0 : ($current_week_subscriptions - $last_week_subscriptions) / ($current_week_subscriptions + $last_week_subscriptions) * 100;

        $downloads = UserDownloads::count();
        $last_week_downloads = UserDownloads::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $current_week_downloads = UserDownloads::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $percent_downloads = !$last_week_downloads ? 0 : ($current_week_downloads - $last_week_downloads) / ($current_week_downloads + $last_week_downloads) * 100;

        return view(
            'pages.dashboard',
            compact(
                "users",
                "recent_users",
                "newbie",
                "nerds",
                "grouped_nerds",
                "grouped_newbie",
                "earnings",
                "percent_earnings",
                "subscriptions",
                "percent_subscriptions",
                "downloads",
                "percent_downloads"
            )
        );
    }
}
