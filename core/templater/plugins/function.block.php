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



function smarty_function_block($params, &$view)
{
	if (!isset($params['view'])) return '';
	if (!isModuleActive($params['view'])) return '';
	if (!isModulePermitted($params['view'])) return '';

	$vars_backup = $view->_tpl_vars;

	$params['view'] = str_replace('/', '', $params['view']);
	$params['view'] = str_replace('.', '/', $params['view']);

	if (is_array($params))
	foreach ($params as $name => $value)
	{
		$view->assign($name, $value);
	}

	$result = $view->fetch('blocks/'.$params['view'].'.tpl');
	$view->_tpl_vars = $vars_backup;

	return
		(!empty($params['wrapper'])?('<div class="'.$params['wrapper'].'">'):'').
		$result.
		(!empty($params['wrapper'])?('</div>'):'');
}
