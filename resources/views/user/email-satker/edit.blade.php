@extends('user.layouts.app')

@section('content')

<form action="{{ route('email-satker.update', $emailSatker) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('user.email-satker.form')

</form>

@endsection