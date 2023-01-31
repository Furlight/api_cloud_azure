<?php
	// Connect to database
    $server = "houssais-psqlserver.postgres.database.azure.com";
	$username = $_ENV['user'];
	$password = $_ENV['password'];
	$db = "mydb";
	$connexion = pg_connect("host=$server dbname=$db user=$username password=$password");
	$method = $_SERVER["REQUEST_METHOD"];

    echo($username);
    echo($password);
    echo($method);

	function getActors()
    {
        global $connexion;
        $result = pg_query($connexion, "SELECT * FROM users");
        if (!$result) {
            echo json_encode(array("error" => "An error occurred."));
            exit;
        }
        $response = array();
        while ($row = pg_fetch_row($result)) {
            $response[] = array("id" => $row[0], "username" => $row[1], "email" => $row[2]);
        }
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        echo json_encode($response);
    }
	
    // Différentes routes récupérées
	switch($method)
	{
		case 'GET':
            getActors();
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			break;  
	}
?>