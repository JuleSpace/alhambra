<template>
    <div class="commission-create-container">
      <header class="header">
        <h1>Créer une Nouvelle Commission</h1>
      </header>
  
      <div class="form-container">
        <form @submit.prevent="addCommission">
          <label for="commission-name">Nom de la Commission :</label>
          <input
            type="text"
            id="commission-name"
            v-model="newCommission"
            placeholder="Entrez le nom de la commission"
            required
          />
  
          <button type="submit" class="submit-button">Ajouter Commission</button>
        </form>
      </div>
  
      <div class="commission-list">
        <h2>Commissions Existantes</h2>
        <ul>
          <li v-for="commission in commissions" :key="commission.id">
            {{ commission.name }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CommissionsCreate',
    data() {
      return {
        newCommission: '',
        commissions: []
      };
    },
    methods: {
      async addCommission() {
        if (this.newCommission.trim()) {
          try {
            const response = await fetch('http://localhost/backend/src/controller/add_commission.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({ name: this.newCommission })
            });
  
            const result = await response.json();
  
            if (response.ok) {
              // Ajouter la nouvelle commission localement et réinitialiser le champ de saisie
              this.commissions.push({ id: Date.now(), name: this.newCommission });
              this.newCommission = '';
              alert(result.message);
              this.fetchCommissions(); // Appel pour mettre à jour la liste après ajout
            } else {
              alert("Erreur : " + result.message);
            }
          } catch (error) {
            alert("Erreur de connexion au serveur.");
          }
        }
      },
      async fetchCommissions() {
        try {
          const response = await fetch('http://localhost/backend/src/controller/get_commissions.php');
          if (!response.ok) {
            throw new Error('Erreur lors de la récupération des commissions');
          }
          this.commissions = await response.json();
        } catch (error) {
          alert(error.message);
        }
      }
    },
    mounted() {
      this.fetchCommissions(); // Charger les commissions existantes lors du montage du composant
    }
  };
  </script>
  
  <style scoped>
  /* Ajoutez vos styles ici */
  </style>
  