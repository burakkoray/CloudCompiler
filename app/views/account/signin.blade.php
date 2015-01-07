@extends('main')

@section('content')
   
   <div class="middle" style="   position : absolute;    
    width    : 400px;
    height   : 200px;
    left     : 50%;
    top      : 50%;
    margin-left : -150px; /* half of the width  */
    margin-top  : -100px; /* half of the height */
">
    
   <form class="form-horizontal" action="{{ URL::route('account-sign-in-post')}}" method="post" style="margin: 0 auto; align:center;">
  <div class="form-group" >
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10" >
      <input type="text" name="email"{{ (Input::old('email')) ? 'value="' . Input::old('email') . '"' : ''}} >
    @if($errors->has('email'))
    {{$errors->first('email') }}
    @endif
     </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="password">
    @if($errors->has('password'))
    {{$errors->first('password') }}
    @endif 

       </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
      {{Form::token()}}
    </div>
  </div>
</form>
</div>

   @stop

   