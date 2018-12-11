var radios = document.ratingForm.customRadio;

const getRatingUrl = 'http://projektbafis.test/api/movies/getRating';
const changeRatingUrl = 'http://projektbafis.test/api/movies/changeRating';

const params = {
    headers:{
        "Content-type": "application/json"
    },
    body: JSON.stringify(data),
    method:"POST"
}

fetch(getRatingUrl, params)
        .then(resp=>resp.json())
        .then(resp=> {
            if(resp.data != null) {
                radios[resp.data-1].checked = true;
            } else {
                console.log(resp.message);
            }
        })
        .catch(error=>console.log(error))

radios.forEach((radio) => {
    radio.addEventListener('change', function() {
        data.ratingValue = radio.value;
        params.body = JSON.stringify(data);

        fetch(changeRatingUrl, params)
        .then(resp=>resp.json())
        .then(resp=> {
            console.log(resp);
        })
        .catch(error=>console.log(error))
    })
})