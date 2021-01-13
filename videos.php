<?php
if($page->template == "videos"){
	$parent = $page;
	$video = $page->child->video;
} else {
	$parent = $page->parent;
	$video = $page->video;
}

// Featured Big
$c .= "<div id='video' class='video my-5'><iframe src='https://www.youtube-nocookie.com/embed/". $main->video ."?rel=0' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";

// Other videos
$c .= "<div id='videos' class='grid'>";
foreach($parent->children("template=video, id!=". $main->id) as $item){

	// If image does not exist
	if(!$item->img->first){
		$file = "https://i1.ytimg.com/vi/". $item->video ."/mqdefault.jpg";
		if(@GetImageSize($file)){
			$item->of(false);
			$item->img->add($file);
			$item->save();
		}
	}

	// Create link
	$c .= "<a class='block' href='$item->url'>". img($item->img->first,$item->title) ."<div class='videoTitle'>$item->title</div><div class='pubdate'>". date("d.m.Y", $item->post_date) ."</div></a>";
}
$c .= "</div>";

// Render
echo $c;
