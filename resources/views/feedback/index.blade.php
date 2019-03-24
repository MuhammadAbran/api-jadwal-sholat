@extends('layouts.app')

@section('content-title', ucwords(__('feedback.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2 offset-md-2',
  'panel_title' => ucwords(__('feedback.plural')),
  'resource_route' => 'feedback',
  'model_variable' => 'feedback',
  'model_class' => \App\Feedback::class,
  'models' => $feedback,
  'action_buttons_view' => 'generator::components.models.index.action_buttons',
])
