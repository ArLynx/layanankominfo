@extends('user.layouts.app')

@section('content')

<form action="{{ route('subdomain.update', $subdomain) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('user.subdomain.form')

</form>

@endsection