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



function smarty_function_number_as_text($params, &$smarty)
{
	if (!isset($params['value']))
		return '';

	$value = $params['value'];
	$first_upper = true;
	$L = $value;
	 
	global $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd, $kopeek;

	$s=" ";
	$s1=" ";
	//считаем количество копеек, т.е. дробной части числа
	$kop=intval(( $L*100 - intval($L)*100 ));
	//отбрасываем дробную часть
	$L=intval($L);

	if($L>=1000000000)
	{
		$many=0;
		semantic(intval($L / 1000000000),$s1,$many,3);
		$s.=$s1.$namemrd[$many];
		$L%=1000000000;
	}

	if($L >= 1000000)
	{
		$many=0;
		semantic(intval($L / 1000000),$s1,$many,2);
		$s.=$s1.$namemil[$many];
		$L%=1000000;
		//аналогично если ровно сколько-то миллионов, то хватит считать
	}

	if($L >= 1000)
	{
		$many=0;
		semantic(intval($L / 1000),$s1,$many,1);
		$s.=$s1.$nametho[$many];
		$L%=1000;
	}
	if($L != 0)
	{
		$many=0;
		semantic($L,$s1,$many,0);
		$s.=$s1;
	}


	$result =trim($s);

	if (isset($params['assign'])) {
		$smarty->assign($params['assign'], $result);
		$result = '';
	}
	
	return $result;
}