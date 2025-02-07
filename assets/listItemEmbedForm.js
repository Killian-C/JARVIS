const listItemsContainer = document.getElementById('list-items-container');
listItemsForm = listItemsContainer.dataset.prototype;
addListItemButton = document.getElementById('add-list-item');
let index = 0;
const regex = /__name__/g;
addListItemButton.addEventListener('click', (e) => {
    e.preventDefault();
    index++;
    let listedForm = document.createElement('li');
    listedForm.innerHTML = listItemsForm.replace(regex, 'list_item_' + index);

    listedForm.querySelector('#shopping_list_listItems_list_item_' + index + '_quantity').value = 1;
    const listedFormDiv = listedForm.querySelector('#shopping_list_listItems_list_item_' + index);
    listedFormDiv.classList.add('d-flex', 'justify-content-around', 'align-items-center');

    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML  = '<i class="fas fa-trash"></i>'
    deleteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        listedForm.remove();
    })
    listedForm.appendChild(deleteBtn);

    listItemsContainer.appendChild(listedForm);
})