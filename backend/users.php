<?php
function list_users($connection)
{
   $sql  = "SELECT * FROM users";
   $statement = $connection->prepare($sql);
   $statement->execute();
   $users = $statement->rowCount() > 0 ? $statement->fetchAll() : 0;
   return $users;
}

function seve_user($connection, $user)
{
   $sql  = "INSERT INTO users (full_name, email, phone,password,role)
            VALUES (?, ?, ? , ?, ?)";
   $statement = $connection->prepare($sql);
   $statement->execute([$user["full_name"], $user["email"], $user["phone"], $user["password"], $user["role"]]);
   return $statement->fetch();
}

function get_user($connection, $email)
{
   $sql  = "SELECT * FROM users WHERE email=?";
   $statement = $connection->prepare($sql);
   $statement->execute([$email]);
   $user = $statement->rowCount() > 0 ? $statement->fetch() : null;
   return $user;
}
