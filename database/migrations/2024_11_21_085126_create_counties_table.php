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
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->integer('county_code');
            $table->string('county_name');
            $table->timestamps();
        });

        DB::table('counties')->insert([
            ['id' => 1, 'county_code' => 1, 'county_name' => 'ALBA'],
            ['id' => 2, 'county_code' => 2, 'county_name' => 'ARAD'],
            ['id' => 3, 'county_code' => 3, 'county_name' => 'ARGEȘ'],
            ['id' => 4, 'county_code' => 4, 'county_name' => 'BACĂU'],
            ['id' => 5, 'county_code' => 5, 'county_name' => 'BIHOR'],
            ['id' => 6, 'county_code' => 6, 'county_name' => 'BISTRIȚA-NĂSĂUD'],
            ['id' => 7, 'county_code' => 7, 'county_name' => 'BOTOȘANI'],
            ['id' => 8, 'county_code' => 8, 'county_name' => 'BRAȘOV'],
            ['id' => 9, 'county_code' => 9, 'county_name' => 'BRĂILA'],
            ['id' => 10, 'county_code' => 10, 'county_name' => 'BUZĂU'],
            ['id' => 11, 'county_code' => 11, 'county_name' => 'CARAȘ-SEVERIN'],
            ['id' => 12, 'county_code' => 51, 'county_name' => 'CĂLĂRAȘI'],
            ['id' => 13, 'county_code' => 12, 'county_name' => 'CLUJ'],
            ['id' => 14, 'county_code' => 13, 'county_name' => 'CONSTANȚA'],
            ['id' => 15, 'county_code' => 14, 'county_name' => 'COVASNA'],
            ['id' => 16, 'county_code' => 15, 'county_name' => 'DÂMBOVIȚA'],
            ['id' => 17, 'county_code' => 16, 'county_name' => 'DOLJ'],
            ['id' => 18, 'county_code' => 17, 'county_name' => 'GALAȚI'],
            ['id' => 19, 'county_code' => 52, 'county_name' => 'GIURGIU'],
            ['id' => 20, 'county_code' => 18, 'county_name' => 'GORJ'],
            ['id' => 21, 'county_code' => 19, 'county_name' => 'HARGHITA'],
            ['id' => 22, 'county_code' => 20, 'county_name' => 'HUNEDOARA'],
            ['id' => 23, 'county_code' => 21, 'county_name' => 'IALOMIȚA'],
            ['id' => 24, 'county_code' => 22, 'county_name' => 'IAȘI'],
            ['id' => 25, 'county_code' => 23, 'county_name' => 'ILFOV'],
            ['id' => 26, 'county_code' => 24, 'county_name' => 'MARAMUREȘ'],
            ['id' => 27, 'county_code' => 25, 'county_name' => 'MEHEDINȚI'],
            ['id' => 28, 'county_code' => 26, 'county_name' => 'MUREȘ'],
            ['id' => 29, 'county_code' => 27, 'county_name' => 'NEAMȚ'],
            ['id' => 30, 'county_code' => 28, 'county_name' => 'OLT'],
            ['id' => 31, 'county_code' => 29, 'county_name' => 'PRAHOVA'],
            ['id' => 32, 'county_code' => 30, 'county_name' => 'SATU MARE'],
            ['id' => 33, 'county_code' => 31, 'county_name' => 'SĂLAJ'],
            ['id' => 34, 'county_code' => 32, 'county_name' => 'SIBIU'],
            ['id' => 35, 'county_code' => 33, 'county_name' => 'SUCEAVA'],
            ['id' => 36, 'county_code' => 34, 'county_name' => 'TELEORMAN'],
            ['id' => 37, 'county_code' => 35, 'county_name' => 'TIMIȘ'],
            ['id' => 38, 'county_code' => 36, 'county_name' => 'TULCEA'],
            ['id' => 39, 'county_code' => 37, 'county_name' => 'VASLUI'],
            ['id' => 40, 'county_code' => 38, 'county_name' => 'VÂLCEA'],
            ['id' => 41, 'county_code' => 39, 'county_name' => 'VRANCEA'],
            ['id' => 42, 'county_code' => 40, 'county_name' => 'BUCUREȘTI']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counties');
    }
};
