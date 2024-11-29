const listItemsContainer = document.getElementById('list-items-container');
const checkBoxes = listItemsContainer.querySelectorAll('.js-checkbox');


checkBoxes.forEach((checkBox) => {

    checkBox.addEventListener('click', () => {
        const listItemId = checkBox.dataset.listItemId
        const isChecked = checkBox.checked;
        const data = {
            listItemId: listItemId,
            isChecked: isChecked
        }


        fetch('/shopping-list/async-set-checked-on-list-item', {
            method: 'POST',
            body: JSON.stringify(data)
        })
        .then(r => {

            if (r.ok) {
                const labelToApplyStyle= listItemsContainer.querySelector(`#list-item-${ listItemId }-label`);
                applyStyleOnLabelFromChecked(labelToApplyStyle, isChecked);
            }

        })
        .catch(error => console.error(error))

    })
})

const applyStyleOnLabelFromChecked = (label, isChecked) => {
    if (isChecked) {
        label.classList.remove('text-dark');
        label.classList.add('checked-item');
        return;
    }
    label.classList.remove('checked-item');
    label.classList.add('text-dark');
};
