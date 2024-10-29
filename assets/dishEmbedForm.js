const dishBlocks = document.getElementsByClassName('dishes-block');
dishBlocks.forEach( container => {
    let dishForm  = container.dataset.prototype;
    let id        = container.getAttribute('data-block-id');
    let addButton = document.querySelector(`#btn-${id}`);
    addButton.addEventListener('click', (e) => {
        e.preventDefault();
        let dishCount = addButton.getAttribute('data-dish-index');
        dishCount++;
        addButton.setAttribute('data-dish-index', dishCount);
        let listedForm       = document.createElement('li');
        listedForm.classList.add('dish-form');
        const regexDish      = /__name__/g;
        let newDishForm      = dishForm.replace(regexDish, 'dish_' + dishCount);
        listedForm.innerHTML = newDishForm;
        container.appendChild(listedForm);
    });
});