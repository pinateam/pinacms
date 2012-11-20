
<?php

    require_once PATH_TABLES .'post_comment_rating.php';

 
    $postCommentRatingGateway  = new PostCommentRatingGateway();
    $postCommentRatingGateway->remove($request->param('rating_id'));
    
    $request->ok();