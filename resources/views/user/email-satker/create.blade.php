@extends('user.layouts.app')

@section('content')

<form action="{{ route('email-satker.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @include('user.email-satker.form')

</form>

@endsection