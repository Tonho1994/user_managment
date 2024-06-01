
  <template>
    <v-card
      class="mx-auto"
      prepend-icon="bi bi-person"
    >
      <template v-slot:title>
        <span class="font-weight-black">Edit User </span>| {{user.name}}
      </template>
      <v-card-text class="bg-surface-light pt-4">
        <v-form class="needs-validation" @submit.prevent="submitForm($event)" novalidate>
          <div class="mb-3">
              <label for="name" class="form-label">Name*</label>
              <input type="text" class="form-control"  id="name" v-model="formData.name" placeholder="Name" maxlength="40" required>
              <div class="invalid-feedback">
                Please enter a username.
              </div>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address*</label>
            <input type="email" class="form-control" id="email" v-model="formData.email" maxlength="150" placeholder="name@example.com" required>
            <div class="invalid-feedback">
              Please provide a valid email.
            </div>
          </div>
          <div class="row g-3 align-items-center mb-5">
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" class="form-control"  id="phone" v-model="formData.phone" placeholder="Phone" maxlength="40">
              <div class="invalid-feedback">
                Please enter a valid Phone Number.
              </div>
            </div>
            <div class="col-md-6">
              <label for="role" class="form-label">Role*</label>
              <select v-model="formData.role" class="form-select" id="role" aria-label="roles selection" required>
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
              <label for="password" class="col-form-label">Password</label>
            </div>
            <div class="col-md-4">
              <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" id="password" v-model="formData.password" class="form-control" aria-describedby="passwordHelpInline">
              <div class="invalid-feedback">
                Please enter a valid Password.
              </div>
            </div>
            <div class="col-md-6">
              <span id="passwordHelpInline" class="form-text">
                Password must contain at least 8 characters, one lowercase letter, one uppercase letter, one number and can contain special characters.
              </span>
            </div>
            <div class="col-12 d-flex justify-content-end">
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
        roles: { type: Object, required: true },
        userEditRoute: { type: String, required: true }
      },
      data ()  {
        return {
          formData: {
            name: this.user.name,
            email: this.user.email,
            phone: this.user.phone,
            role: this.user.role,
            password: ''
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
            axios.post(this.userEditRoute,this.formData,{
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
        }
      },
      mounted(){

      }
    }
  </script>
