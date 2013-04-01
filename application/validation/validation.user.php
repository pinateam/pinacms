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



function validateAuth($request)
{
	if (!Session::get('auth_user_id'))
	{
		$request->setRedirect(href(array('action' => 'user.enter')));
		$request->stop(lng('please_sign_in_or_register'));
	}
}

function validateAccess($subject, $action)
{
}

function validateSingleOwner($owner_id, $item_id, $subject)
{
}

function validateAuthAdmin()
{
        validateAuth();
        #TODO: isAdmin
}

function validateNewLogin($request)
{
        $user_login = $request->param('user_login');
        if (empty($user_login))
        {
                $request->error(lng('enter_user_login'), 'user_login');
        }

        if (strlen($user_login) < 3)
        {
                $request->error(lng('user_login_should_be_more_3_characters'), 'username');
        }

        validateTokenChars($request, "user_login");
}

function validateUniqueUsernameAndEmail($request)
{
	require_once PATH_TABLES."user.php";
	
        $user = new UserGateway;
        $u = $user->getByLoginOrEmail($request->param('user_login'), $request->param('user_email'));

        if (empty($u)) return;

        if ($u['user_login'] == $request->param('user_login'))
        {
                $request->error(lng('user_login_is_already_exists'), 'user_login');
        }

        if ($u['user_email'] == $request->param('user_email'))
        {
                $request->error(lng('user_email_is_already_exists'), 'user_email');
        }
}

function validateNewPassword($request)
{
	if (!$request->param('new_password'))
	{
		$request->error(lng('enter_password'), 'new_password');
	}

	if (!$request->param('new_password2') || $request->param('new_password') != $request->param('new_password2'))
	{
		$request->error(lng('password_does_not_match_confirmation'), 'new_password2');
	}
}

function validatePassword($request, $passwordHash)
{
	if (!passwordVerify($request->param('user_password'), $passwordHash))
	{
		$request->error(lng('wrong_password'), 'user_password');
	}
}

function validateUserEmail($request, $field = 'user_email')
{
	if (!$request->param($field) || !isEmail($request->param($field)))
	{
		$request->error(lng('wrong_email'), $field);
	}
}

function validateUserLogin($request)
{
	$user_login = $request->param("user_login");
	if (empty($user_login))
	{
	    $request->stop(lng('enter_user_login'), 'user_login');
	}

	if (strlen($user_login) < 3)
	{
	    $request->stop(lng('user_login_should_be_more_3_characters'), 'user_login');
	}

	validateTokenChars($request, "user_login");
}

function validateUserOperationPermitted($request, $key = 'user_id')
{
	
	$user_id = $request->param("user_id");
	$user_id = intval($user_id);

	require_once PATH_TABLES."user.php";
	$user = new UserGateway;
	$u = $user->get($user_id);

	if ($u["account_id"] != Site::accountId())
	{
		$request->stop(lng("access-denied"));
	}
	
}