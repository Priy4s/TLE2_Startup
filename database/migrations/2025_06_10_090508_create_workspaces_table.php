<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

#Schema::create('workspace_items', function (Blueprint $table) {
       # $table->id();
       # $table->foreignId('workspace_id')->constrained()->onDelete('cascade');
        #$table->enum('type', ['file', 'link', 'deadline', 'note']);
       # $table->text('content')->nullable(); // voor tekst, link of notitie
        #$table->string('file_path')->nullable(); // voor bestandsupload
       # $table->timestamp('deadline')->nullable(); // voor deadlines
       # $table->timestamps();
    #});


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
