<?php

use App\Lesson;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonsTest extends ApiTester
{
    // Behavior-Driven Development. Also take a look at Behat (behat.org)

    use Factory;

    /** @test */
    public function it_fetches_lessons()
    {
        $this->times(5)->make(Lesson::class);

        $this->getJson('api/v1/lessons');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_lesson()
    {
        $this->make(Lesson::class);

        $lesson = $this->getJson('api/v1/lessons/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($lesson, 'title', 'body');
    }

    /** @test */
    public function it_404s_if_a_lesson_is_not_found()
    {
        $json = $this->getJson('api/v1/lessons/x');

        $this->assertResponseStatus(404);
        $this->assertObjectHasAttributes($json, 'error');
    }

    /** @test */
    public function it_creates_a_new_lesson_given_valid_parameters()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)->getJson('api/v1/lessons', 'POST', $this->getStub());

        $this->assertResponseStatus(201);
    }

    /** @test */
    public function it_throws_a_422_if_a_new_lesson_request_fails_validation()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)->getJson('api/v1/lessons', 'POST');

        $this->assertResponseStatus(422);
    }

    protected function getStub()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'some_bool' =>$this->faker->boolean
        ];
    }
}
