<template>
    <div class="chat-container">
      <h2>Chat Room</h2>
      <div class="messages">
        <div v-for="message in messages" :key="message.id" class="message">
          <strong>{{ message.sender }}:</strong> {{ message.content }}
        </div>
      </div>
      <div class="message-input">
        <input
          v-model="newMessage"
          @keyup.enter="sendMessage"
          placeholder="Type a message"
        />
        <button @click="sendMessage">Send</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "ChatIndex",
    data() {
      return {
        messages: [],
        newMessage: "",
      };
    },
    methods: {
      // Fetch messages from backend
      async fetchMessages() {
        try {
          const response = await axios.get("/api/chat/messages");
          this.messages = response.data;
        } catch (error) {
          console.error("Error fetching messages:", error);
        }
      },
      // Send new message to backend
      async sendMessage() {
        if (this.newMessage.trim() === "") return;
  
        try {
          await axios.post("/api/chat/messages", {
            content: this.newMessage,
            sender: "currentUser", // Replace with actual user data
          });
          this.newMessage = "";
          this.fetchMessages(); // Refresh messages
        } catch (error) {
          console.error("Error sending message:", error);
        }
      },
    },
    mounted() {
      this.fetchMessages();
      // Optionally set up a polling or WebSocket to fetch new messages in real-time
      setInterval(this.fetchMessages, 5000); // Fetch messages every 5 seconds
    },
  };
  </script>
  
  <style scoped>
  .chat-container {
    width: 100%;
    max-width: 600px;
    margin: auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
  }
  
  .messages {
    height: 300px;
    overflow-y: auto;
    margin-bottom: 10px;
  }
  
  .message {
    padding: 5px 0;
  }
  
  .message-input {
    display: flex;
  }
  
  .message-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .message-input button {
    margin-left: 5px;
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  </style>
  