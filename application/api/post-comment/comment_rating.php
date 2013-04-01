
<?php
require_once PATH_TABLES .'post_comment_rating.php';

$data = $request->params();

$postCommentRatingGateway  = new PostCommentRatingGateway();
$ratings=$postCommentRatingGateway->findBy("user_id",$data["user_id"]);
if(!$ratings) $postCommentRatingGateway->add($data);

$request->ok();
