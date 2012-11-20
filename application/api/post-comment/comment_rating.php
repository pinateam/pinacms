
<?php
require_once PATH_TABLES .'post_comment_rating.php';

$data = $request->params();
$data ['site_id'] = Site::id();

$postCommentRatingGateway  = new PostCommentRatingGateway();
$ratings=$postCommentRatingGateway->findBy("user_id",$data["user_id"]);
if(!$ratings) $postCommentRatingGateway->add($data);

$request->ok();
