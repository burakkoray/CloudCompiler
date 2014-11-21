<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Online Compiler</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ URL::route('home') }}">Home </a></li>
    
    @if(Auth::check())
    	<li><a href="{{URL::route('account-sign-out')}}"> Sign out</a></li>
    	<li><a href="{{URL::route('account-change-password')}}"> Change Password </a></li>
    @else
		<li><a href="{{ URL::route('account-sign-in')}}">Sign in</a></li>
		<li><a href="{{ URL::route('account-create')}}">Create an Account </a></li>
		<li><a href="{{ URL::route('account-forgot-password')}}">Forgot password </a></li>
	@endif
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>

<nav>
<ul>
	

</ul>
</nav>

