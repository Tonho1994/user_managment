
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
          <v-btn :href="userRoute+'/'+value" color="primary" size="small" icon="bi bi-pencil-square"></v-btn>
        </div>
        <div class="col-lg-6 pt-md-0 pt-1">
          <v-btn @click="deleteUser(value)" type="button" color="red" size="small" icon="bi bi-trash3"></v-btn>
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
        userRoute: { type: String, required: true },
        getUsersRoute: { type: String, required: true }
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
          axios.get(this.getUsersRoute, {
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
        deleteUser(id){
          Swal.fire({
              title: 'Are you sure?',
              text: "It can't be undone",
              icon: 'warning',
              reverseButtons :true,
              confirmButtonText: 'Delete',
              showCancelButton: true,
              cancelButtonText: 'Cancel',
              buttonsStyling:false,
              customClass: {
                  confirmButton: 'btn btn-danger text-white ms-4',
                  cancelButton: 'btn btn-secondary text-white me-4',
              }
          }).then((result) => {
            if (result.isConfirmed) {
              axios.delete(this.userRoute+'/'+id)
              .then(function (success) {//exito recarga todo
                Swal.fire({
                    title: 'Success!',
                    text: success.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling:false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        confirmButton: 'btn btn-primary text-white',
                    }
                }).then((result) => {
                  if (result.isConfirmed) {
                    location. reload()
                  }
                })
              })
              .catch(function (error) {
                  if (error.response.status == 419) {//Session token expired
                    Swal.fire({
                        title: 'Exhausted Time',
                        text: '¡Reload the page!',
                        icon: 'warning',
                        confirmButtonText: '<i class="bi bi-arrow-clockwise text-white"></i>',
                        buttonsStyling:false,
                        customClass: {
                            confirmButton: 'btn btn-primary text-white',
                        }
                    }).then((result) => {
                      if (result.isConfirmed) {
                        location. reload()
                      }
                    })
                  }
                  else {//another error
                    Swal.fire({
                      title: 'Upss...',
                      text: error,
                      icon: 'error',
                      confirmButtonText: 'Close',
                      buttonsStyling:false,
                      customClass: {
                        confirmButton: 'btn btn-danger text-white',
                      }
                    })
                  }
              });
            }
          })
        },
      },
    }
  </script>
