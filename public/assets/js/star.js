const stars = document.getElementsByClassName('icon');
const starIcon = document.getElementsByClassName('fa-star-o');
for (let i = 0; i < stars.length; i++) {
    stars[i].addEventListener('click', (event) => {
        let counters = document.getElementsByClassName('count-' + event.target.dataset.articleid);

        fetch('/star/add', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'articleid': event.target.dataset.articleid,
                'userid': event.target.dataset.userid,
                'starcount': event.target.dataset.starcount,
            })
        })
            .then(response => response.json())
            .then(data => changeStarIcon(counters))
            .then(console.log(starIcon[i].classList))
            .then(data => addcount(counters,event.target.dataset.starcount))
    })
}
function addcount(counters, starcount) {
    for (let i = 0; i <= counters.length; i++) {
        counters[i].innerHTML = parseInt(starcount) + 1;
    }
}

function changeStarIcon(counters) {
    for (let j = 0; j <= counters.length; j++) {
        starIcon[j].classList.replace('fa-star-o', 'fa-star');
    }
}