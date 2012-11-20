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



function smarty_function_module($__params, &$__view)
{
	if (!isset($__params['action'])) return '';

	if (!isModuleActive($__params['action'])) return '';
	if (!isModulePermitted($__params['action'])) return '';

	$request = new BlockRequest($__view, $__params);
	$action = $request->getHandler();

	$vars_backup = $__view->_tpl_vars;

	try
	{
		include PATH_CONTROLLERS.$action.'.php';
	}
	catch (Exception $e)
	{
		echo "<p>".$e->getMessage()."</p>";
		return;
	}

	if (is_array($request->error_messages) && count($request->error_messages))
	{
		echo '<p>'.join("<br />", $request->error_messages)."</p>";
		return;
	}

	$result = $__view->fetch('blocks/'.$action.'.tpl');
	$__view->_tpl_vars = $vars_backup;

	return
		(!empty($__params['wrapper'])?('<div class="'.$__params['wrapper'].'">'):'').
                $result.
		(!empty($__params['wrapper'])?('</div>'):'');
}
