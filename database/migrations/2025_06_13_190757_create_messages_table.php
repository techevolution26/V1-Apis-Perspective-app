<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $t) {
            $t->id();
            $t
                ->foreignId('from_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $t
                ->foreignId('to_user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $t->text('body');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
