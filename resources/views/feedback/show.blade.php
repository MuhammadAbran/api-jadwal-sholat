@extends('layouts.app')

@section('content-title', ucwords(__('feedback.plural')))

@include('generator::components.models.show', [
  'panel_title' => ucwords(__('feedback.singular')),
  'resource_route' => 'feedback',
  'model_variable' => 'feedback',
  'model' => $feedback
])
