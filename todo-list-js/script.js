//Select tags
const addTaskBtn = document.getElementById('add-task-btn');
const deskTaskInput = document.getElementById('description-task');
const todosWrapper = document.querySelector('.todos-wrapper');
//If local storage is not empty parse it
let tasks;
!localStorage.tasks ? tasks = [] : tasks = JSON.parse(localStorage.getItem('tasks'));

let todoItemElems = [];
//Create object task 
function Task(description) {
    this.description = description;
    this.completed = false;
}
//Make template
const createTemplate = (task, index) => {
    return `<div class="todo-item ${task.completed ? 'checked' : ''}">
                <div class="description">${task.description}</div>
                <div class="buttons">
                    <input onclick="completeTask(${index})" class="btn-complete" type="checkbox" ${task.completed ? 'checked' : ''}>
                    <button onclick=" deleteTask(${index})" class="btn-delete">Delete</button>
                </div>
            </div>`
}
//Filter active and completed tasks 
const filterTasks = () => {
    const activeTasks = tasks.length && tasks.filter(item => item.completed  == false);
    const completedTasks = tasks.length && tasks.filter(item => item.completed == true);
    tasks = [...activeTasks,...completedTasks];
}
//Write list into html
const fillHtmlList = () => {
    todosWrapper.innerHTML = "";
    if(tasks.length > 0) {
        filterTasks();
        tasks.forEach((item, index) => {
            todosWrapper.innerHTML += createTemplate(item, index);
        });
        todoItemElems = document.querySelectorAll('.todo-item');
    }
}

fillHtmlList();
//Refresh local storage
const updateLocal = () => {
    localStorage.setItem('tasks', JSON.stringify(tasks));
}
//If task is completed
const completeTask = index => {
    tasks[index].completed = !tasks[index].completed;
    if (tasks[index].completed) {
        todoItemElems[index].classList.add('checked');
    } else {
        todoItemElems[index].classList.remove('checked');
    }
    updateLocal();
    fillHtmlList();
}
//Listen to add button click
addTaskBtn.addEventListener('click', () => {
    tasks.push(new Task(deskTaskInput.value));
    updateLocal();
    fillHtmlList();
    deskTaskInput.value = '';
})
 
const deleteTask = index => {
    todoItemElems[index].classList.add('delition');
    setTimeout(() => {
        tasks.splice(index, 1);
        updateLocal();
        fillHtmlList();
    },500)
}

const tasksListElement = document.querySelector(`.todos-wrapper`);
const taskElements = tasksListElement.querySelectorAll(`.todo-item`);
//Loop through all the elements of the list and assign true
for (const task of taskElements) {
  task.draggable = true;
}

tasksListElement.addEventListener(`dragstart`, (evt) => {
    evt.target.classList.add(`selected`);
})
  
tasksListElement.addEventListener(`dragend`, (evt) => {
    evt.target.classList.remove(`selected`);
});

tasksListElement.addEventListener(`dragover`, (evt) => {
    //Allows drop items in this area
    evt.preventDefault();
    //Select the moving element
    const activeElement = tasksListElement.querySelector(`.selected`);
    //Finds the element over which the cursor is currently located
    const currentElement = evt.target;
    //Checking if the event is fired:
    //1. not on the element we are moving,
    //2. on the element of the list
    const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`todo-item`);
    //If not, to abort the execution of the function
    if (!isMoveable) {
      return;
    }
    //Finds the element before which to will insert
    const nextElement = (currentElement === activeElement.nextElementSibling) ?
        currentElement.nextElementSibling :
        currentElement;
  
    //Insert activeElement before nextElement
    tasksListElement.insertBefore(activeElement, nextElement);
});

const getNextElement = (cursorPosition, currentElement) => {
    //Get an object with dimensions and coordinates
    const currentElementCoord = currentElement.getBoundingClientRect();
    //Finds the vertical coordinate of the center of the current element
    const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
    //If the cursor is higher the center of the element, return the current element
    //Otherwise, the next DOM element
    const nextElement = (cursorPosition < currentElementCenter) ?
        currentElement :
        currentElement.nextElementSibling;
  
    return nextElement;
};

tasksListElement.addEventListener(`dragover`, (evt) => {
    evt.preventDefault();
  
    const activeElement = tasksListElement.querySelector(`.selected`);
    const currentElement = evt.target;
    const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`todo-item`);
  
    if (!isMoveable) {
      return;
    }

    //evt.clientY - vertical coordinate of the cursor at the moment,
    //when the event it worked
    const nextElement = getNextElement(evt.clientY, currentElement);
    //Checking, do it need to swap elements
    if (
      nextElement && 
      activeElement === nextElement.previousElementSibling ||
      activeElement === nextElement
    ) {
    //If not, exiting the function to avoid unnecessary changes to the DOM
    return;
    }
  
    tasksListElement.insertBefore(activeElement, nextElement);
});