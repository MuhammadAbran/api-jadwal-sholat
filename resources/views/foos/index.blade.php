@extends('layouts.app')

@section('content-title', ucwords(__('foos.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('foos.plural')),
  'resource_route' => 'foos',
  'model_variable' => 'foo',
  'model_class' => \App\Foo::class,
  'models' => $foos,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
