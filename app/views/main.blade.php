
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/docs.css" rel="stylesheet"> 
    <link href="/css/showhint.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/monokai.css" rel="stylesheet">
    <link href="/css/fullscreen.css" rel="stylesheet">
    <link href="/css/merge.css" rel="stylesheet">
    <link href="/css/codemirror.css" rel="stylesheet">
    <link href="/css/mergehelp.css" rel="stylesheet">
    <link href="/css/dialog.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
    
<link href="/css/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">
    <script src="/js/codemirror.js"></script>
    <script src="js/xml.js"></script>
    <script src="js/dif.js"></script>
    <script src="js/merge.js"></script>
    <script src="js/showhint.js"></script>
   
     <script src="js/searchcursor.js"></script>
     <script src="js/search.js"></script>
     <script src="js/fullscreen.js"></script>
   
     <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery.easing.js" type="text/javascript"></script>
        <script src="js/jqueryFileTree.js" type="text/javascript"></script>
  

    <script src="js/dialog.js"></script>
     <script src="js/jstree.min.js"></script>
  
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    @include('navigation')

    <div class="container-fluid">
        @if(Session::has('global'))
	   <p>	
	   	{{Session::get('global')}}
	   </p>
		@endif

	    @yield('content')
    </div><!-- /.container -->
	</body>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/fullscreen.js"></script>

    <!--bu hata veriyor-->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    
    <script src="/js/mode/clike/clike.js"></script>
     <script src="js/javascrit.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   
  </body>
</html>