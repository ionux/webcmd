<?php

date_default_timezone_set("America/New_York");

function buildResponse($command, $message = null) {
	if(isset($message))
		$response = array("command" => $command, "message" => $message);
	else
		$response = array("command" => $command);

	return json_encode($response);
}

$input = strtolower($_POST['q']);

$response = null;

switch($input)
{
	case "date":
		$response = buildResponse("DISPLAY", "Today's date: " . date("D M j G:i:s T Y"));
		break;
	case "clear":
		$response = buildResponse("CLEAR");
		break;
	default:
		$response = buildResponse("ERROR", "An error has occurred.");
}


echo $response;

?>