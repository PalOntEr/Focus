<?php

session_start();

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['usertype'])) {
	$_SESSION['usertype'] = $input['usertype'];
	echo json_encode(['success' => true]);
} else {
	echo json_encode(['success' => false]);
}
?>