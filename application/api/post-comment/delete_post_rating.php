
<?php

    require_once PATH_TABLES .'post_rating.php';

 
    $postRatingGateway  = new PostRatingGateway();
    $postRatingGateway->remove($request->param('rating_id'));
    
    $request->ok();