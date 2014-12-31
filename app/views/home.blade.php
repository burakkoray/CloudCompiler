@extends ('main')
@section('content')
<div class="row" role="main" id="container">
@if(Auth::check())

	<div class="col-md-4" id="tree">
    <ul>
    </ul>
	</div>



	<div class="col-md-8 content default">

    <div id="image" style="display:none; position:relative;"><img src="" alt="" style="display:block; padding:0; max-height:70%; max-width:70%;" /></div>
     <!--On click te cagir-->


<!-- 
     <button type="submit" class="btn btn-primary" id="compile" >
     <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Save
    </button>
    <button type="submit" class="btn btn-primary" >
    <span class="glyphicon glyphicon-play" aria-hidden="true" ></span>Execute
     </button> -->
<input type="submit" class="button" name="insert" value="Save" />
<input type="submit" class="button" name="select" value="Run" />
   

    <textarea id="code" name="code" rows="5">
  		
    	</textarea>

  
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" >
        <img alt="Brand" src="/img/Mac-Terminal-icon.png">Terminal
      </a>
    </div>

  </div>
</nav>
    
  </div>


  <pre id="yazi"></pre>
<div id="dom-target" style="visibility: hidden";> <?php  


           ?></div>

</pre>



   <script >
$(document).ready(function(){
    $('.button').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = '/Ds/showoutputs',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
       
          var div = document.getElementById("dom-target");
          var myData = div.textContent;
       //   div.style.visibility='visible';
        document.getElementById("yazi").innerHTML = myData;
        //     alert(myData);
        });
    });

});
</script>


@else
  <div style="background: red">You're not signed in!</div>
@endif
	  
</div>



<script src="/js/jstree.min.js"></script>
<script src="/js/jqek.js" type="text/javascript"></script>
     

<script>
var cEditor = CodeMirror.fromTextArea(document.getElementById("code"), 

{

 
        lineNumbers: true,
        matchBrackets: true,
        theme: "monokai",
        mode: "text/x-csrc",
        extraKeys: {
    		"Ctrl-Space": "autocomplete", 
			"F11": function(cm) {
	          cm.setOption("fullScreen", !cm.getOption("fullScreen"));
	        },
	        "Esc": function(cm) {
	          if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
	        }},
      });

     var mac = CodeMirror.keyMap.default == CodeMirror.keyMap.macDefault;
    CodeMirror.keyMap.default[(mac ? "Cmd" : "Ctrl") + "-Space"] = "autocomplete";


</script>
@stop
