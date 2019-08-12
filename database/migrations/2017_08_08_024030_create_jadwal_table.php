<!-- <php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->primary('kode_jadwal');
            $table->string('kode_jadwal');
            $table->string('kode_makul');
            $table->string('no_induk');
            $table->string('kode_kelas');
            $table->string('kode_ruang');
            $table->string('hari');
            $table->string('jam_masuk');
            $table->string('jam_keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
} -->
