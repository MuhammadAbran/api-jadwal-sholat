<?php

namespace Tests\Feature;

use App\Foo;
use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FooControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        if (!Route::has('foos.index')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $foos = factory(Foo::class, 5)->create();

        $response = $this->get(route('foos.index')."?search=lorem");
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('foos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        if (!Route::has('foos.create')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('foos.create'));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('foos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        if (!Route::has('foos.store')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('foos.store'), factory(Foo::class)->make()->toArray());
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
        if (!Route::has('foos.show')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $foo = factory(Foo::class)->create();

        $response = $this->get(route('foos.show', [ $foo->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('foos.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        if (!Route::has('foos.edit')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $foo = factory(Foo::class)->create();

        $response = $this->get(route('foos.edit', [ $foo->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('foos.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        if (!Route::has('foos.update')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $foo = factory(Foo::class)->create();

        $response = $this->put(route('foos.update', [ $foo->getKey() ]), factory(Foo::class)->make()->toArray());
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
        if (!Route::has('foos.destroy')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $foo = factory(Foo::class)->create();

        $response = $this->delete(route('foos.destroy', [ $foo->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
