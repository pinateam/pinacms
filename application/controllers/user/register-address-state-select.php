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



require_once PATH_TABLES."directory.php";

$code = $request->param("country_key");

$directory = new DirectoryGateway();

if (empty($code))
{
	//если страна не инициализирована, берем первую из списка
	//TODO: сделать домен, который будет говорить, какая страна должна идти по умолчанию.
	$cs = $directory->findByKey("country");
	$code = $cs[0]['directory_value'];
}

$ss = $directory->findByKey("state_".$code);

$states = array();
foreach ($ss as $k => $v)
{
        $states[$v["directory_value"]] = $v["directory_title"];
}
$request->result("states", $states);

if ($request->param("value"))
{
        $request->result("value", $request->param("value"));
}

$request->ok();