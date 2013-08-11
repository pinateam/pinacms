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



require_once PATH_DOMAIN."image.php";

require_once PATH_TABLES."slide.php";
$slideGateway = new SlideGateway;

if (!$slideGateway->reportCountBy("slide_href", "http://www.pinacart.com/"))
{
	$imageId = ImageDomain::saveCopy(
		PATH .'import/demo/slide-1.png',
		"slide-1.png"
	);

	$slideGateway->add(array(
		"image_id" => $imageId,
		"slide_href" => "http://www.pinacart.com/",
		"slide_enabled" => "Y"
	));
}

if (!$slideGateway->reportCountBy("slide_href", "http://www.pinacms.com/"))
{
	$imageId = ImageDomain::saveCopy(
		PATH .'import/demo/slide-2.png',
		"slide-2.png"
	);

	$slideGateway->add(array(
		"image_id" => $imageId,
		"slide_href" => "http://www.pinacms.com/",
		"slide_enabled" => "Y"
	));
}