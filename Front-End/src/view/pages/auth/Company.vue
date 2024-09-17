<template>
  <div class="login-form login-signin mt-5">
    <div class="text-center mb-10 mb-lg-14 mt-14">
      <h3 class="font-size-h1">Create Your Company!</h3>
    </div>

    <!--YYY--Company Name-->
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group
        id="input-group-1"
        label="Company Name*"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.name"
          placeholder="Enter name"
          required
        ></b-form-input>
      </b-form-group>

      <!--YYY--Company members-->
      <label for="demo-sb">Memebers</label>
      <b-form-spinbutton
        id="demo-sb"
        v-model="value"
        min="1"
        max="1000"
      ></b-form-spinbutton>
      <br />

      <!--YYY--Company Types-->
      <b-form-group id="input-group-3" label="Type" label-for="input-3">
        <b-form-select id="input-3"  v-model="selected">
          <b-form-select-option
           
            v-for="op in options"
            :key="op.id"
            :value="op.id"
            @click="chooseType(op.type)"
          >
            {{ op.type }}
          </b-form-select-option>
        </b-form-select>
      </b-form-group>

      <!--YYY--Company Descriptions-->
      <!--b-form-group
        id="input-group-1"
        label="Company Description"
        label-for="input-1"
      >
        <b-form-textarea id="textarea-rows" placeholder="Enter text" rows="6">
        </b-form-textarea>
      </b-form-group-->

      <br />
      <!--begin::Action-->
      <div class="form-group d-flex flex-wrap flex-center mb-6 mx-10 px-9">
        <b-button
          type="submit"
          @click="onSubmit"
          variant="primary"
          class="px-7 py-2 my-1 font-size-3 mx-4 mb-7"
          >Get Started</b-button
        >

        <b-button
          type="reset"
          v-on:click="$router.push('joincompany')"
          variant="info"
          class=" btn btn-light-info
              font-weight-bold
              px-7
              py-2
              my-1
              font-size-5
              mx-4
              mb-7
            "
          >Cancel</b-button
        >
      </div>
    </b-form>
    <!-- <span>{{ selected }}</span> -->
  </div>
</template>

<script>
import axios from "axios";
import router from "@/router.js";
export default {
  data() {
    return {
      form: {
        name: "",

        options: "",
      },
      value: 0,
      selected: null,
      options: null,
      show: true,
    };
  },
  methods: {
    chooseCompany(companyType) {
      this.selected = companyType;
    },
    onSubmit() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/company",
        data: {
          name: this.form.name,
          typeid: this.selected,
          members: this.value,
           
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        if (response.status == 200) {
          console.log(JSON.stringify(response.data)),
            router.replace("/workspace");
        }
      });
    },
    // onSubmit(event) {
    //   event.preventDefault();
    //   alert(JSON.stringify(this.form));
    // },
    onReset(event) {
      event.preventDefault();
      // Reset our form values
      this.form.name = "";
      this.form.options = null;

      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    },
  },
  created: function() {
    axios({
      method: "get",
      url: "http://127.0.0.1:8000/api/getcompanytype",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.options = response.data;
    });
  },
};
</script>
