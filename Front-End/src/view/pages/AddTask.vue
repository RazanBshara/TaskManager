<template>
  <div>
    <b-nav class="mx-1">
      <b-nav-item class="text-muted" v-on:click="$router.push('tasks')">
        <b-icon icon="chevron-left"></b-icon>
        TASKS
      </b-nav-item>
      <br /><br /><br />
      <b-item class="font-size-h1 font-weight-weight">New Task</b-item>
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
                  <h3 class="wizard-title">1. Enter Details</h3>
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
                    Setup Your Task Details
                  </h3>
                  <!--begin: Task Name-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark">Task Name*</label>
                    <input
                      type="text"
                      v-model="task.name"
                      class="form-control form-control-solid form-control-lg"
                      name="address1"
                      placeholder="Enter Name"
                    />
                    <span class="form-text text-muted"
                      >Please enter your task name</span
                    >
                  </div>

                  <!--begin: Task Description-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Description</label
                    >
                    <b-form-textarea
                      id="textarea-rows"
                      v-model="task.description"
                      class="form-control form-control-solid form-control-lg"
                      placeholder="Describe your Task.."
                      rows="6"
                    >
                    </b-form-textarea>
                  </div>

                  <!--begin: Parent Task-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Parent Task</label
                    >
                    <!-- <b-nav class="mx-1 mt-2"> -->
                    <div>
                      <b-form-select
                        v-model="selected"
                        :options="options"
                        class="mb-3"
                        value-field="item"
                        text-field="name"
                      ></b-form-select>
                    </div>
                    <!-- <b-dropdown
                        split
                        v-model="task.parenttask"
                        split-variant="outline-primary"
                        variant="primary"
                        text="Choose the parent task..."
                        class="mr-5 pr-5 col-xl-5"
                      >
                        <b-dropdown-item href="#"
                          >Project Task 01</b-dropdown-item
                        >
                        <b-dropdown-item href="#"
                          >Parent SubTask 01</b-dropdown-item
                        >
                        <b-dropdown-item href="#"
                          >Parent SubTask 02</b-dropdown-item
                        >
                        <b-dropdown-item href="#">SubTask 01</b-dropdown-item>
                        <b-dropdown-item href="#">SubTask 02</b-dropdown-item>
                        <b-dropdown-item href="#">SubTask 03</b-dropdown-item>

                        <b-dropdown-item href="#">SubTask 04</b-dropdown-item>
                      </b-dropdown> -->
                    <!-- </b-nav> -->
                  </div>

                  <!--begin: DependOn Task -->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Depend On Task</label
                    >
                    <div>
                      <b-form-select v-model="selection" class="mb-3">
                        <b-form-select-option :value="null"
                          >Parent SubTask 01</b-form-select-option
                        >
                        <b-form-select-option value="a"
                          >Parent SubTask 02</b-form-select-option
                        >
                        <b-form-select-option value="b"
                          >Parent SubTask 03</b-form-select-option
                        >
                        <b-form-select-option value="c"
                          >SubTask 01</b-form-select-option
                        >
                        <b-form-select-option value="d"
                          >SubTask 02</b-form-select-option
                        >
                        <b-form-select-option value="e"
                          >SubTask 03</b-form-select-option
                        >
                      </b-form-select>
                    </div>
                  </div>
                  <!--begin:Type of project-->

                  <div class="form-group">
                    <label class="font-weight-bold text-dark"
                      >Type of Project</label
                    >
                    <div>
                      <b-form-select v-model="select" class="mb-3">
                        <b-form-select-option :value="null"
                          >Custom</b-form-select-option
                        >
                        <b-form-select-option value="a"
                          >Project</b-form-select-option
                        >
                      </b-form-select>
                    </div>
                  </div>
                  <!--begin: Start Date-->

                  <div class="row">
                    <div class="col-xl-6">
                      <div class="form-group">
                        <label class="font-weight-bold text-dark"
                          >Start Date</label
                        >
                        <b-form-datepicker
                          id="example-datepicker"
                          v-model="task.startdate"
                          class="mb-2"
                        ></b-form-datepicker>
                      </div>
                    </div>

                    <!--begin: End Date-->

                    <div class="col-xl-6">
                      <div class="form-group">
                        <label class="font-weight-bold text-dark"
                          >End Date</label
                        >
                        <b-form-datepicker
                          id="example-datepicker"
                          v-model="task.enddate"
                          class="mb-2"
                        ></b-form-datepicker>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <!-- <div class="col-xl-12">
                      <div class="form-group">
                        <label class="font-weight-bold text-dark">Status</label>
                        <input
                          type="text"
                          class="form-control form-control-solid form-control-lg"
                          v-model="task.status"
                          name="state"
                          placeholder=""
                        />
                        <span class="form-text text-muted"
                          >Please enter your Task Status.</span
                        >
                      </div>
                    </div> -->
                    <div
                      class="d-flex justify-content-between border-top pt-10"
                    >
                      <div class="mr-2">
                        <button
                          v-on:click="onSubmit"
                          class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                          data-wizard-type="action-prev"
                        >
                          Create Task
                        </button>
                      </div>
                      <div>
                        <button
                          v-on:click="$router.push('tasks')"
                          class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                          data-wizard-type="action-submit"
                        >
                          Cancel
                        </button>
                      </div>
                      <!-- <span>{{ task }}</span> -->
                    </div>
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
      task: {
        name: "",
        description: "",
        parenttask: "",
        dependontask: "",
        typeofproject: "",
        startdate: "",
        enddate: "",
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
        method: "post",
        url: "http://127.0.0.1:8000/api/task",
        data: {
          name: this.task.name,
          description: this.task.description,
          startdate: this.task.startdate,
          enddate: this.task.enddate,
          priority: "2",
          dependontask: this.task.dependontask,
          uppertask: this.task.uppertask,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then(function(response) {
        console.log(JSON.stringify(response.data)), router.replace("/task");
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
};
</script>
