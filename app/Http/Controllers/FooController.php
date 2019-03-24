<?php

namespace App\Http\Controllers;

use App\Foo;
use Illuminate\Http\Request;

/**
 * FooController
 */
class FooController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param Foo $foo
     * @return array
     */
    public static function relations(Request $request = null, Foo $foo = null)
    {
        return [
            'foo' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'childs', 'label' => ucwords(__('foos.childs')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('foos.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param Foo $foo
     * @return array
     */
    public static function visibles(Request $request = null, Foo $foo = null)
    {
        return [
            'index' => [
                'foo' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('foos.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('foos.name')) ],
                ]
            ],
            'show' => [
                'foo' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('foos.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('foos.name')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param Foo $foo
     * @return array
     */
    public static function fields(Request $request = null, Foo $foo = null)
    {
        return [
            'create' => [
                'foo' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('foos.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('foos.name')), 'required' => true ],
                ]
            ],
            'edit' => [
                'foo' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('foos.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('foos.name')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param Foo $foo
     * @return array
     */
    public static function rules(Request $request = null, Foo $foo = null)
    {
        return [
            'store' => [
                //'parent_id' => 'required|exists:parents,id',
                'name' => 'required|string|max:255',
            ],
            'update' => [
                //'parent_id' => 'exists:parents,id',
                'name' => 'string|max:255',
            ]
        ];
    }

    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $foos = Foo::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Foo');

        return response()->view('foos.index', [
            'foos' => $foos,
            'relations' => self::relations(request()),
            'visibles' => self::visibles(request())['index']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', 'App\Foo');

        return response()->view('foos.create', [
            'fields' => self::fields(request())['create']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Foo');
        $request->validate(self::rules($request)['store']);

        $foo = new Foo;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $foo->{$key} = $request->file($key)->store('foos');
                } elseif ($request->exists($key)) {
                    $foo->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $foo->{$key} = $request->{$key};
            }
        }
        $foo->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('foos.show', $foo->getKey());

        return $response->withInput([ $foo->getForeignKey() => $foo->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Foo $foo
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Foo $foo)
    {
        $this->authorize('view', $foo);

        return response()->view('foos.show', [
            'foo' => $foo,
            'relations' => self::relations(request(), $foo),
            'visibles' => self::visibles(request(), $foo)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Foo $foo
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Foo $foo)
    {
        $this->authorize('update', $foo);

        return response()->view('foos.edit', [
            'foo' => $foo,
            'fields' => self::fields(request(), $foo)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Foo $foo
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Foo $foo)
    {
        $this->authorize('update', $foo);
        $request->validate(self::rules($request, $foo)['update']);

        foreach (self::rules($request, $foo)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $foo->{$key} = $request->file($key)->store('foos');
                } elseif ($request->exists($key)) {
                    $foo->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $foo->{$key} = $request->{$key};
            }
        }
        $foo->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('foos.show', $foo->getKey());

        return $response->withInput([ $foo->getForeignKey() => $foo->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Foo $foo
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Foo $foo)
    {
        $this->authorize('delete', $foo);
        $foo->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/foos/'.$foo->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('foos.index');

        return $response->with('status', __('Success'));
    }
}
