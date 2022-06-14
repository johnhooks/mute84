<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Create the initial users and assign roles.
   *
   * @return void
   */
  public function run()
  {
    // create demo users
    $user = \App\Models\User::factory()->create([
      'name' => 'Example User',
      'email' => 'test@example.com',
      'password' => Hash::make('password'),
      'slug' => 'example-user',
    ]);
    $user->assignRole('creator');

    $user = \App\Models\User::factory()->create([
      'name' => 'Example Admin User',
      'email' => 'admin@example.com',
      'password' => Hash::make('password'),
      'slug' => 'admin-user',
    ]);
    $user->assignRole('admin');

    $user = \App\Models\User::factory()->create([
      'name' => 'Example Super User',
      'email' => 'super@example.com',
      'password' => Hash::make('password'),
      'slug' => 'super-user',
    ]);
    $user->assignRole('super');
  }
}
