const ingredientsContainer = document.getElementById('ingredients-container');
ingredientForm = ingredientsContainer.dataset.prototype;
addIngredientButton = document.getElementById('add-ingredient');
let index = 0;
const regex = /__name__/g;
addIngredientButton.addEventListener('click', (e) => {
    e.preventDefault();
    index++;

    let listedForm = document.createElement('li');
    const suffix = 'ingredient_' + index;
    const formId = 'recipe_ingredients_' + suffix;

    listedForm.innerHTML = ingredientForm.replace(regex, suffix);

    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML  = '<i class="fas fa-trash"></i>'
    deleteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        listedForm.remove();
    })
    listedForm.appendChild(deleteBtn);

    ingredientsContainer.appendChild(listedForm);
})