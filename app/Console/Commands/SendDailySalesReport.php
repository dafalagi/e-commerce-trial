<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReport;
use App\Models\Auth\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-sales {--date= : Specific date (YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::yesterday();
        $dateString = $date->format('Y-m-d');

        $this->info("Generating daily sales report for {$dateString}...");

        try {
            $sales_data = $this->get_daily_sales_data($date);
            
            $admin_users = User::whereHas('role', function ($query) {
                $query->where('code', 'admin');
            })->get();

            if ($admin_users->isEmpty()) {
                $this->warn('No admin users found to send the report to.');
                return;
            }

            foreach ($admin_users as $admin) {
                Mail::to($admin->email)->send(new DailySalesReport($sales_data, $date, $admin));
                $this->line("Report sent to: {$admin->email}");
            }

            $this->info("Daily sales report sent successfully to {$admin_users->count()} admin(s).");

        } catch (\Exception $e) {
            $this->error("Failed to send daily sales report: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get daily sales data
     */
    private function get_daily_sales_data(Carbon $date)
    {
        $start_of_day = $date->copy()->startOfDay()->timestamp;
        $end_of_day = $date->copy()->endOfDay()->timestamp;

        $orders = DB::table('ord_orders')
            ->where('created_at', '>=', $start_of_day)
            ->where('created_at', '<=', $end_of_day)
            ->where('is_active', 1)
            ->get();

        $order_items = DB::table('ord_order_items as oi')
            ->join('ord_orders as o', 'oi.order_id', '=', 'o.id')
            ->join('prd_products as p', 'oi.product_id', '=', 'p.id')
            ->where('o.created_at', '>=', $start_of_day)
            ->where('o.created_at', '<=', $end_of_day)
            ->where('o.is_active', 1)
            ->where('oi.is_active', 1)
            ->select(
                'oi.product_name',
                'oi.quantity',
                'oi.price',
                'oi.total_price',
                'p.stock as current_stock'
            )
            ->get();

        $total_orders = $orders->count();
        $total_revenue = $order_items->sum('total_price');
        $total_items_sold = $order_items->sum('quantity');
        
        // Top selling products
        $top_products = $order_items->groupBy('product_name')
            ->map(function ($items, $product_name) {
                return [
                    'name' => $product_name,
                    'quantity_sold' => $items->sum('quantity'),
                    'revenue' => $items->sum('total_price'),
                    'current_stock' => $items->first()->current_stock
                ];
            })
            ->sortByDesc('quantity_sold')
            ->take(5)
            ->values();

        // Low stock alerts (products with stock < 10)
        $low_stock_products = DB::table('prd_products')
            ->where('stock', '<', 10)
            ->where('is_active', 1)
            ->select('name', 'stock', 'price')
            ->orderBy('stock', 'asc')
            ->get();

        return [
            'date' => $date,
            'summary' => [
                'total_orders' => $total_orders,
                'total_revenue' => $total_revenue,
                'total_items_sold' => $total_items_sold,
                'average_order_value' => $total_orders > 0 ? $total_revenue / $total_orders : 0
            ],
            'top_products' => $top_products,
            'low_stock_products' => $low_stock_products,
            'all_orders' => $orders,
            'order_items' => $order_items
        ];
    }
}