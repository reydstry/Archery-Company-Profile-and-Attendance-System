    <div class="relative min-h-screen py-24 sm:py-32 overflow-x-hidden bg-gradient-to-b from-[#1b2659] to-[#16213a]">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                    <?php echo e(__('gallery.highlights_title')); ?>

                </h2>
                <p class="text-gray-300 text-base sm:text-lg max-w-2xl mx-auto">
                    <?php echo e(__('gallery.highlights_page_subtitle')); ?>

                </p>
            </div>

            <?php
                use App\Models\Achievement;
                use App\Models\News;

                $newsItems = News::query()
                    ->published()
                    ->orderBy('publish_date', 'desc')
                    ->orderBy('id', 'desc')
                    ->limit(12)
                    ->get()
                    ->map(function ($news) {
                        return [
                            'id' => $news->id,
                            'type' => 'news',
                            'badge' => __('gallery.type_news'),
                            'badge_icon' => '📰',
                            'image' => $news->photo_url ?? asset('asset/img/latarbelakanglogin.jpeg'),
                            'title' => $news->title,
                            'date' => $news->publish_date?->format('d F Y'),
                            'timestamp' => $news->publish_date?->timestamp ?? 0,
                            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($news->content), 150),
                            'url' => route('news.detail', $news->id),
                        ];
                    });

                $achievementItems = Achievement::query()
                    ->published()
                    ->with('member')
                    ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc')
                    ->limit(12)
                    ->get()
                    ->map(function ($achievement) {
                        $badgeIcon = '🏆';
                        $title = strtolower($achievement->title);

                        if (str_contains($title, 'juara 1') || str_contains($title, 'gold') || str_contains($title, '1st place')) {
                            $badgeIcon = '🥇';
                        } elseif (str_contains($title, 'juara 2') || str_contains($title, 'silver') || str_contains($title, '2nd place')) {
                            $badgeIcon = '🥈';
                        } elseif (str_contains($title, 'juara 3') || str_contains($title, 'bronze') || str_contains($title, '3rd place')) {
                            $badgeIcon = '🥉';
                        }

                        return [
                            'id' => $achievement->id,
                            'type' => 'achievement',
                            'badge' => __('gallery.type_achievement'),
                            'badge_icon' => $badgeIcon,
                            'image' => $achievement->photo_url ?? asset('asset/img/latarbelakanglogin.jpeg'),
                            'title' => $achievement->title,
                            'date' => $achievement->date?->format('d F Y'),
                            'timestamp' => $achievement->date?->timestamp ?? 0,
                            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($achievement->description), 120),
                            'member' => $achievement->type === 'member' && $achievement->member ? $achievement->member->name : null,
                            'url' => route('achievement.detail', $achievement->id),
                        ];
                    });

                $highlightItems = $newsItems
                    ->concat($achievementItems)
                    ->sortByDesc('timestamp')
                    ->values();
            ?>

            <div class="relative" x-data="{
                currentIndex: 0,
                cardWidth: 0,
                totalCards: 0,
                visibleCards: 3,

                initScroll() {
                    const c = this.$refs.highlightsContainer;
                    const card = c.querySelector('[data-card]');
                    if (!card) return;

                    this.cardWidth = card.offsetWidth + 24; // + gap
                    this.totalCards = c.children.length;

                    this.updatePosition();
                },

                scrollHighlights(direction) {
                    const maxIndex = this.totalCards - this.visibleCards;

                    this.currentIndex += direction;

                    if (this.currentIndex < 0) this.currentIndex = 0;
                    if (this.currentIndex > maxIndex) this.currentIndex = maxIndex;

                    this.updatePosition();
                },

                updatePosition() {
                    const c = this.$refs.highlightsContainer;
                    c.style.transform = `translateX(-${this.currentIndex * this.cardWidth}px)`;
                },

                get canScrollLeft() {
                    return this.currentIndex > 0;
                },

                get canScrollRight() {
                    return this.currentIndex < this.totalCards - (this.visibleCards + 1);
                }
            }"
            x-init="$nextTick(() => initScroll())"
            >

                <div class="relative w-screen left-1/2 -translate-x-1/2">
                    <!-- LEFT FADE + BUTTON -->
                    <div
                        x-show="canScrollLeft"
                        x-transition.opacity
                        class="absolute left-0 top-0 bottom-0 w-24 z-40 flex items-center justify-start overflow-hidden"
                    >
                        <!-- Gradient -->
                        <div class="mr-5 absolute inset-0 bg-gradient-to-r from-black/90 via-80% to-transparent w-18 rounded-r-3xl pointer-events-none"></div>

                        <!-- Button -->
                        <button
                            @click="scrollHighlights(-1)"
                            class="liquid-btn btn-white relative z-50 w-10 h-32 flex items-center justify-center pointer-events-auto ml-10"
                            onMouseenter="this.classList.add('is-hovered')"
                            onMouseleave="this.classList.remove('is-hovered')"
                            >

                            <span class="shine"></span>
                            <svg class="w-6 h-6 relative z-10 text-white"
                                fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                    </div>


                    <!-- RIGHT FADE + BUTTON -->
                    <div
                        x-show="canScrollRight"
                        x-transition.opacity
                        class="absolute right-0 top-0 bottom-0 w-24 z-40 flex items-center justify-end overflow-hidden"
                    >
                        <!-- Gradient -->
                        <div class="ml-5 absolute inset-0 bg-gradient-to-l from-black/90 via-80% to-transparent w-18 rounded-l-3xl pointer-events-none"></div>

                        <!-- Button -->
                        <button
                            @click="scrollHighlights(1)"
                            class="liquid-btn btn-white relative z-50 w-10 h-32 flex items-center justify-center pointer-events-auto mr-10"
                            onMouseenter="this.classList.add('is-hovered')"
                            onMouseleave="this.classList.remove('is-hovered')"
                            >

                            <span class="shine"></span>
                            <svg class="w-6 h-6 relative z-10 text-white"
                                fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>


                    <!-- SCROLL TRACK -->
                    <div x-ref="highlightsContainer"
                        class="flex gap-6 px-24 transition-transform duration-500 ease-out"
                        style="will-change: transform;"
                    >

                        <style>
                            [x-ref="highlightsContainer"]::-webkit-scrollbar {
                                display: none;
                            }
                        </style>

                        <?php $__currentLoopData = $highlightItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div data-card
                                class="shrink-0"
                                style="width: clamp(401px, 23vw, 330px); scroll-snap-align: start;">
                                <a href="<?php echo e($item['url']); ?>" class="relative group h-full block">
                                    <div class="liquid-glass relative h-full flex flex-col z-10 transition-all duration-300 ease-out cursor-pointer"
                                        style="box-shadow: 0 10px 28px rgba(0,0,0,0.34);"
                                        onmouseenter="this.classList.add('is-hovered')"
                                        onmouseleave="this.classList.remove('is-hovered')">
                                        <span class="shine"></span>

                                        <div class="relative h-48 sm:h-52 overflow-hidden rounded-t-[1rem] shrink-0">
                                            <img src="<?php echo e($item['image']); ?>"
                                                alt="<?php echo e($item['title']); ?>"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                loading="lazy">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                        </div>

                                        <div class="p-5 flex flex-col flex-1">
                                            <div class="flex items-center justify-between gap-2 text-white/40 text-xs mb-3">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span><?php echo e($item['date']); ?></span>
                                                </div>
                                                <?php if(!empty($item['member'])): ?>
                                                    <span class="text-yellow-400/85 truncate max-w-[120px]"><?php echo e($item['member']); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <h3 class="text-base sm:text-lg font-bold text-white mb-2 line-clamp-2 leading-snug">
                                                <?php echo e($item['title']); ?>

                                            </h3>

                                            <div class="w-8 h-0.5 <?php echo e($item['type'] === 'news' ? 'bg-blue-400/60' : 'bg-yellow-400/60'); ?> rounded-full mb-3"></div>

                                            <p class="text-white/60 text-xs sm:text-sm line-clamp-3 leading-relaxed flex-1">
                                                <?php echo e($item['excerpt']); ?>

                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-8">
                    <a href="<?php echo e(route('galeri.highlights')); ?>"
                    class="liquid-glass wide group inline-flex items-center gap-2 px-4 py-2 text-white/80 hover:text-white font-semibold text-sm transition-all duration-200"
                    onmouseenter="this.classList.add('is-hovered')"
                    onmouseleave="this.classList.remove('is-hovered')">
                        <span class="shine"></span>
                        <span class="relative z-10"><?php echo e(__('gallery.view_all_highlights')); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH C:\laragon\www\Project\club-panahan\resources\views/components/galeri/news-section.blade.php ENDPATH**/ ?>