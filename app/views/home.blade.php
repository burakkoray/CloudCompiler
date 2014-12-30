@extends ('main')
@section('content')
<div class="row" role="main" id="container">
@if(Auth::check())
 <p>  Hello,{{ Auth::user()->username}}. </p>

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
  		int main(int argc, char** argv) {
  			char buf[100];
  			return 0;
  		}

    	</textarea>

  
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" >
        <span class="mega-octicon octicon-terminal"></span> Terminal
      </a>
    </div>

  </div>
</nav>
    
  </div>


  <!-- <div id="event_result" style="margin-top:2em; text-align:center;">&nbsp;</div>
   -->          
  <pre id="yazi"></pre>
<div id="dom-target" style="visibility: hidden";> <?php  

          // get directory
          $output=  shell_exec("ls");
          
          // go into directory
          chdir("user-files");     
          // echo getcwd() . "\n";


           $output2=  shell_exec("ls");
          //echo $output2;
           
           define('isim', Auth::user()->username);
          
          //echo isim;
           chdir(isim);
           $output3=  shell_exec("ls");
        
           //shows directory
           //   echo $output3;
       




          // burda o klasöre girecek
  
          $dir = "/var/www/public/user-files/"; 
          $direct= $dir.isim;
          //  echo $direct;
          //  chdir("C");

          if(file_exists($direct . "/Makefile")) { 
          shell_exec('clean');
          shell_exec('make');
          $outputyeni= shell_exec('./main 2>&1');
          echo "<pre>$outputyeni</pre>"; 
            } else { 
           echo "Couldn't find Makefile in $dir!"; 
             }  

      
       //  compile and run c hard coded
       // shell_exec('gcc main.c Functions.c -o someobjectfile 2>&1');
       // $output=shell_exec('./someobjectfile');
       // echo "<pre>$output</pre>";



               if(file_exists($direct . "/Makefile")) { 
          
              shell_exec('clean');
              shell_exec('make');
              $outputyeni= shell_exec('java Main 2>&1');
             //    echo "<pre>$outputyeni</pre>"; 
                                            
              } else { 
              $deneme="3";
             //  echo "Couldn't find Makefile in $dir!"; 
              }  


               echo "\n";
   
              // echo getcwd() . "\n";
              $path= getcwd() ;
              // echo $path;
       
         
            // compile and run python in
            //   $pythonexec = exec('/usr/bin/python /var/www/public/user-files/burakkoray/Python/test.py 2>&1');
            //   echo "<pre>$pythonexec</pre>";

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

$(function () {
              $('#tree')
                .on('changed.jstree', function (e, data) {
                  var i, j, r = [];
                  for(i = 0, j = data.selected.length; i < j; i++) {
                    r.push(data.instance.get_node(data.selected[i]).text);
                  }
                  $('#event_result').html('Selected:<br /> ' + r.join(', '));
                })
                .jstree();
            });
</script>

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


  //  $.post( "/fs/operations?operation=set_content&id= ", { content: cEditor.getValue() } );

     //alert(cEditor.getValue());
    document.write(cEditor.getValue());
  //  content: cEditor.getValue();


</script>
@stop
