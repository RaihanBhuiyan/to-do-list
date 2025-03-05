<template>
  <div class="container mt-5">
    <div class="row">
      <!-- Pending Tasks -->
      <div class="col-md-6">
        <h4>Pending Tasks</h4>
        <ul class="list-group">
          <li v-for="task in pendingTasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{ task.title }}</span>
            <div>
              <button class="btn btn-success btn-sm" @click="markAsCompleted(task.id)">
                Mark as Completed
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">
                Delete
              </button>
            </div>
          </li>
        </ul>
      </div>

      <!-- Completed Tasks -->
      <div class="col-md-6">
        <h4>Completed Tasks</h4>
        <ul class="list-group">
          <li v-for="task in completedTasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
            <span class="text-decoration-line-through">{{ task.title }}</span>
            <div>
              <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">
                Delete
              </button>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Add New Task -->
    <div class="mt-4">
      <h4>Add New Task</h4>
      <div class="input-group">
        <input type="text" v-model="newTask" class="form-control" placeholder="Enter new task" />
        <button class="btn btn-primary" @click="addTask">Add Task</button>
      </div>
    </div>

    <!-- Logout Button -->
    <div class="mt-4">
      <button class="btn btn-warning" @click="logout">Logout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [],
      newTask: '',
    };
  },
  computed: {
    pendingTasks() {
      return this.tasks.filter(task => !task.completed);
    },
    completedTasks() {
      return this.tasks.filter(task => task.completed);
    }
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
      if (!this.newTask) return;
      try {
        await axios.post(
          '/api/tasks',
          { title: this.newTask },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
            },
          }
        );
        this.fetchTasks(); // Refresh task list
        this.newTask = ''; // Clear input
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async markAsCompleted(id) {
      try {
        await axios.put(
          `/api/tasks/${id}`,
          { completed: true },
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
    }
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
