<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('available_message_status')->delete();
      Status::create(array(
        'status' => 'inbox',
      ));

      Status::insert(array(
        'status' => 'sent',
      ));

      Status::insert(array(
       'status' => 'drafts',
      ));

      Status::insert(array(
       'status' => 'trash'
      ));
    }
}
