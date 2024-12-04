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
      newCommission: '', // Stocke le nom de la nouvelle commission
      commissions: [] // Liste des commissions existantes
    };
  },
  methods: {
    /**
     * Ajoute une nouvelle commission via l'API Symfony.
     */
    async addCommission() {
      if (this.newCommission.trim()) {
        try {
          const response = await fetch('http://localhost:8000/api/commissions', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name: this.newCommission }), // Envoi des données au backend
          });

          if (response.ok) {
            const result = await response.json(); // Parse la réponse JSON
            this.commissions.push({ id: result.id, name: this.newCommission }); // Mise à jour locale
            this.newCommission = ''; // Réinitialisation du champ
            alert(result.message); // Affiche un message de succès
          } else {
            const error = await response.json();
            alert("Erreur : " + error.message);
          }
        } catch (error) {
          alert("Erreur de connexion au serveur : " + error.message);
        }
      }
    },
    /**
     * Récupère la liste des commissions via l'API Symfony.
     */
    async fetchCommissions() {
      try {
        const response = await fetch('http://localhost:8000/api/commissions');
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
.commission-create-container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.header h1 {
  text-align: center;
  margin-bottom: 20px;
}

.form-container {
  margin-bottom: 20px;
}

.form-container form {
  display: flex;
  flex-direction: column;
}

.form-container label {
  margin-bottom: 5px;
}

.form-container input {
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.submit-button {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #0056b3;
}

.commission-list h2 {
  margin-bottom: 10px;
}

.commission-list ul {
  list-style: none;
  padding: 0;
}

.commission-list li {
  padding: 5px 0;
  border-bottom: 1px solid #ddd;
}
</style>
