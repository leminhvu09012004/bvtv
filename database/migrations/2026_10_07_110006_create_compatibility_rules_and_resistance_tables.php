<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_code', 50)->unique();
            $table->enum('scope', ['product_specific', 'group_specific'])->default('group_specific');
            $table->enum('entity_a_type', ['product', 'chemical_group']);
            $table->string('entity_a_key', 100);
            $table->enum('entity_b_type', ['product', 'chemical_group']);
            $table->string('entity_b_key', 100);
            $table->enum('status', ['FORBIDDEN', 'AVOID', 'COMPATIBLE', 'UNKNOWN'])->default('UNKNOWN');
            $table->integer('priority')->default(100); // Product: 200, Group: 100
            $table->string('title');
            $table->text('reason'); // Cơ chế hóa lý
            $table->text('conditions')->nullable(); // Điều kiện (thời tiết, thứ tự pha)
            $table->enum('source_type', ['manufacturer_label', 'extension_manual', 'scientific_paper', 'official_standard']);
            $table->string('source_reference'); // Tên tài liệu trích dẫn thật
            $table->enum('confidence', ['HIGH', 'MEDIUM', 'LOW'])->default('HIGH');
            $table->text('advice');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['entity_a_key', 'entity_b_key']);
            $table->index('priority');
        });

        Schema::create('resistance_profiles', function (Blueprint $table) {
            $table->id();
            $table->enum('code_type', ['FRAC', 'IRAC', 'HRAC']);
            $table->string('code_value', 50); // vd "FRAC 11", "IRAC 4A"
            $table->string('target_site_of_action');
            $table->enum('risk_level', ['HIGH', 'MEDIUM', 'LOW'])->default('MEDIUM');
            $table->string('cross_resistance_group', 100)->nullable();
            $table->text('rotation_advice');
            $table->timestamps();

            $table->unique(['code_type', 'code_value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resistance_profiles');
        Schema::dropIfExists('compatibility_rules');
    }
};
