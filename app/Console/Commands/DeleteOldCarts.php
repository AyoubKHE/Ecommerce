<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\ProductVariation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
    protected $description = 'delete all carts that exceed 3 hours since they were updated ';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $carts = Cart::where('updated_at', '<', Carbon::now()->subHours(3))->get();

        $current_time = Carbon::now();

        $message = "- carts of " . $current_time . "\n";

        if (count($carts) == 0) {

            $message = $message . "There is no available carts\n";
        } else {

            foreach ($carts as $cart) {
                try {

                    DB::transaction(function () use ($cart) {
                        $cart_items = $cart->items;
                        foreach ($cart_items as $cart_item) {

                            $product_variation = ProductVariation::where("id", $cart_item->productVariation_id)->first();

                            $product_variation->quantity_in_stock += (int)$cart_item->quantity;

                            if (!$product_variation->save()) {
                                throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . $product_variation->id . " dans la table 'carts'");
                            }
                        }

                        $cart->delete();
                    });

                } catch (\Exception $e) {

                    $message = $message . "Warning: the cart with id " . $cart->id . " was not deleted succesfully\n";
                }
            }
        }

        if ($message == "- carts of " . $current_time . "\n") {
            $message = $message . "All old carts are deleted succesfully\n";
        }

        echo $message . "\n";
    }
}
