
  <template>
    <v-card
      class="mx-auto"
    >
      <template v-slot:title>
        <div class="row">
          <div class="col-8">
            <i class="bi bi-people pr-2"></i>
            <span class="font-weight-black">Users</span>
          </div>
          <div class="col-4 d-flex justify-content-end">
            <v-btn type="button" data-bs-toggle="modal" data-bs-target="#createModal" color="secondary" rounded="lg" prepend-icon="bi bi-plus-circle">User</v-btn>
          </div>
        </div>
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
    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <v-card
            class="mx-auto"
            prepend-icon="bi bi-person"
          >
            <template v-slot:title>
              <div class="row">
                <div class="col-10">
                  <span class="font-weight-black">Create User </span>
                </div>
                <div class="col-2 d-flex justify-content-end">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              </div>
            </template>
            <v-card-text class="bg-surface-light pt-4">
              <v-form class="needs-validation" id="createForm" @submit.prevent="createUser($event)" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" class="form-control"  id="name" v-model="createFormData.name" placeholder="Name" maxlength="40" required>
                    <div class="invalid-feedback">
                      Please enter a username.
                    </div>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email address*</label>
                  <input type="email" class="form-control" id="email" v-model="createFormData.email" maxlength="150" placeholder="name@example.com" required>
                  <div class="invalid-feedback">
                    Please provide a valid email.
                  </div>
                </div>
                <div class="row g-3 align-items-center mb-5">
                  <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control"  id="phone" v-model="createFormData.phone" placeholder="Phone" maxlength="40">
                    <div class="invalid-feedback">
                      Please enter a valid Phone Number.
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="role" class="form-label">Role*</label>
                    <select v-model="createFormData.role" class="form-select" id="role" aria-label="roles selection" required>
                      <option value="">Select...</option>
                      <option v-for="role in roles" v-bind:value="role">
                        {{ role }}
                      </option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a Role
                    </div>
                  </div>
                </div>
                <div class="row g-3 align-items-center">
                  <div class="col-md-2">
                    <label for="password" class="col-form-label">Password*</label>
                  </div>
                  <div class="col-md-4">
                    <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" id="password" v-model="createFormData.password" class="form-control" aria-describedby="passwordHelpInline" required>
                    <div class="invalid-feedback">
                      Please enter a valid Password.
                    </div>
                  </div>
                  <div class="col-md-6">
                    <span id="passwordHelpInline" class="form-text">
                      Password must contain at least 8 characters, one lowercase letter, one uppercase letter, one number and can contain special characters.
                    </span>
                  </div>
                  <div class="col-6 d-flex">
                    <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal">Close</button>
                  </div>
                  <div class="col-6 d-flex justify-content-end">
                    <v-btn  color="secondary" type="submit" rounded="lg" prepend-icon="bi bi-floppy">Create</v-btn>
                  </div>
                </div>
              </v-form>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </div>

  </template>
  <script>
    export default {
      props: {
        userRoute: { type: String, required: true },
        getUsersRoute: { type: String, required: true },
        roles: { type: Object, required: true },
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
        createFormData: {
            name: '',
            email: '',
            phone: '',
            role: '',
            password: ''
          }
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
                  cancelButton: 'btn btn-dark text-white me-4',
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
                      text: 'Save this code! '+error.response.data.message,
                      icon: 'error',
                      confirmButtonText: 'Close',
                      buttonsStyling:false,
                      customClass: {
                        confirmButton: 'btn btn-dark text-white',
                      }
                    })
                  }
              });
            }
          })
        },
        createUser(event){
          const form = event.target
          const createModal = document.getElementById('createModal')

          if (!form.checkValidity()) {
            event.stopPropagation()
          }
          else{
            axios.post(this.userRoute+'/create',this.createFormData,{
              headers:{
                'Content-Type': 'multipart/form-data'
              }
            })
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
                    //close modal and reseet form
                  }
                });
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
                else if(error.response.status == 422){//laravel validation error
                  Swal.fire({
                    title: "Something's missing!",
                    text: error.response.data.message,
                    icon: 'info',
                    confirmButtonText: 'check',
                    buttonsStyling:false,
                    customClass: {
                      icon: '...',
                      confirmButton: 'btn btn-secondary text-white',
                    }
                  })
                }
                else {//another error
                  Swal.fire({
                    title: 'Upss...',
                    text: 'Save this code! '+error.response.data.message,
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
          form.classList.add('was-validated')
        },
      },
    }
  </script>
