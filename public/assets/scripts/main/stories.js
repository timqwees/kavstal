(function(){
  var storiesData = window.__storiesData || [];
  var modal = document.getElementById('storyModal');
  if (!modal || !storiesData.length) return;
  var overlay = document.getElementById('storyOverlay');
  var progress = document.getElementById('storyProgress');
  var image = document.getElementById('storyImage');
  var video = document.getElementById('storyVideo');
  var title = document.getElementById('storyTitle');
  var prevBtn = document.getElementById('storyPrev');
  var nextBtn = document.getElementById('storyNext');
  var nextStoryBtn = document.getElementById('storyNextBtn');
  var closeBtn = document.getElementById('storyClose');
  var soundBtn = document.getElementById('storySound');
  var soundOn = soundBtn ? soundBtn.querySelector('.story-sound-on') : null;
  var soundOff = soundBtn ? soundBtn.querySelector('.story-sound-off') : null;
  var currentStory = 0, currentSlide = 0, timer = null, muted = false;

  function updateSoundUI(){
    if (!soundBtn) return;
    if (soundOn) soundOn.classList.toggle('hidden', muted);
    if (soundOff) soundOff.classList.toggle('hidden', !muted);
  }

  function open(storyIndex, slideIndex){
    currentStory = storyIndex;
    currentSlide = slideIndex || 0;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    render();
  }
  function close(){
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    clearTimeout(timer);
    timer = null;
    video.pause();
    video.classList.add('hidden');
    video.src = '';
    video.onloadedmetadata = null;
    video.onerror = null;
    if (soundBtn) soundBtn.style.display = 'none';
  }
  function render(){
    var s = storiesData[currentStory];
    var sl = s.slides[currentSlide];
    title.textContent = sl.title || s.title || '';
    if (soundBtn) soundBtn.style.display = sl.video ? 'flex' : 'none';
    updateSoundUI();
    if (sl.video) {
      image.classList.add('hidden');
      video.classList.remove('hidden');
      if (video.src !== sl.video) {
        video.src = sl.video;
        video.currentTime = 0;
        video.onloadedmetadata = null;
        video.onerror = null;
        video.onloadedmetadata = function(){
          if (video.src !== sl.video) return;
          var dur = Math.round(video.duration * 1000);
          if (!isFinite(dur) || dur <= 0) dur = 15000;
          animateProgress(dur);
          clearTimeout(timer);
          timer = setTimeout(function(){ advance(); }, dur);
        };
        video.onerror = function(){
          if (video.src !== sl.video) return;
          fallbackToImage();
        };
      } else {
        video.currentTime = 0;
        clearTimeout(timer);
        animateProgress(Math.round((video.duration || 15) * 1000));
        timer = setTimeout(function(){ advance(); }, Math.round((video.duration || 15) * 1000));
      }
      video.muted = muted;
      video.play().catch(function(){});
    } else {
      fallbackToImage();
    }
    progress.innerHTML = '';
    s.slides.forEach(function(_, i){
      var bar = document.createElement('div');
      bar.className = 'flex-1 h-[3px] rounded-full overflow-hidden bg-white/30';
      var fill = document.createElement('div');
      fill.className = 'h-full bg-white rounded-full';
      fill.style.width = i < currentSlide ? '100%' : '0%';
      bar.appendChild(fill);
      progress.appendChild(bar);
    });
  }
  function fallbackToImage(){
    var sl = storiesData[currentStory].slides[currentSlide];
    video.classList.add('hidden');
    video.pause();
    video.src = '';
    image.classList.remove('hidden');
    image.src = sl.bg || '';
    animateProgress(5000);
    startTimer();
  }
  function animateProgress(dur){
    var bars = progress.children;
    if (!bars[currentSlide]) return;
    var fill = bars[currentSlide].querySelector('div');
    if (!fill) return;
    fill.style.width = '0%';
    requestAnimationFrame(function(){
      fill.style.transition = 'width ' + dur + 'ms linear';
      fill.style.width = '100%';
    });
  }
  function advance(){
    var s = storiesData[currentStory];
    if (currentSlide < s.slides.length - 1){ currentSlide++; render(); }
    else { nextStory(); }
  }
  function nextSlide(){
    clearTimeout(timer);
    video.pause();
    advance();
  }
  function prevSlide(){
    clearTimeout(timer);
    video.pause();
    if (currentSlide > 0){ currentSlide--; render(); }
    else if (currentStory > 0){
      currentStory--;
      currentSlide = storiesData[currentStory].slides.length - 1;
      render();
    }
  }
  function nextStory(){
    clearTimeout(timer);
    video.pause();
    if (currentStory < storiesData.length - 1){ currentStory++; currentSlide = 0; render(); }
    else { close(); }
  }
  function startTimer(){
    clearTimeout(timer);
    timer = setTimeout(advance, 5000);
  }

  document.querySelectorAll('.story-card').forEach(function(card){
    card.addEventListener('click', function(e){
      e.preventDefault();
      open(
        parseInt(this.getAttribute('data-story-index'), 10),
        parseInt(this.getAttribute('data-slide-index'), 10)
      );
    });
  });
  closeBtn.addEventListener('click', close);
  if (soundBtn) {
    soundBtn.addEventListener('click', function(e){
      e.stopPropagation();
      muted = !muted;
      video.muted = muted;
      updateSoundUI();
    });
  }
  overlay.addEventListener('click', close);
  prevBtn.addEventListener('click', function(e){ e.stopPropagation(); prevSlide(); });
  nextBtn.addEventListener('click', function(e){ e.stopPropagation(); nextSlide(); });
  nextStoryBtn.addEventListener('click', function(e){ e.stopPropagation(); nextSlide(); });
  document.getElementById('storySlide').addEventListener('click', function(e){
    e.stopPropagation();
    nextSlide();
  });
  document.addEventListener('keydown', function(e){
    if (modal.classList.contains('hidden')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowRight') nextSlide();
    if (e.key === 'ArrowLeft') prevSlide();
  });
})();
