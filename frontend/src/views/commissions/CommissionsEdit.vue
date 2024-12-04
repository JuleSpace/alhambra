<template>
    <div class="commissions-container">
      <header class="header">
        <h1>Gérer les Commissions</h1>
      </header>
  
      <div class="content">
        <!-- Liste des commissions -->
        <div v-if="commissions.length > 0">
          <ul>
            <li v-for="commission in commissions" :key="commission.id">
              <div>
                <h3>{{ commission.name }}</h3>
                <p>{{ commission.description }}</p>
                <div class="action-buttons">
                  <router-link :to="`/commissions/edit/${commission.id}`" class="button edit">
                    Modifier
                  </router-link>
                  <button @click="deleteCommission(commission.id)" class="button delete">
                    Supprimer
                  </button>
                  <router-link :to="`/commissions/show/${commission.id}`" class="button show">
                    Voir
                  </router-link>
                </div>
              </div>
            </li>
          </ul>
        </div>
  
        <!-- Si la liste est vide -->
        <div v-else>
          <p>Aucune commission disponible.</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'EditCommissions',
    data() {
      return {
        commissions: [] // Liste des commissions
      };
    },
    methods: {
      /**
       * Récupère la liste des commissions depuis l'API Symfony.
       */
      async fetchCommissions() {
        try {
          const response = await fetch('/api/commissions');
          if (!response.ok) {
            throw new Error('Erreur lors de la récupération des commissions.');
          }
          this.commissions = await response.json(); // Met à jour la liste avec les données reçues
        } catch (error) {
          alert(error.message);
        }
      },
  
      /**
       * Supprime une commission via l'API Symfony.
       */
      async deleteCommission(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette commission ?')) {
          try {
            const response = await fetch(`/api/commissions/${id}`, {
              method: 'DELETE',
            });
  
            if (response.ok) {
              this.commissions = this.commissions.filter(commission => commission.id !== id);
              alert('Commission supprimée avec succès.');
            } else {
              const error = await response.json();
              alert("Erreur : " + error.message);
            }
          } catch (error) {
            alert("Erreur de connexion au serveur : " + error.message);
          }
        }
      }
    },
    /**
     * Charge les commissions existantes à l'initialisation du composant.
     */
    mounted() {
      this.fetchCommissions();
    }
  };
  </script>
  
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
  
  /* Style pour la liste des commissions */
  .content ul {
    list-style: none;
    padding: 0;
  }
  
  .content li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }
  
  /* Conteneur des boutons d'action */
  .action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }
  
  /* Style des boutons d'action */
  .button {
    display: inline-block;
    padding: 10px 20px;
    text-align: center;
    font-size: 1em;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
  }
  
  .edit {
    background-color: #25d366;
    color: white;
  }
  
  .edit:hover {
    background-color: #128c7e;
  }
  
  .delete {
    background-color: #ff4136;
    color: white;
  }
  
  .delete:hover {
    background-color: #e0292b;
  }
  
  .show {
    background-color: #075e54;
    color: white;
  }
  
  .show:hover {
    background-color: #128c7e;
  }
  </style>
  