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
        Schema::table('contact_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_messages', 'first_name')) {
                $table->string('first_name');
            }
            if (!Schema::hasColumn('contact_messages', 'last_name')) {
                $table->string('last_name')->nullable();
            }
            if (!Schema::hasColumn('contact_messages', 'email')) {
                $table->string('email');
            }
            if (!Schema::hasColumn('contact_messages', 'message')) {
                $table->text('message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'email', 'message']);
        });
    }
};
