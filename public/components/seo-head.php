<?php
// Общий SEO-блок: гео-теги, верификация поисковиков, GTM, GA4, Яндекс.Метрика.
// Подключается в <head> каждой страницы сразу перед </head>.
$siteInfo = $siteInfo ?? $site ?? [];
$gscId  = $_ENV['GSC_ID']  ?? '';
$ga4Id  = $_ENV['GA4_ID']  ?? '';
$ymId   = $_ENV['YM_ID']   ?? '';
$ywebId = $_ENV['YWEB_ID'] ?? '';
$gadsId = $_ENV['GADS_ID'] ?? '';
?>
  <meta name="geo.region" content="RU-MOW">
  <meta name="geo.placename" content="Москва">
  <meta name="geo.position" content="55.765833;37.618889">
  <meta name="ICBM" content="55.765833, 37.618889">
  <meta name="theme-color" content="#dc2626">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-config" content="/browserconfig.xml">
  <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/images/icons/favicon/apple-touch-icon.png">

  <!-- SEO METRIKS -->
  <?php if ($gscId): ?><meta name="google-site-verification" content="<?= htmlspecialchars($gscId) ?>"><?php endif; ?>
  <?php if ($ywebId): ?><meta name="yandex-verification" content="<?= htmlspecialchars($ywebId) ?>" /><?php endif; ?>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-KPHKLMXW');</script>
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPHKLMXW" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>

  <?php if ($ga4Id): ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($ga4Id) ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= htmlspecialchars($ga4Id) ?>');
    <?php if ($gadsId): ?>gtag('config', '<?= htmlspecialchars($gadsId) ?>');<?php endif; ?>
  </script>
  <?php endif; ?>

  <?php if ($ymId): ?>
  <script>
    (function(m,e,t,r,i,k,a){
      m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
      m[i].l=1*new Date();
      for(var j=0;j<document.scripts.length;j++){if(document.scripts[j].src===r)return;}
      k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a);
    })(window,document,'script','https://mc.yandex.ru/metrika/tag.js','ym');
    ym(<?= htmlspecialchars($ymId) ?>,'init',{clickmap:true,trackLinks:true,accurateTrackBounce:true,webvisor:true,ecommerce:'dataLayer'});
    window.ymGoal = function(target, params){ try { ym(<?= htmlspecialchars($ymId) ?>,'reachGoal',target, params||{}); } catch(e){} };
  </script>
  <noscript><div><img src="https://mc.yandex.ru/watch/<?= htmlspecialchars($ymId) ?>" style="position:absolute;left:-9999px" alt=""></div></noscript>
  <?php endif; ?>

  <script>
    // Универсальная отправка целей в Яндекс.Метрику и GA4
    window.trackGoal = function(target, params){
      params = params || {};
      <?php if ($ymId): ?>try { ym(<?= htmlspecialchars($ymId) ?>,'reachGoal',target,params); } catch(e){}<?php endif; ?>
      <?php if ($ga4Id): ?>try { gtag('event', target, params); } catch(e){}<?php endif; ?>
    };
    document.addEventListener('DOMContentLoaded', function(){
      // Авто-трекинг отправки любой формы с data-goal
      document.querySelectorAll('form[data-goal]').forEach(function(form){
        form.addEventListener('submit', function(){
          window.trackGoal(form.getAttribute('data-goal'), {page: location.pathname});
        });
      });
      // Кнопки с data-goal
      document.querySelectorAll('[data-goal]').forEach(function(el){
        if (el.tagName === 'FORM') return;
        el.addEventListener('click', function(){
          window.trackGoal(el.getAttribute('data-goal'), {page: location.pathname});
        });
      });
    });
  </script>
