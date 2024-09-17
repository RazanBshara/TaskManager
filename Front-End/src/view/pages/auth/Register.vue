<template>
  <div>
    <!--begin::Signup YYYY be 2lb l div fene 23mel marg aw padd ll formYYYY-->
    <div class="login-form login-signin">
      <div class="text-center mb-5 mb-lg-3">
        <h2 class="font-size-h1 mt-14 mb-4 pt-2">Sign Up</h2>
        <p class="text-muted font-weight-semi-bold font-size-h2 pt-2 mt-5 mb-2">
          Enter your details to create your account
        </p>
      </div>

      <!--begin::Form-->
      <b-form class="form pt-1 py-2" @submit.stop.prevent="onSubmit">
        <!-- <div
          role="alert"
          v-bind:class="{ show: errors.length }"
          class="alert fade alert-danger"
        >
          <div class="alert-text" v-for="(error, i) in errors" :key="i">
            {{ error }}
          </div>
        </div> -->

        <!--YYY--Sing Up FirstName-->
        <b-form-group
          id="example-input-group-0"
          label=""
          label-for="example-input-0"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            id="example-input-0"
            name="example-input-0"
            v-model="form.firstname"
            :state="validateState('firstname')"
            aria-describedby="input-0-live-feedback"
            placeholder="First Name"
          ></b-form-input>

          <b-form-invalid-feedback id="input-0-live-feedback">
            First name is required.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--YYY--Sing Up LastName-->
        <b-form-group
          id="example-input-group-1"
          label=""
          label-for="example-input-1"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            id="example-input-1"
            name="example-input-1"
            v-model="form.lastname"
            :state="validateState('lastname')"
            aria-describedby="input-1-live-feedback"
            placeholder="Last Name"
          ></b-form-input>

          <b-form-invalid-feedback id="input-1-live-feedback">
            Last name is required.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--YYY--Sing Up Email-->
        <b-form-group
          id="example-input-group-2"
          label=""
          label-for="example-input-2"
          description="We'll never share your email with anyone else."
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            id="example-input-2"
            name="example-input-2"
            v-model="form.email"
            :state="validateState('email')"
            aria-describedby="input-2-live-feedback"
            placeholder="Email address"
          ></b-form-input>

          <b-form-invalid-feedback id="input-2-live-feedback">
            Email is required and a valid email address.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--YYY--Sing Up Password-->
        <b-form-group
          id="example-input-group-3"
          label=""
          label-for="example-input-3"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            type="password"
            id="example-input-3"
            name="example-input-3"
            v-model="form.password"
            :state="validateState('password')"
            aria-describedby="input-3-live-feedback"
            placeholder="Password"
          ></b-form-input>

          <b-form-invalid-feedback id="input-3-live-feedback">
            Password is required.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--YYY--Confirm Password-->
        <b-form-group
          id="example-input-group-3"
          label=""
          label-for="example-input-3"
        >
          <b-form-input
            class="form-control form-control-solid h-auto py-5 px-6"
            type="password"
            id="example-input-3"
            name="example-input-3"
            v-model="form.password_confirmation"
            :state="validateState('password_confirmation')"
            aria-describedby="input-3-live-feedback"
            placeholder="Confirm Password"
          ></b-form-input>

          <b-form-invalid-feedback id="input-3-live-feedback">
            Confirm Your Password is required.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--YYY--Sing Up terms and conditions-->
        <div>
          <b-form-checkbox
            id="checkbox-1"
            name="checkbox-1"
            value="accepted"
            unchecked-value="not_accepted"
            v-model="form.terms"
            :state="validateState('terms')"
            aria-describedby="checkbox-1-live-feedback"
          >
            I Accept the<strong> terms</strong> and <strong>conditions</strong>
            <b-form-invalid-feedback id="checkbox-1-live-feedback">
              You should agree terms and conditions!
            </b-form-invalid-feedback>
          </b-form-checkbox>
        </div>
        <br /><br />

        <!--begin::Action-->
        <div class="form-group d-flex flex-wrap flex-center">
          <!--YYY--Submit button-->
          <button
            @click="onSubmit"
            type="submit"
            ref="kt_login_signup_submit"
            class="
              btn btn-primary
              font-weight-bold
              px-6
              py-2
              my-3
              font-size-3
              mx-4
            "
          >
            Submit
          </button>

          <!--YYY--Cancel button-->
          <button
            v-on:click="$router.push('login')"
            class="
              btn btn-light-info
              font-weight-bold
              px-6
              py-2
              my-3
              font-size-3
              mx-4
            "
          >
            Cancel
          </button>
        </div>

        <!--YYY--Google-icon-button-->
        <!--b-button
          pill
          type="submit"
          variant="outline-primary"
          class="px-3 py-4 my-3 mx-2"
        >
          <span class="btn-inner--icon"
            ><i class="fab fa-google-plus-g"></i
          ></span>
        </b-button-->

        <!--end::Action-->
      </b-form>
      <!--end::Form-->
    </div>
    <!--end::Signup-->
  </div>
</template>

<style lang="scss" scoped>
.spinner.spinner-right {
  padding-right: 3.5rem !important;
}
</style>

<script>
import axios from "axios";
import router from "@/router.js";

import { mapState } from "vuex";
//import { REGISTER } from "@/core/services/store/auth.module";
//import { LOGOUT } from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import { email, required, minLength } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],
  name: "register",
  data() {
    return {
      // Remove this dummy login info
      form: {
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        terms: "",
        password_confirmation: "",
        //status:"not_accepted"
      },
    };
  },
  validations: {
    form: {
      firstname: {
        required,
        minLength: minLength(4),
      },
      lastname: {
        required,
        minLength: minLength(4),
      },
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(3),
      },
      password_confirmation: {
        required,
        minLength: minLength(3),
      },
      terms: {
        required,
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
        firstname: null,
        lastname: null,
        email: null,
        password: null,
        terms: null,
        password_confirmation: null,
      };

      this.$nextTick(() => {
        this.$v.$reset();
      });
    },

    onSubmit() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/register",
        data: {
          firstname: this.form.firstname,
          lastname: this.form.lastname,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
        },
        headers: {
          Accept: "application/json",
        },
      }).then(function(response) {
        localStorage.setItem("Token", response.data.token);
        console.log(JSON.stringify(response.data)),
          router.replace("/joincompany");
      });
    },
    // onSubmit() {
    //   this.$v.form.$touch();
    //   if (this.$v.form.$anyError) {
    //     return;
    //   }

    //   const firstname = this.$v.form.firstname.$model;
    //   const lastname = this.$v.form.lastname.$model;
    //   const email = this.$v.form.email.$model;
    //   const password = this.$v.form.password.$model;
    //   const terms = this.$v.form.terms.$model;

    //   // clear existing errors
    //   this.$store.dispatch(LOGOUT);

    //   // set spinner to submit button
    //   const submitButton = this.$refs["kt_login_signup_submit"];
    //   submitButton.classList.add("spinner", "spinner-light", "spinner-right");

    //   // dummy delay
    //   setTimeout(() => {
    //     // send register request
    //     this.$store
    //       .dispatch(REGISTER, { firstname, lastname, email, password, terms })
    //       .then.submitButton(() => this.$router.push({ name: "company" }));

    //     submitButton.classList.remove(
    //       "spinner",
    //       "spinner-light",
    //       "spinner-right"
    //     );
    //   }, 2000);
    // },
  },
  computed: {
    ...mapState({
      errors: (state) => state.auth.errors,
    }),
  },
};
</script>
