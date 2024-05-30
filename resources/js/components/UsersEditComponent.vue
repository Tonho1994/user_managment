
  <template>
    <v-card
      class="mx-auto"
      prepend-icon="bi bi-person"
    >
    <template v-slot:title>
      <span class="font-weight-black">Edit User </span>{{user.name}}
    </template>

    <v-card-text class="bg-surface-light pt-4">
      <v-form class="needs-validation" @submit.prevent="submitForm($event)" novalidate>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" v-model="user.name" placeholder="Name" maxlength="20" required>
          <div class="invalid-feedback">
            Please enter a username.
          </div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" v-model="user.email" placeholder="name@example.com" required>
          <div class="invalid-feedback">
            Please provide a valid email.
          </div>
        </div>
        <div class="row g-3 align-items-center">
          <div class="col-auto">
            <label for="password" class="col-form-label">Password</label>
          </div>
          <div class="col-auto">
            <input type="password" id="password" class="form-control" aria-describedby="passwordHelpInline">
          </div>
          <div class="col-auto">
            <!-- <span id="passwordHelpInline" class="form-text">
              Must be 8-20 characters long.
            </span> -->
          </div>
          <div class="col-12">
            <v-btn  color="secondary" type="submit" rounded="lg" prepend-icon="bi bi-floppy">Update</v-btn>
          </div>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
  </template>
  <script>
    export default {
      props: {
        user: { type: Object, required: true },
        userRoute: { type: String, required: true }
      },
      data ()  {
        return {
          formData: {
          }
        }
      },
      methods: {
        submitForm(event) {
          const form = event.target
          if (!form.checkValidity()) {
            event.stopPropagation()
          }
          else{
            this.formData = new FormData(event.target);
            axios({
                method: 'post',
                url: this.userRoute,
                data: this.formData,
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(function (success) {//exito recarga todo
                Swal.fire({
                    title: '¡Éxito!',
                    text: success.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    buttonsStyling:false,
                    timer: 2000,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    }
                })
            })
            .catch(function (error) {
                if (error.response.status == 419) {//Se acabo el token de sesion
                  Swal.fire({
                      title: 'Tiempo Agotado',
                      text: '¡Recarga la página!',
                      icon: 'warning',
                      confirmButtonText: '<i class="bi bi-arrow-clockwise text-white"></i>',
                      buttonsStyling:false,
                      customClass: {
                          confirmButton: 'btn btn-primary',
                      }
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location. reload()
                    }
                  })
                }
                else if(error.response.status == 422){//hubo unerro de validacion de laravel
                  Swal.fire({
                    title: '¡Algo Falta!',
                    text: error.response.data.message,
                    icon: 'info',
                    confirmButtonText: 'Revisar',
                    buttonsStyling:false,
                    customClass: {
                      icon: '...',
                      confirmButton: 'btn btn-primary',
                    }
                  })
                }
                else {//algun otro error
                  console.log(error.response.data.message);
                  Swal.fire({
                    title: 'Upss...',
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    buttonsStyling:false,
                    customClass: {
                      confirmButton: 'btn btn-primary',
                    }
                  })
                }
            });
          }
          form.classList.add('was-validated')
        }
      },
      mounted(){

      }
    }
  </script>
