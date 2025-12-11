<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    {{ __("You're logged in!") }} Welcome, {{ Auth::user()->name }}!
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h4 mb-4">My Tasks</h3>

                    <div class="mb-4">
                        <form id="addTaskForm" class="row g-2">
                            @csrf
                            <div class="col">
                                <input 
                                    type="text" 
                                    id="taskTitle" 
                                    name="title" 
                                    placeholder="Enter a new task..." 
                                    required
                                    class="form-control"
                                >
                            </div>
                            <div class="col-auto">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary"
                                >
                                    Add
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="tasksList">
                        <div class="text-center py-5 text-muted">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading tasks...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var token = document.querySelector('meta[name="csrf-token"]').content;

        window.onload = function() {
            loadTasks();
        };

        function loadTasks() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/tasks');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var tasks = JSON.parse(xhr.responseText);
                    var tasksList = document.getElementById('tasksList');
                    tasksList.innerHTML = '';

                    if (tasks.length === 0) {
                        tasksList.innerHTML = '<p class="text-center text-muted py-5">No tasks yet. Add your first task above!</p>';
                    } else {
                        for (var i = 0; i < tasks.length; i++) {
                            var task = tasks[i];
                            var checked = task.is_completed ? 'checked' : '';
                            var textClass = task.is_completed ? 'flex-grow-1 text-decoration-line-through text-muted' : 'flex-grow-1';
                            
                            var html = '<div class="d-flex align-items-center gap-3 p-3 bg-light rounded mb-2" data-task-id="' + task.id + '">';
                            html += '<input type="checkbox" ' + checked + ' onclick="toggleTask(' + task.id + ')" class="form-check-input" style="width: 20px; height: 20px; cursor: pointer;">';
                            html += '<span class="' + textClass + '">' + task.title + '</span>';
                            html += '<span class="text-muted small">' + task.time_ago + '</span>';
                            html += '</div>';
                            
                            tasksList.innerHTML += html;
                        }
                    }
                } else {
                    alert('Error loading tasks');
                }
            };
            
            xhr.send();
        }

        document.getElementById('addTaskForm').onsubmit = function(e) {
            e.preventDefault();
            
            var input = document.getElementById('taskTitle');
            var title = input.value.trim();
            
            if (title === '') {
                return;
            }
            
            var button = this.querySelector('button');
            button.disabled = true;
            button.textContent = 'Adding...';
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/tasks');
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            
            xhr.onload = function() {
                button.disabled = false;
                button.textContent = 'Add';
                
                if (xhr.status === 201) {
                    input.value = '';
                    loadTasks();
                } else {
                    alert('Error adding task');
                }
            };
            
            xhr.send(JSON.stringify({ title: title }));
        };

        function toggleTask(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('PUT', '/tasks/' + id);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    loadTasks();
                } else {
                    alert('Error updating task');
                }
            };
            
            xhr.send();
        }
    </script>
</x-app-layout>
