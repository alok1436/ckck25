<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $json = File::get("database/data/users.json");
        $users = json_decode($json);
  
        foreach ($users as $key => $value) {
            User::create([
                "name" => $value->name,
                "email" => $value->email,
                "password" => $value->password,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                "isActive" => $value->isActive,
                "isDelete" => $value->isDelete,
            ]);
        }
    }
}
