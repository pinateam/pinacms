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



$db = getDB();
$db->query("
CREATE TABLE IF NOT EXISTS `cody_config` (
  `site_id` int(10) NOT NULL DEFAULT '0',
  `account_id` int(10) NOT NULL DEFAULT '0',
  `module_key` varchar(32) NOT NULL DEFAULT '',
  `config_key` varchar(32) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  `config_type` varchar(32) NOT NULL DEFAULT 'text',
  `config_title` varchar(255) NOT NULL DEFAULT '',
  `config_description` varchar(255) NOT NULL DEFAULT '',
  `config_order` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`,`module_key`,`config_key`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_config_directory` (
  `account_id` int(10) NOT NULL DEFAULT '0',
  `config_module_key` varchar(32) NOT NULL DEFAULT '',
  `config_key` varchar(32) NOT NULL DEFAULT '',
  `directory_module_key` varchar(32) NOT NULL DEFAULT '',
  `direcoty_key` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`account_id`,`config_module_key`,`config_key`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_directory` (
  `site_id` int(10) NOT NULL DEFAULT '0',
  `module_key` varchar(32) NOT NULL DEFAULT '',
  `directory_key` varchar(32) NOT NULL DEFAULT '',
  `directory_value` varchar(255) NOT NULL DEFAULT '',
  `directory_title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`site_id`,`module_key`,`directory_key`,`directory_value`),
  KEY `language_code` (`site_id`,`module_key`,`directory_key`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_logo` (
  `site_id` int(10) NOT NULL DEFAULT '0',
  `logo_filename` varchar(255) NOT NULL DEFAULT '0',
  `logo_width` int(1) NOT NULL DEFAULT '0',
  `logo_height` int(1) NOT NULL DEFAULT '0',
  `logo_type` varchar(20) NOT NULL DEFAULT '',
  `logo_size` int(10) NOT NULL DEFAULT '0',
  `logo_alt` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`site_id`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_module` (
  `module_key` varchar(32) NOT NULL DEFAULT '',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `module_title` varchar(255) NOT NULL DEFAULT '',
  `module_description` varchar(255) NOT NULL DEFAULT '',
  `module_enabled` varchar(1) NOT NULL DEFAULT 'N',
  `module_version` varchar(16) NOT NULL DEFAULT '1.00',
  `module_config_action` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`module_key`,`site_id`),
  KEY `language_code` (`site_id`,`module_enabled`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_url` (
  `site_id` int(10) NOT NULL DEFAULT '0',
  `url_key` varchar(64) NOT NULL DEFAULT '',
  `url_action` varchar(32) NOT NULL DEFAULT '',
  `url_params` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`site_id`,`url_key`),
  KEY `action_params` (`site_id`,`url_action`,`url_params`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");