$(document).ready(() => {
    const filter = () => {
        const distance = parseFloat(document.getElementById('distance').value);
        const cuisine = document.getElementById('cuisine').options[document.getElementById('cuisine').selectedIndex].value;
        const minorder = parseFloat(document.getElementById('minorder').options[document.getElementById('minorder').selectedIndex].value);
        const deliverycost = parseFloat(document.getElementById('deliverycost').options[document.getElementById('deliverycost').selectedIndex].value);
        const restaurantBoxes = document.getElementsByClassName('restaurant-box');
        console.log('Im inside of filter!');
        // if (!restaurantBoxes || !distance || !minorder || !deliverycost || restaurantBoxes.length <= 0) return;

        for (let i = 0, iMax = restaurantBoxes.length; i < iMax; i++) {
            let distanceAccepted = false;
            let cuisineAccepted = false;
            let minorderAccepted = false;
            let deliverycostAccepted = false;
            let allFilterPassed = false;

            const restaurantDistance = parseFloat(restaurantBoxes[i].getElementsByClassName('r-distance')[0].innerText);
            const restaurantCuisine = restaurantBoxes[i].getElementsByClassName('r-cuisine')[0].innerText;
            const restaurantMinorder = parseFloat(restaurantBoxes[i].getElementsByClassName('r-minorder')[0].innerText);
            const restaurantDeliverycost = parseFloat(restaurantBoxes[i].getElementsByClassName('r-deliverycost')[0].innerText);

            if(distance >= restaurantDistance || distance === 0 || !distance) distanceAccepted = true;
            if(cuisine === restaurantCuisine || cuisine === 'any' || !cuisine) cuisineAccepted = true;
            if(minorder >= restaurantMinorder || minorder === 0 || !minorder) minorderAccepted = true;
            if(deliverycost >= restaurantDeliverycost || deliverycost === 0 || !deliverycost) deliverycostAccepted = true;
            if (distanceAccepted && cuisineAccepted && minorderAccepted && deliverycostAccepted) allFilterPassed = true;

            if (allFilterPassed) {
                    restaurantBoxes[i].style.display = 'flex';
            } else {
                    restaurantBoxes[i].style.display = 'none';
            }
        }
    }

    $('#distance').on('change keyup paste', filter);
    $('#cuisine').on('change', filter);
    $('#minorder').on('change', filter);
    $('#deliverycost').on('change', filter);

    // const $wrapper = $('.restaurant-results');
    // $wrapper.find('.restaurant-box').sort(function (a, b) {
    //     return +a.dataset.name - +b.dataset.distance;
    // })

});
