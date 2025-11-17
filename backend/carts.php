<?php
include "books.php";
function create_cart($connection, $id)
{
   $sql  = "INSERT INTO carts (user_id, created_at, status, total)
            VALUES (?, ?, ?, ?)";
   $statement = $connection->prepare($sql);
   $statement->execute([$id, date('Y-m-d H:i:s'), 'empty', 0]);
   if ($statement->rowCount() > 0)
      return $statement->fetch();
}

function delete_cart($connection, $id) {}

function get_cart($connection, $id)
{
   $sql  = "SELECT * FROM carts WHERE user_id=?";
   $statement = $connection->prepare($sql);
   $statement->execute([$id]);
   if ($statement->rowCount() > 0)
      $cart = $statement->fetch();
   return $cart;
}

function insert_item($connection, $id, $book_id)
{
   $cart = get_cart($connection, $id);
   $book = get_book($connection, $book_id);
   $check = "SELECT * FROM cart_items WHERE cart_id = ? AND book_id = ?";
   $stmt = $connection->prepare($check);
   $stmt->execute([$cart["cart_id"], $book_id]);
   if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch();
      $row['qty'] += 1;
      $update = "UPDATE cart_items SET qty = ? WHERE cart_item_id = ?";
      $stmt2 = $connection->prepare($update);
      $stmt2->execute([$row['qty'], $row['cart_item_id']]);
      $res = $stmt2->fetch();
   } else {
      $insert = "INSERT INTO cart_items (cart_id, book_id, qty,price) VALUES (?, ?, ? ,?)";
      $stmt3 = $connection->prepare($insert);
      $stmt3->execute([$cart["cart_id"], $book_id, 1, $book['price']]);
      $res = $stmt3->fetch();
   }
   return $res;
}

function get_cart_items($connection, $id)
{
   $cart = get_cart($connection, $id);
   if ($cart) {
      $sql  = 'SELECT * FROM cart_items WHERE cart_id=?';
      $statement = $connection->prepare($sql);
      $statement->execute([$cart['cart_id']]);
      if ($statement->rowCount() > 0)
         return $statement->fetchAll();
   }
}


function set_cart_total_checkout($connection, $id)
{
   $items = get_cart_items($connection, $id);
   if ($items) {
      $total = 0;
      foreach ($items as $key => $value) {
         $total += $items[$key]['qty'] * $items[$key]["price"];
      }
      return  $total;
   }
   return 0;
}

function remove_item($connection, $id)
{
   $sql  = "SELECT * FROM cart_items WHERE book_id=?";
   $statement = $connection->prepare($sql);
   $statement->execute([$id]);
   if ($statement->rowCount() > 0) {
      $sql2  = "DELETE FROM cart_items WHERE book_id=?";
      $statement2 = $connection->prepare($sql2);
      $statement2->execute([$id]);
      $res = $statement->fetch();
   }
   return $res;
}
