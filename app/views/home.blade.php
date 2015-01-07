@extends ('main')
@section('content')
<div class="row" role="main" id="container">
  @if(Auth::check())

  <div class="col-md-4" id="tree">
    <ul>
    </ul>
  </div>



  <div class="col-md-8 content default" id="code-terminal">

    <!-- <div id="image" style="display:none; position:relative;"><img src="" alt="" style="display:block; padding:0; max-height:70%; max-width:70%;" /></div>
    
 -->

  <div id="code-container">
    <div id="code-buttons">
      <button type="submit" class="btn btn-primary" id="compile-button" onclick="save()">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Save
      </button>
      <button type="submit" class="btn btn-success" id="run-button" onclick="run()">
        <span class="glyphicon glyphicon-play" aria-hidden="true" ></span> Execute
      </button>
    </div>
    <textarea id="code" name="code"></textarea>
  </div>
  <div id="terminal-container">

    <div class="terminal-header">
      <span class="mega-octicon octicon-terminal"></span> Terminal
    </div>
    <pre id="yazi"></pre>
  </div>
</div>
<!-- 
  <div id="event_result" style="margin-top:2em; text-align:center;">&nbsp;</div>
            
<div id="dom-target" style="visibility: hidden";> </div>

</pre>
-->


<script >
  var currentFile;
  var run = function() {
    save();
    $.get('/fs/operations?operation=run', { 'id' : currentFile })
    .done(function (d) {
      document.getElementById("yazi").innerHTML = d;
    })
    .fail(function () {
      document.getElementById("yazi").innerHTML = "Error";
    });
  };

  var save = function() {
    $.post('/fs/operations?operation=set_content&id='+currentFile, { 'content': cEditor.getValue() });
  };


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

    height: 'dynamic',
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

  //  content: cEditor.getValue();


</script>
@stop
