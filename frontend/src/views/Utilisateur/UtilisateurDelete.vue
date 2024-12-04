<template>
<div class="user-delete-container">
    <h2>Delete User</h2>

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
        <button @click="deleteUser(user.id)">Delete</button>
        </li>
    </ul>
    </div>
    <div v-else>
    <p>No users found.</p>
    </div>

    <div v-if="message" class="message" :class="messageClass">
    {{ message }}
    </div>
</div>
</template>

<script>
import axios from "axios";

export default {
name: "UtilisateurDelete",
data() {
    return {
    users: [],
    filteredUsers: [],
    searchQuery: "",
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
    async deleteUser(userId) {
    try {
        await axios.delete(`/api/users/${userId}`);
        this.message = "User deleted successfully!";
        this.messageClass = "success";
        this.users = this.users.filter((user) => user.id !== userId);
        this.filteredUsers = this.users;
    } catch (error) {
        this.message = "Error deleting user: " + (error.response?.data?.error || error.message);
        this.messageClass = "error";
        console.error("Error deleting user:", error);
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
.user-delete-container {
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
background-color: #dc3545;
color: white;
border: none;
border-radius: 4px;
padding: 5px 10px;
cursor: pointer;
}

button:hover {
background-color: #c82333;
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
