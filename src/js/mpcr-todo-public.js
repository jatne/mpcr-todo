const mpcrTodos = document.querySelectorAll('.mpcr-todo');

const countRows = mpcrTodoMain => {
  const itemsWrapper = mpcrTodoMain.querySelector('.mpcr-todo__items');

  return !itemsWrapper.children.length
    ? 1
    : Math.max.apply(
        null,
        [...itemsWrapper.children].map(item => parseInt(item.dataset.row))
      ) + 1;
};

const handleUpdateTodo = (todoData, todoId) => {
  const data = new FormData();
  data.append('action', 'update_mpcr_todo_items');
  data.append('ajaxnonce', ajax_object.ajaxnonce);
  data.append('todo_id', todoId);
  data.append('todo_data', todoData);

  fetch(ajax_object.ajaxurl, {
    method: 'POST',
    credentials: 'same-origin',
    body: data,
  })
    .then(response => response.json())
    .then(res => {
      if (res) {
        console.log(res);
      }
    })
    .catch(error => {
      console.error(error);
    });
};

const prepare = mpcrTodoMain => {
  const items = mpcrTodoMain.querySelectorAll(
    '.mpcr-todo__items .mpcr-todo__item'
  );

  const updatedItems = [...items].map(item => {
    const label = item.querySelector('[name="label"]').value;
    const status = item.querySelector('[name="status"]').checked;

    return {
      label,
      status,
    };
  });

  return JSON.stringify(updatedItems);
};

const removeItem = (el, mpcrTodoMain) => {
  mpcrTodoMain
    .querySelector(`.mpcr-todo__item[data-row="${el.dataset.row}"]`)
    .remove();
  handleUpdateTodo(prepare(mpcrTodoMain), mpcrTodoMain.dataset.todoId);
};

const handleNewItem = (event, mpcrTodoMain) => {
  if (event.key !== 'Enter' || !event.currentTarget.value) {
    return false;
  }

  addNewItem(event.currentTarget, mpcrTodoMain);
};

const handleExistingItems = (event, mpcrTodoMain) => {
  if (event.type === 'focusout' || event.key === 'Enter') {
    handleUpdateTodo(prepare(mpcrTodoMain), mpcrTodoMain.dataset.todoId);
  }

  if (event.key === 'Backspace') {
    if (!event.currentTarget.value) {
      removeItem(event.currentTarget, mpcrTodoMain);
    }
  }
};

const addNewItem = (el, mpcrTodoMain) => {
  const template = `
        <div class="mpcr-todo__item" data-row="${countRows(mpcrTodoMain)}">
          <div class="mpcr-todo__status">
            <input name="status" type="checkbox"/>
          </div>
          <div class="mpcr-todo__label">
            <input name="label" type="text" value="${
              el.value
            }" data-row="${countRows(mpcrTodoMain)}" />
          </div>
        </div>
  `;

  mpcrTodoMain
    .querySelector('.mpcr-todo__items')
    .insertAdjacentHTML('beforeend', template);

  el.value = '';

  mpcrTodoMain
    .querySelectorAll('.mpcr-todo__items input[type="text"]')
    .forEach(label => {
      label.addEventListener('keyup', event =>
        handleExistingItems(event, mpcrTodoMain)
      );
      label.addEventListener('focusout', event =>
        handleExistingItems(event, mpcrTodoMain)
      );
    });

  mpcrTodoMain
    .querySelectorAll('.mpcr-todo__items input[type="checkbox"]')
    .forEach(status =>
      status.addEventListener('change', () =>
        handleUpdateTodo(prepare(mpcrTodoMain), mpcrTodoMain.dataset.todoId)
      )
    );

  handleUpdateTodo(prepare(mpcrTodoMain), mpcrTodoMain.dataset.todoId);
};

mpcrTodos.forEach(mpcrTodo => {
  const addNewInput = mpcrTodo.querySelector(
    '.mpcr-todo__new input[type="text"]'
  );

  const addedItemsLabels = mpcrTodo.querySelectorAll(
    '.mpcr-todo__items input[type="text"]'
  );

  const addedItemsStatus = mpcrTodo.querySelectorAll(
    '.mpcr-todo__items input[type="checkbox"]'
  );

  addNewInput.addEventListener('keyup', event =>
    handleNewItem(event, mpcrTodo)
  );

  addedItemsLabels.forEach(label => {
    label.addEventListener('keyup', event =>
      handleExistingItems(event, mpcrTodo)
    );
    label.addEventListener('focusout', event =>
      handleExistingItems(event, mpcrTodo)
    );
  });
  addedItemsStatus.forEach(status =>
    status.addEventListener('change', () => {
      handleUpdateTodo(prepare(mpcrTodo), mpcrTodo.dataset.todoId);
    })
  );
});
