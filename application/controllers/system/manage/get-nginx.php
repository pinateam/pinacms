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



    $end = "<br />";

    $result = "";
    $result .= $end;

    include PATH."config/config.dispatcher.php";
    foreach ($config_dispatcher as $rule)
    {
        $pattern = dispatch_getPattern($rule["pattern"]);

        preg_match_all("/{(\w*):/", $rule["pattern"], $matches);
        $titles = $matches[1];

        $result .= 'if ($request_filename ~ ('.$pattern.(!empty($pattern)?"\.html":"").') ) {'.$end;
        $result .= "\t".'rewrite ^/'.$pattern.(!empty($pattern)?"\.html":"").'$ /'.SITE_PATH.'page.php?action='.$rule["action"];

        $pos = 1;
        foreach ($titles as $t)
        {
            $result .= "&".$t."=$".$pos;
            $pos ++;
        }
        foreach ($rule as $name => $value)
        {
            if ($name == "action" || $name == "pattern") continue;
            $result .= "&".$name."=".$value;
        }
        $result .= ';'.$end;
        $result .= '}'.$end.$end;

        #print_r($pattern); print_r($titles);
    }


    $result .= 'if ($request_filename ~ ((.*)\.html) ) {'.$end;
    $result .= 'rewrite ^/(.*)\.html$ /'.SITE_PATH.'page.php?dispatch=$1;'.$end;
    $result .= '}'.$end.$end;

    $result .= 'if ($request_filename ~ (([^\/]*)\/page\.php) ) {'.$end;
    $result .= 'rewrite ^/([^\/]*)\/page\.php$ /'.SITE_PATH.'page.php?path=$1;'.$end;
    $result .= '}'.$end.$end;

    $result .= 'if ($request_filename ~ (([^\/]*)\/api\.php) ) {'.$end;
    $result .= 'rewrite ^/([^\/]*)\/api\.php$ /'.SITE_PATH.'api.php?path=$1;'.$end;
    $result .= '}'.$end.$end;

    $result .= 'if ($request_filename ~ (([^\/]*)\/block\.php) ) {'.$end;
    $result .= 'rewrite ^/([^\/]*)\/block\.php$ /'.SITE_PATH.'block.php?path=$1;'.$end;
    $result .= '}'.$end.$end;

    $result .= 'if ($request_filename ~ (([^\/]*)\/) ) {'.$end;
    $result .= 'rewrite ^/([^\/]*)\/$ /'.SITE_PATH.'page.php?action=home&path=$1;'.$end;
    $result .= '}'.$end.$end;


    $request->result("result", $result);
    $request->ok();