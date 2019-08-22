<?php
if($temp == "videos"){
	$id = $page->child->video;
	$item = $page->children("id!={$page->child->id}");
} else {
	$id = $page->video;
	$item = $page->parent->children("id!={$page->id}");
}

// Featured video
echo "<div class='video mb-5'><iframe src='https://www.youtube-nocookie.com/embed/{$id}' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";

// Other videos
if($item->first->id){
	echo "<div class='row'>";
	foreach($item as $item){
		if(!$item->img->first) {
			$file = "https://i1.ytimg.com/vi/". $item->video ."/mqdefault.jpg";
			$headers = @get_headers($file);
			if(strpos($headers[0],'404') === false){
				$item->of(false);
				$item->img->add($file);
				$item->save();
			}
		}
		echo "<a class='col-4 r12 r7 mb-4 text-black' href='$item->url' title='YouTube: $item->title ($item->pubdate)'><figure>". img($item->img->first,$item->title) ."<figcaption><h2 class='mb-0 mt-3'>$item->title</h2><div class='pubdate'>$item->pubdate</div></figcaption></figure></a>";
	}
	echo "</div>";
}
