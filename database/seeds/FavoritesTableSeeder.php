<?php

use Illuminate\Database\Seeder;
use App\Entities\Question;
class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('Favorites')->delete();

        $users = \App\User::pluck('id')->all();
        $numberOfUsers = count($users);

        foreach(Question::all() as $question){

            for($i = 0; $i <= rand(0, $numberOfUsers-1); $i++){
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }
    }
}
