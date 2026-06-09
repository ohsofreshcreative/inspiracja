import Swiper from 'swiper';
import { Autoplay } from 'swiper/modules';

const initSignsMarquee = (scope = document) => {
  const marquees = scope.querySelectorAll('.signs-marquee:not(.swiper-initialized)');

  if (!marquees.length) {
    return;
  }

  marquees.forEach((marquee) => {
    const slides = marquee.querySelectorAll('.swiper-slide');

    if (slides.length < 2) {
      return;
    }

    new Swiper(marquee, {
      modules: [Autoplay],
      slidesPerView: 'auto',
      spaceBetween: 24,
      loop: true,
      speed: 7000,
      allowTouchMove: false,
      grabCursor: false,
      freeMode: false,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
      },
      breakpoints: {
        768: {
          spaceBetween: 32,
        },
        1280: {
          spaceBetween: 48,
        },
      },
    });
  });
};

initSignsMarquee();

if (window.acf) {
  window.acf.addAction('render_block', (el) => {
    const node = el?.[0] ?? el;

    if (node) {
      initSignsMarquee(node);
    }
  });
}

export default initSignsMarquee;