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



$redirectAction = $request->param('redirect_action');

if (Session::get("auth_user_id"))
{
        if(!empty($redirectAction) && isModulePermitted($redirectAction))
        {
                redirect(href(array('action' => $redirectAction)));
        }
	elseif (isModuleActive("order.cart") && isModulePermitted("order.cart"))
	{
		redirect(href(array("action" => "order.cart")));
	}
	elseif (isModuleActive("dashboard") && isModulePermitted("dashboard"))
	{
		redirect(href(array("action" => "dashboard")));
	}
	else
	{
		redirect(href(array("action" => "home")));
	}
}

$request->result('redirect_action', $redirectAction);

$request->ok();