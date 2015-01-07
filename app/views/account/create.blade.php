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
            <form class="form-horizontal" action="{{ URL::route('account-create-post')}}" method="post" style="margin: 0 auto;">
            
        	<div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
           <div class="col-sm-10" >

        	<input type="text" name="email" {{ (Input::old('email')) ? 'value"' . e(Input::old('email')) . '"' : '' }}>
            @if($errors->has('email'))
            {{$errors->first('email')}}
            @endif
            </div>
            </div>
        	
        	<div class="form-group">
            <label for="Username3" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">

            <input type="text" name="username"{{ (Input::old('username')) ? 'value"' . e(Input::old('username')) . '"' : '' }}>
            @if($errors->has('username'))
            {{$errors->first('username')}}
            @endif

            </div>
            </div>


        	<div class="form-group">

        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">

            <input type="password" name="password">
            @if($errors->has('password'))
            {{$errors->first('password')}}
            @endif
                </div>
        </div>

        	<div class="form-group">

        <label for="inputPassword4" class="col-sm-2 control-label">Password Again</label>
        <div class="col-sm-10">
           <input type="password" name="password_again">
            @if($errors->has('password_again'))
            {{$errors->first('password_again')}}
            @endif
            </div>
            </div>
            <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
      
            <input type="submit" value="Create account" style="align:rigth;">
                {{Form::token()}}
     </div>
      </div>
            </form>
        </div>

            @stop