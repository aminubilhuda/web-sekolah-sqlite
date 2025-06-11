<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sekolah_aktif ? $sekolah_aktif->nama_sekolah : 'Sekolah' }}</title>
    @if($sekolah_aktif && $sekolah_aktif->icon_sekolah)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $sekolah_aktif->icon_sekolah) }}">
    @endif
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
        }

        .icon-bounce {
            transition: transform 0.2s ease;
        }

        .icon-bounce:hover {
            transform: scale(1.1);
        }

        /* Animation Styles */
        [data-animation],
        .stagger-item {
            opacity: 0;
            /* Start hidden, animation will make it visible */
        }

        .animate-fade-in-up {
            animation-name: fadeInUp;
            animation-fill-mode: forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-left {
            animation-name: fadeInLeft;
            animation-fill-mode: forwards;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-right {
            animation-name: fadeInRight;
            animation-fill-mode: forwards;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-zoom-in {
            animation-name: zoomIn;
            animation-fill-mode: forwards;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-pop-in {
            animation-name: popIn;
            animation-fill-mode: forwards;
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            70% {
                opacity: 1;
                transform: scale(1.05);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Hero Slider Styles - OPTIMIZED FOR FULL IMAGE DISPLAY */
        .heroSwiper {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .heroSwiper .swiper-slide {
            position: relative;
            width: 100% !important;
            height: 100% !important;
            flex-shrink: 0;
            overflow: hidden;
        }

        .heroSwiper .swiper-wrapper {
            width: 100% !important;
            height: 100% !important;
            display: flex;
            align-items: center;
            transition-timing-function: ease-in-out;
        }

        .heroSwiper .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
            border-radius: 0;
        }

        /* Ensure container maintains aspect ratio */
        .hero-image-container {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 1.5rem;
        }

        .heroSwiper .hero-prev,
        .heroSwiper .hero-next {
            width: 40px !important;
            height: 40px !important;
            margin-top: -20px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(8px) !important;
            border-radius: 50% !important;
            color: white !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease !important;
            z-index: 10 !important;
        }

        .heroSwiper .hero-prev:hover,
        .heroSwiper .hero-next:hover {
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .heroSwiper .hero-next {
            background: #fbbf24 !important;
        }

        .heroSwiper .hero-next:hover {
            background: #f59e0b !important;
        }

        .heroSwiper .swiper-button-prev:after,
        .heroSwiper .swiper-button-next:after {
            display: none !important;
        }

        .heroSwiper .hero-pagination {
            position: absolute !important;
            bottom: 20px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            width: auto !important;
            z-index: 10 !important;
        }

        .heroSwiper .swiper-pagination-bullet {
            width: 8px !important;
            height: 8px !important;
            background: rgba(255, 255, 255, 0.5) !important;
            opacity: 1 !important;
            margin: 0 4px !important;
        }

        .heroSwiper .swiper-pagination-bullet-active {
            background: #fbbf24 !important;
            width: 24px !important;
            border-radius: 4px !important;
        }

        /* Mobile responsiveness for hero slider */
        @media (max-width: 640px) {

            .heroSwiper .hero-prev,
            .heroSwiper .hero-next {
                width: 32px !important;
                height: 32px !important;
                margin-top: -16px !important;
            }

            .heroSwiper .hero-pagination {
                bottom: 16px !important;
            }

            .hero-image-container {
                height: 400px;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
    <!-- Header -->
    @include('layouts.header')

    @yield('content')
    
    @include('layouts.footer')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Hero Slider with FULL IMAGE DISPLAY optimization
        const heroSwiper = new Swiper('.heroSwiper', {
            // Core settings for full image display
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            centeredSlides: false,
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
            preventInteractionOnTransition: false,

            // Autoplay settings
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
                reverseDirection: false
            },

            // Transition settings
            speed: 800,
            effect: 'slide',

            // Navigation and pagination
            pagination: {
                el: '.hero-pagination',
                clickable: true,
                bulletActiveClass: 'swiper-pagination-bullet-active',
                bulletClass: 'swiper-pagination-bullet',
            },
            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },

            // Event handlers
            on: {
                init: function () {
                    console.log('Hero Swiper initialized with full image display');
                    // Re-initialize Lucide icons after swiper init
                    setTimeout(() => {
                        lucide.createIcons();
                    }, 100);
                },
                slideChange: function () {
                    console.log('Slide changed to:', this.activeIndex);
                    // Re-initialize Lucide icons on slide change
                    setTimeout(() => {
                        lucide.createIcons();
                    }, 100);
                },
                resize: function () {
                    // Ensure proper sizing on window resize
                    this.update();
                }
            }
        });
    </script>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenuBtn.innerHTML = '<i data-lucide="menu" class="w-6 h-6"></i>';
            } else {
                mobileMenuBtn.innerHTML = '<i data-lucide="x" class="w-6 h-6"></i>';
            }
            lucide.createIcons(); // Re-initialize icons after DOM change
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('backdrop-blur-sm', 'bg-white/95');
            } else {
                header.classList.remove('backdrop-blur-sm', 'bg-white/95');
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -30px 0px'
        };

        const animationObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const animationType = target.dataset.animation;
                    let baseDelay = parseInt(target.dataset.animationDelay) || 0;
                    const animationDuration = target.dataset.animationDuration || '0.8s';

                    if (animationType) {
                        setTimeout(() => {
                            target.classList.add(`animate-${animationType}`);
                            target.style.animationDuration = animationDuration;
                        }, baseDelay);
                    }

                    if (target.classList.contains('stagger-container')) {
                        const items = target.querySelectorAll('.stagger-item');
                        items.forEach((item, index) => {
                            const itemAnimation = item.dataset.animation || 'fade-in-up';
                            const itemBaseDelay = parseInt(item.dataset.animationDelay) || 0;
                            const staggerDelay = index * 150;
                            const totalDelay = baseDelay + itemBaseDelay + staggerDelay;
                            const itemDuration = item.dataset.animationDuration || '0.6s';

                            setTimeout(() => {
                                item.classList.add(`animate-${itemAnimation}`);
                                item.style.animationDuration = itemDuration;
                            }, totalDelay);
                        });
                    }
                    observer.unobserve(target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('[data-animation], .stagger-container').forEach(el => {
            animationObserver.observe(el);
        });
    </script>
</body>

</html>