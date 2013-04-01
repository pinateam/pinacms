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



$request->filterParams("strip_tags trim", "person_title person_position person_email person_phone");
$request->filterParams("filter_only_y_n", "person_enabled");

validateNotEmpty($request, "person_title" , lng('enter_text'));
//validateUserEmail($request, 'person_email');
//validateNotEmpty($request, "person_position"    , lng('enter_text'));
//validateNotEmpty($request, "person_description" , lng('enter_text'));

$request->trust();

$data = $request->params();

require_once PATH_TABLES.'person.php';
$personGateway = new PersonGateway();
$person_id = $personGateway->add($data);

$data["person_id"] = $person_id;

require_once PATH_TABLES.'person_photo.php';
$photoGateway = new PersonPhotoGateway();

require_once PATH_DOMAIN.'image.php';
ImageDomain::save("person_photo", $photoGateway, $person_id, $data);

$request->setRedirect(href(array("action" => "person.manage.edit", "person_id" => $person_id)));
$request->ok();
