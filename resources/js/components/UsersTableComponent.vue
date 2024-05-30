
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
      item-value="name"
      @update:options="loadItems"
    >
    <template v-slot:item.acciones="{ value }">
      <div class="row">
        <div class="col-lg-6">
          <v-btn :href="userRoute+'/'+value" color="darkblueshade" size="small" icon="bi bi-pencil-square"></v-btn>
        </div>
        <div class="col-lg-6 pt-md-0 pt-1">
          <v-btn :href="value" color="red" size="small" icon="bi bi-trash3"></v-btn>
        </div>
      </div>
    </template>
    </v-data-table-server>
    </v-card-text>
  </v-card>
  </template>
  <script>
    export default {
      props: {
        userRoute: { type: String, required: true }
      },
      data: () => ({
        headers: [
          { title: 'Id', key: 'id'},
          { title: 'Nombre', key: 'name'},
          { title: 'Email', key: 'email'},
          { title: 'Actions', key: 'acciones', align: 'center', sortable: false, value: serverItems => `${serverItems.id}` },
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
        itemsPerPage: 10,
      }),
      methods: {
        loadItems ({ page, itemsPerPage, sortBy }) {
          this.loading = true
          axios.get('/api/users/all', {
              params: {
                page: page,
                itemsPerPage: itemsPerPage,
                sort: sortBy,
              }
            }).then(({ data }) => {

            this.itemsPerPage = data.itemsPerPage
            this.serverItems = data.data
            this.totalItems = data.total
            this.loading = false
          });
        },
      },
    }
  </script>
