#!/usr/bin/php -q
<?php 

include '/var/lib/asterisk/agi-bin/phpagi.php';
include 'dbconfig.php';

$agi= new AGI();

$callerid= $argv[1];
$dialstatus= argv[2];
$uniqueid= argv[3];
$exten= argv[4];

$db_connexion = new PDO("mysql:host=".$DB['HOST'].";port=".$DB['PORT'].";dbname=".$DB['NAME'],$DB['USER'],$DB['PASS']);				
$db_connexion->exec("SET CHARACTER SET utf8");

/*			
$st = $db_connexion->prepare("SELECT * FROM calldata");
$st->execute();
$result= $st->fetchAll(PDO::FETCH_ASSOC);
*/


    //$agi->stream_file("custom/choix-lang","#");
    //$agi->stream_file("please-enter-your","#");

/*
   do
    {
        $agi->stream_file("custom/enter-unique-id","#");
        $result = $agi->get_data('beep', 7000, 20); // beepsound, timeout(ms) maxdigits
        $keys = $result['result'];
        $agi->stream_file("you-entered","#");
        $agi->say_digits($keys);
    } while($keys != '111');

*/


//RECORD FILE FILENAME FORMAT ESCAPE_DIGITS TIMEOUT OFFSET_SAMPLES BEEP S=SILENCE 
// $sal = $agi->record_file("msg1", "wav", "#", -1,NULL,true); 
// $create_wav49 = `/usr/bin/sox {$file}.wav -c 1 -r 8000 -g -t wav {$file}.WAV`;

$agi->stream_file("custom/decrire-probleme","#");
$filename= $callerid.'-'.time();
$agi->record_file($filename, 'wav', '#', -1, '', TRUE, 2);

$pin= generatePIN();
$st = $db_connexion->query("INSERT INTO caller (callerid, time_start, time_end, pin) VALUES('$callerid', NOW(), NOW(), '$pin')");
$agi->stream_file("you-entered","#");
$agi->say_digits($pin);


do
{
    $agi->stream_file("custom/enter-unique-id","#");
    $result = $agi->get_data('beep', 7000, 20); // beepsound, timeout(ms) maxdigits
    $keys = $result['result'];
    $agi->stream_file("you-entered","#");
    $agi->say_digits($keys);
} while(strlen($keys) != 4); 


$st = $db_connexion->prepare("SELECT * FROM caller WHERE pin = '$keys'");
$st->execute();
$item= $st->fetch(PDO::FETCH_ASSOC);

if($item)
$agi->say_digits(1);
else
$agi->say_digits(0);


function generatePIN($digits = 4){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
}