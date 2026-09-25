# Glosarium LibreOffice Indonesia (Web Statis)

Situs web statis Glosarium LibreOffice Indonesia (GLO-ID) berbasis template Jekyll Single Page Application (SPA).

## 📁 Struktur Data & Proyek

- `_data/glosarium.csv`: Pangkalan data padanan kata (`Source`, `Padanan`).
- `_data/menu.json`: Konfigurasi tautan menu navigasi desktop dan mobile.
- `_layouts/`: Layout utama Jekyll (`default.html` dan `defaults.html`).
- `assets/css/style.css`: Berkas stylesheet modern responsif.
- `assets/js/main.js`: Logika pencarian instan, filter abjad, dan perutean SPA.
- `assets/img/`: Aset gambar dan logo resmi.
- `index.html`: Halaman utama SPA.

## 🚀 Menjalankan Secara Lokal

Pastikan Anda telah memasang Jekyll dan Ruby:

```bash
jekyll serve
```

Buka `http://localhost:4000` di peramban Anda.
