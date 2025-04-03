
import '../libs/@glidejs/glide/dist/glide.min.js';

document.addEventListener('DOMContentLoaded', function() {

	
	// Получаем все элементы с классом 'glide'
	const glideCarousel = document.querySelectorAll('.glide--carousel');

	// Проходимся по каждому элементу и инициализируем GlideJS
	glideCarousel.forEach(element => {
		new Glide(element, {
			perView: 3,
			animationDuration: 750,
			focusAt: 'center',
			type: "carousel",
			breakpoints: {
				1200: {
				perView: 3
				},
				960: {
				perView: 3
				},
				520: {
				perView: 2
				}
			}
		}).mount();
	});



	// Получаем все элементы с классом 'glide'
	const glideOne = document.querySelectorAll('.glide--one');

	// Проходимся по каждому элементу и инициализируем GlideJS
	glideOne.forEach(element => {
		new Glide(element, {
			perView: 1,
			animationDuration: 750,
			focusAt: 'center',
			type: "carousel"
		}).mount();
	});



	// Получаем все элементы с классом 'glide--post'
	const glidePost = document.querySelectorAll('.glide--post');

	// Проходимся по каждому элементу и инициализируем GlideJS
	glidePost.forEach(element => {
		const glideInstance = new Glide(element, {
			perView: 6,
			gap: 0,
			animationDuration: 250,
			type: "carousel",
			breakpoints: {
					1200: {
						perView: 5
					},
					960: {
						perView: 3
					},
					520: {
						perView: 1
					}
			}
		});

		// Добавляем обработчик события 'mount.after'
		glideInstance.on('mount.after', function() {
			const slides = element.querySelectorAll('.post--col-material');
			let maxHeight = 0;

			slides.forEach(slide => {
				if (slide.offsetHeight > maxHeight) {
					maxHeight = slide.offsetHeight;
				}
			});

			slides.forEach(slide => {
				slide.style.height = `${maxHeight+15}px`;
			});
		});

		// Монтируем GlideJS
		glideInstance.mount();
	});


})