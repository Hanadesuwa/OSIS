<?php
//use kreait/firebase-php
require __DIR__ . '../data/vendor/autoload.php';
use Kreait\Firebase\Factory;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_ajax = isset($_GET['content_only']);

// This function holds the routing logic
function get_page_content($path_)
{
  // Whitelist your pages for security
  $page_file = match ($path_) {
    '/page1' => '../data/page1.php',
    '/' => '../data/home.php',
    default => '../data/404.php' // (You should create a 404.php)
  };
  // Check if file exists before including
  if (file_exists($page_file)) {
    // ob_start/ob_get_clean lets us "capture" the include
    // instead of just printing it.
    ob_start();
    include $page_file;
    return ob_get_clean();
  } else {
    return "<h1>Error 404</h1><p>Page not found.</p>";
  }
}


// --- Request Handling ---

// If it's an AJAX request, send *only* the content and stop.
if ($is_ajax) {
  echo get_page_content($path);
  exit; // Stop the script
}
if (isset($_GET["page"])) {
  
    $response = array();
    $response["code"] = 0x80;
    $response["title"] = "Otlov - Login page";
    $lg = get_page_content($path);
    $response["content"] = $lg;
    echo json_encode($response);
    exit;
  
}

if (isset($_POST["login"])) {
  try {
    session_start();
    header("Content-Type: application/json");
    $time = time();
    if (isset($_SESSION["post_login"])) {
      if (is_integer($_SESSION["post_login"])) {
        if ($time < $_SESSION["post_login"]) {
          $status["code"] = 0x5;
          $status["msg"] = "Please wait 10 seconds after trying to log in.";
          echo json_encode($status);
          exit();
        }
      } else {
        $_SESSION["post_login"] = $time + 10;
        $status["code"] = 0x4;
        $status["msg"] = "Something went wrong";
        echo json_encode($status);
        exit();
      }
    }

    $_SESSION["post_login"] = $time + 10;
    $factory = (new Factory())
      ->withServiceAccount("../data/.private/private/serviceAccountKey.json")
      ->WithDatabaseUri(
        "https://t-ui-af1c8-default-rtdb.asia-southeast1.firebasedatabase.app/"
      );
    $database = $factory->createDatabase();
    $status = [];
    $password = $_POST["password"];
    $key = "account/$_POST[clientid]";
    $key2 = "account/$_POST[clientid]/key";
    $client = $database->getReference($key);
    if (!$client->getSnapshot()->exists()) {
      $status["code"] = 0x1;
      echo json_encode($status);
      exit();
    }
    $clientVal = $client->getSnapshot()->getValue();
    if ($password != $clientVal["pass"]) {
      $status["code"] = 0x2;
      echo json_encode($status);
      exit();
    }
    $client2 = $database->getReference($key2);
    $auth = $factory->createAuth();
    if (isset($_SESSION["user_id"]) && isset($_SESSION["key"]) && $_SESSION["key"] !== "") {
      if ($client2->getSnapshot()->exists() && $clientVal["key"] !== "" && $clientVal["key"] == $_SESSION["key"] && $password == $clientVal["pass"] && $client->getSnapshot()->exists()) {
        try {
          $signInResult = $auth->signInWithEmailAndPassword($_SESSION["user_email"], $password);
          $user = $signInResult->data();
          $uid = $user["localId"];
          if ($_SESSION["user_id"] == $uid) {
            $status["code"] = 0x0;
            $status["msg"] = "You have already logged in before";
            echo json_encode($status);
            exit();
          } else {
            $status["code"] = 0x8;
            $status["msg"] = "Invalid User Information";
            echo json_encode($status);
            header("Location: index.php#login");
            exit();
          }
        } catch (Exception $e) {
          $status["code"] = 0x4;
          $status["msg"] = "You have to log in again";
          echo json_encode($status);
          exit();
        }
      }
    }
    if ($client2->getSnapshot()->exists() && $clientVal["key"] !== "") {
      $status["code"] = 0x3;
      $status["msg"] = "Sorry, but your account is already in used. we'll send you link to reset your account key. Learn more account key: https://www.otlov.my.id/about-account-key";
      echo json_encode($status);
      exit();
    }

    $email = $clientVal["email"];
    try {
      $signInResult = $auth->signInWithEmailAndPassword($email, $password);
    } catch (Exception $e) {
      $status["code"] = 0x4;
      $status["msg"] = "Sorry, we cant make you log in into your account";
      echo json_encode($status);
      exit();
    }
    // Get the user's UID
    $user = $signInResult->data();
    $uid = $user["localId"];
    $_SESSION["user_id"] = $uid;
    $_SESSION["user_email"] = $user["email"];
    $_SESSION["password"] = $password;
    $_SESSION["clientid"] = $_POST["clientid"];

    $_SESSION["key"] = bin2hex(random_bytes('64'));
    $client2->set($_SESSION["key"]);
    $status["code"] = 0x0;
    $status["msg"] = "Success log in! enjoy!";
    echo json_encode($status);
    exit();
  } catch (Exception $e) {
    $status["code"] = 0x7;
    $status["msg"] = "Sorry, we cant make you log in into your account";
    echo json_encode($status);
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Otlov LLC</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      background-color: #f0f2f5;
      /* Slightly different iOS-like background */
    }

    .ios-header {
      background-color: rgba(248, 248, 248, 0.50);
      backdrop-filter: blur(12px) saturate(180%);
      -webkit-backdrop-filter: blur(12px) saturate(180%);
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .novel-item-card {
      cursor: pointer;
      transition: transform 0.2s ease-out, box-shadow 0.2s ease-out;
    }

    .novel-item-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .novel-item-card img {
      aspect-ratio: 16 / 9;
      /* More of a banner/featured look for cards */
      object-fit: cover;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Modal Styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.6);
      /* Darker overlay */
      backdrop-filter: blur(4px);
      /* Blur background content */
      -webkit-backdrop-filter: blur(4px);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      z-index: 1000;
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-content {
      background-color: rgba(255, 255, 255, 0.80);
      /*rgba(249,249,249,1);*/
      /* iOS modal background */
      border-radius: 14px;
      /* iOS modal border radius */
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      width: 90%;
      max-width: 420px;
      /* Typical width for iOS modals */
      max-height: 90vh;
      overflow-y: auto;
      transform: scale(0.95) translateY(20px);
      opacity: 0;
      transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.3s ease;
      position: relative;
      /* For close button positioning */
    }

    .modal-overlay.active .modal-content {
      transform: scale(1) translateY(0);
      opacity: 1;
    }

    .modal-close-button {
      position: absolute;
      top: 12px;
      right: 12px;
      background-color: rgba(0, 0, 0, 0.3);
      color: white;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.2s ease;
      z-index: 10;
      /* Ensure it's above the image */
    }

    .modal-close-button:hover {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .loginbtn {
      background-color: #007aff;
      /* iOS blue */
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 9999px;
      /* Pill shape */
      transition: background-color 0.2s ease;
      text-align: center;
      display: inline-block;
    }

    .ios-get-button {
      background-color: #007aff;
      /* iOS blue */
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 9999px;
      /* Pill shape */
      transition: background-color 0.2s ease;
      text-align: center;
      display: inline-block;
    }

    .loginbtn:hover {
      background-color: #005ecb;
    }

    /* Hide scrollbar when modal is open */
    body.modal-open {
      overflow: hidden;
    }

    /* Custom scrollbar for modal content (optional) */
    .modal-content::-webkit-scrollbar {
      width: 5px;
    }

    .modal-content::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 3px;
    }

    .modal-content::-webkit-scrollbar-track {
      background: transparent;
    }

    @font-face {
      /* If you have a custom font */
      font-family: 'MyCustomFont';
      src: url('fonts/YourCustomFont.otf') format('opentype');
      /* Make sure this path is correct */
    }

    /* Uncomment and adjust if using a custom font */
    /*
        body {
            font-family: 'MyCustomFont', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }
        */
  </style>
</head>

<body class="text-gray-800">
  <header class="ios-header sticky top-0 z-50 w-full">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Otlov</h1>
      </div>
    </div>
  </header>
  <div id="content">

  </div>
  <footer class="text-center p-6 text-gray-500 text-xs">
    &copy; 2025 Otlov Games
  </footer>

  <script>
    $(document).ready(function () {
      const contentArea = $('#content');
      const router = () => {
        const path = location.hash.substring(1) || 'home';
        contentArea.html(`${path}`);
        loadContent(path);
      };
      const loadContent = (page) => {
        contentArea.html('<div class="text-center text-gray-500">Loading...</div>');

        $.ajax({
          url: `?page=${page}`,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            // Update the page content and title
            $(document).prop('title', data.title);
            contentArea.html(`${data.content}`);

          },
          error: function (jqXHR, textStatus, errorThrown) {
            /*console.error('Failed to load content:', textStatus, errorThrown);*/
            const errorMessage = `Page not found (${jqXHR.status})`;
            contentArea.html(`<div id="app-content"><h1 class="text-4xl font-bold text-red-600">Error</h1><p class="text-lg text-gray-600">${errorMessage}. Please try again.</p></div>`);
            $(document).prop('title', 'Error');
          }
        });
      };
      $(window).on('hashchange', router);
      router();
    });
  </script>
</body>

</html>