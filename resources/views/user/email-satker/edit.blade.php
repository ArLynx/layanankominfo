@extends('user.layouts.app')

@section('content')

<form action="{{ route('email-pribadi.update', $emailPribadi) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('user.email-pribadi.form')

</form>

@endsection