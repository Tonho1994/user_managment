
  <template>
    <v-card
      class="mx-auto"
      prepend-icon="bi bi-people"
    >
    <template v-slot:title>
      <span class="font-weight-black">Users</span>
    </template>

    <v-card-text class="bg-surface-light pt-4">
      <v-data-table-server
      v-model:items-per-page="itemsPerPage"
      :headers="headers"
      :items="serverItems"
      :items-length="totalItems"
      :loading="loading"
      :search="search"
      item-key="name"
      @update:options="loadItems"
    ></v-data-table-server>
    </v-card-text>
  </v-card>
  </template>
  <script>
    export default {
      data: () => ({
        itemsPerPage: 5,
        headers: [

          { title: 'Id', key: 'id', align: 'end' },
          { title: 'Nombre', key: 'name', align: 'center' },
          { title: 'Email', key: 'email', align: 'center' },
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
      }),
      methods: {
        loadItems ({ page, itemsPerPage, sortBy }) {
          this.loading = true
          axios.get('/api/users/all').then(({ data }) => {

            this.itemsPerPage = itemsPerPage
            this.serverItems = data.data
            this.totalItems = data.total
            this.loading = false
          });
        },
      },
    }
  </script>
