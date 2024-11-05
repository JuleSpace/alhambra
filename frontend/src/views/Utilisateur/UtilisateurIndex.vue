<template>
    <div class="user-list-container">
      <!-- Header pour le titre de la liste des utilisateurs -->
      <div class="header">
        <h1>Liste des Utilisateurs</h1>
      </div>
      
      <!-- Contenu de la liste des utilisateurs -->
      <div class="content">
        <UtilisateurListe />
      </div>
  
      <!-- Le bouton s'affiche uniquement si la route est exactement "/utilisateur" -->
      <router-link 
        v-if="$route.path === '/utilisateur'" 
        to="/utilisateur/create"
        class="create-link">
        Créer un nouvel utilisateur
      </router-link>
      
      <router-view />
    </div>
  </template>
  
  <script>
  /*import UtilisateurListe from '@/components/UtilisateurListe.vue';
  
  export default {
    components: {
      UtilisateurListe,
    },
  };*/
  </script>
  
  <style scoped>
  /* Style général du conteneur */
  .user-list-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: #eae6df; /* couleur inspirée de WhatsApp */
    height: 100vh;
    font-family: Arial, sans-serif;
    color: #333;
  }
  
  /* Style pour le header */
  .header {
    background-color: #075e54; /* couleur verte de WhatsApp */
    width: 100%;
    padding: 20px;
    text-align: center;
    color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
  }
  
  .header h1 {
    font-size: 1.5em;
    margin: 0;
  }
  
  /* Style pour le contenu */
  .content {
    width: 100%;
    max-width: 600px;
    margin-bottom: 20px;
  }
  
  /* Style pour le lien de création d'un nouvel utilisateur */
  .create-link {
    display: inline-block;
    text-decoration: none;
    color: #333;
    background-color: #ffffff;
    padding: 15px;
    text-align: center;
    border-radius: 8px;
    font-size: 1.1em;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, color 0.3s;
  }
  
  .create-link:hover {
    background-color: #dcf8c6; /* couleur verte claire inspirée de WhatsApp */
    color: #075e54;
  }
  </style>
  