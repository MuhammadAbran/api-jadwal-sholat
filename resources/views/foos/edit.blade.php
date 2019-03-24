@extends('layouts.app')

@section('content-title', ucwords(__('foos.plural')))

@include('generator::components.models.edit', [
  'panel_title' => ucwords(__('foos.singular')),
  'resource_route' => 'foos',
  'model_variable' => 'foo',
  'model' => $foo
])
