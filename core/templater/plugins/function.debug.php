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



function debugQueryTable($queries)
{
	if (!is_array($queries)) return false;


    $out = "";
	$out .= '<table style="width:100%">';
	$maxKey = 0;
    $maxKeyStyle = ' style="color:red;font-weight:bold;"';
    foreach ($queries as $key => $query)
	{
		if ($query["time"] > $queries[$maxKey]["time"]) $maxKey = $key;
	}

	foreach ($queries as $key => $query)
	{
		$out .= '<tr><td'.($key == $maxKey?$maxKeyStyle:'').'>'.$query['query'].'</td><td'.($key == $maxKey?$maxKeyStyle:'').'>'.sprintf("%.6f",$query['time']).'</td></tr>';
	}
	$out .= '</table>';
    return $out;
}


function smarty_function_debug($params, &$view) {
    if (!defined("DEBUG") && !defined("LOG_LOADTIME")) return '';

    global $startLoading;
    list($msec, $sec) = explode(' ', microtime());
    $endLoading = (float)$msec + (float)$sec;

    if (defined("DEBUG"))
    {
        $out .= debugQueryTable(getDB()->getDebug());
        $dbTotal = getDB()->getDebugTotal();

        $out .= debugQueryTable(Cache::$debug);
        $cacheTotal = Cache::getDebugTotal();

        $out .= "<pre>";
        $out .= "DB Time: ".($dbTotal)."\n";
        $out .= "Cache Time: ".($cacheTotal)." (".count(Cache::$data,COUNT_RECURSIVE)." items)"."\n";
        $out .= "PHP Time: ".($endLoading - $startLoading - $dbTotal - $cacheTotal)."\n";
        $out .= "Total Time: ".($endLoading - $startLoading)."\n";
        $out .= "</pre>";
        $out .= str_repeat("<br />", 10);
        //dump(Cache::$data);
        return '<div class="debug">'.$out.'</div>';
    }

    if (defined("LOG_LOADTIME"))
    {
        $fp = fopen(PATH."var/log/loadtime.log", "a+");
        if (@strpos($_SERVER['REQUEST_URI'], "<?") !== false || @strpos($_SERVER['HTTP_REFERER'], "<?") !== false)
            fwrite($fp, "try hack;".($endLoading - $startLoading).";".$_SERVER["REMOTE_ADDR"].";".$_SERVER["HTTP_REFERER"].";".date("Y-m-d H:i:s")."\n");
        else
            @fwrite($fp, $_SERVER['REQUEST_URI'].";".($endLoading - $startLoading).";".$_SERVER["REMOTE_ADDR"].";".$_SERVER["HTTP_REFERER"].";".date("Y-m-d H:i:s")."\n");
        fclose($fp);
    }

    return '';
}

