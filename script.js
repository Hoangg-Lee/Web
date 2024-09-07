const header = document.querySelector('header');
const head_title = document.getElementById('header_title');
const d_btn1 = document.getElementById('d_btn1');
const d_btn2 = document.getElementById('d_btn2');
const slider_btn = document.querySelectorAll('.dot');


const backing = {
    fing: 'img/betman.jpg',
    sing: 'img/tru_bat_toan_ao_ly_.jpg',
    ting: 'img/Mot_Chut_Fact_logo_chen_vid.png',
}

const slider_load = (index) =>  {
    const images = [backing.fing, backing.sing, backing.ting]
    const titles = ["Game 1", "Game 2", "Game 3 "]

    header.style.background = `url(${images[index]}) no-repeat center center/cover`;
    header_title.innerText = titles[index];

    slider_btn.array.forEach((btn, i) => {
        btn.style.background = i === index ? "#fff" : "rgb(184, 184, 184, .1)"
    });

    d_btn1.href = "#"
    d_btn2.href = "#"
}

let currentIndex = 0;

const nextSlide = () => {
    currentIndex = (currentIndex + 1) % slider_btn.length;
    slider_load(currentIndex);
}

slider_btn.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        currentIndex = index;
        slider_load(currentIndex)
    })
})

setInterval(nextSlide, 15000)
slider_load(currentIndex)