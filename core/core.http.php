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



class HttpCurl
{
	static function request($url, $method="GET", $params = "") 
	{
			if (is_array($params)) $params = self::array2url($params);

			$curl = curl_init($url . ($method == "GET" && $params != "" ? "?" . $params : ""));
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPGET, ($method == "GET"));
			curl_setopt($curl, CURLOPT_POST, ($method == "POST"));

			if ($method == "POST") curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($curl);
//			print_r($curl);
			if (curl_errno($curl) == 0){
				return $response;
			}
			return false;
	}

	static function array2url($params)
	{
		if (!is_array($params)) return false;

		$query = "";
		foreach ($params as $ppp => $vvv)
		{
			$query .= "&".$ppp."=".$vvv;
		}
		return substr($query, 1);
	}
}
