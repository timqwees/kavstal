<?php $site = Setting\route\function\Functions::site(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>КАВ СТАЛЬ — комплексное снабжение металлопрокатом | Металлопрокат с доставкой по Москве</title>
  <meta name="description"
    content="КАВ СТАЛЬ — комплексное снабжение металлопрокатом. Работаем с поставщиками по всей России, подбираем оптимальные условия по цене и срокам. Оставьте заявку — подберём материал под вашу задачу.">

  <meta property="og:title" content="КАВ СТАЛЬ — комплексное снабжение металлопрокатом">
  <meta property="og:description"
    content="Работаем с поставщиками по всей России, подбираем оптимальные условия по цене и срокам. Оставьте заявку — подберём материал под вашу задачу.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo $site['baseUrl']; ?>">
  <meta property="og:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="КАВ СТАЛЬ">
  <meta property="og:locale" content="ru_RU">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="КАВ СТАЛЬ | Снабжение металлопрокатом">
  <meta name="twitter:description" content="Поставки металлопроката по Москве и МО.">
  <meta name="twitter:image" content="<?php echo $site['baseUrl']; ?>/public/assets/images/bgpage/main.jpg">

  <meta name="robots" content="index, follow">
  <meta name="author" content="ООО 'КАВ Сталь'">
  <meta name="keywords" content="купить арматуру, металлопрокат с доставкой, поставки металлопроката москва">
  <link rel="canonical" href="<?php echo $site['baseUrl']; ?>/">

  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="dns-prefetch" href="https://yandex.ru">

  <link rel="icon" type="image/png"
    href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/svg+xml"
    href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.svg">
  <link rel="shortcut icon" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180"
    href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-title" content="Металл">
  <link rel="manifest" href="<?php echo $site['baseUrl']; ?>/public/assets/images/icons/favicon/site.webmanifest">
  <meta name="theme-color" content="#ef4444">

  <link rel="search" type="application/opensearchdescription+xml" title="КАВ СТАЛЬ"
    href="<?php echo $site['baseUrl']; ?>/opensearch.xml">
  <link rel="alternate" type="application/rss+xml" title="КАВ СТАЛЬ — Металлопрокат в Москве"
    href="<?php echo $site['baseUrl']; ?>/rss.xml">

  <?php include_once './public/components/seo-head.php'; ?>

  <!-- Structured Data -->
  <script
    type="application/ld+json">{"@context":"https://schema.org","@graph":[{"@type":"Organization","@id":"<?= $site['baseUrl'] ?>#contact","name":"КАВ СТАЛЬ","url":"<?= $site['baseUrl'] ?>","telephone":"+7-495-989-24-20","email":"<?= $site['email'] ?>","address":{"@type":"PostalAddress","streetAddress":"Семёновская площадь, 7","addressLocality":"Москва","addressRegion":"Московская область","postalCode":"115035","addressCountry":"RU"},"openingHours":"Mo-Su 09:00-18:00"},{"@type":"WebSite","@id":"<?= $site['baseUrl'] ?>#website","url":"<?= $site['baseUrl'] ?>","name":"КАВ СТАЛЬ","potentialAction":{"@type":"SearchAction","target":"<?= $site['baseUrl'] ?>/search?q={search_term_string}","query":"required name=search_term_string"}}]}</script>

  <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  </noscript>

  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  </noscript>

  <link rel="stylesheet" href="/public/assets/styles/tailwind.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
  <link rel="preload" href="/public/assets/styles/main.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="/public/assets/styles/main.css">
  </noscript>

  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js" defer></script>
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/css/intlTelInput.css" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/css/intlTelInput.css">
  </noscript>
  <style>
    .iti__selected-dial-code {
      color: #000;
    }

    .iti {
      width: 100%;
    }
  </style>
</head>

<body>

  <a href="#main-content"
    class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-red-500 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg">Перейти
    к основному содержанию</a>

  <?php include_once './public/components/header-shared.php'; ?>

  <main id="main-content">

    <!-- Breadcrumb -->
    <nav class="mt-2 bg-gray-50 border-b border-gray-200" aria-label="Breadcrumb">
      <div class="max-w-7xl mx-auto px-4 lg:px-8 py-2 flex items-center text-sm text-gray-500">
        <a href="/" class="hover:text-red-500 transition-colors" aria-label="Главная"><svg class="w-4 h-4 inline"
            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
          </svg></a>
        <svg class="w-3 h-3 mx-2 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="m9 18 6-6-6-6" />
        </svg>
        <span class="text-gray-900 font-medium">Комплексное снабжение металлопрокатом — КАВ СТАЛЬ</span>
      </div>
    </nav>

    <style>
      html {
        scroll-behavior: smooth;
      }

      .hero {
        position: relative;
        height: 90dvh;
        min-height: 600px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 45px;
        max-width: 98%;
        margin-inline: auto;
        margin-top: 20px;
        perspective: 1200px;
        transform-style: preserve-3d;
      }

      .hero-shape {
        position: absolute;
        inset: -40px;
        animation: scale-up-center 2200ms ease-out 600ms both;
        overflow: hidden;
        will-change: clip-path, transform;
        transition: transform 0.15s ease-out;
      }

      .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 1.8s ease, transform 8s ease;
        transform: scale(1);
      }

      .hero-img.active {
        opacity: 1;
        transform: scale(1.05);
      }

      .hero-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        position: absolute;
        top: 0;
        left: 0;
      }

      .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 40%, transparent 70%);
        z-index: 1;
        pointer-events: none;
      }

      .hero-glow {
        position: absolute;
        top: -20%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.12) 0%, transparent 65%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
        animation: glowPulse 6s ease-in-out infinite alternate;
      }

      @keyframes glowPulse {
        0% {
          opacity: 0.4;
          transform: scale(0.95);
        }

        100% {
          opacity: 0.8;
          transform: scale(1.08);
        }
      }

      .hero-shadow-left {
        position: absolute;
        left: 0;
        bottom: 28%;
        width: 55%;
        height: 50%;
        background: radial-gradient(ellipse at left center, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.35) 45%, transparent 70%);
        filter: blur(50px);
        pointer-events: none;
        opacity: 0;
        animation: fade-in 1500ms ease-out 1800ms both;
        z-index: 2;
      }

      .hero-shadow-bottom {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 30%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.35) 50%, transparent 100%);
        pointer-events: none;
        opacity: 0;
        animation: fade-in 1500ms ease-out 1800ms both;
        z-index: 2;
      }

      .hero-content {
        position: relative;
        z-index: 5;
        padding: 140px 60px 0;
        max-width: 800px;
        will-change: transform;
        transition: transform 0.12s ease-out;
      }

      .hero-label {
        display: block;
        font-size: 16px;
        font-weight: 500;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(20px);
      }

      .hero-title {
        font-size: clamp(32px, 4vw, 56px);
        font-weight: 700;
        line-height: 1.25;
        color: #fff;
        margin-bottom: 24px;
        word-break: normal;
        overflow-wrap: break-word;
        opacity: 0;
        transform: translateY(20px);
      }

      .hero-title span {
        display: block;
      }

      .hero-desc {
        font-size: 20px;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 36px;
        max-width: 520px;
        opacity: 0;
        transform: translateY(20px);
      }

      .accent {
        color: #fff;
        font-weight: 700;
      }

      .hero-actions {
        display: flex;
        align-items: center;
        gap: 24px;
        opacity: 0;
        transform: translateY(20px);
      }

      .hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border: 1.5px solid #fff;
        border-radius: 20px;
        background: #fff;
        color: #111;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s, color 0.3s, box-shadow 0.4s, transform 0.2s ease-out;
        text-decoration: none;
        position: relative;
        overflow: hidden;
      }

      .hero-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.4s;
      }

      .hero-cta:hover::before {
        opacity: 1;
      }

      .hero-cta:hover {
        background: transparent;
        color: #fff;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.15), 0 4px 20px rgba(0, 0, 0, 0.2);
      }

      .hero-cta-arrow {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s, transform 0.3s;
      }

      .hero-cta:hover .hero-cta-arrow {
        background: #fff;
        transform: translateX(4px);
      }

      .hero-cta:hover .hero-cta-arrow svg {
        stroke: #111;
      }

      .hero-cta-arrow svg {
        width: 14px;
        height: 14px;
        stroke: #fff;
      }

      .hero-link {
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        border: 1.5px solid #fff;
        border-radius: 20px;
        padding: 18px 32px;
        min-width: 220px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s, opacity 0.3s;
      }

      .hero-link:hover {
        background: #111;
        border-color: #111;
      }

      .hero-link-arrow {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        transition: background 0.3s, transform 0.3s;
      }

      .hero-link:hover .hero-link-arrow {
        background: #fff;
        transform: translateX(4px);
      }

      .hero-link:hover .hero-link-arrow svg {
        stroke: #111;
      }

      .hero-link-arrow svg {
        width: 12px;
        height: 12px;
        stroke: #111;
      }

      .hero-stats {
        position: relative;
        z-index: 5;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        background: rgba(0, 0, 0, 0.15);
        will-change: transform;
        transition: transform 0.12s ease-out;
      }

      .hero-stat {
        padding: 32px 60px;
        border-right: 1px solid rgba(255, 255, 255, 0.15);
        opacity: 0;
        transform: translateY(30px);
      }

      .hero-stat:last-child {
        border-right: none;
      }

      .hero-stat-value {
        font-size: 40px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 6px;
      }

      .hero-stat-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
      }

      @media (max-width: 900px) {
        .hero {
          border-radius: 10px;
          height: 100%;
        }

        .hero-content {
          padding: 120px 32px 0;
          max-width: 100%;
        }

        .hero-title {
          font-size: 38px;
        }

        .hero-stat {
          padding: 24px 32px;
        }

        .hero-stat-value {
          font-size: 32px;
        }

        .hero-glow {
          width: 300px;
          height: 300px;
        }

        .hero-scroll {
          display: none;
        }
      }

      @media (max-width: 600px) {
        .hero-content {
          padding: 100px 20px 0;
        }

        .hero-title {
          font-size: 30px;
        }

        .hero-desc {
          font-size: 14px;
        }

        .hero-actions {
          flex-direction: column;
          align-items: stretch;
          gap: 12px;
        }

        .hero-cta,
        .hero-link {
          justify-content: center;
          min-width: 0;
        }

        .hero-stats {
          grid-template-columns: 1fr;
          margin-top: 30px;
        }

        .hero-stat {
          border-right: none;
          border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .hero-stat:last-child {
          border-bottom: none;
        }

        .hero-stat-value {
          font-size: 28px;
        }

        .hero-cta {
          padding: 12px 24px;
        }

        .hero-link {
          padding: 12px 24px;
        }

        .hero-scroll {
          display: none;
        }
      }

      @keyframes scale-up-center {
        0% {
          clip-path: inset(48% 47% 48% 47% round 50%);
          filter: blur(12px);
        }

        25% {
          clip-path: inset(12% 45% 12% 45% round 50%);
          filter: blur(2px);
        }

        55% {
          clip-path: inset(5% 12% 5% 12% round 40px);
          filter: blur(0);
        }

        100% {
          clip-path: inset(0 round 0);
        }
      }

      @keyframes fade-up {
        0% {
          opacity: 0;
          transform: translateY(30px);
        }

        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }

      @keyframes fade-in {
        0% {
          opacity: 0;
        }

        100% {
          opacity: 1;
        }
      }
    </style>

    <section class="hero">
      <div class="hero-shape">
        <img class="hero-img active" src="/public/assets/images/bgpage/hero/bg.jpeg" alt="" data-slide="0">
        <!-- <video class="hero-video" src="https://khoper.ru/upload/iblock/cfb/4q2lepajajkmypu2qa7d9xw33y6r6qwm.mp4"
          autoplay muted loop playsinline></video> -->
      </div>
      <div class="hero-overlay"></div>
      <div class="hero-glow"></div>
      <div class="hero-shadow-left"></div>
      <div class="hero-shadow-bottom"></div>

      <div class="hero-content">
        <span class="hero-label">КОМПЛЕКСНОЕ СНАБЖЕНИЕ МЕТАЛЛОПРОКАТОМ</span>
        <h1 class="hero-title">
          <span>КАВ Сталь — качество, амбиции, возможности</span>
        </h1>
        <p class="hero-desc">Организуем комплектацию заявок, металлообработку
          по техническому заданию и доставку продукции по всей территории России.</p>
        <div class="hero-actions">
          <a href="#spec" class="hero-cta" id="heroCta"
            onclick="event.preventDefault();document.getElementById('specOverlay').classList.add('show');document.getElementById('specModal').classList.add('show');">
            Получить предложение
            <span class="hero-cta-arrow">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
            </span>
          </a>
          <a href="/market" class="hero-link">
            Перейти в каталог
          </a>
        </div>
      </div>

      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-value" data-count="80" data-suffix="" data-presuffix="Более "></div>
          <div class="hero-stat-label">юридических и физических лиц доверили нам поставку металлопроката и комплектующих</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-value" data-count="7" data-suffix=" из 10" data-presuffix=""></div>
          <div class="hero-stat-label">компаний делают повторный заказ</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-value" data-count="16000" data-suffix="" data-presuffix="Более "></div>
          <div class="hero-stat-label">наименований металлопроката и комплектующих можем поставить</div>
        </div>
      </div>
    </section>

    <script>
      // Hero img slideshow — закомментировано, используется видео
      // (function () {
      //   var imgs = document.querySelectorAll('.hero-img');
      //   if (imgs.length < 2) return;
      //   var current = 0;
      //   setInterval(function () {
      //     imgs[current].classList.remove('active');
      //     current = (current + 1) % imgs.length;
      //     imgs[current].classList.add('active');
      //   }, 6000);
      // })();
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);

        var hero = document.querySelector('.hero');
        if (!hero) return;

        /* ── Entrance timeline ── */
        var tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.to('.hero-label', { y: 0, opacity: 1, duration: 0.6, delay: 0.3 })
          .to('.hero-title', { y: 0, opacity: 1, duration: 0.8 }, '-=0.3')
          .to('.hero-desc', { y: 0, opacity: 1, duration: 0.8 }, '-=0.3')
          .to('.hero-actions', { y: 0, opacity: 1, duration: 0.8 }, '-=0.5')
          .to('.hero-stat', {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.15
          }, '-=0.4');

        /* ── Stat counters ── */
        document.querySelectorAll('.hero-stat-value').forEach(function (el) {
          var target = parseInt(el.getAttribute('data-count'), 10);
          var suffix = el.getAttribute('data-suffix') || '';
          var presuffix = el.getAttribute('data-presuffix') || '';
          var obj = { val: 0 };
          gsap.to(obj, {
            val: target,
            duration: 2,
            delay: 1.8,
            ease: 'power2.out',
            onUpdate: function () {
              el.textContent = presuffix + Math.round(obj.val) + suffix;
            }
          });
        });

        /* ── Scroll parallax ── */
        gsap.to(hero, {
          yPercent: 15,
          opacity: 0,
          ease: 'none',
          scrollTrigger: {
            trigger: hero,
            start: 'top top',
            end: 'bottom top',
            scrub: true,
          }
        });

        var shape = document.querySelector('.hero-shape');
        var content = document.querySelector('.hero-content');
        var stats = document.querySelector('.hero-stats');

        if (shape) {
          gsap.to(shape, {
            yPercent: 10,
            scale: 1.08,
            ease: 'none',
            scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
          });
        }

        if (content) {
          gsap.to(content, {
            y: -80,
            opacity: 0,
            ease: 'none',
            scrollTrigger: { trigger: hero, start: '20% top', end: '70% top', scrub: true }
          });
        }

        if (stats) {
          gsap.to(stats, {
            y: -40,
            opacity: 0,
            ease: 'none',
            scrollTrigger: { trigger: hero, start: '30% top', end: '80% top', scrub: true }
          });
        }
      });
    </script>

    <!-- Project assets -->
    <svg aria-hidden="true" style="position:absolute;width:0;height:0;overflow:hidden"
      xmlns="http://www.w3.org/2000/svg">
      <defs>
        <symbol id="logo" viewBox="0 0 40 32">
          <path
            d="M16.463 31.448v-5.12l-.132-.839v-8.563c0-1.971-.559-3.487-1.677-4.546-1.089-1.059-2.722-1.589-4.899-1.589-1.501 0-2.928.25-4.281.75s-2.501 1.162-3.443 1.986L.619 11.188c1.177-1 2.589-1.766 4.237-2.295a16.102 16.102 0 0 1 5.208-.839c3.001 0 5.311.75 6.93 2.251 1.648 1.471 2.472 3.722 2.472 6.753v14.389h-3.001zm-7.989.221c-1.736 0-3.252-.28-4.546-.839-1.265-.589-2.236-1.383-2.913-2.383C.338 27.417 0 26.24 0 24.916c0-1.206.28-2.295.839-3.266.589-1 1.53-1.795 2.825-2.383 1.324-.618 3.09-.927 5.297-.927h7.989v2.339H9.049c-2.236 0-3.796.397-4.679 1.192-.853.794-1.28 1.78-1.28 2.957 0 1.324.515 2.383 1.545 3.178s2.472 1.192 4.326 1.192c1.766 0 3.281-.397 4.546-1.192 1.295-.824 2.236-2.001 2.825-3.531l.706 2.163c-.589 1.53-1.618 2.751-3.09 3.663-1.442.912-3.266 1.368-5.473 1.368z" />
          <path
            d="M29.44 31.669c-2.413 0-4.531-.5-6.356-1.501-1.824-1.03-3.251-2.428-4.281-4.193-1.03-1.795-1.545-3.84-1.545-6.135s.486-4.326 1.457-6.091c1-1.766 2.354-3.149 4.061-4.149 1.736-1.03 3.678-1.545 5.826-1.545 2.178 0 4.105.5 5.782 1.501 1.707.971 3.046 2.354 4.017 4.149.971 1.766 1.457 3.811 1.457 6.135 0 .147-.015.309-.044.486v.486H19.643v-2.339h18.494l-1.236.927c0-1.677-.368-3.163-1.103-4.458-.706-1.324-1.677-2.354-2.913-3.09s-2.663-1.103-4.281-1.103c-1.589 0-3.016.368-4.281 1.103s-2.251 1.766-2.957 3.09c-.706 1.324-1.059 2.84-1.059 4.546v.486c0 1.766.383 3.325 1.148 4.679a8.571 8.571 0 0 0 3.266 3.134c1.412.736 3.016 1.103 4.811 1.103 1.412 0 2.722-.25 3.928-.75a8.169 8.169 0 0 0 3.178-2.295l1.766 2.03c-1.03 1.236-2.325 2.177-3.884 2.825-1.53.647-3.222.971-5.076.971zM37.296 3.31H21.848V0h15.448v3.31z" />
        </symbol>
        <symbol id="tel" viewBox="0 0 32 32">
          <path
            d="m26.332 6.267-3.347-3.344a2.16 2.16 0 0 0-3.068 0l-3.605 3.598a2.167 2.167 0 0 0 0 3.074l2.816 2.819a12.745 12.745 0 0 1-2.715 4 12.75 12.75 0 0 1-3.998 2.721l-2.816-2.819a2.164 2.164 0 0 0-3.068-.001l-3.608 3.598a2.166 2.166 0 0 0-.638 1.537c0 .581.226 1.125.638 1.537l3.344 3.344a3.762 3.762 0 0 0 2.646 1.097c.204 0 .402-.016.603-.05 4.161-.685 8.291-2.9 11.625-6.232 3.331-3.337 5.544-7.466 6.235-11.63a3.743 3.743 0 0 0-1.047-3.249zM25.15 9.143c-.613 3.705-2.605 7.401-5.607 10.402s-6.694 4.993-10.4 5.606a1.477 1.477 0 0 1-1.282-.415l-3.284-3.284 3.482-3.485 3.793 3.799.679-.251a15.128 15.128 0 0 0 8.979-8.982l.251-.679-3.797-3.793 3.482-3.485L24.73 7.86c.339.339.497.817.418 1.282z" />
        </symbol>
        <symbol id="btn-txt" viewBox="0 0 32 32">
          <path
            d="M15.192 3.749c-0.157 0.010-0.301-0.017-0.433-0.081-0.111-0.056-0.205-0.134-0.282-0.236l0.063 1.015-0.246 0.015-0.154-2.49 0.236-0.015 0.022 0.357c0.064-0.119 0.149-0.214 0.257-0.284 0.123-0.079 0.264-0.124 0.423-0.134 0.173-0.011 0.33 0.019 0.471 0.089 0.143 0.068 0.258 0.169 0.346 0.305 0.087 0.134 0.136 0.292 0.148 0.474 0.011 0.185-0.018 0.349-0.088 0.492s-0.172 0.259-0.305 0.346c-0.131 0.087-0.284 0.136-0.457 0.146zM15.161 3.532c0.129-0.008 0.243-0.044 0.341-0.108 0.098-0.066 0.174-0.154 0.227-0.264 0.053-0.112 0.076-0.239 0.067-0.38s-0.046-0.263-0.113-0.365c-0.067-0.103-0.153-0.181-0.258-0.234s-0.223-0.077-0.352-0.069c-0.129 0.008-0.244 0.045-0.344 0.112-0.098 0.066-0.174 0.154-0.227 0.264-0.051 0.11-0.072 0.235-0.064 0.376s0.045 0.264 0.11 0.369c0.067 0.103 0.153 0.181 0.258 0.234 0.107 0.051 0.226 0.073 0.355 0.065z">
          </path>
          <path
            d="M12.461 4.088c0.155 0.044 0.319 0.045 0.49 0.004 0.173-0.041 0.319-0.117 0.438-0.226 0.118-0.111 0.2-0.244 0.244-0.397 0.046-0.156 0.048-0.322 0.006-0.497-0.042-0.178-0.119-0.325-0.23-0.441-0.109-0.117-0.241-0.197-0.396-0.241-0.153-0.044-0.318-0.046-0.493-0.004-0.173 0.041-0.318 0.116-0.435 0.225s-0.198 0.24-0.245 0.394c-0.047 0.154-0.049 0.32-0.006 0.497 0.042 0.175 0.119 0.322 0.23 0.441 0.111 0.116 0.243 0.198 0.397 0.244zM13.221 3.714c-0.086 0.080-0.193 0.135-0.321 0.166-0.124 0.030-0.242 0.028-0.354-0.005-0.113-0.035-0.211-0.097-0.294-0.187-0.084-0.092-0.142-0.206-0.175-0.344-0.033-0.139-0.033-0.268 0.001-0.385s0.094-0.216 0.179-0.296c0.085-0.082 0.191-0.138 0.317-0.168s0.245-0.028 0.358 0.007c0.112 0.033 0.209 0.094 0.29 0.184 0.083 0.090 0.141 0.204 0.175 0.344 0.033 0.137 0.033 0.266-0.001 0.385-0.032 0.117-0.090 0.216-0.175 0.299z">
          </path>
          <path
            d="M10.256 3.046c0.136-0.059 0.266-0.083 0.391-0.074 0.126 0.006 0.241 0.050 0.344 0.131 0.105 0.080 0.193 0.201 0.263 0.363l0.42 0.972-0.226 0.098-0.41-0.949c-0.076-0.176-0.178-0.29-0.306-0.34-0.127-0.054-0.269-0.046-0.429 0.023-0.119 0.051-0.212 0.121-0.281 0.208-0.067 0.084-0.105 0.183-0.114 0.295-0.008 0.109 0.015 0.228 0.070 0.355l0.38 0.879-0.226 0.098-1.021-2.364 0.226-0.098 0.423 0.98c0.017-0.104 0.058-0.201 0.124-0.29 0.087-0.121 0.21-0.216 0.372-0.285z">
          </path>
          <path
            d="M8.793 5.882c0.136-0.036 0.267-0.095 0.394-0.175 0.135-0.085 0.238-0.175 0.31-0.269 0.072-0.098 0.113-0.194 0.121-0.29 0.009-0.099-0.015-0.193-0.072-0.283-0.053-0.084-0.114-0.14-0.184-0.167-0.069-0.031-0.142-0.040-0.22-0.030-0.077 0.008-0.157 0.027-0.239 0.057-0.082 0.027-0.162 0.057-0.242 0.091-0.078 0.033-0.153 0.059-0.224 0.080-0.071 0.017-0.136 0.021-0.194 0.012-0.056-0.011-0.103-0.046-0.14-0.105-0.047-0.074-0.053-0.155-0.018-0.243 0.036-0.091 0.123-0.18 0.262-0.268 0.078-0.049 0.163-0.088 0.255-0.116 0.091-0.030 0.185-0.043 0.283-0.039l-0.015-0.225c-0.092-0.002-0.195 0.015-0.311 0.053-0.117 0.036-0.225 0.085-0.325 0.148-0.131 0.083-0.23 0.173-0.297 0.27-0.067 0.094-0.102 0.189-0.107 0.285s0.019 0.186 0.072 0.27c0.056 0.088 0.118 0.147 0.186 0.178 0.070 0.029 0.145 0.041 0.223 0.035 0.077-0.008 0.156-0.026 0.236-0.055 0.082-0.030 0.163-0.062 0.243-0.096s0.155-0.061 0.224-0.080c0.069-0.021 0.131-0.027 0.187-0.016 0.057 0.008 0.103 0.040 0.139 0.097 0.048 0.076 0.055 0.158 0.020 0.246-0.036 0.086-0.128 0.175-0.274 0.267-0.108 0.068-0.221 0.116-0.34 0.145-0.12 0.027-0.226 0.036-0.318 0.029l0.010 0.224c0.099 0.014 0.217 0.004 0.354-0.031z">
          </path>
          <path
            d="M6.277 8.194l-1.788-0.77 0.164-0.17 1.51 0.662-0.705-1.496 0.147-0.152 1.517 0.655-0.71-1.492 0.157-0.162 0.832 1.761-0.161 0.167-1.475-0.624 0.675 1.453-0.161 0.167z">
          </path>
          <path
            d="M4.945 9.927c0.143-0.076 0.262-0.188 0.357-0.335 0.097-0.15 0.15-0.305 0.161-0.466 0.009-0.162-0.024-0.314-0.098-0.456-0.075-0.145-0.188-0.266-0.339-0.364-0.153-0.099-0.31-0.153-0.471-0.16-0.159-0.009-0.31 0.024-0.453 0.1-0.141 0.074-0.261 0.187-0.359 0.338-0.097 0.15-0.15 0.304-0.159 0.463s0.022 0.311 0.095 0.454c0.073 0.143 0.186 0.265 0.339 0.364 0.152 0.098 0.309 0.151 0.471 0.16 0.161 0.007 0.312-0.025 0.456-0.098zM5.236 9.132c-0.007 0.117-0.046 0.231-0.117 0.341-0.069 0.107-0.156 0.187-0.259 0.241-0.106 0.053-0.22 0.076-0.342 0.068-0.124-0.009-0.245-0.051-0.364-0.128-0.12-0.078-0.209-0.171-0.266-0.279s-0.082-0.221-0.075-0.338c0.005-0.118 0.042-0.232 0.113-0.34s0.158-0.19 0.264-0.242c0.104-0.054 0.216-0.076 0.337-0.067 0.122 0.007 0.243 0.050 0.364 0.128 0.119 0.077 0.207 0.17 0.266 0.279 0.058 0.106 0.085 0.219 0.080 0.337z">
          </path>
          <path
            d="M2.613 10.728c0.058-0.136 0.135-0.244 0.231-0.324 0.095-0.083 0.208-0.13 0.339-0.143 0.132-0.015 0.279 0.012 0.441 0.081l0.975 0.412-0.096 0.227-0.952-0.403c-0.177-0.075-0.329-0.086-0.456-0.035-0.129 0.049-0.227 0.153-0.294 0.313-0.050 0.119-0.070 0.234-0.059 0.344 0.010 0.107 0.050 0.205 0.121 0.292 0.070 0.085 0.168 0.154 0.296 0.208l0.882 0.373-0.096 0.227-1.678-0.71 0.092-0.217 0.305 0.129c-0.067-0.091-0.108-0.194-0.123-0.312-0.021-0.147 0.003-0.301 0.072-0.463z">
          </path>
          <path
            d="M3.292 14.916c0.090-0.115 0.146-0.251 0.169-0.407 0.025-0.172 0.009-0.331-0.049-0.477-0.058-0.149-0.149-0.272-0.275-0.37s-0.28-0.16-0.463-0.187c-0.181-0.027-0.346-0.011-0.494 0.046-0.151 0.057-0.275 0.149-0.37 0.275-0.098 0.124-0.159 0.271-0.185 0.443-0.023 0.158-0.009 0.305 0.044 0.441 0.046 0.12 0.121 0.223 0.224 0.31l-0.354-0.052-0.034 0.233 2.468 0.363 0.036-0.244-1.006-0.148c0.116-0.055 0.212-0.131 0.29-0.227zM3.206 14.139c0.042 0.109 0.054 0.228 0.035 0.356s-0.065 0.24-0.137 0.334c-0.074 0.092-0.169 0.16-0.283 0.204-0.116 0.041-0.244 0.052-0.383 0.031s-0.258-0.067-0.355-0.14c-0.097-0.075-0.167-0.167-0.212-0.277-0.044-0.112-0.057-0.232-0.038-0.36s0.066-0.238 0.14-0.33c0.074-0.092 0.169-0.16 0.283-0.204s0.241-0.056 0.381-0.035c0.14 0.021 0.259 0.068 0.358 0.144 0.096 0.075 0.167 0.167 0.212 0.277z">
          </path>
          <path
            d="M3.326 16.821c0.005 0.176-0.030 0.335-0.105 0.478-0.077 0.141-0.184 0.254-0.321 0.338-0.139 0.085-0.299 0.13-0.479 0.134-0.183 0.005-0.344-0.031-0.485-0.108s-0.253-0.184-0.335-0.321c-0.082-0.137-0.126-0.294-0.131-0.472-0.005-0.18 0.030-0.341 0.105-0.482 0.075-0.143 0.181-0.256 0.317-0.338 0.137-0.085 0.296-0.13 0.479-0.134 0.18-0.005 0.342 0.031 0.485 0.108 0.141 0.075 0.254 0.182 0.338 0.321 0.082 0.139 0.126 0.297 0.131 0.476zM3.108 16.827c-0.004-0.132-0.036-0.248-0.096-0.348-0.063-0.1-0.148-0.178-0.256-0.233-0.11-0.057-0.236-0.084-0.377-0.080-0.143 0.004-0.267 0.037-0.372 0.1-0.105 0.061-0.185 0.143-0.24 0.246-0.057 0.103-0.084 0.22-0.081 0.349s0.037 0.244 0.1 0.344c0.061 0.1 0.145 0.179 0.253 0.236s0.234 0.084 0.377 0.080c0.141-0.004 0.265-0.037 0.372-0.1 0.105-0.063 0.186-0.146 0.243-0.25 0.055-0.103 0.081-0.219 0.077-0.346z">
          </path>
          <path
            d="M28.75 16.696c-0.049 0.132-0.078 0.272-0.087 0.422-0.009 0.159 0.004 0.296 0.039 0.409 0.037 0.116 0.092 0.205 0.165 0.267 0.075 0.065 0.166 0.1 0.272 0.106 0.099 0.006 0.18-0.012 0.243-0.052 0.065-0.038 0.115-0.092 0.152-0.162 0.039-0.067 0.070-0.143 0.093-0.227 0.025-0.082 0.048-0.165 0.067-0.25 0.019-0.082 0.040-0.159 0.065-0.229 0.027-0.068 0.062-0.123 0.104-0.164 0.042-0.039 0.097-0.057 0.166-0.053 0.088 0.005 0.157 0.047 0.208 0.127 0.053 0.082 0.075 0.205 0.066 0.369-0.005 0.092-0.024 0.184-0.054 0.275-0.029 0.091-0.073 0.175-0.133 0.253l0.191 0.119c0.055-0.073 0.101-0.168 0.138-0.284 0.039-0.116 0.062-0.233 0.069-0.351 0.009-0.155-0.007-0.288-0.046-0.399-0.038-0.109-0.094-0.193-0.169-0.253s-0.163-0.093-0.262-0.099c-0.104-0.006-0.188 0.010-0.253 0.048-0.065 0.040-0.118 0.094-0.159 0.161-0.039 0.067-0.070 0.142-0.093 0.224-0.024 0.084-0.045 0.169-0.063 0.254s-0.041 0.161-0.065 0.229c-0.023 0.068-0.055 0.122-0.096 0.161-0.039 0.042-0.093 0.061-0.16 0.057-0.090-0.005-0.161-0.048-0.212-0.127-0.049-0.079-0.068-0.206-0.058-0.379 0.008-0.127 0.034-0.247 0.080-0.36 0.048-0.113 0.102-0.205 0.162-0.276l-0.188-0.122c-0.069 0.072-0.129 0.174-0.181 0.306z">
          </path>
          <path
            d="M30.043 19.858c0.080-0.096 0.135-0.217 0.166-0.362 0.037-0.172 0.031-0.328-0.017-0.469-0.035-0.106-0.089-0.196-0.165-0.27l1.044 0.224 0.052-0.241-2.517-0.54-0.052 0.241 0.936 0.201c0.136 0.029 0.246 0.079 0.33 0.149 0.086 0.073 0.144 0.161 0.174 0.264 0.032 0.106 0.034 0.223 0.007 0.349-0.036 0.17-0.113 0.29-0.23 0.362-0.115 0.075-0.267 0.092-0.455 0.051l-1.011-0.217-0.052 0.241 1.035 0.222c0.172 0.037 0.321 0.036 0.448-0.003 0.126-0.037 0.228-0.105 0.306-0.204z">
          </path>
          <path
            d="M27.766 21.145c0.067-0.163 0.163-0.295 0.29-0.395 0.128-0.098 0.271-0.158 0.43-0.18 0.161-0.021 0.325 0.002 0.492 0.071 0.169 0.069 0.302 0.168 0.4 0.295s0.157 0.27 0.177 0.429c0.020 0.158-0.003 0.32-0.071 0.485-0.068 0.167-0.165 0.3-0.291 0.398-0.126 0.101-0.269 0.161-0.427 0.181-0.159 0.022-0.323-0.001-0.492-0.071-0.167-0.068-0.3-0.167-0.4-0.295-0.099-0.125-0.158-0.269-0.18-0.43-0.019-0.16 0.005-0.323 0.072-0.488zM27.969 21.228c-0.050 0.122-0.068 0.241-0.053 0.357 0.017 0.117 0.064 0.222 0.14 0.316 0.078 0.097 0.182 0.172 0.312 0.226 0.133 0.054 0.26 0.074 0.381 0.059 0.12-0.013 0.227-0.056 0.319-0.128 0.094-0.071 0.166-0.167 0.215-0.287s0.065-0.238 0.048-0.355c-0.015-0.116-0.060-0.222-0.136-0.318s-0.18-0.171-0.313-0.226c-0.131-0.054-0.258-0.073-0.381-0.059-0.121 0.015-0.229 0.059-0.323 0.13-0.092 0.072-0.162 0.167-0.21 0.285z">
          </path>
          <path
            d="M27.034 22.887c-0.129 0.069-0.235 0.17-0.319 0.303-0.093 0.147-0.142 0.299-0.148 0.456-0.008 0.159 0.026 0.309 0.102 0.45s0.191 0.26 0.348 0.359c0.155 0.098 0.312 0.15 0.471 0.158 0.161 0.009 0.311-0.025 0.45-0.102 0.139-0.073 0.255-0.184 0.348-0.33 0.085-0.135 0.131-0.275 0.139-0.421 0.006-0.128-0.020-0.253-0.080-0.374l0.302 0.191 0.126-0.2-2.11-1.331-0.131 0.208 0.86 0.542c-0.128 0.003-0.247 0.034-0.357 0.091zM26.797 23.632c0.005-0.117 0.043-0.23 0.112-0.34s0.156-0.193 0.26-0.25c0.105-0.054 0.219-0.078 0.341-0.072 0.123 0.009 0.244 0.051 0.363 0.127s0.208 0.166 0.268 0.272c0.058 0.108 0.085 0.221 0.082 0.339-0.005 0.12-0.042 0.235-0.111 0.344s-0.156 0.191-0.262 0.245c-0.105 0.054-0.219 0.078-0.341 0.072s-0.243-0.046-0.362-0.122-0.209-0.167-0.269-0.276c-0.058-0.108-0.085-0.221-0.082-0.339z">
          </path>
          <path
            d="M25.988 26.966c-0.107 0.102-0.221 0.17-0.342 0.205-0.12 0.038-0.243 0.036-0.368-0.004-0.127-0.039-0.251-0.123-0.372-0.25l-0.729-0.767 0.178-0.17 0.712 0.749c0.132 0.139 0.267 0.21 0.404 0.214 0.137 0.007 0.269-0.050 0.395-0.169 0.094-0.089 0.158-0.187 0.191-0.292 0.034-0.102 0.036-0.208 0.006-0.317-0.030-0.105-0.093-0.208-0.189-0.309l-0.66-0.694 0.178-0.17 1.255 1.32-0.171 0.163-0.228-0.24c0.025 0.11 0.021 0.221-0.012 0.335-0.040 0.143-0.123 0.275-0.251 0.396z">
          </path>
          <path
            d="M23.523 26.771c-0.161 0.013-0.315 0.068-0.461 0.166-0.148 0.099-0.259 0.22-0.333 0.364-0.072 0.146-0.103 0.298-0.091 0.457 0.011 0.162 0.067 0.318 0.167 0.469 0.102 0.152 0.225 0.263 0.369 0.334 0.142 0.072 0.294 0.101 0.455 0.088 0.159-0.012 0.314-0.068 0.464-0.168 0.148-0.099 0.258-0.22 0.33-0.362s0.103-0.294 0.093-0.454c-0.010-0.16-0.065-0.317-0.167-0.469-0.1-0.15-0.223-0.261-0.369-0.334-0.145-0.070-0.297-0.101-0.457-0.091zM22.94 27.385c0.053-0.104 0.134-0.194 0.243-0.267 0.106-0.071 0.217-0.11 0.334-0.119 0.118-0.007 0.232 0.018 0.341 0.073 0.11 0.057 0.205 0.144 0.283 0.262 0.080 0.119 0.124 0.24 0.133 0.362s-0.013 0.235-0.065 0.34c-0.051 0.106-0.131 0.196-0.238 0.268s-0.221 0.111-0.339 0.118c-0.117 0.008-0.229-0.015-0.336-0.072-0.109-0.055-0.204-0.142-0.283-0.262-0.078-0.117-0.123-0.238-0.133-0.362-0.011-0.121 0.009-0.234 0.060-0.341z">
          </path>
          <path
            d="M21.597 27.832l1.332 1.42-0.218 0.090-1.12-1.21 0.049 1.653-0.196 0.081-1.129-1.207 0.055 1.651-0.208 0.086-0.059-1.947 0.215-0.089 1.103 1.161-0.038-1.602 0.215-0.089z">
          </path>
          <path
            d="M18.329 28.941c-0.139-0.022-0.283-0.021-0.431 0.001-0.158 0.023-0.289 0.063-0.393 0.121-0.106 0.060-0.182 0.132-0.228 0.216-0.048 0.087-0.064 0.183-0.049 0.288 0.015 0.099 0.048 0.174 0.1 0.227 0.050 0.056 0.113 0.094 0.189 0.116 0.074 0.024 0.154 0.039 0.242 0.045 0.085 0.008 0.172 0.013 0.258 0.015 0.084 0.002 0.164 0.007 0.238 0.018 0.072 0.013 0.133 0.035 0.182 0.068 0.047 0.033 0.075 0.084 0.086 0.152 0.013 0.087-0.014 0.163-0.082 0.23-0.069 0.069-0.185 0.115-0.348 0.139-0.092 0.014-0.185 0.014-0.28 0.003-0.095-0.009-0.186-0.035-0.275-0.079l-0.078 0.211c0.083 0.039 0.185 0.065 0.306 0.078 0.121 0.015 0.241 0.014 0.357-0.003 0.153-0.023 0.28-0.065 0.381-0.126 0.099-0.059 0.17-0.131 0.213-0.217s0.058-0.178 0.043-0.276c-0.015-0.103-0.048-0.182-0.098-0.238-0.053-0.056-0.116-0.096-0.19-0.123-0.074-0.024-0.153-0.040-0.238-0.046-0.087-0.006-0.174-0.009-0.261-0.011s-0.166-0.007-0.238-0.018c-0.071-0.008-0.131-0.029-0.177-0.061-0.049-0.030-0.078-0.079-0.088-0.145-0.013-0.089 0.014-0.167 0.081-0.233 0.068-0.064 0.187-0.108 0.359-0.134 0.126-0.019 0.249-0.017 0.369 0.005 0.12 0.024 0.221 0.059 0.303 0.103l0.081-0.209c-0.085-0.053-0.197-0.091-0.336-0.115z">
          </path>
          <path
            d="M15.845 30.938c-0.148-0.001-0.277-0.031-0.388-0.090-0.113-0.056-0.2-0.143-0.262-0.259-0.064-0.116-0.095-0.262-0.094-0.438l0.008-1.058 0.246 0.002-0.008 1.034c-0.001 0.192 0.046 0.337 0.142 0.435 0.094 0.1 0.228 0.151 0.401 0.152 0.13 0.001 0.243-0.025 0.341-0.077 0.095-0.050 0.17-0.125 0.224-0.224 0.052-0.097 0.078-0.215 0.079-0.353l0.007-0.958 0.246 0.002-0.020 2.574-0.246-0.002 0.008-1.067c-0.057 0.088-0.134 0.16-0.231 0.216-0.128 0.075-0.28 0.112-0.455 0.111z">
          </path>
          <path
            d="M14.206 29.086c-0.125-0.103-0.273-0.17-0.446-0.201-0.175-0.032-0.339-0.022-0.492 0.030-0.153 0.054-0.281 0.143-0.384 0.265-0.105 0.124-0.174 0.275-0.206 0.453-0.033 0.18-0.022 0.345 0.033 0.496 0.052 0.151 0.141 0.277 0.266 0.38 0.122 0.102 0.272 0.17 0.45 0.202 0.175 0.032 0.338 0.022 0.489-0.031s0.278-0.14 0.383-0.262c0.105-0.122 0.173-0.273 0.206-0.453 0.032-0.178 0.022-0.343-0.033-0.496-0.055-0.151-0.143-0.279-0.265-0.384zM13.36 29.122c0.111-0.039 0.231-0.046 0.36-0.022 0.125 0.023 0.233 0.072 0.322 0.147 0.089 0.078 0.154 0.174 0.194 0.29 0.040 0.118 0.047 0.246 0.021 0.385-0.026 0.141-0.078 0.259-0.156 0.352s-0.173 0.16-0.283 0.199c-0.111 0.041-0.23 0.050-0.358 0.026s-0.236-0.074-0.325-0.151c-0.090-0.075-0.153-0.17-0.191-0.285-0.040-0.115-0.047-0.244-0.021-0.385 0.025-0.139 0.077-0.256 0.156-0.353 0.076-0.094 0.169-0.162 0.28-0.203z">
          </path>
          <path
            d="M11.543 28.277c0.148 0.055 0.268 0.138 0.363 0.249 0.079 0.096 0.133 0.206 0.162 0.33l0.354-0.953 0.231 0.086-0.868 2.339-0.221-0.082 0.124-0.335c-0.106 0.083-0.223 0.135-0.35 0.155-0.144 0.023-0.291 0.007-0.441-0.049-0.163-0.060-0.294-0.151-0.395-0.272-0.104-0.12-0.168-0.259-0.192-0.419-0.025-0.157-0.006-0.322 0.057-0.493 0.064-0.174 0.158-0.312 0.28-0.414s0.262-0.167 0.419-0.192c0.155-0.026 0.314-0.009 0.477 0.051zM11.484 28.488c-0.121-0.045-0.24-0.058-0.355-0.040-0.116 0.021-0.221 0.071-0.315 0.15-0.094 0.081-0.166 0.188-0.215 0.32s-0.064 0.259-0.045 0.38 0.066 0.227 0.141 0.319c0.075 0.092 0.172 0.16 0.294 0.205s0.241 0.057 0.36 0.037c0.116-0.021 0.221-0.071 0.315-0.15 0.091-0.080 0.161-0.186 0.21-0.318s0.065-0.259 0.049-0.381c-0.019-0.121-0.066-0.227-0.141-0.319-0.078-0.090-0.177-0.158-0.298-0.203z">
          </path>
          <path
            d="M7.427 28.042c0.058 0.111 0.148 0.209 0.27 0.293 0.144 0.1 0.291 0.155 0.439 0.165 0.118 0.009 0.228-0.009 0.33-0.056l-0.189 0.272 0.194 0.135 1.039-1.496-0.202-0.141-0.546 0.787c-0.079 0.114-0.167 0.196-0.265 0.247-0.1 0.051-0.204 0.071-0.311 0.059-0.11-0.012-0.218-0.055-0.325-0.128-0.143-0.099-0.224-0.216-0.245-0.352-0.024-0.135 0.018-0.282 0.128-0.439l0.59-0.849-0.202-0.141-0.604 0.869c-0.1 0.144-0.157 0.283-0.17 0.414-0.015 0.131 0.009 0.251 0.070 0.361z">
          </path>
          <path
            d="M7.135 25.469c0.125 0.123 0.21 0.263 0.256 0.418 0.042 0.155 0.043 0.311 0.003 0.466-0.041 0.157-0.125 0.3-0.252 0.429-0.128 0.13-0.27 0.216-0.425 0.258s-0.31 0.042-0.464 0.001c-0.154-0.041-0.295-0.125-0.421-0.25-0.129-0.127-0.215-0.267-0.258-0.42-0.045-0.155-0.047-0.31-0.006-0.464 0.040-0.156 0.124-0.299 0.252-0.429 0.127-0.129 0.268-0.215 0.425-0.258 0.153-0.044 0.309-0.045 0.466-0.003 0.156 0.043 0.297 0.127 0.424 0.252zM6.982 25.624c-0.094-0.093-0.197-0.154-0.311-0.184-0.115-0.029-0.23-0.025-0.346 0.010-0.119 0.035-0.228 0.103-0.327 0.204-0.101 0.102-0.167 0.212-0.199 0.33-0.034 0.116-0.034 0.231-0.002 0.344 0.030 0.114 0.092 0.217 0.184 0.308s0.196 0.151 0.31 0.179c0.113 0.030 0.228 0.029 0.346-0.005s0.227-0.101 0.327-0.204c0.099-0.101 0.165-0.211 0.199-0.33 0.032-0.118 0.033-0.234 0.002-0.349-0.032-0.113-0.093-0.214-0.184-0.303z">
          </path>
          <path
            d="M4.848 25.819l1.116-1.595-0.131-0.192-1.56 0.367 0.91-1.318-0.131-0.192-1.894 0.458 0.127 0.186 1.605-0.393-0.949 1.352 0.119 0.175 1.608-0.388-0.954 1.344 0.133 0.195z">
          </path>
          <path
            d="M4.116 20.836c0.052 0.141 0.082 0.281 0.090 0.422 0.005 0.141-0.009 0.259-0.043 0.353l-0.221-0.037c0.026-0.089 0.039-0.195 0.038-0.317-0.003-0.122-0.027-0.243-0.071-0.362-0.060-0.163-0.129-0.27-0.205-0.323-0.079-0.052-0.16-0.063-0.245-0.031-0.063 0.023-0.104 0.062-0.123 0.116-0.022 0.053-0.030 0.115-0.023 0.186 0.005 0.072 0.015 0.151 0.032 0.236s0.031 0.171 0.044 0.258c0.012 0.084 0.013 0.165 0.005 0.242-0.011 0.078-0.037 0.148-0.081 0.211-0.044 0.061-0.115 0.109-0.212 0.145-0.093 0.035-0.186 0.040-0.279 0.015s-0.179-0.079-0.257-0.164c-0.081-0.086-0.149-0.201-0.203-0.347-0.041-0.111-0.067-0.227-0.078-0.349-0.013-0.121-0.009-0.226 0.013-0.316l0.223 0.032c-0.024 0.095-0.031 0.19-0.020 0.285 0.008 0.096 0.029 0.187 0.061 0.274 0.057 0.154 0.126 0.258 0.208 0.312 0.079 0.052 0.159 0.063 0.242 0.033 0.065-0.024 0.109-0.063 0.131-0.115 0.022-0.055 0.031-0.119 0.029-0.192-0.005-0.075-0.016-0.153-0.032-0.236-0.017-0.085-0.030-0.17-0.039-0.256-0.012-0.087-0.014-0.168-0.006-0.246 0.005-0.079 0.030-0.148 0.074-0.209 0.041-0.062 0.108-0.11 0.202-0.145 0.1-0.037 0.197-0.041 0.292-0.012 0.092 0.028 0.178 0.087 0.258 0.178 0.078 0.090 0.144 0.209 0.2 0.359z">
          </path>
          <path
            d="M1.756 18.883c-0.035 0.12-0.037 0.253-0.008 0.398 0.035 0.172 0.102 0.313 0.203 0.423 0.074 0.083 0.16 0.144 0.259 0.181l-1.046 0.212 0.049 0.242 2.523-0.511-0.049-0.242-0.939 0.19c-0.136 0.028-0.257 0.026-0.362-0.005-0.108-0.032-0.196-0.090-0.265-0.173-0.071-0.085-0.12-0.19-0.146-0.317-0.034-0.17-0.012-0.311 0.066-0.424 0.076-0.114 0.208-0.191 0.396-0.229l1.013-0.205-0.049-0.241-1.037 0.21c-0.172 0.035-0.309 0.096-0.409 0.182-0.101 0.084-0.167 0.187-0.199 0.309z">
          </path>
          <path
            d="M19.165 2.296c-0.098-0.078-0.22-0.131-0.365-0.159-0.173-0.034-0.329-0.025-0.468 0.026-0.112 0.039-0.205 0.1-0.28 0.184l0.063-0.325-0.232-0.045-0.348 1.788 0.242 0.047 0.183-0.94c0.027-0.136 0.074-0.247 0.143-0.333 0.071-0.087 0.158-0.147 0.261-0.179 0.106-0.034 0.222-0.038 0.349-0.013 0.17 0.033 0.293 0.108 0.367 0.223 0.077 0.114 0.097 0.265 0.060 0.454l-0.198 1.015 0.242 0.047 0.202-1.039c0.034-0.173 0.030-0.322-0.012-0.448-0.039-0.125-0.109-0.226-0.21-0.302z">
          </path>
          <path
            d="M20.456 4.527c-0.164-0.063-0.298-0.156-0.402-0.28-0.101-0.125-0.164-0.267-0.19-0.426-0.025-0.161-0.005-0.325 0.060-0.494 0.065-0.171 0.161-0.306 0.286-0.407s0.267-0.163 0.425-0.186c0.158-0.024 0.32-0.004 0.486 0.060 0.168 0.065 0.303 0.159 0.405 0.282 0.104 0.124 0.167 0.265 0.191 0.423 0.026 0.159 0.006 0.323-0.060 0.494-0.065 0.168-0.16 0.304-0.286 0.407-0.123 0.101-0.265 0.165-0.426 0.19-0.16 0.023-0.323 0.002-0.489-0.061zM20.535 4.323c0.123 0.047 0.242 0.062 0.358 0.045 0.116-0.020 0.221-0.069 0.313-0.147 0.095-0.080 0.168-0.186 0.218-0.318 0.051-0.134 0.068-0.261 0.050-0.382-0.016-0.12-0.061-0.225-0.135-0.316-0.073-0.093-0.171-0.162-0.291-0.209s-0.24-0.060-0.356-0.040c-0.116 0.018-0.221 0.065-0.315 0.143s-0.167 0.184-0.219 0.318c-0.050 0.132-0.067 0.259-0.050 0.382 0.018 0.121 0.064 0.228 0.137 0.32 0.074 0.090 0.171 0.158 0.29 0.204z">
          </path>
          <path
            d="M22.457 3.307l-0.391 1.907 0.197 0.124 1.286-0.956-0.312 1.57 0.197 0.124 1.556-1.172-0.191-0.12-1.317 0.998 0.334-1.618-0.179-0.113-1.322 0.994 0.342-1.613-0.2-0.126z">
          </path>
          <path
            d="M25.095 7.565c-0.104-0.108-0.188-0.225-0.251-0.351-0.061-0.127-0.095-0.241-0.102-0.341l0.217-0.055c0.011 0.092 0.042 0.194 0.093 0.306 0.052 0.111 0.122 0.212 0.21 0.303 0.12 0.125 0.226 0.196 0.318 0.214 0.093 0.016 0.172-0.007 0.237-0.069 0.048-0.047 0.071-0.098 0.067-0.156-0.001-0.057-0.018-0.117-0.053-0.18-0.033-0.064-0.074-0.132-0.124-0.203s-0.097-0.144-0.143-0.219c-0.045-0.073-0.078-0.146-0.102-0.22-0.021-0.076-0.025-0.151-0.011-0.226 0.016-0.073 0.062-0.146 0.136-0.218 0.072-0.069 0.155-0.111 0.25-0.125s0.195 0.001 0.301 0.047c0.109 0.046 0.217 0.125 0.324 0.237 0.082 0.085 0.152 0.181 0.211 0.288 0.060 0.106 0.099 0.204 0.115 0.294l-0.217 0.060c-0.016-0.097-0.048-0.187-0.096-0.269-0.046-0.084-0.101-0.16-0.165-0.226-0.114-0.118-0.219-0.186-0.315-0.202-0.093-0.016-0.171 0.006-0.234 0.067-0.050 0.048-0.075 0.101-0.074 0.158 0.002 0.059 0.019 0.121 0.050 0.187 0.035 0.066 0.076 0.134 0.124 0.203 0.050 0.071 0.096 0.144 0.138 0.218 0.046 0.074 0.081 0.149 0.104 0.223 0.026 0.074 0.032 0.148 0.016 0.221-0.013 0.073-0.055 0.145-0.126 0.214-0.077 0.074-0.164 0.116-0.263 0.128-0.095 0.011-0.198-0.008-0.308-0.060-0.107-0.051-0.216-0.134-0.327-0.249z">
          </path>
          <path
            d="M28.050 8.413c-0.017-0.124-0.068-0.247-0.153-0.368-0.101-0.144-0.22-0.245-0.356-0.305-0.101-0.046-0.204-0.067-0.31-0.062l0.872-0.615-0.142-0.201-2.104 1.484 0.142 0.201 0.783-0.552c0.113-0.080 0.224-0.127 0.333-0.142 0.112-0.014 0.216 0.003 0.312 0.051 0.1 0.049 0.187 0.126 0.261 0.232 0.1 0.142 0.137 0.28 0.11 0.415-0.024 0.135-0.114 0.258-0.27 0.369l-0.845 0.596 0.142 0.201 0.865-0.61c0.144-0.101 0.244-0.212 0.301-0.331 0.059-0.118 0.078-0.239 0.058-0.363z">
          </path>
          <path
            d="M27.442 10.925c-0.075-0.159-0.107-0.319-0.096-0.48 0.014-0.16 0.067-0.306 0.157-0.439 0.093-0.133 0.221-0.239 0.384-0.316 0.165-0.078 0.328-0.11 0.488-0.096s0.305 0.067 0.436 0.159c0.13 0.092 0.234 0.218 0.31 0.38 0.077 0.163 0.11 0.324 0.098 0.483-0.011 0.161-0.062 0.307-0.154 0.437-0.091 0.132-0.219 0.238-0.384 0.316-0.163 0.077-0.326 0.109-0.488 0.096-0.159-0.012-0.306-0.064-0.439-0.157-0.131-0.094-0.235-0.222-0.311-0.383zM27.64 10.832c0.056 0.119 0.132 0.213 0.228 0.28 0.098 0.066 0.207 0.103 0.328 0.11 0.124 0.008 0.25-0.018 0.377-0.078 0.13-0.061 0.23-0.142 0.3-0.242 0.072-0.098 0.112-0.205 0.12-0.322 0.011-0.118-0.011-0.235-0.067-0.352s-0.132-0.209-0.23-0.275c-0.096-0.067-0.205-0.105-0.327-0.114s-0.248 0.017-0.377 0.078c-0.128 0.060-0.228 0.141-0.3 0.242-0.071 0.1-0.111 0.209-0.122 0.326-0.009 0.117 0.014 0.233 0.068 0.348z">
          </path>
          <path
            d="M28.225 12.61c-0.035 0.142-0.032 0.288 0.009 0.44 0.046 0.167 0.125 0.306 0.237 0.417 0.113 0.113 0.246 0.189 0.401 0.228s0.321 0.034 0.5-0.015c0.176-0.048 0.321-0.129 0.434-0.242 0.115-0.113 0.191-0.247 0.228-0.401 0.040-0.152 0.036-0.312-0.010-0.48-0.042-0.154-0.115-0.283-0.218-0.386-0.091-0.091-0.201-0.156-0.33-0.193l0.345-0.095-0.063-0.227-2.405 0.662 0.065 0.238 0.98-0.27c-0.084 0.097-0.142 0.205-0.173 0.325zM28.617 13.287c-0.083-0.083-0.141-0.187-0.176-0.312s-0.037-0.245-0.009-0.361c0.031-0.114 0.090-0.214 0.176-0.3 0.090-0.085 0.202-0.146 0.338-0.183s0.263-0.042 0.381-0.015c0.119 0.030 0.22 0.086 0.305 0.168 0.086 0.084 0.146 0.189 0.18 0.314s0.036 0.244 0.005 0.358c-0.031 0.114-0.090 0.214-0.176 0.3s-0.198 0.148-0.334 0.185-0.264 0.042-0.385 0.012c-0.119-0.030-0.22-0.086-0.305-0.168z">
          </path>
        </symbol>
        <symbol id="btn-arrow" viewBox="0 0 32 32">
          <path
            d="M11.079 18.921c-0.090 0.056-0.118 0.175-0.061 0.266s0.175 0.118 0.266 0.061l-0.204-0.327zM21.177 12.999c0.024-0.104-0.041-0.207-0.144-0.231l-1.69-0.39c-0.104-0.024-0.207 0.041-0.231 0.144s0.041 0.207 0.144 0.231l1.503 0.347-0.347 1.503c-0.024 0.104 0.041 0.207 0.144 0.231s0.207-0.041 0.231-0.144l0.39-1.69zM11.283 19.248l9.809-6.129-0.204-0.327-9.809 6.129 0.204 0.327z">
          </path>
        </symbol>
      </defs>
    </svg>

    <!-- Hero -->
    <section class="py-6 lg:py-8 bg-white">
      <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <?php
          $heroCards = [
            ['label' => 'Скидки до 15%', 'title' => 'Арматура А500С', 'subtitle' => 'от 45 000 ₽/т при заказе от 10 т', 'url' => '/market/katalog/armatura', 'img' => '/public/assets/images/products/Арматура/Арматура/арматура_гладкая.webp'],
            ['label' => 'Каталог', 'title' => 'Труба профильная', 'subtitle' => 'от 58 000 ₽/т, уточняйте наличие', 'url' => '/market/katalog/truby', 'img' => '/public/assets/images/products/Трубы/ТРУБЫ_ЭЛЕКТРОСВАРНЫЕ/труба_электросварная.webp'],
            ['label' => 'Каталог', 'title' => 'Лист горячекатаный', 'subtitle' => 'от 51 000 ₽/т, уточняйте наличие', 'url' => '/market/katalog/listovoy-prokat', 'img' => '/public/assets/images/products/Листовой_прокат/СТАЛЬ_ЛИСТ_Г_К_КОНСТРУКЦИОННАЯ/лист.webp'],
          ];
          foreach ($heroCards as $i => $c):
            $hd = @getimagesize(__DIR__ . $c['img']);
            $hw = $hd[0] ?? 800;
            $hh = $hd[1] ?? 533;
            ?>
            <a href="<?= $c['url'] ?>"
              class="relative rounded-2xl overflow-hidden bg-white border border-gray-200 hover:shadow-lg transition-shadow block group">
              <div class="h-40 relative overflow-hidden">
                <img src="<?= $c['img'] ?>" alt="" width="<?= $hw ?>" height="<?= $hh ?>" <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async"
                  class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white z-10">
                  <span
                    class="inline-block bg-red-500 text-white text-[11px] font-semibold px-2 py-0.5 rounded-md mb-1.5"><?= $c['label'] ?></span>
                  <div class="text-lg font-bold group-hover:underline"><?= $c['title'] ?></div>
                  <div class="text-xs text-white/80"><?= $c['subtitle'] ?></div>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Stories -->
    <section class="pb-6 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <h3 class="text-lg font-bold text-gray-900 mb-3">Почему выбирают КАВ Сталь</h3>
        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide items-stretch">
          <?php
          $infoDir = __DIR__ . '/assets/images/info';
          $images = array_values(array_filter(scandir($infoDir), fn($f) => preg_match('/\.webp$/i', $f)));
          foreach ($images as $img):
            $dims = @getimagesize($infoDir . '/' . $img);
            $w = $dims[0] ?? 450;
            $h = $dims[1] ?? 600;
            ?>
            <div class="flex-shrink-0 h-64 rounded-xl overflow-hidden" style="border: 1px solid #ff0404">
              <img src="/public/assets/images/info/<?= htmlspecialchars($img) ?>" alt="" width="<?= $w ?>"
                height="<?= $h ?>" class="h-full w-auto max-w-none" loading="lazy" decoding="async">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var grid = document.getElementById('catalog-grid');
        if (!grid) return;
        var btns = Array.prototype.slice.call(document.querySelectorAll('#catalog-filters [data-cat]'));
        var cards = Array.prototype.slice.call(grid.querySelectorAll('[data-cat]'));
        var ACT = 'inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium transition-colors bg-red-500 text-white border border-red-500';
        var DEF = 'inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium transition-colors border border-gray-200 bg-white text-gray-600 hover:border-red-500 hover:text-red-500';
        btns.forEach(function (b) {
          b.addEventListener('click', function () {
            var cat = b.getAttribute('data-cat');
            var visible = 0;
            cards.forEach(function (c) {
              var show = (cat === '' || c.getAttribute('data-cat') === cat);
              c.style.display = show ? '' : 'none';
              if (show) visible++;
            });
            btns.forEach(function (x) { x.className = (x === b) ? ACT : DEF; });
            var empty = grid.querySelector('.col-span-full');
            if (!visible) {
              if (!empty) {
                var el = document.createElement('div');
                el.className = 'col-span-full text-center py-10 text-gray-400 text-sm';
                el.textContent = 'Товары не найдены';
                grid.appendChild(el);
              }
            } else if (empty) {
              empty.remove();
            }
          });
        });
      });
    </script>

    <!-- Популярные разделы -->
    <?php
    $treeData = \Setting\route\function\Functions::getCatalogTree();
    $catTreeCategories = $treeData['categories'];
    $catTreeSubcategories = $treeData['subcategories'];
    $catIconMap = [
        'armatura' => '/public/assets/images/icons/product_icons/арматура.webp',
        'balki' => '/public/assets/images/icons/product_icons/балки.webp',
        'truby' => '/public/assets/images/icons/product_icons/трубы.webp',
        'ugolok' => '/public/assets/images/icons/product_icons/угол.webp',
        'setka' => '/public/assets/images/icons/product_icons/сетка.webp',
        'shveller' => '/public/assets/images/icons/product_icons/швеллер.webp',
        'profnastil' => '/public/assets/images/icons/product_icons/профнастил.webp',
        'provoloka' => '/public/assets/images/icons/product_icons/проволка.webp',
        'vodostochnaya-sistema' => '/public/assets/images/icons/product_icons/водосточнаясистема.webp',
        'krepezh-i-metizy' => '/public/assets/images/icons/product_icons/метизы.webp',
        'tsvetnye-metally' => '/public/assets/images/icons/product_icons/цветныеметаллы.webp',
        'detali-truboprovodov' => '/public/assets/images/icons/product_icons/деталитрубопровода.webp',
        'polimery-i-tekhnicheskie-materialy' => '/public/assets/images/icons/product_icons/полимеры.webp',
        'truboprovodnaya-armatura' => '/public/assets/images/icons/product_icons/трубопроводнаяарматура.webp',
        'listovoy-prokat' => '/public/assets/images/icons/product_icons/листовойпрокат.webp',
        'nerzhaveyushchaya-stal' => '/public/assets/images/icons/product_icons/нержавеющяя сталь.webp',
        'krug-kvadrat-polosa' => '/public/assets/images/icons/product_icons/кругполосаквадрат.jpg',
        'izdeliya-i-proektnye-pozitsii' => '/public/assets/images/icons/product_icons/изделияпроектныепозицииоптом.png',
        'kachestvennye-i-spetsialnye-stali' => '/public/assets/images/icons/product_icons/качественныестали.jpg',
    ];
    ?>
    <section id="catalog" class="py-10 lg:py-14">
      <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between mb-2">
          <span class="inline-block bg-red-50 text-red-500 text-xs font-semibold px-3 py-1 rounded-full">Каталог</span>
        </div>
        <div class="flex items-end justify-between mb-6">
          <div>
            <h2 class="section-title">Каталог металлопроката</h2>
            <p class="text-gray-500 text-sm mt-1">Выберите нужный раздел и найдите подходящий металлопрокат</p>
          </div>
          <a href="/market" class="text-sm font-medium text-red-500 hover:underline hidden sm:block">Все разделы →</a>
        </div>
        <div class="relative lg:hidden">
          <div class="flex gap-3 overflow-x-auto pb-3 pl-2 pr-4 -mx-4 sm:flex-wrap sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;" id="cat-slider-home">
            <?php foreach ($catTreeCategories as $cat):
              $catSlug = $cat['id'];
              $catSubs = $catTreeSubcategories[$catSlug] ?? [];
              $catCount = (int)($cat['products'] ?? 0);
            ?>
              <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>"
                class="group relative flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-3 hover:border-red-300 hover:shadow-md transition-all duration-200 shrink-0 snap-start w-[72vw] max-w-[280px] sm:w-[calc(50%_-_6px)] sm:max-w-none sm:shrink md:w-[calc(33.333%_-_8px)]">
                <span class="absolute top-2.5 right-2.5 w-5 h-5 rounded-full bg-zinc-100 text-zinc-400 group-hover:bg-red-500 group-hover:text-white flex items-center justify-center transition-all duration-200">
                  <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
                <div class="w-14 h-14 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                  <?php if (!empty($catIconMap[$catSlug])): ?>
                    <img src="<?= htmlspecialchars($catIconMap[$catSlug]) ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                      class="w-10 h-10 object-contain" loading="lazy">
                  <?php else: ?>
                    <i class="fas fa-cube text-zinc-300 text-base"></i>
                  <?php endif; ?>
                </div>
                <div class="min-w-0">
                  <span class="text-[13px] font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($cat['name']) ?></span>
                  <span class="text-[11px] text-zinc-400 leading-tight"><?= $catCount ?> <?= $catCount === 1 ? 'товар' : ($catCount < 5 ? 'товара' : 'товаров') ?></span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
          <style>#cat-slider-home::-webkit-scrollbar{display:none}</style>
          <div class="pointer-events-none absolute right-0 top-0 bottom-3 w-8 bg-gradient-to-l from-white rounded-r-2xl"></div>
        </div>
        <p class="lg:hidden mt-2 text-center text-xs text-zinc-400 select-none">Листайте вправо →</p>
        <style>#cat-desktop-home{display:none}</style>
        <div id="cat-desktop-home" class="gap-3">
          <?php foreach ($catTreeCategories as $cat):
            $catSlug = $cat['id'];
            $catSubs = $catTreeSubcategories[$catSlug] ?? [];
            $catCount = (int)($cat['products'] ?? 0);
          ?>
            <a href="/market/katalog/<?= htmlspecialchars($catSlug) ?>"
              class="group relative flex items-center gap-3 bg-white border border-zinc-200 rounded-2xl p-4 hover:border-red-300 hover:shadow-md transition-all duration-200">
              <span class="absolute top-3 right-3 w-6 h-6 rounded-full bg-zinc-100 text-zinc-400 group-hover:bg-red-500 group-hover:text-white flex items-center justify-center transition-all duration-200">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
              </span>
              <div class="w-16 h-16 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-center shrink-0 overflow-hidden group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                <?php if (!empty($catIconMap[$catSlug])): ?>
                  <img src="<?= htmlspecialchars($catIconMap[$catSlug]) ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                    class="w-11 h-11 object-contain" loading="lazy">
                <?php else: ?>
                  <i class="fas fa-cube text-zinc-300 text-lg"></i>
                <?php endif; ?>
              </div>
              <div class="min-w-0">
                <span class="text-sm font-semibold text-zinc-800 group-hover:text-red-500 transition-colors leading-tight block truncate"><?= htmlspecialchars($cat['name']) ?></span>
                <span class="text-xs text-zinc-400 leading-tight"><?= $catCount ?> <?= $catCount === 1 ? 'товар' : ($catCount < 5 ? 'товара' : 'товаров') ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <style>@media (min-width: 1024px) { #cat-desktop-home { display: grid !important; grid-template-columns: repeat(5, 1fr); } }</style>
    </section>

    <!-- CTA Banner -->
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
      <div
        class="rounded-2xl px-8 py-10 md:px-12 md:py-12 text-center text-gray-900 relative overflow-hidden bg-white border border-gray-200">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-red-400 opacity-5 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-red-500 opacity-5 blur-3xl animate-pulse"
          style="animation-delay:1s;"></div>
        <div class="absolute top-1/2 left-1/3 w-32 h-32 rounded-full bg-red-300 opacity-5 blur-3xl animate-pulse"
          style="animation-delay:2s;"></div>
        <div class="relative">
          <h3 class="text-xl md:text-2xl font-bold mb-2">Нужна консультация?</h3>
          <p class="text-sm text-gray-500 mb-5">Поможем подобрать металлопрокат, рассчитать стоимость и организовать
            доставку</p>
          <a href="tel:<?= htmlspecialchars($site['phone_clean'] ?? preg_replace('/[^0-9+]/', '', $site['phone'])) ?>"
            class="inline-flex items-center gap-3 bg-red-500 text-white px-8 py-4 rounded-full text-base font-bold hover:bg-red-500 transition-all duration-300 shadow-lg shadow-red-500/20 hover:shadow-red-500/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path
                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
            </svg>
            <?= htmlspecialchars($site['phone']) ?>
          </a>
        </div>
      </div>
    </div>

    <!-- Видео-слайдер -->
    <?php $img = '/public/assets/images/services/stories/';
    $vid = '/public/assets/images/services/vides/';
    $info = '/public/assets/images/info/';
    $videoStories = [
      ['title' => 'Лазерная резка металла', 'desc' => 'Высокоточная резка до 25 мм', 'video' => $vid . 'lazer.MP4', 'bg' => 'https://content.storage-cdn.ru/custom/vitrina/other/stories/37/content-31-4anv.png'],
      ['title' => 'Гибка металла', 'desc' => 'Точная гибка листового металла', 'video' => $vid . 'gibkametalla.MP4', 'bg' => $img . 'ПРОФНАСТИЛ.webp'],
      ['title' => 'Плазменная резка', 'desc' => 'Резка толстого металла до 150 мм', 'video' => $vid . 'plazma.MP4', 'bg' => $img . 'БАЛКА.webp'],
      ['title' => 'Доставка металлопроката', 'desc' => 'В день оплаты по Москве и МО', 'video' => $vid . 'dostavka.MP4', 'bg' => $img . 'ШВЕЛЛЕР.webp'],
      ['title' => 'Комплексная доставка на объект', 'desc' => 'Кран-борт, манипулятор, разгрузка', 'video' => $vid . 'dostavkaKD.MP4', 'bg' => $img . 'СВАИ.webp'],
      ['title' => 'Горячее цинкование', 'desc' => 'Защита от коррозии на 50+ лет', 'video' => $vid . 'gorachiethinkirovanie.MP4', 'bg' => $img . 'УГОЛОК.webp'],
      ['title' => 'Ленточнопильная резка', 'desc' => 'Точная резка балок и труб', 'video' => $vid . 'lentochnopilnik.MP4', 'bg' => $img . 'БАЛКА.webp'],
      ['title' => 'Ручная резка металла', 'desc' => 'Индивидуальная резка по размерам', 'video' => $vid . 'ruchnairezka.MP4', 'bg' => $img . 'ПОЛОСА.webp'],
      ['title' => 'Изоляция трубопроводов', 'desc' => 'Тепло- и звукоизоляция', 'video' => $vid . 'izolatiatrub.MP4', 'bg' => $img . 'ТРУБА.webp'],
    ]; ?>
    <style>
      .video-section {
        padding: 72px 0 48px;
      }

      .video-section .news-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 16px;
      }

      .video-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
      }

      .video-kicker {
        display: block;
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #9a9a9a;
        margin-bottom: 8px;
      }

      .video-header h2 {
        font-size: 36px;
        font-weight: 500;
        color: #141414;
        letter-spacing: -0.03em;
        line-height: 1.2;
        margin: 0;
      }

      .video-controls {
        display: flex;
        gap: 8px;
      }

      .video-arrow {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid rgb(227, 225, 223);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        color: #1a1a1a;
      }

      .video-arrow:hover {
        border-color: rgb(201, 198, 194);
        color: #1a1a1a;
      }

      .video-arrow svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
      }

      .video-arrow.swiper-button-disabled {
        opacity: 0.35;
        cursor: default;
      }

      .video-swiper {
        overflow: hidden;
      }

      .video-slide {
        height: auto;
      }

      .video-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        display: block;
        text-decoration: none;
        cursor: pointer;
        aspect-ratio: 9 / 14;
      }

      .video-card-media {
        position: absolute;
        inset: 0;
      }

      .video-card-media video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .video-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.15) 0%, transparent 30%, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
        z-index: 1;
        pointer-events: none;
      }

      .video-card-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 8px;
        pointer-events: none;
      }

      .video-card-badge-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      .video-card-badge-icon svg {
        width: 14px;
        height: 14px;
        fill: #fff;
      }

      .video-card-badge-text {
        font-size: 12px;
        font-weight: 500;
        color: #fff;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
      }

      .video-card-body {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px 16px;
        z-index: 2;
      }

      .video-card-title {
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        line-height: 1.35;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
      }

      .video-card-desc {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 4px;
        line-height: 1.4;
      }

      .video-pagination {
        text-align: center;
        margin-top: 24px;
      }

      .video-pagination .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: #d1d5db;
        opacity: 1;
        transition: background 0.2s, width 0.2s;
      }

      .video-pagination .swiper-pagination-bullet-active {
        background: #dc2626;
        width: 24px;
        border-radius: 4px;
      }

      @media (max-width: 900px) {
        .video-header h2 {
          font-size: 28px;
        }

        .video-card {
          aspect-ratio: 9 / 13;
        }
      }

      @media (max-width: 600px) {
        .video-section {
          padding: 48px 0 32px;
        }

        .video-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 12px;
        }

        .video-header h2 {
          font-size: 24px;
        }

        .video-card {
          aspect-ratio: 9 / 14;
        }

        .video-card-title {
          font-size: 14px;
        }

        .video-card-body {
          padding: 16px 12px;
        }
      }
    </style>

    <section class="video-section">
      <div class="news-container">
        <div class="video-header">
          <div>
            <span class="video-kicker">Наши возможности</span>
            <h2 class="section-title">Видео с производства</h2>
          </div>
          <div class="video-controls">
            <button type="button" class="video-arrow video-prev" aria-label="Назад">
              <svg viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6" />
              </svg>
            </button>
            <button type="button" class="video-arrow video-next" aria-label="Вперёд">
              <svg viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" />
              </svg>
            </button>
          </div>
        </div>

        <div class="swiper video-swiper" id="videoSwiper">
          <div class="swiper-wrapper">
            <?php foreach ($videoStories as $vs): ?>
              <div class="swiper-slide video-slide">
                <div class="video-card" tabindex="0">
                  <div class="video-card-media">
                    <video src="<?= $vs['video'] ?>" muted loop playsinline preload="none"></video>
                  </div>
                  <div class="video-card-overlay"></div>
                  <div class="video-card-badge">
                    <span class="video-card-badge-icon">
                      <svg viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                      </svg>
                    </span>
                    <span class="video-card-badge-text">Кав Сталь — услуги</span>
                  </div>
                  <div class="video-card-body">
                    <div class="video-card-title"><?= $vs['title'] ?></div>
                    <div class="video-card-desc"><?= $vs['desc'] ?></div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="video-pagination"></div>
        </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swiper === 'undefined') return;

        var videoSwiper = new Swiper('#videoSwiper', {
          slidesPerView: 1.3,
          spaceBetween: 16,
          grabCursor: true,
          pagination: { el: '.video-pagination', clickable: true },
          navigation: { nextEl: '.video-next', prevEl: '.video-prev' },
          breakpoints: {
            480: { slidesPerView: 2.2 },
            768: { slidesPerView: 3.2 },
            1024: { slidesPerView: 4 }
          }
        });

        document.querySelectorAll('.video-card').forEach(function (card) {
          var video = card.querySelector('video');
          if (!video) return;

          card.addEventListener('mouseenter', function () {
            video.play().catch(function () { });
          });

          card.addEventListener('mouseleave', function () {
            video.pause();
          });
        });

        var observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            var video = entry.target.querySelector('video');
            if (!video) return;
            if (entry.isIntersecting) {
              video.play().catch(function () { });
            } else {
              video.pause();
            }
          });
        }, { threshold: 0.5 });

        document.querySelectorAll('.video-card').forEach(function (card) {
          observer.observe(card);
        });
      });
    </script>

    <!-- Карта отгрузок -->
    <section class="py-14 lg:py-20">
      <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-8">
          <span class="inline-block bg-red-50 text-red-500 text-xs font-semibold px-3 py-1 rounded-full mb-3">География
            поставок</span>
          <h2 class="text-xl md:text-2xl section-title">Карта отгрузок по всей России</h2>
          <p class="text-gray-600 text-sm mt-2">Доставляем металлопрокат в более чем 100 городов России — <a
              href="/delivery-map" class="text-red-500 hover:text-red-600 font-medium underline underline-offset-2">все
              города на карте отгрузок</a></p>
        </div>
        <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm" style="height:420px;">
          <iframe
            src="https://yandex.ru/map-widget/v1/?um=constructor%3A5d7f9c69d82be5cfae8e60fc3a09dca546e89e06c8c576248c668b43aba603ae&amp;source=constructor"
            width="100%" height="680" frameborder="0"></iframe>
        </div>
      </div>
    </section>

    <!-- Что нового -->
    <section class="news-section">
      <div class="news-container">

        <?php
        /*
         * НАСТРОЙКА ИСТОРИЙ «Реализованные отгрузки»
         *
         * Формат: ['title' => 'Заголовок', 'slides' => [...слайды...]]
         *
         * Слайд — один из вариантов:
         *   '4.webp'                    — просто фото (файл в /public/assets/images/services/stories/)
         *   ['video' => 'video.MP4']    — видео (файл в /public/assets/images/services/vides/)
         *   ['bg' => '4.webp', 'video' => 'video.MP4'] — видео с собственной обложкой
         *
         * Несколько слайдов в одной истории = несколько фото/видео,
         * листаются стрелками внутри модалки.
         * tagName — необязательная метка на карточке (по умолчанию «Новость»).
         */
        $stories = [
          [
            'title' => 'Поставка нержавеющих труб и листового проката для предприятия атомной промышленности',
            'desc'  => 'Поставка нержавеющих труб и листового проката для предприятия атомной промышленности',
            'slides' => ['4.webp'],
          ],
          [
            'title' => 'Поставка сортового и трубного проката для производства металлоконструкций',
            'tagName' => 'Поставка',
            'slides' => [['bg' => 'bg_2.png', 'video' => 'postavka_sortovogo.MP4']],
          ],
          [
            'title' => 'Поставка арматуры для изготовления сварной сетки',
            'tagName' => 'Поставка',
            'slides' => [['bg' => 'bg_3.png', 'video' => 'postavka_armatury.MP4']],
          ],
          [
            'title' => 'Поставка труб и отводов в ВУС изоляции для реконструкции трубопровода в Тульской области',
            'tagName' => 'Поставка',
            'slides' => ['2.jpeg', '3.jpeg'],
          ],
          [
            'title' => 'Поставка труб для производства металлоконструкций',
            'tagName' => 'Поставка',
            'slides' => [['bg' => 'bg_4.png', 'video' => 'postavka_trub.MP4']],
          ],
        ];

        // Нормализация: короткий формат -> полный (title/bg/video подставляются автоматически)
        $stories = array_map(function ($s) use ($img, $vid) {
          $s['slides'] = array_map(function ($slide) use ($img, $vid, $s) {
            $item = [];
            if (is_string($slide)) {
              $item['bg'] = $img . $slide;
            } else {
              $item['bg'] = isset($slide['bg']) ? $img . $slide['bg'] : $img . '1.webp';
              if (!empty($slide['video'])) {
                $item['video'] = $vid . $slide['video'];
              }
            }
            $item['title'] = $s['title'];
            return $item;
          }, $s['slides']);
          return $s;
        }, $stories);
        ?>

        <div class="news-header">
          <div>
            <span class="news-kicker">НАШИ ПОСТАВКИ</span>
            <h2 class="section-title">Реализованные отгрузки</h2>
          </div>
          <div class="news-controls">
            <button id="newsSwiperPrev" class="news-arrow" aria-label="Предыдущая новость"><svg fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
              </svg></button>
            <button id="newsSwiperNext" class="news-arrow" aria-label="Следующая новость"><svg fill="none"
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg></button>
          </div>
        </div>

        <style>
          .news-section {
            padding: 72px 0;
          }

          .news-kicker {
            display: block;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #9a9a9a;
            margin-bottom: 10px;
          }

          .news-header h2 {
            font-size: 36px;
            font-weight: 500;
            letter-spacing: -0.03em;
            color: #141414;
          }

          .news-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 16px;
          }

          .news-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 32px;
          }

          .news-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
          }

          .news-controls {
            display: flex;
            align-items: center;
            gap: 10px;
          }

          .news-arrow {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgb(227, 225, 223);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b6b6b;
            cursor: pointer;
            transition: color 0.2s ease, border-color 0.2s ease;
          }

          .news-arrow svg {
            width: 15px;
            height: 15px;
          }

          .news-arrow:hover {
            border-color: rgb(201, 198, 194);
            color: #1a1a1a;
          }

          .news-arrow.swiper-button-disabled {
            opacity: 0.35;
            cursor: default;
            color: #9a9a9a;
            border-color: rgb(227, 225, 223);
          }

          .story-card {
            position: relative;
            display: block;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid rgb(229, 228, 226);
            padding: 5px;
            background: #fff;
            text-align: left;
            cursor: pointer;
            transition: border-color 0.2s ease;
          }

          .story-card-media {
            position: relative;
            display: block;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 9px;
          }

          .story-card-media img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
          }

          .story-card-media2 {
            position: absolute;
            z-index: 1;
            right: 10px;
            bottom: 10px;
            width: 42%;
            aspect-ratio: 1 / 1;
            border-radius: 9px;
            overflow: hidden;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
          }

          .story-card-media2 img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
          }

          .story-card-count {
            position: absolute;
            left: 10px;
            bottom: 10px;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(20, 20, 20, 0.65);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            line-height: 1;
            pointer-events: none;
            backdrop-filter: blur(4px);
          }

          .story-card-count svg {
            width: 12px;
            height: 12px;
          }

          .story-card-body {
            display: block;
            padding: 12px 8px 8px;
          }

          .story-card-cat {
            display: block;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #a3a3a3;
            margin-bottom: 6px;
          }

          .story-card-title {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #141414;
            font-weight: 500;
            font-size: 14px;
            line-height: 1.45;
            letter-spacing: -0.03em;
          }

          .story-card-play {
            position: absolute;
            right: 10px;
            bottom: 10px;
            z-index: 2;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a1a;
            pointer-events: none;
            transition: background-color 0.2s ease;
          }

          .story-card-play svg {
            width: 12px;
            height: 12px;
            margin-left: 1px;
          }

          .story-card:hover {
            border-color: rgb(200, 197, 193);
          }

          .story-card:hover .story-card-play {
            background: #fff;
          }

          @media (max-width: 767px) {
            .news-section {
              padding: 48px 0;
            }

            .news-header h2 {
              font-size: 28px;
            }
          }
        </style>
        <div class="swiper newsSwiper">
          <div class="swiper-wrapper">
            <?php foreach ($stories as $i => $s):
              $slidesCount = count($s['slides']);
              $first = $s['slides'][0];
              $hasVideo = !empty($first['video']);
              $preview2 = $slidesCount > 1 && !empty($s['slides'][1]['bg']) ? $s['slides'][1]['bg'] : null;
            ?>
              <div class="swiper-slide story-slide">
                <button type="button" class="story-card" data-story-index="<?= $i ?>"
                  aria-label="<?= htmlspecialchars($s['title']) ?>">
                  <span class="story-card-media">
                    <img src="<?= $first['bg'] ?>" alt="<?= htmlspecialchars($s['title']) ?>" loading="lazy">
                    <?php if ($preview2): ?>
                      <span class="story-card-media2">
                        <img src="<?= $preview2 ?>" alt="" loading="lazy">
                      </span>
                    <?php endif; ?>
                    <?php if ($slidesCount > 1): ?>
                      <span class="story-card-count" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect x="3" y="3" width="18" height="18" rx="2" />
                          <circle cx="8.5" cy="8.5" r="1.5" />
                          <path d="M21 15l-5-5L5 21" />
                        </svg>
                        <?= $slidesCount ?>
                      </span>
                    <?php endif; ?>
                    <?php if ($hasVideo): ?>
                      <span class="story-card-play" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor">
                          <path d="M8 5v14l11-7z" />
                        </svg></span>
                    <?php endif; ?>
                  </span>
                  <span class="story-card-body">
                    <span class="story-card-cat"><?= htmlspecialchars($s['tagName'] ?? 'Новость') ?></span>
                    <span class="story-card-title"><?= $s['title'] ?></span>
                  </span>
                </button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Загрузка спецификации -->
    <section id="spec" class="py-14 lg:py-20 relative">
      <div class="absolute top-10 left-10 w-32 h-32 rounded-full bg-red-400 opacity-5 blur-3xl animate-pulse"></div>
      <div class="absolute bottom-20 right-20 w-40 h-40 rounded-full bg-red-500 opacity-5 blur-3xl animate-pulse"
        style="animation-delay:1s;"></div>
      <div class="absolute top-1/2 left-1/3 w-24 h-24 rounded-full bg-red-300 opacity-5 blur-3xl animate-pulse"
        style="animation-delay:2s;"></div>
      <div class="max-w-7xl mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-8">
          <span
            class="inline-block bg-red-50 text-red-500 text-xs font-semibold px-3 py-1 rounded-full mb-3">Заявка</span>
          <h2 class="text-xl md:text-2xl section-title">Загрузите Вашу заявку или полную спецификацию всего объекта
          </h2>
          <p class="text-gray-600 text-sm mt-3">Посчитаем все материалы под ключ</p>
        </div>
        <div class="max-w-4xl mx-auto">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 md:p-8">
            <form id="specForm" enctype="multipart/form-data" class="space-y-5">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                  <label for="specName"
                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 mb-1.5"><svg
                      class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>Имя</label>
                  <input type="text" name="name" id="specName" placeholder="Ваше имя"
                    class="w-full text-sm border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-400 bg-gray-50/50 transition">
                </div>
                <div>
                  <label for="specPhone"
                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 mb-1.5"><svg
                      class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>Телефон <span class="text-red-500">*</span></label>
                  <input type="tel" name="phone" id="specPhone" required placeholder="(___) ___-__-__"
                    class="w-full text-sm border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-400 bg-gray-50/50 transition">
                </div>
                <div>
                  <label for="specEmail"
                    class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 mb-1.5"><svg
                      class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>Почта <span class="text-red-500">*</span></label>
                  <input type="email" name="email" id="specEmail" required placeholder="email@example.com"
                    class="w-full text-sm border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-400 bg-gray-50/50 transition">
                </div>
              </div>
              <div>
                <label for="specFile"
                  class="flex flex-col items-center justify-center gap-2 w-full border-2 border-dashed border-gray-300 rounded-xl px-4 py-8 cursor-pointer transition hover:border-red-400 hover:bg-red-50/30 text-center">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                  </svg>
                  <span class="text-sm font-medium text-gray-600" id="specFileLabel">Прикрепить файл
                    (xlsx, xls, pdf, csv, doc, docx)</span>
                  <span class="text-xs text-gray-400">Можно прикрепить несколько файлов</span>
                  <input type="file" name="spec_file[]" id="specFile" multiple accept=".xlsx,.xls,.pdf,.csv,.doc,.docx"
                    class="hidden">
                </label>
                <div id="specFileList" class="mt-2 space-y-1"></div>
              </div>
              <div>
                <label for="specComment"
                  class="flex items-center gap-1.5 text-xs font-semibold text-gray-700 mb-1.5"><svg
                    class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                  </svg>Комментарии</label>
                <textarea name="comment" id="specComment" rows="3" placeholder="Дополнительная информация к заявке"
                  class="w-full text-sm border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-400 bg-gray-50/50 transition"></textarea>
              </div>
              <div class="text-xs text-gray-500">Поле с телефоном и почтой обязательно для заполнения</div>
              <button type="submit"
                class="w-full bg-gradient-to-r from-red-500 to-red-500 hover:from-red-500 hover:to-red-500 text-white py-3.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md shadow-red-500/20">Отправить
                заявку →</button>
              <div id="specFormStatus" class="hidden text-center text-sm font-medium"></div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('specForm');
        if (!form) return;
        var fileInput = document.getElementById('specFile');
        var fileList = document.getElementById('specFileList');
        var label = document.getElementById('specFileLabel');
        var status = document.getElementById('specFormStatus');

        fileInput.addEventListener('change', function () {
          var names = Array.from(this.files).map(function (f) { return f.name; });
          label.textContent = names.length ? names.length + ' файл(а) прикреплено' : 'Прикрепить файл (xlsx, xls, pdf, csv, doc, docx)';
          fileList.innerHTML = names.map(function (n) {
            return '<div class="flex items-center gap-2 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5">' +
              '<svg class="w-3.5 h-3.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>' +
              '<span class="truncate">' + n + '</span></div>';
          }).join('');
        });

        form.addEventListener('submit', async function (e) {
          e.preventDefault();
          status.classList.add('hidden');
          status.style.color = '';
          var btn = form.querySelector('button[type="submit"]');
          btn.disabled = true;
          btn.textContent = 'Отправка...';
          try {
            var res = await fetch('/send/email', { method: 'POST', body: new FormData(form) });
            var data = await res.json();
            if (data.success) {
              status.textContent = 'Заявка отправлена! Мы свяжемся с вами в ближайшее время';
              status.style.color = '#16a34a';
              form.reset();
              label.textContent = 'Прикрепить файл (xlsx, xls, pdf, csv, doc, docx)';
              fileList.innerHTML = '';
            } else {
              status.textContent = 'Ошибка: ' + (data.error || 'повторите попытку');
              status.style.color = '#dc2626';
            }
          } catch (err) {
            status.textContent = 'Ошибка соединения. Попробуйте позже.';
            status.style.color = '#dc2626';
          }
          status.classList.remove('hidden');
          btn.disabled = false;
          btn.textContent = 'Отправить заявку →';
        });
      });
    </script>

    <!-- Stories Modal -->
    <style>
      #storyModal {
        z-index: 9999;
      }

      #storyModal:not(.hidden) .story-overlay {
        animation: story-fade 0.25s ease forwards;
      }

      #storyModal:not(.hidden) .story-container {
        animation: story-pop 0.3s ease forwards;
      }

      @keyframes story-fade {
        from {
          opacity: 0;
        }

        to {
          opacity: 1;
        }
      }

      @keyframes story-pop {
        from {
          opacity: 0;
          transform: translateY(14px) scale(0.98);
        }

        to {
          opacity: 1;
          transform: translateY(0) scale(1);
        }
      }

      .story-overlay {
        background: rgba(0, 0, 0, 0.72);
      }

      .story-container {
        width: 100%;
        max-width: 400px;
        height: 85vh;
        max-height: 740px;
      }

      .story-progress {
        display: flex;
        gap: 6px;
        padding: 14px 16px 8px;
      }

      .story-progress>div {
        flex: 1;
        height: 3px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.55);
      }

      .story-progress>div>div {
        height: 100%;
        border-radius: 999px;
        background: #fff;
      }

      .story-ctrl-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }

      .story-ctrl-btn:hover {
        background: #fff;
      }

      .story-ctrl-btn svg {
        width: 18px;
        height: 18px;
      }

      .story-title {
        display: inline-block;
        background: rgba(255, 255, 255, 0.14);
        -webkit-backdrop-filter: blur(14px);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 10px;
        padding: 6px 12px;
        color: #fff;
        font-weight: 500;
        font-size: 18px;
        line-height: 1.35;
        letter-spacing: -0.03em;
      }

      .story-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 22px;
        background: #dc2626;
        color: #fff;
        height: 44px;
        padding: 0 24px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: -0.01em;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }

      .story-cta-btn:hover {
        background: #b91c1c;
      }

      .story-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 9999;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgb(232, 231, 229);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }

      .story-nav-btn:hover {
        background: #fff;
      }

      .story-nav-btn svg {
        width: 18px;
        height: 18px;
      }

      .story-nav-prev {
        left: 12px;
      }

      .story-nav-next {
        right: 12px;
      }

      @media (min-width: 768px) {
        .story-nav-prev {
          left: calc(50% - 268px);
        }

        .story-nav-next {
          right: calc(50% - 268px);
        }
      }

      @media (max-width: 767px) {
        .story-container {
          top: -50px;
        }

        .story-nav-btn {
          top: 43%;
        }

        .story-nav-prev {
          left: 30px;
        }

        .story-nav-next {
          right: 30px;
        }
      }
    </style>
    <div id="storyModal" class="fixed inset-0 hidden">
      <div class="absolute inset-0 story-overlay" id="storyOverlay"></div>
      <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="relative rounded-2xl overflow-hidden shadow-2xl pointer-events-auto story-container"
          id="storyContainer" style="background: linear-gradient(160deg, #2b2b2b 0%, #1c1c1c 55%, #131313 100%);">
          <!-- Progress bars -->
          <div id="storyProgress" class="absolute top-0 left-0 right-0 z-30 story-progress"></div>
          <!-- Top-right buttons: sound (under close) -->
          <div class="absolute right-3 z-30 flex flex-col items-center gap-2" style="top: 28px;">
            <button type="button" id="storyClose" class="story-ctrl-btn" aria-label="Закрыть">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            <button type="button" id="storySound" class="story-ctrl-btn" aria-label="Звук вкл/выкл">
              <svg class="story-sound-on" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3A4.5 4.5 0 0 0 14 8v8a4.5 4.5 0 0 0 2.5-4zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" />
              </svg>
              <svg class="story-sound-off hidden" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3A4.5 4.5 0 0 0 14 8v8a4.5 4.5 0 0 0 2.5-4zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" />
                <path d="M22 8l-6 6m0-6l6 6" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" />
              </svg>
            </button>
          </div>
          <!-- Media area (image or video) -->
          <div id="storySlide" class="absolute inset-0">
            <img id="storyImage" src="" alt="" class="absolute inset-0 w-full h-full object-cover">
            <video id="storyVideo" preload="none" playsinline loop
              class="absolute inset-0 w-full h-full object-cover hidden"></video>
          </div>
          <!-- Title overlaid on media -->
          <div
            style="position: absolute; left: 20px; right: 20px; top: 28px; z-index: 10; text-align: left; pointer-events: none;">
            <h3 id="storyTitle" class="story-title"></h3>
          </div>
          <!-- CTA button at bottom -->
          <div
            style="position: absolute; bottom: 32px; display: flex; flex-direction: column; width: 100%; padding: 0px 32px; z-index: 20;">
            <button type="button" id="storyNextBtn" class="story-cta-btn">Дальше</button>
          </div>
        </div>
      </div>
      <!-- Arrows outside modal -->
      <button type="button" id="storyPrev" class="story-nav-btn story-nav-prev" aria-label="Предыдущая история"><svg
          fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg></button>
      <button type="button" id="storyNext" class="story-nav-btn story-nav-next" aria-label="Следующая история"><svg
          fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg></button>
    </div>

  </main>

  <!-- SEO-описание — охват запросов по металлопрокату -->
  <section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
      <h2 class="text-2xl md:text-3xl font-medium text-gray-900 tracking-tight leading-snug mb-6">
        Металлопрокат с доставкой по Москве и Московской области
      </h2>

      <div class="grid md:grid-cols-2 gap-8">
        <div class="space-y-4 text-[15px] text-gray-500 leading-relaxed">
          <p>
            «КАВ СТАЛЬ» — комплексное снабжение металлопрокатом в Москве. В каталоге представлены:
            чёрный металлопрокат (арматура, балка, швеллер, уголок, круг, квадрат, полоса, катанка,
            листовой прокат, трубы профильные, электросварные, ВГП, бесшовные),
            нержавеющая сталь, цветные металлы, качественные и специальные стали,
            крепёж и метизы, детали трубопроводов, трубопроводная арматура,
            кровельные и фасадные материалы, полимеры и изоляция.
            Весь сортамент — по ГОСТ и ТУ.
          </p>
          <p>
            Цена металлопроката за тонну и за метр зависит от марки стали
            (Ст3, 09Г2С, 12Х18Н10Т, А500С и др.), размера и объёма заказа.
            Организуем резку в размер, доставку и сопроводительные документы.
            На всю продукцию — сертификаты качества и паспорта.
          </p>
        </div>

        <div class="flex flex-wrap gap-3 content-start">
          <a href="/market/katalog/chernyy-metalloprokat"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Чёрный
            металлопрокат</a>
          <a href="/market/katalog/nerzhaveyushchaya-stal"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Нержавеющая
            сталь</a>
          <a href="/market/katalog/tsvetnye-metally"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Цветные
            металлы</a>
          <a href="/market/katalog/krepezh-i-metizy"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Крепёж
            и метизы</a>
          <a href="/market/katalog/detali-truboprovodov"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Детали
            трубопроводов</a>
          <a href="/market/katalog/truboprovodnaya-armatura"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Трубопроводная
            арматура</a>
          <a href="/market/katalog/kachestvennye-i-spetsialnye-stali"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Качественные
            и специальные стали</a>
          <a href="/market/katalog/krovelnye-i-fasadnye-materialy"
            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-900 hover:text-white transition-colors">Кровельные
            и фасадные материалы</a>
        </div>
      </div>
    </div>
  </section>

  <?php include_once './public/components/footer.php'; ?>

  <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script defer src="/public/assets/scripts/components/swiper.min.js"></script>
  <script defer src="/public/assets/scripts/components/lazyIMG.min.js"></script>
  <script defer src="/public/assets/scripts/components/cart-favorites.min.js"></script>
  <script defer src="/public/assets/scripts/main/switchUnit.min.js"></script>

  <script>
    window.__storiesData = <?php echo json_encode($stories ?? []); ?>;
  </script>
  <script defer src="/public/assets/scripts/main/stories.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@27.1.3/dist/js/intlTelInputWithUtils.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll("[data-type-phone]").forEach(function (input) {
        window.intlTelInput(input, {
          initialCountry: "ru",
          separateDialCode: true,
        });
      });
      document.querySelectorAll('input[data-type-phone]').forEach(function (input) {
        input.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          if (value.startsWith('7') || value.startsWith('8')) {
            value = value.substring(1);
          }
          value = value.substring(0, 10);
          if (value.length > 0) {
            let formatted = '';
            if (value.length >= 1) formatted += '(' + value.substring(0, 3);
            if (value.length >= 4) formatted += ') ' + value.substring(3, 6);
            if (value.length >= 7) formatted += '-' + value.substring(6, 8);
            if (value.length >= 9) formatted += '-' + value.substring(8, 10);
            e.target.value = formatted;
          } else {
            e.target.value = '';
          }
          e.target.setCustomValidity('');
        });
        input.addEventListener('blur', function () {
          const digits = this.value.replace(/\D/g, '');
          if (digits.length !== 10) {
            this.setCustomValidity('Введите полный номер телефона');
          } else {
            this.setCustomValidity('');
          }
        });
      });
    });
  </script>
</body>

</html>