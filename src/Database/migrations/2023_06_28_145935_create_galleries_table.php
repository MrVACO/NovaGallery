<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MrVaco\NovaStatusesManager\Classes\StatusClass;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function(Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->json('images')->nullable();
            $table->integer('year')->nullable();
            $table->integer('status')->default(StatusClass::DEFAULT_ID());
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
