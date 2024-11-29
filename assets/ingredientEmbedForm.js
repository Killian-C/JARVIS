const ingredientsContainer = document.getElementById('ingredients-container');
ingredientForm = ingredientsContainer.dataset.prototype;
addIngredientButton = document.getElementById('add-ingredient');
let index = 0;
const regex = /__name__/g;
addIngredientButton.addEventListener('click', (e) => {
    e.preventDefault();
    index++;
    let listedForm = document.createElement('li');
    listedForm.innerHTML = ingredientForm.replace(regex, 'ingredient_' + index);
    ingredientsContainer.appendChild(listedForm);
})