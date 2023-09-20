<?php
require_once('model/PostModel.php');
require_once('middleware/Validator.php');

class PostController
{
  public function feedback()
  {
    unset($error_feedback);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['post_id'])) {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['post_id']);
        if ($valid == 'válido') {
          $db = new PostModel;
          $db->deletePost((int) $_POST['post_id'], FALSE);
        } else {
          $error_feedback = $valid;
        }
      }
    }
    include('view/feedback.php');
  }
  public function feedbackNew()
  {
    unset($error_new_feed);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['title']) && isset($_POST['text']) && $_POST['user_id']) {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['title']);
        if ($valid == 'válido') {
          $valid = $validator->typeTest($_POST['text']);
          if ($valid == 'válido') {
            $valid = $validator->idTest($_POST['user_id']);
            if ($valid == 'válido') {
              $db = new PostModel;
              $error_new_feed = $db->newPost((int) $_POST['user_id'], $_POST['title'], $_POST['text'], FALSE);
            } else {
              $error_new_feed = $valid;
            }
          } else {
            $error_new_feed = $valid;
          }
        } else {
          $error_new_feed = $valid;
        }
      }
    }
    include('view/feedbackNew.php');
  }
  public function feedbackEdit()
  {
    unset($error_edit_feed);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['post']) || strlen($_GET['post']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['title']) && isset($_POST['text']) && $_POST['post_id']) {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['title']);
        if ($valid == 'válido') {
          $valid = $validator->typeTest($_POST['text']);
          if ($valid == 'válido') {
            $valid = $validator->idTest($_POST['post_id']);
            if ($valid == 'válido') {
              $db = new PostModel;
              $error_edit_feed = $db->editPost((int) $_POST['post_id'], $_POST['title'], $_POST['text'], FALSE);
            } else {
              $error_edit_feed = $valid;
            }
          } else {
            $error_edit_feed = $valid;
          }
        } else {
          $error_edit_feed = $valid;
        }
      }
    }
    include('view/feedbackEdit.php');
  }
  public function blog()
  {
    unset($error_blog);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['post_id'])) {
        $validator = new Validator;
        $valid = $validator->idTest($_POST['post_id']);
        if ($valid == 'válido') {
          $db = new PostModel;
          $db->deletePost((int) $_POST['post_id'], TRUE);
        } else {
          $error_blog = $valid;
        }
      }
    }
    include('view/blog.php');
  }
  public function blogNewPost()
  {
    unset($error_new_blog);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adv') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['title']) && isset($_POST['text']) && $_POST['user_id']) {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['title']);
        if ($valid == 'válido') {
          $valid = $validator->typeTest($_POST['text']);
          if ($valid == 'válido') {
            $valid = $validator->idTest($_POST['user_id']);
            if ($valid == 'válido') {
              $db = new PostModel;
              $error_new_blog = $db->newPost((int) $_POST['user_id'], $_POST['title'], $_POST['text'], TRUE);
            } else {
              $error_new_blog = $valid;
            }
          } else {
            $error_new_blog = $valid;
          }
        } else {
          $error_new_blog = $valid;
        }
      }
    }
    include('view/blogNewPost.php');
  }
  public function blogEditPost()
  {
    unset($error_edit_blog);
    if (!isset($_GET['id']) || strlen($_GET['id']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $_GET['id']) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_SESSION['user_kind']) || $_SESSION['user_kind'] != 'adv') {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if (!isset($_GET['post']) || strlen($_GET['post']) == 0) {
      header("Location: https://freyesleben.adv.br/login?logout");
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['title']) && isset($_POST['text']) && $_POST['post_id']) {
        $validator = new Validator;
        $valid = $validator->typeTest($_POST['title']);
        if ($valid == 'válido') {
          $valid = $validator->typeTest($_POST['text']);
          if ($valid == 'válido') {
            $valid = $validator->idTest($_POST['post_id']);
            if ($valid == 'válido') {
              $db = new PostModel;
              $error_edit_blog = $db->editPost((int) $_POST['post_id'], $_POST['title'], $_POST['text'], TRUE);
            } else {
              $error_edit_blog = $valid;
            }
          } else {
            $error_edit_blog = $valid;
          }
        } else {
          $error_edit_blog = $valid;
        }
      }
    }
    include('view/blogEditPost.php');
  }
}
