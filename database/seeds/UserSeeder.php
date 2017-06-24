<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('seeds.users', []);

        if (empty($users)) {
            factory(User::class, 10)->create();
        } else {
            foreach ($users as $user) {
                $middleName = (isset($user['middle']) && !empty($user['middle'])) ? $user['middle'] : null;
                $email = (isset($user['email']) && !empty($user['email'])) ? $user['email'] : null;

                factory(User::class)->create([
                    'first_name' => $user['first'],
                    'middle_name' => $middleName,
                    'last_name' => $user['last'],
                    'email' => $email
                ]);
            }
        }
    }
}
