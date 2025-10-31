        <?php

        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;

        return new class extends Migration
        {
            /**
             * Run the migrations.
             */
            public function up(): void
            {
                Schema::create('attendance', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('employee_id');
                    $table->string('employee_name');
                    $table->string('department')->nullable();

                    // Date and time fields
                    $table->date('date');   
                    $table->time('clock_in')->nullable();
                    $table->time('clock_out')->nullable();

                    // Attendance flags
                    $table->boolean('is_late')->default(false);
                    $table->boolean('is_half_day')->default(false);

                    // Work location: office / home / other
                    $table->enum('working_from', ['office', 'home', 'other'])->default('office');

                    // Metadata
                    $table->boolean('is_overwritten')->default(false);
                    $table->timestamps();


        });
            }

            /**
             * Reverse the migrations.
             */
            public function down(): void
            {
                Schema::dropIfExists('attendance');
            }
        };
