<template>
  <div class="mt-1">
    <!--YYY begin header-->
    <div>
      <b-nav class="mx-1">
        <b-item class="font-size-h1 font-weight-weight">Workspace</b-item>
      </b-nav>
    </div>
    <!-- begin add Workspace-->
    <div class="row">
      <div class="col-md-8 text-left left-0">
        <b-button
          v-b-modal.modal-center
          @click="modalShow = !modalShow"
          v-b-modal.modal-prevent-closing
          pill
          variant="primary"
          class="col-xl-3 py-1 mx-0 mt-10 font-size-h5"
          >+ Add Your workspace</b-button
        >
        <b-modal
          v-model="modalShow"
          id="modal-prevent-closing"
          ref="modal"
          centered
          title="Add Workspace"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          hide-footer="true"
        >
          <form ref="form" @submit.stop.prevent="handleSubmit">
            <h4 class="mb-10 font-weight-bold text-dark">
              Enter your Workspace Details
            </h4>
            <!--YYYYYYYYYYYY Workspace name-->
            <b-form-group
              label="Workspace Name*"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-input
                id="name-input"
                v-model="workspace.name"
                :state="nameState"
                placeholder="Enter Name"
                class="form-control form-control-solid form-control-lg"
                required
              ></b-form-input>
            </b-form-group>
            <!--YYYYYYYYYYYY Workspace description-->

            <b-form-group
              label="Description"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-textarea
                id="textarea-rows"
                v-model="workspace.description"
                :state="nameState"
                placeholder="Describe Your Workspace..."
                class="form-control form-control-solid form-control-lg"
                rows="6"
                required
              ></b-form-textarea>
            </b-form-group>

            <!--YYYYYYYYYYYY select workspace manager-->
            <!-- <b-form-group
              label="Select Project Manager"
              class="font-weight-bold text-dark"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-select
                v-model="workspace.managerid"
                v-bind="managerid"
                :select="select"
                class="mb-3"
                value-field="item"
                text-field="name"
                :state="nameState"
                required
              >
                <b-form-select-option
                  v-for="projManGet in projectManagersGeted"
                  :key="projManGet.id"
                  :value="projManGet.id"
                  @click="chooseType(op.type)"
                  >{{ projManGet.Manager }}</b-form-select-option
                >
              </b-form-select>
            </b-form-group> -->
            <!--YYYYYYYYYYYY Department Level-->

            <!-- <b-form-group
              label="Department Level"
              class="font-weight-bold text-dark"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-select
                v-model="workspace.managerid"
                v-bind="managerid"
                :select="select"
                class="mb-3"
                value-field="item"
                text-field="name"
                :state="nameState"
                required
              >
                <b-form-select-option
                  v-for="department in departmentsGeted"
                  :key="department.id"
                  :value="department.id"
                  :state="getUnit(department.id)"
                  >{{ department.name }}</b-form-select-option
                >
              </b-form-select>
            </b-form-group> -->
            <!-- <b-form-group
              label="Select Department"
              class="font-weight-bold text-dark"
              label-for="name-input"
              invalid-feedback="Name is required"
              :state="nameState"
            >
              <b-form-select v-model="selected">
                <b-form-select-option
                  v-model="getUnit"
                  v-for="department in departmentsGeted"
                  :key="department.id"
                  :value="department.id"
                  @mouseenter="getUnit()"
                >
                  {{ department.name }}</b-form-select-option
                >
                ></b-form-select
              >
            </b-form-group> -->

            <!--YYYYYYYYYYYY Unit level-->
            <!-- <div>
              <b-form-group
                label="Select Unit:"
                class="font-weight-bold text-dark"
                label-for="name-input"
                invalid-feedback="Name is required"
                :state="nameState"
              >
                <b-form-select v-model="selected"></b-form-select>
              </b-form-group>
            </div> -->

            <!--YYYYYYYYYYYY Section level-->
            <!-- <div>
              <b-form-group
                label="Select Section:"
                class="font-weight-bold text-dark"
                label-for="name-input"
                invalid-feedback="Name is required"
                :state="nameState"
              >
                <b-form-select v-model="selected"></b-form-select>
              </b-form-group>
            </div> -->

            <!-- <span>{{projectManagersGeted}}</span> -->
            <!-- <button @click-="getUnit"></button> -->
            <!--YYYYYYYYYYYY Workspace buttons-->

            <div class="d-flex justify-content-between border-top pt-8">
              <div class="mr-2">
                <button
                  @click="onSubmitAddWorkspace"
                  class="btn btn-light-primary font-weight-bold text-uppercase px-6 py-2"
                  data-wizard-type="action-prev"
                >
                  Create Workspace
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
          </form>
        </b-modal>
      </div>
    </div>
    <!--YYYYYYYYYYYY Workspace wizard people-->
    <people></people>

    <div class="mt-10 mb-4"></div>
    <!--YYYYYYYYYYYYY begin card 1-->
    <div class="col-md-7">
      <b-card-group deck>
        <!-- <a
          href="#tab_forms"
        > -->
        <!-- </a> -->

        <!--YYYYYYYYYYY begin card 2-->
        <!-- <a
          href="#tab_forms"
        > -->
        <b-card
          bg-variant="light"
          header-tag="header"
          footer-tag="footer"
          style="max-width: 25rem;"
          v-for="workspace in workspacesGeted"
          :key="workspace.id"
          :value="workspace.name"
        >
          <template #header>
            <div class="mt-0 ma-4" style="height: 36px">
              <h6 class="mb-0">{{ workspace.name }}</h6>
            </div>
            <td class="text-right pr-0">
              <a
                href="#"
                v-on:click="showProjects(workspace.id)"
                class="btn btn-icon btn-light btn-sm"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/General/Settings-1.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
              <a
                href="#"
                v-on:click="editWorkspace(workspace.id)"
                class="btn btn-icon btn-light btn-sm mx-3"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/Communication/Write.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
              <a
                href="#"
                class="btn btn-icon btn-light btn-sm"
                v-on:click="deleteWorkspace(workspace.id)"
              >
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon-->
                  <inline-svg
                    src="media/svg/icons/General/Trash.svg"
                  ></inline-svg>
                  <!--end::Svg Icon-->
                </span>
              </a>
            </td>
          </template>
          <b-card-text
            ><strong>Manager: {{ workspace.ManagerName }}</strong>
          </b-card-text>
          <b-card-text>{{ workspace.description }}</b-card-text>
          <!-- <template #footer>
            <b-button
              class="btn btn-light-primary font-weight-bold px-4 py-4"
              href="#"
              variant="primary"
              v-on:click="$router.push('projects')"
              >Show Project</b-button
            >
          </template> -->
        </b-card>
        <!-- </a> -->
      </b-card-group>
      <!-- <span>{{workspacesGeted}}</span> -->
    </div>
  </div>
</template>

<script>
import router from "@/router.js";
import People from "./People.vue";
import axios from "axios";
// import Button from './vue-bootstrap/Button.vue';
// import router from "@/router.js";
export default {
  components: { People },
  data() {
    return {
      projectManagersGeted: null,
      workspacesGeted: null,
      unitsGeted: null,
      workspace: {
        modalShow: false,
        name: "",
        description: "",
        managerid: "",
        nameState: null,
      },
      value: null,
      options: [
        { text: "Department Level", value: "second" },
        { text: "Unit Level", value: "third" },
        { text: "Section Level", value: "fourth" },
      ],
      show: true,
    };
  },
  computed: {
    state() {
      return Boolean(this.value);
    },
  },

  methods: {
    showProjects(workspaceid){
     axios({
        method: "get",
        url: `http://127.0.0.1:8000/api/workspace/${workspaceid}`,
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
         if (
          response.status === 201 ||
          response.status === 204 ||
          response.status === 200
        ) {
          localStorage.setItem("workspaceid", workspaceid);
          console.log(JSON.stringify(response.data)),
            router.replace("/projects");
        }
      }) 
    },
    deleteWorkspace(workspaceid){
      axios({
        method: "delete",
        url: `http://127.0.0.1:8000/api/workspace/${workspaceid}`,
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      })
    },

    editWorkspace(id) {
      localStorage.setItem("workspaceid", id);
      router.replace("/editworkspace");
    },
    // getUnit(department) {
    //   axios({
    //     method: "get",
    //     url: "http://127.0.0.1:8000/api/fetchdata",
    //     data: {
    //       // unitid: this.unitid,
    //       departmentid: department,
    //     },
    //     headers: {
    //       Accept: "application/json",
    //       Authorization: "Bearer " + localStorage.getItem("Token"),
    //     },
    //   }).then((response) => {
    //     // this.unitid = null;
    //     this.departmentid = null;
    //     this.unitsGeted = response.data.units;
    //   });
    // },
    chooseManager(managerType) {
      this.workspace.managerid = managerType;
    },
    onSubmitAddWorkspace() {
      axios({
        method: "post",
        url: "http://127.0.0.1:8000/api/workspace",
        data: {
          name: this.workspace.name,
          description: this.workspace.description,
          // managerid: this.workspace.managerid,
        },
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("Token"),
        },
      }).then((response) => {
        if (response.status == 201) {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-prevent-closing");
          });
          // console.log(JSON.stringify(response.data)),
          //   router.replace("/workspace");
        }
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      this.name = "";
      this.nameState = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }
      // Push the name to submitted names
      this.submittedNames.push(this.name);
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
  },
  created: function() {
    axios({
      method: "get",
      url: "http://127.0.0.1:8000/api/workspace",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("Token"),
      },
    }).then((response) => {
      this.workspacesGeted = response.data;
    });

    // axios({
    //   method: "get",
    //   url: "http://127.0.0.1:8000/api/workspace/create",
    //   headers: {
    //     Accept: "application/json",
    //     Authorization: "Bearer " + localStorage.getItem("Token"),
    //   },
    // }).then((response) => {
    //   this.projectManagersGeted = response.data.user;
    //   this.departmentsGeted = response.data.departments;
    // });
  },
};
</script>
