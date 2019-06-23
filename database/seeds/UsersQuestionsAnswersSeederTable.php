<?php

use Illuminate\Database\Seeder;

class UsersQuestionsAnswersSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();

        factory(\App\User::class, 3)->create()->each(function ($u){
           $u->questions()
             ->saveMany(
                 factory(\App\Entities\Question::class, 10)->make()
             )->each(function ($q){
                 $q->answers()->saveMany(
                     factory(\App\Entities\Answer::class, 5)->make());
               });
        });
    }
}
