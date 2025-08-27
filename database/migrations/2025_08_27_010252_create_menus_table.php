<?php

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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();               // mis: 'lucide-home' / 'heroicon-o-cog'
            $table->string('route_name')->nullable()->index();// prefer route_name agar URL stabil
            $table->string('url')->nullable();                // fallback URL manual (eksternal/khusus)
            $table->foreignId('parent_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false);     // hasil sync (boleh kamu edit)
            $table->string('permission_name')->nullable();    // ex: 'access users.index' (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
