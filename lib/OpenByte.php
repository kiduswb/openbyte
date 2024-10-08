<?php 

// OpenByte.php
// Core classes and functions for the OpenByte platform

require_once 'vendor/autoload.php';
require_once 'Database.php';

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
            $this->cpanel_username = $result[0]['cpanel_username'];
            $this->cpanel_password = $result[0]['cpanel_password'];
            $this->timestamp = $result[0]['timestamp'];
        }
    }

    public static function create($userid, $label, $subdomain, $cpanel_username, $cpanel_password) {
        //...
    }

    public static function subdomain_check($subdomain) {
        //...
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