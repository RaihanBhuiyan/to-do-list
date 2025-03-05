<template>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
      <h3 class="text-center mb-4">Register</h3>
      <!-- Registration Form -->
      <form @submit.prevent="registerUser">
        <!-- Name Input -->
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" id="name" class="form-control" v-model="name" placeholder="Enter your full name" required />
        </div>

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

        <!-- Confirm Password Input -->
        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" id="confirm_password" class="form-control" v-model="confirmPassword" placeholder="Confirm your password" required />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Register</button>

        <!-- Error Message -->
        <p v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</p>
        <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p>
      </form>

      <!-- Login Link -->
      <div class="text-center mt-3">
        <p>Already have an account? <router-link to="/" class="text-decoration-none">Login here</router-link></p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      errorMessage: '',
      successMessage: '',
    };
  },
  methods: {
    async registerUser() {
      if (this.password !== this.confirmPassword) {
        this.errorMessage = "Passwords don't match.";
        return;
      }
      
      try {
        const response = await axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        });

        if (response.status === 201) {
          this.successMessage = 'Registration successful! You can now log in.';
          this.errorMessage = '';  // Clear any previous error message
          this.$router.push('/');  // Redirect to login page after successful registration
        }
      } catch (error) {
        this.errorMessage = 'An error occurred during registration. Please try again.';
        this.successMessage = '';  // Clear success message
      }
    },
  },
};
</script>
