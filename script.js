const pearlForm = document.getElementById('pearl-form');
const pearlInput = document.getElementById('pearl');
const marquee = document.querySelector('.marquee');

pearlForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const pearl = pearlInput.value.trim();
  if (pearl.length > 0) {
    const pearlElement = document.createElement('span');
    pearlElement.textContent = pearl;
    pearlElement.style.paddingRight = '10px';
    marquee.appendChild(pearlElement);
    pearlInput.value = '';
    savePearl(pearl);
  }
});

function savePearl(pearl) {
  const pearls = JSON.parse(localStorage.getItem('pearls')) || [];
  pearls.push(pearl);
  localStorage.setItem('pearls', JSON.stringify(pearls));
}

function loadPearls() {
  const pearls = JSON.parse(localStorage.getItem('pearls')) || [];
  pearls.forEach((pearl) => {
    const pearlElement = document.createElement('