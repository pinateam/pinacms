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



    require_once PATH_MODEL .'core/DirectoryImport.php';
    require_once PATH_MODEL .'core/StringImport.php';
    
    set_time_limit(3600);

    $data = $request->param('data');
    if(empty($data['path'])) $request->error(lng('enter_path'), 'path');
    if(empty($data['coding'])) $request->error(lng('enter_coding'), 'coding');
    
    $import = '';
    switch ($data['path'])
    {
        case 'directory':
            $import = new DirectoryImport();
        break;
        case 'string':
            $import = new StringImport();
        break;
    }

    if(!is_object($import)) $request->error(lng('internal_error'));
    $request->trust();

    $codings = array('cp1251' => 'UTF-8', 'UTF-8' => 'cp1251');
    foreach($codings as $input=>$output)
    {
        if($input == $data['coding'])
        {
            $import->setInputCoding($input);
            $import->setOutputCoding($output);
        }
    }

    $request->result('result',$import->import());

    $request->ok();