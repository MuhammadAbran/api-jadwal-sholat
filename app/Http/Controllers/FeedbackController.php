<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;

/**
 * FeedbackController
 */
class FeedbackController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null $request
     * @param Feedback $feedback
     * @return array
     */
    public static function relations(Request $request = null, Feedback $feedback = null)
    {
        return [
            'feedback' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    //[ 'name' => 'childs', 'label' => ucwords(__('feedback.childs')) ],
                ], // also for morphMany, hasManyThrough
                'hasOne' => [
                    //[ 'name' => 'child', 'label' => ucwords(__('feedback.child')) ],
                ], // also for morphOne
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null $request
     * @param Feedback $feedback
     * @return array
     */
    public static function visibles(Request $request = null, Feedback $feedback = null)
    {
        return [
            'index' => [
                'feedback' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('feedback.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('feedback.name')) ],
                ]
            ],
            'show' => [
                'feedback' => [
                    //[ 'name' => 'parent', 'label' => ucwords(__('feedback.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => ucwords(__('feedback.name')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null $request
     * @param Feedback $feedback
     * @return array
     */
    public static function fields(Request $request = null, Feedback $feedback = null)
    {
        return [
            'create' => [
                'feedback' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('feedback.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('feedback.name')), 'required' => true ],
                ]
            ],
            'edit' => [
                'feedback' => [
                    //[ 'field' => 'select', 'name' => 'parent_id', 'label' => ucwords(__('feedback.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //    return [ 'value' => $parent->id, 'text' => $parent->name ];
                    //})->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => ucwords(__('feedback.name')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null $request
     * @param Feedback $feedback
     * @return array
     */
    public static function rules(Request $request = null, Feedback $feedback = null)
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
        $feedback = Feedback::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Feedback');

        return response()->view('feedback.index', [
            'feedback' => $feedback,
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
        $this->authorize('create', 'App\Feedback');

        return response()->view('feedback.create', [
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
        $this->authorize('create', 'App\Feedback');
        $request->validate(self::rules($request)['store']);

        $feedback = new Feedback;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $feedback->{$key} = $request->file($key)->store('feedback');
                } elseif ($request->exists($key)) {
                    $feedback->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $feedback->{$key} = $request->{$key};
            }
        }
        $feedback->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('feedback.show', $feedback->getKey());

        return $response->withInput([ $feedback->getForeignKey() => $feedback->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Feedback $feedback
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Feedback $feedback)
    {
        $this->authorize('view', $feedback);

        return response()->view('feedback.show', [
            'feedback' => $feedback,
            'relations' => self::relations(request(), $feedback),
            'visibles' => self::visibles(request(), $feedback)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feedback $feedback
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Feedback $feedback)
    {
        $this->authorize('update', $feedback);

        return response()->view('feedback.edit', [
            'feedback' => $feedback,
            'fields' => self::fields(request(), $feedback)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Feedback $feedback
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Feedback $feedback)
    {
        $this->authorize('update', $feedback);
        $request->validate(self::rules($request, $feedback)['update']);

        foreach (self::rules($request, $feedback)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $feedback->{$key} = $request->file($key)->store('feedback');
                } elseif ($request->exists($key)) {
                    $feedback->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $feedback->{$key} = $request->{$key};
            }
        }
        $feedback->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('feedback.show', $feedback->getKey());

        return $response->withInput([ $feedback->getForeignKey() => $feedback->getKey() ])
            ->with('status', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feedback $feedback
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Feedback $feedback)
    {
        $this->authorize('delete', $feedback);
        $feedback->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/feedback/'.$feedback->getKey()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('feedback.index');

        return $response->with('status', __('Success'));
    }
}
