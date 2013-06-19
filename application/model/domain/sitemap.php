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



        require_once PATH_TABLES .'category_site.php';
        require_once PATH_TABLES .'product_site.php';
        require_once PATH_TABLES .'post.php';
        require_once PATH_MODEL .'finder/category.php';
        require_once PATH_MODEL .'finder/product.php';
        require_once PATH_MODEL .'finder/post.php';
        require_once PATH_CORE.'classes/Paging.php';
        require_once PATH_CORE .'core.dispatcher.php';

        class SitemapDomain
        {
                function __construct()
                {
                        $config = getConfig();                        
                        
                        $this->catFinder   = new CategoryFinder();
                        $this->prodFinder  = new ProductFinder();
                        $this->postFinder  = new PostFinder();
                        //$this->paging = new Paging(0, $this->datebaseReadStep);
                        $this->catSorting  = new Sorting('category_id', 'asc');
                        $this->prodSorting = new Sorting('product_id', 'asc');
                        $this->postSorting = new Sorting('post_id', 'asc');

                        $this->fileName = 'index';
                        $this->fp = false;

                        $categorySiteGateway = new CategorySiteGateway();
                        $productSiteGateway = new ProductSiteGateway();
                        $postGateway = new PostGateway();

                        $this->types = array(
                                'category' => array(
                                        'loc'      => href(array("action" => "category.view", 'category_id' => '')),
                                        'priority' => $config->get('xml_sitemap', 'cat_priority') ? $config->get('xml_sitemap', 'cat_priority') : 0.8,
                                        'count'    => (int)$categorySiteGateway->reportCountBy('category_avail', 'Y')
                                ),
                                'product' => array(
                                        'loc'      => href(array('action' => 'product.view', 'product_id' => '')),
                                        'priority' => $config->get('xml_sitemap', 'prod_priority') ? $config->get('xml_sitemap', 'prod_priority') : 1,
                                        'count'    => (int)$productSiteGateway->reportCountBy('product_available', 'Y')
                                ),
                                'post' => array(
                                        'loc'      => href(array('action' => 'post.view', 'post_id' => '')),
                                        'priority' => $config->get('xml_sitemap', 'post_priority') ? $config->get('xml_sitemap', 'post_priority') : 0.5,
				        
                                        'count'    => (int)$postGateway->reportCountBy('site_id', Site::id())
				        
					
                                )
                        );
                        
                        $this->fileMaxUrls = $config->get('xml_sitemap', 'max_urls') ? $config->get('xml_sitemap', 'max_urls') : 50000;
                        $this->dbReadStep = 500;
                        $this->countFiles = ceil(
                                ($this->types['category']['count'] + 
                                $this->types['product']['count'] + 
                                $this->types['post']['count']) 
                                / $this->fileMaxUrls
                        );
                }

                private function writeIndexHeader($fp)
                {
                        gzwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>');
                        gzwrite($fp, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                }

                private function writeIndexFooter($fp)
                {
                        gzwrite($fp, '</sitemapindex>');
                }

                private function findIds($type, $start, $limit)
                {
                        $paging = new Paging(ceil($start / $limit) + 1, $limit);
                        switch ($type)
                        {
                                case 'category':
                                        return $this->catFinder->searchIds(array('avail' => 'Y'), $this->catSorting, $paging);
                                break;

                                case 'product':
                                        return $this->prodFinder->searchIds(array('store' => array('only_available')), $this->prodSorting, $paging);
                                break;

                                case 'post':
                                        return $this->postFinder->searchIds(array(), $this->postSorting, $paging);
                                break;
                        }
                        return false;
                }

                private function writeSitemapHeader($fp)
                {
                        gzwrite($fp, '<?xml version="1.0" encoding="UTF-8"?>');
                        gzwrite($fp, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
                }

                private function writeSitemapFooter($fp)
                {
                        gzwrite($fp, '</urlset>');
                }

                private function generateIndexFile($file)
                { 
                        $fp = gzopen($file, 'w');
                        $this->writeIndexHeader($fp);
                        for($i = 1; $i <= $this->countFiles; $i++)
                        {
                                gzwrite($fp, '<sitemap>');
                                gzwrite($fp, '<loc>'. htmlentities(Site::baseUrl() .'sitemap/'. Site::id() .'/'. $i .'.xml.gz') .'</loc>');
                                gzwrite($fp, '<lastmod>'. date('Y-m-d') .'</lastmod>');
                                gzwrite($fp, '</sitemap>');
                        }
                        $this->writeIndexFooter($fp);
                        fclose($fp);
                }

                function scanDir($dir)
                {
                        $list = scandir($dir);
                        unset($list[0],$list[1]);
                        return array_values($list);
                }

                function cleanDir($dir)
                {
                        $list = $this->scanDir($dir);
                        foreach ($list as $file)
                        {
                                if (is_dir($dir . $file))
                                {
                                        $this->cleanDir($dir . $file . DIRECTORY_SEPARATOR);
                                        rmdir($dir . $file);
                                }
                                else
                                {
                                        unlink($dir . $file);
                                }
                        }
                }
                
                public function getDir()
                {
                        $dir = PATH .'sitemap'. DIRECTORY_SEPARATOR.Site::id().DIRECTORY_SEPARATOR;
                        prepareDir($dir);
                        return $dir;
                }
                
                public function writeUrls($ids, $fp)
                {
                          
                }

                public function generate()
                {
                        $dir = $this->getDir();
                        $this->cleanDir($dir);
                       
                        if($this->countFiles > 1) 
                        {
                                $this->generateIndexFile($dir .'index.xml.gz');
                        }
                        
                        $fileName = 1;
                        $countUrls = 0;
                        $fp = gzopen($dir.$fileName .'.xml.gz', 'w');
                        $this->writeSitemapHeader($fp);
                        foreach($this->types as $type => $params)
                        {
                                for($start = 0; $start <= $params['count']; $start += $this->dbReadStep)
                                {
                                        $ids = $this->findIds($type, $start, $this->dbReadStep);
                                        foreach($ids as $id)
                                        {
                                                if($countUrls >= $this->fileMaxUrls)
                                                {
                                                        $fileName++;
                                                        $countUrls = 0;
                                                        $this->writeSitemapFooter($fp);
                                                        fclose($fp);
                                                        $fp = gzopen($dir.$fileName .'.xml.gz', 'w');
                                                        $this->writeSitemapHeader($fp);
                                                }
                                                gzwrite($fp, '<url>');
                                                gzwrite($fp, '<loc>'. htmlentities(url_rewrite($this->types[$type]['loc'].$id, false)) .'</loc>');
                                                gzwrite($fp, '<priority>'. $this->types[$type]['priority'] .'</priority>');
                                                gzwrite($fp, '<lastmod>'. date('Y-m-d') .'</lastmod>');
                                                gzwrite($fp, '</url>');
                                                ++$countUrls;
                                        }                                                                         
                                }
                        }
                        $this->writeSitemapFooter($fp);
                        fclose($fp);
                }
        }
