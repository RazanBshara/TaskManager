<template>
  <div>
    <!--begin::Signup YYYY be 2lb l div fene 23mel marg aw padd ll formYYYY-->
    <div class="login-form login-signin">
      <div class="text-center mb-5 mb-lg-3">
        <h2 class="font-size-h1 mt-14 mb-4 pt-10">Forgotten Password?</h2>
        <p class="text-muted font-weight-semi-bold font-size-h2 pt-2 mt-5 mb-2">
          Enter your Email to reset your password
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
            v-model="$v.form.email.$model"
            :state="validateState('email')"
            aria-describedby="input-2-live-feedback"
            placeholder="Email address"
          ></b-form-input>

          <b-form-invalid-feedback id="input-2-live-feedback">
            Email is required and a valid email address.
          </b-form-invalid-feedback>
        </b-form-group>

        <!--begin::Action-->
        <div class="form-group d-flex flex-wrap flex-center">
          <!--YYY--Submit button-->
          <button
            v-on:click="$router.push('')"
            type="submit"
            ref="kt_login_signup_submit"
            class="
              btn btn-primary
              font-weight-bold
              px-6
              py-2
              my-3
              font-size-5
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
              font-size-5
              mx-4
            "
          >
            Cancel
          </button>
        </div>

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
import { mapState } from "vuex";
import { LOGIN, LOGOUT } from "@/core/services/store/auth.module";

import { validationMixin } from "vuelidate";
import { email, minLength, required } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],
  name: "forgetpassword",
  data() {
    return {
      // Remove this dummy login info
      form: {
        email: "",
        password: "",
      },
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
      this.$v.form.$touch();
      if (this.$v.form.$anyError) {
        return;
      }

      const email = this.$v.form.email.$model;
      const password = this.$v.form.password.$model;

      // clear existing errors
      this.$store.dispatch(LOGOUT);

      // set spinner to submit button
      const submitButton = this.$refs["kt_login_signin_submit"];
      submitButton.classList.add("spinner", "spinner-light", "spinner-right");

      // dummy delay
      setTimeout(() => {
        // send login request
        this.$store
          .dispatch(LOGIN, { email, password })
          // go to which page after successfully login
          .then(() => this.$router.push({ name: "mytasks" }));

        submitButton.classList.remove(
          "spinner",
          "spinner-light",
          "spinner-right"
        );
      }, 2000);
    },
  },
  computed: {
    ...mapState({
      errors: (state) => state.auth.errors,
    }),
  },
};
</script>
