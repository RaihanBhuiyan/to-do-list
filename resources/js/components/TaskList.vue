<template>
  <div class="container mt-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold">Task Manager</h2>
      <button class="btn btn-warning" @click="logout">Logout</button>
    </div>

    <div class="row">
      <!-- Pending Tasks -->
      <div class="col-md-6">
        <h4 class="text-primary">Pending Tasks</h4>
        <ul class="list-group list-group-flush">
          <li
            v-for="task in pendingTasks"
            :key="task.id"
            class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded mb-3"
            style="transition: transform 0.2s ease, box-shadow 0.3s ease;"
            @mouseover="hover = true"
            @mouseleave="hover = false"
          >
            <div>
              <strong>{{ task.title }}</strong>
              <p class="text-muted">{{ task.description }}</p> <!-- Show task description -->
            </div>
            <div>
              <button
                class="btn btn-success btn-sm"
                @click="markAsCompleted(task.id)"
              >
                Mark as Completed
              </button>
              <button
                class="btn btn-danger btn-sm ms-2"
                @click="deleteTask(task.id)"
              >
                Delete
              </button>
            </div>
          </li>
        </ul>
      </div>

      <!-- Completed Tasks -->
      <div class="col-md-6">
        <h4 class="text-success">Completed Tasks</h4>
        <ul class="list-group list-group-flush">
          <li
            v-for="task in completedTasks"
            :key="task.id"
            class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded mb-3"
            style="transition: transform 0.2s ease, box-shadow 0.3s ease;"
            @mouseover="hover = true"
            @mouseleave="hover = false"
          >
            <div>
              <strong class="text-decoration-line-through">{{ task.title }}</strong>
              <p class="text-decoration-line-through text-muted">{{ task.description }}</p> <!-- Show task description -->
            </div>
            <div>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteTask(task.id)"
              >
                Delete
              </button>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Add New Task -->
    <div class="mt-4">
      <h4 class="text-info">Add New Task</h4>
      <div class="input-group mb-3">
        <input
          type="text"
          v-model="newTask.title"
          class="form-control"
          placeholder="Enter task title"
        />
        <textarea
          v-model="newTask.description"
          class="form-control"
          placeholder="Enter task description"
        ></textarea>
        <button class="btn btn-primary" @click="addTask">Add Task</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [],
      newTask: {
        title: '',
        description: '', // New description field
      },
      hover: false, // Hover effect
    };
  },
  computed: {
    pendingTasks() {
      return this.tasks.filter((task) => !task.is_completed);
    },
    completedTasks() {
      return this.tasks.filter((task) => task.is_completed);
    },
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await axios.get('/api/tasks', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    async addTask() {
      if (!this.newTask.title) return;
      try {
        await axios.post('/api/tasks', this.newTask, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
        this.fetchTasks(); // Refresh task list
        this.newTask.title = ''; // Clear title input
        this.newTask.description = ''; // Clear description input
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async markAsCompleted(id) {
      try {
        await axios.put(
          `/api/tasks/${id}`,
          { is_completed: true },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          }
        );
        this.fetchTasks(); // Refresh task list after update
      } catch (error) {
        console.error('Error marking task as completed:', error);
      }
    },
    async deleteTask(id) {
      try {
        await axios.delete(`/api/tasks/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
          },
        });
        this.fetchTasks(); // Refresh task list after delete
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    },
    logout() {
      localStorage.removeItem('auth_token');
      this.$router.push('/'); // Redirect to login
    },
  },
  mounted() {
    const token = localStorage.getItem('auth_token');
    if (token) {
      this.fetchTasks(); // Fetch tasks only if authenticated
    } else {
      this.$router.push('/'); // Redirect to login if not authenticated
    }
  },
};
</script>

<style scoped>
/* Custom Styles */
h2 {
  font-size: 2.5rem;
  font-weight: bold;
  color: #343a40;
}

button {
  font-weight: 600;
}

.list-group-item {
  background-color: #f8f9fa;
  border: 1px solid #ddd;
  transition: all 0.3s ease;
}

.list-group-item:hover {
  transform: scale(1.02);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

textarea {
  height: 80px;
}

input,
textarea {
  border-radius: 8px;
  border: 1px solid #ddd;
}

input:focus,
textarea:focus {
  border-color: #007bff;
  outline: none;
}

input::placeholder,
textarea::placeholder {
  color: #999;
}

.btn {
  border-radius: 8px;
}

.text-decoration-line-through {
  color: #6c757d;
}

.text-muted {
  font-size: 0.9rem;
}
</style>
