<?php
date_default_timezone_set("America/New_York");
?>
<!DOCTYPE html>
<html>
<head>
	<title>WebCMD</title>
	<style>
	* {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	}

	body {
		background: black;
		margin: 0;
		padding: 20px;
		color: #fff;
		font: 16px 'Courier New', sans-serif;
	}

	#terminal {
		width: 100%;
	}

	.line {
		width: 100%;
		height: auto;
		clear: both;
		line-height: 16px;
		padding: 1px 0;
	}

	#history {
		width: 100%;
	}

	#prompt {
		position: relative;
	}

	#prompt span {
		position: absolute;
		left: 0;
	}

	#command {
		color: #fff;
		background: black;
		border: 0;
		padding: 0;
		font: 16px 'Courier New', sans-serif;
		width: 100%;
		outline: 0;
		margin: 0;
		line-height: 16px;
		padding-left: 19px;
	}
	</style>
</head>
<body>
<div id="terminal">
	<div id="history">
		<div class="line">Login date: <?= date("D M j G:i:s T Y"); ?></div>
	</div>

	<form id="prompt">
		<span>>&nbsp;</span><input type="text" name="command" id="command" autocomplete="off" />
	</form>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var cmd = $('#command');
var prompt = $('#prompt');

$(document).ready(function() { 
	cmd.focus();
});

$('html').dblclick(function() {
	cmd.focus();
});

prompt.submit(function(x){
	x.preventDefault();

	var command = cmd.val();
	var history = $("#history");
	cmd.hide();
	history.append('<div class="line"><span>>&nbsp;</span>' + command + '</div>');
	$.ajax({  
            type: "POST",  
            url: "interpreter.php", 
            data: "q=" + command
     })
	.done(function(data){
		var response = $.parseJSON(data);

		process(response);

		$("body").scrollTop($("body").height());
	});

	cmd.val('').show();
});


function process(response) {
	switch(response.command) {
		case "DISPLAY":
			appendLine(response.command + ": " + response.message);
			break;
		case "CLEAR":
			$("#history").html('');
			break;
		default:
			appendLine("Unknown error.");
	}
}

function appendLine(message) {
	$("#history").append('<div class="line">' + message + '</div>');
}

</script>
</body>
</html>