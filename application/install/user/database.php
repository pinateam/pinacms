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
CREATE TABLE IF NOT EXISTS `cody_address` (
  `address_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `address_title` varchar(32) NOT NULL DEFAULT '',
  `address_firstname` varchar(128) NOT NULL DEFAULT '',
  `address_lastname` varchar(128) NOT NULL DEFAULT '',
  `address_middlename` varchar(128) NOT NULL DEFAULT '',
  `address_street` varchar(255) NOT NULL DEFAULT '',
  `address_city` varchar(255) NOT NULL DEFAULT '',
  `address_county` varchar(64) NOT NULL DEFAULT '',
  `address_state_key` varchar(2) NOT NULL DEFAULT '',
  `address_country_key` varchar(2) NOT NULL DEFAULT '',
  `address_zip` varchar(32) NOT NULL DEFAULT '',
  `address_zip4` varchar(32) NOT NULL DEFAULT '',
  `address_phone` varchar(32) NOT NULL DEFAULT '',
  `address_fax` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`address_id`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `account_id` int(10) NOT NULL DEFAULT '0',
  `user_title` varchar(255) NOT NULL DEFAULT '',
  `user_login` varchar(32) NOT NULL DEFAULT '',
  `user_password` varchar(64) NOT NULL DEFAULT '',
  `user_email` varchar(64) NOT NULL DEFAULT '',
  `activation_token` varchar(32) NOT NULL DEFAULT '',
  `restore_token` varchar(32) NOT NULL DEFAULT '',
  `user_status` enum('new','active','suspensed','disabled') NOT NULL DEFAULT 'new',
  `access_group_id` int(10) NOT NULL DEFAULT '1',
  `user_gender` enum('male','female','unspecified') NOT NULL DEFAULT 'unspecified',
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `idx_username` (`user_login`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_user_config` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `register_address_id` int(10) NOT NULL DEFAULT '0',
  `shipping_address_id` int(10) NOT NULL DEFAULT '0',
  `preferred_shipping_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_user_field` (
  `user_field_key` varchar(32) NOT NULL DEFAULT '',
  `user_field_type` enum('directory','number','text','boolean') DEFAULT NULL,
  `module_key` varchar(32) NOT NULL DEFAULT '',
  `directory_key` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_field_key`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");

$db->query("
CREATE TABLE IF NOT EXISTS `cody_user_field_value` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_field_key` varchar(32) NOT NULL DEFAULT '',
  `user_field_value` varchar(255) NOT NULL DEFAULT '',
  KEY `user_id` (`user_id`,`user_field_key`)
) ENGINE=".DB_DEFAULT_ENGINE." DEFAULT CHARSET=utf8;
");