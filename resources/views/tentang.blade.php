
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Tentang Kami</title>

    <style>
      body {
        font-family: system-ui, -apple-system, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
      }
      h1 {
        color: #4f46e5;
      }
        .love {
            margin-top: 20px;
            font-size: 24px;
            color: rgb(255, 0, 238);
            text-shadow: 0 0 10px rgb(255, 0, 238);
            animation: fadeIn 2s ease-in-out infinite alternate;
            
        }
    </style>
  </head>
  <body>
    <h1>Tentang Toko Online</h1>
    <p>Selamat datang di toko online kami.</p>
    <p class="love"><i>Dibuat dengan sepenuh hati saya yang paling dalam <br> ❤️ <br>menggunakan Laravel.</i></p>

    <p>Waktu saat ini: {{ now()->format('d M Y, H:i:s') }}</p>

    <a href="/">← Kembali ke Home</a>
     
  </body>
</html>