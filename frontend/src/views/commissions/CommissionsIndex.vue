<template>
    <div class="commissions-container">
      <header class="header">
        <h1>Liste des Commissions</h1>
      </header>
  
      <div class="content">
        <UtilisateurListe />
        <router-link to="/create" class="create-button">Créer une Nouvelle Commission</router-link>
      </div>
    </div>
  </template>
  <!--
  <script>
  // Si vous utilisez UtilisateurListe dans votre composant, assurez-vous de l'importer
  import UtilisateurListe from '@/components/UtilisateurListe.vue';
  
  export default {
    name: 'CommissionsList',
    components: {
      UtilisateurListe
    }
  };
  </script>
  -->
  <style scoped>
  /* Style général du conteneur */
  .commissions-container {
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
  }
  
  /* Style pour le bouton de création */
  .create-button {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #075e54; /* Couleur verte de WhatsApp */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
  }
  
  .create-button:hover {
    background-color: #dcf8c6; /* Couleur verte claire */
  }
  </style>
  