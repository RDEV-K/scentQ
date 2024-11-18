<?php

namespace Tests\Feature\Staff;

use App\Models\Badge;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BadgeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_stuff_can_visit_badge_index_page()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $this->get(route('staff.badge.index'))
            ->assertStatus(200);
    }

    public function test_stuff_can_visit_badge_create_page()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $this->get(route('staff.badge.create'))
            ->assertStatus(200);
    }

    public function test_stuff_can_record_a_new_badge()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $data = [
            "name" => "ok",
            "description" => "<p>okok</p>",
            'image' => 'image.jpg',
        ];

        $this->post(route('staff.badge.store'), $data)
            ->assertStatus(302);

        expect(Badge::count())->toBe(1);
    }

    public function test_stuff_fails_to_record_a_new_badge_for_validation()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $data = [
            "description" => "<p>okok</p>",
            'image' => UploadedFile::fake()->create('image.jpg', 1024),
        ];

        $this->post(route('staff.badge.store'), $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['image', 'name']);

        expect(Badge::count())->toBe(0);
    }


    public function test_stuff_can_update_existing_badge()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $data = [
            "name" => "ok",
            "description" => "<p>okok</p>",
            'image' => 'image.jpg',
        ];

        $this->post(route('staff.badge.store'), $data)
            ->assertStatus(302);

        $data = [
            "name" => "Update",
            "description" => "<p>okok</p>",
            'image' => 'image.jpg',
        ];

        $this->put(route('staff.badge.update',1), $data)
            ->assertStatus(302);

        expect(Badge::first()->name)->toBe('Update');
    }

    public function test_stuff_fails_to_update_existing_badge_for_validation()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $data = [
            "name" => "ok",
            "description" => "<p>okok</p>",
            'image' => 'image.jpg',
        ];

        $this->post(route('staff.badge.store'), $data)
            ->assertStatus(302);

        $data = [
            'name'=>'Update',
            "description" => "<p>okok</p>",
            'image' => UploadedFile::fake()->create('image.jpg', 1024),
        ];

        $this->put(route('staff.badge.update',1), $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['image']);

        expect(Badge::first()->name)->toBe('ok');
    }

    public function test_stuff_can_delete_existing_badge()
    {
        $user = Staff::create([
            'name' => 'test',
            'username' => 'test',
            'email' => 'test@mail.com',
            'password' => bcrypt('password'),
        ]);


        $this->actingAs($user, 'staff');

        $data = [
            "name" => "ok",
            "description" => "<p>okok</p>",
            'image' => 'image.jpg',
        ];

        $this->post(route('staff.badge.store'), $data)
            ->assertStatus(302);

        $this->delete(route('staff.badge.destroy',1))
            ->assertStatus(302);

        expect(Badge::count())->toBe(0);
    }
}
