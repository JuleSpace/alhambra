<template>
  <div class="commissions-container">
    <header class="header">
      <h1>Liste des Commissions</h1>
    </header>

    <div class="content">
      <!-- Liste des commissions -->
      <div v-if="commissions.length > 0">
        <ul>
          <li v-for="commission in commissions" :key="commission.id">
            {{ commission.name }} - {{ commission.description }}
          </li>
        </ul>
      </div>

      <!-- Si la liste est vide -->
      <div v-else>
        <p>Aucune commission disponible.</p>
      </div>

      <!-- Boutons pour accéder à la page de gestion et de création -->
      <div v-if="$route.path === '/commissions'" class="button-container">
        <!-- Bouton pour créer une nouvelle commission -->
        <router-link to="/commissions/create" class="button create">
          Créer une nouvelle Commission
        </router-link>
        
        <!-- Bouton pour gérer les commissions (modifier, supprimer, voir) -->
        <router-link to="/commissions/edit" class="button manage">
          Gérer les Commissions
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CommissionsList',
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

/* Conteneur des boutons */
.button-container {
  display: flex;
  flex-direction: column;
  gap: 15px; /* Espacement entre les boutons */
  margin-top: 20px;
  width: 100%;
  max-width: 400px;
  align-items: center;
}

/* Style pour les boutons */
.button {
  display: inline-block;
  width: 100%;
  padding: 12px;
  text-align: center;
  font-size: 1em;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

/* Styles spécifiques pour chaque bouton */
.create {
  background-color: #075e54; /* Vert foncé */
  color: white;
}

.create:hover {
  background-color: #dcf8c6; /* Vert clair */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.manage {
  background-color: #25d366; /* Vert clair */
  color: white;
}

.manage:hover {
  background-color: #128c7e; /* Vert plus foncé */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}
</style>
