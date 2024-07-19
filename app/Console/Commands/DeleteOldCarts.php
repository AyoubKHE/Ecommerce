<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Cart;
use Illuminate\Console\Command;

class DeleteOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete all carts that exceed 24 hours since they were updated ';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $carts = Cart::where('updated_at', '<', Carbon::now()->subHours(24))->get();

        $current_time = Carbon::now();

        $message = "- carts of " . $current_time . "\n";

        if (count($carts) == 0) {

            $message = $message . "There is no available carts\n";
        } else {

            foreach ($carts as $cart) {
                try {

                    $cart->delete();

                } catch (\Exception $e) {

                    $message = $message . "Warning: the cart with id " . $cart->id . " was not deleted succesfully\n";
                }

            }

        }

        if($message == "- carts of " . $current_time . "\n") {
            $message = $message . "All old carts are deleted succesfully\n";
        }

        echo $message . "\n";
    }
}
