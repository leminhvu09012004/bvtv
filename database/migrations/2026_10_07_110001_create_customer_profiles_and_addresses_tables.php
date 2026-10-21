<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_code', 50)->unique();
            $table->string('full_name');
            $table->string('phone', 20)->index();
            $table->string('crop_type')->nullable(); // vd: Sầu riêng, Tiêu, Cà phê
            $table->decimal('farm_area_hectares', 8, 2)->nullable();
            $table->unsignedBigInteger('total_spent')->default(0);
            $table->unsignedInteger('loyalty_points')->default(0);
            $table->enum('loyalty_tier', ['standard', 'silver', 'gold', 'vip'])->default('standard')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_profile_id')->constrained('customer_profiles')->cascadeOnDelete();
            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            $table->unsignedInteger('province_id')->default(0);
            $table->string('province_name', 100);
            $table->unsignedInteger('district_id')->default(0);
            $table->string('district_name', 100);
            $table->unsignedInteger('ward_id')->default(0);
            $table->string('ward_name', 100);
            $table->string('street_address', 255);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
        Schema::dropIfExists('customer_profiles');
    }
};
