<template>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
      <h3 class="text-center mb-4">Login</h3>
      <!-- Login Form -->
      <form @submit.prevent="loginUser">
        <!-- Email Input -->
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" class="form-control" v-model="email" placeholder="Enter your email" required />
        </div>

        <!-- Password Input -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control" v-model="password" placeholder="Enter your password" required />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Login</button>

        <!-- Error Message -->
        <p v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</p>
      </form>

      <!-- Register Link -->
      <div class="text-center mt-3">
        <p>Don't have an account? <router-link to="/register" class="text-decoration-none">Register here</router-link></p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        });

        if (response.status === 200) {
          // Save the token to localStorage
          localStorage.setItem('auth_token', response.data.token);
          // Redirect to task list after successful login
          this.$router.push('/task-list');
        }
      } catch (error) {
        this.errorMessage = 'Invalid credentials. Please try again.';
      }
    },
  },
};
</script>
