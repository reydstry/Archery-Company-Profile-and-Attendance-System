# Entity Relationship Diagram (Markdown)

Dokumen ini menggambarkan struktur database aktif berdasarkan migration terbaru.

## ERD (Mermaid)

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string role
        string email UK
        string phone
        timestamp email_verified_at
        string password
        timestamp created_at
        timestamp updated_at
    }

    SOCIAL_ACCOUNTS {
        bigint id PK
        bigint user_id FK
        string provider
        string provider_user_id
        string email
        timestamp created_at
        timestamp updated_at
    }

    PASSWORD_RESET_TOKENS {
        string email PK
        string token
        timestamp created_at
    }

    PERSONAL_ACCESS_TOKENS {
        bigint id PK
        string tokenable_type
        bigint tokenable_id
        text name
        string token UK
        text abilities
        timestamp last_used_at
        timestamp expires_at
        timestamp created_at
        timestamp updated_at
    }

    SESSIONS {
        string id PK
        bigint user_id FK
        string ip_address
        text user_agent
        longtext payload
        int last_activity
    }

    MEMBERS {
        bigint id PK
        bigint user_id FK
        bigint registered_by FK
        string name
        string phone
        bool is_self
        bool is_active
        string status
        timestamp created_at
        timestamp updated_at
    }

    COACHES {
        bigint id PK
        bigint user_id FK
        string name
        string phone
        timestamp created_at
        timestamp updated_at
    }

    PACKAGES {
        bigint id PK
        string name
        text description
        decimal price
        int duration_days
        int session_count
        bool is_active
        timestamp created_at
        timestamp updated_at
    }

    MEMBER_PACKAGES {
        bigint id PK
        bigint member_id FK UK
        bigint package_id FK
        int total_sessions
        int used_sessions
        date start_date
        date end_date
        bool is_active
        bigint validated_by FK
        datetime validated_at
        timestamp created_at
        timestamp updated_at
    }

    SESSION_TIMES {
        bigint id PK
        string name
        time start_time
        time end_time
        bool is_active
        timestamp created_at
        timestamp updated_at
    }

    TRAINING_SESSIONS {
        bigint id PK
        date date
        string status
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }

    TRAINING_SESSION_SLOTS {
        bigint id PK
        bigint training_session_id FK
        bigint session_time_id FK
        int max_participants
        timestamp created_at
        timestamp updated_at
    }

    TRAINING_SESSION_SLOT_COACH {
        bigint id PK
        bigint training_session_slot_id FK
        bigint coach_id FK
        timestamp created_at
        timestamp updated_at
    }

    ATTENDANCES {
        bigint id PK
        bigint session_id FK
        bigint member_id FK
        timestamp created_at
        timestamp updated_at
    }

    NEWS {
        bigint id PK
        string photo_path
        string title
        text content
        date publish_date
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }

    ACHIEVEMENTS {
        bigint id PK
        string type
        bigint member_id FK
        string title
        text description
        date date
        string photo_path
        timestamp created_at
        timestamp updated_at
    }

    GALLERIES {
        bigint id PK
        string title
        text description
        string photo_path
        string category
        bool is_active
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }

    JOBS {
        bigint id PK
        string queue
        longtext payload
        int attempts
        int reserved_at
        int available_at
        int created_at
    }

    USERS ||--o{ SOCIAL_ACCOUNTS : has
    USERS ||--o{ MEMBERS : owns_profile
    USERS ||--o{ MEMBERS : registers_member
    USERS ||--o{ COACHES : has_coach_profile
    USERS ||--o{ MEMBER_PACKAGES : validates
    USERS ||--o{ TRAINING_SESSIONS : creates
    USERS ||--o{ SESSIONS : has
    USERS ||--o{ NEWS : posts
    USERS ||--o{ GALLERIES : uploads

    MEMBERS ||--o| MEMBER_PACKAGES : has_active_package
    PACKAGES ||--o{ MEMBER_PACKAGES : assigned_to

    TRAINING_SESSIONS ||--o{ TRAINING_SESSION_SLOTS : has
    SESSION_TIMES ||--o{ TRAINING_SESSION_SLOTS : used_in

    TRAINING_SESSION_SLOTS ||--o{ TRAINING_SESSION_SLOT_COACH : mapped
    COACHES ||--o{ TRAINING_SESSION_SLOT_COACH : assigned

    TRAINING_SESSIONS ||--o{ ATTENDANCES : records
    MEMBERS ||--o{ ATTENDANCES : attends

    MEMBERS o|--o{ ACHIEVEMENTS : may_have

    BROADCASTS ||--o{ BROADCAST_LOGS : has
    MEMBERS ||--o{ BROADCAST_LOGS : receives
```

## Catatan Penting

- Tabel `session_bookings` sudah dihapus oleh migration refactor attendance.
- Tabel `attendances` saat ini langsung menghubungkan `training_sessions` dan `members`.
- Relasi `member_packages.member_id` unik, sehingga satu member memiliki maksimal satu baris package aktif pada satu waktu.
- `personal_access_tokens` menggunakan relasi polymorphic (`tokenable_type`, `tokenable_id`) sehingga tidak divisualkan ke satu tabel spesifik saja.
