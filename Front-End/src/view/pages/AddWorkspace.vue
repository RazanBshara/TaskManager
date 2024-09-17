<template>
  <div>
    <div>
      <b-nav class="mx-1">
        <b-nav-item class="text-muted" v-on:click="$router.push('workspace')">
          <b-icon icon="chevron-left"></b-icon>
          WORKSPACES
        </b-nav-item>
        <br /><br /><br />
        <b-item class="font-size-h1 font-weight-weight">New Workspace</b-item>
      </b-nav>
    </div>
    <div class="card card-custom">
      <div class="card-body p-0">
        <!--begin: Wizard-->
        <div
          class="wizard wizard-2"
          id="kt_wizard_v2"
          data-wizard-state="step-first"
          data-wizard-clickable="true"
        ></div>
      </div>

      <!--begin: Wizard Body -->
      <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
        <!--begin: Wizard Form-->
        <div class="row">
          <div class="offset-xxl-2 col-xxl-8">
            <form class="form" id="kt_form">
              <!--begin: Wizard Step 1-->
              <div
                class="pb-5"
                data-wizard-type="step-content"
                data-wizard-state="current"
              >
                <h4 class="mb-10 font-weight-bold text-dark">
                  Enter your Project Details
                </h4>
                <!--YYYYYYYYYYYY projects name-->
                <div class="form-group">
                  <label>Workspace Name*</label>
                  <input
                    type="text"
                    v-model="workspace.name"
                    class="form-control form-control-solid form-control-lg"
                    name="fname"
                    placeholder="Enter Name"
                  />
                </div>
                <!--YYYYYYYYYYYY projects description-->
                <div class="form-group">
                  <label>Description</label>
                  <b-form-textarea
                    id="textarea-rows"
                    v-model="workspace.description"
                    class="form-control form-control-solid form-control-lg"
                    placeholder="Describe your Project.."
                    rows="6"
                  >
                  </b-form-textarea>
                </div>
                <div class="form-group">
                  <label class="font-weight-bold text-dark"
                    >Select Project Manager</label
                  >
                  <!-- <b-nav class="mx-1 mt-2"> -->
                  <div>
                    <b-form-select
                      v-model="selected"
                      :select="select"
                      class="mb-3"
                      value-field="item"
                      text-field="name"
                    ></b-form-select>
                  </div>
                </div>

                <div>
                  <b-form-radio-group
                    v-model="value"
                    :options="options"
                    :state="state"
                    name="radio-validation"
                    plain
                    stacked
                  >
                    <b-form-invalid-feedback :state="state"
                      >Please select one</b-form-invalid-feedback
                    >
                    <b-form-valid-feedback :state="state"
                      >Thank you</b-form-valid-feedback
                    >
                  </b-form-radio-group>
                </div>
              </div>
              <div class="d-flex justify-content-between border-top pt-10">
                <div class="mr-2">
                  <button
                    @click="onSubmit"
                    class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4"
                    data-wizard-type="action-prev"
                  >
                    Create Workspace
                  </button>
                </div>
                <div>
                  <button
                    v-on:click="$router.push('workspace')"
                    class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                    data-wizard-type="action-submit"
                  >
                    Cancel
                  </button>
                </div>
              </div>
              <!--end: Wizard Actions -->
            </form>
          </div>
          <!--end: Wizard-->
        </div>
      </div>
      <!--end: Wizard Body -->
    </div>
  </div>
  <!--end: Wizard-->
  <!--/div>
  </div-->
</template>

<style lang="scss">
@import "@/assets/sass/pages/wizard/wizard-2.scss";
</style>

<script>
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import KTUtil from "@/assets/js/components/util";
import KTWizard from "@/assets/js/components/wizard";
import Swal from "sweetalert2";
import axios from "axios";
import router from "@/router.js";

export default {
  name: "Wizard-2",
  data() {
    return {
      workspace: {
        name: "",
        description: "",
      },
      value: null,
      options: [
        { text: "First radio", value: "first" },
        { text: "Second radio", value: "second" },
        { text: "Third radio", value: "third" },
      ],
      // Must be an array reference!
      //   select: [
      //     { text: "InProgress", value: "no label" },
      //     { text: "InProgress", value: "inprogress" },
      //     { text: "Canceled", value: "canceled" },
      //     { text: "New", value: "new" },
      //     { text: "Paused", value: "paused" },
      //   ],
      //   show: true,
    };
  },
  computed: {
    state() {
      return Boolean(this.value);
    },
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      { title: "Wizard", route: "wizard-1" },
      { title: "Wizard-2" },
    ]);

    // Initialize form wizard
    const wizard = new KTWizard("kt_wizard_v2", {
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
    submit: function(e) {
      e.preventDefault();
      Swal.fire({
        title: "",
        text: "Your Project has been successfully Created!",
        icon: "success",
        confirmButtonClass: "btn btn-secondary",
      });
    },
    onSubmit() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/project",
        data: {
          name: this.names,
          description: this.description,
        },
        headers: {
          Accept: "application/json",
        },
      }).then(function(response) {
        console.log(JSON.stringify(response.data)), router.replace("/projects");
      });
    },
  },
};
</script>
