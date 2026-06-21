<?php

use App\Models\Company;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new companies can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'company_name' => 'PT Test Company',
        'industry' => 'Technology',
        'address' => 'Jl. Test No. 1',
        'phone' => '08123456789',
        'contact_person' => 'Test Person',
        'description' => 'A test company',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('company.pending', absolute: false));

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'role' => 'company',
    ]);

    $this->assertDatabaseHas('companies', [
        'name' => 'PT Test Company',
        'industry' => 'Technology',
    ]);
});
