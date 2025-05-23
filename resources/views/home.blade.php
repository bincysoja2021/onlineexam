
@extends('layouts.header')

@section('content')

    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url ('/home')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
          <div class="col-12">
            <div
              class="alert alert-success alert-dismissible fade show"
              role="alert"
            >
              <strong>Welcome {{ Auth::user()->name }},</strong> You're successfully logged in.
              <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          
        </div>
      </div>
      
@extends('layouts.footer')



    </div>
  </body>
</html>
