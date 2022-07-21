<?php

date_default_timezone_set("Asia/Jerusalem");//function sets the default timezone used by all date/time functions in the script.
// echo date_default_timezone_get();
$API_KEY="b3aaf699260ae84eedc6580f158f7e7e";
if(isset($_POST['submit'])){
    $ID_OF_CITY=$_POST['id_city']; 
}
//echo $ID_OF_CITY;

//how to call API->api.openweathermap.org/data/2.5/forecast?id=524901&appid={API key}
$API_URL="api.openweathermap.org/data/2.5/forecast?id=".$ID_OF_CITY."&lang=en&appid=".$API_KEY;
//PHP can be used to make HTTP requests using the cURL library
$ch=curl_init();//Initialize a cURL session/ch for “cURL handle

curl_setopt($ch,CURLOPT_HEADER,false);//The curl_setopt() function is used to set the curl value//false to not  include the header in the output.
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//true to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
curl_setopt($ch,CURLOPT_URL,$API_URL);//set cUrl option 
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);//true to follow any "Location: " header that the server sends as part of the HTTP header
curl_setopt($ch,CURLOPT_VERBOSE,FALSE);//true to output verbose information.
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//false to stop cURL from verifying the peer's certificate
$RESPONSE=curl_exec($ch);//Execute the given cURL session.

//This function should be called after initializing a cURL session and all the options for the session are set.
curl_close($ch);//Closes a cURL session and frees all resources

$DATA=json_decode($RESPONSE);//to convert json object to php object
echo "<pre>";
print_r($DATA);
echo "</pre>";
$CURRENT_TIME=time();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Weather Using OpenWeatherMap API With PHP</title>
        <style>
            body{
                font-family: "Lucida Console", "Courier New", monospace;
                font-size: 0.8em;
                color:black;
                background-color: #E6E6FA;
            }
            .c{
                border:black 1px solid;
                border-radius:2px;
                padding:10px ;
                width:600px;
                margin:auto;
            }
            .i{
                margin-right:10px;
                text-align: center;
            }
            .b
            {
color:black;
font-size :1em;

margin:10px 0px;
            }
            
            .t{
                line-height: 20px;
            }
        </style>
    </head>
    <body>
     <div class="c">
        <h2><?php echo $DATA->city->name ?>  Weather Statues</h2><!--print the name of city have the id in URL-->
     
     <div class="t">
        <div><?php echo date("l jS \of F Y h:i:s A",$CURRENT_TIME) ?></div><!--print the day, date, month, year, time, AM or PM-->
        
        <div><?php echo $DATA->list[0]->weather[0]->description ?></div><!--print the description of weather-->
     </div>
     <div class="b">
        <img class="i" src="http://openweathermap.org/img/wn/<?php echo $DATA->list[0]->weather[0]->icon ?>.png"><!--print the icon of the weather-->
        <br>
      <h4> Max_Temp:<?php echo $DATA->list[0]->main->temp_max?></h4>  <!--print max tempreture-->
        
      <h4>Min_Temp:  <?php echo $DATA->list[0]->main->temp_min?></h4> <!--print min tempreture-->
     </div>
     <div class="t">
     
     <div><h4>Pressure:<?php echo $DATA->list[0]->main->pressure?></h4></div> <!--print pressure-->
        <div><h4>Humidity:<?php echo $DATA->list[0]->main->humidity?></h4></div> <!--print humidity-->
        <div><h4>sea_level:<?php echo $DATA->list[0]->main->sea_level?></h4></div> <!--print sea_level-->
     </div>
    </div>
    </body>
    </html>