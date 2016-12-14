<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    DB::table('users')->delete();
    User::create(array(
      'email' => 'chirstine@mymail.com',
      'password' => Hash::make('awesome'),
    ));

    User::insert(array(
      'email' => 'joji@mymail.com',
      'password' => Hash::make('august'),
   ));
  }
}
