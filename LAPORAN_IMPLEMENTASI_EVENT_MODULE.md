# Laporan Implementasi Module Event Management
## Pertemuan 5 - Validation, File Upload, dan Delete Mechanism

---

## 1. RINGKASAN KEGIATAN

Telah berhasil mengimplementasikan fitur lengkap Event Management pada aplikasi AmikomEventHub dengan fitur-fitur berikut:
- ✅ Create Event dengan Upload Gambar (Poster)
- ✅ Validasi Input (Client-side dan Server-side)
- ✅ Mekanisme Hapus Event beserta File Gambar di Storage
- ✅ Edit Event dengan Update Gambar
- ✅ Testing Validasi Harga Negatif

---

## 2. KODE YANG DITERAPKAN

### 2.1 EventController - Store Method (Validasi min:0)
```php
public function store(Request $request)
{
    // Menerapkan validasi data request dari pengguna
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',  // ← VALIDASI HARGA MINIMUM 0
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('poster')) {
        $data['poster_path'] = $request->file('poster')->store('posters', 'public');
    }

    \App\Models\Event::create($data);
    return redirect()->route('admin.events.index')->with('success', 'Data Event berhasil ditambahkan.');
}
```

### 2.2 EventController - Update Method (Update dengan Validasi)
```php
public function update(Request $request, Event $event)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',  // ← VALIDASI HARGA MINIMUM 0
        'stock' => 'required|numeric|min:1',
        'poster' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('poster')) {
        // Hapus gambar lama jika sebelumnya sudah memiliki poster
        if ($event->poster_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
        }
        // Upload gambar baru
        $data['poster_path'] = $request->file('poster')->store('posters', 'public');
    }

    $event->update($data);
    return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
}
```

### 2.3 EventController - Destroy Method (Hapus Event & File)
```php
/**
 * Remove the specified resource from storage.
 */
public function destroy(Event $event)
{
    // Hapus file gambar dari storage jika ada
    if ($event->poster_path) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
    }
    
    $event->delete();
    return redirect()->route('admin.events.index')->with('success', 'Data event berhasil dihapus secara permanen.');
}
```

---

## 3. HASIL TESTING

### 3.1 Test 1: Upload Event dengan Gambar ✅

**Data Event yang Diinput:**
- Judul Event: **Web Developer Summit 2026**
- Kategori: **Seminar IT**
- Deskripsi: Summit tahunan untuk para developer web profesional dan pelajar. Dapatkan insights terbaru tentang teknologi web modern, networking opportunities, dan showcase proyek terbaik Anda.
- Tanggal & Waktu: **15 Juli 2026, 09:00 AM**
- Lokasi: **Gedung Konferensi Amikom, Yogyakarta**
- Harga: **Rp 350.000**
- Kapasitas (Stok): **150 Tiket**
- Poster: **concert.png** (dari public/assets/)

**Hasil:**
- ✅ Event berhasil ditambahkan ke database
- ✅ Gambar berhasil diupload ke folder: `/storage/app/public/posters/`
- ✅ Filename gambar di-generate otomatis: `ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg`
- ✅ Event muncul di tabel Kelola Event dengan gambar thumbnail

**Database Record (ID 10):**
```
[id] => 10
[category_id] => 1
[title] => Web Developer Summit 2026
[description] => Summit tahunan untuk para developer web...
[date] => 2026-07-15T09:00:00.000000Z
[location] => Gedung Konferensi Amikom, Yogyakarta
[price] => 350000
[stock] => 150
[poster_path] => posters/ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg
[created_at] => 2026-06-10T07:31:04.000000Z
[updated_at] => 2026-06-10T07:31:04.000000Z
```

---

### 3.2 Test 2: Validasi Harga Negatif ✅

**Skenario:**
1. Membuka form edit event (Web Developer Summit 2026)
2. Mengubah nilai Harga dari Rp 350.000 menjadi **-5**
3. Mencoba submit form dengan harga negatif

**Hasil Validasi:**
```
ERROR MESSAGE: "Value must be greater than or equal to 0."
```

**Penjelasan:**
Validasi bekerja pada **dua level**:

1. **Client-Side Validation (HTML5 Input min Attribute):**
   - Browser menampilkan error message saat user mencoba input angka negatif
   - Input type="number" dengan `min="0"` attribute mencegah pengiriman form jika nilai < 0
   - User-friendly: memberikan feedback langsung tanpa perlu submit

2. **Server-Side Validation (Laravel Rule - min:0):**
   - Bahkan jika user bypass client-side validation (via dev tools), Laravel tetap memvalidasi
   - Rule `'price' => 'required|numeric|min:0'` menolak nilai negatif
   - Mengembalikan error dengan pesan validasi yang jelas
   - Data tidak akan tersimpan ke database

**Keamanan:**
- Validasi client-side: UX yang baik
- Validasi server-side: keamanan (defense in depth)
- Kombinasi keduanya: robust dan user-friendly

---

### 3.3 Test 3: Mekanisme Hapus Event & File Gambar ✅

**Skenario:**
1. Buka halaman Kelola Event
2. Klik tombol Delete (trash icon) pada event "Web Developer Summit 2026"
3. Konfirmasi penghapusan
4. Verifikasi file gambar terhapus dari storage

**Sebelum Hapus - File di Storage:**
```
Folder: storage/app/public/posters/
- 8q3GLnamHoWJADWxhWcblw5XrzpeGe0bVSU388Qk.jpg
- ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg  ← Web Developer Summit
- RTBncY1pX0aDcZDx27Z6YYu5s8hKiq7wXyGpLfFx.png
```

**Setelah Hapus - File di Storage:**
```
Folder: storage/app/public/posters/
- 8q3GLnamHoWJADWxhWcblw5XrzpeGe0bVSU388Qk.jpg
- RTBncY1pX0aDcZDx27Z6YYu5s8hKiq7wXyGpLfFx.png
```

**Hasil:**
- ✅ Event berhasil dihapus dari database
- ✅ File `ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg` **otomatis terhapus** dari storage
- ✅ Success message: "Data event berhasil dihapus secara permanen."
- ✅ Tidak ada file sampah tertinggal di server

**Implementasi:**
Destroy method di EventController menjalankan:
```php
// Hapus file gambar dari storage jika ada
if ($event->poster_path) {
    \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster_path);
}
// Hapus data event dari database
$event->delete();
```

---

## 4. TEKNOLOGI & TOOLS YANG DIGUNAKAN

| Aspek | Tool/Framework |
|-------|---|
| Backend Framework | Laravel 11.4.0 |
| Database | MySQL / MariaDB |
| File Storage | Laravel Storage Disk (public) |
| Form Validation | Laravel Validator + HTML5 |
| Web Server | Apache (Laragon) |
| Bahasa Pemrograman | PHP 8.3.28 |
| Frontend | Blade Template + Tailwind CSS |

---

## 5. STRUKTUR FOLDER STORAGE

```
storage/
├── app/
│   ├── public/
│   │   └── posters/
│   │       ├── ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg
│   │       ├── RTBncY1pX0aDcZDx27Z6YYu5s8hKiq7wXyGpLfFx.png
│   │       └── ... (file lainnya)
│   └── ...
└── ...
```

**Link Public:**
```
URL: http://127.0.0.1:8000/storage/posters/ORD5cEWLnKZVja9NRipI46SaGEhbNSCYkqctE41H.jpg
Path: public/storage → storage/app/public
```

---

## 6. FITUR-FITUR YANG TELAH DIIMPLEMENTASIKAN

### Create Event (POST)
- [x] Form validation (client & server)
- [x] File upload dengan random filename
- [x] Store ke database
- [x] Store gambar ke storage
- [x] Success redirect dengan message

### Read Event (GET)
- [x] Tampil daftar event di tabel
- [x] Pagination (10 per halaman)
- [x] Thumbnail gambar
- [x] Event detail dengan relasi kategori

### Update Event (PUT)
- [x] Form pre-fill data lama
- [x] Validasi input
- [x] Update database
- [x] Opsi replace gambar (hapus lama, upload baru)
- [x] Preserve gambar jika tidak di-update

### Delete Event (DELETE)
- [x] Konfirmasi penghapusan
- [x] Hapus file gambar dari storage
- [x] Hapus data dari database
- [x] Redirect dengan success message

---

## 7. VALIDASI DATA

| Field | Rules | Keterangan |
|-------|-------|-----------|
| category_id | required\|exists:categories,id | Kategori harus ada di tabel |
| title | required\|string\|max:255 | Judul wajib diisi, max 255 char |
| description | required\|string | Deskripsi wajib diisi |
| date | required\|date | Tanggal harus format date |
| location | required\|string\|max:255 | Lokasi wajib, max 255 char |
| price | **required\|numeric\|min:0** | ← **Tidak boleh negatif** |
| stock | required\|numeric\|min:1 | Stok minimum 1 |
| poster | nullable\|image\|max:2048 | Opsional, max 2MB |

---

## 8. KESIMPULAN

Implementasi Event Management Module telah **berhasil** dengan semua requirement:

1. ✅ **Instruksi Modul Diterapkan**: Semua rule validasi dan file handling sesuai dengan kode modul
2. ✅ **Server Berjalan**: Apache + Laravel serve berjalan normal
3. ✅ **Upload File Berhasil**: Gambar terupload dan ter-generate nama random
4. ✅ **Validasi Harga Bekerja**: Input -5 ditolak dengan pesan error yang jelas
5. ✅ **Hapus File Otomatis**: Saat event dihapus, file gambar juga ikut terhapus

**Penjelasan Validasi Harga Negatif:**

Ketika user mencoba memasukkan harga negatif (contoh: -5), sistem memiliki 2 layer proteksi:

- **Layer 1 (Client)**: Browser menampilkan error "Value must be greater than or equal to 0" karena HTML input min="0"
- **Layer 2 (Server)**: Jika somehow user bypass layer 1, Laravel validator akan menolak dengan rule `min:0`
- **Hasil**: Proses penyimpanan ditolak, data tidak masuk database, user mendapat feedback error

Ini adalah **best practice** untuk keamanan dan UX yang baik.

---

## 9. SCREENSHOT BUKTI

Lihat lampiran screenshot folder untuk bukti visual dari:
- Form create event
- Event berhasil ditambahkan di tabel
- Form edit dengan harga -5
- Error message validasi
- Success message setelah hapus
- File di storage sebelum dan sesudah hapus

---

**Tanggal:** 10 Juni 2026  
**Pembuat:** Admin AmikomEventHub  
**Status:** ✅ COMPLETE
