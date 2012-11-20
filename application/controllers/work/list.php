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



    require_once PATH_TABLES .'work.php';
    $workGateway = new WorkGateway();
    $works = $workGateway->findAvailableBySiteAnd("work_group_id",$request->param('work_group_id'));

    require_once PATH_TABLES.'work_image.php';
    $workImageGateway = new WorkImageGateway();
    $images = $workImageGateway->findAll();

    $list = $works;

    $index=0;
    foreach ($list as $item)
    {
            $indexImage=0;
            foreach($images as $image)
            {
                    if ($list[$index]['work_id']==$images[$indexImage]['work_id'])
                    {
                            $list[$index]['work_image_filename']=$images[$indexImage]['work_image_filename'];
                            $list[$index]['work_image_width']=$images[$indexImage]['work_image_width'];
                            $list[$index]['work_image_height']=$images[$indexImage]['work_image_height'];
                            $list[$index]['work_image_type']=$images[$indexImage]['work_image_type'];
                            $list[$index]['work_image_size']=$images[$indexImage]['work_image_size'];
                    }
                    $indexImage++;
            }
            $index++;
    }

    $request->result('works', $list);

    $request->ok();