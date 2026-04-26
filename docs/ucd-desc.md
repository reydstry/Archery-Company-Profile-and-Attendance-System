# Use Case Description

Dokumen ini berisi deskripsi use case utama untuk modul yang aktif di sistem.

## UC-01 Registrasi Akun

- Aktor: Pengunjung
- Tujuan: Membuat akun baru dengan role default member.
- Prasyarat: Email belum terdaftar.
- Trigger: Pengunjung mengisi form registrasi.
- Alur Normal:
1. Sistem menerima data nama, email, password, dan phone.
2. Sistem memvalidasi format data dan keunikan email.
3. Sistem membuat akun user baru.
4. Sistem mengembalikan token autentikasi.
- Alur Alternatif:
1. Jika validasi gagal, sistem mengembalikan error 422.
- Postkondisi: Akun user tersimpan dan siap login.

## UC-02 Login/Logout

- Aktor: Pengunjung, Member, Coach, Admin
- Tujuan: Masuk ke sistem dan mengakhiri sesi secara aman.
- Prasyarat: Akun aktif tersedia.
- Trigger: User mengirim kredensial login atau aksi logout.
- Alur Normal:
1. Sistem memvalidasi email dan password.
2. Sistem membuat token akses baru dan menonaktifkan token lama sesuai kebijakan.
3. User mengakses fitur sesuai role.
4. Saat logout, token aktif dihapus.
- Alur Alternatif:
1. Jika kredensial salah, sistem mengembalikan error validasi.
- Postkondisi: User terautentikasi atau sesi berhasil diakhiri.

## UC-03 Lihat Konten Public

- Aktor: Pengunjung
- Tujuan: Melihat informasi publik klub.
- Prasyarat: Konten dipublikasikan.
- Trigger: Pengunjung membuka halaman/endpoint publik.
- Alur Normal:
1. Sistem menampilkan daftar berita, prestasi, galeri, dan paket.
2. Sistem menampilkan detail konten saat dipilih.
- Alur Alternatif:
1. Jika item belum publish, sistem mengembalikan not found.
- Postkondisi: Pengunjung mendapatkan informasi publik terbaru.

## UC-04 Kelola Profil dan Password

- Aktor: Member, Coach, Admin
- Tujuan: Melihat profil dan mengganti password akun.
- Prasyarat: User sudah login.
- Trigger: User membuka menu profil atau ubah password.
- Alur Normal:
1. Sistem menampilkan profil user saat ini.
2. User mengirim password lama dan password baru.
3. Sistem memvalidasi password lama.
4. Sistem memperbarui password dan mencabut token lama.
- Alur Alternatif:
1. Jika password lama salah, sistem menolak perubahan.
- Postkondisi: Profil tetap sinkron dan keamanan akun meningkat.

## UC-05 Registrasi Member Diri/Anak

- Aktor: Member
- Tujuan: Mendaftarkan profil member untuk diri sendiri atau anak.
- Prasyarat: User role member sudah login.
- Trigger: User mengirim form register self atau register child.
- Alur Normal:
1. User memilih tipe pendaftaran self atau child.
2. Sistem memvalidasi data member.
3. Sistem menyimpan data member dengan status pending.
4. Sistem menampilkan daftar member milik user.
- Alur Alternatif:
1. Jika register child dilakukan sebelum self tersedia, sistem menolak.
2. Jika duplikasi register self, sistem menolak.
- Postkondisi: Data member tercatat dan menunggu validasi admin.

## UC-06 Lihat Dashboard Member

- Aktor: Member
- Tujuan: Melihat status member, kuota paket, riwayat kehadiran, dan prestasi.
- Prasyarat: User memiliki profil member.
- Trigger: User membuka dashboard member.
- Alur Normal:
1. Sistem memuat data member aktif.
2. Sistem menghitung kuota total, terpakai, dan sisa sesi.
3. Sistem menampilkan riwayat attendance dan statistik hadir/absen.
4. Sistem menampilkan daftar prestasi terkait.
- Alur Alternatif:
1. Jika profil member belum ada, sistem mengembalikan not found.
- Postkondisi: Member mengetahui status latihan dan progres.

## UC-07 Kelola Sesi Latihan

- Aktor: Admin, Coach
- Tujuan: Membuat, mengubah, membuka/menutup/membatalkan sesi latihan.
- Prasyarat: User sesuai role dan sudah login.
- Trigger: User menjalankan aksi manajemen sesi.
- Alur Normal:
1. User membuat sesi latihan berdasarkan tanggal.
2. User mengatur slot sesi dan kuota peserta.
3. User menugaskan coach ke slot sesi.
4. User memperbarui status sesi menjadi open, closed, atau canceled.
- Alur Alternatif:
1. Jika data bentrok atau tidak valid, sistem menolak perubahan.
- Postkondisi: Data sesi siap digunakan untuk absensi.

## UC-08 Kelola Kehadiran per Sesi

- Aktor: Admin, Coach
- Tujuan: Mencatat dan sinkronisasi kehadiran member pada sesi.
- Prasyarat: Sesi latihan tersedia.
- Trigger: User membuka input attendance per sesi.
- Alur Normal:
1. Sistem menampilkan daftar member aktif yang eligible.
2. User mengirim data attendance per sesi.
3. Sistem menyimpan daftar attendance dan mencegah duplikasi pasangan session-member.
4. Sistem memperbarui data yang tampil pada dashboard member.
- Alur Alternatif:
1. Jika sesi tidak valid, sistem menolak input.
- Postkondisi: Attendance tersimpan sebagai sumber data kuota dan laporan.

## UC-09 Validasi Member Pending

- Aktor: Admin
- Tujuan: Meninjau dan mengaktifkan member yang baru daftar.
- Prasyarat: Ada data member status pending.
- Trigger: Admin membuka daftar pending member.
- Alur Normal:
1. Sistem menampilkan daftar member pending.
2. Admin meninjau data member.
3. Admin mengubah status atau aktivasi sesuai kebijakan.
- Alur Alternatif:
1. Jika data tidak ditemukan, sistem mengembalikan error.
- Postkondisi: Member tervalidasi dan dapat diproses ke tahap paket/latihan.

## UC-10 Kelola Master Data

- Aktor: Admin
- Tujuan: Mengelola data inti sistem.
- Ruang Lingkup: Paket, coach, member, session time.
- Prasyarat: Admin sudah login.
- Trigger: Admin membuka modul master data.
- Alur Normal:
1. Admin membuat, melihat, memperbarui, atau menonaktifkan data.
2. Sistem memvalidasi integritas relasi antar data.
- Alur Alternatif:
1. Jika data terikat relasi yang membatasi delete, sistem menolak aksi.
- Postkondisi: Master data selalu siap dipakai modul operasional.

## UC-11 Kelola Konten Website

- Aktor: Admin
- Tujuan: Mengelola news, achievements, dan galleries.
- Prasyarat: Admin sudah login.
- Trigger: Admin mengakses modul konten.
- Alur Normal:
1. Admin melakukan CRUD konten.
2. Sistem menyimpan tanggal publish dan metadata konten.
3. Konten valid ditampilkan ke kanal publik.
- Alur Alternatif:
1. Jika validasi konten gagal, sistem mengembalikan error.
- Postkondisi: Konten website terbarui sesuai kebutuhan promosi klub.

## UC-12 Kelola Paket Member

- Aktor: Admin
- Tujuan: Menetapkan paket latihan ke member dan memantau periodenya.
- Prasyarat: Member dan paket tersedia.
- Trigger: Admin menjalankan assign package.
- Alur Normal:
1. Admin memilih member dan paket.
2. Sistem menghitung total sesi, tanggal mulai, dan tanggal akhir.
3. Sistem menyimpan package assignment dan status aktif.
4. Sistem dapat menampilkan daftar package per member.
- Alur Alternatif:
1. Jika member tidak valid, sistem menolak assignment.
- Postkondisi: Member memiliki kuota latihan terdefinisi.

## UC-13 Kelola WhatsApp Blast dan Log

- Aktor: Admin
- Tujuan: Mengirim pesan massal dan memantau hasil pengiriman.
- Prasyarat: Konfigurasi gateway tersedia.
- Trigger: Admin membuat blast message.
- Alur Normal:
1. Admin menentukan target penerima dan isi pesan.
2. Sistem membuat data broadcast dan broadcast logs berstatus pending.
3. Sistem melempar pekerjaan ke queue.
4. Sistem menampilkan log sukses/gagal dan rekap total.
5. Admin dapat export log per periode.
- Alur Alternatif:
1. Jika koneksi gateway gagal, status log menjadi failed.
- Postkondisi: Riwayat komunikasi terdokumentasi.

## UC-14 Kelola Konfigurasi WhatsApp dan Reminder

- Aktor: Admin
- Tujuan: Mengatur driver WhatsApp, kredensial, dan reminder expiry.
- Prasyarat: Admin sudah login.
- Trigger: Admin membuka settings WhatsApp/reminder.
- Alur Normal:
1. Admin mengubah pengaturan API dan driver.
2. Sistem menyimpan setting pada storage konfigurasi.
3. Admin melakukan test connection.
4. Admin mengatur enable reminder dan parameter hari pengingat.
- Alur Alternatif:
1. Jika tes koneksi gagal, sistem menampilkan detail error.
- Postkondisi: Integrasi WhatsApp siap untuk blast dan reminder otomatis.

## UC-15 Export Laporan

- Aktor: Admin
- Tujuan: Mengunduh laporan operasional dalam format Excel.
- Prasyarat: Data attendance tersedia.
- Trigger: Admin memilih parameter periode laporan.
- Alur Normal:
1. Admin memilih jenis laporan (weekly/monthly).
2. Sistem membangun dataset summary dan rekap member.
3. Sistem menghasilkan file Excel untuk diunduh.
- Alur Alternatif:
1. Jika parameter tanggal tidak valid, sistem menolak request.
- Postkondisi: File laporan berhasil diunduh.

## UC-16 Kirim Reminder Expiry Paket Otomatis

- Aktor: System Scheduler/Queue
- Tujuan: Mengirim pengingat paket yang akan habis sebelum jatuh tempo.
- Prasyarat: Scheduler aktif dan reminder di-enable.
- Trigger: Job terjadwal harian berjalan.
- Alur Normal:
1. Scheduler menjalankan command reminder.
2. Sistem mengambil daftar member yang mendekati tanggal berakhir paket.
3. Sistem mengirim pesan reminder lewat abstraksi WhatsApp service.
4. Sistem menyimpan log hasil pengiriman.
- Alur Alternatif:
1. Jika reminder dinonaktifkan, proses berhenti tanpa kirim pesan.
- Postkondisi: Member mendapatkan pengingat tepat waktu.

## UC-17 Proses Broadcast via Queue

- Aktor: System Scheduler/Queue, WhatsApp Gateway
- Tujuan: Mengeksekusi pengiriman broadcast secara asynchronous.
- Prasyarat: Data broadcast pending tersedia.
- Trigger: Job queue diproses worker.
- Alur Normal:
1. Worker mengambil job broadcast dari queue.
2. Sistem memproses daftar penerima satu per satu.
3. Gateway mengembalikan status sukses/gagal per nomor.
4. Sistem memperbarui broadcast logs dan rekap total.
5. Sistem menandai broadcast completed.
- Alur Alternatif:
1. Jika exception terjadi per penerima, log penerima ditandai failed.
- Postkondisi: Broadcast selesai diproses dan dapat diaudit dari log.
