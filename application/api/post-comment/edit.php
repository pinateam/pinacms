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

    validateAuth($request);
    
    $request->filterParams("trim", "visitor_email visitor_email comment_message");
    
    validateNotEmpty($request, 'visitor_name', lng('enter_name'));
    validateNotEmpty($request, 'comment_message', lng('enter_message'));
    validateUserEmail($request, 'visitor_email');

    $request->trust();
    
    $postId = $request->param('post_id');
    $commentId = $request->param('comment_id');
    
    $postCommentGateway = new PostCommentGateway();
    
    $userId = $postCommentGateway->reportUserId($commentId);
    if ($userId != Session::get("auth_user_id"))
    {
	$request->stop(lng('access_denied'));
    }
    
    $data = array(
	'post_id'=> $postId,
	  
	'user_id' => Session::get("auth_user_id")?Session::get("auth_user_id"):0,
	  
	'visitor_email' => $request->param("visitor_email"),
	'visitor_name' => $request->param("visitor_name"),
	'visitor_site' => $request->param("visitor_site"),
	'visitor_ip' => $_SERVER['REMOTE_ADDR'],
	  
	'comment_message' => $request->param("comment_message"),
	'comment_approved' => 'Y',
	'comment_updated' => date("Y-m-d H:i:s")
    );
    
    $postCommentGateway->edit($commentId, $data);
    
    $request->setRedirect(href(array("action" => "post.view", "post_id" => $postId)));     
    $request->ok();