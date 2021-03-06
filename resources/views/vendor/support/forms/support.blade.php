<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Submit Support Request | NOMI </title>

  <style type="text/css">
      .sub-container{
        display: block;
        padding: 3%;
      }
      .submit_button {
        float: right;
        background-color: #d00d2d;
        border-color: #d00d2d;
        color: #fff;
      }
      .nomi-logo {
        height: 75%;
      }
      .back-button {
        position: relative;
        float: left;
        left: 3%;
        height: 100%;
        padding: 1.5%;
        width: 8%;
        cursor: pointer;
        border-color: black;
      }
      .header-bar {
		    height: 3rem;
		    width: 100%;
        top: 0;
        background-color: #d00d2d;
        z-index:101;
        display: block;
      }

    </style>
  </head>
  <body>
  <div class="header-bar">
      <img class="back-button" src="{{ asset('/images/chevron-left.svg') }}" onclick="window.history.back()" alt="Back Button">
  </div>
    <div class="container sub-container">
      <div class="justify-content-md-center">
        <div class="col-sm-8">
          <div class="row">
            <div class="col-6">
              <h2 class="m-0">Feedback Form</h2>
            </div>
            <div class="col-6">
              <img class="nomi-logo" src="{{ asset('/images/apple-touch-icon.png') }}" alt="NOMI Logo; Names of Matador Individuals"> 
            </div>
          </div>
          <p>Hello, Professor {{ $submitter_name }}.</p>
          <p>Your feedback and input helps us improve our application.</p>
          <p>Please provide your comments below.</p>
        </div>
      </div>
      <div class="justify-content-md-center">
      <div class="form-group col-sm-8">
              <label for="impact"><span class="required">*</span> Impact</label>
              <select name="impact" id="impact" class="form-control">
                @foreach($impact as $key => $value)
                  @if(old('impact') == $key)
                    <option value="{{ $key }}" selected="selected">
                  @else
                    <option value="{{ $key }}">
                  @endif
                  {{ $value }}
                  </option>
                @endforeach
              </select>
            </div>
      </div>

      @if($errors->count() > 0)
        <div class="row justify-content-md-center">
          <div class="col-sm-8">
            <div class="alert alert-danger">
              <p>The following errors occurred:</p>
              <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
              </ul>
            </div>
          </div>
        </div>
      @elseif(!empty($success))
        <div class="row justify-content-md-center">
          <div class="col-sm-8">
            <div class="alert alert-success">
              {{ $success }}
            </div>
          </div>
        </div>
      @elseif(session('success'))
        <div class="row justify-content-md-center">
          <div class="col-sm-8">
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          </div>
        </div>
      @endif

      <div class="justify-content-md-center">
        <div class="col-sm-8">
          <form method="POST" action="{{ route('feedback.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
              <textarea class="form-control" rows="5" name="content" id="content" placeholder="Please enter your feedback.">{{ old('content') }}</textarea>
            </div>
            <button type="submit" class="btn submit_button">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
