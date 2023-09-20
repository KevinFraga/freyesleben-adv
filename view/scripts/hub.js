function carouselControlsNext() {
  const currentSlide = document.getElementsByClassName('selected');
  const slideNumber = parseInt(currentSlide[0].getAttribute('name'));
  const nextSlide =  slideNumber < 16 ? document.getElementsByName(`${slideNumber + 1}`) : document.getElementsByName('1');
  currentSlide[0].className = 'not';
  nextSlide[0].className = 'selected';
}

function carouselControlsPrev() {
  const currentSlide = document.getElementsByClassName('selected');
  const slideNumber = parseInt(currentSlide[0].getAttribute('name'));
  const prevSlide =  slideNumber > 1 ? document.getElementsByName(`${slideNumber - 1}`) : document.getElementsByName('16');
  currentSlide[0].className = 'not';
  prevSlide[0].className = 'selected';
}

for (let i = 0; i < document.getElementsByClassName('next-slide').length; i++) {
  document.getElementsByClassName('next-slide')[i].addEventListener('click', carouselControlsNext);
}
for (let j = 0; j < document.getElementsByClassName('prev-slide').length; j++) {
  document.getElementsByClassName('prev-slide')[j].addEventListener('click', carouselControlsPrev);
}
