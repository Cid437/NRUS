<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 12, 2)->default(0);
                $table->string('category')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        } else {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'category')) {
                    $table->string('category')->nullable()->after('price');
                }
                if (!Schema::hasColumn('products', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products')) {
            if (Schema::hasColumn('products', 'category')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropColumn('category');
                });
            }

            if (!Schema::hasColumn('products', 'category') && !Schema::hasColumn('products', 'deleted_at')) {
                Schema::dropIfExists('products');
            }
        }
    }
};
