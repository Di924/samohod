<?php

namespace classes;

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once BASE_PATH . '/lib/Db.php';

use lib\Db; 

class DBquery
{
    //переменные
    public $conn;
    //функции
    public function __construct(){
        $this->conn = (new Db())->db;
    }

    public function getProducts(){
        $query = 'SELECT * FROM `products`';
        $rows = $this->conn->query($query);
        return $rows;
    }

    public function inBasketProducts($product_id){
        $query = "INSERT INTO `baskets`(`user_id`, `product_id`, `count`) VALUES ( :user_id, :product_id, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":user_id", $_SESSION['user']['id']);
        $stmt->bindValue(":product_id", $product_id);
        $affectedRowsNumber = $stmt->execute();
        return $affectedRowsNumber;
    }
    // 
    // BASKET
    // 

    public function getBasket(){
        $query = 'SELECT `baskets`.`id`, products.id AS pid, products.photo, products.title, products.description, products.price, `baskets`.`count` FROM `baskets` 
        LEFT JOIN products ON products.id = baskets.product_id
        WHERE `baskets`.`user_id` = :user_id AND `baskets`.order IS NULL';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":user_id", $_SESSION['user']['id']);
        $stmt->execute();
        $arr = [];
        foreach ($stmt as $row) {
            $arr[] = $row;
        }
        return $arr;
    }
    
    public function countBasket($count, $id){
        $query = 'UPDATE `baskets` SET `count`= :count WHERE `id`=:id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":count", $count);
        $stmt->bindValue(":id", $id);
        $affectedRowsNumber = $stmt->execute();
        return $affectedRowsNumber;
    }
    
    public function deleteBasket( $id){
        $query = 'DELETE FROM `baskets` WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        $affectedRowsNumber = $stmt->execute();
        return $affectedRowsNumber;
    }
    
    public function getCountBasket(){
        $query = 'SELECT COUNT(`baskets`.`id`) AS c FROM `baskets` 
        LEFT JOIN products ON products.id = baskets.product_id
        WHERE `baskets`.`user_id` = :user_id AND `baskets`.order IS NULL';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":user_id", $_SESSION['user']['id']);
        $stmt->execute();
        $arr = [];
        foreach ($stmt as $row) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function newOrder(){   
        $COUNT = $this->getCountBasket();
        foreach ($COUNT as $row):
            if ($row['c'] != 0) {                
                $i = 1;
                //создание нового заказа
                $query = 'INSERT INTO `orders`(`user_id`) VALUES (:id)';
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(":id", $_SESSION['user']['id']);
                $stmt->execute();
                //получение его ид
                $query = 'SELECT MAX(`id`) FROM `orders` WHERE `user_id` = ?';
                $stmt = $this->conn->prepare($query);
                $stmt->execute($id = array($_SESSION['user']['id']));
                
                foreach ($stmt as $row) {   
                //добавление всех товаров из корзины в заказ
                $query = 'UPDATE `baskets` SET `order`= :orderId
                WHERE `baskets`.`user_id` = :id AND `baskets`.order IS NULL';
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(":orderId", $row[0]);
                $stmt->bindValue(":id", $_SESSION['user']['id']);
                $stmt->execute();
                }
            }
        endforeach;
    }
    // 
    // ORDERS
    // 

    public function getOrders(){
        $i = 1;
        $orders = [];
        // список номеров заказов
        $query = 'SELECT `id` FROM `orders` WHERE `user_id`= ? ORDER BY id DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute($id = array($_SESSION['user']['id']));
        $id=0;
        foreach ($stmt as $row) {
            $orders[$id] = $row[0];
            $id = $id + 1;
        }
        return $orders;
    }
    
    public function getOrderList($order){
        $i = 1;
        $groupsOrders = [];
        $query2 = 'SELECT products.id,  products.title, products.description, products.photo FROM `baskets` 
                    LEFT JOIN products ON products.id = baskets.product_id
                    WHERE baskets.order = :order_id AND baskets.user_id= :user_id';
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindValue(":order_id", $order);
        $stmt2->bindValue(":user_id", ($_SESSION['user']['id']));
        $stmt2->execute();
        $id=0;
        foreach ($stmt2 as $key) {
            $groupsOrders += [$id => array("id" => $key["id"], "title" => $key["title"], "description" => $key["description"], "photo" => $key["photo"])];
            $id+=1;
        }        
        return $groupsOrders;
    }
}
?>