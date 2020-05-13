const countRows = () => {
  const itemsWrapper = document.querySelector('#mpcr-todo .mpcr-todo-items');

  return !itemsWrapper.children.length
    ? 1
    : Math.max.apply(
        null,
        [...itemsWrapper.children].map(item => parseInt(item.dataset.row))
      ) + 1;
};

const removeItem = event => {
  document
    .querySelector(
      `.mpcr-todo-item[data-row="${event.currentTarget.dataset.remove}"]`
    )
    .remove();
};

const addEventRemove = () => {
  document
    .querySelectorAll('.mpcr-todo-item__remove button')
    .forEach(btn => btn.addEventListener('click', removeItem));
};

const addNewFields = () => {
  const template = document.getElementById('template-mpcr-todo');
  const toDoItems = document.querySelector('#mpcr-todo .mpcr-todo-items');

  toDoItems.insertAdjacentHTML(
    'beforeend',
    template.innerHTML.replace(/{{ todoRowIndex }}/g, countRows())
  );

  addEventRemove();
};

document
  .getElementById('mpcr-todo-addnew')
  .addEventListener('click', addNewFields);

addEventRemove();
