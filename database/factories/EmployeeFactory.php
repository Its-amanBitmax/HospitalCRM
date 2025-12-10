<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'employee_code' => 'EMP' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => Hash::make('password'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'date_of_birth' => $this->faker->date('Y-m-d', '-30 years'),
            'status' => 'active',
            'department_id' => null,
            'designation' => $this->faker->jobTitle(),
            'joining_date' => $this->faker->date('Y-m-d', '-2 years'),
            'salary' => $this->faker->numberBetween(30000, 100000),
            'address' => $this->faker->address(),
            'emergency_contact' => $this->faker->phoneNumber(),
            'qualification' => $this->faker->sentence(),
            'experience_years' => $this->faker->numberBetween(0, 20),
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
