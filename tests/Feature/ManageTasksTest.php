<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_task()
    {
        // User memngunjungi halaman Daftar Task
        $this->visit('/tasks');

        // Isi form `name` dan `description` kemudian submit
        $this->submitForm('Create Task', [
            'name' => 'My First Task',
            'description' => 'This is my first task on my new job.',
        ]);

        // Lihat Record tersimpan ke database
        $this->seeInDatabase('tasks', [
            'name' => 'My First Task',
            'description' => 'This is my first task on my new job.',
            'is_done' => 0,
        ]);

        // Redirect ke halaman Daftar Task
        $this->seePageIs('/tasks');

        // Tampil hasil task yang telah diinput
        $this->see('My First Task');
        $this->see('This is my first task on my new job.');
    }

    /** @test */
    public function task_entry_must_pass_validation()
    {
        // Submit form untuk membuat task baru
        // dengan field name description kosong
        $this
            ->visit('/tasks')
            ->submitForm('Create Task', [
                'name' => '',
                'description' => '',
            ]);

        // Cek pada tampilan apakah ada error untuk field nama dan description
        $this
            ->see(__('validation.required', ['attribute' => 'name']))
            ->see(__('validation.required', ['attribute' => 'description']));
    }

    /** @test */
    public function user_can_browser_tasks_index_page()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function user_can_edit_an_existing_task()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function user_can_delete_an_existing_task()
    {
        $this->assertTrue(true);
    }
}
