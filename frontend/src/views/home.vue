<template>
    <div>
      <h1>Bienvenue sur l'application de gestion de l'association Alhambra</h1>
  
      <ul>
        <li><router-link :to="{ name: 'utilisateur-index' }">Gestion des Utilisateurs</li>
        <li><router-link :to="{ name: 'commission-index' }">Gestion des Commissions</li>
        <li><router-link :to="{ name: 'post-index' }">Gestion des Posts</li>
        <li><router-link :to="{ name: 'privilege-index' }">Gestion des Privilèges</li>
        <li><router-link :to="{ name: 'chat-index' }">Accès au chat</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Home',
    metaInfo: {
      title: 'Accueil'
    }
  }
  </script>
  
  <style scoped>
  /* Ajoutez vos styles ici */
  </style>
  