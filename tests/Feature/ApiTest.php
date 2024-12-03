<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected $token;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        // Melakukan login untuk mendapatkan token
        $response = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->token = $response['token'];
    }

    public function testCreateCompany()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->postJson('/api/companies', [
            'name' => 'Company Name',
            'email' => 'company@gmail.com',
            'phone' => '1234567890',
        ]);

        $response->assertStatus(201);
    }

    public function testLoginCompany(){
        $response = $this->postJson('/api/login', [
            'email' => 'company@gmail.com',
            'password' => 'password',
        ]);
        $this->token = $response['token'];
        $response->assertStatus(200);

    }
    public function testCreateEmployee()
    {
        $user = User::factory()->create();
        $user->addRole('manajer');

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response['token'],
            'Accept' => 'application/json',
        ])->postJson('/api/employee', [
            'name' => 'faisal',
            'email' => 'faisal@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id', 'name', 'email', 'created_at', 'updated_at',
        ]);
    }

    public function testLoginEmployee(){
        $user = User::factory()->create();
        $user->addRole('karyawan');
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function testGetEmployee()
    {
        $user = User::factory()->create();
        $user->addRole('manajer');

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response['token'],
            'Accept' => 'application/json',
        ])->getJson('/api/employee');

        $response->assertStatus(200);
    }

    public function testUpdateEmployee()
    {
        $user = User::factory()->create();
        $user->addRole('manajer');

        $user = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $karyawan = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
            'Accept' => 'application/json',
        ])->postJson('/api/employee', [
            'name' => 'faisal',
            'email' => 'faisaldwiki@gmail.com',
            'phone' => '08123456789',
            'address' => 'Jl. Raya Jakarta',
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
            'Accept' => 'application/json',
        ])->putJson('/api/employee/' . $karyawan['id'], [
            'name' => 'faisal dwiki',
            'email' => 'faisaldwiki@gmail.com',
            'phone' => '08123456789',
            'address' => 'Jl. Raya Jakarta2',
        ]);
        $response->assertStatus(200);
    }

    public function testShowEmployee()
    {
        $user = User::factory()->create();
        $user->addRole('manajer');
        $user = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $karyawan = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
            'Accept' => 'application/json',
            ])->get('/api/employee');

        $karyawan->assertStatus(200);
    }

    public function testDeleteEmployee()
    {
        $user = User::factory()->create();
        $user->addRole('manajer');

        $user = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $karyawan = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
            'Accept' => 'application/json',
        ])->postJson('/api/employee', [
            'name' => 'faisal',
            'email' => 'faisal1@gmail.com',
            'phone' => '08123456789',
            'address' => 'Jl. Raya Jakarta',
            'password' => 'password',
        ]);
        // dd($karyawan->json( ));
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
            'Accept' => 'application/json',
        ])->deleteJson('/api/employee/' . $karyawan['id']);

        $response->assertStatus(200);
    }
}
