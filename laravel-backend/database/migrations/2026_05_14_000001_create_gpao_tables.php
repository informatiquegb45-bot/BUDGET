<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('unit', 20);
            $table->enum('type', ['finished', 'component', 'semi_finished']);
            $table->timestamps();
        });

        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_product_id')->constrained('products');
            $table->foreignId('component_id')->constrained('products');
            $table->decimal('qty', 12, 3);
            $table->timestamps();
        });

        Schema::create('work_centers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedInteger('capacity')->default(1);
            $table->timestamps();
        });

        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('work_center_id')->constrained();
            $table->unsignedInteger('setup_time')->default(0);
            $table->unsignedInteger('cycle_time')->default(0);
            $table->timestamps();
        });

        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('product_id')->constrained();
            $table->decimal('qty_planned', 12, 3);
            $table->decimal('qty_done', 12, 3)->default(0);
            $table->enum('status', ['draft', 'planned', 'released', 'in_progress', 'completed', 'closed', 'cancelled'])->default('draft');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('work_order_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('operation_id')->constrained();
            $table->timestamp('planned_start')->nullable();
            $table->timestamp('planned_end')->nullable();
            $table->timestamp('actual_start')->nullable();
            $table->timestamp('actual_end')->nullable();
            $table->string('status', 30)->default('planned');
            $table->timestamps();
        });

        Schema::create('stock_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('stock_moves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('location_id')->constrained('stock_locations');
            $table->enum('move_type', ['consume', 'produce', 'adjust_in', 'adjust_out']);
            $table->decimal('qty', 12, 3);
            $table->foreignId('work_order_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_moves');
        Schema::dropIfExists('stock_locations');
        Schema::dropIfExists('work_order_operations');
        Schema::dropIfExists('work_orders');
        Schema::dropIfExists('operations');
        Schema::dropIfExists('work_centers');
        Schema::dropIfExists('bom_items');
        Schema::dropIfExists('products');
    }
};
