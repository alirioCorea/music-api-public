<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Subscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $subscriptions = Subscription::where('renewal_date', Carbon::now()->toDateString())->get();
            foreach ($subscriptions as $subscription) {
              $lastPayment=Payment::where('subscription_id',$subscription->id)->orderBy('payment_date','desc')->first();

                $payment = Payment::create([
                    'subscription_id' => $subscription->id,
                    'payment_method' => $subscription->payment_method,
                    'payment_date' => Carbon::now()->toDateString(),
                    'total' => $lastPayment->total,
                ]);
                $subscription->renewal_date = Carbon::now()->addMonth()->toDateString();
                $subscription->save();
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
