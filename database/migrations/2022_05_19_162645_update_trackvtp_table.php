<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrackvtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // [DATA] => Array
        //         (
        //             [ORDER_NUMBER] => 1684063821201 //             [ORDER_REFERENCE] => 1684063821201 //             [ORDER_STATUSDATE] => 21/04/2022 06:21:31 //             [ORDER_STATUS] => 400 //             [STATUS_NAME] => Nhận bảng kê đến //             [LOCALION_CURRENTLY] => HCM, TTKT3, Trung tâm khai thác 3 - Hồ Chí Minh, 02862938169, 729003, PHƯỜNG TRUNG MỸ TÂY //             [NOTE] => Nhan tai //             [MONEY_COLLECTION] => 36001 //             [MONEY_FEECOD] => 4630 //             [MONEY_TOTALFEE] => 28704 //             [MONEY_TOTAL] => 36001
        
        //             [EXPECTED_DELIVERY] => Khoảng 3 ngày làm việc //             [PRODUCT_WEIGHT] => 240 //             [ORDER_SERVICE] => LCOD //             [ORDER_PAYMENT] => 4 //             [EXPECTED_DELIVERY_DATE] => 24/04/2022 00:00:00 //             [DETAIL] => Array
        //                 (
        //                     [0] => Array
        //                         (
        //                             [CODE] => HGC
        //                             [VALUE] => 4630
        //                         )

        //                 )

        //             [VOUCHER_VALUE] => 0 //             [MONEY_COLLECTION_ORIGIN] => 0 //             [EMPLOYEE_NAME] => Nguyễn Văn Vinh //             [EMPLOYEE_PHONE] => 84372072030 //         )

        //     [TOKEN] => 8805
        Schema::table('trackvtp', function (Blueprint $table) {
            $table->string('status_name');
            $table->string('localion_currently');
            $table->string('expected_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('trackvtp', function (Blueprint $table) {
            $table->dropColumn('status_name');
            $table->dropColumn('localion_currently');
            $table->dropColumn('expected_delivery_date');
        });
    }
}
