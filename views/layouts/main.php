<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengaduan Sarana Sekolah</title>
    <link rel="stylesheet" href="/ukk_bintang_26/public/css/style.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-[#4455DD] shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center text-[#4455DD] font-bold text-[10px] text-center leading-tight">
                    LOGO<br>SEKOLAH
                </div>
                <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center text-[#4455DD] font-bold text-[10px] text-center leading-tight">
                    LOGO<br>PEMDA
                </div>
            </div>
            <div class="flex items-center gap-6">
                <a href="/ukk_bintang_26/" class="text-white hover:text-[#FFDD44] transition text-sm font-medium">Beranda</a>
                <a href="/ukk_bintang_26/aspirasi" class="text-white hover:text-[#FFDD44] transition text-sm font-medium">Sampaikan Aspirasi</a>
                <a href="/ukk_bintang_26/histori" class="text-white hover:text-[#FFDD44] transition text-sm font-medium">Histori Aspirasi</a>
            </div>
        </div>
    </nav>
    <main>
        <?= $content ?>
    </main>
</body>
</html>