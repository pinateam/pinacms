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



    require_once PATH_DOMAIN .'wizard.php';

    if(!Session::get("auth_user_id"))
    {
        $request->setRedirect(href(array("action" => "wizard.auth")));
        $request->stop();
    }
    
    $data = array(
        'domain'    => $request->param('domain'),
        'template'  => $request->param('template'),
        'build'     => $request->param('build'),
        'load_data' => $request->param('load_data') == 'Y' ? 'Y' : 'N'
    );
    Session::set('wizard_data', $data);

    $errors = array(
        'domain'    => lng('select_domain'),
        'template'  => lng('select_template'),
        'build'     => lng('select_build')
    );

    foreach($data as $field => $value)
    {
        if(empty($value))
        {
            $request->error($errors[$field], $field);
        }
    }
    $wizardDomain = new WizardDomain();
    if(!$wizardDomain->checkDomain($data['domain']))
    {
        $request->error(lng('invalid_domain'), 'domain');
    }
    if(!$wizardDomain->issetTemplate($data['template']))
    {
        $request->error(lng('select_template'), 'template');
    }
    if(!$wizardDomain->checkBuild($data['build']))
    {
        $request->error(lng('select_build'), 'build');
    }
    $request->trust();

    $siteId = $wizardDomain->create($data);
    if($siteId)
    {
        $request->setRedirect(href(array('action' => 'wizard.done')));
        Session::set('site_id', $siteId);
    }

    $request->ok();