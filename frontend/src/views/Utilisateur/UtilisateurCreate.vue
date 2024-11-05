<template>
    <div class="user-create-container">
      <h2>Create New User</h2>
      <form @submit.prevent="createUser">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" v-model="username" required />
        </div>
        
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required />
        </div>
  
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password" required />
        </div>
        
        <div class="form-group">
          <label for="roles">Roles</label>
          <select id="roles" v-model="role" required>
            <option value="ROLE_USER">User</option>
            <option value="ROLE_ADMIN">Admin</option>
          </select>
        </div>
  
        <button type="submit">Create User</button>
      </form>
      
      <div v-if="message" class="message">
        {{ message }}
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'UtilisateurCreate',
    data() {
      return {
        username: '',
        email: '',
        password: '',
        role: 'ROLE_USER',
        message: '',
      };
    },
    methods: {
      async createUser() {
        try {
          await axios.post('/api/users', {
            username: this.username,
            email: this.email,
            password: this.password,
            roles: [this.role],
          });
          this.message = "User created successfully!";
          
          // Clear form fields
          this.username = '';
          this.email = '';
          this.password = '';
          this.role = 'ROLE_USER';
        } catch (error) {
          this.message = "Error creating user: " + error.response.data.error;
          console.error("Error creating user:", error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .user-create-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  .form-group input,
  .form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  
  .message {
    margin-top: 15px;
    font-size: 14px;
    color: green;
  }
  </style>
  