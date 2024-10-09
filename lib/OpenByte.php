<?php 

// OpenByte.php
// Core classes and functions for the OpenByte platform

require_once 'vendor/autoload.php';
require_once 'Database.php';

use \InfinityFree\MofhClient\Client;

class User 
{
    public $id;
    public $email;
    public $pwd_hash;
    public $is_verified;
    public $timestamp;

    public function __construct($id = "")
    {
        if ($id != "") 
        {
            $result = mysqlQuery("SELECT * FROM users WHERE id = ?", [$id]);
            if (!$result || count($result) == 0) {
                return 0;
            }

            $this->id = $result[0]['id'];
            $this->email = $result[0]['email'];
            $this->pwd_hash = $result[0]['pwd_hash'];
            $this->is_verified = $result[0]['is_verified'];
            $this->timestamp = $result[0]['timestamp'];
        }
    }

    public static function login($email, $password) {
        $result = mysqlQuery("SELECT * FROM users WHERE email = ?", [$email]);
        if (!$result || count($result) == 0) {
            return 0;
        }

        $user = $result[0];
        if (!password_verify($password, $user['pwd_hash'])) {
            return 0;
        }

        return $user;
    }

    public static function check_email_exists($email) {
        $result = mysqlQuery("SELECT * FROM users WHERE email = ?", [$email]);
        if (!$result || count($result) == 0) {
            return false;
        }

        return true;
    }

    public static function register($email, $password) {
        $id = Ramsey\Uuid\Uuid::uuid4()->toString();
        $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
        $timestamp = time();
        $result = mysqlQuery("INSERT INTO users (id, email, pwd_hash, is_verified, timestamp) VALUES (?, ?, ?, ?, ?)", [$id, $email, $pwd_hash, 0, $timestamp]);
        
        if ($result !== false) {
            return $id;
        }

        return '';
    }
}

class Site
{
    public $id;
    public $userid;
    public $label;
    public $subdomain;
    public $internal_id;
    public $cpanel_username;
    public $cpanel_password;
    public $timestamp;
    

    public function __construct($id = "")
    {
        if ($id != "") {
            $result = mysqlQuery("SELECT * FROM sites WHERE id = ?", [$id]);
            if (!$result || count($result) == 0) {
                return 0;
            }

            $this->id = $result[0]['id'];
            $this->userid = $result[0]['userid'];
            $this->label = $result[0]['label'];
            $this->subdomain = $result[0]['subdomain'];
            $this->internal_id = $result[0]['internal_id'];
            $this->cpanel_username = $result[0]['cpanel_username'];
            $this->cpanel_password = $result[0]['cpanel_password'];
            $this->timestamp = $result[0]['timestamp'];
        }
    }

    public static function create($userid, $label, $subdomain, $internal_id, $cpanel_password) 
    {
        $mofhClient = new Client($_ENV['MOFH_API_USERNAME'], $_ENV['MOFH_API_PASSWORD']);
        $user = new User($userid);
        $site = new Site();
        $site->id = Ramsey\Uuid\Uuid::uuid4()->toString();
        $site->userid = $userid;
        $site->label = $label;
        $site->subdomain = $subdomain;
        $site->internal_id = $internal_id;
        $site->cpanel_password = $cpanel_password;

        try 
        {
            $createResponse = $mofhClient->createAccount (
                $internal_id, 
                $cpanel_password,
                $user->email,
                $subdomain,
                'openbyte'
            );
        }

        catch (Exception $e) {
            echo '<p class="text-danger">Failed to create account: ' . $e->getMessage() . '</p>';
            return '';
        }

        if($createResponse->isSuccessful()) {
            $cpanel_username = $createResponse->getVpUsername();
            mysqlQuery("INSERT INTO sites (id, userid, label, subdomain, internal_id, cpanel_username, cpanel_password, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
            [$site->id, $site->userid, $site->label, $site->subdomain, $site->internal_id, $cpanel_username, $site->cpanel_password, time()]);
            return $site;
        } else {
            //!TODO: Implement logging here
            echo '<p class="text-danger">Failed to create account: ' . $createResponse->getMessage() . '</p>';
            return '';
        }
    }

    public static function get($siteid) {
        $result = mysqlQuery("SELECT * FROM sites WHERE id = ?", [$siteid]);
        if (!$result || count($result) == 0) {
            return '';
        }

        return new Site($result[0]['id']);
    }

    public static function subdomain_check($subdomain) {
        $result = mysqlQuery("SELECT * FROM sites WHERE subdomain = ?", [$subdomain]);
        if (!$result || count($result) == 0) {
            return false;
        }

        return true;
    }

    public static function get_user_sites($userid) {
        $result = mysqlQuery("SELECT * FROM sites WHERE userid = ?", [$userid]);
        $sites = [];

        if (!$result || count($result) == 0) {
            return $sites;
        }

        foreach ($result as $site) {
            $sites[] = new Site($site['id']);
        }

        return $sites;
    }

    public static function delete($siteid) {
        //...
    }
}