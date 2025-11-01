<?php
//check if user is logged in
session_start();
if (!isset($_SESSION["user_id"])) {
    echo get_page_content("/login");
    exit;
    // redirecting without reloading the page
    //echo '<script>window.location.href = "/login"; </script>';
   // exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Basic HTML Page</title>
  <style>
    :root{--brand:#0b74de;--bg:#f9f9f9;--text:#222}
    html,body{height:100%}
    body{font-family:system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; margin:0; color:var(--text); background:var(--bg); line-height:1.5}
    .container{max-width:900px;margin:0 auto;padding:1rem}
    header{background:var(--brand);color:#fff}
    header .container{display:flex;align-items:center;justify-content:space-between}
    nav a{color:rgba(255,255,255,0.95);text-decoration:none;margin-left:0.75rem}
    main{padding:2rem 0}
    footer{padding:1rem 0;background:#fff;border-top:1px solid #e6e6e6}
    .btn{display:inline-block;padding:0.5rem 0.85rem;background:var(--brand);color:#fff;border-radius:6px;text-decoration:none;border:none;cursor:pointer}
    .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap;border:0}
  </style>
</head>
<body>
  <header>
    <div class="container">
      <h1 style="margin:0;font-size:1.25rem">Basic HTML Page</h1>
      <nav aria-label="Main navigation">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <p>This is a minimal, accessible HTML starter page. Use it as a base for new pages or prototypes.</p>

      <button id="greet" class="btn">Say hello</button>

      <section aria-labelledby="example-heading" style="margin-top:1.5rem">
        <h2 id="example-heading">Example content</h2>
        <p>Small demo showing a button that triggers a JavaScript action. Keep HTML semantic and simple.</p>
      </section>
    </div>
  </main>

  <footer>
    <div class="container">
      <small>&copy; 2025 Your Name — Built with a minimal HTML template</small>
    </div>
  </footer>

  <script>
    // Very small, unobtrusive JS — keeps page functional without JS too
    document.getElementById('greet').addEventListener('click', function () {
      window.alert('Hello — this is a basic HTML page!');
    });
  </script>
</body>
</html>