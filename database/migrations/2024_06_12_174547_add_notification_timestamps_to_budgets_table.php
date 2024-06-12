<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationTimestampsToBudgetsTable extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->timestamp('last_partially_spent_notification')->nullable();
            $table->timestamp('last_completely_spent_notification')->nullable();
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('last_partially_spent_notification');
            $table->dropColumn('last_completely_spent_notification');
        });
    }
}
