<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <span class="mega-octicon octicon-cloud-download"></span> Cloud Compiler
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">@if(Auth::check()) <?php echo Auth::user()->username; ?> @else User @endif  <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            @if(Auth::check())
            	<li><a href="{{URL::route('account-sign-out')}}"> Sign out</a></li>
            	<li><a href="{{URL::route('account-change-password')}}"> Change Password </a></li>
            @else
          		<li><a href="{{ URL::route('account-sign-in')}}">Sign in</a></li>
          		<li><a href="{{ URL::route('account-create')}}">Create an Account </a></li>
          		<li><a href="{{ URL::route('account-forgot-password')}}">Forgot password </a></li>
        	@endif
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>