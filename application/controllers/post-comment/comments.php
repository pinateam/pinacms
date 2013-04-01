<?php
/*
* PinaCMS
* 
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
* A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
* SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
* THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* @copyright © 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }



require_once PATH_TABLES .'post_comment.php';
require_once PATH_TABLES .'post_comment_rating.php';
require_once PATH_TABLES .'user.php';



$postId = $request->param("post_id");

$commentGateway = new PostCommentGateway();
$comments = $commentGateway->findBySiteAndPostAndApproved($postId, "Y");
$postCommentRatingGateway  = new PostCommentRatingGateway();
$ratings=$postCommentRatingGateway->findAll();
$request->result('ratings', $ratings);

$ind=0;
$size = 40;
foreach ($comments as $value)
{
	$mail=$value['visitor_email'];
	$emailGravatar = "http://ru.gravatar.com/avatar/";
	$grav_url = $emailGravatar. md5( strtolower( trim( $mail ) ) ) . "?size=" . $size;
	$comments[$ind]['gravatar_url']=$grav_url;
	foreach ($ratings as $rating)
	{
		if($value['comment_id']==$rating['comment_id'])
		{
			$comments[$ind]['rating']=$comments[$ind]['rating']+$rating['rating'];	
		}
	}
	$ind++;

	

	
}

$userGateway = new UserGateway();
$login=$userGateway->reportTitle(Session::get("auth_user_id"));
$email=$userGateway->reportEmailByid(Session::get("auth_user_id"));

$comments1=$comments;
$id=0;
 
foreach ($comments as $key =>$comment_ans) 
{
	$delete = 1;
	foreach ( $comments1 as $key =>$comment_id) 
	{
		if ($comment_ans["answer_comment_id"]==$comment_id["comment_id"])
		{
			$delete = 0;
		}
	}

	if ($delete)		
	{
		$comments[$id]["answer_comment_id"]=null;
	}
	$id++;       
}

$request->result('comments', $comments);

$request->result('auth_user_id',Session::get("auth_user_id"));
$comment_message = $request->param("comment_message");


if ($login)
{
	$fill = array(
		'visitor_email' => $email,	  
		'visitor_site'=> '',
		'visitor_name'=> $login,
		'comment_message'=> $comment_message
	);
}
else
{
	$fill = Session::get("fill_post_comment");
}



$request->result('fill', $fill);

$request->ok();