<?php
	// Connect to database
    $server = "houssais-psqlserver.postgres.database.azure.com";
	$username = $_ENV['user'];
	$password = $_ENV['password'];
	$db = "mydb";
	$connexion = pg_connect("host=$server dbname=$db user=$username password=$password");
	$method = $_SERVER["REQUEST_METHOD"];

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
            $response[] = array("Id" => $row[0], "Username" => $row[1], "Email" => $row[2]);
        }
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Content-Type: application/json');
        return json_encode($response, JSON_PRETTY_PRINT);
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