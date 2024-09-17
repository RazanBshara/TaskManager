<template>
  <div>
    <div>
      <!--begin::Signin-->
      <div class="login-form login-signin mb-lg-5">
        <div class="text-center mb-5 mb-lg-3">
          <h3 class="font-size-h1 font-weight-bold">Welcome to Taskit!</h3>
          <span class="font-size-h4 text-muted">
            Don't have an account yet?
          </span>
          <router-link class="font-size-h5" :to="{ name: 'register' }">
            Sign Up!
          </router-link>
        </div>

        <!--begin::Form-->
        <b-form
          class="form"
          style="width: 100%"
          @submit.stop.prevent="onSubmit"
        >
          <!--div role="alert" class="alert alert-info">
          <div class="alert-text">
            Use account <strong>admin@demo.com</strong> and password
            <strong>demo</strong> to continue.
          </div>
        </div> -->

          <!-- <div
          role="alert"
          v-bind:class="{ show: errors.length }"
          class="alert fade alert-danger"
        >
          <div class="alert-text" v-for="(error, i) in errors" :key="i">
            {{ error }}
          </div>
        </div> -->

          <!--YYY--Login Email-->
          <b-form-group
            id="example-input-group-1"
            label="Email Address"
            label-cols-xl="12"
            style="width: 110%"
            label-for="example-input-1"
          >
            <b-form-input
              class="form-control form-control-solid h-auto py-5 px-6"
              id="example-input-1"
              name="example-input-1"
              v-model="form.email"
              :state="validateState('email')"
              aria-describedby="input-1-live-feedback"
              placeholder="Enter your email"
            ></b-form-input>

            <b-form-invalid-feedback id="input-1-live-feedback">
              Email is required and a valid email address.
            </b-form-invalid-feedback>
          </b-form-group>

          <!--YYY--Login Password-->
          <b-form-group
            id="example-input-group-2"
            label="Password"
            style="width: 110%"
            label-for="example-input-2"
          >
            <a
              href="#"
              class="text-dark-60 text-hover-primary pl-40 ml-40"
              id="kt_login_forgot"
              v-on:click="$router.push('forgetpassword')"
            >
              Forgot Password ?
            </a>

            <b-form-input
              class="form-control form-control-solid h-auto py-5 px-6"
              type="password"
              id="example-input-2"
              name="example-input-2"
              v-model="form.password"
              :state="validateState('password')"
              aria-describedby="input-2-live-feedback"
              placeholder="Enter your password"
            ></b-form-input>

            <b-form-invalid-feedback id="input-2-live-feedback">
              Password is required.
            </b-form-invalid-feedback>
          </b-form-group>

          <!--begin::Action-->
          <div class="d-flex justify-content-between pt-8">
            <div class="mr-40">
              <button
                ref="kt_login_signin_submit"
                class="btn btn-primary font-weight-bold px-6 py-2 my-3 font-size-3"
              >
                Sign In
              </button>
            </div>

            <button
              ref="kt_login_signin_submit"
              class="btn btn-danger font-weight-bold px-6 py-2 my-3 font-size-3"
            >
              <b-icon icon="google" variant="warning"></b-icon>

              Sign in with Google
            </button>
            <span>{{ e }}</span>
          </div>
          <!--end::Action-->
        </b-form>
        <!--end::Form-->
      </div>
      <!--end::Signin-->
    </div>
    <!-- <b-button @click="onSubmit" class="btn btn-primary">Submit</b-button> -->
  </div>
</template>

<style lang="scss" scoped>
.spinner.spinner-right {
  padding-right: 3.5rem !important;
}
</style>

<script>
import axios from "axios";
import { mapState } from "vuex";

//import { LOGIN, LOGOUT } from "@/core/services/store/auth.module";
import { validationMixin } from "vuelidate";
import { email, minLength, required } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],

  name: "login",
  data() {
    return {
      // Remove this dummy login info
      e: "",
      form: {
        email: "",
        password: "",
      },
      // config: {
      //   method: "post",
      //   url:
      //     "http://127.0.0.1:8000/api/login?email=${{th}}&password=123456789",
      //   data: {
      //     email: "azad12@user.com",
      //     password: "123456789"
      //   },
      //   headers: {
      //     Accept: "application/json",
      //   },
      // },
      res: null,
      status: null,
    };
  },
  validations: {
    form: {
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(3),
      },
    },
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },
    resetForm() {
      this.form = {
        email: null,
        password: null,
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },
    onSubmit() {
      axios
        .post("http://127.0.0.1:8000/api/login", {
          email: this.form.email,
          password: this.form.password,
        })
        .then((response) => {
          this.e = response;
          console.log(response);
          localStorage.setItem("Token", response.data.token);
          //this.status = isNaN(response.data);
          // if (!this.status) {
          this.$router.push({ name: "workspace" });
          // }
        });
      // const headers = {
      //   Accept: "Application / json",
      // };
      // axios(this.config)
      //   .then(function(response) {
      //     console.log(JSON.stringify(response.data));
      //   })
      //   .catch(function(error) {
      //     console.log(error);
      //   });
      // .post("http://127.0.0.1:8000/api/login", {
      //   params: {
      //     email: this.form.email,
      //     password: this.form.password,
      //   },
      //headers: { Accept: "Application/json" },
      // })
      // .then((response) => (this.res = response.data));
      // this.$v.form.$touch();
      // if (this.$v.form.$anyError) {
      //   return;
      // }

      // const email = this.$v.form.email.$model;
      // const password = this.$v.form.password.$model;

      // clear existing errors
      // this.$store.dispatch(LOGOUT);

      // // set spinner to submit button
      // const submitButton = this.$refs["kt_login_signin_submit"];
      // submitButton.classList.add("spinner", "spinner-light", "spinner-right");

      // dummy delay
      //  setTimeout(() => {
      //     // send login request
      //     this.$store
      //       .dispatch(LOGIN, { email, password })
      //       // go to which page after successfully login
      //       .then(() => this.$router.push({ name: "dashboard" }));

      //     submitButton.classList.remove(
      //       "spinner",
      //       "spinner-light",
      //       "spinner-right"
      //     );
      //   }, 2000);
    },
  },
  computed: {
    ...mapState({
      errors: (state) => state.auth.errors,
    }),
  },
};
</script>
