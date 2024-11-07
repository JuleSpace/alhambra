<template>
<div class="user-edit-container">
    <h2>Edit User</h2>

    <div class="search-bar">
    <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by username or email"
        @input="filterUsers"
    />
    </div>

    <div v-if="users.length">
    <ul class="user-list">
        <li v-for="user in filteredUsers" :key="user.id" class="user-item">
        <span>{{ user.username }} ({{ user.email }})</span>
        <button @click="selectUser(user)">Edit</button>
        </li>
    </ul>
    </div>
    <div v-else>
    <p>No users found.</p>
    </div>

    <div v-if="selectedUser" class="edit-form">
    <h3>Edit {{ selectedUser.username }}</h3>
    <form @submit.prevent="updateUser">
        <label for="username">Username:</label>
        <input
        type="text"
        id="username"
        v-model="selectedUser.username"
        required
        />

        <label for="email">Email:</label>
        <input
        type="email"
        id="email"
        v-model="selectedUser.email"
        required
        />

        <button type="submit">Save</button>
    </form>
    </div>

    <div v-if="message" class="message" :class="messageClass">
    {{ message }}
    </div>
</div>
</template>

<script>
import axios from "axios";

export default {
name: "UtilisateurEdit",
data() {
    return {
    users: [],
    filteredUsers: [],
    searchQuery: "",
    selectedUser: null,
    message: "",
    messageClass: "",
    };
},
mounted() {
    this.fetchUsers();
},
methods: {
    async fetchUsers() {
    try {
        const response = await axios.get("/api/users");
        this.users = response.data;
        this.filteredUsers = this.users;
    } catch (error) {
        console.error("Error fetching users:", error);
        this.message = "Error fetching users.";
        this.messageClass = "error";
    }
    },
    selectUser(user) {
    this.selectedUser = { ...user };
    },
    async updateUser() {
    try {
        await axios.put(`/api/users/${this.selectedUser.id}`, this.selectedUser);
        this.message = "User updated successfully!";
        this.messageClass = "success";
        this.fetchUsers(); // Refresh the user list
        this.selectedUser = null;
    } catch (error) {
        this.message = "Error updating user: " + (error.response?.data?.error || error.message);
        this.messageClass = "error";
        console.error("Error updating user:", error);
    }
    },
    filterUsers() {
    if (this.searchQuery) {
        this.filteredUsers = this.users.filter(
        (user) =>
            user.username.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            user.email.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
    } else {
        this.filteredUsers = this.users;
    }
    },
},
};
</script>

<style scoped>
.user-edit-container {
max-width: 600px;
margin: auto;
padding: 20px;
border: 1px solid #ddd;
border-radius: 8px;
}

.search-bar {
margin-bottom: 20px;
}

.search-bar input {
width: 100%;
padding: 8px;
border: 1px solid #ddd;
border-radius: 4px;
}

.user-list {
list-style-type: none;
padding: 0;
}

.user-item {
display: flex;
justify-content: space-between;
margin-bottom: 10px;
padding: 10px;
background-color: #f9f9f9;
border: 1px solid #ddd;
border-radius: 4px;
}

button {
background-color: #007bff;
color: white;
border: none;
border-radius: 4px;
padding: 5px 10px;
cursor: pointer;
}

button:hover {
background-color: #0056b3;
}

.edit-form {
margin-top: 20px;
}

.edit-form label {
display: block;
margin-top: 10px;
}

.edit-form input {
width: 100%;
padding: 8px;
border: 1px solid #ddd;
border-radius: 4px;
}

.edit-form button {
background-color: #28a745;
color: white;
border: none;
border-radius: 4px;
padding: 10px 15px;
cursor: pointer;
margin-top: 10px;
}

.edit-form button:hover {
background-color: #218838;
}

.message {
margin-top: 15px;
font-size: 14px;
padding: 10px;
border-radius: 4px;
}

.message.success {
color: green;
background-color: #d4edda;
border: 1px solid #c3e6cb;
}

.message.error {
color: red;
background-color: #f8d7da;
border: 1px solid #f5c6cb;
}
</style>
