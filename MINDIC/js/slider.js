
const slides = [

    [
        {
            img:'images/recean.png',
            title:'Revenirea lui Dorin Recean în satul de baștină'
        },
        {
            img:'images/vila.png',
            title:'Vila Ohanovici în 2024.Oportunități'
        },
        {
            img:'images/portul.png',
            title:'A șaptea ediție a festivalului "Portului Popular și al Pâinii"'
        }
    ],

    [
        {
            img:'images/a 7-a editie.jpg',
            title:'A șaptea ediție a festivalului "Portului Popular și al Pâinii"'
        },
        {
            img:'images/recean.png',
            title:'Revenirea lui Dorin Recean în satul de baștină'
        },
        {
            img:'images/vila.png',
            title:'Vila Ohanovici în 2024. Oportunități'
        }
    ],

    [
        {
            img:'images/oportunitati.jpg',
            title:'Vila Ohanovici în 2024. Oportunități'
        },
        {
            img:'images/a 7-a editie.jpg',
            title:'A șaptea ediție a festivalului "Portului Popular și al Pâinii"'
        },
        {
            img:'images/recean.png',
            title:'Revenirea lui Dorin Recean'
        }
    ],

    [
        {
            img:'images/ursulet.jpg',
            title:'Ursuleț'
        },
        {
            img:'images/oportunitati.jpg',
            title:'Vila Ohanovici în 2024. Oportunități'
        },
        {
            img:'images/a 7-a editie.jpg',
            title:'A șaptea ediție a festivalului "Portului Popular și al Pâinii"'
        }
    ]
];

let current = 0;

function renderSlide(){

    document.getElementById('img1').src = slides[current][0].img;
    document.getElementById('title1').innerText = slides[current][0].title;

    document.getElementById('img2').src = slides[current][1].img;
    document.getElementById('title2').innerText = slides[current][1].title;

    document.getElementById('img3').src = slides[current][2].img;
    document.getElementById('title3').innerText = slides[current][2].title;
}

document.getElementById('nextBtn').onclick = () => {

    current++;

    if(current >= slides.length){
        current = 0;
    }

    renderSlide();
};

document.getElementById('prevBtn').onclick = () => {

    current--;

    if(current < 0){
        current = slides.length - 1;
    }

    renderSlide();
};

renderSlide();