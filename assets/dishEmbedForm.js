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
        listedForm.innerHTML = dishForm.replace(regexDish, 'dish_' + dishCount);

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML  = '<i class="fas fa-trash"></i>'
        deleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            listedForm.remove();
        })
        listedForm.appendChild(deleteBtn);



        container.appendChild(listedForm);
    });
});