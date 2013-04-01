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

    if (!empty($_SERVER["HTTP_HOST"])) die('access-denied');

    include "init.php";

    include_once PATH_CORE."request/ApiRequest.php";

    $data = array();
    if (is_array($argv))
    foreach ($argv as $v)
    {
        $param = explode('=', $v);
        if (count($param) != 2)
        {
            continue;
        }

        $data[$param[0]] = $param[1];
    }

    $request = new ApiRequest($data);
    $action = $request->getHandler();
    if (!file_exists(PATH_API.$action.".php"))
    {
        if (file_exists(PATH_CONTROLLERS."fatal-error.php"))
        {
            require_once PATH_CONTROLLERS."fatal-error.php";
        }
        exit;
    }

    require_once PATH_API.$action.".php";
