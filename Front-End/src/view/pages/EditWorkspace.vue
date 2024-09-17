<template>
  <div>
    <b-nav class="mx-1">
      <b-nav-item class="text-muted" v-on:click="$router.push('workspace')">
        <b-icon icon="chevron-left"></b-icon>
        WORKSPACE
      </b-nav-item>
      <br /><br /><br />
      <b-item class="font-size-h1 font-weight-weight">Edit Workspace</b-item>
    </b-nav>

    <div class="card card-custom">
      <div class="card-body p-0 bg-light-default gutter-b">
        <!--begin: Wizard-->
        <div
          class="wizard wizard-1"
          id="kt_wizard_v1"
          data-wizard-state="step-first"
          data-wizard-clickable="true"
        >
          <!--begin:Nav-->
          <div class="wizard-nav border-bottom">
            <div class="wizard-steps p-8 p-lg-10">
              <div
                class="wizard-step"
                data-wizard-type="step"
                data-wizard-state="current"
              >
                <div class="wizard-label">
                  <i class="wizard-icon flaticon-list"></i>
                  <h3 class="wizard-title">1. Edit Your Workspace</h3>
                </div>
              </div>
            </div>
          </div>
          <!--end: Nav-->

          <!--begin: Body-->
          <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
            <div class="col-xl-12 col-xxl-7">
              <!--begin:  Form-->
              <form class="form" id="kt_form">
                <!--begin:  Step 1-->
                <div
                  class="pb-5"
                  data-wizard-type="step-content"
                  data-wizard-state="current"
                >
                  <h3 class="mb-10 font-weight-bold text-dark">
                    Edit Your Workspace Details
                  </h3>
                  <!--begin: Task Name-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Workspace Name*</label
                    >
                    <input
                      type="text"
                      v-model="Workspace.name"
                      class="form-control form-control-solid form-control-lg"
                      name="address1"
                      placeholder="Enter Name"
                    />
                    <span class="form-text text-muted"
                      >Please enter your workspace name</span
                    >
                  </div>

                  <!--begin: Task Description-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Description*</label
                    >
                    <b-form-textarea
                      id="textarea-rows"
                      v-model="Workspace.description"
                      class="form-control form-control-solid form-control-lg"
                      placeholder="Describe your workspace.."
                      rows="6"
                    >
                    </b-form-textarea>
                  </div>

                  <!--begin: Created by-->

                  <!-- <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Created By*</label
                    >
                    <input
                      v-model="workspace.createdby"
                      class="form-control form-control-solid form-control-lg"
                      rows="6"
                    
                    />
                  </div> -->

                  <!-- <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Select Company*</label
                    >
                  
                    <div>
                      <b-form-select
                        v-model="selected"
                        :select="select"
                        class="mb-3"
                        value-field="item"
                        text-field="name"
                      ></b-form-select>
                    </div>
                  </div> -->

                  <div class="d-flex justify-content-between border-top pt-8">
                    <div class="mr-2">
                      <button
                        class="btn btn-light-primary font-weight-bold text-uppercase px-6 py-2"
                        data-wizard-type="action-prev"
                        @click="onSubmit"
                      >
                        Ok
                      </button>
                    </div>
                    <div>
                      <button
                        v-on:click="$router.push('workspace')"
                        class="btn btn-success font-weight-bold text-uppercase px-6 py-2"
                        data-wizard-type="action-submit"
                      >
                        Cancel
                      </button>
                    </div>
                    <!-- <span>{{ projectManagersGeted }}</span> -->
                  </div>
                </div>

                <!--end: Wizard Actions -->
              </form>
              <!--end: Wizard Form-->
            </div>
          </div>
          <!--end: Wizard Body-->
        </div>
      </div>
      <!--end: Wizard-->
    </div>
  </div>
</template>

<style lang="scss">
@import "@/assets/sass/pages/wizard/wizard-1.scss";
</style>

<script>
import axios from "axios";
import router from "@/router.js";

import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import KTUtil from "@/assets/js/components/util";
import KTWizard from "@/assets/js/components/wizard";
import Swal from "sweetalert2";

export default {
  name: "Wizard-1",
  data() {
    return {
      myWorkspace: "",
      workspaceid: localStorage.getItem("workspaceid"),
      Workspace: {
        name: "",
        description: "",
        // status: "",
      },
      selected: "",
      options: [
        { item: "A", name: "Project Task 01" },
        { item: "B", name: "Parent SubTask 01" },
        { item: "C", name: "Parent SubTask 02" },
        { item: "D", name: "SubTask 01" },
        { item: "E", name: "SubTask 02" },
        { item: "F", name: "SubTask 03" },
        { item: "G", name: "SubTask 04" },

        // { item: { d: 1 }, name: 'Option D' }
      ],
      selection: null,
      select: null,
    };
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      { title: "Wizard" },
      { title: "Wizard-1" },
    ]);

    // Initialize form wizard
    const wizard = new KTWizard("kt_wizard_v1", {
      startStep: 1, // initial active step number
      clickableSteps: true, // allow step clicking
    });

    // Validation before going to next page
    wizard.on("beforeNext", function(/*wizardObj*/) {
      // validate the form and use below function to stop the wizard's step
      // wizardObj.stop();
    });

    // Change event
    wizard.on("change", function(/*wizardObj*/) {
      setTimeout(() => {
        KTUtil.scrollTop();
      }, 500);
    });
  },
  methods: {
    onSubmit() {
      axios({
        method: "put",
        url: `http://127.0.0.1:8000/api/workspace/${this.workspaceid}`,
        data: {
          name: this.Workspace.name,
          description: this.Workspace.description,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then(function(response) {
        if (
          response.status === 201 ||
          response.status === 204 ||
          response.status === 200
        ) {
          console.log(JSON.stringify(response.data)),
            router.replace("/workspace");
        }
      });
    },

    // onSubmit() {
    //   axios
    //     .post("http://127.0.0.1:8000/api/task", {
    //       data: {
    //         params: {
    //           name: "task 145", //this.unit.name,
    //           description: "srgdssdf", // this.unit.description,
    //           startdate: "2021-08-25 06:13:16",
    //           enddate: "2021-08-27 06:13:16",
    //           priority: "1",
    //         },
    //       },
    //       headers: {
    //         Accept: "application/json",
    //         Authorization: "Bearer " + localStorage.getItem("Token"),
    //       },
    //     })
    //     .then((response) => {
    //       this.res = response.data;
    //     });
    // },
    submit: function(e) {
      e.preventDefault();
      Swal.fire({
        title: "",
        text: "The application has been successfully submitted!",
        icon: "success",
        confirmButtonClass: "btn btn-secondary",
      });
    },
  },
  created: function() {
    axios({
      method: "get",
      url: `http://127.0.0.1:8000/api/workspace/${this.workspaceid}/edit`,
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.myWorkspace = response.data.Workspace;
    });
  },
};
</script>
