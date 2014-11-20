<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Authentication App With Laravel 4</title>
     {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('css/main.css')}}
    {{ HTML::script('js/jquery.js')}}
    {{ HTML::script('js/custom.js')}}
  </head>
 
  <body>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav" style="float:none"> 
                @if(!Auth::check())
                    <li>{{ HTML::link('users/register', 'Register') }}</li>  
                    <li>{{ HTML::link('users/login', 'Login') }}</li>  
                @else
                    <?php  $username = Auth::user()->firstname.' '.Auth::user()->lastname; ?>
                    <li>{{ HTML::link('users/dashboard', 'Dashboard') }}</li>
                    <li style="float:right">{{ HTML::link('users/logout', 'Logout') }}</li>
                    <li style="float:right"><a>{{$username}}</a></li>
                @endif
            </ul> 
        </div>
    </div>
  </div>
	<div class="container">
        @if(Session::has('message'))
            <p class="alert">{{ Session::get('message') }}</p>
        @endif

        {{ $content }}
    </div>
  </body>
  
<div class="navbar navbar-fixed-bottom">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav" style="float:none"> 
                    <li style="float:right"><a>Happily Designed & Developed by TechArays !!</a></li>                   
            </ul> 
        </div>
    </div>
  </div>
  
</html>