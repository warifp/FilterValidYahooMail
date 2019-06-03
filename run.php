<?php
/**
 * Author : Wahyu Arif Purnomo
 * Update : 03 Juni 2019
 * Please don't recode and re-share.
 */
error_reporting(0);
ini_set('memory_limit', '-1');
mkdir('Filter');
mkdir('Valid');

echo "\e[1;91m=========================================================================\e[0m\r\n";
echo "                        \e[0;36m||\e[0m \e[45mFILTER AND VALID EMAIL [YAHOO.COM]\e[0m \r\n";
echo "                        \e[0;36m||\e[0m \e[42m(c) 2019 WAHYU ARIF P\e[0m\r\n";
echo " \e[1;91m======================\e[0m \e[0;36m||\e[0m \r\n";
echo " \e[45mFILTER AND VALID EMAIL\e[0m \e[0;36m||\e[0m Facebook  : \e[0;34mhttps://www.facebook.com/warifp\e[0m\r\n";
echo "       \e[45m[YAHOO.COM]\e[0m      \e[0;36m||\e[0m Instagram : \e[0;34mhttps://www.instagram.com/warifp\e[0m\r\n";
echo " \e[1;91m======================\e[0m \e[0;36m||\e[0m Twitter   : \e[0;34mhttps://www.twitter.com/wahyuarifp\e[0m\r\n";
echo "                        \e[0;36m||\e[0m Github    : \e[0;34mhttps://www.github.com/warifp\r\n";
echo "\e[1;91m=========================================================================\e[0m\r\n\n";
echo "\e[1;36m[>] Usage \t\t: php namafile.php namalist.txt\e[0m\r\n";
echo "\e[1;36m[>] Result Email \t: Filter/result-email.txt\e[0m\r\n";
echo "\e[1;36m[>] Valid Email \t: Valid/Live.txt or Valid/Dead.txt\e[0m\r\n\n";
echo "\e[1;91m=========================================================================\e[0m\r\n";
echo "\e[42m[+] UPDATE : 03 Juni 2019\e[0m\r\n";
echo "\e[1;91m=========================================================================\e[0m\r\n\n";
echo "\e[45m[?] - Filtering Email [Yahoo.com]\e[0m\n";
echo "\e[0;34mStarting ..\e[0m";
sleep(3);echo "\n";
echo "\n";

$f = file_get_contents($argv[1]) or die ("\e[1;91mPenggunaan : php namafile.php namalist.txt\e[0m\n");
$f = explode("\r\n", $f);
$f = array_unique($f);

$no 		= 0;

foreach ($f as $key => $email) {
	$explode = explode("@", $email);
	if(! is_numeric($explode[0]) && filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/marketplace.amazon|example|test|auto|cdiscount.com/", $explode[0])){
		
		if(preg_match("/yahoo.com/", $explode[1])){
			$x = fopen("Filter/result-email.txt", "a+");
            fwrite($x, $email."\r\n");
            $no++;
			fclose($x);
		}
    }
}
function valid($list){
    echo "\e[45m[?] - Valid Email [Yahoo.com]\e[0m";
    echo "\n\e[0;34mStarting ..\e[0m";
    sleep(3);echo "\n";
    echo "\n";
    $file = file_get_contents("$list");
    $data = explode("\n", str_replace("\r", "", $file));
    $x = 0;
    for ($a = 0; $a < count($data); $a++) {
    $email   = $data[$a];
    $x++;
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://widhitools.000webhostapp.com/api/yahoo.php?email='.$email);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    $headers   = array();
    $headers[] = 'Connection: Keep-Alive';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $hasil = json_decode($result);
    curl_close($ch);

    if($hasil->status === "live"){
        echo "\e[1;90m$x.\e[0m \e[1;92mLIVE\e[0m | \e[0;35m".$email."\e[0m\n";
        $warifp = fopen("Valid/Live.txt", "a+");
        fwrite($warifp, $email."\r\n");
    }else{
        echo "\e[1;90m$x.\e[0m \e[0;31mDEAD\e[0m | \e[0;35m".$email."\e[0m\n";
        $warifp = fopen("Valid/Dead.txt", "a+");
        fwrite($warifp, $email."\r\n");
    }
}}
valid("Filter/result-email.txt");