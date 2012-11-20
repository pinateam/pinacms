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
    $result .= "DirectoryIndex page.php?action=home".$end;
    $result .= $end;

    $result .= "Options +FollowSymLinks -MultiViews -Indexes".$end;
    $result .= $end;

    $result .= "RewriteEngine On".$end;
    $result .= "RewriteBase /".SITE_PATH.$end;
    $result .= "RewriteCond %{REQUEST_FILENAME} !\.(gif|jpe?g|png|js|css|swf|php|ico)$".$end;
    $result .= "RewriteCond %{REQUEST_FILENAME} !-f".$end;
    $result .= "RewriteCond %{REQUEST_FILENAME} !-d".$end;
    $result .= "RewriteCond %{REQUEST_FILENAME} !-l".$end;
    $result .= $end;

    include PATH."config/config.dispatcher.php";
    foreach ($config_dispatcher as $rule)
    {
        $pattern = dispatch_getPattern($rule["pattern"]);

        preg_match_all("/{(\w*):/", $rule["pattern"], $matches);
        $titles = $matches[1];

        $result .= "RewriteRule ^".$pattern.(!empty($pattern)?"\.html":"")."$ page.php?action=".$rule["action"];
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
        $result .= " [L]".$end;

        #print_r($pattern); print_r($titles);
    }

    $result .= "RewriteRule ^(.*)\.html$ page.php?dispatch=$1 [L]".$end;
    $result .= "RewriteRule ^([^\/]*)\/page\.php$ page.php?path=$1 [L]".$end;
    $result .= "RewriteRule ^([^\/]*)\/api\.php$ api.php?path=$1 [L]".$end;
    $result .= "RewriteRule ^([^\/]*)\/block\.php$ block.php?path=$1 [L]".$end;
    $result .= "RewriteRule ^([^\/]*)\/$ page.php?action=home&path=$1 [L]".$end;

    $request->result("result", $result);
    $request->ok();