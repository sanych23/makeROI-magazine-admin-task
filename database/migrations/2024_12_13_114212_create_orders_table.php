<?php

use App\Enums\OrderStatusType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->primary();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('status');
            $table->integer('amo_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
