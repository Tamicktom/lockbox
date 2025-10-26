<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($appName ?? 'Lockbox', ENT_QUOTES, 'UTF-8') ?></title>
  <style>
    :root {
      color-scheme: light dark;
    }

    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial, "Apple Color Emoji", "Segoe UI Emoji";
      margin: 0;
      padding: 2rem;
    }

    .container {
      max-width: 720px;
      margin: 0 auto;
    }

    .card {
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 1.5rem;
    }

    h1 {
      margin-top: 0;
    }

    .muted {
      opacity: .7;
    }

    a {
      color: inherit;
    }

    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
      }
    }
  </style>
  <script>
    /* no js */
  </script>
</head>

<body>
  <div class="container">
    <div class="card">
      <h1><?= htmlspecialchars($appName ?? 'Lockbox', ENT_QUOTES, 'UTF-8') ?></h1>
      <p>Bem-vindo! PHP <?= htmlspecialchars($phpVersion ?? '', ENT_QUOTES, 'UTF-8') ?> está rodando.</p>
      <p class="muted">Estrutura: Composer, Router, Controllers, Views, Config, Helpers.</p>
    </div>
  </div>
</body>

</html>