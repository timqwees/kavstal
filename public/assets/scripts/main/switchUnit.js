function switchUnit(btn){
  var card = btn.closest('[itemscope]');
  if(!card) return;
  var price = card.querySelector('.price-display');
  var all = card.querySelectorAll('[data-unit]');
  all.forEach(function(b){ b.classList.remove('bg-red-100','text-red-800'); b.classList.add('bg-gray-100','text-gray-500'); });
  btn.classList.remove('bg-gray-100','text-gray-500'); btn.classList.add('bg-red-100','text-red-800');
  if(price) price.textContent = btn.getAttribute('data-price') + ' ₽';
}
