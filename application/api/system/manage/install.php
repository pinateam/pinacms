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



validateNotEmpty($request, "modules", "please specify modules list");

$modules = $request->param("modules");
$modules = preg_split("/[\s]+/",$modules);

if (is_array($modules))
foreach ($modules as $m)
{
	$m = trim($m);
	if (empty($m)) continue;

	if (file_exists(PATH.'/application/install/'.$m.'/database.php'))
	{
		include PATH.'/application/install/'.$m.'/database.php';
	}

	if (file_exists(PATH.'/application/install/'.$m.'/module.php'))
	{
		include PATH.'/application/install/'.$m.'/module.php';
	}
	else
	{
		$request->error("module not exists ".$m);
	}
}

$request->trust();

$request->ok();