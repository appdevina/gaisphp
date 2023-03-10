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
            $userDivisi = Auth::user()->division_id ?? '';
            
            // BADGE REQUEST
            $notifRequestAcc = RequestBarang::where('status_po', 0)->where('request_type_id', 1)->count();
            if($notifRequestAcc == '0') {
                $notifRequestAcc = '';
            }

            $notifRequestAdmin = RequestBarang::where('closed_by', null)->count();
            if($notifRequestAdmin == '0') {
                $notifRequestAdmin = '';
            }

            $notifRequestApprov = RequestBarang::where('closed_by', null)
            ->whereHas('request_type', function($q) use($userDivisi) { $q->where('pic_division_id', $userDivisi); })
            ->count();
            if($notifRequestApprov == '0') {
                $notifRequestApprov = '';
            }

            if (Auth::check()){
            $notifRequestUser = RequestBarang::where('user_id', Auth::id())->where('status_client', 0)->count();
                if($notifRequestUser == '0') {
                    $notifRequestUser = '';
                }
            } else {
                $notifRequestUser = '';
            }

            // BADGE PROBLEM REPORT
            //KALAU DIVISI HCM TAMPILIN NOTIF REPORT YANG GANGGUAN UMUM AJA
            if ($userDivisi == 4) {
                $notifReportAdmin = ProblemReport::where('closed_by', null)
                ->where('pr_category_id', 7)
                ->count();
            } else {
                $notifReportAdmin = ProblemReport::where('closed_by', null)
                ->where('pr_category_id', '!=', 7)
                ->count();
            }

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
                'notifRequestApprov' => $notifRequestApprov,
                'notifRequestUser' => $notifRequestUser,
                'notifReportAdmin' => $notifReportAdmin,
                'notifReportUser' => $notifReportUser,
            ]);
        });
    }
}
