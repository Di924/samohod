<?php

namespace classes;

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once BASE_PATH . '/lib/Db.php';

use lib\Db;

class NullProduct extends Product
{
    public function __construct() {
        parent::__construct(0, '', '', 0, '', 0);
    }

    public function isNull(): bool 
    {
        return true;
    }
}

class Product
{
    protected static $db;
    protected $id;
    protected $title;
    protected $description;
    protected $price;
    protected $photo;
    protected $count;

    protected function __construct(int $id, string $title, ?string $description, int $price, ?string $photo, int $count) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->photo = $photo;
        $this->count = $count;
    }

    public function isNull(): bool
    {
        return false;
    }

    public static function findOne(int $id): self
    {
        self::$db = (self::$db) ? self::$db : new Db;
        
        $product = self::$db->row('SELECT * FROM `products` WHERE `id` = :id;', ['id' => $id]);
        
        if ($product) {
            $product = $product[0];
            return new static($product['id'], $product['title'], $product['description'], $product['price'], $product['photo'], $product['count']);
        }

        return new NullProduct;
    }

    public static function insert(string $title, ?string $description, int $price, ?string $photo, int $count): self
    {
        self::$db = (self::$db) ? self::$db : new Db;
        
        $params = [
            'title'       => $title,
            'description' => $description,
            'price'       => $price,
            'photo'       => $photo,
            'count'       => $count,
        ];
        
        self::$db->row('INSERT INTO `products` (`title`, `description`, `price`, `photo`, `count`) VALUES (:title, :description, :price, :photo, :count);', $params);

        return self::findOne(self::$db->db->lastInsertId());
    }

    public static function findAll(): array
    {
        self::$db = (self::$db) ? self::$db : new Db;

        $products = self::$db->row('SELECT * FROM `products` ORDER BY id DESC;');

        $array = [];

        foreach ($products as $value) {
            $array[] = new static($value['id'], $value['title'], $value['description'], $value['price'], $value['photo'], $value['count']);
        }

        return $array;
    }

    // Должен быть метод не 'row'
    public function update(?string $title, ?string $description, ?int $price, ?string $photo, ?int $count): self
    {
        $params = [
            'id'          => $this->id,
            'title'       => $title,
            'description' => $description,
            'price'       => $price,
            'photo'       => $photo,
            'count'       => $count,
        ];

        self::$db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`), `description` = COALESCE(:description, `description`), `price` = COALESCE(:price, `price`), `photo` = COALESCE(:photo, `photo`), `count` = COALESCE(:count, `count`) WHERE `id` = :id;', $params);

        return self::findOne($this->id);
    }

    // return возвращает не всегда верный результат
    // Должен быть метод не 'query'
    public function delete(): bool
    {
        $result = self::$db->query('DELETE FROM `products` WHERE `id` = :id;', ['id' => $this->id]);

        return ($result) ? true : false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    // public function setTitle($value): bool
    // {
    //     Product::$db->db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`) WHERE `id` = :id;', ['title' => $value]);
    // }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    // public function setDescription($value): bool
    // {
    //     Product::$db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`) WHERE `id` = :id;', ['title' => $value]);
    // }

    public function getPrice(): int
    {
        return $this->price;
    }

    // public function setPrice($value): bool
    // {
    //     Product::$db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`) WHERE `id` = :id;', ['title' => $value]);
    // }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    // public function setPhoto($value): bool
    // {
    //     Product::$db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`) WHERE `id` = :id;', ['title' => $value]);
    // }

    public function getCount(): int
    {
        return $this->count;
    }

    // public function setCount($value): bool
    // {
    //     Product::$db->query('UPDATE `products` SET `title` = COALESCE(:title, `title`) WHERE `id` = :id;', ['title' => $value]);
    // }
}
