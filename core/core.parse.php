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



function parseBetweenMarkers(&$content, $markerBegin, $markerEnd, $left = 0)
{
	$pos = strpos($content, $markerBegin, $left);
//	echo "\nparse-pos: ".$pos;

	if ($pos === false) return false;

	$posStart = $pos + strlen($markerBegin);
	$posEnd = strpos($content, $markerEnd, $posStart);
/*
echo "\nparse-marker: ".$markerBegin;
echo "\nparse-Left: ".$left;
echo "\nparse-Start: ".$posStart;
echo "\nparse-End: ".$posEnd;
*/
	if ($posEnd === false) return false;

	$data = substr($content, $posStart, $posEnd - $posStart);

	return $data;
}

function loadFile($path, $url, $hashSrc)
{
	$imageContent = HttpCurl::request($url, 'GET');
	if (empty($imageContent)) return false;

	$name = md5($hashSrc);
	$typePos = strrpos($url, '.');
	$type = substr($url, $typePos+1);
	
	$name .= ".".$type;
		
	$first = substr($name, 0, 2);
	$second = substr($name, 2, 2);
	@mkdir(PATH.$path.$first, 0777);
	@mkdir(PATH.$path.$first."/".$second, 0777);
	file_put_contents(PATH.$path.$first."/".$second."/".$name, $imageContent);
	@chmod(PATH.$path.$first."/".$second."/".$name, 0777);
	
	return $name;
}
