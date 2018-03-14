<?php
// $my_account = "explore/tags/yellow";
//$my_account = "shermanpaggi";
$my_account =$_GET['my_account'];
$my_acount = htmlentities('$my_account');
date_default_timezone_set('America/New_York');

$json = file_get_contents('https://www.instagram.com/'.$my_account.'/?__a=1');

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    if(is_array($val)) {
        //echo "<p>$key:--- ";
    } else {
		if($key == "text") { $text = $val; }
		if($key == "taken_at_timestamp") {    $date = date("r", "$val"); 	}
    	if($key == "display_url") { $body.="<item>\n
			<title>".$my_account."</title>\n
			<pubDate>".$date."</pubDate>\n
			<description>\n
			<![CDATA[<img src='".$val."'>]]> 
			".$text."
			</description>\n
			</item>\n";}
       // echo "$key => $val</p>";
    }
}

 echo "<?xml version='1.0'?>
<rss version='2.0'>
	<channel>
		<title>".$my_account." Instagram</title>
		<link>https://www.instagram.com/".$my_account."/</link>
		<description>".$my_account." Instagram channel</description>
		".$body."
	</channel>
</rss>";

/*
echo "<pre>
<channel>
     <title>".$my_account." Instagram</title>
    <link>https://www.instagram.com/".$my_account."/</link>
    <description>".$my_account." Instagram channel</description>
   ".$body."
  </channel>
  </pre>"
  */
?>

