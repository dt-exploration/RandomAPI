<!DOCTYPE html>
<html>
<body>

  <form action="random_numbers.php" method="POST">
  Min broj:<br>
  <input type="text" name="min"><br>
  Maks broj:<br>
  <input type="text" name="max"><br>
  Koliko brojeva zelis da vidis:<br>
  <input type="text" name="howmany"><br><br>
  <input type="submit" value="Lets go" name="submit">
  </form>

<?php
//The URL for invoking the API is https://api.random.org/json-rpc/1/invoke
/*

   "jsonrpc": "2.0",
    "method": "generateIntegers",
    "params": {
        "apiKey": "6b1e65b9-4186-45c2-8981-b77a9842c4f0",
        "n": 6,
        "min": 1,
        "max": 6,
        "replacement": true
    },
    "id": 42
*/
if (isset($_POST["submit"])) {

   $min = $_POST["min"];
   $max = $_POST["max"];
   $how_many = $_POST["howmany"];

    $request = array("jsonrpc"=> "2.0", "method"=> "generateIntegers", "params" =>
                array(
                    "apiKey" => "d116ab95-8579-4196-9426-a46a187e4a8c",
                     "n" => $how_many,
                     "min" => $min,
                     "max" => $max,
                     "replacement" => true) ,
                   "id"=>42);

    $data = json_encode($request);

    $url = "https://api.random.org/json-rpc/1/invoke";
    $ch  = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Content-Type: application/json',
                   'Content-Length: ' . strlen($data))
               );
    $result = curl_exec($ch);

//j_decoded kastovano kao niz jer ako je string $result prazan, sto je cesto
//slucaj, onda json decode vraca null i
//prelomi program u foreachu sa greskom

    $j_decoded = (array) json_decode($result, true);
    $a = $j_decoded["result"];
    $b = $a["random"];
    $c = $b["data"];

    foreach ($c as $value) {
        echo "$value<br>";
    }

/*
$options = array(
  'http' => array(
    'method'  => 'POST',
    'content' => json_encode( $request ),
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
);

$context  = stream_context_create( $options );
$result = file_get_contents( "https://api.random.org/json-rpc/1/invoke", false, $context );
$response = json_decode( $result );
var_dump($response);
*/
}

?>
</body>
</html>
