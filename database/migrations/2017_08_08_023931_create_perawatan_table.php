<!-- <php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerawatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perawatan', function (Blueprint $table) {
            $table->primary('kode_perawatan');
            $table->string('kode_perawatan');
            $table->string('no_induk');
            $table->string('kode_barang');
            $table->datetime('tgl_perawatan');
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
        Schema::dropIfExists('perawatan');
    }
} -->
