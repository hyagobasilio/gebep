<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('posts')->insert([
         	
            'title' => str_random(20),
            'content' => str_random(100).'@gmail.com',
    	]);
    }
}
