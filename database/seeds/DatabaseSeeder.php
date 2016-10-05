<?php

use App\Lesson;
use App\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    private $tables = [
        'lessons',
        'tags',
        'lesson_tag'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();


        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(LessonTagTableSeeder::class);

        Model::reguard();
    }

    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach($this->tables as $tableName){
            DB::table($tableName)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
