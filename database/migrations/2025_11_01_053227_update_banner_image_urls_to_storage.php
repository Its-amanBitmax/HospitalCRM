<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update image_url from /assets/image/ to /storage/uploads/banners/
        DB::table('banners')
            ->where('image_url', 'like', '/assets/image/%')
            ->update([
                'image_url' => DB::raw("REPLACE(image_url, '/assets/image/', '/storage/uploads/banners/')")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the update
        DB::table('banners')
            ->where('image_url', 'like', '/storage/uploads/banners/%')
            ->update([
                'image_url' => DB::raw("REPLACE(image_url, '/storage/uploads/banners/', '/assets/image/')")
            ]);
    }
};
