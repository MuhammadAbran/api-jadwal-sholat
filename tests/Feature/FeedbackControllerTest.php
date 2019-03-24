<?php

namespace Tests\Feature;

use App\Feedback;
use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        if (!Route::has('feedback.index')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $feedback = factory(Feedback::class, 5)->create();

        $response = $this->get(route('feedback.index')."?search=lorem");
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('feedback.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        if (!Route::has('feedback.create')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('feedback.create'));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        if (!Route::has('feedback.store')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('feedback.store'), factory(Feedback::class)->make()->toArray());
        if ($response->getStatusCode() == 422) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return json_encode(session()->all(), JSON_PRETTY_PRINT); });
            return;
        }
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testShow()
    {
        if (!Route::has('feedback.show')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $feedback = factory(Feedback::class)->create();

        $response = $this->get(route('feedback.show', [ $feedback->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('feedback.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        if (!Route::has('feedback.edit')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $feedback = factory(Feedback::class)->create();

        $response = $this->get(route('feedback.edit', [ $feedback->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('feedback.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        if (!Route::has('feedback.update')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $feedback = factory(Feedback::class)->create();

        $response = $this->put(route('feedback.update', [ $feedback->getKey() ]), factory(Feedback::class)->make()->toArray());
        if ($response->getStatusCode() == 422) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return json_encode(session()->all(), JSON_PRETTY_PRINT); });
            return;
        }
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     * @throws \Exception
     */
    public function testDestroy()
    {
        if (!Route::has('feedback.destroy')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $feedback = factory(Feedback::class)->create();

        $response = $this->delete(route('feedback.destroy', [ $feedback->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
