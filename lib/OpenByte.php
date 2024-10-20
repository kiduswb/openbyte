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

    public static function get($userid) {
        $result = mysqlQuery("SELECT * FROM users WHERE id = ?", [$userid]);
        
        if (!$result || count($result) == 0) {
            return null;
        }

        else return new User($userid);
    }

    public static function get_id_by_email($email) {
        $result = mysqlQuery("SELECT id FROM users WHERE email = ?", [$email]);
        
        if (!$result || count($result) == 0) {
            return null;
        }

        else return $result[0]["id"];
    }

    public function update() 
    {
        $result = mysqlQuery("UPDATE users SET email = ? , pwd_hash = ? , is_verified = ? WHERE id = ?", 
        [$this->email, $this->pwd_hash, $this->is_verified, $this->id]);

        if (!$result) {
            return false;
        }

        return true;
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

        return null;
    }

    public static function generate_reset_token($userid) 
    {
        $token = '';

        // If token already exists, send that token:
        $result = mysqlQuery("SELECT * FROM reset_tokens WHERE userid = ?", [$userid]);
        if (count($result)) $token = $result[0]['token'];
        
        else {
            $token = rand(100000, 999999);
            mysqlQuery("INSERT INTO reset_tokens (userid, token) VALUES (?, ?)", [$userid, $token]);
        }

        return $token;
    }

    public static function validate_reset_token($userid, $token) {
        $result = mysqlQuery("SELECT * FROM reset_tokens WHERE userid = ? AND token = ?", [$userid, $token]);

        if (!$result || count($result) == 0) {
            return false;
        }

        return true;
    }

    public function delete_token() {
        mysqlQuery("DELETE FROM reset_tokens WHERE userid = ?", [$this->id]);
    }

    public function delete() 
    {
        $result = mysqlQuery("DELETE FROM users WHERE id = ?", [$this->id]);

        if (!$result) {
            return false;
        }

        return true;
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
            return null;
        }

        return new Site($result[0]['id']);
    }

    public function update() {
        $result = mysqlQuery("UPDATE sites SET label = ?, cpanel_password = ? WHERE id = ?", [$this->label, $this->cpanel_password, $this->id]);
        
        if (!$result) {
            return false;
        }

        return true;
    }

    public function change_cpanel_password($newpass) 
    {
        $mofhClient = new Client($_ENV['MOFH_API_USERNAME'], $_ENV['MOFH_API_PASSWORD']);

        try
        {
            $passwordChangeReq = $mofhClient->password($this->internal_id, $newpass);
            if($passwordChangeReq->isSuccessful()) 
            {
                $this->cpanel_password = $newpass;
                return $this->update();
            }
        } catch (Exception $e) {
            //!TODO: implement error logging
            return false;
        }
    }

    public static function subdomain_available($subdomain) {

        $mofhClient = new Client($_ENV['MOFH_API_USERNAME'], $_ENV['MOFH_API_PASSWORD']);

        try
        {
            $sdCheck = $mofhClient->availability($subdomain);
            if($sdCheck->isSuccessful()) return $sdCheck->isAvailable();
            return false;
        } 
        
        catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }

        // Should theoretically be redundant

        $result = mysqlQuery("SELECT * FROM sites WHERE subdomain = ?", [$subdomain]);
        if (count($result) == 0) {
            return true;
        }

        return false;
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

    public function delete() 
    {
        $mofhClient = new Client($_ENV['MOFH_API_USERNAME'], $_ENV['MOFH_API_PASSWORD']);

        try 
        {
            $suspendRes = $mofhClient->suspend($this->internal_id, "User Request");
            if($suspendRes->isSuccessful())
            {
                mysqlQuery("DELETE FROM sites WHERE id = ?", [$this->id]);
                return true;
            }

            return false;
        }

        catch (Exception $e)
        {
            error_log($e->getMessage());
            return false;
        }
    }
}