<?php
	
	require 'twitteroauth/twitteroauth.php';
	include "database.php";
	
	// consumer ve access

	$consumer_key = "A0owSmWKvnbGhAlInjz1xkpYD";
	$consumer_secret = "YJWYsZ3fRBgxSqjgXZPbgdU0YGpdYUB9U3kbgc0z9lJYe68yqn";
	$access_token = "2367274534-OI0fVvqK9hCVbDKVhV6xOeBYsyiQbqsY0nzIhPu";
	$access_token_secret = "UBOn4SxExIDPUFsDOr79XhfXQzKkhlSa8h0cN2XQwGMTt";
	
	
	// sıfını başlatalım
	$twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	
	// tw - kullanıcı adı
	$username = 'Aytiaras';
	// tw- sorgu
	$q = "";
	// tw sayısı
	$count = 500;
	// tw locations
	//$locations = '25.9008758068,42.2285173562,35.7108378353,45.3515625'; türkiye
	//$locations = '-125.7543976307,49.6987776322,29.0753751796,-61.0753751796'; 

	//ankara site:http://boundingbox.klokantech.com/[[[25.9008758068,35.7108378353],[25.9008758068,42.2285173562],[45.3515625,42.2285173562],[45.3515625,35.7108378353],[25.9008758068,35.7108378353]]]
	
	//$locations = '31.5063461065,39.7156381348,33.6206070185,40.1678855033'; //ankara
	$geocode='41,29,100km';

	//$url = 'https://api.twitter.com/1.1/search/tweets.json?q='.$q.'&result_type=recent&count='.$count.'&locations='.$locations;
	$url = 'https://api.twitter.com/1.1/search/tweets.json?q='.$q.'&result_type=recent&count='.$count.'&geocode='.$geocode;
	
	$tweets = $twitter->get($url);

	//echo "<pre>";
	//echo print_r($tweets);
	$lastcreated = "SELECT created from deprem order by created desc LIMIT 0,1";
	//$lastcreated = mysql_query($lastcreated);
	//$lastcreated = mysql_fetch_assoc($lastcreated);
	//$lastcreated = date("Y-m-d H:i:s", strtotime($lastcreated["created"]));
	$query = $db->query("SELECT created from deprem order by created desc LIMIT 0,1")->fetch(PDO::FETCH_ASSOC);
	$lastcreated = date("Y-m-d H:i:s", strtotime($query["created"]));
	
	$table = "<tr><th>profil resmi</th><th>kullanici adı</th><th>Text</th><th>tarih</th><th>retweet</th><th>lat</th><th>long</th><th>tip</th></tr>";
	$sql = 'INSERT INTO deprem(username, img, contents, created,retweet,latitude, longitude,tip) VALUES';
	$index = 0;
	$tip=0;
	
	
	
	
	if(isset($tweets->statuses)){
		foreach ( $tweets->statuses as $tweet ){
			
			$id = $tweet->id_str;
			$username = $tweet->user->screen_name; // tweet atan kullanici id
			
			$profile_img = $tweet->user->profile_image_url;// tweet atan kullanici profil photo
			$text = str_replace("'", '`',$tweet->text);// tweet içerik
			$created_at = date("Y-m-d H:i:s", strtotime($tweet->created_at));// tweet tarihi
			$retweet = $tweet->retweet_count;// tweet sayısı
			

			$lat = $tweet->geo->coordinates[0];
			$long = $tweet->geo->coordinates[1];
			
			$lat2 = $tweet->coordinates->coordinates[1];
			$long2 = $tweet->coordinates->coordinates[0];
			
			$lat3 = $tweet->place->bounding_box->coordinates[0][0][1];
			$long3 =$tweet->place->bounding_box->coordinates[0][0][0];
				$tip=3;
			
			
			
			if($lat3!="0")
			{
				$lat=$lat3;
				$long=$long3;
				$tip=1;
					
			}	
			elseif($lat2!="0"){
				
				$lat=$lat2;
				$long=$long2;
				$tip=2;
				
			}			
			
			
		
			
			
			
			//if($lat!=""){
				if($created_at > $lastcreated){
					//echo "username = ". $username . " last = ". $lastcreated . " and created_ad = ". $created_at. "<br>";
						if($index == 0){
							$sql .= "('".$username."', '".$profile_img."', '".$text."', '".$created_at."', '".$retweet."', '".$lat."', '".$long."', '".$tip."')";
							$index = 1;
						}else
							$sql .= ",('".$username."', '".$profile_img."', '".$text."', '".$created_at."', '".$retweet."', '".$lat."', '".$long."', '".$tip."')";
														
						$table.= '<tr><td><img src="'.$profile_img.'" /></td><td> '.$username.'</td><td> '.$text.'</td><td>' .$created_at.'</td><td>' .$retweet.'</td><td>' .$lat.'</td><td>' .$long.'</td><td>' .$tip.'</td></tr>';	
						}
				//}
			
				
		}
		//$result = mysql_query($sql) or die('');
		
		$db->exec($sql);
		
	}
	echo $table;
?>
