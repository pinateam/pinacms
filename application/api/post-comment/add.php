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

    $postId = $request->param('post_id');

    if(empty($postId)) $request->stop(lng('internal_error'));
    
    $request->filterParams("trim", "visitor_email comment_message");
    
    Session::set("fill_post_comment", $request->params("visitor_email visitor_name comment_message visitor_site answer_comment_id"));
    
    validateNotEmpty($request, 'visitor_name', lng('enter_name'));
    validateNotEmpty($request, 'comment_message', lng('enter_message'));
    validateUserEmail($request, 'visitor_email');

    $request->trust();

    $params = array(
	'visitor_email' => $request->param("visitor_email"),
	'visitor_name' => $request->param("visitor_name"),
	'comment_message' => $request->param("comment_message"),
	'visitor_site' => $request->param("visitor_site"),
	'answer_comment_id' => $request->param("answer_comment_id"),
	'post_id'=> $postId,
	'visitor_ip' => $_SERVER['REMOTE_ADDR'],
	'comment_approved' => 'Y',
	'user_id' => Session::get("auth_user_id")?Session::get("auth_user_id"):0
    );

    $post = new PostCommentGateway();
    $postCommentId = $post->add($params);
    
    Session::drop("fill_post_comment");

    if(!$postCommentId) $request->stop(lng('internal_error'));

    $request->setRedirect(href(array("action" => "post.view", "post_id" => $postId)));
    $request->ok();


