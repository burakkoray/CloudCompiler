@extends ('main')
@section('content')
<div class="row" role="main">
@if(Auth::check())
	    <p>  Hello,{{ Auth::user()->username}}. </p>


	<div class="col-md-4" id="html1">

 <ul>
    <li>Root node 1</li>
    <li>Root node 2</li>
  </ul>
	</div>

       

	<div class="col-md-8">
	<textarea id="code" name="code" rows="5">
		int main(int argc, char** argv) {
			char buf[100];
			return 0;
		}

	</textarea>
	</div>



	  @else

		<div style="background: red">You're not signed in!</div>
	  @endif
	  
</div>

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
      var cppEditor = CodeMirror.fromTextArea(document.getElementById("cpp-code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-c++src"
      });
      var javaEditor = CodeMirror.fromTextArea(document.getElementById("java-code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-java"
      });
      var scalaEditor = CodeMirror.fromTextArea(document.getElementById("scala-code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-scala"
      });
      var mac = CodeMirror.keyMap.default == CodeMirror.keyMap.macDefault;
      CodeMirror.keyMap.default[(mac ? "Cmd" : "Ctrl") + "-Space"] = "autocomplete";


  </script>



  
<script>
var value, orig1, orig2, dv, hilight= true;
function initUI(panes) {
  if (value == null) return;
  var target = document.getElementById("view");
  target.innerHTML = "";
  dv = CodeMirror.MergeView(target, {
    value: value,
    origLeft: panes == 3 ? orig1 : null,
    orig: orig2,
    lineNumbers: true,
    mode: "text/html",
    highlightDifferences: hilight
  });
}

function toggleDifferences() {
  dv.setShowDifferences(hilight = !hilight);
}

window.onload = function() {
  value = document.documentElement.innerHTML;
  orig1 = value.replace(/\.\.\//g, "codemirror/").replace("yellow", "orange");
  orig2 = value.replace(/\u003cscript/g, "\u003cscript type=text/javascript ")
    .replace("white", "purple;\n      font: comic sans;\n      text-decoration: underline;\n      height: 15em");
  initUI(2);
};

function mergeViewHeight(mergeView) {
  function editorHeight(editor) {
    if (!editor) return 0;
    return editor.getScrollInfo().height;
  }
  return Math.max(editorHeight(mergeView.leftOriginal()),
                  editorHeight(mergeView.editor()),
                  editorHeight(mergeView.rightOriginal()));
}

function resize(mergeView) {
  var height = mergeViewHeight(mergeView);
  for(;;) {
    if (mergeView.leftOriginal())
      mergeView.leftOriginal().setSize(null, height);
    mergeView.editor().setSize(null, height);
    if (mergeView.rightOriginal())
      mergeView.rightOriginal().setSize(null, height);

    var newHeight = mergeViewHeight(mergeView);
    if (newHeight >= height) break;
    else height = newHeight;
  }
  mergeView.wrap.style.height = height + "px";
}


</script>

@stop