<?php

namespace App\Providers;

use App\Models\RequestBarang;
use App\Models\ProblemReport;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapThree();

        View::composer('*', function ($view) {
            // BADGE REQUEST
            $notifRequestAcc = RequestBarang::where('status_po', 0)->count();
            $notifRequestAdmin = RequestBarang::where('closed_by', null)->count();

            if (Auth::check()){
            $notifRequestUser = RequestBarang::where('user_id', Auth::id())->where('status_client', 0)->count();
                if($notifRequestUser == '0') {
                    $notifRequestUser = '';
                }
            } else {
                $notifRequestUser = '';
            }

            // BADGE PROBLEM REPORT
            $notifReportAdmin = ProblemReport::where('closed_by', null)->count();
            if($notifReportAdmin == '0') {
                $notifReportAdmin = '';
            }

            if (Auth::check()){
            $notifReportUser = ProblemReport::where('user_id', Auth::id())->where('status_client', 0)->count();
                if($notifReportUser == '0') {
                    $notifReportUser = '';
                }
            } else {
                $notifReportUser = '';
            }

            return $view->with([
                'notifRequestAcc' => $notifRequestAcc,
                'notifRequestAdmin' => $notifRequestAdmin,
                'notifRequestUser' => $notifRequestUser,
                'notifReportAdmin' => $notifReportAdmin,
                'notifReportUser' => $notifReportUser,
            ]);
        });
    }
}
