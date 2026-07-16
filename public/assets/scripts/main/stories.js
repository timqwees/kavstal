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
  var muteBtn = document.getElementById('storyMute');
  var muteIcon = document.getElementById('muteIcon');
  var unmuteIcon = document.getElementById('unmuteIcon');
  var currentStory = 0, currentSlide = 0, timer = null, muted = true;

  function open(storyIndex){
    currentStory = storyIndex;
    currentSlide = 0;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    render();
  }
  function close(){
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    clearTimeout(timer);
    video.pause();
    video.classList.add('hidden');
    video.src = '';
  }
  function render(){
    var s = storiesData[currentStory];
    var sl = s.slides[currentSlide];
    title.textContent = sl.title;
    if (sl.video) {
      image.classList.add('hidden');
      video.classList.remove('hidden');
      video.src = sl.video;
      video.muted = muted;
      video.currentTime = 0;
      video.play().catch(function(){});
      video.onloadedmetadata = function(){
        var dur = Math.round(video.duration * 1000);
        animateProgress(dur);
        clearTimeout(timer);
        timer = setTimeout(function(){ advance(); }, dur);
      };
    } else {
      video.classList.add('hidden');
      video.pause();
      video.src = '';
      image.classList.remove('hidden');
      image.src = sl.bg;
      animateProgress(5000);
      startTimer();
    }
    progress.innerHTML = '';
    s.slides.forEach(function(_, i){
      var bar = document.createElement('div');
      bar.className = 'flex-1 h-[3px] rounded-full overflow-hidden bg-white/30';
      var fill = document.createElement('div');
      fill.className = 'h-full bg-white rounded-full';
      if (i < currentSlide) fill.style.width = '100%';
      bar.appendChild(fill);
      progress.appendChild(bar);
    });
    prevBtn.style.display = currentSlide > 0 ? '' : 'none';
    nextBtn.style.display = '';
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
    if (currentSlide > 0){ clearTimeout(timer); video.pause(); currentSlide--; render(); }
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
      open(parseInt(this.getAttribute('data-story-index'), 10));
    });
  });
  closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', close);
  muteBtn.addEventListener('click', function(e){
    e.stopPropagation();
    muted = !muted;
    video.muted = muted;
    muteIcon.classList.toggle('hidden', muted);
    unmuteIcon.classList.toggle('hidden', !muted);
  });
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
