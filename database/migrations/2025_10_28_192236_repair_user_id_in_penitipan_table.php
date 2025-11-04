<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $tableName = 'penitipan';
        $columnName = 'user_id';

        // HAPUS KOLOM LAMA JIKA ADA
        if (Schema::hasColumn($tableName, $columnName)) {
            // Hapus foreign key dulu
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = ? 
                  AND COLUMN_NAME = ? 
                  AND REFERENCED_TABLE_NAME = 'users'
            ", [$tableName, $columnName]);

            Schema::table($tableName, function (Blueprint $table) use ($foreignKeys) {
                foreach ($foreignKeys as $fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                }
                $table->dropColumn('user_id');
            });
        }

        // BUAT ULANG KOLOM user_id
        Schema::table($tableName, function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->after('kode_struk')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('penitipan', function (Blueprint $table) {
            if (Schema::hasColumn('penitipan', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};