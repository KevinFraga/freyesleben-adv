<?php
require_once('model/database.php');

class PostModel
{
  public function newPost(int $author_id, string $title, string $text, bool $is_blog)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');

    $sql = $is_blog ? "INSERT INTO DeeDee (user_id, title, text) VALUES (?, ?, ?);" : "INSERT INTO JohnnyBravo (user_id, title, text) VALUES (?, ?, ?);";
    $query = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($query,'iss', $author_id, $title, $text);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Post criado com sucesso';
  }
  public function editPost(int $post_id, string $title, string $text, bool $is_blog)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);
    $connect->set_charset('utf8');
    
    $sql = $is_blog ? "UPDATE DeeDee SET title = ?, text = ? WHERE id = ?;" : "UPDATE JohnnyBravo SET title = ?, text = ? WHERE id = ?;";
    $query = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($query,'ssi', $title, $text, $post_id);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_close($query);
    mysqli_close($connect);
    return 'Post editado com sucesso';
  }
  public function deletePost(int $post_id, bool $is_blog)
  {
    global $dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D;
    $connect = mysqli_connect($dbHost_D, $dbUser_D, $dbPassword_D, $dbName_D);

    $sql = $is_blog ? "DELETE FROM DeeDee WHERE id = ?;" : "DELETE FROM JohnnyBravo WHERE id = ?;";
    $query = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($query, 'i', $post_id);
    mysqli_stmt_execute($query);
    
    mysqli_stmt_close($query);
    mysqli_close($connect);
  }
}
