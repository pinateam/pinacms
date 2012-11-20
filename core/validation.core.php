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



function validateCaptcha($request)
{
	if (!$request->param("captcha") || $request->param("captcha") != Session::get('captcha_keystring'))
	{
		$request->error(lng("wrong_captcha_code"), 'captcha');
	}
}
	
function validateNotLoggedCaptcha($request)
{
	if (!Session::get('auth_user_id') && (!$request->param("captcha") || $request->param("captcha") != Session::get('captcha_keystring')))
	{
		$request->error(lng("wrong_captcha_code"), 'captcha');
	}
}

function validatePrice($request, $field = 'price')
{
        if (strval(floatval($request->param($field))) != $request->param($field))
        {
                $request->error(lng("wrong_price_format"), $field);
        }

        if (floatval($request->param($field)) >= 1000000000)
        {
                $request->error(lng("wrong_price_format"), $field);
        }
}

function validateImageType($request, $imType)
{
        $mimeType = image_type_to_mime_type($imType);
        if (!in_array($mimeType, array("image/jpeg", "image/gif", "image/png") ) )
        {
                $request->error(lng("wrong_data"));
        }
}

function validateTokenChars($request, $field, $message = '')
{
	$user_login = $request->param($field);
	for ($i = 0; $i < strlen($user_login); $i++)
        {
                if (
                        !(
                        ($user_login[$i] >= 'a' && $user_login[$i] <= 'z')
                        ||
                        ($user_login[$i] >= 'A' && $user_login[$i] <= 'Z')
                        ||
                        ($user_login[$i] >= '0' && $user_login[$i] <= '9')
                        ||
                        ($user_login[$i] == '-' || $user_login[$i] == '_')
                        )
                )
                {
			if (empty($message)) $message = lng('only_letters_numbers_dash_accepted');
                        $request->error($message, $field);
			break;
                }
        }
}

function validateNotEmpty($request, $field, $message)
{
	if ($request->param($field) == '') $request->error($message, $field);
}

function validateDateTimeFormat($request, $field)
{
	$date = $request->param($field);
	if (!preg_match("/^\s*[\d]{2}\.[\d]{2}\.[\d]{4}\s+[\d]{2}\:[\d]{2}(\:[\d]{2})?\s*$/i", $date))
	{
		$request->error(lng('wrong_date_format'), $field);
	}
}

function validateDateFormat($request, $field)
{
	$date = $request->param($field);
	if (!preg_match("/^\s*[\d]{2}\.[\d]{2}\.[\d]{4}\s*$/i", $date))
	{
		$request->error(lng('wrong_date_format'), $field);
	}
}

function validateDateStartEnd($request)
{
	$start = $request->param('date_start');
	$end   = $request->param('date_end');
	if ($start && $end)
	{
		if ($start >= $end)
		{
			$request->error(lng('date_start_end_explanation'), 'date_end');
		}
	}
}

function validateInArray($request, $field, $values, $message)
{
        $value = $request->param($field);
        if(!in_array($value, $values))
        {
                $request->error($message, $field);
        }
}