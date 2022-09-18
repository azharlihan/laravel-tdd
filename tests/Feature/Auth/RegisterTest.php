<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private function getRegisterFields($overrides = [])
    {
        return array_merge([
            'name'                  => 'John Thor',
            'email'                 => 'username@example.net',
            'password'              => 'secreteightchar',
            'password_confirmation' => 'secreteightchar',
        ], $overrides);
    }

    /** @test */
    public function user_can_register()
    {
        // Kunjungi halaman '/register'
        $this->visit('/register');

        // Submit form register dengan name, email dan password 2 kali
        $this->submitForm('Register', $this->getRegisterFields());

        // Lihat halaman ter-redirect ke url '/home' (register sukses).
        $this->seePageIs('/home');

        // Kita melihat halaman tulisan "Dashboard" pada halaman itu.
        $this->seeText('Dashboard');

        // Lihat di database, tabel users, data user yang register sudah masuk
        $this->seeInDatabase('users', [
            'name'  => 'John Thor',
            'email' => 'username@example.net',
        ]);

        // Cek hash password yang tersimpan cocok dengan password yang diinput
        $this->assertTrue(app('hash')->check('secreteightchar', User::first()->password));
    }

    /** @test */
    public function user_name_is_required()
    {
        // Submit form untuk register dengan field 'name' kosong.
        $this->post('/register', $this->getRegisterFields(['name' => '']));

        // Cek pada session apakah ada error untuk field 'name'.
        $this->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_name_maximum_is_255_characters()
    {
        // Submit form untuk register dengan field 'name' 260 karakter.
        $this->post('/register', $this->getRegisterFields([
            'name' => str_repeat('John Thor ', 26)
        ]));

        // Cek pada session apakah ada error untuk field 'name'.
        $this->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_email_is_required()
    {
        // Submit form untuk register dengan field 'email' kosong.
        $this->post('/register', $this->getRegisterFields(['email' => '']));

        // Cek pada session apakah ada error untuk field 'email'.
        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_must_be_a_valid_email()
    {
        // Submit form untuk register dengan field 'email' tidak valid.
        $this->post('/register', $this->getRegisterFields([
            'email' => 'username.example.net',
        ]));

        // Cek pada session apakah ada error untuk field 'email'.
        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_maximum_is_255_characters()
    {
        // Submit form untuk register dengan field 'email' 260 karakter.
        $this->post('/register', $this->getRegisterFields([
            'email' => str_repeat('username@example.net', 13),
        ]));

        // Cek pada session apakah ada error untuk field 'email'.
        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_must_be_unique_on_users_table()
    {
        // Buat satu user baru
        User::factory()->create(['email' => 'emailsama@example.net']);

        // Submit form untuk register dengan field
        // 'email' yang sudah ada di tabel users.
        $this->post('/register', $this->getRegisterFields([
            'email' => 'emailsama@example.net',
        ]));

        // Cek pada session apakah ada error untuk field 'email'.
        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_password_is_required()
    {
        // Submit form untuk register dengan field 'password' kosong.
        $this->post('/register', $this->getRegisterFields(['password' => '']));

        // Cek pada session apakah ada error untuk field 'password'.
        $this->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_password_minimum_is_6_characters()
    {
        // Submit form untuk register dengan field 'password' 8 karakter.
        $this->post('/register', $this->getRegisterFields(['password' => 'ecret']));

        // Cek pada session apakah ada error untuk field 'password'.
        $this->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_password_must_be_same_with_password_confirmation_field()
    {
        // Submit form untuk register dengan field 'password'
        // beda dengan 'password_confirmation'.
        $this->post('/register', $this->getRegisterFields([
            'password'              => 'secret',
            'password_confirmation' => 'escret',
        ]));

        // Cek pada session apakah ada error untuk field 'password'.
        $this->assertSessionHasErrors(['password']);
    }
}
