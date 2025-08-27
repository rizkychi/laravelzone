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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // human readable, ex: "Users Index"
            $table->string('route_name')->nullable()->index(); // ex: users.index
            $table->string('action')->nullable()->index();     // ex: App\Http\Controllers\UserController@index
            $table->string('method')->nullable(); // GET/POST/PUT...
            $table->string('uri')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('permission_name')->unique(); // ex: access users.index
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
