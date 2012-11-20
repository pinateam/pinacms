
<?php
require_once PATH_TABLES .'post_rating.php';


$data = $request->params();
$data ['site_id'] = Site::id();


$postRatingGateway  = new PostRatingGateway();
$ratings=$postRatingGateway ->findBy("user_id",$data["user_id"]);
if(!$ratings) $postRatingGateway ->add($data);


$request->ok();
