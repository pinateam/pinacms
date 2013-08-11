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


    
    require_once PATH_TABLES .'site.php';
    require_once PATH_TABLES .'module.php';
    require_once PATH_TABLES .'account.php';
    require_once PATH_TABLES .'user.php';

    class WizardDomain
    {
        function __construct()
        {
            $this->dir = PATH_VIEW .'templates/';
            $this->siteDir = PATH_VIEW .'sites/';

	    require_once PATH_TABLES."module.php";
	    $moduleGateway = new ModuleGateway;
	    $ms = $moduleGateway->findAll();

	    $this->builds = array();
	    $buildRels = array();
	    $buildRels['card'] = array('common', 'content', 'other', 'user');
	    $buildRels['shop'] = array('catalog', 'order', 'shipping', 'payment');
	    $buildRels['shop'] = array_merge($buildRels['shop'], $buildRels['card']);
	    foreach ($ms as $m)
	    {
		if ($m["module_key"] == "wizard") continue;
		foreach ($buildRels as $k => $r)
		{
			if (in_array($m['module_group'], $r))
			{
				$this->builds[$k][] = $m['module_key'];
			}
		}
	    }
        }

        public function findTemplates()
        {
            $templates = array();

            $templates[] = array(
		'template' => 'default',
                'title' => 'default',
                'screen' => Site::baseUrl(0) .'style/screenshot.png',
                'description' => file_exists(PATH_VIEW .'default/description.txt') ? htmlspecialchars(file_get_contents(PATH_VIEW .'default/description.txt')) : ''
            );

            $dh  = opendir($this->dir);
            while (false !== ($filename = readdir($dh)))
            {
                if (in_array($filename, array('.', '..', '.svn')) || !is_dir($this->dir . $filename)) continue;

		if (!file_exists(PATH.'style/templates/'. $filename .'/screenshot.png')) continue;
		
                $templates[] = array(
		    'template'  => $filename,
                    'title'  => $filename,
                    'screen' => Site::baseUrl(0) .'style/templates/'. $filename .'/screenshot.png',
                    'description' => file_exists($this->dir . $filename .'/description.txt') ? htmlspecialchars(file_get_contents($this->dir . $filename .'/description.txt')) : ''
                );
            }
            return $templates;
        }

        public function issetTemplate($template)
        {
            if($template == 'default') return true;
            return file_exists($this->dir . $template);
        }

        public function checkDomain($domain)
        {
            $domain = (string)trim($domain);
            $lenDomain = strlen($domain);
            if($lenDomain > 63 || $lenDomain < 2 || ($domain[2] == '-' && $domain[2] == $domain[3])) return false;
            preg_match('#^([^-\.][a-z\d\.-]+\.[a-z]{2,6})$#', $domain, $matches);
            if(!isset($matches[0]) || strlen($matches[0]) != $lenDomain) return false;

            $siteGateway = new SiteGateway();
            if($siteGateway->getBy('site_domain', $domain) || $siteGateway->getBy('site_path', $domain)) return false;
            return true;
        }

        public function checkBuild($build)
        {
            if(is_array($this->builds[$build])) return true;
            return false;
        }
        
        public function create($data)
        {
            $accountGateway = new AccountGateway();
            $account = $accountGateway->getBy('user_id', Session::get("auth_user_id"));
            if(!is_array($account))
            {
                $accountId = $accountGateway->add(array('user_id' => Session::get("auth_user_id")));
            }
            else
            {
                $accountId = $account['account_id'];
            }

            if(empty($accountId))
            {
                return false;
            }

            $siteGateway = new SiteGateway();
            $siteId = $siteGateway->add(array(
                'account_id'    => $accountId,
                'site_domain'   => $data['domain'],
                'site_template' => $data['template'] != 'default' ? $data['template'] : '',
                'site_path'     => str_replace(".", "-", $data["domain"]),
            ));

            if(!$siteId)
            {
                return false;
            }
            
            $dir = PATH."application/install/";

	    $currentSiteId = Site::id();
            Site::initById($siteId, true);
            foreach ($this->builds[$data['build']] as $m)
            {
                    if (file_exists($dir.$m."/module.php"))
                    {
                            include $dir.$m."/module.php";
                    }
            }


	    if ($data['load_data'] == 'Y')
	    {
		    foreach ($this->builds[$data['build']] as $m)
		    {
			    if (file_exists($dir.$m."/demo.php"))
			    {
				    include_once $dir.$m."/demo.php";
			    }
		    }
	    }

            $userGateway = new UserGateway();
            $userGateway->useAccountId = false;
            $user = $userGateway->get(Session::get('auth_user_id'));
            if ($user['access_group_id'] == '1')
            {
                $userGateway->edit(Session::get('auth_user_id'), 
			array(
			    'access_group_id' => '3', //merchant
			    'user_status' => 'active',
			    'account_id' => $accountId
			)
		);
            }

	    //setcookie(session_name(), $_COOKIE[session_name()], time()+10000, "/", $data['domain']);
	    $config = getConfig();
	    if ($config->get("wizard", "root_test_domain"))
	    {
		    setcookie(session_name(), $_COOKIE[session_name()], time()+60*60*24*30, "/", ".".$config->get("wizard", "root_test_domain"));
		    session_regenerate_id();
	    }

	    Site::initById($currentSiteId);

            return $siteId;
        }

    }

