@extends('auth.login')

@section('content')
  <div class="col">
    <div class="card card-outline card-red">
      <div class="card-header text-center">
        <a href="{{ url('') }}" class="h1">
          <b>Audit Mutu Internal</b>
          <p>IT Telkom Purwokerto</p>
        </a>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.login.check') }}" method="post" autocomplete="off">
          @csrf
          @if($errors->any())
            <div class="alert alert-warn  ing alert-dismissible fade show" role="alert">
              <ul class="mb-0 pl-4">
                @foreach ($errors->all() as $error)
                  <li>{{ __($error) }}</li>
                @endforeach
              </ul>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          <div class="form-group">
            <label for="username">Username</label>
            <div class="input-group mb-3">
              <input id="username" type="text" name="username"
                     class="form-control" value="{{ old('username') }}" autofocus
              >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group mb-3">
              <input id="password" type="password" name="password"
                     class="form-control"
              >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>

          <label for="user_type">Login Sebagai...</label>
          <div class="form-group btn-group btn-group-toggle d-flex" data-toggle="buttons">
            <label class="btn btn-primary d-block border-light border active">
              <input type="radio" name="options" id="admin-radio" checked>
              <button type="button" class="text-white-50 bg-transparent border-transparent" disabled>
                {{ __('Admin') }}
              </button>
            </label>
            <label class="btn btn-primary d-block border-light border">
              <input type="radio" name="options" id="auditor-radio">
              <a href="{{ route('auditor.login') }}" class="text-white">
                {{ __('Auditor') }}
              </a>
            </label>
            <label class="btn btn-primary d-block border-light border">
              <input type="radio" name="options" id="auditee-radio">
              <a href="{{ route('auditee.login') }}" class="text-white">
                {{ __('Auditee') }}
              </a>
            </label>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col text-right">
                <button type="submit" class="btn btn-primary text-uppercase">
                  {{ __('Sign In') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
