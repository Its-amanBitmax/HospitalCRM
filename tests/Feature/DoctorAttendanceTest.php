<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class DoctorAttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test doctor
        $this->doctor = Employee::factory()->create([
            'status' => 'active',
        ]);

        // Authenticate as doctor
        Auth::guard('doctor')->login($this->doctor);
    }

    /** @test */
    public function doctor_can_clock_in_successfully()
    {
        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_in',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
                'server_info' => [
                    'user_agent' => 'Test Agent',
                    'platform' => 'Test Platform',
                    'language' => 'en-US',
                    'cookie_enabled' => true,
                    'online' => true,
                    'timestamp' => now()->toISOString()
                ]
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Clocked In Successfully!']);

        $this->assertDatabaseHas('attendances', [
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_in' => now()->format('H:i:s'),
            'check_in_latitude' => 12.9716,
            'check_in_longitude' => 77.5946,
            'check_in_location' => 'Bangalore, Karnataka, India',
        ]);
    }

    /** @test */
    public function doctor_can_clock_out_successfully()
    {
        // First clock in
        Attendance::create([
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_in' => now()->subHours(8)->format('H:i:s'),
            'check_in_latitude' => 12.9716,
            'check_in_longitude' => 77.5946,
            'check_in_location' => 'Bangalore, Karnataka, India',
        ]);

        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_out',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
                'server_info' => [
                    'user_agent' => 'Test Agent',
                    'platform' => 'Test Platform',
                    'language' => 'en-US',
                    'cookie_enabled' => true,
                    'online' => true,
                    'timestamp' => now()->toISOString()
                ]
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Clocked Out Successfully!']);

        $this->assertDatabaseHas('attendances', [
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_out' => now()->format('H:i:s'),
            'check_out_latitude' => 12.9716,
            'check_out_longitude' => 77.5946,
            'check_out_location' => 'Bangalore, Karnataka, India',
            'status' => 'present',
        ]);
    }

    /** @test */
    public function doctor_cannot_clock_in_twice_on_same_day()
    {
        // First clock in
        Attendance::create([
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_in' => now()->subHours(1)->format('H:i:s'),
        ]);

        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_in',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
            ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Already Clocked In!']);
    }

    /** @test */
    public function doctor_cannot_clock_out_without_clocking_in()
    {
        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_out',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
            ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Clock In first!']);
    }

    /** @test */
    public function doctor_cannot_clock_out_twice_on_same_day()
    {
        // Clock in and out
        Attendance::create([
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_in' => now()->subHours(8)->format('H:i:s'),
            'check_out' => now()->subHours(1)->format('H:i:s'),
        ]);

        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_out',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
            ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Already Clocked Out!']);
    }

    /** @test */
    public function attendance_marking_requires_valid_type()
    {
        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'invalid_type',
            ]);

        $response->assertStatus(422); // Validation error
    }

    /** @test */
    public function late_clock_in_marks_as_half_day()
    {
        // Set time to after 9:30 AM
        $lateTime = now()->setHour(10)->setMinute(0);

        $this->travelTo($lateTime);

        $response = $this->actingAs($this->doctor, 'doctor')
            ->postJson('/doctor/attendance/mark', [
                'type' => 'clock_in',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'location' => 'Bangalore, Karnataka, India',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('attendances', [
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'status' => 'half_day',
        ]);
    }

    /** @test */
    public function attendance_view_shows_correct_data()
    {
        // Create attendance record
        Attendance::create([
            'employee_id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'check_in' => '09:00:00',
            'check_out' => '18:00:00',
            'status' => 'present',
        ]);

        $response = $this->actingAs($this->doctor, 'doctor')
            ->get('/doctor/attendence');

        $response->assertStatus(200)
            ->assertViewHas('attendance')
            ->assertViewHas('history');
    }
}
