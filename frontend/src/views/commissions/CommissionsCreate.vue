<template>
  <div class="commissions-create-container">
    <header class="header">
      <h1>Créer une Nouvelle Commission</h1>
    </header>

    <div class="content">
      <form @submit.prevent="addCommission">
        <!-- Champ pour le nom de la commission -->
        <div class="form-group">
          <label for="name">Nom de la Commission</label>
          <input
            type="text"
            id="name"
            v-model="newCommission.name"
            placeholder="Entrez le nom de la commission"
            required
          />
        </div>

        <!-- Champ pour la description de la commission -->
        <div class="form-group">
          <label for="description">Description</label>
          <textarea
            id="description"
            v-model="newCommission.description"
            placeholder="Entrez une description"
            required
          ></textarea>
        </div>

        <!-- Bouton pour soumettre le formulaire -->
        <div class="form-actions">
          <button type="submit" class="button create">Créer la Commission</button>
          <router-link to="/commissions" class="button cancel">Annuler</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CommissionsCreate',
  data() {
    return {
      newCommission: {
        name: '', // Nom de la commission
        description: '' // Description de la commission
      }
    };
  },
  methods: {
    /**
     * Ajoute une nouvelle commission via l'API Symfony.
     */
     async addCommission() {
  if (this.newCommission.name.trim() && this.newCommission.description.trim()) {
    try {
      const response = await fetch('http://localhost:81/api/commissions', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          name: this.newCommission.name,
          description: this.newCommission.description
        }),
      });

      if (response.ok) {
        const result = await response.json();
        console.log(result); // Vous pouvez l'afficher dans la console ou l'utiliser autrement

        this.$router.push({ name: 'commissions' }); // Rediriger vers la page des commissions
        alert("Commission créée avec succès !");
      } else {
        const error = await response.json();
        alert("Erreur lors de la création de la commission : " + error.message);
      }
    } catch (error) {
      alert("Erreur de connexion au serveur : " + error.message);
    }
  } else {
    alert("Veuillez remplir tous les champs.");
  }
}

  }
};
</script>

<style scoped>
/* Style général du conteneur */
.commissions-create-container {
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

/* Style pour le contenu du formulaire */
.content {
  width: 100%;
  max-width: 600px;
  margin-top: 20px;
}

/* Style des groupes de champs */
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.form-group textarea {
  resize: vertical;
  min-height: 100px;
}

/* Conteneur des boutons */
.form-actions {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin-top: 20px;
}

/* Style pour les boutons */
.button {
  display: inline-block;
  padding: 12px 20px;
  text-align: center;
  font-size: 1em;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

/* Bouton de création */
.create {
  background-color: #075e54; /* Vert foncé */
  color: white;
}

.create:hover {
  background-color: #dcf8c6; /* Vert clair */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

/* Bouton d'annulation */
.cancel {
  background-color: #f44336; /* Rouge */
  color: white;
}

.cancel:hover {
  background-color: #dc3545; /* Rouge plus foncé */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}
</style>
