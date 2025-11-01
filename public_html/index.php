<?php
//use kreait/firebase-php
require '../data/vendor/autoload.php';
use Kreait\Firebase\Factory;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_ajax = isset($_GET['content_only']);

// This function holds the routing logic
function get_page_content($path_)
{
  // Whitelist your pages for security

  $page_file = match ($path_) {
    '/page1' => '../data/page1.php',
    '/home' => '../data/.private/private/home.php',
    '/' => '../data/.private/private/home.php',
    '/login' => '../data/.private/private/login.php',
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
    //return the stylish erro
    return "<div id=\"app-content\"><h1 class=\"text-4xl font-bold text-red-600\">Error</h1><p class=\"text-lg text-gray-600\"> $path_ Page not found. Please try again.</p></div>";
    //return "<h1>Error 404</h1><p>Page not found.</p>";
  }
}
if ($is_ajax) {
  $response = array();
  $response["code"] = 0x80;
  $response["title"] = "Otlov - Login page";
  $lg = get_page_content($path);
  $response["content"] = $lg;
  echo $lg;
  exit;
}
/*function show_page($path_){
  //this code will make container for the page content and JavaScript for it to load the content
  // if the page is not yet loaded it shows loading text and when it's ready replace the content
  echo "<div id=\"app-content\" class=\"min-h-screen flex items-center justify-center\">
          <div class=\"text-center text-gray-500\">Loading...</div>
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var content = " . json_encode(get_page_content($path_)) . ";
            document.getElementById('app-content').innerHTML = content;
          });
        </script>";
}

*/
// --- Request Handling ---

// If it's an AJAX request, send *only* the content and stop.
/*if ($is_ajax) {
  echo get_page_content($path);
  exit; // Stop the script
}*/


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
    <?php //echo get_page_content($path); ?>

  </div>
  <footer class="text-center p-6 text-gray-500 text-xs">
    &copy; 2025 Otlov Games
  </footer>
  <script>
    $(document).ready(function () {
      const contentArea = $('#content');

      // Load content for a given page via AJAX
      const loadContent = (page) => {
        $.ajax({
          url: `/${page}?content_only`,
          type: 'GET',
          dataType: 'text',
          success: function (data) {
            // Update the page content
            contentArea.html(data);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            const errorMessage = `Page not found (${jqXHR.status})`;
            contentArea.html(`<div id="app-content"><h1 class="text-4xl font-bold text-red-600">Error</h1><p class="text-lg text-gray-600">${errorMessage}. Please try again.</p></div>`);
            $(document).prop('title', 'Error');
          }
        });
      };

      // Simple hash-based router
      const router = () => {
        const path = location.hash.substring(1) || 'home';
        loadContent(path);
      };

      $(window).on('hashchange', router);
      router();
    });
  </script>
</body>

</html>