<?php

namespace classes;

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once BASE_PATH . '/lib/Db.php';

use lib\Db;
use PDOException;

class NullUser extends User
{
    public function __construct() {
        parent::__construct(0, '', '', '', '', '', 0);
    }

    public function isNull() {
        return true;
    }
}

class User
{
    protected static $db;
    protected $id;
    protected $fname;
    protected $mname;
    protected $lname;
    protected $email;
    protected $password;
    protected $role_id;

    protected function __construct(int $id, string $fname, string $mname, string $lname, string $email, string $password, int $role_id) {
        $this->id = $id;
        $this->fname = $fname;
        $this->mname = $mname;
        $this->lname = $lname;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id;
    }

    public static function findOne(string $email): self 
    {
        self::$db = (self::$db) ? self::$db : new Db;

        $user = self::$db->row('SELECT * FROM `users` WHERE `email` = :email;', ['email' => $email]);

        if ($user) {
            $user = $user[0];
            return new static($user['id'], $user['fname'], $user['mname'], $user['lname'], $user['email'], $user['password'], $user['role_id']);
        }

        return new NullUser;
    }

    public static function createUser(string $fname, string $mname, string $lname, string $email, string $password): self
    {
        self::$db = (self::$db) ? self::$db : new Db;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return new NullUser;
        if (mb_strlen($password) < 8) return new NullUser;
        
        $params = [
            'fname'    => $fname,
            'mname'    => $mname,
            'lname'    => $lname,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        try {
            self::$db->row('INSERT INTO `users` (`fname`, `mname`, `lname`, `email`, `password`) VALUES (:fname, :mname, :lname, :email, :password);', $params);
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') {
                return new NullUser;
            }
        }

        return self::findOne($email);
    }

    public function isNull() {
        return false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFname(): string
    {
        return $this->fname;
    }

    public function getMname(): string
    {
        return $this->mname;
    }

    public function getLname(): string
    {
        return $this->lname;
    }

    // В формате: ФИ(О)
    public function getFullName(): string
    {
        return ($this->mname === '') ? $this->lname . ' ' . $this->fname : $this->lname . ' ' . $this->fname . ' ' . $this->mname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleId(): int {
        return $this->role_id;
    }
}