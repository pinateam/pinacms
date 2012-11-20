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



    require_once PATH_TABLES .'person.php';
    require_once PATH_TABLES.'person_photo.php';

    $personGateway = new PersonGateway();
    $persons = $personGateway->findBy("person_enabled", "Y");

    $photoGateway = new PersonPhotoGateway();
    $photos = $photoGateway->findAll();

    $datas = $persons;

    $index=0;
    foreach ($datas as $data)
    {
            $indexPhoto=0;
            foreach($photos as $photo)
            {
                    if ($datas[$index]['person_id']==$photos[$indexPhoto]['person_id'])
                    {
                            $datas[$index]['person_photo_filename']=$photos[$indexPhoto]['person_photo_filename'];
                            $datas[$index]['person_photo_width']=$photos[$indexPhoto]['person_photo_width'];
                            $datas[$index]['person_photo_height']=$photos[$indexPhoto]['person_photo_height'];
                            $datas[$index]['person_photo_type']=$photos[$indexPhoto]['person_photo_type'];
                            $datas[$index]['person_photo_size']=$photos[$indexPhoto]['person_photo_size'];
                    }

                    $indexPhoto++;
            }
            $index++;
    }


    $request->result('persons', $datas);
    $request->ok(lng('team'));