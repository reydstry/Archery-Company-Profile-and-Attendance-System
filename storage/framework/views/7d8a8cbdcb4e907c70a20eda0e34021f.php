<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('subtitle', 'Ringkasan aktivitas member dan keluarga'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down { animation: slideDown 0.3s ease-out; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div x-data="memberDashboard()" x-init="init()" class="space-y-6">

        <!-- Loading State -->
        <div x-show="loading" class="flex justify-center items-center min-h-[60vh]">
            <div class="flex flex-col items-center gap-4">
                <div class="relative">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-slate-200"></div>
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-[#1a307b] border-t-transparent absolute top-0"></div>
                </div>
                <p class="text-slate-200 font-medium">Memuat dashboard...</p>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div x-show="!loading" x-cloak class="space-y-6">

            <!-- Notifications Bar -->
            <div x-show="notifications.length > 0" class="space-y-3">
                <template x-for="notif in notifications" :key="notif.id">
                    <div class="relative overflow-hidden rounded-2xl border-2 p-5 animate-slide-down"
                         :class="{
                             'bg-amber-50 border-amber-300': notif.type === 'warning',
                             'bg-blue-50 border-blue-300': notif.type === 'info',
                             'bg-red-50 border-red-300': notif.type === 'urgent'
                         }">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center"
                                 :class="{
                                     'bg-amber-500': notif.type === 'warning',
                                     'bg-blue-500': notif.type === 'info',
                                     'bg-red-500': notif.type === 'urgent'
                                 }">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path x-show="notif.type === 'warning' || notif.type === 'urgent'" stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                    <path x-show="notif.type === 'info'" stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-800 mb-1" x-text="notif.title"></h4>
                                <p class="text-sm text-slate-700" x-text="notif.message"></p>
                                <p class="text-xs text-slate-500 mt-2" x-text="notif.date"></p>
                            </div>
                            <button @click="dismissNotification(notif.id)" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Welcome Banner -->
            <div class="relative overflow-hidden bg-gradient-to-br from-[#1a307b] to-[#112052] rounded-3xl shadow-2xl">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 50px 50px;"></div>
                </div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-48 -mt-48"></div>

                <div class="relative px-6 py-8 md:px-8 md:py-10">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2 md:mb-3 leading-tight">
                        Selamat Datang, <br class="block sm:hidden" /><span x-text="userName"></span>! 👋
                    </h1>
                    <p class="text-blue-100 text-sm md:text-lg mb-6 md:mb-8" x-text="getCurrentDate()"></p>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4">
                            <p class="text-blue-100 text-xs mb-1">Total Anggota</p>
                            <p class="text-white text-3xl font-bold" x-text="allMembers.length"></p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4">
                            <p class="text-blue-100 text-xs mb-1">Paket Aktif</p>
                            <p class="text-white text-3xl font-bold" x-text="activePackagesCount"></p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4">
                            <p class="text-blue-100 text-xs mb-1">Total Kehadiran</p>
                            <p class="text-white text-3xl font-bold" x-text="totalAttendance"></p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4">
                            <p class="text-blue-100 text-xs mb-1">Rata-rata</p>
                            <p class="text-white text-3xl font-bold" x-text="averageAttendanceRate + '%'"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Member Section -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-5 md:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-slate-800">Tambah Anggota Keluarga</h2>
                        <p class="text-sm md:text-base text-slate-600 mt-1">Daftarkan anggota keluarga Anda untuk latihan archery</p>
                    </div>
                    <button @click="showAddMemberForm = !showAddMemberForm" 
                            class="w-full sm:w-auto px-6 py-3 rounded-xl font-semibold transition-all"
                            :class="showAddMemberForm ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-[#1a307b] text-white hover:bg-opacity-90'">
                        <span x-text="showAddMemberForm ? 'Tutup Form' : '+ Tambah Anggota'"></span>
                    </button>
                </div>

                <!-- Add Member Form -->
                <div x-show="showAddMemberForm" x-collapse class="bg-slate-50 rounded-2xl p-6">
                    <form @submit.prevent="submitAddMember" class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Anggota *</label>
                                <input type="text" x-model="newMember.name" required
                                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#1a307b] focus:ring-2 focus:ring-[#1a307b]/30 outline-none transition"
                                       placeholder="Masukkan nama lengkap anak/anggota keluarga">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon</label>
                                <input type="tel" x-model="newMember.phone"
                                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-[#1a307b] focus:ring-2 focus:ring-[#1a307b]/30 outline-none transition"
                                       placeholder="08xx xxxx xxxx (opsional)">
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <p class="text-sm text-blue-800">
                                <strong>Catatan:</strong> Setelah mendaftar, anggota akan berstatus <em>pending</em> dan menunggu verifikasi dari admin. Anda akan diberitahu setelah disetujui.
                            </p>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="showAddMemberForm = false"
                                    class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition">
                                Batal
                            </button>
                            <button type="submit" :disabled="submitting"
                                    class="px-6 py-3 bg-[#1a307b] text-white rounded-xl font-semibold hover:bg-[#1a307b]/90 transition disabled:opacity-50 flex items-center gap-2">
                                <svg x-show="submitting" class="animate-spin w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                    <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="submitting ? 'Menyimpan...' : 'Simpan Anggota'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Members Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="member in allMembers" :key="member.id">
                    <div class="bg-white rounded-3xl shadow-lg border-2 border-slate-200 hover:border-[#1a307b]/30 hover:shadow-xl transition-all overflow-hidden">
                        <!-- Member Header -->
                        <div class="bg-gradient-to-br from-[#1a307b] to-[#112052] px-6 py-5 text-white">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-xl font-bold mb-1" x-text="member.name"></h3>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full" :class="member.status === 'active' ? 'bg-green-300' : 'bg-amber-300'"></span>
                                        <span x-text="member.status === 'active' ? 'Aktif' : 'Pending'"></span>
                                    </span>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl font-bold">
                                    <span x-text="member.name?.charAt(0).toUpperCase()"></span>
                                </div>
                            </div>
                            <p class="text-blue-100 text-sm" x-text="'ID: ' + member.id"></p>
                        </div>

                        <!-- Member Body -->
                        <div class="p-5 md:p-6 space-y-4">
                            <!-- Active Package -->
                            <template x-if="member.activePackage">
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-4">
                                    <p class="text-xs font-semibold text-green-700 mb-2">📦 Paket Aktif</p>
                                    <p class="text-sm md:text-base font-bold text-slate-800 mb-2" x-text="member.activePackage.package_name"></p>
                                    <div class="grid grid-cols-3 gap-1 md:gap-2 mb-3">
                                        <div class="text-center">
                                            <p class="text-[10px] md:text-xs text-slate-600">Total</p>
                                            <p class="text-base md:text-lg font-bold text-slate-800" x-text="member.activePackage.total_sessions"></p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[10px] md:text-xs text-slate-600">Terpakai</p>
                                            <p class="text-base md:text-lg font-bold text-slate-800" x-text="member.activePackage.used_sessions"></p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[10px] md:text-xs text-green-700">Tersisa</p>
                                            <p class="text-base md:text-lg font-bold text-green-700" x-text="member.activePackage.remaining_sessions"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between text-[11px] md:text-xs text-slate-600">
                                        <span>Berlaku s/d</span>
                                        <span class="font-semibold" x-text="formatDate(member.activePackage.end_date)"></span>
                                    </div>
                                </div>
                            </template>

                            <!-- No Package -->
                            <template x-if="!member.activePackage">
                                <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-4 text-center">
                                    <p class="text-sm md:text-base text-amber-800 font-semibold mb-2">Belum Ada Paket Aktif</p>
                                    <p class="text-xs text-amber-600">Hubungi admin untuk aktivasi</p>
                                </div>
                            </template>

                            <!-- Attendance Stats -->
                            <div class="grid grid-cols-2 gap-2 md:gap-3">
                                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-3 text-center border border-slate-200">
                                    <p class="text-[10px] md:text-xs text-[#1a307b] mb-1 font-semibold">Kehadiran</p>
                                    <p class="text-xl md:text-2xl font-bold text-[#1a307b]" x-text="member.stats?.total_attended || 0"></p>
                                </div>
                                <div class="bg-gradient-to-br from-rose-50 to-red-50 rounded-xl p-3 text-center border border-red-100">
                                    <p class="text-[10px] md:text-xs text-[#d12823] mb-1 font-semibold">Tidak Hadir</p>
                                    <p class="text-xl md:text-2xl font-bold text-[#d12823]" x-text="member.stats?.total_absent || 0"></p>
                                </div> 
                            </div>

                            <!-- Attendance Rate -->
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-semibold text-slate-700">Tingkat Kehadiran</span>
                                        <span class="text-sm font-bold text-[#1a307b]" x-text="calculateAttendanceRate(member) + '%'"></span>
                                    </div>
                                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-[#1a307b] to-[#2542a3] rounded-full transition-all"
                                             :style="`width: ${calculateAttendanceRate(member)}%`"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="pt-4 border-t border-slate-200 space-y-2">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                    </svg>
                                    <span x-text="member.phone || 'Belum ada nomor telepon'"></span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a :href="'https://wa.me/6281234567890?text=Halo, saya ingin booking sesi latihan untuk ' + member.name" target="_blank"
                               class="block w-full py-3 bg-green-600 hover:bg-green-700 text-white text-center rounded-xl font-semibold transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <span>Booking via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Recent Attendance Section -->
            <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-5 md:p-8">
                <h2 class="text-xl md:text-2xl font-bold text-slate-800 mb-6">Riwayat Kehadiran Terbaru</h2>
                
                <div x-show="attendanceHistory.length > 0" class="space-y-3">
                    <template x-for="(attendance, index) in attendanceHistory" :key="attendance.id">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 p-4 md:p-5 rounded-2xl border-2 border-slate-100 hover:border-[#1a307b]/30 hover:shadow-md transition-all">
                            <!-- Status Icon -->
                            <div class="flex items-center gap-3 sm:hidden mb-2">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                                     :class="attendance.attendance_status === 'present' ? 'bg-gradient-to-br from-green-100 to-emerald-100' : 'bg-gradient-to-br from-red-100 to-rose-100'">
                                    <svg class="w-5 h-5" :class="attendance.attendance_status === 'present' ? 'text-green-600' : 'text-red-600'"
                                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path x-show="attendance.attendance_status === 'present'" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        <path x-show="attendance.attendance_status !== 'present'" stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="font-bold text-slate-800" x-text="attendance.member_name"></p>
                            </div>

                            <div class="hidden sm:flex flex-shrink-0 w-14 h-14 rounded-xl items-center justify-center"
                                 :class="attendance.attendance_status === 'present' ? 'bg-gradient-to-br from-green-100 to-emerald-100' : 'bg-gradient-to-br from-red-100 to-rose-100'">
                                <svg class="w-7 h-7" :class="attendance.attendance_status === 'present' ? 'text-green-600' : 'text-red-600'"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path x-show="attendance.attendance_status === 'present'" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <path x-show="attendance.attendance_status !== 'present'" stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="hidden sm:block font-bold text-slate-800 mb-1" x-text="attendance.member_name"></p>
                                <p class="text-sm text-slate-600 mb-1" x-text="formatDate(attendance.session_date) + ' · ' + attendance.session_time"></p>
                                <p class="text-xs text-slate-500" x-text="'Coach ' + attendance.coach_name"></p>
                            </div>

                            <!-- Status Badge -->
                            <span class="flex-shrink-0 inline-flex self-start sm:self-auto mt-2 sm:mt-0 px-4 py-2 rounded-lg text-sm font-bold w-fit"
                                  :class="attendance.attendance_status === 'present' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                  x-text="attendance.attendance_status === 'present' ? 'Hadir' : 'Tidak Hadir'"></span>
                        </div>
                    </template>
                </div>

                <div x-show="attendanceHistory.length === 0" class="text-center py-10 md:py-12">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
                        </svg>
                    </div>
                    <h4 class="text-base md:text-lg font-bold text-slate-800 mb-2">Belum Ada Riwayat</h4>
                    <p class="text-slate-500 text-xs md:text-sm">Booking sesi latihan via WhatsApp untuk memulai</p>
                </div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>

        // Auto-refresh CSRF token every 60 minutes to prevent expiry
        setInterval(() => {
            fetch('/api/me', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                credentials: 'same-origin'
            }).then(response => {
                if (response.status === 419) {
                    showToast('Session expired, silakan login kembali', 'error');
                    setTimeout(() => window.location.href = '/login', 2000);
                }
            }).catch(console.error);
        }, 60 * 60 * 1000); // Every 60 minutes

        // Handle form resubmission (back button after POST)
        if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            window.location.reload();
        }

        window.showToast = (message, type = 'info') => {
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { message, type }
            }));
        };

        // Main Dashboard Component
        function memberDashboard() {
            return {
                loading: true,
                userName: '<?php echo e(auth()->user()->name); ?>',
                userEmail: '<?php echo e(auth()->user()->email); ?>',
                userInitial: '<?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>',
                
                allMembers: [],
                attendanceHistory: [],
                notifications: [],
                
                showAddMemberForm: false,
                submitting: false,
                newMember: {
                    name: '',
                    phone: ''
                },

                async init() {
                    await this.fetchAllData();
                    this.loading = false;
                },

                async fetchAllData() {
                    try {
                        // Fetch dashboard data for the main (self) member
                        const dashboardData = await API.get('/member/dashboard');
                        
                        // Fetch all members (self + family)
                        const membersResponse = await API.get('/member/my-members');
                        const membersData = membersResponse.data || [];
                        
                        // Map members with data
                        this.allMembers = membersData.map(member => {
                            // If this is the self member, attach full dashboard data
                            if (member.is_self) {
                                return {
                                    ...member,
                                    activePackage: dashboardData.quota || null,
                                    stats: dashboardData.attendance?.statistics || { total_attended: 0, total_absent: 0 }
                                };
                            }
                            // For family members (children), we don't have individual package data yet
                            // In the future, admin can assign packages to them
                            return {
                                ...member,
                                activePackage: null,
                                stats: { total_attended: 0, total_absent: 0 }
                            };
                        });

                        // Fetch attendance history (combined for all)
                        this.attendanceHistory = (dashboardData.attendance?.history || []).map(att => ({
                            ...att,
                            member_name: this.allMembers.find(m => m.is_self)?.name || 'Member'
                        }));
                        
                        // Generate notifications
                        this.generateNotifications();
                        
                    } catch (error) {
                        console.error('Error fetching data:', error);
                        showToast('Gagal memuat data dashboard', 'error');
                    }
                },

                generateNotifications() {
                    this.notifications = [];
                    
                    // Check for expiring packages
                    this.allMembers.forEach(member => {
                        if (member.activePackage) {
                            const endDate = new Date(member.activePackage.end_date);
                            const today = new Date();
                            const daysUntilExpiry = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));
                            
                            if (daysUntilExpiry <= 7 && daysUntilExpiry > 0) {
                                this.notifications.push({
                                    id: `expiry-${member.id}`,
                                    type: 'warning',
                                    title: `⚠️ Paket ${member.name} Akan Berakhir`,
                                    message: `Paket membership akan berakhir dalam ${daysUntilExpiry} hari (${this.formatDate(member.activePackage.end_date)}). Segera perpanjang!`,
                                    date: this.formatDate(today)
                                });
                            } else if (daysUntilExpiry <= 0) {
                                this.notifications.push({
                                    id: `expired-${member.id}`,
                                    type: 'urgent',
                                    title: `🚨 Paket ${member.name} Sudah Berakhir`,
                                    message: `Paket membership sudah tidak aktif. Hubungi admin untuk perpanjangan.`,
                                    date: this.formatDate(today)
                                });
                            }
                        }
                    });

                    // Example: Upcoming competition notification
                    // Uncomment and customize as needed:
                    // this.notifications.push({
                    //     id: 'event-1',
                    //     type: 'info',
                    //     title: '🏆 Perlombaan Mendatang',
                    //     message: 'Kompetisi Archery Regional akan diadakan tanggal 25 Februari 2026. Daftarkan anak Anda sekarang!',
                    //     date: this.formatDate(new Date())
                    // });
                },

                dismissNotification(id) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                },

                async submitAddMember() {
                    if (!this.newMember.name) {
                        showToast('Mohon masukkan nama anggota', 'error');
                        return;
                    }

                    this.submitting = true;
                    try {
                        const response = await API.post('/member/register-child', this.newMember);
                        showToast(response.message || 'Anggota berhasil ditambahkan!', 'success');
                        
                        // Reset form
                        this.newMember = {
                            name: '',
                            phone: ''
                        };
                        this.showAddMemberForm = false;
                        
                        // Refresh data
                        await this.fetchAllData();
                    } catch (error) {
                        console.error('Error adding member:', error);
                        showToast(error.message || 'Gagal menambahkan anggota', 'error');
                    } finally {
                        this.submitting = false;
                    }
                },

                calculateAttendanceRate(member) {
                    const total = (member.stats?.total_attended || 0) + (member.stats?.total_absent || 0);
                    return total === 0 ? 0 : Math.round((member.stats?.total_attended / total) * 100);
                },

                get activePackagesCount() {
                    return this.allMembers.filter(m => m.activePackage).length;
                },

                get totalAttendance() {
                    return this.allMembers.reduce((sum, m) => sum + (m.stats?.total_attended || 0), 0);
                },

                get averageAttendanceRate() {
                    if (this.allMembers.length === 0) return 0;
                    const totalRate = this.allMembers.reduce((sum, m) => sum + this.calculateAttendanceRate(m), 0);
                    return Math.round(totalRate / this.allMembers.length);
                },

                getCurrentDate() {
                    return new Date().toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },

                formatDate(dateString) {
                    if (!dateString) return '-';
                    return new Date(dateString).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                }
            }
        }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.member', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Project-KP-Archery\resources\views/dashboards/member/dashboard.blade.php ENDPATH**/ ?>