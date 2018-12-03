<?php
require 'config.php';
$path_info = get__PATH_INFO($_SERVER['REQUEST_URI']);

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($path_info,'/'));

// connect to the mysql database
$link = mysqli_connect($host, $user, $pass, $name);
mysqli_set_charset($link,'utf8');

// retrieve the endpoint and param from the path
$endpoint = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$param = array_shift($request)+0;

// escape the columns and values from the input object
$input = json_decode(file_get_contents('php://input'),true);
if (!$input) $input = [];
if($endpoint == 'boardSave') {
  $params = $input[0];
  $input = $input[1];
}

// $columns = preg_replace('/[^a-z0-9_]+/i','', array_keys($input));
// $values = array_map(function ($value) use ($link) {
//   if ($value===null) return null;
//   return mysqli_real_escape_string($link,(string)$value);
// },array_values($input));

// build the SET part of the SQL command
// $set = '';
// for ($i=0;$i<count($columns);$i++) {
//   $set.=($i>0?',':'').'`'.$columns[$i].'`=';
//   $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
// }
 
// create SQL based on HTTP method
require 'sqlQueries.php';
switch ($method) {
  case 'GET':
    switch($endpoint) {
      case 'board': $result = mysqli_query( $link, get_board($param) ); break;
      // Should be changed over to user id
      case 'boards': $result = mysqli_query($link, get_all_boards(1) ); break;
      case 'step': $result = mysqli_query($link, get_step($param) ); break;
    }; break;
  case 'PUT':
    switch($endpoint) {
      case 'boardSave': 
        for ($i=0;$i<count($input);$i++) {
          mysqli_query($link, update_steps($input[$i]['strStepName'], $input[$i]['txtContent'], $input[$i]['lngStepId']) );
        }
        $result = true; 
        break;
    }; break;
  case 'POST':
    break;
  case 'DELETE':
    break;
}
 
// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
 
// print results, insert id or affected row count
if ($method == 'GET' || $method == 'POST') {
  if (!$param) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$param) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($link);
} else {
  echo mysqli_affected_rows($link);
}
 
// close mysql connection
mysqli_close($link);

