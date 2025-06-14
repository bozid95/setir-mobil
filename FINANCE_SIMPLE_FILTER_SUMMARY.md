# 💰 FINANCE SIMPLE FILTER & SUMMARY

## ✅ FITUR YANG DITAMBAHKAN

### **1. Date Range Filter**

-   **Filter berdasarkan rentang tanggal**
-   Input: Date From dan Date Until
-   Otomatis filter data sesuai range tanggal yang dipilih

### **2. Payment Type Filter**

-   **Filter berdasarkan jenis pembayaran:**
    -   Tuition Fee (Biaya Kursus)
    -   Registration Fee (Biaya Pendaftaran)
    -   Material Fee (Biaya Materi)
    -   Exam Fee (Biaya Ujian)

### **3. Total Amount Summary**

-   **Kolom Amount dengan Summarizer**
-   Menampilkan **total jumlah uang** di bagian bawah tabel
-   Otomatis update sesuai filter yang aktif
-   Format: Rupiah (IDR)

## 🎯 CARA MENGGUNAKAN

### **Filter berdasarkan Tanggal:**

```
1. Klik "Filters" di atas tabel
2. Pilih "Date From" - tanggal mulai
3. Pilih "Date Until" - tanggal akhir
4. Tabel akan otomatis filter sesuai range tanggal
5. Total di bawah tabel akan update otomatis
```

### **Filter berdasarkan Jenis Pembayaran:**

```
1. Klik "Filters" di atas tabel
2. Pilih "Payment Type"
3. Pilih jenis pembayaran (bisa multiple):
   - Tuition Fee
   - Registration Fee
   - Material Fee
   - Exam Fee
4. Total akan update sesuai jenis yang dipilih
```

### **Kombinasi Filter:**

```
1. Bisa kombinasi Date Range + Payment Type
2. Contoh:
   - Date: 1 Juni - 30 Juni 2025
   - Type: Tuition Fee
   - Hasil: Semua pembayaran tuition di bulan Juni
   - Total: Jumlah uang tuition bulan Juni
```

## 📊 TAMPILAN SUMMARY

### **Total Amount Summarizer:**

-   Muncul di bagian bawah kolom Amount
-   Format: **Rp 25,500,000** (contoh)
-   Label: **"Total"**
-   Otomatis calculate berdasarkan data yang terfilter

### **Contoh Penggunaan:**

#### **Scenario 1: Revenue Bulanan**

```
Filter:
- Date From: 1 Juni 2025
- Date Until: 30 Juni 2025
- Payment Type: All

Hasil: Total revenue bulan Juni
```

#### **Scenario 2: Tuition Fee Analysis**

```
Filter:
- Date From: 1 Januari 2025
- Date Until: 31 Desember 2025
- Payment Type: Tuition Fee

Hasil: Total tuition fee setahun
```

#### **Scenario 3: Weekly Report**

```
Filter:
- Date From: 10 Juni 2025
- Date Until: 16 Juni 2025
- Payment Type: All

Hasil: Total revenue minggu ini
```

## 🔧 TECHNICAL IMPLEMENTATION

### **Date Range Filter:**

```php
Filter::make('date_range')
    ->form([
        Forms\Components\DatePicker::make('date_from')->label('Date From'),
        Forms\Components\DatePicker::make('date_until')->label('Date Until'),
    ])
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when($data['date_from'], fn($q, $date) => $q->whereDate('date', '>=', $date))
            ->when($data['date_until'], fn($q, $date) => $q->whereDate('date', '<=', $date));
    })
```

### **Amount Summarizer:**

```php
Tables\Columns\TextColumn::make('amount')
    ->summarize([
        Tables\Columns\Summarizers\Sum::make()
            ->money('IDR')
            ->label('Total'),
    ])
```

## ✅ BENEFITS

### **For Finance Team:**

-   **Quick Date Analysis** - Filter range tanggal dengan mudah
-   **Payment Type Insights** - Analisis per jenis pembayaran
-   **Real-time Total** - Lihat total amount langsung
-   **Simple Interface** - Interface yang sederhana dan user-friendly

### **For Management:**

-   **Period Analysis** - Analisis revenue per periode
-   **Type Breakdown** - Breakdown revenue per jenis pembayaran
-   **Quick Reports** - Generate laporan cepat dengan filter
-   **Data Accuracy** - Total yang akurat sesuai filter

---

**Status:** SIMPLE & COMPLETE ✅  
**Date Range Filter:** Working ✅  
**Payment Type Filter:** Working ✅  
**Total Amount Summary:** Real-time Calculation ✅  
**User Interface:** Simple & Easy to Use ✅

**File Location:** `app/Filament/Resources/FinanceResource.php`  
**Last Updated:** June 14, 2025
