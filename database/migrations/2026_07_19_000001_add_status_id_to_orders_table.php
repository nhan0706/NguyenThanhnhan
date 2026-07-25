<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('status_id')->default(1)->after('customer_id')->constrained('order_statuses');
        });

        // Migrate data
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $statusId = 1;
            switch ($order->status) {
                case '1':
                    $statusId = 2;
                    break;
                case '2':
                    $statusId = 3;
                    break;
                case '3':
                    $statusId = 4;
                    break;
                case '4':
                    $statusId = 5;
                    break;
                case '0':
                case 'pending':
                default:
                    $statusId = 1;
                    break;
            }

            DB::table('orders')->where('id', $order->id)->update([
                'status_id' => $statusId
            ]);
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('total_amount');
        });

        // Rollback data if needed
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $statusStr = 'pending';
            switch ($order->status_id) {
                case 1:
                    $statusStr = '0';
                    break;
                case 2:
                    $statusStr = '1';
                    break;
                case 3:
                    $statusStr = '2';
                    break;
                case 4:
                    $statusStr = '3';
                    break;
                case 5:
                    $statusStr = '4';
                    break;
            }
            DB::table('orders')->where('id', $order->id)->update([
                'status' => $statusStr
            ]);
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
