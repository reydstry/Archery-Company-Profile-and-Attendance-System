<!-- Achievements Section -->
<section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#1b2659] to-[#0f172a] overflow-hidden">
    <div class="container mx-auto px-6 relative z-10">

        <!-- Section Header -->
        <div class="text-center mb-12 sm:mb-16">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                {{ __('about.achievements_title') }}
            </h2>
            <p class="text-gray-300 text-base sm:text-lg max-w-2xl mx-auto px-4">
                {{ __('about.achievements_subtitle') }}
            </p>
        </div>

        @php
            use App\Models\Achievement;
            
            $memberAchievements = Achievement::query()
                ->where('type', 'member')
                ->whereNotNull('member_id')
                ->with('member')
                ->orderBy('date', 'desc')
                ->get()
                ->groupBy('member_id')
                ->map(function($achievements) {
                    $member = $achievements->first()->member;
                    if (!$member) return null;
                    
                    return [
                        'name' => $member->name,
                        'photo' => $achievements->first()->photo_url ?? asset('asset/img/default-avatar.png'),
                        'awards' => $achievements->map(function($achievement) {
                            $medal = '🏆';
                            $title = strtolower($achievement->title);
                            
                            if (str_contains($title, 'juara 1') || str_contains($title, 'gold') || str_contains($title, '1st place') || str_contains($title, 'first place')) {
                                $medal = '🥇';
                            } elseif (str_contains($title, 'juara 2') || str_contains($title, 'silver') || str_contains($title, '2nd place') || str_contains($title, 'second place')) {
                                $medal = '🥈';
                            } elseif (str_contains($title, 'juara 3') || str_contains($title, 'bronze') || str_contains($title, '3rd place') || str_contains($title, 'third place')) {
                                $medal = '🥉';
                            }
                            
                            return [
                                'medal' => $medal,
                                'title' => $achievement->title
                            ];
                        })->toArray()
                    ];
                })
                ->filter()
                ->take(10);
        @endphp

        @if($memberAchievements->isEmpty())
        <div class="text-center py-12">
            <p class="text-white/60 text-lg">Belum ada prestasi member yang tersedia saat ini.</p>
        </div>
        @else
        <!-- Carousel Container with Alpine.js -->
        <div x-data="{ 
            scrollAchievements(direction) {
                const container = $refs.achievementsContainer;
                const scrollAmount = container.offsetWidth * 0.8;
                container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
            }
        }">
            <!-- Header with View All Button -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-1">Prestasi Member Terbaik</h3>
                    <p class="text-gray-400 text-sm">Atlet-atlet berprestasi FocusOneX</p>
                </div>
                <a href="{{ route('galeri') }}" 
                   class="liquid-glass wide group flex items-center gap-2 px-4 py-2 text-yellow-300 hover:text-yellow-200 font-semibold text-sm transition-all duration-200"
                   onmouseenter="this.classList.add('is-hovered')"
                   onmouseleave="this.classList.remove('is-hovered')">
                    <span class="shine"></span>
                    <span class="relative z-10">Lihat Semua</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Carousel -->
            <div class="relative px-8 sm:px-10 md:px-14">
                <!-- Left Arrow: liquid-btn -->
                @if($memberAchievements->count() > 3)
                <button @click="scrollAchievements(-1)" 
                        class="liquid-btn btn-white absolute -left-3 sm:-left-5 md:-left-7 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-13 sm:h-13 md:w-14 md:h-14 text-white flex items-center justify-center"
                        onmouseenter="this.classList.add('is-hovered')" onmouseleave="this.classList.remove('is-hovered')">
                    <span class="shine"></span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                @endif

                <!-- Scrollable Container: seamless scroll, fade edges -->
                <div class="relative overflow-hidden">
                    <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-8 sm:w-12 bg-gradient-to-r from-[#1b2659] to-transparent z-10"></div>
                    <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-8 sm:w-12 bg-gradient-to-l from-[#0f172a] to-transparent z-10"></div>
                    <div x-ref="achievementsContainer" 
                         class="flex gap-6 sm:gap-8 overflow-x-auto overflow-y-visible snap-x snap-mandatory py-4 -my-4 px-2 carousel-scroll"
                         style="scrollbar-width: none; -ms-overflow-style: none; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                    @foreach($memberAchievements as $achievement)
                    <div class="flex-shrink-0 w-[85%] sm:w-[calc(50%-16px)] lg:w-[calc(33.333%-22px)] snap-start">
                        <div class="relative group h-full">
                            <!-- Card: liquid-glass -->
                            <div class="liquid-glass relative h-full flex flex-col transition-all duration-300 hover:scale-[1.03] hover:-translate-y-2"
                                 style="box-shadow: 0 8px 32px rgba(0,0,0,0.25);"
                                 onmouseenter="this.classList.add('is-hovered')"
                                 onmouseleave="this.classList.remove('is-hovered')">

                                <!-- Shine -->
                                <span class="shine"></span>

                                <!-- Image -->
                                <div class="h-48 overflow-hidden rounded-t-[1rem] flex-shrink-0 bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                                    @if($achievement['photo'])
                                    <img src="{{ $achievement['photo'] }}" 
                                         alt="{{ $achievement['name'] }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                    <div class="text-center">
                                        <svg class="w-20 h-20 text-white/30 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-white/50 text-xs">{{ substr($achievement['name'], 0, 1) }}</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-5 flex flex-col flex-1">
                                    <div class="text-center">
                                        <h4 class="font-bold text-white text-base">{{ $achievement['name'] }}</h4>
                                        <p class="text-white/50 text-xs mb-4">Atlet FocusOnex</p>
                                    </div>

                                    <div class="flex justify-center">
                                        <div class="w-20 h-px bg-red-500/70 mb-4"></div>
                                    </div>
             
                                    <!-- Awards: liquid-glass inner cards -->
                                    <div class="space-y-3">
                                        @foreach($achievement['awards'] as $award)
                                        <div class="liquid-glass relative flex items-center gap-3 px-4 py-2.5 transition-transform duration-300"
                                             style="box-shadow: 0 4px 16px rgba(0,0,0,0.15);"
                                             onmouseenter="this.classList.add('is-hovered')"
                                             onmouseleave="this.classList.remove('is-hovered')">
                                            <span class="shine"></span>
                                            <span class="text-xl relative z-10">{{ $award['medal'] }}</span>
                                            <span class="text-white/80 text-xs sm:text-sm leading-snug relative z-10">{{ $award['title'] }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>

                <!-- Right Arrow: liquid-btn -->
                @if($memberAchievements->count() > 3)
                <button @click="scrollAchievements(1)" 
                        class="liquid-btn btn-white absolute -right-3 sm:-right-5 md:-right-7 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-13 sm:h-13 md:w-14 md:h-14 text-white flex items-center justify-center"
                        onmouseenter="this.classList.add('is-hovered')" onmouseleave="this.classList.remove('is-hovered')">
                    <span class="shine"></span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif
            </div>
        </div>
        @endif

    </div>
</section>
