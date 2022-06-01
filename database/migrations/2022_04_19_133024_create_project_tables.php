<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         \Illuminate\Support\Facades\DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');

        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('full_name');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('name', 'deleted_at');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained('countries');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country_id', 'name', 'deleted_at']);
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained('countries');
            $table->enum('appointment_scheme', [1, 2, 3, 4, 5, 6]); // see AppointmentSchemeEnum
            $table->string('name');
            $table->string('full_name');
            $table->string('description');
            $table->string('full_description', '');
            $table->string('logotype')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country_id', 'name', 'deleted_at']);
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies');
            $table->foreignUuid('city_id')->constrained('cities');
            $table->enum('appointment_scheme', [1, 2, 3, 4, 5, 6]); // see AppointmentSchemeEnum
            $table->string('name');
            $table->string('full_name');
            $table->string('description');
            $table->string('full_description', '');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies');
            $table->string('name');
            $table->string('full_name');
            $table->string('description');
            $table->string('full_description', '');
            $table->unsignedInteger('duration');
            $table->boolean('group_order_flag')
                ->default(false)
                ->comment('Service ordered for a group of people');
            $table->unsignedTinyInteger('min_simultaneous_customers')
                ->nullable()
                ->comment('Minimum number of simultaneous customers for a service');
            $table->unsignedTinyInteger('max_simultaneous_customers')
                ->nullable()
                ->comment('Maximum number of simultaneous customers for a service');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'name', 'deleted_at']);
            $table->index('company_id');
        });

        Schema::create('workplaces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->string('name');
            $table->string('full_name');
            $table->string('description');
            $table->string('full_description', '')->nullable();
            $table->boolean('group_order_flag')
                ->default(false)
                ->comment('Service ordered for a group of people');
            $table->unsignedTinyInteger('min_simultaneous_customers')
                ->nullable()
                ->comment('Minimum number of simultaneous customers for a workplace');
            $table->unsignedTinyInteger('max_simultaneous_customers')
                ->nullable()
                ->comment('Maximum number of simultaneous customers for a workplace');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'name', 'deleted_at']);
            $table->index('branch_id');
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('photo')->nullable();
            $table->string('description');
            $table->string('full_description', '')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('customer', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained('companies');
            $table->string('mobile_number', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'mobile_number', 'deleted_at']);
            $table->unique(['company_id', 'email', 'deleted_at']);
            $table->index('company_id');
        });

        Schema::create('branch_employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->foreignUuid('employee_id')->constrained('employees');
            $table->timestamps();

            $table->unique(['branch_id', 'employee_id']);
            $table->index('branch_id');
        });

        Schema::create('branch_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->foreignUuid('service_id')->constrained('services');
            $table->timestamps();

            $table->unique(['branch_id', 'service_id']);
            $table->index('branch_id');
        });

        Schema::create('service_employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->foreignUuid('service_id')->constrained('services');
            $table->foreignUuid('employee_id')->constrained('employees');
            $table->unsignedSmallInteger('priority_level')->nullable();
            $table->timestamps();

            $table->unique(['branch_id', 'service_id', 'employee_id']);
            $table->index('service_id');
            $table->index('employee_id');
        });

        Schema::create('service_workplaces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->foreignUuid('service_id')->constrained('services');
            $table->foreignUuid('workplace_id')->constrained('workplaces');
            $table->unsignedSmallInteger('priority_level')
                ->nullable()
                ->comment('Priority of assigning an employee providing a service');
            $table->timestamps();

            $table->unique(['branch_id', 'service_id', 'workplace_id']);
            $table->index('service_id');
            $table->index('workplace_id');
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('schedule_type', [1, 2, 3, 4]); // see ScheduleTypeEnum
            $table->foreignUuid('branch_id')->constrained('branches');
            $table->foreignUuid('employee_id')->nullable()->constrained('employees');
            $table->foreignUuid('workplace_id')->nullable()->constrained('workplaces');
            $table->enum('time_step', [1, 5, 10, 15, 20, 30, 60]) // see TimeStepEnum
                ->comment('Time step in minutes');
            $table->unsignedSmallInteger('number_available_days')->nullable()
                ->comment('Number of days available for appointment from the current date');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'employee_id', 'workplace_id', 'deleted_at']);
            $table->index('workplace_id');
            $table->index('employee_id');
        });

        Schema::create('intervals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['start_time', 'end_time', 'deleted_at']);
        });

        Schema::create('work_day_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_id')->constrained('schedules');
            $table->foreignUuid('interval_id')->constrained('intervals');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['schedule_id', 'interval_id', 'date', 'deleted_at']);
            $table->index('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_workplaces');
        Schema::dropIfExists('service_employees');
        Schema::dropIfExists('branch_services');
        Schema::dropIfExists('branch_employees');

        Schema::dropIfExists('work_day_schedules');
        Schema::dropIfExists('intervals');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('workplaces');
        Schema::dropIfExists('services');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('countries');
    }
};
