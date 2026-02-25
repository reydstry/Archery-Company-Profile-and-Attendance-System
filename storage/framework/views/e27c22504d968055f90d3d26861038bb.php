<?php $__env->startSection('title', 'Forgot Password - FocusOneX Archery'); ?>

<?php $__env->startSection('content'); ?>
<section class="relative min-h-screen flex items-center justify-center px-4 overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('asset/img/latarbelakanglogin.jpeg')); ?>"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md">
        <div class="backdrop-blur-sm border border-white/20 rounded-2xl shadow-2xl shadow-black/50 px-10 py-10">

            <h1 class="text-3xl font-bold text-white text-center mb-4">
                Forgot Password
            </h1>

            <p class="text-white/60 text-sm text-center mb-8">
                Enter your email and we’ll send you a password reset link.
            </p>

            <?php if(session('status')): ?>
                <div class="mb-6 rounded-xl border border-green-400/30 bg-green-500/10 p-3 text-sm text-green-300">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 rounded-xl border border-red-400/30 bg-red-500/10 p-3 text-sm text-red-300">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-8">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div>
                    <input type="email"
                           name="email"
                           value="<?php echo e(old('email')); ?>"
                           required
                           autofocus
                           placeholder="Email address"
                           class="w-full bg-transparent border-0 border-b border-white
                                  text-white placeholder-white text-sm
                                  pb-2 pt-1 focus:outline-none focus:border-white">
                </div>

                <button type="submit"
                        class="w-full bg-white border border-white/20 hover:bg-white/80
                               rounded-xl py-3 text-sm font-medium text-black transition-all">
                    Send Reset Link
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-white/50">
                Back to
                <a href="<?php echo e(route('login')); ?>" class="text-white font-semibold hover:text-white/80">
                    Login
                </a>
            </p>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Project\club-panahan\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>