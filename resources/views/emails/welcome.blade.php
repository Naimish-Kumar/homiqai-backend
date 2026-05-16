@extends('emails.template')

@section('greeting', 'Welcome to the Future of Space.')

@section('content')
We are thrilled to welcome you to **Homiq**. You are now part of an exclusive collective leveraging spatial intelligence to redefine the boundaries of interior design.

Our AI engine is ready to transform your vision into high-fidelity reality. Whether you're reimagining a single room or orchestrating a complete architectural shift, Homiq provides the tools to execute with absolute precision.

Explore our curated style library or initiate your first transformation cycle today.
@endsection

@section('action_text', 'Initiate Transformation')
@section('action_url', url('/'))
