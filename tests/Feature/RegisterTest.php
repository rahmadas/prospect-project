<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use WithFaker;

    /**
     * Test registrasi pengguna berhasil.
     */
    public function test_can_register_a_user()
    {
        // Data pengguna palsu untuk pengujian
        $userData = [
            'first_name' => 'goku',
            'last_name' => 'name',
            'email' => 'goku@gmail.com',
            // 'inviter_referral_code' => $this->faker->optional()->randomNumber(),
            'password' => '12345678', // Ganti dengan format password yang diinginkan
            'password_confirmation' => '12345678', // Optional foto profile
        ];

        // Mengirimkan permintaan POST ke endpoint /api/register
        $response = $this->postJson('/api/register', $userData);

        // Cetak respons untuk debugging
        $response->dump();

        // Memastikan respons HTTP 201 Created jika registrasi berhasil
        $response->assertStatus(201);

        // Memastikan struktur JSON respons sesuai dengan yang diharapkan
        $response->assertJsonStructure([
            'data' => [
                'id',
                'full_name',
                'foto_profile',
                'first_name',
                'last_name',
                'email',
                'password',
                'password_confirmation',
                'status',
                'referral_code',
                'access_token',
            ],
            'message',
            'status',
        ]);

        // Memastikan nilai-nilai tertentu dalam respons JSON
        $response->assertJson([
            'data' => [
                'first_name' => 'ngatim',
                'last_name' => 'name',
                'email' => 'ngatim@gmail.com',
            ],
            'message' => 'Register Success',
            'status' => true,
        ]);
    }

    /**
     * Test validasi memerlukan password_confirmation.
     */
    // public function test_requires_password_confirmation()
    // {
    //     // Data pengguna tanpa password_confirmation
    //     $userData = [
    //         'name' => $this->faker->name,
    //         'email' => $this->faker->unique()->safeEmail,
    //         'password' => 'password', // Ganti dengan format password yang diinginkan
    //         // password_confirmation tidak disertakan
    //     ];

    //     // Mengirimkan permintaan POST ke endpoint /api/register
    //     $response = $this->postJson('/api/register', $userData);

    //     // Memastikan respons HTTP 422 Unprocessable Entity (asumsi validasi error)
    //     $response->assertStatus(422);

    //     // Memastikan terjadi error validasi terkait dengan field 'password'
    //     $response->assertJsonValidationErrors('password');
    // }

    // /**
    //  * Test validasi email harus unik.
    //  */
    // public function test_email_must_be_unique()
    // {
    //     // Membuat pengguna dengan menggunakan factory
    //     $existingUser = User::factory()->create();

    //     // Data pengguna dengan menggunakan email yang sudah ada
    //     $userData = [
    //         'name' => $this->faker->name,
    //         'email' => $existingUser->email,
    //         'password' => 'password', // Ganti dengan format password yang diinginkan
    //         'password_confirmation' => 'password',
    //     ];

    //     // Mengirimkan permintaan POST ke endpoint /api/register
    //     $response = $this->postJson('/api/register', $userData);

    //     // Memastikan respons HTTP 422 Unprocessable Entity (asumsi validasi error)
    //     $response->assertStatus(422);

    //     // Memastikan terjadi error validasi terkait dengan field 'email'
    //     $response->assertJsonValidationErrors('email');
    // }
}