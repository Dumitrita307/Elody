function toggleFavorite(product) {
    let fav = JSON.parse(localStorage.getItem('elody_fav')) || [];

    let exists = fav.find(item => item.id === product.id);

    if(exists){
        fav = fav.filter(item => item.id !== product.id);
    } else {
        fav.push(product);
    }

    localStorage.setItem('elody_fav', JSON.stringify(fav));
}