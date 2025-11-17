<?php
function get_book($connection, $id)
{
   $sql  = "SELECT * FROM books WHERE book_id=?";
   $statement = $connection->prepare($sql);
   $statement->execute([$id]);
   if ($statement->rowCount() > 0) 
   	  $book = $statement->fetch();
   return $book;
}

function search_books($connection, $key)
{
   # for a partial match search 
   $key = "%{$key}%";
   $sql  = "SELECT * FROM books 
            WHERE title LIKE ?
            OR description LIKE ?
            OR category LIKE ?
            OR author LIKE ?";
   $statement = $connection->prepare($sql);
   $statement->execute([$key, $key, $key, $key]);
   if ($statement->rowCount() > 0) 
      return $statement->fetchAll();
   
}

function insert_book($connection, $book)
{
   $sql  = "INSERT INTO books (title,author,description,category,price,cover)
                         VALUES (?,?,?,?,?,?)";
   $statement = $connection->prepare($sql);
   $book  = $statement->execute([$book['title'], $book['author'], $book['description'], $book['category'], 
               $book['price'], $book['cover']]);
   return $book;
}
function update_book($connection, $book){
   $sql = "UPDATE books SET title=?, author=?, description=?, category=?, cover=?,
                            price=? WHERE book_id=?";
	$stmt = $connection->prepare($sql);
	$res  = $stmt->execute([$book["title"], $book["author"], $book["description"], $book["category"],
               $book["cover"], $book["price"], $book["book_id"]]);
   return $res;
}

function list_books($connection)
{
   $sql  = "SELECT * FROM books ORDER bY book_id DESC";
   $statement = $connection->prepare($sql);
   $statement->execute();
   
   if ($statement->rowCount() > 0) {
   	  $books = $statement->fetchAll();
      }
   return $books;
}

?>