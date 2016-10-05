<?php

use App\Lesson;
use App\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LessonTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $lessonIds = Lesson::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();


        foreach(range(1, 30) as $index)
        {
            $this->createRandomPivots('lesson_tag', $lessonIds, $tagIds);
        }
    }


    private function createRandomPivots($tableName, $firstCollection, $secondCollection)
    {
        $faker = Faker::create();

        $done = false;

        while (!$done) {

            $randomFirstId = $faker->randomElement($firstCollection);
            $randomSecondId = $faker->randomElement($secondCollection);

            $pivot = DB::table($tableName)->where([
                ['lesson_id', '=', $randomFirstId],
                ['tag_id', '=', $randomSecondId],
            ])->get();

            if($pivot->isEmpty()){
                DB::table('lesson_tag')->insert([
                    'lesson_id' => $randomFirstId,
                    'tag_id' => $randomSecondId
                ]);
                $done = true;
            }
        }
    }


}
