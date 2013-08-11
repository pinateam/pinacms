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



	$now = time();

	$date_formats = array(
	    "d.m.Y", "d/m/Y", "d-m-Y",
	    "m/d/Y", "m-d-Y", "Y-m-d"
	);
	
	$date_format_selector = array();
	foreach ($date_formats as $f)
	{
		$date_format_selector [] = array("value" => $f, "caption" => date($f, $now), "color" => "orange");
		//$date_format_selector [$f] = date($f, $now);
	}

	$request->result("date_format_selector", $date_format_selector);
	
	$time_formats = array(
	    "H:i", "H:i:s", "h:i A", "h:i:s A",
	    "H.i", "H.i.s", 
	);
	
	$time_format_selector = array();
	foreach ($time_formats as $f)
	{
		$time_format_selector [] = array("value" => $f, "caption" => date($f, $now), "color" => "orange");
		//$date_format_selector [$f] = date($f, $now);
	}

	$request->result("time_format_selector", $time_format_selector);

	$request->addLocation(lng("settings"), href(array("action" => "config.manage.home")));
	$request->setLayout("admin");
	$request->ok(lng("date_time_format"));