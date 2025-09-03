# Form Design Utility Classes

Panduan lengkap untuk menggunakan utility classes CSS yang konsisten untuk semua form di sistem.

## 🎨 **Gaya Desain**

### **Prinsip Desain**
- **Clean & Compact**: Desain bersih dengan ukuran kompak
- **Consistent Rounding**: Menggunakan `rounded-xl` untuk card, `rounded-lg` untuk tombol, `rounded-md` untuk form elements
- **Subtle Shadows**: Shadow yang halus untuk kedalaman visual
- **Responsive**: Otomatis menyesuaikan pada perangkat mobile

## 📦 **Utility Classes**

### **Form Cards**
```html
<!-- Card dengan header -->
<div class="form-card">
    <div class="form-card-header">
        <h2 class="text-sm font-semibold text-white flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            Judul Card
        </h2>
    </div>
    <div class="form-card-body">
        <!-- Konten form -->
    </div>
</div>
```

### **Form Elements**
```html
<!-- Input Text -->
<div class="form-group">
    <label for="nama" class="form-label">Nama Lengkap</label>
    <input type="text" id="nama" class="form-input" placeholder="Masukkan nama">
</div>

<!-- Select Dropdown -->
<div class="form-group">
    <label for="status" class="form-label-flex">
        <i class="fas fa-circle mr-1 text-green-500"></i>
        Status
    </label>
    <select id="status" class="form-select">
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
    </select>
</div>

<!-- Textarea -->
<div class="form-group">
    <label for="alamat" class="form-label">Alamat</label>
    <textarea id="alamat" class="form-textarea" rows="2" placeholder="Masukkan alamat"></textarea>
</div>
```

### **Grid Layouts**
```html
<!-- 2 Kolom -->
<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label">Kolom 1</label>
        <input type="text" class="form-input">
    </div>
    <div class="form-group">
        <label class="form-label">Kolom 2</label>
        <input type="text" class="form-input">
    </div>
</div>

<!-- 3 Kolom -->
<div class="form-grid-3">
    <div class="form-group">
        <label class="form-label">Kolom 1</label>
        <input type="text" class="form-input">
    </div>
    <div class="form-group">
        <label class="form-label">Kolom 2</label>
        <input type="text" class="form-input">
    </div>
    <div class="form-group">
        <label class="form-label">Kolom 3</label>
        <input type="text" class="form-input">
    </div>
</div>
```

### **Buttons**
```html
<!-- Primary Button -->
<button type="submit" class="btn-primary">
    <i class="fas fa-save mr-1"></i>
    Simpan
</button>

<!-- Secondary Button -->
<button type="button" class="btn-secondary">
    <i class="fas fa-times mr-1"></i>
    Batal
</button>

<!-- Small Button -->
<button type="button" class="btn-small">
    <i class="fas fa-plus mr-1"></i>
    Tambah
</button>
```

### **Info Boxes**
```html
<!-- Success Message -->
<div class="info-box info-box-success">
    <i class="fas fa-check-circle mr-1"></i>
    Data berhasil disimpan
</div>

<!-- Error Message -->
<div class="info-box info-box-error">
    <i class="fas fa-exclamation-circle mr-1"></i>
    Terjadi kesalahan
</div>

<!-- Info Message -->
<div class="info-box info-box-info">
    <i class="fas fa-info-circle mr-1"></i>
    Informasi penting
</div>
```

### **Error Messages**
```html
@error('field_name')
    <div class="form-error">
        <i class="fas fa-exclamation-circle mr-1"></i>
        {{ $message }}
    </div>
@enderror
```

## 🎯 **Contoh Lengkap Form**

```html
<div class="form-card">
    <div class="form-card-header">
        <h2 class="text-sm font-semibold text-white flex items-center">
            <i class="fas fa-user mr-2"></i>
            Maklumat Pengguna
        </h2>
    </div>

    <div class="form-card-body">
        <div class="form-grid-2">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" class="form-input" placeholder="Masukkan nama lengkap">
                @error('nama')
                    <div class="form-error">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-input" placeholder="email@example.com">
                @error('email')
                    <div class="form-error">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" class="form-textarea" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
            @error('alamat')
                <div class="form-error">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-end">
            <a href="#" class="btn-secondary">
                <i class="fas fa-times mr-1"></i>
                Batal
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-1"></i>
                Simpan
            </button>
        </div>
    </div>
</div>
```

## 📱 **Responsive Design**

Classes ini secara otomatis responsive:
- **Desktop**: Layout penuh dengan grid
- **Tablet**: Grid menyesuaikan menjadi 2 kolom
- **Mobile**: Grid menjadi 1 kolom, padding dikurangi

## 🎨 **Kustomisasi**

### **Mengubah Warna**
```css
/* Override warna card header */
.form-card-header {
    background: linear-gradient(to right, #10b981, #059669); /* green-500 to green-700 */
}

/* Override warna button */
.btn-primary {
    background: #10b981; /* green-500 */
}
.btn-primary:hover {
    background: #059669; /* green-700 */
}
```

### **Mengubah Ukuran**
```css
/* Lebih compact */
.form-card-body {
    padding: 0.5rem; /* p-2 */
}

/* Lebih besar */
.form-input, .form-select, .form-textarea {
    padding: 0.5rem 0.75rem; /* px-3 py-2 */
}
```

## 🚀 **Keuntungan Menggunakan Utility Classes**

1. **Konsistensi**: Semua form memiliki tampilan yang sama
2. **Maintenance**: Mudah mengubah desain di satu tempat
3. **Performance**: CSS yang optimal dan ter-cache
4. **Responsive**: Otomatis menyesuaikan di semua perangkat
5. **Accessibility**: Focus states dan transitions yang smooth

## 📋 **Checklist Implementasi**

- [ ] Gunakan `form-card` untuk container utama
- [ ] Gunakan `form-card-header` dan `form-card-body` untuk struktur
- [ ] Gunakan `form-group` untuk setiap field group
- [ ] Gunakan `form-label` atau `form-label-flex` untuk label
- [ ] Gunakan `form-input`, `form-select`, `form-textarea` untuk input
- [ ] Gunakan `form-grid-2` atau `form-grid-3` untuk layout
- [ ] Gunakan `btn-primary`, `btn-secondary` untuk tombol
- [ ] Gunakan `info-box-*` untuk pesan informasi
- [ ] Gunakan `form-error` untuk error messages

---

**Catatan**: Utility classes ini dirancang untuk memberikan konsistensi maksimal sambil tetap fleksibel untuk kustomisasi sesuai kebutuhan spesifik form tertentu.