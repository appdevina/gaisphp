<?php

namespace App\Console\Commands;

use App\Models\RequestBarang;
use App\Models\RequestApproval;
use App\Models\ProblemReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AutoApprove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autoapprove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is command to auto approve status_client on table Request & ProblemReport';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ##AUTO APPROVE PROBLEM REPORT
        $date24HoursAgo = Carbon::now()->subHours(24)->toDateTimeString();

        $problems = DB::table('problem_report')
        ->where('closed_by','!=', null)
        ->where('status_client', 0)
        ->whereDate('closed_at', '<', $date24HoursAgo)
        ->get();
        
        foreach ($problems as $problem) {
            DB::table('problem_report')
            ->where('id', $problem->id)
            ->update(['status_client' => 1]);
        }

        ##AUTO APPROVE REQUEST
        // $requestBarangs = RequestBarang::with('request_approval')
        // ->where('status_client', 0)
        // ->whereHas('request_approval', function ($q) {
        //     $q->where('approval_type', 'EXECUTOR')
        //     ->where('approved_by', '!=', null);
        // })
        // ->whereHas('request_approval', function ($q) {
        //     $q->where('approval_type', 'ENDUSER')
        //     ->where('approved_by', null);
        // })
        // ->get();

        // $requestApproval = RequestApproval::whereIn('request_id', $requestBarangs->pluck('id'))->get();

        // foreach ($requestApproval as $ra) {
        //     if ($ra->approval_type  == 'ENDUSER') {
        //         $ra->approved_by = 1;
        //         $ra->approved_at = Carbon::now();
        //         $ra->save();
        //     }
        // }

        // foreach ($requestBarangs as $rb) {
        //     $rb->status_client = 1;
        //     $rb->save();
        // }

        return $this->info('Successfully approved !');
    }
}
