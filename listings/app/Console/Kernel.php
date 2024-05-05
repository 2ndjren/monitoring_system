<?php

namespace App\Console;

use App\Mail\Send_Contract_Has_Ended_Message;
use App\Models\contract;
use App\Models\notification;
use App\Models\user;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $today = Carbon::today();
            $contracts = contract::where('status', '!=', 'Completed')->get();
            foreach ($contracts as $contract) {
                if ($contract->contract_end <= $today) {
                    $contract->update(['status' => 'Completed']);
                    $notification = new notification();
                    $users = user::all();
                    foreach ($users as $user) {
                        $notification->target_id = $contract->con_id;
                        $notification->user_id = $user->user_id;
                        $notification->event = "Contract Expired";
                        $notification->heading = "Contract Completed";
                        $notification->content = "The property " . $contract->property . " - " . $contract->building . " " . $contract->unit . " (" . $contract->unit_type . ") contract has ended";
                        $notification->notified = "0";
                        $notification->status = "Sending";
                        if ($notification->save()) {
                            $mail = [
                                'property' => $contract->property,
                                'start' => $contract->contract_start,
                                'end' => $contract->contract_end,
                                'status' => "Completed",
                                'con_id' => $contract->con_id,
                            ];
                            Mail::to($user->email)->send(new Send_Contract_Has_Ended_Message($mail));
                        }
                    }
                } else {
                    $due = Carbon::parse($contract->due_date);
                    $days = $today->diffInDays($due);
                    $today > $due ? $status = "$days Days Past Due" : $status = "$days Days Remaining";

                    $contract->update(['status' => $status]);
                }
            }
        })->everyFifteenSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
