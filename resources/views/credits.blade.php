<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight tracking-wide">
            Our Team
        </h2>
    </x-slot>

    <style>
        :root {
            --col-bg: #0d0f14;
            --col-surface: #151820;
            --col-border: #1e2330;
            --col-muted: #3a3f52;
            --col-text: #e4e8f5;
            --col-subtle: #6b7394;
            --accent: #4a9eff;
            --accent-dim: rgba(74, 158, 255, 0.15);
        }

        /* Light mode styles for credits page */
        [data-theme="light"] {
            --col-bg: #caf0f8;
            --col-surface: #f0f9ff;
            --col-border: #e0e7ff;
            --col-muted: #64748b;
            --col-text: #03045e;
            --col-subtle: #475569;
            --accent: hsl(220, 90%, 45%);
            --accent-dim: hsla(220, 90%, 45%, 0.15);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--col-text);
            background: var(--col-bg);
            min-height: 100vh;
        }

        .credits-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .hero-badge {
            display: inline-block;
            background: var(--accent-dim);
            color: var(--accent);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border: 1px solid var(--accent);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--accent), #4ade80, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--col-subtle);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .carousel-stage {
            position: relative;
            height: 600px;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto 4rem auto;
            perspective: 1500px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-item {
            position: absolute;
            transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            width: 320px;
            will-change: transform, opacity;
        }

        .carousel-item.active {
            transform: translateX(0) scale(1.1) translateZ(100px);
            opacity: 1;
            z-index: 10;
            cursor: default;
        }

        .carousel-item.prev {
            transform: translateX(-110%) scale(0.8) translateZ(-100px) rotateY(15deg);
            opacity: 0.5;
            z-index: 5;
            cursor: pointer;
            filter: blur(2px) brightness(0.7);
        }

        .carousel-item.next {
            transform: translateX(110%) scale(0.8) translateZ(-100px) rotateY(-15deg);
            opacity: 0.5;
            z-index: 5;
            cursor: pointer;
            filter: blur(2px) brightness(0.7);
        }

        .carousel-item.hidden {
            transform: translateX(0) scale(0.6) translateZ(-300px);
            opacity: 0;
            z-index: 1;
            pointer-events: none;
        }

        .carousel-item.prev:hover, .carousel-item.next:hover {
            opacity: 0.8;
            filter: blur(0px) brightness(1);
        }

        .floating-wrapper {
            width: 100%;
            height: 100%;
            animation: float-anim 6s ease-in-out infinite alternate;
        }
        
        .carousel-item.prev .floating-wrapper {
            animation-delay: -2s;
        }
        .carousel-item.next .floating-wrapper {
            animation-delay: -4s;
        }

        @keyframes float-anim {
            0% { transform: translateY(-12px); }
            100% { transform: translateY(12px); }
        }

        .team-card {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 24px;
            padding: 0;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .carousel-item.active .team-card {
            border-color: var(--accent);
            box-shadow: 0 25px 60px rgba(74, 158, 255, 0.2);
        }

        .card-header {
            position: relative;
            height: 200px;
            background: linear-gradient(135deg, var(--accent-dim), transparent);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .member-photo {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            object-fit: cover;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .team-card:hover .member-photo {
            transform: scale(1.02);
        }

        .card-content {
            padding: 2rem;
        }

        .member-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--col-text);
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .member-role {
            color: var(--accent);
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--accent-dim);
            border-radius: 20px;
            font-size: 0.875rem;
            width: 100%;
            text-align: center;
        }

        .member-bio {
            color: var(--col-subtle);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
        }

        .member-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
        }

        .skill-tag {
            background: var(--col-bg);
            color: var(--col-text);
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid var(--col-border);
            transition: all 0.2s ease;
        }

        .skill-tag:hover {
            background: var(--accent);
            color: white;
            transform: translateY(-2px);
            border-color: var(--accent);
        }

        .project-section {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .project-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #4ade80, #f59e0b, var(--accent));
            animation: gradient-shift 4s ease-in-out infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(10px); }
        }

        .project-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--col-text);
            margin-bottom: 1rem;
        }

        .project-subtitle {
            color: var(--col-subtle);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .tech-card {
            background: var(--col-bg);
            border: 1px solid var(--col-border);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .tech-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent);
            box-shadow: 0 12px 24px rgba(74, 158, 255, 0.15);
        }

        .tech-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .tech-name {
            font-weight: 600;
            color: var(--col-text);
            font-size: 0.9rem;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--col-border);
            color: var(--col-subtle);
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .credits-container {
                padding: 1rem;
            }
            
            .carousel-stage {
                height: auto;
                flex-direction: column;
                overflow: visible;
                margin-bottom: 2rem;
                perspective: none;
            }
            .carousel-item {
                position: relative;
                width: 100%;
                transform: none !important;
                opacity: 1 !important;
                filter: none !important;
                margin-bottom: 1.5rem;
                z-index: 1 !important;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .tech-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .team-card {
                margin: 0 -0.5rem;
            }
        }
    </style>

    <div class="credits-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-badge">Meet the Team</div>
            <h1 class="hero-title">deadlineHariIni</h1>
            <p class="hero-subtitle">
                Built with passion by a team of dedicated developers committed to helping you achieve your productivity goals through smart study solutions.
            </p>
        </div>

        <!-- Team Members Carousel -->
        <div class="carousel-stage" x-data="teamCarousel()">
            <template x-for="(member, index) in team" :key="index">
                <div class="carousel-item" :class="getPosition(index)" @click="getPosition(index) !== 'active' ? goTo(index) : null">
                    <div class="floating-wrapper">
                        <div class="team-card">
                            <div class="card-header">
                                <img :src="member.photo" :alt="member.name" class="member-photo">
                            </div>
                            <div class="card-content" x-show="getPosition(index) === 'active'" x-transition.opacity.duration.500ms>
                                <h3 class="member-name" x-text="member.name"></h3>
                                <div class="member-role" x-text="member.role"></div>
                                <p class="member-bio" x-text="member.bio"></p>
                                <div class="member-skills">
                                    <template x-for="skill in member.skills" :key="skill">
                                        <div class="skill-tag" x-text="skill"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Project Section -->
        <div class="project-section">
            <h2 class="project-title">About ProjekTimer</h2>
            <p class="project-subtitle">
                A smart study timer application with personalized chronotype recommendations. Built with passion for helping students and professionals achieve their productivity goals through data-driven insights and beautiful design.
            </p>
            
            <div class="tech-grid">
                <div class="tech-card">
                    <div class="tech-icon">🚀</div>
                    <div class="tech-name">Laravel</div>
                </div>
                <div class="tech-card">
                    <div class="tech-icon">⚡</div>
                    <div class="tech-name">Alpine.js</div>
                </div>
                <div class="tech-card">
                    <div class="tech-icon">🎨</div>
                    <div class="tech-name">TailwindCSS</div>
                </div>
                <div class="tech-card">
                    <div class="tech-icon">📊</div>
                    <div class="tech-name">Chart.js</div>
                </div>
                <div class="tech-card">
                    <div class="tech-icon">🔧</div>
                    <div class="tech-name">MySQL</div>
                </div>
                <div class="tech-card">
                    <div class="tech-icon">🎯</div>
                    <div class="tech-name">Anime.js</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2026 ProjekTimer Team. Made with ❤️ for better study habits.</p>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('teamCarousel', () => ({
            currentIndex: 0,
            team: [
                {
                    name: 'Rusdiansyah Alief Prasetya',
                    role: 'Full-Stack Developer',
                    photo: '/images/team/testfoto.webp',
                    bio: 'Backend development, API design, and system architecture. Passionate about creating scalable and efficient solutions.',
                    skills: ['Laravel', 'PHP', 'MySQL', 'API Design']
                },
                {
                    name: 'Aisha Maryam',
                    role: 'Frontend Developer',
                    photo: '/images/team/aisha.jpeg',
                    bio: 'UI/UX design, interactive components, and user experience. Creating beautiful and intuitive interfaces that users love.',
                    skills: ['Vue.js', 'UI/UX', 'TailwindCSS', 'JavaScript']
                },
                {
                    name: 'Anindhita Faiza',
                    role: 'Data Science Developer',
                    photo: '/images/team/ninda.jpg',
                    bio: 'Chronotype algorithms, data analysis, and analytics implementation. Turning data into actionable insights for better productivity.',
                    skills: ['Python', 'Machine Learning', 'Data Analysis', 'Algorithms']
                },
                {
                    name: 'Shafa Rizwana Zarin',
                    role: 'Full-Stack Developer',
                    photo: '/images/team/shafa.jpg',
                    bio: 'Frontend-backend integration, database design, and feature development. Bridging the gap between design and functionality.',
                    skills: ['React', 'Database', 'Node.js', 'DevOps']
                }
            ],
            getPosition(index) {
                // On mobile, bypass 3D positioning
                if (window.innerWidth <= 768) return 'active';

                const N = this.team.length;
                const diff = (index - this.currentIndex + N) % N;
                
                if (diff === 0) return 'active';
                if (diff === 1) return 'next';
                if (diff === N - 1) return 'prev';
                return 'hidden';
            },
            goTo(index) {
                this.currentIndex = index;
            }
        }));
    });
</script>
