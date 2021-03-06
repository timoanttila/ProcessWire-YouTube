<?php
if(!in_array($_SERVER['REMOTE_ADDR'], array($myip, $serverip)) || !$user->hasRole("superuser"){
	$session->redirect("/");
	die();
}
$video_id = "UC0V6NsKvhBVDJh0jzNoAf3w";
if($video_id){

	$xml = "https://www.youtube.com/feeds/videos.xml?channel_id={$video_id}";
	$xml = simplexml_load_file($xml);

	$parent = $pages->get("template=videos");

	foreach ($xml->entry as $feed) {

		// Video's information
		$id = $title = $date = $check = "";
		$id = substr($feed->id, 9);
		$title = (string)$feed->title;
		$date = date('d.m.Y', strtotime($feed->published));

		// Check if the video exists
		$check = $pages->get("template=video, video={$id}");

		if(!$check->id){
			$file = "https://i1.ytimg.com/vi/". $id ."/mqdefault.jpg";
			$t = new Page();
			$t->template = $templates->get('video');
			$t->parent = $parent->id;
			$t->title = $feed->title;
			$t->video = $id;
			$t->date = $date;
			$t->save();
			// Add an image to the new page if it exists
			if(file_exists($file)){
				$p = $pages->get("template=video, sort=-date");
				$p->of(false);
				$p->img->add($file);
				$p->save();
			}
		}
	}
}
