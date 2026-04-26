# Use Case Diagram (Markdown)

Dokumen ini memetakan use case utama sistem berdasarkan implementasi route web dan API saat ini.

## Aktor

- Pengunjung (Guest)
- Member
- Coach
- Admin
- System Scheduler/Queue
- WhatsApp Gateway

## Diagram (Mermaid)

```mermaid
flowchart LR
    G[Pengunjung]
    M[Member]
    C[Coach]
    A[Admin]
    S[System Scheduler/Queue]
    W[WhatsApp Gateway]

    subgraph U[Club Panahan Management System]
        UC01((Registrasi Akun))
        UC02((Login/Logout))
        UC03((Lihat Konten Public))
        UC04((Kelola Profil dan Password))

        UC05((Registrasi Member Diri/Anak))
        UC06((Lihat Dashboard Member))

        UC07((Kelola Sesi Latihan))
        UC08((Kelola Kehadiran per Sesi))

        UC09((Validasi Member Pending))
        UC10((Kelola Master Data))
        UC11((Kelola Konten Website))
        UC12((Kelola Paket Member))
        UC13((Kelola WhatsApp Blast dan Log))
        UC14((Kelola Konfigurasi WhatsApp dan Reminder))
        UC15((Export Laporan))

        UC16((Kirim Reminder Expiry Paket Otomatis))
        UC17((Proses Broadcast via Queue))
    end

    G --> UC01
    G --> UC02
    G --> UC03

    M --> UC02
    M --> UC04
    M --> UC05
    M --> UC06

    C --> UC02
    C --> UC04
    C --> UC07
    C --> UC08

    A --> UC02
    A --> UC04
    A --> UC09
    A --> UC10
    A --> UC11
    A --> UC12
    A --> UC07
    A --> UC08
    A --> UC13
    A --> UC14
    A --> UC15

    S --> UC16
    S --> UC17

    UC13 --> W
    UC16 --> W
    UC17 --> W
```

## Relasi Use Case Penting

- UC06 Lihat Dashboard Member bergantung pada data UC12 Kelola Paket Member dan UC08 Kelola Kehadiran per Sesi.
- UC13 Kelola WhatsApp Blast dan Log memicu UC17 Proses Broadcast via Queue.
- UC14 Kelola Konfigurasi WhatsApp dan Reminder mempengaruhi perilaku UC16 Kirim Reminder Expiry Paket Otomatis.
- UC08 Kelola Kehadiran per Sesi hanya bisa dilakukan jika UC07 Kelola Sesi Latihan sudah tersedia.
